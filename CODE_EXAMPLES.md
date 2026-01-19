# Advanced CRUD - Code Examples & Queries

## Search & Filter - Example Queries

### Search Only
```php
// Controller
$books = Book::with('category')
    ->where('title', 'like', '%Python%')
    ->orWhere('author', 'like', '%Python%')
    ->latest()
    ->paginate(15);
```

### Category Filter Only
```php
// Controller
$books = Book::with('category')
    ->where('category_id', 1)
    ->latest()
    ->paginate(15);
```

### Combined Search + Filter
```php
// Controller
$books = Book::with('category')
    ->where(function ($q) {
        $q->where('title', 'like', '%PHP%')
          ->orWhere('author', 'like', '%PHP%');
    })
    ->where('category_id', 2)
    ->latest()
    ->paginate(15);
```

## File Upload Examples

### Store Photo
```php
if ($request->hasFile('photo')) {
    $file = $request->file('photo');
    $filename = time() . '_' . uniqid() . '.' . $file->getClientOriginalExtension();
    $file->storeAs('items', $filename, 'public');
    $validated['photo'] = $filename;
}
```

### Display Photo
```blade
@if($book->photo)
    <img src="{{ $book->getPhotoPath() }}" alt="{{ $book->title }}" class="h-10 w-10 rounded-full object-cover">
@else
    <div class="flex h-10 w-10 items-center justify-center rounded-full bg-blue-600 text-xs font-bold text-white">
        {{ $book->getInitials() }}
    </div>
@endif
```

### Delete Photo
```php
if ($book->photo) {
    Storage::disk('public')->delete('items/' . $book->photo);
}
```

## Soft Delete & Trash Examples

### Soft Delete (Regular Delete)
```php
public function destroy(Book $book)
{
    $book->delete(); // Soft delete - sets deleted_at timestamp
    return redirect()->back()->with('success', 'Book moved to trash.');
}
```

### Get Only Soft-Deleted Items
```php
// Get trashed books
$trashedBooks = Book::onlyTrashed()
    ->with('category')
    ->latest('deleted_at')
    ->get();

// Count trashed
$trashedCount = Book::onlyTrashed()->count();
```

### Restore from Trash
```php
public function restore(Book $book)
{
    $book->restore();
    return redirect()->back()->with('success', 'Book restored successfully.');
}
```

### Permanent Delete
```php
public function forceDelete(Book $book)
{
    // Delete photo first
    if ($book->photo) {
        Storage::disk('public')->delete('items/' . $book->photo);
    }
    
    $book->forceDelete(); // Permanently deletes from database
    return redirect()->back()->with('success', 'Book permanently deleted.');
}
```

### Get All Books (Excluding Soft-Deleted)
```php
$books = Book::with('category')
    ->latest()
    ->get(); // Automatically excludes soft-deleted
```

### Force Include Soft-Deleted
```php
$allBooks = Book::withTrashed()
    ->with('category')
    ->latest()
    ->get();
```

## PDF Export Examples

### Basic Export
```php
public function exportPdf(Request $request)
{
    $books = Book::with('category')
        ->latest()
        ->get();
    
    $filename = 'Books_Export_' . now()->format('Y-m-d_H-i-s') . '.pdf';
    
    return PDF::loadView('books.pdf', compact('books'))
        ->download($filename);
}
```

### Export with Filters
```php
public function exportPdf(Request $request)
{
    $query = Book::with('category');
    
    if ($request->filled('search')) {
        $search = $request->input('search');
        $query->where(function ($q) use ($search) {
            $q->where('title', 'like', "%{$search}%")
              ->orWhere('author', 'like', "%{$search}%");
        });
    }
    
    if ($request->filled('category')) {
        $query->where('category_id', $request->input('category'));
    }
    
    $books = $query->latest()->get();
    $filename = 'Books_Export_' . now()->format('Y-m-d_H-i-s') . '.pdf';
    
    return PDF::loadView('books.pdf', compact('books'))
        ->download($filename);
}
```

### Generate Button
```blade
<a href="{{ route('books.export-pdf', ['search' => request('search'), 'category' => request('category')]) }}" class="rounded-lg bg-green-600 px-4 py-2 text-sm font-medium text-white transition-colors hover:bg-green-700">
    📥 Export to PDF
</a>
```

## Blade Template Examples

### Search & Filter Form
```blade
<form action="{{ route('dashboard') }}" method="GET" class="grid gap-3 md:grid-cols-3">
    <div>
        <label class="mb-2 block text-sm font-medium text-neutral-700">Search by Title or Author</label>
        <input type="text" name="search" value="{{ request('search') }}" placeholder="Search books..." class="w-full rounded-lg border...">
    </div>

    <div>
        <label class="mb-2 block text-sm font-medium text-neutral-700">Filter by Category</label>
        <select name="category" class="w-full rounded-lg border...">
            <option value="">All Categories</option>
            @foreach($categories as $category)
                <option value="{{ $category->id }}" {{ request('category') == $category->id ? 'selected' : '' }}>
                    {{ $category->name }}
                </option>
            @endforeach
        </select>
    </div>

    <div class="flex items-end gap-2">
        <button type="submit" class="flex-1 rounded-lg bg-blue-600 px-4 py-2 text-sm font-medium text-white">
            Search
        </button>
        <a href="{{ route('dashboard') }}" class="flex-1 rounded-lg border border-neutral-300 px-4 py-2 text-center text-sm font-medium">
            Clear
        </a>
    </div>
</form>
```

### Photo Upload
```blade
<div>
    <label class="mb-2 block text-sm font-medium text-neutral-700">Photo (Optional)</label>
    <input type="file" name="photo" accept="image/jpg,image/png" class="w-full rounded-lg border...">
    <p class="mt-1 text-xs text-neutral-500">JPG or PNG, max 2MB</p>
</div>
```

### Trash Link in Sidebar
```blade
<a href="{{ route('books.trash') }}" class="rounded-lg bg-red-600 px-4 py-2 text-sm font-medium text-white">
    🗑️ Trash ({{ \App\Models\Book::onlyTrashed()->count() }})
</a>
```

### Delete Confirmation
```blade
<form action="{{ route('books.destroy', $book) }}" method="POST" class="inline" onsubmit="return confirm('Move this book to trash?')">
    @csrf
    @method('DELETE')
    <button type="submit" class="text-red-600 transition-colors hover:text-red-700">Delete</button>
</form>
```

### Restore Button
```blade
<form action="{{ route('books.restore', $book) }}" method="POST" class="inline">
    @csrf
    <button type="submit" class="text-green-600 transition-colors hover:text-green-700" onclick="return confirm('Restore this book?')">
        Restore
    </button>
</form>
```

## SQL & Migrations

### Migration Code
```php
// Add photo column
Schema::table('books', function (Blueprint $table) {
    $table->string('photo')->nullable()->after('isbn');
});

// Add soft deletes
Schema::table('books', function (Blueprint $table) {
    $table->softDeletes();
});
```

### Check Table Structure
```sql
DESCRIBE books;
```

### SQL Queries

```sql
-- Get all non-deleted books
SELECT * FROM books WHERE deleted_at IS NULL;

-- Get all trashed books
SELECT * FROM books WHERE deleted_at IS NOT NULL;

-- Get books with photos
SELECT * FROM books WHERE photo IS NOT NULL;

-- Search by title
SELECT * FROM books 
WHERE deleted_at IS NULL 
AND title LIKE '%Laravel%';

-- Filter by category
SELECT * FROM books 
WHERE deleted_at IS NULL 
AND category_id = 1;

-- Combined search + filter
SELECT * FROM books 
WHERE deleted_at IS NULL 
AND (title LIKE '%Laravel%' OR author LIKE '%Laravel%')
AND category_id = 1;

-- Count books by category
SELECT category_id, COUNT(*) as count 
FROM books 
WHERE deleted_at IS NULL 
GROUP BY category_id;

-- Count trashed books
SELECT COUNT(*) FROM books WHERE deleted_at IS NOT NULL;
```

## Validation Rules

### File Upload
```php
'photo' => 'nullable|image|mimes:jpg,png|max:2048'

// Breakdown:
// nullable - can be empty
// image - must be image
// mimes:jpg,png - only JPG or PNG
// max:2048 - max 2MB (2048 KB)
```

### Search Input
```php
// Can accept any string
'search' => 'nullable|string'
```

### Category Filter
```php
// Must exist in categories table
'category' => 'nullable|exists:categories,id'
```

## Frontend JavaScript

### Edit Modal
```javascript
function editBook(id, title, author, isbn, category_id) {
    document.getElementById('editBookModal').classList.remove('hidden');
    document.getElementById('editBookModal').classList.add('flex');
    document.getElementById('editBookForm').action = `/books/${id}`;
    document.getElementById('edit_title').value = title;
    document.getElementById('edit_author').value = author;
    document.getElementById('edit_isbn').value = isbn;
    document.getElementById('edit_category_id').value = category_id || '';
}

function closeEditBookModal() {
    document.getElementById('editBookModal').classList.add('hidden');
    document.getElementById('editBookModal').classList.remove('flex');
}
```

### Delete Confirmation
```javascript
// Using browser confirm() for simplicity
onsubmit="return confirm('Move this book to trash?')"
```

## Tailwind CSS Classes Used

### Buttons
- `rounded-lg` - Rounded corners
- `bg-blue-600` - Blue background
- `hover:bg-blue-700` - Darker on hover
- `px-4 py-2` - Padding
- `text-white` - White text
- `transition-colors` - Smooth color transition

### Forms
- `border-neutral-300` - Gray border
- `rounded-lg` - Rounded input
- `focus:border-blue-500` - Blue border on focus
- `focus:ring-2` - Focus ring
- `dark:` prefix - Dark mode styles

### Tables
- `divide-y` - Row dividers
- `hover:bg-neutral-50` - Hover effect
- `px-4 py-3` - Cell padding

### Responsive
- `md:grid-cols-2` - 2 columns on medium screens
- `md:grid-cols-3` - 3 columns on medium screens
- `overflow-x-auto` - Horizontal scroll on mobile

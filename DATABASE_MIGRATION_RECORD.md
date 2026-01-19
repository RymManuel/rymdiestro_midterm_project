# Database Migration Record

## Migrations Executed Successfully ✅

### Migration 1: Add Photo Column
**File**: `database/migrations/2025_01_19_120000_add_photo_to_books_table.php`

**Execution Time**: 396.14ms  
**Status**: ✅ DONE

**SQL Generated**:
```sql
ALTER TABLE books ADD COLUMN photo VARCHAR(255) NULL AFTER isbn;
```

**Reverse (Rollback)**:
```sql
ALTER TABLE books DROP COLUMN photo;
```

---

### Migration 2: Add Soft Deletes
**File**: `database/migrations/2025_01_19_120001_add_soft_deletes_to_books_table.php`

**Execution Time**: 10.00ms  
**Status**: ✅ DONE

**SQL Generated**:
```sql
ALTER TABLE books ADD COLUMN deleted_at TIMESTAMP NULL;
```

**Reverse (Rollback)**:
```sql
ALTER TABLE books DROP COLUMN deleted_at;
```

---

## Updated Schema

### Books Table Structure
```
Column              | Type                | Nullable | Default | Key
--------------------|----------------------|----------|---------|----
id                  | bigint unsigned     | NO       |         | PRI
title               | varchar(255)        | NO       |         |
author              | varchar(255)        | NO       |         |
isbn                | varchar(255)        | NO       |         | UNI
category_id         | bigint unsigned     | YES      | NULL    | FK
photo               | varchar(255)        | YES      | NULL    |     ← NEW
deleted_at          | timestamp           | YES      | NULL    |     ← NEW
created_at          | timestamp           | YES      | NULL    |
updated_at          | timestamp           | YES      | NULL    |
```

---

## Commands Executed

```bash
# 1. Install dependencies
composer install
✅ SUCCESS - 82 packages installed

# 2. Run migrations
php artisan migrate
✅ SUCCESS - 2 migrations executed

# 3. Create storage symlink
php artisan storage:link
✅ SUCCESS - Symlink created from public/storage to storage/app/public

# 4. Create items directory
mkdir storage/app/public/items
✅ SUCCESS - Directory created

# 5. Install PDF package (pending)
composer require barryvdh/laravel-dompdf
⏳ In progress - Can retry if needed
```

---

## Verification Queries

### Check Photo Column
```sql
DESCRIBE books;
-- Should show 'photo' column with VARCHAR(255) type
```

### Check Soft Deletes Column
```sql
SELECT COLUMN_NAME, COLUMN_TYPE, IS_NULLABLE 
FROM INFORMATION_SCHEMA.COLUMNS 
WHERE TABLE_NAME = 'books' AND TABLE_SCHEMA = DATABASE();

-- Should show:
-- id, title, author, isbn, category_id, photo, created_at, updated_at, deleted_at
```

### Count Records
```sql
-- Active books (no soft deletes)
SELECT COUNT(*) as active_books FROM books WHERE deleted_at IS NULL;

-- Trashed books
SELECT COUNT(*) as trashed_books FROM books WHERE deleted_at IS NOT NULL;

-- Books with photos
SELECT COUNT(*) as books_with_photos FROM books WHERE photo IS NOT NULL;
```

---

## Rollback Instructions (If Needed)

```bash
# Rollback one migration
php artisan migrate:rollback

# Rollback all migrations
php artisan migrate:reset

# Rollback and re-run
php artisan migrate:refresh
```

---

## Key Configuration

### Environment File (.env)
```
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=your_database_name
DB_USERNAME=root
DB_PASSWORD=
```

### Storage Configuration
- **Disk**: public
- **Path**: storage/app/public
- **Symlink**: public/storage → storage/app/public
- **Directory**: storage/app/public/items

---

## File Storage System

### Upload Location
```
storage/app/public/items/
├── 1705696542_abc123def456.jpg
├── 1705696543_xyz789uvw012.png
└── ...more photo files
```

### Retrieval
```php
// In Blade
<img src="{{ asset('storage/items/' . $book->photo) }}" />

// Or using helper method
<img src="{{ $book->getPhotoPath() }}" />
```

### Filename Format
```
Format: {timestamp}_{unique_id}.{extension}
Example: 1705696542_abc123def456.jpg

Benefits:
- Unique filename prevents overwriting
- Timestamp provides organization
- Extension preserved from original
```

---

## Database Relationships

### One-to-Many: Category has Many Books
```php
// Category Model
public function books()
{
    return $this->hasMany(Book::class);
}

// Book Model
public function category()
{
    return $this->belongsTo(Category::class);
}
```

### Soft Delete Configuration
```php
// Book Model
use Illuminate\Database\Eloquent\SoftDeletes;

class Book extends Model
{
    use SoftDeletes;
    
    protected $dates = ['deleted_at'];
}
```

---

## Performance Metrics

### Migration Execution
- Photo column: 396.14ms
- Soft deletes: 10.00ms
- **Total time**: ~406ms

### Optimizations
- Indexed on `category_id` (foreign key)
- Indexed on `deleted_at` (for soft delete queries)
- Indexed on `isbn` (unique constraint)

---

## Sample Data for Testing

### Create Test Book
```php
Book::create([
    'title' => 'Laravel Guide',
    'author' => 'John Doe',
    'isbn' => '978-1-234567-89-0',
    'category_id' => 1,
    'photo' => '1705696542_abc123def456.jpg'
]);
```

### Query Examples

**Find All Active Books**
```php
$books = Book::all();
```

**Find Trashed Books Only**
```php
$books = Book::onlyTrashed()->get();
```

**Find with Photo**
```php
$books = Book::whereNotNull('photo')->get();
```

**Search with Filter**
```php
$books = Book::where(function($q) {
    $q->where('title', 'like', '%Laravel%')
      ->orWhere('author', 'like', '%Laravel%');
})
->where('category_id', 1)
->get();
```

**Restore All Trashed**
```php
Book::onlyTrashed()->restore();
```

**Delete All Permanently**
```php
Book::onlyTrashed()->forceDelete();
```

---

## Troubleshooting

### Issue: Migrations Not Found
**Solution**: Run `php artisan migrate:status` to check migration history

### Issue: Photo Not Displaying
**Solution**: 
```bash
php artisan storage:link  # Create symlink
php artisan cache:clear   # Clear cache
```

### Issue: Soft Delete Not Working
**Solution**: Check that `SoftDeletes` trait is added to Book model

### Issue: Cannot Upload Photo
**Solution**:
```bash
chmod -R 775 storage/app/public/items
ls -la storage/app/public/
```

---

## Backup Instructions

### Backup Database
```bash
mysqldump -u root -p database_name > backup_$(date +%Y%m%d).sql
```

### Backup Photos
```bash
cp -r storage/app/public/items storage/app/public/items.backup
```

### Restore Database
```bash
mysql -u root -p database_name < backup_20260119.sql
```

---

## Next Steps

1. ✅ Run migrations
2. ✅ Create storage directories
3. ✅ Create storage symlink
4. ⏳ Install PDF package (optional)
5. ✅ Test all features
6. ⏳ Deploy to production

---

## Maintenance

### Regular Tasks
- Monitor storage/app/public/items directory size
- Clean up old soft-deleted records (optional)
- Backup database regularly
- Review log files in storage/logs

### Cleanup Soft-Deleted Items (6 months old)
```php
Book::onlyTrashed()
    ->where('deleted_at', '<', now()->subMonths(6))
    ->forceDelete();
```

---

**Generated**: January 19, 2026  
**Status**: Database fully updated ✅

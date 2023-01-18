<?php

namespace Modules\Categories\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use HasFactory;

    protected $table = 'categories';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'parent_id',
        'category_name'
    ];

    /**
     * Creates new category in DB.
     *
     * @param string $CategoryName
     * @param int $ParentId
     * @return Category
     */
    public static function createCategory(string $CategoryName, int $ParentId = null): Category
    {
        $category = new self();
        $category->category_name = $CategoryName;
        $category->parent_id = $ParentId;
        $category->save();

        return $category;
    }

    /**
     * Checks if current category has children.
     *
     * @param string $CategoryId
     * @return bool
     */
    public static function isHaveChildren($CategoryId): bool
    {
        return self::where('parent_id', $CategoryId)->exists();
    }
}

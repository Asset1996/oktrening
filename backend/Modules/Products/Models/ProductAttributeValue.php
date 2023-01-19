<?php

namespace Modules\Products\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductAttributeValue extends Model
{
    use HasFactory;

    protected $table = 'product_attributes_values';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'attribute_id',
        'product_slug',
        'value'
    ];

    /**
     * Creates value of product custom attribute in DB.
     *
     * @param $AttributeId
     * @param $ProductSlug
     * @param $Value
     * @return ProductAttributeValue
     */
    public static function createProductAttributeValue($AttributeId, $ProductSlug, $Value): ProductAttributeValue
    {
        $ProductAttributeValue = self::firstOrNew([
            'attribute_id' => $AttributeId,
            'product_slug' => $ProductSlug
        ]);
        $ProductAttributeValue->value = $Value;
        $ProductAttributeValue->save();

        return $ProductAttributeValue;
    }
}

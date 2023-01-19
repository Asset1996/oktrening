<?php

namespace Modules\Products\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Attribute extends Model
{
    use HasFactory;

    protected $table = 'attributes';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'attribute_name',
        'attribute_description'
    ];

    /**
     * Creates new attribute in DB.
     *
     * @param $AttributeName
     * @param $AttributeDescription
     * @return Attribute
     */
    public static function createAttribute($AttributeName, $AttributeDescription): Attribute
    {
        $Attribute = new self();
        $Attribute->attribute_name = $AttributeName;
        $Attribute->attribute_description = $AttributeDescription;
        $Attribute->save();

        return $Attribute;
    }
}

<?php

namespace Modules\Shop\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

use App\Traits\UuidTrait;

class Attribute extends Model
{
    use HasFactory, UuidTrait;

    protected $fillable = [
        'code',
        'name',
        'attribute_type',
        'validation_rules',
    ];

    protected $table = 'shop_attributes';
    
    public const ATTR_WEIGHT = 'ATTR_WEIGHT';
    public const ATTR_COLOR = 'ATTR_COLOR';
    public const ATTR_SIZE = 'ATTR_SIZE';
    public const ATTR_LENGTH = 'ATTR_LENGTH';
    public const ATTR_HEIGHT = 'ATTR_HEIGHT';
    public const ATTR_WIDTH = 'ATTR_WIDTH';

    public const ATTR_TYPE_STRING = 'string';
    public const ATTR_TYPE_TEXT = 'text';
    public const ATTR_TYPE_BOOLEAN = 'boolean';
    public const ATTR_TYPE_INTEGER = 'integer';
    public const ATTR_TYPE_FLOAT = 'float';
    public const ATTR_TYPE_SELECT = 'select';

    protected static function newFactory()
    {
        return \Modules\Shop\Database\factories\AttributeFactory::new();
    }

    public function options()
    {
        return $this->hasMany('Modules\Shop\Entities\AttributeOption', 'attribute_id');
    }

    public static function setDefaultAttributes()
    {
        foreach (self::defaultAttributes() as $code => $name) {
            $existAttribute = self::where('code', $code)->first();
            if ($existAttribute == null) {
                self::create([
                    'code' => $code,
                    'name' => $name,
                    'attribute_type' => self::defaultAttributeTypes()[$code] 
                ]);
            }
        }
    }

    public static function defaultAttributes()
    {
        return [
            self::ATTR_WEIGHT => 'Berat',
            self::ATTR_COLOR => 'Warna',
            self::ATTR_SIZE => 'Ukuran',
            self::ATTR_LENGTH => 'Panjang',
            self::ATTR_HEIGHT => 'Tinggi',
            self::ATTR_WIDTH => 'Lebar',
        ];
    }

    public static function defaultAttributeTypes()
    {
        return [
            self::ATTR_WEIGHT => self::ATTR_TYPE_INTEGER,
            self::ATTR_COLOR => self::ATTR_TYPE_SELECT,
            self::ATTR_SIZE => self::ATTR_TYPE_SELECT,
            self::ATTR_LENGTH => self::ATTR_TYPE_INTEGER,
            self::ATTR_HEIGHT => self::ATTR_TYPE_INTEGER,
            self::ATTR_WIDTH => self::ATTR_TYPE_INTEGER,
        ];
    }

    public static function attributeTypes()
    {
        return [
            self::ATTR_TYPE_STRING => 'string',
            self::ATTR_TYPE_TEXT => 'text',
            self::ATTR_TYPE_BOOLEAN => 'boolean',
            self::ATTR_TYPE_INTEGER => 'integer',
            self::ATTR_TYPE_FLOAT => 'float',
            self::ATTR_TYPE_SELECT => 'select',
        ];
    }
}

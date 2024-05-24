<?php

namespace Modules\Shop\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

use App\Traits\UuidTrait;

class Product extends Model
{
    use HasFactory, UuidTrait;

    protected $fillable = [
        'parent_id',
		'user_id',
		'sku',
		'type',
		'name',
		'slug',
		'price',
        'featured_image',
        'sale_price',
		'status',
		'stock_status',
		'manage_stock',
		'publish_date',
		'excerpt',
		'body',
		'metas',
        'weight',
    ];

    protected $table = 'shop_products';

    public const DRAFT = 'DRAFT';
	public const ACTIVE = 'ACTIVE';
	public const INACTIVE = 'INACTIVE';

    public const STATUSES = [
		self::DRAFT => 'Draft',
		self::ACTIVE => 'Active',
		self::INACTIVE => 'Inactive',
	];

    public const STATUS_IN_STOCK = 'IN_STOCK';
    public const STATUS_OUT_OF_STOCK = 'OUT_OF_STOCK';

    public const STOCK_STATUSES = [
        self::STATUS_IN_STOCK => 'In Stock',
        self::STATUS_OUT_OF_STOCK => 'Out of Stock',
    ];

	public const SIMPLE = 'SIMPLE';
	public const CONFIGURABLE = 'CONFIGURABLE';
	public const TYPES = [
		self::SIMPLE => 'Simple',
		self::CONFIGURABLE => 'Configurable',
	];
    
    protected static function newFactory()
    {
        return \Modules\Shop\Database\factories\ProductFactory::new();
    }

    public function user()
    {
        return $this->belongsTo('App\Models\User');
    }

    public function inventory()
    {
        return $this->hasOne('Modules\Shop\Entities\ProductInventory');
    }

    public function variants()
	{
		return $this->hasMany('Modules\Shop\Entities\Product', 'parent_id')->orderBy('price', 'ASC');
	}

    public function categories()
    {
        return $this->belongsToMany('Modules\Shop\Entities\Category', 'shop_categories_products', 'product_id', 'category_id'); //phpcs:ignore
    }

    public function tags()
    {
        return $this->belongsToMany('Modules\Shop\Entities\Tag', 'shop_products_tags', 'product_id', 'tag_id');
    }

    public function attributes()
	{
		return $this->hasMany(ProductAttribute::class, 'product_id');
	}

    public function images()
	{
		return $this->hasMany('Modules\Shop\Entities\ProductImage', 'product_id');
	}

    public function getPriceLabelAttribute()
    {
        return number_format($this->price);
    }

    public function getHasSalePriceAttribute()
    {
        return $this->sale_price != null;
    }

    public function getSalePriceLabelAttribute()
    {
        return number_format($this->sale_price);
    }

    public function getDiscountPercentAttribute()
    {
        $discountPercent = (($this->price - $this->sale_price) / $this->price) * 100;

        return number_format($discountPercent);
    }

    public function getStockStatusLabelAttribute()
    {
        return self::STOCK_STATUSES[$this->stock_status];
    }

    public function getStockAttribute()
    {
        if (!$this->inventory) {
            return 0;
        }

        return $this->inventory->qty;
    }
}

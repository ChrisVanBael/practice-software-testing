<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Mehradsadeghi\FilterQueryString\FilterQueryString;

/** @OA\Schema(
 *     schema="ProductRequest",
 *     type="object",
 *     title="ProductRequest",
 *     properties={
 *         @OA\Property(property="name", type="string"),
 *         @OA\Property(property="description", type="string"),
 *         @OA\Property(property="price", type="number", example=1.99),
 *         @OA\Property(property="category_id", type="integer", example=1),
 *         @OA\Property(property="brand_id", type="integer", example=1),
 *         @OA\Property(property="product_image_id", type="integer", example=1),
 *         @OA\Property(property="is_location_offer", type="integer", example=1),
 *         @OA\Property(property="is_rental", type="integer", example=0),
 *     }
 * )
 *
 * @OA\Schema(
 *     schema="ProductResponse",
 *     type="object",
 *     title="ProductResponse",
 *     properties={
 *         @OA\Property(property="id", type="integer", example=1),
 *         @OA\Property(property="name", type="string", example="new brand"),
 *         @OA\Property(property="description", type="string", example="Lorum ipsum"),
 *         @OA\Property(property="price", type="number", example=9.99),
 *         @OA\Property(property="is_location_offer", type="integer", example=1),
 *         @OA\Property(property="is_rental", type="integer", example=0),
 *         @OA\Property(property="brand", ref="#/components/schemas/BrandResponse"),
 *         @OA\Property(property="category", ref="#/components/schemas/CategoryResponse"),
 *         @OA\Property(property="product_image", ref="#/components/schemas/ImageResponse")
 *     }
 * )
 */
class Product extends BaseModel
{
    use HasFactory, FilterQueryString;

    protected $table = 'products';
    protected $fillable = ['name', 'description', 'category_id', 'brand_id', 'price', 'product_image_id', 'is_location_offer', 'is_rental'];
    protected $hidden = ['created_at', 'updated_at'];
    protected $filters = ['between', 'sort'];

    protected $casts = array(
        "price" => "double"
    );

    /**
     * Get the user's first name.
     *
     * @return Attribute
     */
    protected function price(): Attribute
    {
        return Attribute::get(
            get: fn($value) => number_format($value, 2, '.', null),
        );
    }

    public function product_image(): BelongsTo
    {
        return $this->belongsTo('App\Models\ProductImage');
    }

    public function category(): BelongsTo
    {
        return $this->belongsTo('App\Models\Category');
    }

    public function brand(): BelongsTo
    {
        return $this->belongsTo('App\Models\Brand');
    }
}

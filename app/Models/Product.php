<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * @OA\Schema(
 *      title="products",
 *      required={ "product_name"},
 *      @OA\Property(
 *          property="product_name",
 *          description="product_name",
 *          type="string",
 *          format="int32",
 *          example="Pempek Kapal Selam",
 *      ),
 *      @OA\Property(
 *          property="product_code",
 *          description="product_code",
 *          type="string",
 *          format="int32",
 *          example="PROD-1",
 *      ),
 *      @OA\Property(
 *          property="price",
 *          description="price",
 *          type="string",
 *          format="int32",
 *          example="15000",
 *      ),
 * )
 * 
 */
class Product extends Model
{
    use HasFactory;

    protected $table = 'products';
    protected $fillable = [
        'product_name',
        'product_code',
        'price',
    ];

    protected $hidden = [
        'created_at',
        'updated_at',
        'pivot'
    ];

    public $rules = [
        'product_name' => 'required|unique:products',
        'product_code' => 'required|unique:products',
    ];



    public function sales()
    {
        return $this->belongsToMany(Sales::class);
    }
}

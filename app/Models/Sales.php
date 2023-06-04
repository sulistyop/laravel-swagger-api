<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * @OA\Schema(
 *      title="Order",
 *      required={"trans_date"},
 *      @OA\Property(
 *          property="trans_date",
 *          description="trans_date",
 *          type="string",
 *          format="date"
 *      ),
 *      @OA\Property(
 *          property="product_id",
 *          description="contoh: [1,2,3]",
 *          type="array",
 *          @OA\Items(type="integer"),
 *          example="[0]"
 *      ),
 *      @OA\Property(
 *          property="sales_code",
 *          description="sales_code",
 *          type="string",
 *          example="ORDER-1"
 *      ),
 *      @OA\Property(
 *          property="buyer_name",
 *          description="buyer_name",
 *          type="string",
 *          format="string",
 *          example="fulan"
 *      ),
 *      @OA\Property(
 *          property="phone",
 *          description="phone",
 *          type="string",
 *          format="string",
 *          example="08123456789"
 *      ),
 * )
 */

class Sales extends Model
{
    use HasFactory;



    protected $fillable = [
        'sales_code',
        'trans_date',
        'buyer_name',
        'phone',
        'total_price',
    ];

    protected $hidden = [
        'created_at',
        'updated_at',
        'pivot'
    ];



    public function salesProducts()
    {
        return $this->belongsToMany(Product::class, 'sales_details', 'sales_id', 'product_id');
    }
}

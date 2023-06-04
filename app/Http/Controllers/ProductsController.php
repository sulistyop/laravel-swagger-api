<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreProductRequest;
use App\Http\Requests\UpdateProductRequest;
use App\Models\Product;
use Illuminate\Http\Request;

class ProductsController extends AppBaseController
{
    /**
     * @param Request $request
     * @return Response
     *
     * @OA\Get(
     *      path="/products",
     *      summary="Get a listing of User.",
     *      tags={"Product"},
     *      description="Get all Users",
     *      security={{"Bearer":{}}},

     *      @OA\Response(
     *          response=200,
     *          description="successful operation",
     *          @OA\Schema(
     *              type="object",
     *              @OA\Property(
     *                  property="success",
     *                  type="boolean"
     *              ),
     *              @OA\Schema(ref="#/components/responses/NewsUpdate"),
     *              @OA\Property(
     *                  property="message",
     *                  type="string"
     *              )
     *          )
     *      )
     * )
     * )
     */
    public function getProduct(Request $request)
    {
        $Product = Product::all();

        return $this->sendResponse($Product, __('messages.product.retrieve_success'));
    }


    /**
     * @param StoreProductRequest $request
     * @return Response
     *
     * @OA\Post(
     *      path="/products",
     *      summary="Store a newly created Nps in storage",
     *      tags={"Product"},
     *      description="Store Nps",

     *      security={{"Bearer":{}}},
     *      @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(ref="#/components/schemas/Product")
     *      ),
     *      @OA\Response(
     *          response=200,
     *          description="successful operation",
     *          @OA\JsonContent(),
     *          @OA\Schema(
     *              type="object",
     *              @OA\Property(
     *                  property="success",
     *                  type="boolean"
     *              ),
     *
     *              @OA\Property(
     *                  property="message",
     *                  type="string"
     *              )
     *          )
     *      )
     * )
     */
    public function store(StoreProductRequest $request)
    {
        $Product = Product::create($request->all());
        return $this->sendResponse($Product, __('messages.product.created_success'));
    }


    /**
     * @param int $id
     * @param UpdateFinanceInvoiceAPIRequest $request
     * @return Response
     *
     * @OA\Put(
     *      path="/products/{id}",
     *      summary="Update the specified Invoice in storage",
     *      tags={"Product"},
     *      description="Update Finance Invoice",

     *      security={{"Bearer":{}}},
     *      @OA\Parameter(
     *          name="id",
     *          description="id of Finance Invoice",
     *          @OA\Schema(
     *             type="integer",
     *             format="int64"
     *         ),
     *          required=true,
     *          in="path"
     *      ),
     *      @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(ref="#/components/schemas/Product")
     *      ),
     *      @OA\Response(
     *          response=200,
     *          description="successful operation",
     *          @OA\Schema(
     *              type="object",
     *              @OA\Property(
     *                  property="success",
     *                  type="boolean"
     *              ),
     *
     *              @OA\Property(
     *                  property="message",
     *                  type="string"
     *              )
     *          )
     *      )
     * )
     */
    public function update(int $id, UpdateProductRequest $request)
    {
        $input = $request->all();

        $Product = Product::where('id', $id)
            ->update($input);

        if ($Product) {
            $Product = Product::where('id', $id)->get();
        }

        return $this->sendResponse($Product, __('messages.product.update_success'));
    }



    /**
     * @param int $id
     * @return Response
     *
     * @OA\Delete(
     *      path="/products/{id}",
     *      summary="Remove the specified products from storage",
     *      tags={"Product"},
     *      description="Delete products",

     *      security={{"Bearer":{}}},
     *      @OA\Parameter(
     *          name="product_code",
     *          description="product_code of products",
     *          @OA\Schema(
     *             type="integer",
     *             format="int64"
     *         ),
     *          required=true,
     *          in="path"
     *      ),
     *      @OA\Response(
     *          response=200,
     *          description="successful operation",
     *          @OA\Schema(
     *              type="object",
     *              @OA\Property(
     *                  property="success",
     *                  type="boolean"
     *              ),
     *              @OA\Property(
     *                  property="data",
     *                  type="string"
     *              ),
     *              @OA\Property(
     *                  property="message",
     *                  type="string"
     *              )
     *          )
     *      )
     * )
     */
    public function destroy(int $id, Request $request)
    {
        $Product = Product::destroy('product_code', $id);
        return $this->sendResponse($Product, __('messages.auth.show_user_failed'));
    }
}

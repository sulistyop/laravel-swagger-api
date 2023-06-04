<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreSalesRequest;
use App\Models\Product;
use App\Models\Sales;
use App\Models\SalesDetail;
use Illuminate\Http\Request;

class SalesController extends AppBaseController
{
    /**
     * @param Request $request
     * @return Response
     * @OA\Get(
     *      path="/sales",
     *      summary="Get a listing of the Finance sales.",
     *      tags={"Sales"},
     *      description="Get all Finance sales",
     *      security={{"Bearer":{}}},
     *      @OA\Parameter(
     *          name="search",
     *          in="query",
     *          description="Search by sales code, buyer name, phone",
     *          required=false,
     *          @OA\Schema(
     *             type="string"
     *         )
     *      ),
     *      @OA\Parameter(
     *          name="start_date",
     *          in="query",
     *          description="Filter by date, starting date. YYYY-MM-DD",
     *          required=false,
     *          @OA\Schema(
     *             type="string"
     *         )
     *      ),
     *      @OA\Parameter(
     *          name="end_date",
     *          in="query",
     *          description="Filter by date, ending date. YYYY-MM-DD",
     *          required=false,
     *          @OA\Schema(
     *             type="string",
     *             format="date"
     *         )
     *      ),
     *      @OA\Parameter(
     *          name="per_page",
     *          in="query",
     *          description="Pagination per page",
     *          required=false,
     *          @OA\Schema(
     *             type="integer",
     *             format="int64",
     *          )
     *      ),
     *      @OA\Parameter(
     *          name="page",
     *          in="query",
     *          description="Which page to render, default 1",
     *          required=false,
     *          @OA\Schema(
     *             type="integer",
     *             format="int64",
     *          ),
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
     *              @OA\Schema(ref="#/components/responses/FinanceProduct"),
     *              @OA\Property(
     *                  property="message",
     *                  type="string"
     *              )
     *          )
     *      )
     * )
     */
    public function index(Request $request)
    {
        $perPage = $request->input('per_page');
        $page = $request->input('page');
        $startDate = $request->input('start_date');
        $endDate = $request->input('end_date');

        $query = Sales::query();
        // Terapkan filter jika ada
        if ($request->has('search')) {
            $search = $request->input('search');
            $query->orwhere('sales_code', 'LIKE', '%' . $search . '%')
                ->orWhere('buyer_name', 'LIKE', '%' . $search . '%')
                ->orWhere('phone', 'LIKE', '%' . $search . '%');
        }

        if ($request->has('start_date') && $request->has('end_date')) {
            $query->whereBetween('trans_date', [$startDate, $endDate]);
        }

        $response = $query->with(['salesProducts'])->paginate(
            $perPage,
            ['*'],
            null,
            $page
        );

        if (empty($response)) {
            return $this->sendError(__('messages.sales.not_found'));
        }

        return $this->sendResponse($response, __('messages.sales.retrieve_success'));
    }

    /**
     * @param $request
     * @return Response
     *
     * @OA\Post(
     *      path="/sales",
     *      summary="Store a newly created sales in storage",
     *      tags={"Sales"},
     *      description="Store sales",
     *      security={{"Bearer":{}}},
     *      @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(ref="#/components/schemas/Sales")
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
    public function store(StoreSalesRequest $request)
    {
        // simpan data sales ke model sales 
        $modelSales = new Sales();
        $sales = $modelSales::create([
            'trans_date' => $request->input('trans_date'),
            'sales_code' => $request->input('sales_code'),
            'buyer_name' => $request->input('buyer_name'),
            'phone' => $request->input('phone'),
        ]);

        // simpan data sales detail produk ke model salesDetail
        $product_id = $request->input('product_id');
        foreach ($product_id as $id) {
            SalesDetail::create(['product_id' => $id, 'sales_id' => $sales->id]);
        }

        // total price product 
        $product = Product::whereIn('id', $product_id);

        $sales['product'] = $product->get();
        $sales['total'] = $product->sum('price');

        //update total price di model sales
        $modelSales->whereId($sales->id)->update(['total_price' => $sales['total']]);

        return $this->sendResponse($sales, __('messages.sales.created_success'));
    }

    /**
     * @OA\Delete(
     *     path="/sales/{sales_code}",
     *     operationId="deleteSales",
     *     tags={"Sales"},
     *     summary="Delete a sales",
     *     description="Delete a specific sales by its ID.",
     *     security={{"Bearer":{}}},
     *      @OA\Parameter(
     *          name="sales_code",
     *          description="id of Finance Invoice",
     *          @OA\Schema(
     *             type="string",
     *            
     *         ),
     *          required=true,
     *          in="path"
     *      ),
     *     @OA\Response(
     *         response=204,
     *         description="sales deleted successfully"
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="sales not found"
     *     )
     * )
     */
    public function destroy($id)
    {
        $sales = Sales::where('sales_code', $id)->get()->first();

        if (empty($sales)) {
            return $this->sendError('Kode Penjualan tidak ditemukan !');
        }

        $idSales = $sales->id;
        $detach = Sales::findOrFail($idSales);
        // Hapus detail produk terkait
        $detach->salesProducts()->detach();
        $detach->delete();
        return $this->sendResponse([], __('messages.sales.deleted_success'));
    }
}

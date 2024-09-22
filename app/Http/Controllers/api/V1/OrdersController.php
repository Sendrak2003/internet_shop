<?php

namespace App\Http\Controllers\api\V1;

use App\Http\Controllers\Controller;
use App\Http\Resources\OrderResource;
use App\Models\Categories;
use App\Models\Orders;
use App\Models\Products;
use Carbon\Carbon;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use PHPOpenSourceSaver\JWTAuth\Facades\JWTAuth;

class OrdersController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function __construct()
    {
        $this->middleware('jwt.auth');
    }

    public function index()
    {
        $token = request()->query('token'); // Retrieve the token from the query parameter

        // Verify and decode the token using the JWTAuth facade
        $user = JWTAuth::parseToken()->authenticate();
        if($user->role_id!=1){
            $orders = Orders::where('status_id', 1)
                ->where('user_id', $user->id)
                ->get();
            foreach ($orders as $order) {
                $this->authorize('view-order', $order);
            }
            return response()->json([
               'orders' => OrderResource::collection($orders)
            ]);
        }

        $orders = Orders::where('status_id', 1)->get();
        foreach ($orders as $order) {
            $this->authorize('view-order', $order);
        }
        return response()->json([
            'orders' => OrderResource::collection($orders)
        ]);

    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $token = request()->query('token'); // Получаем токен из параметра запроса

            $validator = Validator::make($request->all(), [
                'deliveryDate' =>'after:'. Carbon::now()->format('Y-m-d'),
            ], [
               'deliveryDate.after'=>'Дата поставки должна бы больше сегоднешней даты'
            ]);
        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }
// Проверяем и декодируем токен, используя фасад JWTAuth и получаем текущего пользователя
        $user = JWTAuth::parseToken()->authenticate();
        // проверка прав на созаданме заказа
        $this->authorize('create-order', Orders::class); // Проверяем разрешение на создание заказа

        try {
            // из бвзы получаем id товара через производителя
            $prod = Products::where('brand', $request->productBrand)->first();

            if ($prod) {
                $order = new Orders();
                $order->product_id = $prod->id;
                $order->user_id = $user->id;
                $order->orderDate = date('Y-m-d');
                $order->deliveryDate = $request->input('deliveryDate');
                $order->price = $request->input('price');
                $order->quantityProduct = $request->input('quantity');
                $order->status_id = 1;
                $order->save();
                return response()->json(['order' =>  new OrderResource($order)], 200);
            } else {
                return response()->json(['error' => 'Продукт не найден'], 404);
            }


        }
        catch (Exception $e) {
            return response()->json(['error' => $e->getMessage()]);
            //dd($e->getMessage());
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {

        $token = request()->query('token');
        $validator = Validator::make(['id' => $id], [
            'id' => 'required|exists:orders,id'
        ]);

        // Проверка валидации
        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors()], 400);
        }

        $order = Orders::FindOrFail($id);
        $this->authorize('view-order', $order);
        return response()->json(new OrderResource(Orders::FindOrFail($id)));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $token = request()->query('token');
        $order = Orders::find($id);
        $this->authorize('update-order', $order);
        $order->update($request->all());
        return new OrderResource($order);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $token = request()->query('token');
        $validator = Validator::make(['id' => $id], [
            'id' => 'required|exists:orders,id'
        ]);

        // Проверка валидации
        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors()], 400);
        }

        $order = Orders::find($id);
        $this->authorize('delete-order', $order);
        return $order->delete();
    }
}

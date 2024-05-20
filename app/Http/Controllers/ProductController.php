<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\Product;

class ProductController extends Controller
{
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'product_name' => 'required|max:50',
            'product_type' => 'required|in:snack,drink,fruit,drug,groceries,cigarette,make-up',
            'product_price' => 'required|numeric',
            'expired_at' => 'required|date'
        ]);

        if ($validator->fails()) {
            return response()->json($validator->messages(), 422);
        }

        $payload = $validator->validated();

        Product::create([
            'product_name' => $payload['product_name'],
            'product_type' => $payload['product_type'],
            'product_price' => $payload['product_price'],
            'expired_at' => $payload['expired_at']
        ]);

        return response()->json([
            'msg' => 'Data produk berhasil disimpan'
        ], 201);
    }

    public function showAll()
    {
        $products = Product::all();

        return response()->json([
            'msg' => 'Data produk keseluruhan',
            'data' => $products,
        ], 200);
    }

    public function showById($id)
    {
        $product = Product::find($id);

        if ($product) {
            return response()->json([
                'msg' => 'Data produk dengan ID: '.$id,
                'data' => $product,
            ], 200);
        }

        return response()->json([
            'msg' => 'Data produk dengan ID: '.$id.' tidak ditemukan',
        ], 404);
    }

    public function showByName($product_name)
    {
        $products = Product::where('product_name', 'LIKE', '%'.$product_name.'%')->get();

        if ($products->count() > 0) {
            return response()->json([
                'msg' => 'Data produk dengan nama yang mirip: '.$product_name,
                'data' => $products,
            ], 200);
        }

        return response()->json([
            'msg' => 'Data produk dengan nama yang mirip: '.$product_name.' tidak ditemukan',
        ], 404);
    }

    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'product_name' => 'required|max:50',
            'product_type' => 'required|in:snack,drink,fruit,drug,groceries,cigarette,make-up',
            'product_price' => 'required|numeric',
            'expired_at' => 'required|date'
        ]);

        if ($validator->fails()) {
            return response()->json($validator->messages(), 422);
        }

        $product = Product::find($id);

        if (!$product) {
            return response()->json([
                'msg' => 'Produk dengan ID: '.$id.' tidak ditemukan',
            ], 404);
        }

        $payload = $validator->validated();

        $product->update([
            'product_name' => $payload['product_name'],
            'product_type' => $payload['product_type'],
            'product_price' => $payload['product_price'],
            'expired_at' => $payload['expired_at']
        ]);

        return response()->json([
            'msg' => 'Data produk berhasil diperbarui',
            'data' => $product,
        ], 200);
    }

    public function delete($id)
    {
        $product = Product::find($id);

        if ($product) {
            $product->delete();

            return response()->json([
                'msg' => 'Data produk dengan ID: ' . $id . ' berhasil dihapus',
            ], 200);
        }

        return response()->json([
            'msg' => 'Data produk dengan ID: ' . $id . ' tidak ditemukan',
        ], 404);
    }
}
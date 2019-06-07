<?php
/**
 * Created by PhpStorm.
 * User: artemy
 * Date: 6/7/19
 * Time: 4:52 AM
 */

namespace App\Http\Controllers;

use App\User;
use App\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(Request $request)
    {
        $data = [];
        $data['name'] = $request->get('name') ?? '';
        $data['price'] = $request->get('price') ?? 0;
        $data['amount'] = $request->get('amount') ?? 0;
        $data['created_by'] = User::where('api_token', $request->header('x-access-token'))->first()->id;

        $product = Product::create($data);

        return response()->json([$product], 201);
    }

    /**
     * @param $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function show($id)
    {
        $product = Product::find($id) ?? 'Product Not Found';

        return response()->json([$product]);
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function showList(Request $request)
    {
        $param = [];
        $param['price'] = 0;
        $param['sign'] = '>';

        $param['page'] = $request->get('page') ?? 1;
        $param['limit'] = $request->get('limit') ?? 20;
        if ($request->get('price')) {
            $param['price'] = $request->get('price');
            $param['sign'] = '=';
        }
        $param['username'] = $request->get('username') ?? '%';


        $result = [];
        $product = Product::with('user')
            ->whereHas('user', function ($q) use ($param) {
                $q->where('username', 'like', $param['username']);
            })
            ->where('price', $param['sign'], $param['price'])
            ->take($param['limit'])
            ->get();
        foreach ($product as $item) {
            $result[] = [
                'name' => $item->name,
                'price' => $item->price,
                'amount' => $item->amount,
                'created_by' => $item->user->username,
            ];
        }

        return response()->json([$result]);
    }

    /**
     * @param Request $request
     * @param $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(Request $request, $id)
    {
        $product = Product::find($id);
        if ($product) {
            $data = [];
            $data['name'] = $request->get('name') ?? $product->name;
            $data['price'] = $request->get('price') ?? $product->price;
            $data['amount'] = $request->get('amount') ?? $product->amount;
            $data['created_by'] = $product->created_by;

            $product->update($data);

            return response()->json([$product]);
        } else {
            return response()->json('Product Not Found');
        }
    }
}
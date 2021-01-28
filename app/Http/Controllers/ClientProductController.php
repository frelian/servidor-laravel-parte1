<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
use Validator;
use App\Models\ClientProduct;
use App\Models\Product;
use Illuminate\Http\Request;

class ClientProductController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

        $validatedData = Validator::make($request->all(), [
            'client_id'  => 'required',
            'product_id' => 'required',
        ]);

        if ($validatedData->fails()) {
            return response()->json([
                'result' => false,
                'message' => $validatedData->errors(),
            ], 401);
        }

        $data = $request->all();
        $client = ClientProduct::create($data);

        return response()->json([
            'result'  => true,
            'message'  => $client
        ], 200);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\ClientProduct  $clientProduct
     * @return \Illuminate\Http\Response
     */
    public function show(ClientProduct $clientProduct)
    {
        //

    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\ClientProduct  $clientProduct
     * @return \Illuminate\Http\Response
     */
    public function edit(ClientProduct $clientProduct)
    {
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\ClientProduct  $clientProduct
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, ClientProduct $clientProduct)
    {
    }

    /**
     * @param $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy($id)
    {
        $status = DB::table('client_products')->delete($id);

        if ( $status ) {
            $data = [
                "result"  => true,
                "message" => "Asignación de producto eliminada..."
            ];

            return response()->json($data, 200);
        }

        $data = [
            "result"  => false,
            "message" => "Error al eliminar el producto del cliente..."
        ];

        return response()->json($data, 302);
    }
}

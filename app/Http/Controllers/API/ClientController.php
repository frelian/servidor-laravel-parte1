<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Client;
use App\Models\Sale;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;

class ClientController extends Controller
{
    /**
     * Metodo para consultar los clientes del usuario logueado
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $id_user = auth()->user()->id;

        $clients = DB::table('clients')
            ->where('user_id', $id_user)
            ->paginate(15);

        return response()->json([
            'success' => true,
            'message' => 'Datos consultos correctamente...',
            'id_user' => $id_user,
            'clients' => $clients,
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }


    public function clientProducts($idclient)
    {
        $client = Client::find($idclient);

        $products = DB::table('products')
            ->select('products.id as id_product', 'products.product_name', 'products.sale_price',
                'products.stock', 'products.created_at as product_created_at',
                'products.updated_at as product_updated_at', 'client_products.id as id_client_products')
            ->leftJoin('client_products', 'client_products.product_id', '=', 'products.id')
            ->where('client_products.client_id', '=', $idclient)
            ->paginate(15);

        return response()->json([
            "products" => $products,
            "client"   => $client
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    /**
     * Guardar productos del cliente
     *
     * @param Request $request
     */
    public function clientStoreProducts(Request $request)
    {

        $data = $request->all();
        $data = $data['arraydata'];
        $success = true;
        $message = "Registro de compras se realizaron correctamente";

            for($i = 0; $i < count($data); $i++){

                if ( $data[$i] == "item_idproduct_idclientproduct_qt") {

                    // Arrray
                    // 0 => item_idproduct_idclientproduct_qt
                    // 1 => idproduct
                    // 2 => idclientproduct
                    // 3 => qt

                    try {
                        $sale = new Sale();
                        $sale->quantity = $data[$i+3];
                        $sale->client_product_id = $data[$i+2];
                        $sale->user_id = Auth::user()->id;
                        $sale->save();

                    } catch (\Exception $ex) {
                        $data = $ex;
                        $success = false;
                        $message = "Error en el servidor";
                    }

                }
            }


        return response()->json([
            'success' => $success,
            'message' => $message,
        ]);
    }
}

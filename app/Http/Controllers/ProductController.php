<?php

namespace App\Http\Controllers;

use App\Models\Client;
use App\Models\ClientProduct;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {

        $query = $request->get('search-name');

        if($query){

            $products = DB::table('products')
                ->selectRaw("products.id as id_product, products.product_name, products.sale_price,
                COUNT('products.*') as client_productsCount, products.stock, products.created_at as
                product_created_at, products.updated_at as product_updated_at")
                ->leftJoin('client_products', 'client_products.product_id', '=', 'products.id')
                ->where('products.product_name', 'like', "%" . $query . "%")
                ->groupBy('products.id', 'products.product_name', 'products.sale_price', 'products.stock',
                    'products.created_at', 'products.updated_at')
                ->orderBy('client_productsCount', 'desc')
                ->paginate(15);

            $total = $products->total();

            return view('products.index',
                [
                    "products" => $products,
                    "buscado"  => $query,
                    "total"    => $total
                ]);
        }

        $products = DB::table('products')
            ->selectRaw("products.id as id_product, products.product_name, products.sale_price,
                COUNT('products.*') as client_productsCount, products.stock, products.created_at as
                product_created_at, products.updated_at as product_updated_at")
            ->leftJoin('client_products', 'client_products.product_id', '=', 'products.id')
            ->groupBy('products.id', 'products.product_name', 'products.sale_price', 'products.stock',
                'products.created_at', 'products.updated_at')
            ->orderBy('client_productsCount', 'desc')
            // ->take(5)
            ->paginate(15);
        $total = $products->total();

        return view('products.index', [
            'products' => $products,
            'buscado'  => "",
            "total"    => $total
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('products.create');
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
            'product_name' => 'required',
            'sale_price'   => 'required',
            'stock'        => 'required',
        ]);

        if ($validatedData->fails()) {
            return response()->json([
                'result' => false,
                'message' => $validatedData->errors(),
            ], 401);
        }

        $data = $request->all();
        $client = Product::create($data);

        return response()->json([
            'result'  => true,
            'product'  => $client
        ], 200);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function show(Product $product)
    {
        //
    }

    /**
     * @param $id
     */
    public function edit($id)
    {
        $product = Product::find($id);

        // Clientes que tienen el producto asignado:
        $clients = Client::select('clients.id as id_client', 'clients.ide_cli', 'clients.first_name_cli',
            'clients.sur_name_cli', 'clients.business_name_cli', 'clients.phone_cli', 'clients.specialty_cli',
            DB::raw("(
                 CASE WHEN clients.ide_type_cli = 'identification' THEN 'Identificación' ELSE
                    CASE WHEN clients.ide_type_cli = 'nit' THEN 'NIT' ELSE 'n/a' END
                 END) AS ide_type_cli"), 'client_products.id as id_client_products'
        )
            ->leftjoin('client_products', 'client_products.client_id', '=', 'clients.id')
            ->where('client_products.product_id', $id)
            ->paginate(15);

        $clients_alt = Client::select('clients.id as id_client', 'first_name_cli as name1',
            'sur_name_cli as name2', 'business_name_cli as name3', 'client_types.type_name')
            ->join('client_types', 'client_types.id', '=', 'clients.client_types_id')
            ->get();

        $freeClients = [];
        foreach ($clients_alt as $client) {
            $prod = ClientProduct::where('client_id', '=', $client->id_client)
                ->where('product_id', '=', $id)
                ->first();

            if (!$prod) {
                $freeClients[] = $client;
            }
        }

        return view('products.edit', [
            'product' => $product,
            'clients' => $clients,
            'freeClients' => $freeClients
        ]);
    }

    /**
     * @param Request $request
     * @param $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(Request $request, $id)
    {
        $data = $request->all();

        if ( !isset($data) ) {
            return response()->json([
                'result'  => false,
                'message' => "Sin datos para procesar...",
            ], 401);
        }

        $validatedData = Validator::make($request->all(), [
            'product_name' => 'required',
            'sale_price'   => 'required',
            'stock'        => 'required',
        ]);

        if ($validatedData->fails()) {
            return response()->json([
                'result' => false,
                'message' => $validatedData->errors(),
            ], 401);
        }

        $client = Product::find($id);

        if ( !$client ) {
            return response()->json([
                'result' => false,
                'message' => "No se encontro el producto...",
            ], 401);
        }

        $updated = $client->update($data);

        if ( $updated ) {
            return response()->json([
                'result'  => true,
                'message' => "Se actualizo el producto correctamente."
            ], 200);
        }

        return response()->json([
            'result'  => false,
            'message' => "Error al actualizar el producto.",
        ], 401);
    }

    /**
     *
     * @param $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy($id)
    {
        $status = DB::table('products')->delete($id);

        if ( $status ) {
            $data = [
                "result"  => true,
                "message" => "Producto eliminado..."
            ];

            return response()->json($data, 200);
        }

        $data = [
            "result"  => false,
            "message" => "Error al eliminar el producto..."
        ];

        return response()->json($data, 302);
    }
}

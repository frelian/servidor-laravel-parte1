<?php

namespace App\Http\Controllers;

use App\Models\Sale;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class SaleController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {

        $startDate = $request->get('start-date');
        $endDate   = $request->get('end-date');

        if($startDate && $endDate){



            $sales = Sale::select('users.id as id_seller', 'users.names as seller', 'sales.id as id_sale',
                'sales.quantity', 'products.sale_price', 'sales.created_at as sales_created_at',
                'clients.id as id_client', 'clients.first_name_cli',
                'clients.sur_name_cli', 'clients.business_name_cli',
                DB::raw("sales.quantity * products.sale_price as total_product_price"))
                ->join('users', 'users.id', '=', 'sales.user_id')
                ->join('client_products', 'client_products.id', '=', 'sales.client_product_id')
                ->join('clients', 'clients.id', '=', 'client_products.client_id')
                ->join('products', 'products.id', '=', 'client_products.product_id')
                ->whereBetween('sales.created_at', [$startDate, $endDate])
                ->paginate(15);

            return view('sales.index',
                [
                    'sales' => $sales,
                    'start' => $startDate,
                    'end'   => $endDate,
                ]);
        }

        $sales = Sale::select('users.id as id_seller', 'users.names as seller', 'sales.id as id_sale',
                'sales.quantity', 'products.sale_price', 'sales.created_at as sales_created_at',
                'clients.id as id_client', 'clients.first_name_cli',
                'clients.sur_name_cli', 'clients.business_name_cli',
                DB::raw("sales.quantity * products.sale_price as total_product_price"))
            ->join('users', 'users.id', '=', 'sales.user_id')
            ->join('client_products', 'client_products.id', '=', 'sales.client_product_id')
            ->join('clients', 'clients.id', '=', 'client_products.client_id')
            ->join('products', 'products.id', '=', 'client_products.product_id')
            ->paginate(15);

        return view('sales.index', [
            'sales' => $sales,
            'start' => "",
            'end'   => "",
        ]);
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
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Sale  $sale
     * @return \Illuminate\Http\Response
     */
    public function show(Sale $sale)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Sale  $sale
     * @return \Illuminate\Http\Response
     */
    public function edit(Sale $sale)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Sale  $sale
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Sale $sale)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Sale  $sale
     * @return \Illuminate\Http\Response
     */
    public function destroy(Sale $sale)
    {
        //
    }
}

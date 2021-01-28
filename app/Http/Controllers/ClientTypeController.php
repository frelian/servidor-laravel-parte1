<?php

namespace App\Http\Controllers;

use Validator;
use App\Models\ClientType;
use Illuminate\Http\Request;

class ClientTypeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $types =  ClientType::where('state', 1)->get();

        return response()->json([
            'result' => true,
            'data'   => $types,
        ], 200);
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
            'type_name' => 'required|string|min:3',
        ]);

        if ($validatedData->fails()) {
            return response()->json([
                'result' => false,
                'message' => $validatedData->errors(),
            ], 401);
        }

        $data = $request->all();
        $type = ClientType::create($data);

        return response()->json([
            'result'  => true,
            'type'    => $type
        ], 200);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\ClientType  $clientType
     * @return \Illuminate\Http\Response
     */
    public function show(ClientType $clientType)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\ClientType  $clientType
     * @return \Illuminate\Http\Response
     */
    public function edit(ClientType $clientType)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\ClientType  $clientType
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, ClientType $clientType)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\ClientType  $clientType
     * @return \Illuminate\Http\Response
     */
    public function destroy(ClientType $clientType)
    {
        //
    }
}

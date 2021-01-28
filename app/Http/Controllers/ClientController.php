<?php

namespace App\Http\Controllers;

use App\Models\Client;
use App\Models\User;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ClientController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $clients = DB::table('clients')
            ->select('clients.id as id_client', 'clients.ide_cli', 'clients.ide_type_cli as ide_type_cli2',
                'clients.first_name_cli', 'clients.sur_name_cli', 'clients.business_name_cli', 'clients.address_cli',
                'clients.phone_cli', 'clients.specialty_cli', 'clients.created_at as client_created_at',
                'clients.updated_at as client_updated_at', 'client_types.type_name',
                'users.id as id_user', 'users.names as seller',
                DB::raw("(
                 CASE WHEN clients.ide_type_cli = 'identification' THEN 'Identificación' ELSE
                    CASE WHEN clients.ide_type_cli = 'nit' THEN 'NIT' ELSE 'n/a' END
                 END) AS ide_type_cli"))
            ->join('client_types', 'client_types.id', '=', 'clients.client_types_id')
            ->leftJoin('users', 'users.id', '=', 'clients.user_id')
            ->paginate(15);

        return view('clients.index', [
            'clients' => $clients,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {

        return view('clients.create');
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
            'ide_cli'      => 'required|string|min:3',
            'ide_type_cli' => 'required|string|min:3',
            'address_cli'  => 'required|string|min:3',
            'phone_cli'    => 'required|string|min:6',
        ]);

        if ($validatedData->fails()) {
            return response()->json([
                'result' => false,
                'message' => $validatedData->errors(),
            ], 401);
        }

        $data = $request->all();
        $client = Client::create($data);

        return response()->json([
            'result'  => true,
            'client'  => $client
        ], 200);
    }

    /**
     * @param $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function show($id)
    {
        $client = Client::select('clients.id as id_client', 'clients.ide_cli', 'clients.ide_type_cli as ide_type_cli',
            'clients.first_name_cli', 'clients.sur_name_cli', 'clients.business_name_cli', 'clients.address_cli',
            'clients.phone_cli', 'clients.specialty_cli', 'clients.created_at as client_created_at',
            'clients.updated_at as client_updated_at', 'client_types.type_name',
            'clients.client_types_id as id_client_types')
            ->join('client_types', 'client_types.id', '=', 'clients.client_types_id')
            ->where('clients.id', $id)
            ->first();

        if ($client) {
            return response()->json([
                'result' => true,
                'client' => $client,
            ], 200);
        }

        return response()->json([
            'result'  => false,
            'client'  => "Error, cliente no encontrado.",
        ], 401);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {

        $client = Client::select('clients.id as id_client', 'clients.ide_cli', 'clients.ide_type_cli as ide_type_cli2',
            'clients.first_name_cli', 'clients.sur_name_cli', 'clients.business_name_cli', 'clients.address_cli',
            'clients.phone_cli', 'clients.specialty_cli', 'clients.created_at as client_created_at',
            'clients.updated_at as client_updated_at', 'client_types.type_name', 'clients.ide_type_cli')
            ->join('client_types', 'client_types.id', '=', 'clients.client_types_id')
            ->where('clients.id', $id)
            ->first();

        return view('clients.edit', ['client' => $client]);
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
            'ide_cli'      => 'required|string|min:1',
            'ide_type_cli' => 'required|string|min:1',
            'address_cli'  => 'required|string|min:3',
            'phone_cli'    => 'required|string|min:3',
        ]);

        if ($validatedData->fails()) {
            return response()->json([
                'result' => false,
                'message' => $validatedData->errors(),
            ], 401);
        }

        $client = Client::find($id);

        if ( !$client ) {
            return response()->json([
                'result' => false,
                'message' => "No se encontro el cliente...",
            ], 401);
        }

        $updated = $client->update($data);

        if ( $updated ) {
            return response()->json([
                'result'  => true,
                'message' => "Se actualizo el cliente correctamente."
            ], 200);
        }

        return response()->json([
            'result'  => false,
            'message' => "Error al actualizar el cliente.",
        ], 401);
    }

    /**
     * @param $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy($id)
    {
        $status = DB::table('clients')->delete($id);

        if ( $status ) {
            $data = [
                "result"  => true,
                "message" => "Cliente eliminado..."
            ];

            return response()->json($data, 200);
        }

        $data = [
            "result"  => false,
            "message" => "Error al eliminar el cliente..."
        ];

        return response()->json($data, 302);
    }

    public function assignClient(Request $request, $id)
    {
        $data = $request->all();

        if ( !isset($data) ) {
            return response()->json([
                'result'  => false,
                'message' => "Sin datos para procesar...",
            ], 401);
        }

        $validatedData = Validator::make($request->all(), [
            'id_client' => 'required',
            'id_user'   => 'required',
        ]);

        if ($validatedData->fails()) {
            return response()->json([
                'result' => false,
                'message' => $validatedData->errors(),
            ], 401);
        }

        $client = Client::find($id);

        if ( !$client ) {
            return response()->json([
                'result' => false,
                'message' => "No se encontro el cliente...",
            ], 401);
        }
        $client->user_id = $data['id_user'];
        $updated = $client->save();

        if ( $updated ) {
            return response()->json([
                'result'  => true,
                'message' => "Se actualizo el cliente correctamente."
            ], 200);
        }

        return response()->json([
            'result'  => false,
            'message' => "Error al actualizar el cliente.",
        ], 401);
    }

    public function assignIndex(){

        // Listado de clientes para la tabla
        $clients = Client::select('clients.id as id_client', 'clients.ide_cli', 'clients.ide_type_cli',
            'clients.first_name_cli', 'clients.sur_name_cli', 'clients.business_name_cli', 'clients.address_cli',
            'clients.phone_cli', 'clients.specialty_cli', 'clients.created_at as clients_created_at',
            'clients.updated_at as clients_updated_at', 'users.id as id_user', 'users.identification',
            'users.names', 'users.email')
            ->leftjoin('users', 'users.id', '=', 'clients.user_id')
            ->paginate(15);

        // Listado de vendedores
        $users = User::all();

        return view('asign.index', [
            'clients' => $clients,
            'users'   => $users,
        ]);
    }

    public function assignDestroy(Request $request, $id)
    {
        $data = $request->all();

        if ( !isset($data) ) {
            return response()->json([
                'result'  => false,
                'message' => "Sin datos para procesar...",
            ], 401);
        }

        $client = Client::find($id);

        if ( !$client ) {
            return response()->json([
                'result' => false,
                'message' => "No se encontro el cliente...",
            ], 401);
        }
        $client->user_id = null;
        $updated = $client->save();

        if ( $updated ) {
            return response()->json([
                'result'  => true,
                'message' => "Se actualizo el cliente correctamente."
            ], 200);
        }

        return response()->json([
            'result'  => false,
            'message' => "Error al actualizar el cliente.",
        ], 401);
    }
}

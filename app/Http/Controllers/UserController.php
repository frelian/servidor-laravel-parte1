<?php

namespace App\Http\Controllers;

use App\Models\User;
use Validator;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Redirect;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

        return view('users.index', [
            'users' => DB::table('users')->paginate(15),
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {

        return view('users.create');
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
            'identification' => 'required',
            'names'          => 'required|string|min:5',
            'address'        => 'required',
            'phone'          => 'required',
            'email'          => 'required|unique:users|string|min:5',
            'password'       => 'required|string|min:3',
        ]);

        if ($validatedData->fails()) {
            return response()->json([
                'result' => false,
                'message' => $validatedData->errors(),
            ], 401);
        }

        $input = $request->all();
        $input['password'] = Hash::make($input['password']);
        $user = User::create($input);

        return response()->json([
            'result'  => true,
            'user'    => $user
        ], 200);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $user = User::find($id);

        return view('users.edit', ['user' => $user]);
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
        $validatedData = $request->validate([
            'identification' => 'required',
            'names'          => 'required|string|min:6',
            'address'        => 'required',
            'phone'          => 'required',
            'email'          => 'required|string|min:5',
        ]);

        $data = $request->all();

        $user = User::find($id);
        $user_password = ($request->password) ? $request->password : $user->password;
        $user_password = Hash::make($user_password);

        $data['password'] = $user_password;
        $updated = $user->update($data);

        if ( $updated ) {
            return redirect('/users')->with('mensaje', 'Datos del usuario actualizados correctamente.');
        }

        return redirect('/users')->with('mensaje', 'Error al actualizar el usuario, por favor, intente de nuevo.');

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $status = DB::table('users')->delete($id);

        if ( $status ) {
            $data = [
                "result"  => true,
                "message" => "Usuario eliminado..."
            ];

            return response()->json($data, 200);
        }

        $data = [
            "result"  => false,
            "message" => "Error al eliminar el usuario..."
        ];

        return response()->json($data, 302);
    }

}

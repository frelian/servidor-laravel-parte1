@extends('layouts.app')

@section('content')

    <br>

    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">

                <div class="card card-info card-outline">
                    <div class="card-header with-border">
                        <h3 class="card-title ">Edición de Usuario</h3>
                        <div class="card-tools">
                            <a href="{{ route('users')}}" class="btn btn-block btn-outline-info btn-sm">
                                <i class="fa fa-fw fa-reply-all"></i> Volver al listado
                            </a>
                        </div>
                    </div>
                    <div class="card-body">
                        <form action="{{route('user.update', ['id' => $user->id])}}" id="form-general" class="form-horizontal" method="POST" autocomplete="off">
                            @csrf @method("post")

                            @foreach ($errors->all() as $error)
                                <p class="text-danger">{{ $error }}</p>
                            @endforeach

                            <div class="form-group row">
                                <label for="mn_name" class="col-lg-3 col-form-label requerido">Identificación</label>
                                <div class="col-lg-9">
                                    <input type="text" name="identification" id="identification" class="form-control" value="{{old('identification', $user->identification ?? '')}}" required/>
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="mn_url" class="col-lg-3 col-form-label requerido">Nombres</label>
                                <div class="col-lg-9">
                                    <input type="text" name="names" id="names" class="form-control" value="{{old('names', $user->names ?? '')}}" required/>
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="mn_icon" class="col-lg-3 col-form-label">Dirección</label>
                                <div class="col-lg-9">
                                    <input type="text" name="address" id="address" class="form-control" value="{{old('address', $user->address ?? '')}}" required/>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="mn_icon" class="col-lg-3 col-form-label">Teléfono</label>
                                <div class="col-lg-9">
                                    <input type="text" name="phone" id="phone" class="form-control" value="{{old('phone', $user->phone ?? '')}}" required/>
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="mn_icon" class="col-lg-3 col-form-label">Email</label>
                                <div class="col-lg-9">
                                    <input type="email" name="email" id="email" class="form-control" value="{{old('email', $user->email ?? '')}}" required/>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="mn_icon" class="col-lg-3 col-form-label">Contraseña</label>
                                <div class="col-lg-9">
                                    <input type="password" name="password" id="password" class="form-control" value="{{old('password')}}"/>
                                </div>
                            </div>

                            <div class="card-footer">
                                <div class="row justify-content-center">

                                    <button type="submit" class="btn btn-info">Actualizar</button>
                                    <a href="{{ route('users')}}" class="btn btn-default">
                                        Cancelar
                                    </a>

                                </div>
                            </div>

                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection

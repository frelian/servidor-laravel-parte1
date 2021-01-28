@extends('layouts.app')

@section('content')

    <div class="container">
        <br>
        <div class="row justify-content-center">
            <div class="col">
                <h4 class="text-center">Bienvenido </h4>
            </div>
        </div>
        <br>
        <div class="row justify-content-center dashboard-actions">
            <div class="col-6 col-sm-12 col-md-3">
                <a class="btn btn-lg btn-primary full-width" href="{{ route('users') }}">
                    <i class="glyphicon glyphicon-user pull-left"></i>
                    <span>
                        <h4>Vendedores</h4>
                        <small>Listado de usuarios</small>
                    </span>
                </a>
            </div>
            <div class="col-6 col-sm-12 col-md-3">
                <a class="btn btn-lg btn-outline-success full-width" href="{{ route('clients') }}">
                    <i class="glyphicon glyphicon-dashboard pull-left"></i>
                    <span>
                        <h4>Clientes</h4>
                        <small>Listado de clientes</small>
                    </span>
                </a>
            </div>
            <div class="col-6 col-sm-12 col-md-3">
                <a class="btn btn-lg btn-outline-danger full-width" href="{{ route('products') }}">
                    <i class="glyphicon glyphicon-dashboard pull-left"></i>
                    <span>
                        <h4>Productos</h4>
                        <small>Listado de productos</small>
                    </span>
                </a>
            </div>
            <div class="col-6 col-sm-12 col-md-3">
                <a class="btn btn-lg btn-outline-info full-width" href="{{ route('client-assignuser-i') }}">
                    <i class="glyphicon glyphicon-dashboard pull-left"></i>
                    <span>
                        <h4>Asignación</h4>
                        <small>Clientes</small>
                    </span>
                </a>
            </div>
        </div>
        <br>
        <div class="row justify-content-center dashboard-actions">
            <div class="col-6">
                <a class="btn btn-lg btn-outline-dark full-width" href="{{ route('sales') }}">
                    <i class="glyphicon glyphicon-dashboard pull-left"></i>
                    <span>
                        <h4>Ventas</h4>
                        <small></small>
                    </span>
                </a>
            </div>
        </div>
    </div>
@endsection

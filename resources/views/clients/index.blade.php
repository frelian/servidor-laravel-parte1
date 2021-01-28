@extends('layouts.app')

@section('content')

    <br>
    <div class="container_">
        <div class="row fix-row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">Listado de clientes</div>

                    <div class="card-body">

                        <div class="container">
                            <div class="row justify-content-lg-end user-actions">
                                <a href="{{ route('dashboard') }}" class="btn btn-link mr-2">
                                    Volver
                                </a>
                                <a href="{{ route('client-create') }}" class="btn btn-success">
                                    Crear
                                </a>
                            </div>
                        </div>

                        <table class="table table-hover">
                            <thead class="">
                            <tr>
                                <th scope="col">#</th>
                                <th scope="col">Identificación</th>
                                <th scope="col">Tipo ID</th>
                                <th scope="col">Nombres</th>
                                <th scope="col">Apellidos</th>
                                <th scope="col">Razón social</th>
                                <th scope="col">Dirección</th>
                                <th scope="col">Teléfono</th>
                                <th scope="col">Tipo</th>
                                <th scope="col">Vendedor</th>
                                <th scope="col"></th>
                            </tr>
                            </thead>
                            <tbody>
                            @if( $clients->count() > 0 )
                                @foreach($clients as $client )
                                    <tr class="item-row{{ $client->id_client }}">
                                        <th scope="row">{{ $client->id_client }}</th>
                                        <td>{{ $client->ide_cli }}</td>
                                        <td>{{ $client->ide_type_cli }}</td>
                                        <td>{{ $client->first_name_cli }}</td>
                                        <td>{{ $client->sur_name_cli }}</td>
                                        <td>{{ $client->business_name_cli }}</td>
                                        <td>{{ $client->address_cli }}</td>
                                        <td>{{ $client->phone_cli }}</td>
                                        <td>{{ $client->type_name }}</td>
                                        <td>{{ $client->seller }}</td>
                                        <td class="text-center" style="width: 20%;">
                                            <a href="{{route('client-edit', ['id' => $client->id_client])}}" class="table-link">
                                                <span class="fa-stack">
                                                    <i class="fa fa-square fa-stack-2x"></i>
                                                    <i class="fas fa-user-edit fa-stack-1x fa-inverse"></i>
                                                </span>
                                            </a>

                                            <a class="btn-client-delete" data-id="{{ $client->id_client }}" >
                                                <i class="fas fa-trash text-danger  fa-lg"></i>
                                            </a>

                                        </td>
                                    </tr>
                                @endforeach
                            @else
                                <div class="alert alert-info" role="alert">
                                    Sin clientes en el sistema...
                                </div>
                            @endif

                            </tbody>
                        </table>
                        <div class="pagination">
                            {{ $clients->links() }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        $(document).ready(function () {

            $(".btn-client-delete").click(function(){

                let id_client = $(this).data("id");
                swal({
                    title: "Eliminar el cliente ?",
                    text: "Los datos no se podrán recuperar...",
                    icon: "warning",
                    buttons: true,
                    dangerMode: true,
                })
                .then((willDelete) => {
                    if (willDelete) {
                        $.ajax("/client/destroy/"+id_client, {
                            headers: {
                                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                            },
                            data: {
                                "id": id_client
                            },
                            type: "POST",
                            async: false,
                            error: function error(data) {
                                swal("Error", "Error al eliminar el cliente", "error");
                            },
                            success: function success(data) {
                                console.log(id_client);

                                $(".item-row"+id_client).remove();
                                swal("Hecho", "El cliente fue eliminado...", "success");
                            }
                        });
                    }
                });
            });
        });
    </script>

@endsection

@extends('layouts.app')

@section('content')

    <br>
    <div class="container">
        <h3 class="text-center">Asignacion de clientes a vendedores</h3>

        <!-- Tab panes -->
        <div class="tab-content">
            <div id="home" class="container tab-pane active"><br>

                <p>Listado de clientes:</p>

                <table class="table table-hover">
                    <thead class="">
                    <tr>
                        <th scope="col">ID</th>
                        <th class="btn-outline-info" scope="col">Vendedor</th>
                        <th scope="col">Identificación</th>
                        <th scope="col">Nombres</th>
                        <th scope="col">Apellidos</th>
                        <th scope="col">Razón social</th>
                    </tr>
                    </thead>
                    <tbody>
                    @if( $clients->count() > 0 )
                        @foreach($clients as $client )
                            <tr class="item-row{{ $client->id_client }}">
                                <th scope="row">{{ $client->id_client }}</th>
                                <td class="btn-outline-info">{{ $client->names }}</td>
                                <td>{{ $client->ide_cli }}</td>
                                <td>{{ $client->first_name_cli }}</td>
                                <td>{{ $client->sur_name_cli }}</td>
                                <td>{{ $client->business_name_cli }}</td>
                                <td class="text-center" style="width: 20%;">

                                    <a data-toggle="modal"
                                        data-target="#assign-user-modal"
                                        class="btn btn-default btn-assig assign"
                                        data-name="{{ $client->first_name_cli. ' ' .$client->sur_name_cli. ' ' .$client->business_name_cli }} "
                                        data-id="{{ $client->id_client }}">
                                        <i class="fas fa-tasks"></i>Asignar
                                    </a>

                                    <a class="btn-delete-assign btn btn-outline-danger" data-id="{{ $client->id_client }}" >
                                        <i class="fas fa-trash text-bold fa-lg"></i>
                                        Vendedor
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

    <!-- Modal -->
    <div class="modal fade" id="assign-user-modal" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body" >
                    <div>
                        Cliente: <h4 id="name-client-modal"></h4><br>

                        <input type="hidden" id="id-client-hidden" class="id-client-hidden">

                        <div class="row">
                            <div class="col-lg-2">
                                <p class="vertical-center-label">Vendedor:</p>
                            </div>
                            <div class="col-lg-6">
                                <div class="form-group row">
                                    <select name="sel-users" id="sel-users" class="form-control">
                                        <option value="" disabled selected>Seleccione</option>

                                        @foreach($users as $user)
                                            <option value="{{ $user->id }}">
                                                {{ $user->names }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>

                    </div>

                    <div class="card-footer">
                        <div class="row justify-content-center">

                            <a id="btn-store-assign" class="btn btn-success">
                                Asignar
                            </a>

                            <a href="{{ route('client-assignuser-i')}}" class="btn btn-default">
                                Cancelar
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    </div>

    <script>
        $(document).ready(function () {

            $(".btn-delete-assign").click(function(){

                let id_client = $(this).data("id");

                swal({
                    title: "Quitar la asignación del vendedor ?",
                    text: "",
                    icon: "warning",
                    buttons: true,
                    dangerMode: true,
                })
                .then((willDelete) => {
                    if (willDelete) {
                        $.ajax("/client/destroy/assign/user/"+id_client, {
                            headers: {
                                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                            },
                            data: {
                                "id_client": id_client
                            },
                            type: "POST",
                            async: false,
                            error: function error(data) {
                                swal("Error", "Error al eliminar el usuario", "error");
                            },
                            success: function success(data) {
                                location.reload();
                            }
                        });
                    }
                });
            });

            $("#btn-store-assign").click(function(){

                let id_client = $('#id-client-hidden').val();
                let id_user = $('#sel-users').val();

                if (id_user) {

                    $.ajax({
                        type:"POST",
                        url:"/client/assign/user/"+id_client,
                        data: {
                            "id_client": id_client,
                            "id_user": id_user,
                            "_token": "{{ csrf_token() }}"
                        },
                        dataType : 'json',
                        success: function(data){
                            $("#assign-user-modal").modal('hide');
                            location.reload();
                        },
                        error: function(xhr,status, response ){

                            //Obtener el valor de los errores devueltos por el controlador
                            var error = jQuery.parseJSON(xhr.responseText);

                            //Obtener los mensajes de error
                            var info = error.message;

                            //Crear la lista de errores
                            var errorsHtml = '<ul>';
                            $.each(info, function (key,value) {
                                errorsHtml += '<li>' + value[0] + '</li>';
                            });
                            errorsHtml += '</ul>';

                            console.log(response);
                        }
                    });
                }
            });

            $(".assign").click(function(){
                var id_client = $(this).data( "id" );
                var name_client = $(this).data( "name" );

                if (id_client) {
                    $('#id-client-hidden').val(id_client);
                    $('#name-client-modal').text(name_client);
                }
            });

        });
    </script>

@endsection

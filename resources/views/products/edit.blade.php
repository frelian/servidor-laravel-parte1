@extends('layouts.app')

@section('content')

    <br>
    <div class="container">
        <span>

            <div class="row">
                <div class="col-lg-1">
                    <h6>Producto:</h6>
                </div>
                <div class="col-lg-6">
                    <h3>{{ $product->product_name }}</h3>
                    <input type="hidden" id="input-id-product" value="{{ $product->id }}">
                </div>
            </div>
        </span>

        <br>
        <!-- Nav pills -->
        <ul class="nav nav-pills" role="tablist">
            <li class="nav-item">
                <a class="nav-link active" data-toggle="pill" href="#tab1">Datos del producto</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" data-toggle="pill" href="#tab2">Asignar clientes</a>
            </li>
        </ul>

        <!-- Tab panes -->
        <div class="tab-content">
            <div id="tab1" class="container tab-pane active"><br>

                @foreach ($errors->all() as $error)
                    <p class="text-danger">{{ $error }}</p>
                @endforeach

                <div class="form-group row">
                    <label for="mn_name" class="col-lg-3 col-form-label requerido">Nombre</label>
                    <div class="col-lg-9">
                        <input type="text" name="product_name" id="product_name" class="form-control" value="{{old('product_name', $product->product_name ?? '')}}" required/>
                    </div>
                </div>
                <div class="form-group row">
                    <label for="mn_url" class="col-lg-3 col-form-label requerido">Precio</label>
                    <div class="col-lg-9">
                        <input type="text" name="sale_price" id="sale_price" class="form-control" value="{{old('sale_price', $product->sale_price ?? '')}}" required/>
                    </div>
                </div>
                <div class="form-group row">
                    <label for="mn_icon" class="col-lg-3 col-form-label">Stock</label>
                    <div class="col-lg-9">
                        <input type="number" name="stock" id="stock" class="form-control" value="{{old('stock', $product->stock ?? '')}}" required/>
                    </div>
                </div>

                <div class="card-footer">
                    <div class="row justify-content-center">

                        <a id="btn-update-product" class="btn-update-product btn btn-info" >
                            Actualizar
                        </a>
                        <a href="{{ route('products')}}" class="btn btn-default">
                            Cancelar
                        </a>

                    </div>
                </div>

            </div>
            <div id="tab2" class="container tab-pane fade"><br>

                <div class="row">
                    <div class="col-lg-1">
                        Clientes:
                    </div>

                    <div class="col-lg-6">
                        <select name="sel-clients" id="sel-clients" class="form-control">
                            <option value="" disabled selected>Seleccione</option>

                            @foreach($freeClients as $freeClient)
                                <option value="{{ $freeClient->id_client }}">
                                    {{ $freeClient->name1 . ' ' . $freeClient->name2 . ' ' . $freeClient->name3 . ' (' .$freeClient->type_name . ')' }}</option>
                            @endforeach
                        </select>
                        <input type="hidden" id="txt-type-ide">
                    </div>
                    <div class="col-lg-1">
                        <a id="btn-assign-product" class="btn-assign-product" >
                            <i class="fas fa-plus"></i> Añadir
                        </a>
                    </div>

                </div>
                <br>
                <p>Listado de clientes asignados a éste producto:</p>

                <table class="table table-hover">
                    <thead class="">
                    <tr>
                        <th scope="col">ID</th>
                        <th scope="col">Identificación</th>
                        <th scope="col">Tipo ID</th>
                        <th scope="col">Nombres</th>
                        <th scope="col">Apellidos</th>
                        <th scope="col">Razón social</th>
                        <th scope="col"></th>
                    </tr>
                    </thead>
                    <tbody>
                    @if( $clients->count() > 0 )
                        @foreach($clients as $client )
                            <tr class="item-row{{ $client->id_client_products }}">
                                <th scope="row">{{ $client->id_client_products }}</th>
                                <td>{{ $client->ide_cli }}</td>
                                <td>{{ $client->ide_type_cli }}</td>
                                <td>{{ $client->first_name_cli }}</td>
                                <td>{{ $client->sur_name_cli }}</td>
                                <td>{{ $client->business_name_cli }}</td>
                                <td class="text-center" style="width: 20%;">

                                    <a class="btn-client_products-delete" data-id="{{ $client->id_client_products }}" >
                                        <i class="fas fa-trash text-danger fa-lg"></i>
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

    <script>
        $(document).ready(function () {

            $("#btn-update-product").click(function(){

                var id_product = $('#input-id-product').val();
                var product_name = $('#product_name').val();
                var sale_price   = $('#sale_price').val();
                var stock        = $('#stock').val();

                if (product_name && sale_price && stock) {

                    $.ajax({
                        type:"POST",
                        url:"/product/update/"+id_product,
                        data: {
                            "product_name": product_name,
                            "sale_price": sale_price,
                            "stock": stock,
                            "_token": "{{ csrf_token() }}"
                        },
                        dataType : 'json',
                        success: function(data){

                            swal("Hecho", "Producto actualizado...", "success");
                            setTimeout(reload, 1500);

                            function reload(){
                                location.reload();
                            }
                        },
                        error: function(xhr,status, response ){
                            swal("Error", "Se produjo un error al actualizar el producto", "error");
                            console.log(response);
                        }
                    });
                } else {
                    swal("Error", "El nombre, precio y el stock no pueden quedar vacios", "warning");
                }
            });

            $("#btn-assign-product").click(function(){

                var id_client  = $('#sel-clients').val();
                var id_product = $('#input-id-product').val();

                if (id_client) {

                    $.ajax({
                        type:"POST",
                        url:"/assign/client-products",
                        data: {
                            "client_id": id_client,
                            "product_id": id_product,
                            "_token": "{{ csrf_token() }}"
                        },
                        dataType : 'json',
                        success: function(data){

                            swal("Hecho", "Se ha asignado el producto al cliente...", "success");
                            setTimeout(reload, 1500);

                            function reload(){
                                location.reload();
                            }
                        },
                        error: function(xhr,status, response ){
                            swal("Error", "Se produjo un error al crear la asignación...", "error");
                            console.log(response);
                        }
                    });
                } else {
                    swal("Error", "Para asignar un cliente al producto, por favor seleccionelo primero.", "warning");
                }
            });

            $(".btn-client_products-delete").click(function(){

                let id_client = $(this).data("id");
                swal({
                    title: "Eliminar el producto al cliente ?",
                    text: "Los datos no se podrán recuperar...",
                    icon: "warning",
                    buttons: true,
                    dangerMode: true,
                })
                .then((willDelete) => {
                    if (willDelete) {
                        $.ajax("/client-products/destroy/"+id_client, {
                            headers: {
                                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                            },
                            data: {
                                "id": id_client
                            },
                            type: "GET",
                            async: false,
                            error: function error(data) {
                                swal("Error", "Error al eliminar el cliente", "error");
                            },
                            success: function success(data) {

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

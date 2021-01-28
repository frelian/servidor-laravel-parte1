@extends('layouts.app')

@section('content')

    <br>
    <div class="container">
        <h3 class="text-center">Productos</h3>

        <!-- Tab panes -->
        <div class="tab-content">
            <div id="home" class="container tab-pane active"><br>

                <form action="" method="get">
                    <div class="form-group row">

                        <div class="col-lg-4 pull-right">

                            <div class="input-group">
                                <input type="text" class="form-control" value="{{ $buscado }}" name="search-name" placeholder="Buscar producto" id="search-name"/>
                                <div class="input-group-btn">
                                    <button class="btn btn-default" type="submit">
                                        <i class="fas fa-search text-primary fa-lg"></i>
                                    </button>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-4">

                            <a href="{{ route('product-create') }}" class="btn btn-success">
                                Registrar producto
                            </a>
                        </div>
                    </div>
                </form>

                <table class="table table-hover">
                    <thead class="">
                    <tr>
                        <th scope="col">#</th>
                        <th scope="col">Nombre del producto</th>
                        <th scope="col">Precio</th>
                        <th class="text-center" scope="col">Stock</th>
                        <th class="text-center" scope="col">Total clientes</th>
                        <th scope="col">Creado</th>
                        <th scope="col"></th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($products as $product )
                        <tr class="item-row{{ $product->id_product }}">
                            <th scope="row">{{ $product->id_product }}</th>
                            <td>{{ $product->product_name }}</td>
                            <td>{{ $product->sale_price }}</td>
                            <td class="text-center">{{ $product->stock }}</td>
                            <td class="text-center">{{ $product->client_productsCount }}</td>
                            <td>{{ $product->product_created_at }}</td>
                            <td class="text-center" style="width: 20%;">
                                <a href="{{route('product-edit', ['id' => $product->id_product])}}" class="table-link">
                                    <span class="fa-stack">
                                        <i class="fa fa-square fa-stack-2x"></i>
                                        <i class="fas fa-user-edit fa-stack-1x fa-inverse"></i>
                                    </span>
                                </a>

                                <a class="btn-product-delete" data-id="{{ $product->id_product }}" >
                                    <i class="fas fa-trash text-danger  fa-lg"></i>
                                </a>

                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
                <div class="pagination">
                    {{ $products->links() }}
                </div>

            </div>
        </div>
    </div>

    <!-- small modal -->
    <div class="modal fade" id="user-modal" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body" id="smallBody">
                    <div>
                        <h6 class="float-right">Todos los campos son obligatorios </h6>
                        <br><br>
                            <div class="modal-error">

                            </div>
                            <div class="form-group row">
                                <label for="mn_name" class="col-lg-3 col-form-label requerido">Identificación</label>
                                <div class="col-lg-9">
                                    <input type="text" name="identification" id="identification" class="form-control" value="{{old('identification')}}" required/>
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="mn_url" class="col-lg-3 col-form-label requerido">Nombres</label>
                                <div class="col-lg-9">
                                    <input type="text" name="names" id="names" class="form-control" value="{{old('names')}}" required/>
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="mn_icon" class="col-lg-3 col-form-label">Dirección</label>
                                <div class="col-lg-9">
                                    <input type="text" name="address" id="address" class="form-control" value="{{old('address')}}" required/>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="mn_icon" class="col-lg-3 col-form-label">Teléfono</label>
                                <div class="col-lg-9">
                                    <input type="text" name="phone" id="phone" class="form-control" value="{{old('phone')}}" required/>
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="mn_icon" class="col-lg-3 col-form-label">Email</label>
                                <div class="col-lg-9">
                                    <input type="email" name="email" id="email" class="form-control" value="{{old('email')}}" required/>
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

                                    <a id="btn-store-user" class="btn btn-success">
                                        Crear usuario
                                    </a>

                                    <a href="{{ route('users')}}" class="btn btn-default">
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

            $(".btn-product-delete").click(function(){

                let id_product = $(this).data("id");
                swal({
                    title: "Eliminar el usuario ?",
                    text: "Los datos no se podrán recuperar...",
                    icon: "warning",
                    buttons: true,
                    dangerMode: true,
                })
                .then((willDelete) => {
                    if (willDelete) {
                        $.ajax("/product/destroy/"+id_product, {
                            headers: {
                                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                            },
                            data: {
                                "id": id_product
                            },
                            type: "POST",
                            async: false,
                            error: function error(data) {
                                swal("Error", "Error al eliminar el producto", "error");
                            },
                            success: function success(data) {
                                $(".item-row"+id_product).remove();
                                swal("Hecho", "El producto fue eliminado...", "success");
                            }
                        });
                    }
                });
            });

            $("#btn-store-user").click(function(){

                let ide = $('#identification').val();
                let names = $('#names').val();
                let address = $('#address').val();
                let phone = $('#phone').val();
                let email = $('#email').val();
                let password = $('#password').val();

                $.ajax({
                    type:"POST",
                    url:"/userstore",
                    data: {
                        "identification": ide,
                        "names": names,
                        "address": address,
                        "phone": phone,
                        "email": email,
                        "password": password,
                        "_token": "{{ csrf_token() }}"
                    },
                    dataType : 'json',
                    success: function(data){
                        $("#user-modal").modal('hide');
                        swal("Hecho", "Usuario creado correctamente...", "success");
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

                        $(".modal-error").empty();
                        $(".modal-error").append(errorsHtml);
                    }
                });
            });

        });
    </script>

@endsection

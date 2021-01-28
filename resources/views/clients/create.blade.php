@extends('layouts.app')

@section('content')
    <br>

    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">

                <div class="card card-info card-outline">
                    <div class="card-header with-border">
                        <h3 class="card-title ">Nuevo Cliente</h3>
                        <div class="card-tools">
                            <a href="{{ route('clients')}}" class="btn btn-block btn-outline-info btn-sm">
                                <i class="fa fa-fw fa-reply-all"></i> Volver al listado
                            </a>
                        </div>
                    </div>
                    <div class="card-body">
                        <form action="{{route('client-store')}}" id="form-general" class="form-horizontal" method="POST" autocomplete="off">
                            @csrf @method("post")

                            @foreach ($errors->all() as $error)
                                <p class="text-danger">{{ $error }}</p>
                            @endforeach

                            <div class="alert alert-info" role="alert">
                                Puede seleccione el tipo de cliente o crear uno nuevo +
                            </div>

                            <div class="form-group row">
                                <label for="mn_name" class="col-lg-3 col-form-label requerido">Tipo de cliente</label>
                                <div class="col-lg-6">

                                    <select name="sel-tp-clients" id="sel-tp-clients" class="form-control">
                                        <option value="" disabled selected>Seleccione</option>
                                        <option value="1">Domiciliario</option>
                                        <option value="2">Comercial</option>
                                        <option value="3">Hospitalarios</option>
                                    </select>

                                </div>
                                <div class="col-lg-3">
                                    <a data-toggle="modal" data-target="#client-type-modal" class="btn btn-default">
                                        <i class="fas fa-user-plus"></i>
                                    </a>
                                </div>
                            </div>
                            <div class="form-group row area-tp-doc">
                                <label for="mn_name" class="col-lg-3 col-form-label requerido">Tipo de documento</label>
                                <div class="col-lg-9">

                                    <select name="sel-type-ide" id="sel-type-ide" class="form-control">
                                        <option value="" disabled selected>Seleccione</option>
                                        <option value="identification">Identificación</option>
                                        <option value="nit">NIT</option>
                                    </select>
                                    <input type="hidden" id="txt-type-ide">
                                </div>
                            </div>
                            <div class="form-group row area-ide">
                                <label id="lblide" for="mn_name" class="col-lg-3 col-form-label requerido">Identificación</label>
                                <div class="col-lg-9">
                                    <input type="text" name="identification" id="identification" class="form-control" value="{{old('identification')}}" required/>
                                </div>
                            </div>
                            <div class="form-group row area-name">
                                <label for="mn_url" class="col-lg-3 col-form-label requerido">Nombres</label>
                                <div class="col-lg-9">
                                    <input type="text" name="first_name_cli" id="first_name_cli" class="form-control" value="{{old('first_name_cli')}}" />
                                </div>
                            </div>
                            <div class="form-group row area-surname">
                                <label for="mn_url" class="col-lg-3 col-form-label requerido">Apellidos</label>
                                <div class="col-lg-9">
                                    <input type="text" name="sur_name_cli" id="sur_name_cli" class="form-control" value="{{old('sur_name_cli')}}" />
                                </div>
                            </div>
                            <div class="form-group row area-business">
                                <label for="mn_url" class="col-lg-3 col-form-label requerido">Razón social</label>
                                <div class="col-lg-9">
                                    <input type="text" name="business_name_cli" id="business_name_cli" class="form-control" value="{{old('business_name_cli')}}" />
                                </div>
                            </div>
                            <div class="form-group row area-dir">
                                <label for="mn_icon" class="col-lg-3 col-form-label">Dirección</label>
                                <div class="col-lg-9">
                                    <input type="text" name="address_cli" id="address_cli" class="form-control" value="{{old('address_cli')}}" required/>
                                </div>
                            </div>
                            <div class="form-group row area-phone">
                                <label for="mn_icon" class="col-lg-3 col-form-label">Teléfono</label>
                                <div class="col-lg-9">
                                    <input type="text" name="phone" id="phone" class="form-control" value="{{old('phone')}}" required/>
                                </div>
                            </div>
                            <div class="form-group row area-spec">
                                <label for="mn_icon" class="col-lg-3 col-form-label">Especialidad</label>
                                <div class="col-lg-9">
                                    <input type="text" name="specialty_cli" id="specialty_cli" class="form-control" value="{{old('specialty_cli')}}"/>
                                </div>
                            </div>

                            <div class="card-footer">
                                <div class="row justify-content-center">

                                    <a id="btn-store-client" class="btn btn-success">
                                        Crear cliente
                                    </a>

                                    <a href="{{ route('clients')}}" class="btn btn-default">
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


    <!-- Modal -->
    <div class="modal fade" id="client-type-modal" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body" >
                    <div>
                        <div class="modal-error-type"></div>

                        <h5>Crear nuevo tipo de cliente:</h5>
                        <div class="form-group row">
                            <label for="mn_name" class="col-lg-3 col-form-label requerido">Nombre</label>
                            <div class="col-lg-9">
                                <input type="text" name="type_name" id="type_name" class="form-control" value="{{old('type_name')}}" required/>
                            </div>
                        </div>

                        </div>

                        <div class="card-footer">
                            <div class="row justify-content-center">

                                <a id="btn-store-typec" class="btn btn-success">
                                    Crear
                                </a>

                                <a href="{{ route('client-create')}}" class="btn btn-default">
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

            // Oculto los campos
            $('.area-ide').hide();
            $('.area-tp-doc').hide();
            $('.area-name').hide();
            $('.area-surname').hide();
            $('.area-dir').hide();
            $('.area-phone').hide();
            $('.area-business').hide();
            $('.area-spec').hide();

            reloadTypes();

            function reloadTypes() {

                $.ajax({
                    type:"POST",
                    url:"/types",
                    data: {
                        "_token": "{{ csrf_token() }}"
                    },
                    dataType : 'json',
                    success: function(data){

                        // Limpio el select
                        $("#sel-tp-clients")
                            .find('option')
                            .remove()
                            .end()
                            .val('');

                        var options;
                        options = "<option value='' disabled selected>Seleccione</option>";

                        $.each(data.data, function(i,item) {
                            options += "<option value='"+item.id+"'>"+item.type_name+"</option>"
                        });

                        $("#sel-tp-clients")
                            .find('option')
                            .remove()
                            .end()
                            .append(options)
                            .val('');


                    },
                    error: function(xhr,status, response ){
                        swal("Error", "Error al cargar los tipos de cliente", "error");
                    }
                });
            }

            $('#sel-tp-clients').on('change', function() {

                var band = 0;
                if ( (this.value === "1") ) {
                    formComerciales("hide");
                    formHosp("hide");
                    formDomiciliarios("show");
                    band = 1;
                }

                if ( (this.value === "2") ) {
                    formDomiciliarios("hide");
                    formHosp("hide");
                    formComerciales("show");
                    band = 1;
                }

                if ( (this.value === "3") ) {
                    formDomiciliarios("hide");
                    formComerciales("hide");
                    formHosp("show");
                    band = 1;
                }

                if ( band == 0 ) {
                    formDomiciliarios("hide");
                    formHosp("hide");
                    formComerciales("show");
                    $('.area-tp-doc').show();
                    $('#lblide').html("Identificación");
                }
            });

            function formDomiciliarios(type) {

                if ( type === 'show' ) {

                    $('#lblide').html("Identificación");
                    $("#txt-type-ide").val('identification');
                    $('.area-ide').show();
                    $('.area-tp-doc').hide();
                    $('.area-name').show();
                    $('.area-surname').show();
                    $('.area-dir').show();
                    $('.area-phone').show();
                } else {
                    $('.area-ide').hide();
                    $('.area-tp-doc').hide();
                    $('.area-name').hide();
                    $('.area-surname').hide();
                    $('.area-dir').hide();
                    $('.area-phone').hide();
                }
            }

            function formComerciales(type) {

                if ( type === 'show' ) {
                    $('#lblide').html("NIT");

                    $("#txt-type-ide").val('nit');
                    $('.area-ide').show();
                    $('.area-tp-doc').hide();
                    $('.area-business').show();
                    $('.area-dir').show();
                    $('.area-phone').show();
                } else {
                    $('.area-ide').hide();
                    $('.area-tp-doc').hide();
                    $('.area-business').hide();
                    $('.area-dir').hide();
                    $('.area-phone').hide();
                }
            }

            function formHosp(type) {

                if ( type === 'show' ) {
                    $('#lblide').html("NIT");

                    $("#txt-type-ide").val('nit');
                    $('.area-ide').show();
                    $('.area-tp-doc').hide();
                    $('.area-business').show();
                    $('.area-dir').show();
                    $('.area-phone').show();
                    $('.area-spec').show();
                } else {
                    $('.area-ide').hide();
                    $('.area-tp-doc').hide();
                    $('.area-business').hide();
                    $('.area-dir').hide();
                    $('.area-phone').hide();
                    $('.area-spec').hide();
                }
            }

            function inputClear(){
                $("#txt-type-ide").val('');
                $('#identification').val('');
                $('#first_name_cli').val('');
                $('#sur_name_cli').val('');
                $('#business_name_cli').val('');
                $('#address_cli').val('');
                $('#phone').val('');
                $('#specialty_cli').val('');
            }

            // Funcion para guardar el tipo de cliente nuevo
            $("#btn-store-typec").click(function(){

                let type = $('#type_name').val();

                $.ajax({
                    type:"POST",
                    url:"/types/store",
                    data: {
                        "type_name": type,
                        "_token": "{{ csrf_token() }}"
                    },
                    dataType : 'json',
                    success: function(data){
                        $("#client-type-modal").modal('hide');
                        swal("Hecho", "Tipo de cliente creado correctamente...", "success");
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

                        $(".modal-error-type").empty();
                        $(".modal-error-type").append(errorsHtml);
                    }
                });
            });

            // Limpio el campo de tipo de cliente
            $('#client-type-modal').click(function (){
                $('#type_name').val('');
            });

            // Funcion para guardar el nuevo cliente
            $("#btn-store-client").click(function(){

                let client_types_id = $('#sel-tp-clients').val();
                let ide_type_cli =  $("#txt-type-ide").val();
                let ide_cli = $('#identification').val();
                let first_name_cli = $('#first_name_cli').val();
                let sur_name_cli = $('#sur_name_cli').val();
                let business_name_cli = $('#business_name_cli').val();
                let address_cli = $('#address_cli').val();
                let phone_cli = $('#phone').val();
                let specialty_cli = $('#specialty_cli').val();

                $.ajax({
                    type:"POST",
                    url:"/client/store",
                    data: {
                        "client_types_id": client_types_id,
                        "ide_type_cli": ide_type_cli,
                        "ide_cli": ide_cli,
                        "first_name_cli": first_name_cli,
                        "sur_name_cli": sur_name_cli,
                        "business_name_cli": business_name_cli,
                        "address_cli": address_cli,
                        "phone_cli": phone_cli,
                        "specialty_cli": specialty_cli,
                        "_token": "{{ csrf_token() }}",
                    },
                    dataType : 'json',
                    success: function(data){
                        $("#user-modal").modal('hide');
                        swal("Hecho", "Cliente creado correctamente...", "success");
                        formComerciales('hide');
                        formDomiciliarios('hide');
                        formHosp('hide');
                        $('.area-tp-doc').hide();
                        $("#txt-type-ide").val('');
                        $("#txt-type-ide").hide();
                        $(".modal-error-client").empty();
                        $('#sel-tp-clients').val('');
                    },
                    error: function(data){
                        console.log(data);

                        swal({
                            title: "Error",
                            content: "sdasd",
                            icon: "error",
                            dangerMode: true,
                        });
                    }
                });
            });
        });
    </script>

@endsection

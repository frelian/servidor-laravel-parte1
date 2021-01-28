<?php $__env->startSection('content'); ?>
    <br>

    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">

                <div class="card card-info card-outline">
                    <div class="card-header with-border">
                        <h3 class="card-title ">Nuevo producto</h3>
                        <div class="card-tools">
                            <a href="<?php echo e(route('products')); ?>" class="btn btn-block btn-outline-info btn-sm">
                                <i class="fa fa-fw fa-reply-all"></i> Volver al listado
                            </a>
                        </div>
                    </div>
                    <div class="card-body">
                        <form action="<?php echo e(route('client-store')); ?>" id="form-general" class="form-horizontal" method="POST" autocomplete="off">
                            <?php echo csrf_field(); ?> <?php echo method_field("post"); ?>

                            <?php $__currentLoopData = $errors->all(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $error): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <p class="text-danger"><?php echo e($error); ?></p>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

                            <div class="form-group row">
                                <label for="mn_name" class="col-lg-3 col-form-label requerido">Nombre</label>
                                <div class="col-lg-9">
                                    <input type="text" name="product_name" id="product_name" class="form-control" value="<?php echo e(old('product_name', $product->product_name ?? '')); ?>" required/>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="mn_url" class="col-lg-3 col-form-label requerido">Precio</label>
                                <div class="col-lg-9">
                                    <input type="text" name="sale_price" id="sale_price" class="form-control" value="<?php echo e(old('sale_price', $product->sale_price ?? '')); ?>" required/>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="mn_icon" class="col-lg-3 col-form-label">Stock</label>
                                <div class="col-lg-9">
                                    <input type="number" name="stock" id="stock" class="form-control" value="<?php echo e(old('stock', $product->stock ?? '')); ?>" required/>
                                </div>
                            </div>

                            <div class="card-footer">
                                <div class="row justify-content-center">

                                    <a id="btn-store-product" class="btn btn-success">
                                        Registrar
                                    </a>

                                    <a href="<?php echo e(route('products')); ?>" class="btn btn-default">
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
                        "_token": "<?php echo e(csrf_token()); ?>"
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
                        "_token": "<?php echo e(csrf_token()); ?>"
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

            // Funcion para guardar el nuevo producto
            $("#btn-store-product").click(function(){

                let product_name = $('#product_name').val();
                let sale_price =  $("#sale_price").val();
                let stock = $('#stock').val();

                $.ajax({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    type:"POST",
                    url:"/product/store",
                    data: {
                        "product_name": product_name,
                        "sale_price": sale_price,
                        "stock": stock,
                    },
                    dataType : 'json',
                    success: function(data){
                        $('#product_name').val('');
                        $("#sale_price").val('');
                        $('#stock').val('');
                        swal("Hecho", "Producto creado correctamente...", "success");
                    },
                    error: function(data ){
                        swal("Error", "Error al crear el producto", "error");
                    }
                });
            });
        });
    </script>

<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /var/www/pruebas_laborales/Eadvising_20012021/eadvising_laravel/resources/views/products/create.blade.php ENDPATH**/ ?>
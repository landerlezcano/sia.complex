
<div id="content">
    <div class="row">
        <div class="col-xs-12 col-sm-9 col-md-9 col-lg-9">
            <h1 class="page-title txt-color-blueDark">
                <a class="backHome" href="/bo"><i class="fa fa-home"></i> Menu</a> 
                <span>
                    > <a href="/bo/altas">Altas</a> 
                    > <a href="/bo/usuarios">Usuarios</a>
                    > Listar
                </span>
            </h1>
        </div>
    </div>

    <section id="widget-grid" class="">
        <div id="myTabContent1" class="tab-content padding-10"
             style="margin-bottom: 6rem;">
            <div class="row">
                <!-- NEW COL START -->
                <article class="col-sm-12 col-md-12 col-lg-12">
                    <!-- Widget ID (each widget will need unique ID)-->
                    <div class="jarviswidget" id="wid-id-1"
                         data-widget-editbutton="false" data-widget-custombutton="false"
                         data-widget-colorbutton="false">
                        <header>
                            <span class="widget-icon"> <i class="fa fa-edit"></i>
                            </span>
                            <h2>Listar Usuarios</h2>

                        </header>

                        <!-- widget div-->
                        <div>
                            <div
                                class="row col-xs-12 col-md-12 col-sm-12 col-lg-12 pull-right">

                                <div class="col-xs-0 col-md-6 col-sm-0 col-lg-5"></div>

                                <div class="col-xs-4 col-md-1 col-sm-2 col-lg-1">
                                    <center>
                                        <a title="Bloquear" style="cursor: pointer;"
                                           class="txt-color-gray"><i class="fa fa-unlock fa-3x"></i></a>
                                        <br>Bloquear
                                    </center>
                                </div>
                                <div class="col-xs-4 col-md-1 col-sm-2 col-lg-1">
                                    <center>
                                        <a title="Desbloquear" style="cursor: pointer;"
                                           class="txt-color-gray"><i class="fa fa-lock fa-3x"></i></a> <br>Desbloquear
                                    </center>
                                </div>

                                <div class="col-xs-4 col-md-1 col-sm-2 col-lg-1">
                                    <center>
                                        <a title="Editar" style="cursor: pointer;"
                                           class="txt-color-blue"><i class="fa fa-pencil fa-3x"></i></a>
                                        <br>Editar
                                    </center>
                                </div>



                                <!-- <div class="col-xs-4 col-md-1 col-sm-2 col-lg-1">
                                        <center>
                                                <a title="Genealogico" style="cursor: pointer;"
                                                        class="txt-color-gray"><i class="fa fa-sitemap fa-3x"></i></a>
                                                <br>Genealogico
                                        </center>
                                </div>

                                <div class="col-xs-4 col-md-1 col-sm-2 col-lg-1">
                                        <center>
                                                <a title="Arbol 1" style="cursor: pointer;"
                                                        class="txt-color-red"><i class="fa fa-sitemap fa-3x"></i></a>
                                                <br>Arbol 1
                                        </center>
                                </div>

                                <div class="col-xs-4 col-md-1 col-sm-2 col-lg-1">
                                        <center>
                                                <a title="Arbol 2" style="cursor: pointer;"
                                                        class="txt-color-green"><i class="fa fa-sitemap fa-3x"></i></a>
                                                <br>Arbol 2
                                        </center>
                                </div> -->

                                <div class="col-xs-4 col-md-1 col-sm-2 col-lg-1">
                                    <center>
                                        <a title="Eliminar" style="cursor: pointer;"
                                           class="txt-color-red"><i class="fa fa-trash-o fa-3x"></i></a>
                                        <br>Eliminar
                                    </center>
                                </div>

                            </div>
                            <form name="formulario" action="/bo/comercial/actualizar_tabla"
                                  method="post" class="smart-form">

                                <div class="col-xs-12 col-md-12 col-sm-12 col-lg-12">
                                    <br/>
                                    <hr/>
                                    <br/>
                                </div>


                            </form>
                            <table id="dt_basic"
                                   class="table table-striped table-bordered table-hover"
                                   width="100%">
                                <thead>
                                    <tr>
                                        <th>ID</th>
                                        <th data-class="expand">Imagen</th>
                                        <th data-hide="phone">Usuario</th>
                                        <!--<th data-hide="phone,tablet">Cargo</th>-->
                                        <th data-hide="phone,tablet">Contraseña</th>
                                        <th data-hide="phone,tablet">e-mail</th>
                                        <th data-hide="phone">Rol</th>
                                        <th>Accion</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?foreach ( $usuarios as $usuario ) {?>
                                    <tr>
                                        <td><?php echo $usuario->id; ?></td>

                                        <?
                                        $usuarios_imagen = "/template/img/empresario.jpg";
                                        foreach ( $image as $img ) {
                                        if ($img->id_user == $usuario->id) {
                                        $cadena = explode ( ".", $img->img );
                                        if ($cadena [0] == "user") {
                                        $usuarios_imagen = $img->url;
                                        }
                                        }
                                        }
                                        ?>

                                        <td>
                                            <img style="width: 10rem; height: 10rem;" 
                                                 src="<?php echo $usuarios_imagen ?>"></img>
                                        </td>
                                        <td><?php echo $usuario->nombre . " " . $usuario->apellido . " (" . $usuario->username . ")" ?></td>
                                        <!--<td><?php echo $usuario->cargo ?></td>-->
                                        <td><?php echo $usuario->recovery ? $usuario->recovery : "<em class='txt-color-red'>Debe Cambiarse</em>" ?></td>
                                        <td><?php echo $usuario->email ?></td>
                                        <td><?php echo $usuario->rol ?></td>
                                        <td>

                                            <?php if ($usuario->estatus == 'Desactivado') { ?>
                                                <a title="Desbloquear" style='cursor: pointer;'
                                                   onclick="estado_usuario(1,<?= $usuario->id ?>)"
                                                   class="txt-color-gray"><i class="fa fa-lock fa-3x"></i></a>
                                               <?php } else { ?>
                                                <a title="Bloquear" style='cursor: pointer;'
                                                   onclick="estado_usuario(2,<?= $usuario->id ?>)"
                                                   class="txt-color-gray"><i class="fa fa-unlock fa-3x"></i></a>
                                               <?php } ?>
                                            <a title="Editar" style='cursor: pointer;'
                                               onclick="modificar_usuario(<?php echo $usuario->id; ?>)"
                                               class="txt-color-blue"><i class="fa fa-pencil fa-3x"></i></a>
                                               <!-- <a title="Sustituir" style='cursor: pointer;' onclick="sustituir_afiliado(<?php echo $usuario->id; ?>)" class="txt-color-green"><i class="fa fa-exchange fa-3x"></i></a> -->

                                            <a title="Eliminar" style='cursor: pointer;'
                                               onclick="eliminar_usuario(<?php echo $usuario->id; ?>)"
                                               class="txt-color-red"><i class="fa fa-trash-o fa-3x"></i></a>
                                            <!-- 	</br> 
                    <a title="Genealogico" style='cursor: pointer;'
                                                    href="/bo/comercial/tipos_de_red_grafico_1?id_afiliado=<?php echo $usuario->id; ?>"
                                                    class="txt-color-gray"><i class="fa fa-sitemap fa-3x"></i></a>
                                                    <a title="Arbol 1" style='cursor: pointer;' href="/bo/comercial/tipos_de_red_grafico_2?id_afiliado=<?php echo $usuario->id; ?>" class="txt-color-red"><i class="fa fa-sitemap fa-3x"></i></a>
                    <a title="Arbol 2" style='cursor: pointer;'
                                                    href="/bo/comercial/tipos_de_red_genealogico?id_afiliado=<?php echo $usuario->id; ?>"
                                                    class="txt-color-green"><i class="fa fa-sitemap fa-3x"></i></a> -->
                                        </td>

                                    </tr>
                                    <?} ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </article>
            </div>
        </div>
    </section>
</div>
<script src="/template/js/plugin/morris/raphael.min.js"></script>
<script src="/template/js/plugin/morris/morris.min.js"></script>

<script src="/template/js/plugin/datatables/jquery.dataTables.min.js"></script>
<script src="/template/js/plugin/datatables/dataTables.colVis.min.js"></script>
<script
src="/template/js/plugin/datatables/dataTables.tableTools.min.js"></script>
<script src="/template/js/plugin/datatables/dataTables.bootstrap.min.js"></script>
<script
src="/template/js/plugin/datatable-responsive/datatables.responsive.min.js"></script>

<script type="text/javascript">

                                                   var responsiveHelper_dt_basic = undefined;
                                                   var rol = <?= $_GET['rol'] ?>;

                                                   function modificar_usuario(id)
                                                   {

                                                       $.ajax({
                                                           type: "POST",
                                                           url: "/bo/usuarios/get_formulario",
                                                           data: {id: id, rol: rol},
                                                       })
                                                               .done(function (msg)
                                                               {
                                                                   bootbox.dialog({
                                                                       message: msg,
                                                                       title: 'Modificar Usuario',
                                                                   })//fin done ajax
                                                               });//Fin callback bootbox
                                                   }

                                                   function ver_usuario(id)
                                                   {

                                                       $.ajax({
                                                           type: "POST",
                                                           url: "/bo/usuarios/get_detalle",
                                                           data: {id: id},
                                                       })
                                                               .done(function (msg)
                                                               {
                                                                   bootbox.dialog({
                                                                       message: msg,
                                                                       title: 'Datos del Usuario',
                                                                   })//fin done ajax
                                                               });//Fin callback bootbox
                                                   }



                                                   function eliminar_usuario(id) {

                                                       if (id > 2) {

                                                           $.ajax({
                                                               type: "POST",
                                                               url: "/auth/show_dialog",
                                                               data: {message: '¿ Esta seguro que desea Eliminar el Afiliado ?'},
                                                           })
                                                                   .done(function (msg)
                                                                   {
                                                                       bootbox.dialog({
                                                                           message: msg,
                                                                           title: 'Eliminar Afiliado',
                                                                           buttons: {
                                                                               success: {
                                                                                   label: "Aceptar",
                                                                                   className: "btn-success",
                                                                                   callback: function () {
                                                                                       setiniciarSpinner();
                                                                                       $.ajax({
                                                                                           type: "POST",
                                                                                           url: "/bo/usuarios/eliminar",
                                                                                           data: {id:id}
                                                                                       })
                                                                                               .done(function (msg)
                                                                                               {
                                                                                                   bootbox.dialog({
                                                                                                       message: msg,
                                                                                                       title: 'Eliminar Afiliado',
                                                                                                       buttons: {
                                                                                                           success: {
                                                                                                               label: "Aceptar",
                                                                                                               className: "btn-success",
                                                                                                               callback: function () {
                                                                                                                   location.href = "/bo/usuarios/listar?rol=<?=$_GET['rol']?>";
                                                                                                                   FinalizarSpinner();
                                                                                                               }
                                                                                                           }
                                                                                                       }
                                                                                                   })//fin done ajax
                                                                                               });//Fin callback bootbox

                                                                                   }
                                                                               },
                                                                               danger: {
                                                                                   label: "Cancelar!",
                                                                                   className: "btn-danger",
                                                                                   callback: function () {

                                                                                   }
                                                                               }
                                                                           }
                                                                       })
                                                                   });

                                                       }

                                                   }


                                                   $(document).ready(function () {

                                                       var responsiveHelper_dt_basic = undefined;
                                                       var responsiveHelper_datatable_fixed_column = undefined;
                                                       var responsiveHelper_datatable_col_reorder = undefined;
                                                       var responsiveHelper_datatable_tabletools = undefined;

                                                       var breakpointDefinition = {
                                                           tablet: 1024,
                                                           phone: 480
                                                       };
                                                       var otable = $('#dt_basic').DataTable({
                                                           "bFilter": true,
                                                           "bFilter": true,
                                                                   //"bInfo": false,
                                                                   //"bLengthChange": false
                                                                   //"bAutoWidth": false,
                                                                   "bPaginate": true,
                                                           //"bStateSave": true // saves sort state using localStorage
                                                           "sDom": "<'dt-toolbar'<'col-xs-12 col-sm-6 hidden-xs'f><'col-sm-6 col-xs-12 hidden-xs'<'toolbar'>>r>" +
                                                                   "t" +
                                                                   "<'dt-toolbar-footer'<'col-sm-6 col-xs-12 hidden-xs'i><'col-xs-12 col-sm-6'p>>",
                                                           "autoWidth": true,
                                                           "preDrawCallback": function () {
                                                               // Initialize the responsive datatables helper once.
                                                               if (!responsiveHelper_datatable_fixed_column) {
                                                                   responsiveHelper_datatable_fixed_column = new ResponsiveDatatablesHelper($('#dt_basic'), breakpointDefinition);
                                                               }
                                                           },
                                                           "rowCallback": function (nRow) {
                                                               responsiveHelper_datatable_fixed_column.createExpandIcon(nRow);
                                                           },
                                                           "drawCallback": function (oSettings) {
                                                               responsiveHelper_datatable_fixed_column.respond();
                                                           }

                                                       });
                                                       $("div.toolbar").html('<div class="text-right"><img src="" alt="" style="width: 111px; margin-top: 3px; margin-right: 10px;"></div>');

                                                       // Apply the filter
                                                       $("#dt_basic thead th input[type=text]").on('keyup change', function () {

                                                           otable
                                                                   .column($(this).parent().index() + ':visible')
                                                                   .search(this.value)
                                                                   .draw();

                                                       });

// custom toolbar
                                                       /*	 var obj = '<a onclick="reporte_excel()" class="btn btn-success col-xs-12 col-lg-12 col-md-12 col-sm-12 " ><i class="fa fa-print"></i>&nbsp;Crear excel</a>'
                                                        $("#remplazar").html(obj);*/
                                                       /* END BASIC */
                                                   })

</script>

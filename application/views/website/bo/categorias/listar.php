
<!-- MAIN CONTENT -->
<div id="content">
    <div class="row">
        <div class="col-xs-12 col-sm-9 col-md-9 col-lg-9">
            <h1 class="page-title txt-color-blueDark">
                <a class="backHome" href="/bo"><i class="fa fa-home"></i> Menu</a>
                <span>
                    > <a href="/bo/altas/">Altas</a> 
                    > <a href="/bo/categorias"> Categorías </a>
                    >	Listar
                </span>
            </h1>
        </div>
    </div>
   

    <section id="widget-grid" class="">
        <!-- START ROW -->
        <div class="row">
            <!-- NEW COL START -->
            <article class="col-sm-12 col-md-12 col-lg-12">
                <!-- Widget ID (each widget will need unique ID)-->
                <div class="jarviswidget" id="wid-id-1" data-widget-editbutton="false" data-widget-custombutton="false" data-widget-colorbutton="false"	>
                    <header>
                        <span class="widget-icon"> <i class="fa fa-edit"></i> </span>
                        <h2>Categorías</h2>				

                    </header>

                    <!-- widget div-->
                    <div>

                        <!-- widget edit box -->
                        <div class="jarviswidget-editbox">
                            <!-- This area used as dropdown edit box -->

                        </div>
                        <!-- end widget edit box -->
                        <!-- widget content -->
                        <div class="widget-body">
                            <div class="tab-pane">

                                <div class="row col-xs-12 col-md-6 col-sm-4 col-lg-3 pull-right">
                                    <div class="col-xs-3 col-md-3 col-sm-3 col-lg-3">
                                        <center>
                                            <a title="Editar" style="cursor: pointer;" class="txt-color-blue"><i class="fa fa-pencil fa-3x"></i></a>
                                            <br>Editar
                                        </center>
                                    </div>
                                    <div class="col-xs-3 col-md-3 col-sm-3 col-lg-3">
                                        <center>	
                                            <a title="Eliminar" style="cursor: pointer;"" class="txt-color-red"><i class="fa fa-trash-o fa-3x"></i></a>
                                            <br>Eliminar
                                        </center>
                                    </div>
                                    <div class="col-xs-3 col-md-3 col-sm-3 col-lg-3">
                                        <center>	
                                            <a title="Desactivar" style="cursor: pointer;" class="txt-color-green"><i class="fa fa-square-o fa-3x"></i></a>
                                            <br>Desactivado
                                        </center>
                                    </div>
                                    <div class="col-xs-3 col-md-3 col-sm-3 col-lg-3">
                                        <center>
                                            <a title="Activar" style="cursor: pointer;" class="txt-color-green"><i class="fa fa-check-square-o fa-3x"></i></a>
                                            <br>Activado
                                        </center>
                                    </div>
                                </div>



                                <table id="dt_basic" class="table table-striped table-bordered table-hover" width="100%">
                                    <thead>			                
                                        <tr>
                                            <th>ID</th>
                                            <th data-hide="phone,tablet">Nombre</th>
                                            <th data-hide="phone,tablet">Estatus</th>
                                            <th> Acciones</th>
                                        </tr>
                                    </thead>
                                    <tbody>

                                        <?php foreach ($categorias as $categoria) {?>
                                        <tr>
                                            <td><?php echo $categoria->id; ?></td> 
                                            <td><?php echo $categoria->nombre; ?></td>
                                            <td><?php echo $categoria->estatus; ?></td>
                                            <td>
                                                <a title="Editar" style="cursor: pointer;" class="txt-color-blue" onclick="editar('<?php echo $categoria->id_grupo; ?>');"><i class="fa fa-pencil fa-3x"></i></a>
                                                <a title="Eliminar"  style="cursor: pointer;" class="txt-color-red" onclick="eliminar('<?php echo $categoria->id_grupo; ?>');"><i class="fa fa-trash-o fa-3x"></i></a>
                                                <?php if ($categoria->estatus == 'ACT') { ?>
                                                    <a title="Desactivar" style="cursor: pointer;" onclick="estado('DES', '<?php echo $categoria->id_grupo; ?>')" class="txt-color-green"><i class="fa fa-check-square-o fa-3x"></i></a>
                                                <?php } else { ?>
                                                    <a title="Activar" style="cursor: pointer;" onclick="estado('ACT', '<?php echo $categoria->id_grupo; ?>')" class="txt-color-green"><i class="fa fa-square-o fa-3x"></i></a>
                                                <?php } ?>
                                            </td>
                                        </tr>
                                        <?php }?>
                                    </tbody>
                                </table>
                            </div>

                        </div>
                    </div>
                    <!-- end widget content -->

                </div>
                <!-- end widget div -->
        </div>
        <!-- end widget -->
        </article>
        <!-- END COL -->
</div>
<div class="row">         
    <!-- a blank row to get started -->
    <div class="col-sm-12">
        <br />
        <br />
    </div>
</div>            
<!-- END ROW -->
</section>
<!-- end widget grid -->
</div>
<!-- END MAIN CONTENT -->
<script src="/template/js/plugin/dropzone/dropzone.min.js"></script>
<script src="/template/js/plugin/markdown/markdown.min.js"></script>
<script src="/template/js/plugin/markdown/to-markdown.min.js"></script>
<script src="/template/js/plugin/markdown/bootstrap-markdown.min.js"></script>
<script src="/template/js/plugin/datatables/jquery.dataTables.min.js"></script>
<script src="/template/js/plugin/datatables/dataTables.colVis.min.js"></script>
<script src="/template/js/plugin/datatables/dataTables.tableTools.min.js"></script>
<script src="/template/js/plugin/datatables/dataTables.bootstrap.min.js"></script>
<script src="/template/js/plugin/datatable-responsive/datatables.responsive.min.js"></script>
<script src="/template/js/validacion.js"></script>
<script type="text/javascript">

// DO NOT REMOVE : GLOBAL FUNCTIONS!

                                                                                                                            $(document).ready(function () {

                                                                                                                                $("#mymarkdown").markdown({
                                                                                                                                    autofocus: false,
                                                                                                                                    savable: false
                                                                                                                                })


                                                                                                                                /* BASIC ;*/
                                                                                                                                var responsiveHelper_dt_basic = undefined;
                                                                                                                                var responsiveHelper_datatable_fixed_column = undefined;
                                                                                                                                var responsiveHelper_datatable_col_reorder = undefined;
                                                                                                                                var responsiveHelper_datatable_tabletools = undefined;

                                                                                                                                var breakpointDefinition = {
                                                                                                                                    tablet: 1024,
                                                                                                                                    phone: 480
                                                                                                                                };

                                                                                                                                $('#dt_basic').dataTable({
                                                                                                                                    "sDom": "<'dt-toolbar'<'col-xs-12 col-sm-6'f><'col-sm-6 col-xs-12 hidden-xs'l>r>" +
                                                                                                                                            "t" +
                                                                                                                                            "<'dt-toolbar-footer'<'col-sm-6 col-xs-12 hidden-xs'i><'col-xs-12 col-sm-6'p>>",
                                                                                                                                    "autoWidth": true,
                                                                                                                                    "preDrawCallback": function () {
                                                                                                                                        // Initialize the responsive datatables helper once.
                                                                                                                                        if (!responsiveHelper_dt_basic) {
                                                                                                                                            responsiveHelper_dt_basic = new ResponsiveDatatablesHelper($('#dt_basic'), breakpointDefinition);
                                                                                                                                        }
                                                                                                                                    },
                                                                                                                                    "rowCallback": function (nRow) {
                                                                                                                                        responsiveHelper_dt_basic.createExpandIcon(nRow);
                                                                                                                                    },
                                                                                                                                    "drawCallback": function (oSettings) {
                                                                                                                                        responsiveHelper_dt_basic.respond();
                                                                                                                                    }
                                                                                                                                });

                                                                                                                                /* END BASIC */

                                                                                                                                /* BASIC ;*/
                                                                                                                                var responsiveHelper_dt_basic = undefined;
                                                                                                                                var responsiveHelper_datatable_fixed_column = undefined;
                                                                                                                                var responsiveHelper_datatable_col_reorder = undefined;
                                                                                                                                var responsiveHelper_datatable_tabletools = undefined;

                                                                                                                                var breakpointDefinition = {
                                                                                                                                    tablet: 1024,
                                                                                                                                    phone: 480
                                                                                                                                };

                                                                                                                                $('#dt_basic_paquete').dataTable({
                                                                                                                                    "sDom": "<'dt-toolbar'<'col-xs-12 col-sm-6'f><'col-sm-6 col-xs-12 hidden-xs'l>r>" +
                                                                                                                                            "t" +
                                                                                                                                            "<'dt-toolbar-footer'<'col-sm-6 col-xs-12 hidden-xs'i><'col-xs-12 col-sm-6'p>>",
                                                                                                                                    "autoWidth": true,
                                                                                                                                    "preDrawCallback": function () {
                                                                                                                                        // Initialize the responsive datatables helper once.
                                                                                                                                        if (!responsiveHelper_dt_basic) {
                                                                                                                                            responsiveHelper_dt_basic = new ResponsiveDatatablesHelper($('#dt_basic'), breakpointDefinition);
                                                                                                                                        }
                                                                                                                                    },
                                                                                                                                    "rowCallback": function (nRow) {
                                                                                                                                        responsiveHelper_dt_basic.createExpandIcon(nRow);
                                                                                                                                    },
                                                                                                                                    "drawCallback": function (oSettings) {
                                                                                                                                        responsiveHelper_dt_basic.respond();
                                                                                                                                    }
                                                                                                                                });

                                                                                                                                /* END BASIC */

                                                                                                                                pageSetUp();

                                                                                                                            })

                                                                                                                            function editar(id) {
                                                                                                                                $.ajax({
                                                                                                                                    type: "POST",
                                                                                                                                    url: "/bo/categorias/editar",
                                                                                                                                    data: {
                                                                                                                                        id: id
                                                                                                                                    }

                                                                                                                                })
                                                                                                                                        .done(function (msg) {
                                                                                                                                            bootbox.dialog({
                                                                                                                                                message: msg,
                                                                                                                                                title: 'Modificar Afiliado',
                                                                                                                                            });
                                                                                                                                        });//fin Done ajax
                                                                                                                            }

                                                                                                                            function eliminar(id) {

                                                                                                                                $.ajax({
                                                                                                                                    type: "POST",
                                                                                                                                    url: "/auth/show_dialog",
                                                                                                                                    data: {message: '¿ Esta seguro que desea Eliminar la categoria ?'},
                                                                                                                                })
                                                                                                                                        .done(function (msg)
                                                                                                                                        {
                                                                                                                                            bootbox.dialog({
                                                                                                                                                message: msg,
                                                                                                                                                title: 'Eliminar Categoria',
                                                                                                                                                buttons: {
                                                                                                                                                    success: {
                                                                                                                                                        label: "Aceptar",
                                                                                                                                                        className: "btn-success",
                                                                                                                                                        callback: function () {

                                                                                                                                                            $.ajax({
                                                                                                                                                                type: "POST",
                                                                                                                                                                url: "/bo/categorias/eliminar_categoria",
                                                                                                                                                                data: {id: id}
                                                                                                                                                            })
                                                                                                                                                                    .done(function (msg)
                                                                                                                                                                    {
                                                                                                                                                                        bootbox.dialog({
                                                                                                                                                                            message: msg,
                                                                                                                                                                            title: 'Atención',
                                                                                                                                                                            buttons: {
                                                                                                                                                                                success: {
                                                                                                                                                                                    label: "Aceptar",
                                                                                                                                                                                    className: "btn-success",
                                                                                                                                                                                    callback: function () {
                                                                                                                                                                                        location.href = "/bo/categorias/index";
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

                                                                                                                            function estado(estatus, id)
                                                                                                                            {

                                                                                                                                $.ajax({
                                                                                                                                    type: "POST",
                                                                                                                                    url: "/bo/categorias/cambiar_estado_categoria",
                                                                                                                                    data: {
                                                                                                                                        id: id,
                                                                                                                                        estado: estatus
                                                                                                                                    },
                                                                                                                                }).done(function (msg)
                                                                                                                                {
                                                                                                                                    location.href = "/bo/categorias/";

                                                                                                                                })
                                                                                                                            }
</script>

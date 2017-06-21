
<!-- MAIN CONTENT -->
<div id="content">
    <div class="row">
        <div class="col-xs-12 col-sm-9 col-md-9 col-lg-9">
            <h1 class="page-title txt-color-blueDark">
                <a class="backHome" href="/bo"><i class="fa fa-home"></i> Menu</a>
                <span>
                    > <a href="/bo/altas/">Altas</a> 
                    > <a href="/bo/categorias"> Categorías </a>
                    > Alta
                </span>
            </h1>
        </div>
    </div>
  

    <section id="widget-grid" class="">
        <!-- START ROW -->
        <div class="row">
            <!-- NEW COL START -->
            <article class="col-sm-12 col-md-12 col-lg-12">

                <div class="jarviswidget" id="wid-id-3" data-widget-editbutton="false" data-widget-custombutton="false">
                    <!-- widget options:
                            usage: <div class="jarviswidget" id="wid-id-0" data-widget-editbutton="false">
                            
                            data-widget-colorbutton="false"	
                            data-widget-editbutton="false"
                            data-widget-togglebutton="false"
                            data-widget-deletebutton="false"
                            data-widget-fullscreenbutton="false"
                            data-widget-custombutton="false"
                            data-widget-collapsed="true" 
                            data-widget-sortable="false"
                            
                    -->
                    <header>
                        <span class="widget-icon"> <i class="fa fa-edit"></i> </span>
                        <h2>Nueva Categoría</h2>				

                    </header>

                    <!-- widget div-->
                    <div>

                        <!-- widget edit box -->
                        <div class="jarviswidget-editbox">
                            <!-- This area used as dropdown edit box -->

                        </div>
                        <!-- end widget edit box -->

                        <!-- widget content -->
                        <div class="widget-body no-padding">

                            <form id="nueva" class="smart-form"   role="form" method="POST" action="/bo/categorias/crear_categoria">
                                <fieldset>
                                    <label class="input" required> Nombre
                                        <input style="width: 25rem;" type="text" name="nombre" placeholder="Nombre"class="form-control" required>
                                    </label>                                 
                                    <input  type="text" name="tipo" value="<?=$_GET['id']?>" placeholder="Nombre" class="hide" >
                                    Estatus
                                    <label class="select" style="width: 25rem;"> 
                                        <select style="width: 25rem;" name="estado" required>
                                            <option value="ACT">Activado</option>
                                            <option value="DES">Desactivado</option>
                                        </select> <i></i> </label>
                                    <br>
                                    <div class="row">
                                        <section  id="div_subir" style="width: 25rem;">

                                            <div style="width: 25rem;">
                                                <input type="submit" class="btn btn-success" style="margin-left: 66% ! important; width: 40%;" id="boton_subir" value="Agregar">
                                            </div>
                                        </section>
                                    </div>		
                                </fieldset>

                            </form>

                        </div>
                        <!-- end widget content -->

                    </div>
                    <!-- end widget div -->

                </div>
                <!-- end widget -->	
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
<script src="/template/js/plugin/jquery-form/jquery-form.min.js"></script>
<script src="/template/js/validacion.js"></script>
<script src="/template/js/plugin/fuelux/wizard/wizard.min.js"></script>
<script type="text/javascript">
    
    $( "#nueva" ).submit(function( event ) {
	event.preventDefault();
	iniciarSpinner();
	enviar();
    });

    
    function enviar() {

        $.ajax({
            type: "POST",
            url: "/bo/categorias/crear",
            data: $('#nueva').serialize()
        })
                .done(function (msg) {
                    bootbox.dialog({
			message: msg,
			title: 'ATENCION',
			buttons: {
				success: {
					label: "Aceptar",
					className: "btn-success",
					callback: function() {
							location.href="/bo/categorias/listar?id=<?=$_GET['id']?>";
							FinalizarSpinner();
					}
				}
			}
                    })
                });//fin Done ajax

    }
</script>

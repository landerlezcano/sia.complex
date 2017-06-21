
<!-- MAIN CONTENT -->
<div id="content">
	<div class="row">
		<div class="col-xs-12 col-sm-9 col-md-9 col-lg-9">
			<h1 class="page-title txt-color-blueDark">
				<a class="backHome" href="/bo"><i class="fa fa-home"></i> Menu</a> <span>
					> <a href="/bo/altas"> Alta </a> > <a href="/bo/cursos"> Cursos </a>
					> Formulario
				</span>
			</h1>
		</div>


	</div>
	<section id="widget-grid" class="">
		<!-- START ROW -->
		<div class="row">
			<!-- NEW COL START -->
			<article class="col-sm-12 col-md-12 col-lg-12">

				<div class="jarviswidget" id="wid-id-3"
					data-widget-editbutton="false" data-widget-custombutton="false">
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
						<span class="widget-icon"> <i class="fa fa-edit"></i>
						</span>
						<h2>Nuevo curso</h2>

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

							<form id="nueva" class="smart-form" role="form" method="POST"
								action="/bo/cursos/crear" enctype="multipart/form-data">

								<div class="col-md-3 col-xs-12">
									<fieldset>
										<legend>Datos Principales </legend>
										<label class="input">Nombre <input style="width: 25rem;"
											type="text" name="nombre" placeholder="Nombre"
											class="form-control" required>
										</label>

										<div class="row" style="width: 28rem;">
											<section class="col col-lg-12 col-md-12 col-sm-12 col-xs-12"
												id="busquedatodos">
												<label class="label">Descripcion</label> <label
													class="textarea"> <textarea required rows="3"
														class="custom-scroll" name="descripcion"></textarea>
												</label>
											</section>
										</div>

										<br />
										
										<div style="width: 25rem;">
											<label for="" class="select">Tipo de Oferta <select
												id="oferta" name="oferta" onChange="facultad()" required>
													<option value="" selected>-- Seleciona un tipo de Oferta --</option>
                                                <?php foreach ($oferta as $key) { ?>
                                                    <option
														value="<?= $key->id ?>"><?= $key->nombre ?></option>
                                                <?php } ?>
                                            </select>
											</label>
										</div>
										<br />
										<div style="width: 25rem;">
											<label for="" class="select">Facultad <select id="facultad"
												required name="facultad" onChange="cupos()">
													<option value="" selected>-- Seleciona una Facultad --</option>
                                                <?php foreach ($facultad as $key) { ?>
                                                    <option
														value="<?= $key->id ?>"><?= $key->nombre ?></option>
                                                <?php } ?>
                                            </select>
											</label>
										</div>
										<br />


									</fieldset>
								<!--</div>
								
								<div class="col-md-5 col-xs-12">
									 <fieldset id="imagenes">
										<legend> Galería de imagenes</legend>
										<small><cite title="Source Title">Para ver el archivo que va a
												cargar, pulse con el puntero en el boton de "Buscar"</cite></small>
										<hr/>
										<br/>
										<section class="col-md-6" style="width: 25rem;">
											<label class="label">Imagen 1 </label>
											<div class="input input-file">
												<span class="button"> <input class="imgGallery" name="img1"
													onchange="this.parentNode.nextSibling.value = this.value"
													type="file" multiple>Buscar
												</span><input id="imagen_mr"
													placeholder="Agregar alguna imágen" type="text" required>
											</div>

										</section>
										
									</fieldset>
									<div class="row">
											<section id="div_subir">
												<div class="pull-right">
													<input type="button" class="btn btn-primary"
														style="width: 100%;" id="newImg" value="Agregar">
												</div>
											</section>
										</div> -->
									<fieldset>
										<br />
										<div class="row">
											<section id="div_send ">
												<div class="pull-right">
													<input type="submit" class="btn btn-success"
														style="width: 100%;" id="boton_subir" value="Crear Curso">
												</div>
											</section>
										</div>
									</fieldset>
								</div>



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
				<br /> <br />
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

$('#newImg').click(nuevaImagen);

$('.costo').ready(checkPrecio);
$('.costo').click(checkPrecio);

var countImg = 0;

function nuevaImagen(){
	if(countImg==0){
		$('#div_subir').append('<div class="pull-right">'
				+'<input type="button" class="btn btn-danger"'
					+'style="width: 100%;" onclick="suprImagen()" value="Eliminar">'
			+'</div>');
		countImg++;
	}
	countImg++;
	
	$('#imagenes').append('<section id="img'+countImg+'"  class="col-md-6" style="width: 25rem;">'
			+'<label class="label">Imagen '+countImg+' </label>'
			+'<div class="input input-file">'
				+'<span class="button">' 
				+'<input class="imgGallery" name="img'+countImg+'"'
					+'onchange="this.parentNode.nextSibling.value = this.value"'
					+'type="file" multiple>Buscar'
				+'</span><input id="imagen_mr"'
					+'placeholder="Agregar alguna imágen" type="text" required>'					
			+'</div>'
		+'</section>');	
	
}

function suprImagen() {
    $("#img" + countImg + "").remove();
    countImg--;
}

function checkPrecio(){
    var valor = $('.costo:checked').val();
    
        if (valor == 1){ 
            $('#precio').html('');        
        }else if (valor == 2){
            $('#precio').html('<label class="input">Valor de la Entrada'
                            +'<input style="width: 25rem;" type="number" name="precio" min="0" placeholder="$ 0.00" class="form-control" required>'
                            +'</label>');
        }else if (valor ==3) {
            $('#precio').html('<label class="input">Minimo Valor de Donación'
                            +'<input style="width: 25rem;" type="number" name="precio" min="0" placeholder="$ 0.00" class="form-control" required>'
                            +'</label>');
        } 
                    
        
}
  
$( "#nueva" ).submit(function( event ) {
	event.preventDefault();
	iniciarSpinner();
	enviar();
});

function enviar(){

	var dataF = new FormData($("#nueva")[0]);	
	dataF.append('imgCount', countImg);
	
    //for (var pair of dataF.entries()) {
    //    console.log(pair[0]+ ': [' + pair[1] + ']'); 
    //}  
	
	$.ajax({
		type: "POST",
		url: "/bo/cursos/crear",
		data: dataF,
        cache: false,
        contentType: false,
        processData: false,
	}).done(function( msg ) {				
		bootbox.dialog({
			message: msg,
			title: 'ATENCION',
			buttons: {
				success: {
					label: "Aceptar",
					className: "btn-success",
					callback: function() {
							location.href="/bo/cursos/listar";
							FinalizarSpinner();
					}
				}
			}
		})
	});//fin Done ajax
}

$(function()
 {
 	a = new Date();
	año = a.getFullYear()-18;
	$( "#datepicker" ).datepicker({
	changeMonth: true,
	numberOfMonths: 2, 
	dateFormat:"yy-mm-dd",
	changeYear: true,
	yearRange: "0:+99",
	});
});

$(function()
 {
 	a = new Date();
	año = a.getFullYear()-18;
	$( "#datepicker2" ).datepicker({
	changeMonth: true,
	numberOfMonths: 2, 
	dateFormat:"yy-mm-dd",
	changeYear: true,
	yearRange: "0:+99",
	});
});

</script>

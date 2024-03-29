
<!-- MAIN CONTENT -->
<div id="content">
	<div class="row">
		<div class="col-xs-12 col-sm-9 col-md-9 col-lg-9">
			<h1 class="page-title txt-color-blueDark">

				<?php  if($type=='5'){?>
					<a class="backHome" href="/bol"><i class="fa fa-home"></i> Menu</a>
					<span>
					> <a href="/bo/logistico2/alta">Alta </a>
					> <a href="/bo/logistico2/producto">Producto Inventario</a>
					> Alta
					</span>
				 <?php }else if($type=='8'||$type=='9'){
					$index= ($type=='8') ? '/CEDI' : '/Almacen';?>
					<a class="backHome" href="<?=$index?>"><i class="fa fa-home"></i> Menu</a>
					<span> 
					> <a href="<?=$index?>/altas"> Altas</a>
					> <a href="/bo/logistico2/producto">Producto Inventario</a>
					> Alta
					</span>
				 <?php }else{?>
				 	<a class="backHome" href="/bo"><i class="fa fa-home"></i> Menu</a> 
				 	<span>
				 	> <a href="/bo/comercial">Comercial</a> 
					> <a href="/bo/comercial/mercancia"> Mercancias</a>
					> <a href="/bo/mercancia">Alta</a> 
					> Producto
					</span>
				<?php }?>

			</h1>
		</div>
	</div>
	<?php
	
if ($this->session->flashdata ( 'error' )) {
		echo '<div class="alert alert-danger fade in">
								<button class="close" data-dismiss="alert">
									×
								</button>
								<i class="fa-fw fa fa-check"></i>
								<strong>Error </strong> ' . $this->session->flashdata ( 'error' ) . '
			</div>';
	}
	?>	 
	<section id="widget-grid" class="">
		<!-- START ROW -->
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
						<h2>Mercancia</h2>

					</header>

					<!-- widget div-->
					<div>
						<div class="widget-body">
							<form method="POST" enctype="multipart/form-data"
								action="/bo/mercancia/CrearProducto" class="smart-form"
								name="form_product">
								<input type="text" class="hide"
									value="<?php echo $_GET['id']; ?>" name="tipo_mercancia">

								<fieldset>
									<legend>
										Datos del producto</span>
									</legend>
									<div id="form_mercancia">
										<div class="row">
											<fieldset>
												<section class="col col-2">
													<label class="input"> Nombre <input type="text"
														id="nombre_p" name="nombre" required>
													</label>
												</section>

												<section class="col col-2">
													<label class="input"> Concepto <input required type="text"
														id="concepto" name="concepto">
													</label>
												</section>
												<section class="col col-2">
													<label class="input"> Marca <input type="text" name="marca"
														id="marca">
													</label>
												</section>
												<section class="col col-2">
													<label class="input"> Código de barras <input type="number"
														min="1" name="codigo_barras" id="codigo_barras">
													</label>
												</section>
												<section class="col col-3">
													Categoria <label class="select"> <select name="red">
																<?foreach ($grupos as $grupo){?>
																	<option value="<?=$grupo->id_grupo?>">
																	<?= $grupo->descripcion." (".$grupo->red.")"?>
																	</option>
																<?}?>
																</select>
													</label>
												</section>
											</fieldset>
										</div>
										<div class="row">
											<fieldset>
												<section id="imagenes" class="col col-6">
												<label class="label">Imágen</label>
												<div class="input input-file">
													<span class="button"> <input id="img" name="img"
														onchange="this.parentNode.nextSibling.value = this.value"
														type="file" multiple>Buscar
													</span><input id="imagen_mr"
														placeholder="Agregar alguna imágen" type="text" required>
												</div>
												<small><cite title="Source Title">Para ver el archivo que va
														a cargar, pulse con el puntero en el boton de "Buscar"</cite></small>
												</section>
												<section class="col col-2">
													<label class="input"><span id="labelextra">Descuento del
															producto</span> <input required id="precio_promo"
														type="number" min="0" name="descuento"> </label>
												</section>
												<section class="col col-2">
													<label class="input"><span id="labelextra"><b>Mínimo de Inventario</b></span> <input required id="inventario"
														type="number" min="1" name="inventario"> </label>
												</section>
											</fieldset>
										</div>
										<div class="row">
											<section style="padding-left: 3em;" class="col col-6">
												Descripcion
												<textarea name="descripcion" style="max-width: 96%"
													id="mymarkdown"></textarea>
											</section>

											<section id="canal" class="col col-6">
												<label for=""><b>Comercialización</b></label>
												<hr /><br />
												<ul style="list-style:none">
												<?php 
												foreach ($canales as $canal){
													$readonly = '';//($canal->canal==1) ? '<h1><b>x</b><h1>' : '';
													echo '<li class="well col-md-4 text-center" style="height: 8em">
																<h4>'.$canal->nombre.'</h4>
																<h1>____</h1>'.$readonly.'
																<input type="checkbox" class="canal" name="canal[]" value="'.$canal->canal.'" checked="" />
															</li>';
												}
												?>
													
												</ul>
												
											</section>
										</div>
								
								<div class="row">
								<fieldset>
									<legend>Fisicos</legend>
									<section class="col col-2">
										<label class="input"> Peso <input required type="number"
											min="0" name="peso" id="peso">
										</label>
									</section>
									<section id="colonia" class="col col-2">
										<label class="input"> Alto <input type="number" min="0"
											name="alto" id="alto">
										</label>
									</section>
									<section id="municipio" class="col col-2">
										<label class="input"> Ancho <input type="number" min="0"
											name="ancho" id="ancho">
										</label>
									</section>
									<section id="municipio" class="col col-2">
										<label class="input"> Profundidad <input type="number" min="0"
											name="profundidad" id="profundidad">
										</label>
									</section>
									<section id="municipio" class="col col-2">
										<label class="input"> Diametro <input type="number" min="0"
											name="diametro" id="diametro">
										</label>
									</section>
								</fieldset>
								<fieldset id="moneda_field">
									<legend>Moneda y país</legend>
									<section class="col col-2">
										<label class="input"> Cantidad mínima de venta <input
											type="number" name="min_venta" min="1" id="min_venta"
											required>
										</label>
									</section>
									<section class="col col-2">
										<label class="input"> Cantidad máxima de venta <input
											type="number" name="max_venta" min="1" id="max_venta"
											required>
										</label>
									</section>
									<section class="col col-2">
										<label class="input"> Costo real <input type="number"
											name="real" id="real" onchange="calcular_precio_total()" step="0.0001"
											min="1" required>
										</label>
									</section>
									<section class="col col-2">
										<label class="input"> Costo distribuidores <input
											type="number" name="costo" id="costo"
											onchange="calcular_precio_total()" min="1" step="0.0001" required>
										</label>
									</section>
									<section class="col col-2">
										<label class="input"> Costo publico <input type="number"
											name="costo_publico" id="costo_publico"
											onchange="calcular_precio_total()" min="1" step="0.0001" required>
										</label>
									</section>
									<section class="col col-2">
										<label class="input"> Tiempo mínimo de entrega <input
											placeholder="En días" type="number" name="entrega" min="1"
											id="entrega">
										</label>
									</section>

									<section class="col col-3">
										Proveedor <label class="select"> <select name="proveedor"
											required>
																<?
																
foreach ( $proveedores as $key ) {
																	?>
																<option value="<?=$key->user_id?>"><?=$key->nombre." ".$key->apellido?></option>	
																<?}?>
															</select>
										</label>
									</section>

									<section class="col col-3">
										<label class="input"> Puntos comisionables <input
											type="number" min="0" max="" name="puntos_com"
											id="puntos_com" required>
										</label>
									</section>

									<legend>Impuestos</legend>
									<fieldset>
										<div class="row" id="impuesto_agregar">


											<section class="col col-2">
												País de la mercancía <label class="select"> <select
													id="pais" name="pais" onChange="select_pais()" required>
														<option value="-" selected>-- Seleciona un pais --</option>
																<?
																
foreach ( $pais as $key ) {
																	?>
																<option value="<?=$key->Code?>">
																	<?=$key->Name?>
																</option>
																<?}?>
															</select>
												</label>
											</section>
											<!--<section class="col col-2" id="impuesto">Impuesto
														<label class="select">
															<select id="id_impuesto[]" name="id_impuesto[]" onclick="calcular_precio_total()">
																
															</select>
														</label>-->
											<a style="cursor: pointer;" onclick="add_impuesto()">Agregar
												impuesto<i class="fa fa-plus"></i>
											</a>
											<!--</section>-->
											<section class="col col-2">
												Requiere especificación
												<div class="inline-group">
													<label class="radio"> <input type="radio" value="1"
														name="iva" onchange="calcular_precio_total()"> <i></i>con
														IVA
													</label> <label class="radio"> <input type="radio"
														value="0" onchange="calcular_precio_total()" name="iva"
														checked=""> <i></i>más IVA
													</label>
												</div>
											</section>
										</div>
										<div class="row">
											<section class="col col-2">
												<label class="input"> Costo real con IVA <input type="text"
													min="1" max="" name="real_iva" id="real_iva" disabled
													value="">
												</label>
											</section>
											<section class="col col-2">
												<label class="input"> Costo distribuidores con IVA <input
													type="text" min="1" max="" name="distribuidores_iva"
													id="distribuidores_iva" disabled>
												</label>
											</section>
											<section class="col col-2">
												<label class="input"> Costo público con IVA <input
													type="text" min="1" max="" name="publico_iva"
													id="publico_iva" disabled>
												</label>
											</section>
										</div>
									</fieldset>
								</fieldset>
								<fieldset>
									<legend>Extra</legend>
									<section class="col col-2">
										Requiere instalación
										<div class="inline-group">
											<label class="radio"> <input type="radio" value="1"
												name="instalacion" checked=""> <i></i>Si
											</label> <label class="radio"> <input type="radio" value="0"
												name="instalacion"> <i></i>No
											</label>
										</div>
									</section>
									<section class="col col-2">
										Requiere especificación
										<div class="inline-group">
											<label class="radio"> <input type="radio" value="1"
												name="especificacion" checked=""> <i></i>Si
											</label> <label class="radio"> <input type="radio" value="0"
												name="especificacion"> <i></i>No
											</label>
										</div>
									</section>
									<section class="col col-2">
										Requiere producción
										<div class="inline-group">
											<label class="radio"> <input type="radio" value="1"
												name="produccion" checked=""> <i></i>Si
											</label> <label class="radio"> <input type="radio" value="0"
												name="produccion"> <i></i>No
											</label>
										</div>
									</section>
									<section class="col col-2">
										Producto de importación
										<div class="inline-group">
											<label class="radio"> <input type="radio" value="1"
												name="importacion" checked=""> <i></i>Si
											</label> <label class="radio"> <input type="radio" value="0"
												name="importacion"> <i></i>No
											</label>
										</div>
									</section>
									<section class="col col-2">
										Producto de sobrepedido
										<div class="inline-group">
											<label class="radio"> <input type="radio" value="1"
												name="sobrepedido" checked=""> <i></i>Si
											</label> <label class="radio"> <input type="radio" value="0"
												name="sobrepedido"> <i></i>No
											</label>
										</div>
									</section>
								</fieldset>
						
						</div>
					</div>
					</fieldset>
					<footer>
						<button type="submit" class="btn btn-primary">Agregar</button>
					</footer>
					</form>
				</div>
		
		</div>
		<!-- end widget div -->

		</article>
		<!-- END COL -->

</div>

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
<script
	src="/template/js/plugin/datatables/dataTables.tableTools.min.js"></script>
<script src="/template/js/plugin/datatables/dataTables.bootstrap.min.js"></script>
<script
	src="/template/js/plugin/datatable-responsive/datatables.responsive.min.js"></script>
<script src="/template/js/validacion.js"></script>
<script type="text/javascript">

// DO NOT REMOVE : GLOBAL FUNCTIONS!
var i = 0;

/*$('.canal').each(function() {
		// es el valor del checkbox correspondiente
		if($(this).val()==1){
			$(this).hide();
		}
});*/



$(document).ready(function() {
	
	$("#mymarkdown").markdown({
		autofocus:false,
		savable:false
	})


	/* BASIC ;*/
	var responsiveHelper_dt_basic = undefined;
	var responsiveHelper_datatable_fixed_column = undefined;
	var responsiveHelper_datatable_col_reorder = undefined;
	var responsiveHelper_datatable_tabletools = undefined;

	var breakpointDefinition = {
		tablet : 1024,
		phone : 480
	};

	$('#dt_basic').dataTable({
		"sDom": "<'dt-toolbar'<'col-xs-12 col-sm-6'f><'col-sm-6 col-xs-12 hidden-xs'l>r>"+
		"t"+
		"<'dt-toolbar-footer'<'col-sm-6 col-xs-12 hidden-xs'i><'col-xs-12 col-sm-6'p>>",
		"autoWidth" : true,
		"preDrawCallback" : function() {
				// Initialize the responsive datatables helper once.
				if (!responsiveHelper_dt_basic) {
					responsiveHelper_dt_basic = new ResponsiveDatatablesHelper($('#dt_basic'), breakpointDefinition);
				}
			},
			"rowCallback" : function(nRow) {
				responsiveHelper_dt_basic.createExpandIcon(nRow);
			},
			"drawCallback" : function(oSettings) {
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
		tablet : 1024,
		phone : 480
	};

	$('#dt_basic_paquete').dataTable({
		"sDom": "<'dt-toolbar'<'col-xs-12 col-sm-6'f><'col-sm-6 col-xs-12 hidden-xs'l>r>"+
		"t"+
		"<'dt-toolbar-footer'<'col-sm-6 col-xs-12 hidden-xs'i><'col-xs-12 col-sm-6'p>>",
		"autoWidth" : true,
		"preDrawCallback" : function() {
				// Initialize the responsive datatables helper once.
				if (!responsiveHelper_dt_basic) {
					responsiveHelper_dt_basic = new ResponsiveDatatablesHelper($('#dt_basic'), breakpointDefinition);
				}
			},
			"rowCallback" : function(nRow) {
				responsiveHelper_dt_basic.createExpandIcon(nRow);
			},
			"drawCallback" : function(oSettings) {
				responsiveHelper_dt_basic.respond();
			}
		});

	/* END BASIC */

	pageSetUp();

})
function new_user()
{
	var ids=new Array(
		"#username",
		"#email",
		"#password",
		"#confirm_password",
		"#nombre",
		"#apellido",
		"#datepicker",
		"#pais",
		"#cp",
		"#calle"
		);
	var mensajes=new Array(
		"Por favor ingresa un nombre de usuario",
		"Por favor ingresa un correo electronico",
		"Por favor ingresa una contraseña",
		"Por favor confirma la contraseña",
		"Por favor ingresa tu nombre",
		"Por favor ingresa tu apellido",
		"Por favor ingresa tu fecha de nacimineto",
		"Por favor especifica tu pais",
		"Por favor ingresa tu codigo postal",
		"Por favor ingresa tu dirección"
		);
	var id_ml=new Array(
		"#email"
		);
	var eml_mns=new Array(
		"Por favor ingrese un correo valido"
		);
	var psswrds=new Array(
		"#password",
		"#confirm_password"
		);
	var id_tamano=Array(
		"#cp"
		);
	var mensaje_tamano=Array(
		"El codigo postal debe de tener al menos 5 caracteres"
		);
	var tamano_min=Array(
		"5"
		);
	var tamano_max=Array(
		"10"
		);
	var id_fecha=Array(
		"#datepicker"
		);
	var mensaje_fecha=Array(
		"El formato de al fecha es incorrecto (aaaa-mm-dd)"
		);
	var ids_esp=new Array(
		"#username"
		);
	var mensajes_esp=new Array(
		"El nombre de usuario no puede contener espacios en blanco"
		);
	
	var validacion=valida_vacios(ids,mensajes);
	var val_espacios=valida_espacios(ids_esp,mensajes_esp);
	var val_email=valida_correo(id_ml,eml_mns);
	var val_psswrds=valida_psswrds(psswrds,"Las contraseñas deben de ser iguales");
	var val_tamano=valida_tamano(id_tamano,tamano_min,tamano_max,mensaje_tamano);
	var val_fecha=valida_fecha(id_fecha,mensaje_fecha);
	if(val_espacios&&validacion&&val_email&&val_psswrds&&val_tamano&&val_fecha)
	{
		$("#afiliar").remove();
		$("#footer").append('<div class="progress progress-sm progress-striped active"><div id="progress" class="progress-bar bg-color-darken"  role="progressbar" style=""></div></div>');
		$.ajax({
			type: "POST",
			url: "/auth/register",
			data: $('#register').serialize()
		})
		.done(function( msg ) {
			$("#progress").attr('style','width: 40%');
			var email=$("#email").val();
			$("#checkout-form").append("<input value='"+email+"' type='hidden' name='mail_important'>");
			$.ajax({
				type: "POST",
				url: "/bo/admin/new_user",
				data: $('#checkout-form').serialize()
			})
			.done(function( msg ) {
				$("#progress").attr('style','width: 100%');
				bootbox.dialog({
					message: "El usuario ha sido registrado",
					title: "Atención",
					buttons: {
						success: {
							label: "Ok!",
							className: "btn-success",
							callback: function() {
								location.href="";
							}
						}
					}
				});
			});
		});
	}	
}

function codpos()
{
	var pais = $("#pais").val();
	if(pais=="MEX")
	{
		var cp=$("#cp").val();
		$.ajax({
			type: "POST",
			url: "/bo/admin/cp",
			data: {cp: cp},
		})
		.done(function( msg )
		{
			$("#colonia").remove();
			$("#municipio").remove();
			$("#estado").remove();
			$("#dir").append(msg);
		})
	}
}
function codpos_proveedor()
{
	var pais = $("#pais_proveedor").val();
	if(pais=="MEX")
	{
		var cp=$("#cp_proveedor").val();
		$.ajax({
			type: "POST",
			url: "/bo/admin/cp_proveedor",
			data: {cp: cp},
		})
		.done(function( msg )
		{
			$("#colonia_proveedor").remove();
			$("#municipio_proveedor").remove();
			$("#estado_proveedor").remove();
			$("#dir_proveedor").append(msg);
		})
	}
}
function use_username()
{
	$("#msg_usuario").remove();
	var username=$("#username").val();

	$.ajax({
		type: "POST",
		url: "/bo/admin/use_username",
		data: {username: username},
	})
	.done(function( msg )
	{
		$("#usuario").append("<p id='msg_usuario'>"+msg+"</msg>");
	});
}
function use_mail()
{
	$("#msg_correo").remove();
	var mail=$("#email").val();
	$.ajax({
		type: "POST",
		url: "/bo/admin/use_mail",
		data: {mail: mail},
	})
	.done(function( msg )
	{
		$("#correo").append("<p id='msg_correo'>"+msg+"</msg>")
	});
}
function agregar(tipo)
{
	if(tipo==1)
	{
		$("#tel").append("<section class='col col-3'><label class='input'> <i class='icon-prepend fa fa-mobile'></i><input type='tel' name='movil[]' placeholder='(999) 99-99-99-99-99'></label></section>");
	}
	else
	{
		$("#tel").append("<section class='col col-3'><label class='input'> <i class='icon-prepend fa fa-phone'></i><input type='tel' name='fijo[]' placeholder='(999) 99-99-99-99-99'></label></section>");
	}
}
function agregar1(tipo)
{
	if(tipo==1)
	{
		$("#tel1").append("<section class='col col-3'><label class='input'> <i class='icon-prepend fa fa-mobile'></i><input type='tel' name='movil[]' placeholder='(999) 99-99-99-99-99'></label></section>");
	}
	else
	{
		$("#tel1").append("<section class='col col-3'><label class='input'> <i class='icon-prepend fa fa-phone'></i><input type='tel' name='fijo[]' placeholder='(999) 99-99-99-99-99'></label></section>");
	}
}
$(function()
{
	$( "#datepicker" ).datepicker({
		changeMonth: true,
		numberOfMonths: 2,
		dateFormat:"yy-mm-dd",
		defaultDate: "1970-01-01",
		changeYear: true
	});
});
$(function()
{
	$( "#datepicker1" ).datepicker({
		changeMonth: true,
		numberOfMonths: 2,
		dateFormat:"yy-mm-dd",
		defaultDate: "1970-01-01",
		changeYear: true
	});
});

function new_product()
{
	$('#prods').append('<section class="col col-8">Productos'
		+'<label class="select">'
		+'<select class="custom-scroll"  name="producto[]">'
		+'<option value="0">Ninguno</option>'
		+'<?foreach ($producto as $key){?>'
		+'<option value="<?=$key->id_mercancia?>">'
		+'<?=$key->nombre?></option>'
		+'<?}?>'
		+'</select>'
		+'</label>'
		+'</section>'
		+'<section class="col col-4">'
		+'<label class="input">Cantidad de productos'
		+'<input type="number" min="1" name="n_productos[]">'
		+'</label>'
		+'</section>');
}
function new_service()
{
	$('#servs').append('<section class="col col-8">Servicios'
		+'<label class="select">'
		+'<select class="custom-scroll" name="servicio[]">'
		+'<option value="0">Ninguno</option>'
		+'<?foreach ($servicio as $key){?>'
		+'<option value="<?=$key->id_mercancia?>">'
		+'<?=$key->nombre?></option>'
		+'<?}?>'
		+'</select>'
		+'</label>'
		+'</section>'
		+'<section class="col col-4">'
		+'<label class="input">Cantidad de servicios'
		+'<input type="number" min="1" name="n_servicios[]">'
		+'</label>'
		+'</section>');
}
function new_grupo()
{
	bootbox.dialog({
		message: "<label>Nombre del grupo</label><input id='desc'  type='text'/>",
		title: 'Agregar grupo',
		buttons: {
			success: {
				label: "Agregar",
				className: "btn-success",
				callback: function() {
					var desc=$("#desc").val()
					$.ajax({
						type: "POST",
						url: "/bo/admin/new_grupo",
						data: {descripcion: desc},
					})
					.done(function( msg )
					{
						bootbox.dialog({
							message: "El grupo fue añadido con exito",
							title: 'Atención',
							buttons: {
								success: {
									label: "Ok",
									className: "btn-success",
									callback: function() {

									}
								}
							}
						})
						location.href='';
					})
				}
			}
		}
	})
}

function new_impuesto()
{
	bootbox.dialog({
		message: "<label>Nombre del impuesto</label><input id='desc'  type='text'/><br>br><label>Porcentaje de impuesto</label><input id='porc'  type='text'/>",
		title: 'Agregar grupo',
		buttons: {
			success: {
				label: "Agregar",
				className: "btn-success",
				callback: function() {
					var desc=$("#desc").val()
					var porc=$("#porc").val()
					$.ajax({
						type: "POST",
						url: "/bo/admin/new_impuesto",
						data: {descripcion: desc, porcentaje: porc},
					})
					.done(function( msg )
					{
						bootbox.dialog({
							message: "El impuesto fue añadido con exito",
							title: 'Atención',
							buttons: {
								success: {
									label: "Ok",
									className: "btn-success",
									callback: function() {

									}
								}
							}
						})
						location.href='';
					})
				}
			}
		}
	})
}
function kill_impuesto()
{
	bootbox.dialog({
		message: "<form class='smart-form'><label class='select text-center'><select id='imp_sel'><? foreach($impuesto as $imp){?><option value='<?=$imp->id_impuesto?>'><?=$imp->descripcion?> (<?=$imp->porcentaje?> %)</option><?}?></select></label></form>",
		title: 'Eliminar grupo',
		buttons: {
			success: {
				label: "Eliminar",
				className: "btn-danger",
				callback: function() {
					var id_g=$("#imp_sel").val()
					$.ajax({
						type: "POST",
						url: "/bo/admin/kill_impuesto",
						data: {id: id_g},
					})
					.done(function( msg )
					{
						bootbox.dialog({
							message: "El impuesto fue eliminado con exito",
							title: 'Atención',
							buttons: {
								success: {
									label: "Ok",
									className: "btn-success",
									callback: function() {

									}
								}
							}
						})
						location.href='';
					})
				}
			}
		}
	})
}
function dato_pais(codigo,nombre)
{

	$.ajax({
		type: "POST",
		url: "/bo/admin/dato_pais",
		data: {pais: codigo},
	})
	.done(function( msg )
	{
		bootbox.dialog({
			message: msg,
			title: nombre,
			buttons: {
				success: {
					label: "Aceptar",
					className: "btn-success",
					callback: function() {

						$.ajax({
							type: "POST",
							url: "/bo/admin/actualiza_pais",
							data: $("#"+codigo).serialize(),
						})
						.done(function( msg )
						{
							bootbox.dialog({
								message: "Se han actualizado los cambios",
								title: nombre,
								buttons: {
									success: {
										label: "Aceptar",
										className: "btn-success",
										callback: function() {
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
					callback: function() {

					}
				}
			}
		})
	});
}
function dato_pais_multiple()
{
	/*bootbox.dialog({
		message: "Espere mientras se procesan los datos",
		title: "Espere",
		timeOut : 1000,
	})//fin done ajax*/

$.ajax({
	type: "POST",
	url: "/bo/admin/dato_pais_multiple",
	data: $("#multiple_pais").serialize(),
})
.done(function( msg )
{
	bootbox.dialog({
		message: msg,
		title: "Editar",
		buttons: {
			success: {
				label: "Aceptar",
				className: "btn-success",
				callback: function() {
				/*bootbox.dialog({
					message: "Espere mientras se procesan los datos",
					title: "Espere",
				})//fin done ajax*/
	$.each( $('.pais_check:checked'), function( i, val ) {

				  	
				  	$.ajax({
				  		type: "POST",
				  		url: "/bo/admin/actualiza_pais",
				  		data: $("#"+$(val).val()).serialize(),
				  	})
				  	.done(function( msg )
				  	{
					});//Fin callback bootbox

				  });
	bootbox.dialog({
		message: "Se han realizado los cambios con exito",
		title: "Prueba",
		buttons: {
			success: {
				label: "Aceptar",
				className: "btn-success",
				callback: function() {
				}
			}
		}
					})//fin done ajax
}
},
danger: {
	label: "Cancelar!",
	className: "btn-danger",
	callback: function() {

	}
}
}
})
});
}
function editar(id_merc)
{
	$.ajax({
		type: "POST",
		url: "/bo/admin/edit_merc",
		data: {id: id_merc},
	})
	.done(function( msg )
	{
		bootbox.dialog({
			message: msg,
			title: 'Edicion',
			buttons: {
				success: {
					label: "Aceptar",
					className: "btn-success",
					callback: function() {
						$("#update_merc").submit();
					}
				}
			}
	})//fin done ajax
	});//Fin callback bootbox
}
function eliminar(id)
{
	bootbox.dialog({
		message: "Confirme eliminacion(esta acción no se puede deshacer)",
		title: "Eliminar",
		buttons: {
			success: {
				label: "Aceptar",
				className: "btn-success",
				callback: function() {

					$.ajax({
						type: "POST",
						url: "/bo/admin/del_merc",
						data: {id: id},
					})
					.done(function( msg )
					{
						bootbox.dialog({
							message: "Se ha eliminado la mercancia",
							title: 'Alerta',
							buttons: {
								success: {
									label: "Aceptar",
									className: "btn-success",
									callback: function() {
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
				callback: function() {

				}
			}
		}
	})
}
function estatus(tipo,id)
{
	if (tipo==1){
		bootbox.dialog({
			message: "Confirme que desea activar en carrito de compra",
			title: "Activar",
			buttons: {
				success: {
					label: "Aceptar",
					className: "btn-success",
					callback: function() {

						$.ajax({
							type: "POST",
							url: "/bo/admin/estado_mercancia",
							data: {tipo: tipo, id: id},
						})
						.done(function( msg )
						{
							bootbox.dialog({
								message: "Se ha activado el producto",
								title: 'Activar',
								buttons: {
									success: {
										label: "Aceptar",
										className: "btn-success",
										callback: function() {
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
					callback: function() {

					}
				}
			}
		})
	}
	else
	{
		bootbox.dialog({
			message: "Confirme que desea desactivar en carrito de compra",
			title: "Descativar",
			buttons: {
				success: {
					label: "Aceptar",
					className: "btn-success",
					callback: function() {

						$.ajax({
							type: "POST",
							url: "/bo/admin/estado_mercancia",
							data: {tipo: tipo, id: id},
						})
						.done(function( msg )
						{
							bootbox.dialog({
								message: "Se ha desactivado el producto",
								title: 'Descativar',
								buttons: {
									success: {
										label: "Aceptar",
										className: "btn-success",
										callback: function() {
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
					callback: function() {

					}
				}
			}
		})
	}
}
function new_empresa()
{
	bootbox.dialog({
		message: '<form id="form_empresa" method="post" action="/bo/admin/new_empresa" class="smart-form">'
		+'<fieldset>'
		+'<legend>Información de cuenta</legend>'
		+'<section id="usuario" class="col col-6">'
		+'<label class="input">Razón social'
		+'<input required type="text" name="nombre" placeholder="Empresa">'
		+'</label>'
		+'</section>'
		+'<section id="usuario" class="col col-6">'
		+'<label class="input">Correo electrónico'
		+'<input required type="email" name="email">'
		+'</label>'
		+'</section>'
		+'<section id="usuario" class="col col-6">'
		+'<label class="input">Sítio web'
		+'<input required type="url" name="site">'
		+'</label>'
		+'</section>'
		+'<section class="col col-6">Regimen fiscal'
		+'<label class="select">'
		+'<select class="custom-scroll" name="regimen">'
		+'<?foreach ($regimen as $key){?>'
		+'<option value="<?=$key->id_regimen?>">'
		+'<?=$key->abreviatura." ".$key->descripcion?></option>'
		+'<?}?>'
		+'</select>'
		+'</label>'
		+'</section>'
		+'</fieldset>'
		+'<fieldset>'
		+'<legend>Dirección de la empresa</legend>'
		+'<div id="dir" class="row">'
		+'<section class="col col-6">'
		+'País'
		+'<label class="select">'
		+'<select id="pais" required name="pais">'
		+'<?foreach ($pais as $key){?>'
		+'<option value="<?=$key->Code?>">'
		+'<?=$key->Name?>'
		+'</option>'
		+'<?}?>'
		+'</select>'
		+'</label>'
		+'</section>'
		+'<section class="col col-6">'
		+'<label class="input">'
		+'Código postal'
		+'<input required  type="text" id="cp" name="cp">'
		+'</label>'
		+'</section>'
		+'<section class="col col-6">'
		+'<label class="input">'
		+'Dirección domicilio'
		+'<input required type="text" name="calle">'
		+'</label>'
		+'</section>'
		+'<section class="col col-6">'
		+'<label class="input">'
		+'Número interior'
		+'<input required type="text" name="interior">'
		+'</label>'
		+'</section>'
		+'<section class="col col-6">'
		+'<label class="input">'
		+'Número exterior'
		+'<input required type="text" name="exterior">'
		+'</label>'
		+'</section>'
		+'<section id="colonia" class="col col-6">'
		+'<label class="input">'
		+'Ciudad'
		+'<input type="text" name="colonia" >'
		+'</label>'
		+'</section>'
		+'<section id="municipio" class="col col-6">'
		+'<label class="input">'
		+'Provincia'
		+'<input type="text" name="municipio" >'
		+'</label>'
		+'</section>'
		+'</div>'
		+'</fieldset>'
		+'</form>',
		title: "Editar",
		buttons: {
			submit: {
				label: "Aceptar",
				className: "btn-success",
				callback: function() {

					$.ajax({
						type: "POST",
						url: "/bo/admin/new_empresa",
						data: $("#form_empresa").serialize(),
					})
					.done(function( msg )
					{
						bootbox.dialog({
							message: "Se agregado la empresa",
							title: 'Empresa',
							buttons: {
								success: {
									label: "Aceptar",
									className: "btn-success",
									callback: function() {
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
				callback: function() {

				}
			}
		}
	})
}
function agregar_cuenta()
{
	
	$("#cuenta").append('<section class="col col-3">'
		+'<label class="input">CLABE'
		+'<input required name="clabe[]" placeholder="02112312345678901" type="text">'
		+'</label>'
		+'</section>');
}
function check_keyword()
{
	$("#msg_key").remove();
	$("#key_").append('<i id="ajax_" class="icon-append fa fa-spinner fa-spin"></i>');

	var keyword=$("#keyword").val();
	$.ajax({
		type: "POST",
		url: "/ov/perfil_red/use_keyword",
		data: {keyword: keyword},
	})
	.done(function( msg )
	{
		$("#msg_key").remove();
		$("#key").append("<p id='msg_key'>"+msg+"</msg>");
		$("#ajax_").remove();
	});
}
function check_keyword_co()
{
	$("#msg_key_co").remove();
	$("#key_1").append('<i id="ajax_1" class="icon-append fa fa-spinner fa-spin"></i>');
	var keyword=$("#keyword_co").val();
	$.ajax({
		type: "POST",
		url: "/ov/perfil_red/use_keyword",
		data: {keyword: keyword},
	})
	.done(function( msg )
	{
		$("#msg_key_co").remove();
		$("#key_co").append("<p id='msg_key_co'>"+msg+"</msg>");
		$("#ajax_1").remove();
	});
}
function new_proveedor()
{
	$.ajax({
		type: "POST",
		url: "/auth/register",
		data: $('#register1').serialize()
	})
	.done(function( msg ) {
		var email=$("#email1").val();
		$("#proveedor").append("<input value='"+email+"' type='hidden' name='mail_important'>");
		$.ajax({
			type: "POST",
			url: "/bo/admin/new_proveedor",
			data: $('#proveedor').serialize()
		})
		.done(function( msg ) {
			bootbox.dialog({
				message: "Se ha afiliado al usuario",
				title: "Atención",
				buttons: {
					success: {
						label: "Ok!",
						className: "btn-success",
						callback: function() {
							location.href="";
						}
					}
				}
			});
		});
	});
}
function use_username1()
{
	$("#msg_usuario1").remove();
	var username=$("#username1").val();
	$.ajax({
		type: "POST",
		url: "/bo/admin/use_username",
		data: {username: username},
	})
	.done(function( msg )
	{
		$("#usuario1").append("<p id='msg_usuario1'>"+msg+"</msg>")
	});
}
function use_mail1()
{
	$("#msg_correo1").remove();
	var mail=$("#email1").val();
	$.ajax({
		type: "POST",
		url: "/bo/admin/use_mail",
		data: {mail: mail},
	})
	.done(function( msg )
	{
		$("#correo1").append("<p id='msg_correo1'>"+msg+"</msg>")
	});
}
function add_impuesto()
{
	var code=	'<div id="'+i+'"><section class="col col-2" id="impuesto">Impuesto'
	+'<label class="select">'
	+'<select name="id_impuesto[]" id="id_impuesto[]" onclick="calcular_precio_total()">'
	+'<option value="a0">Ninguna</option>'
	+'</select>'
	+'</label>'
	+'<a class="txt-color-red" onclick="dell_impuesto('+i+')" style="cursor: pointer;">Eliminar <i class="fa fa-minus"></i></a>'
	+'</section></div>';
	$("#impuesto_agregar").append(code);
	ImpuestosPais2(i);
	calcular_precio_total();
	i = i + 1
}

function dell_impuesto(id)
{	
	$("#"+id+"").remove();
	calcular_precio_total();
	
}

function add_impuesto_boot()
{
	var code=	'<section class="col col-6">Impuesto'
	+'<label class="select">'
	+'<select name="id_impuesto[]">'
	<?
	
foreach ( $impuesto as $key ) {
		echo "+'<option value=" . $key->id_impuesto . ">" . $key->descripcion . " " . $key->porcentaje . "%" . "</option>'";
	}
	?>
	+'</select>'
	+'</label>'
	+'<a class="btn btn-danger">Eliminar</a>'
	+'</section>';
	$("#moneda_field_boot").append(code);
}
$("#mercancia").submit(function(event){
	var tipo_merc=$("#tipo_mercancia").val();
	if(tipo_merc==1)
	{
		var ids=Array(
			"#nombre_p",
			"#concepto",
			"#marca",
			"#codigo_barras",
			"#mymarkdown",
			"#min_venta",
			"#max_venta",
			"#real",
			"#costo",
			"#costo_publico",
			"#entrega",
			"#puntos_com"
			);
		var mensajes=Array(
			"Por favor ingresa un nombre del producto",
			"Por favor ingresa un concepto",
			"Por favor ingresa una marca",
			"Por favor ingres el codigo de barras",
			"Por favor intriduzca una descripcion",
			"Por favor especifica la canidad minima de venta",
			"Por favor especifica la cantidad maxima de venta",
			"Por favor especifica el costo real",
			"Por favor especifica el costo",
			"Por favor especifica el costo publico",
			"Por favor epsecifica un tiempo de entrega",
			"Por favor especifica la cantidad de puntos comisionables"
			);
		var id_entero=Array(
			"#codigo_barras",
			"#min_venta",
			"#max_venta",
			"#entrega"
			);
		var mensaje_entero=Array(
			"El codigo de barras debe contener solo numeros",
			"El minimo de venta debe de ser entero",
			"El maximo de venta debe de ser entero",
			"El tiempo de entrega debe de ser un numero entero"
			);
		var ids_esp=Array(
			"#codigo_barras"
			);
		var mensajes_esp=Array(
			"El codigo de barras no puede contener espacios en blanco"
			);
		var id_dec=Array(
			"#peso",
			"#alto",
			"#ancho",
			"#profundidad",
			"#diametro",
			"#real",
			"#costo",
			"#costo_publico"
			);
		var msj_dec=Array(
			"El peso debe de ser un numero",
			"El alto debe de ser un numero",
			"El anchp debe de ser un numero",
			"La profundidad debe de ser un numero",
			"El diametro debe de ser un numero",
			"El costo real debe de ser un numero",
			"El costo debe de ser un numero",
			"El costo_publico debe de ser un numero"
			);

		var validacion=valida_vacios(ids,mensajes);
		var val_espacios=valida_espacios(ids_esp,mensajes_esp);
		var val_email=true;
		var val_psswrds=true;
		var val_tamano=true;
		var val_entero=valida_entero(id_entero,mensaje_entero);
		var val_fecha=true;
		//var val_decimales=valida_decimales(id_dec, msj_dec);	

	}
	if(tipo_merc==2)
	{
		var ids=new Array(
			"#nombre_s",
			"#concepto",
			"#startdate",
			"#finishdate",
			"#mymarkdown",
			"#real",
			"#costo",
			"#costo_publico",
			"#entrega",
			"#puntos_com"
			);
		var mensajes=new Array(
			"Por favor ingresa un nombre del producto",
			"Por favor ingresa un concepto",
			"Por favor ingrese la fecha de inicio",
			"Por favor especifica la fecha de finalizacion",
			"Por favor intriduzca una descripcion",
			"Por favor especifica el costo real",
			"Por favor especifica el costo",
			"Por favor especifica el costo publico",
			"Por favor epsecifica un tiempo de entrega",
			"Por favor especifica la cantidad de puntos comisionables"
			);
		var id_entero=Array(
			"#entrega"
			);
		var mensaje_entero=Array(
			"El tiempo de entrega debe de ser un numero entero"
			);
		var id_fecha=Array(
			"#startdate",
			"#finishdate"
			);
		var mensaje_fecha=Array(
			"El formato de la fecha es incorrecto (aaaa-mm-dd)",
			"El formato de la fecha es incorrecto (aaaa-mm-dd)"
			);
		
		var id_dec=new Array(
			"#real",
			"#costo",
			"#costo_publico"
			);
		var msj_dec=new Array(
			"El costo real debe de ser un numero",
			"El costo debe de ser un numero",
			"El costo_publico debe de ser un numero"
			);
		//var val_decimales=valida_decimales(id_dec, msj_dec);
		var validacion=valida_vacios(ids,mensajes);
		var val_espacios=true;
		var val_email=true;
		var val_psswrds=true;
		var val_tamano=true;
		var val_entero=valida_entero(id_entero,mensaje_entero);
		var val_fecha=valida_fecha(id_fecha,mensaje_fecha);
		
	}
	if(tipo_merc==3)
	{
		var tipo_promo=("#tipo").val();
		if(tipo_promo==1)
		{
			var ids=new Array(
				"#nombre_pr",
				"#prod_qty",
				"#serv_qty",
				"#precio_promo",
				"#real",
				"#costo",
				"#costo_publico",
				"#entrega",
				"#puntos_com"
				);
			var mensajes=new Array(
				"Por favor ingresa un nombre del producto",
				"Por favor especifica la cantidad de producto",
				"Por favor especifica la cantidad de servicio",
				"Por favor especifica el descuento de la promocion",
				"Por favor intriduzca una descripcion",
				"Por favor especifica el costo real",
				"Por favor especifica el costo",
				"Por favor especifica el costo publico",
				"Por favor epsecifica un tiempo de entrega",
				"Por favor especifica la cantidad de puntos comisionables"
				);
			var id_entero=Array(
				"#entrega",
				"prod_qty",
				"serv_qty"
				);
			var mensaje_entero=Array(
				"El tiempo de entrega debe de ser un numero entero",
				"La cantidad de prducto debe ser un numero entero",
				"La cantidad de servcio debe ser un numero entero"
				);
			
			var id_dec=new Array(
				"#real",
				"#costo",
				"#costo_publico"
				);
			var msj_dec=new Array(
				"El costo real debe de ser un numero",
				"El costo debe de ser un numero",
				"El costo_publico debe de ser un numero"
				);
			//var val_decimales=valida_decimales(id_dec, msj_dec);
			var validacion=valida_vacios(ids,mensajes);
			var val_espacios=true;
			var val_email=true;
			var val_psswrds=true;
			var val_tamano=true;
			var val_entero=valida_entero(id_entero,mensaje_entero);
			var val_fecha=true;
		}
		if(tipo_promo==2)
		{
			var ids=new Array(
				"#nombre_pr",
				"#n_mercancia",
				"#startdate",
				"#finishdate",
				"#precio_promo"
				);
			var mensajes=new Array(
				"Por favor ingresa un nombre de la promocion",
				"Por favor ingresa la cantidad de mercancia",
				"Por favor ingrese la fecha de inicio",
				"Por favor especifica la fecha de finalizacion",
				"Por favor especifica el descuento de la promocion"
				);
			var id_entero=Array(
				"#n_mercancia"
				);
			var mensaje_entero=Array(
				"La cantidad de mercancia debe ser un numero entero"
				);
			var id_fecha=Array(
				"#startdate",
				"#finishdate"
				);
			var mensaje_fecha=Array(
				"El formato de la fecha es incorrecto (aaaa-mm-dd)",
				"El formato de la fecha es incorrecto (aaaa-mm-dd)"
				);
			
			//var val_decimales=valida_decimales(id_dec, msj_dec);
			var validacion=valida_vacios(ids,mensajes);
			var val_espacios=true;
			var val_email=true;
			var val_psswrds=true;
			var val_tamano=true;
			var val_entero=valida_entero(id_entero,mensaje_entero);
			var val_fecha=valida_fecha(id_fecha,mensaje_fecha);
		}
	}

		//AQUII MAS CODIGO AMIGO JAJA


		if(val_espacios&&validacion&&val_email&&val_psswrds&&val_entero&&val_tamano&&val_fecha)
		{

			return;
		}

		event.preventDefault();

	});

function new_pack()
{
	bootbox.dialog({
		message: '<form id="form_paquete" method="post" action="/bo/admin/alta_paquete" class="smart-form">'
		+'<div class="row">'
		+'<fieldset>'
		+'<legend>Datos del paquete</legend>'
		+'<section class="col col-12">Tipo del paquete'
		+'<label class="select">'
		+'<select class="custom-scroll"  name="tipo_paquete">'
		+'<?foreach ($tipo_paquete as $key){?>'
		+'<option value="<?=$key->id_tipo?>">'
		+'<?=$key->descripcion?></option>'
		+'<?}?>'
		+'</select>'
		+'</label>'
		+'</section>'
		+'<section class="col col-6">'
		+'<label class="input">Nombre'
		+'<input type="text" name="nombre" id="nombre_pr">'
		+'</label>'
		+'</section>'
		+'<div id="tipo_promo">'
		+'<section class="col col-6">'
		+'<label class="input"><span id="labelextra">Precio</span>'
		+'<input id="precio_promo" type="text" name="precio">'
		+'</label>'
		+'</section>'
		+'<section class="col col-6">'
		+'<label class="input"><span id="labelextra">Puntos comisionables</span>'
		+'<input id="precio_promo" type="text" name="puntos">'
		+'</label>'
		+'</section>'
		+'<section class="col col-12">Visibilidad'
		+'<label class="select">'
		+'<select class="custom-scroll"  name="visible">'
		+'<option value="1">Afiliar</option>'
		+'<option value="2">Carrito</option>'
		+'<option value="3">Afiliar y carrito</option>'
		+'</select>'
		+'</label>'
		+'</section>'
		+'<div class="row"><br /></div>'
		+'<div class="col-xs-12 col-sm-12 col-md-6 col-lg-6" id="prods">'
		+'<section class="col col-10">Productos'
		+'<label class="select">'
		+'<select class="custom-scroll"  name="producto[]">'
		+'<option value="0">Ninguno</option>'
		+'<?foreach ($producto as $key){?>'
		+'<option value="<?=$key->id_mercancia?>">'
		+'<?=$key->nombre?></option>'
		+'<?}?>'
		+'</select>'
		+'</label>'
		+'</section>'
		+'<section class="col col-10">'
		+'<label class="input">Cantidad de productos'
		+'<input type="number" min="1" name="n_productos[]" id="prod_qty">'
		+'</label>'
		+'</section>'
		+'</div>'
		+'<div class="col-xs-12 col-sm-12 col-md-6 col-lg-6" id="servs">'
		+'<section class="col col-10">Servicios'
		+'<label class="select">'
		+'<select class="custom-scroll" name="servicio[]">'
		+'<option value="0">Ninguno</option>'
		+'<?foreach ($servicio as $key){?>'
		+'<option value="<?=$key->id_mercancia?>">'
		+'<?=$key->nombre?></option>'
		+'<?}?>'
		+'</select>'
		+'</label>'
		+'</section>'
		+'<section class="col col-10">'
		+'<label class="input">Cantidad de servicios'
		+'<input type="number" min="1" name="n_servicios[]" id="serv_qty">'
		+'</label>'
		+'</section>'
		+'</div>'
		+'</div>'
		+'</fieldset>'
		+'<div id="agregar" class=" text-center row"><a onclick="new_product()">Agregar producto <i class="fa fa-plus"></i></a>  <a  onclick="new_service()">Agregar servicio <i class="fa fa-plus"></i></a></div>'
		+'</fieldset>'
		+'</div>'
		+'</form>',
		title: "Agregar paquete",
		buttons: {
			submit: {
				label: "Aceptar",
				className: "btn-success",
				callback: function() {

					$.ajax({
						type: "POST",
						url: "/bo/admin/alta_paquete",
						data: $("#form_paquete").serialize(),
					})
					.done(function( msg )
					{
						bootbox.dialog({
							message: msg,
							title: 'Paquete',
							buttons: {
								success: {
									label: "Aceptar",
									className: "btn-success",
									callback: function() {
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
				callback: function() {

				}
			}
		}
	})
}

function ImpuestosPais(){
	var pa = $("#pais").val();
	
	$.ajax({
		type: "POST",
		url: "/bo/mercancia/ImpuestaPais",
		data: {pais: pa}
	})
	.done(function( msg )
	{
		$('#impuesto option').each(function() {
		    
		        $(this).remove();
		    
		});
		datos=$.parseJSON(msg);
	      for(var i in datos){
		      var impuestos = $('#impuesto');
		      $('#impuesto select').each(function() {
				  $(this).append('<option value="'+datos[i]['id_impuesto']+'">'+datos[i]['descripcion']+' '+datos[i]['porcentaje']+'</option>');
			    
			});
	    	  
	        
	      }
	});
}
function ImpuestosPais2(id){
	var pa = $("#pais").val();
	
	$.ajax({
		type: "POST",
		url: "/bo/mercancia/ImpuestaPais",
		data: {pais: pa}
	})
	.done(function( msg )
	{
		$('#'+id+' option').each(function() {
		    
		        $(this).remove();
		    
		});
		datos=$.parseJSON(msg);
	      for(var i in datos){
		      var impuestos = $('#'+id);
		      $('#'+id+' select').each(function() {
				  $(this).append('<option value="'+datos[i]['id_impuesto']+'">'+datos[i]['descripcion']+' '+datos[i]['porcentaje']+'</option>');
			    
			});  
	      }
	});
	calcular_precio_total();
}
function validar_impuesto(){
	var  Impuesto = new Array();
$('select[name="id_impuesto[]"]').each(function() {	
	Impuesto.push($(this).val());
});	
return Impuesto;
}
function validar_tipo_iva(porcentaje, tipo, valor){
	var valor_iva=0;
	valor_iva=((valor)*parseFloat(porcentaje))/(100);
if(tipo=="1"){
	precio_con_iva=valor/*-valor_iva*/;
	return precio_con_iva;
}
if(tipo=="0"){
	precio_con_iva=parseFloat(valor)+valor_iva;
	return precio_con_iva;
}
}


function calcular_porcentaje_total(){
		var  Impuesto=validar_impuesto();
		var resultado=0;
		var porcentaje=0;
		if(Impuesto){
		for(i=0;i<Impuesto.length;i++){
	
	$.ajax({
		async: false,
		type: "POST",
		url: "/bo/mercancia/ImpuestoPaisPorId",
		data: {impuesto: Impuesto[i]}
	})
	.done(function( msg )
	{
		recibir=$.parseJSON(msg);
		porcentaje+=parseInt(recibir[0]["porcentaje"]);
	});
}

return porcentaje;
}else{
	return false;
}
}
function calcular_precio_total(){
var tipo_iva=$("input:radio[name=iva]:checked").val();
var porcentaje=calcular_porcentaje_total();
var Resultado_Final=0;
	var valor_real=$("#real").val();
	var valor_distribuidor=$("#costo").val();
	var valor_publico=$("#costo_publico").val();
	var validar_real=validar_campos_vacios(valor_real);
	var validar_distribuidor=validar_campos_vacios(valor_distribuidor);
	var validar_publico=validar_campos_vacios(valor_publico);
	if(porcentaje!=false || porcentaje==0){
	if(validar_real==true){
	Resultado_Final=validar_tipo_iva(porcentaje, tipo_iva, valor_real);
	$("#real_iva").val(Resultado_Final);	
		}
		else{$("#real_iva").val("falta algun dato");}
	if(validar_distribuidor==true){
	Resultado_Final=validar_tipo_iva(porcentaje, tipo_iva, valor_distribuidor);
	$("#distribuidores_iva").val(Resultado_Final);
						}
			else{$("#distribuidores_iva").val("falta algun dato");}
	if(validar_publico==true){
	Resultado_Final=validar_tipo_iva(porcentaje, tipo_iva, valor_publico);
	$("#publico_iva").val(Resultado_Final);
						}
		else{$("#publico_iva").val("falta algun dato");}
	}else{
		$("#real_iva").val("falta un dato");
		$("#distribuidores_iva").val("falta un dato");
		$("#publico_iva").val("falta un dato");
	}
}
function validar_campos_vacios(campo){
if(campo=="undefined"){
return false;
}
if(campo==null){
return false;
}
if(campo==""){
return false;
}
return true;
}
function select_pais(){
calcular_precio_total();
ImpuestosPais();	
}

/*function calcular_iva_real_radio(resultado){
	var tipo_iva=$("input:radio[name=iva]:checked").val();
	var valor_real=$("#real").val();
	var valor_distribuidor=$("#costo").val();
	var valor_publico=$("#costo_publico").val();
	var Resultado_Final=0;
	    for(i=0;i<resultado.length;i++){
        	if(resultado[i].checked){
        	Resultado_Final= calcular_dependiendo_tipo_iva(resultado[i].value,valor_real);
        	$("#real_iva").val(Resultado_Final);
        	Resultado_Final= calcular_dependiendo_tipo_iva(resultado[i].value,valor_distribuidor);
        	$("#distribuidores_iva").val(Resultado_Final);
        	Resultado_Final= calcular_dependiendo_tipo_iva(resultado[i].value,valor_publico);
        	$("#publico_iva").val(Resultado_Final);
        }
	    }

}

function Resultado_ConSin_iva(id_dato,id_modificar){
var tipo_iva = $("input:radio[name=iva]:checked").val();
var valor=$("#"+id_dato).val();
Resultado_Final= calcular_dependiendo_tipo_iva(tipo_iva,valor);
$("#"+id_modificar).val(Resultado_Final);
}*/


</script>
<div id="spinner-div"></div>
<div class="row">
	<form id="actualizar" class="smart-form" role="form" method="POST"
								action="/bo/evento/actualizar" enctype="multipart/form-data">

								<div class="col-md-6 col-xs-12">
								<input type="hidden" name="id" value="<?=$curso[0]->id?>">
									<fieldset>
										<legend>Datos Principales </legend>
										<label class="input">Nombre <input style="width: 25rem;"
											type="text" name="nombre" placeholder="Nombre"
											class="form-control" required value="<?=$curso[0]->nombre?>">
										</label>

										 <div class="row" style="width: 28rem;">
											<section class="col col-lg-12 col-md-12 col-sm-12 col-xs-12"
												id="busquedatodos">
												<label class="label">Descripcion</label> <label
													class="textarea"> <textarea required rows="3"
														class="custom-scroll" name="descripcion"><?=$curso[0]->descripcion?></textarea>
												</label>
											</section>
										</div> 

										<br />
										<div style="width: 25rem;">
											<label class="select">Curso o Carrera <select id="curso"
												required name="curso" onChange="imagenes()">
													<option value="" >-- Seleciona un Curso --</option>
                                                <?php foreach ($cursos as $key) { ?>
                                                    <option
														value="<?= $key->id ?>" <?= ($key->id==$curso[0]->FK_curso) ? 'selected' : '' ?> ><?= $key->nombre ?></option>
                                                <?php } ?>
                                            </select>
											</label>
										</div>
										<br />
										<div style="width: 25rem;">
											<label class="select">Ubicación (Sede) <select id="sede"
												required name="sede" onChange="imagenes()">
													<option value="" >-- Seleciona una Sede --</option>
                                                <?php foreach ($sedes as $key) { ?>
                                                    <option
														value="<?= $key->id ?>" <?= ($key->id==$curso[0]->FK_sede) ? 'selected' : '' ?> ><?= $key->nombre ?></option>
                                                <?php } ?>
                                            </select>
											</label>
										</div>
										<br />
										
										<!-- <div style="width: 25rem;">
											<label for="" class="select">Docente <select id="docente"
												required name="docente" onChange="cupos()">
													<option value=""  >-- Seleciona un Docente--</option>
                                                <?php foreach ($docente as $key) { ?>
                                                    <option
														value="<?= $key->user_id ?>"  <?= ($key->user_id==$curso[0]->FK_docente) ? 'selected' : '' ?> ><?= $key->nombre . " " . $key->apellido ?></option>
                                                <?php } ?>
                                            </select>
											</label>
										</div>
										<br />   -->
										<div style="width: 25rem;">
											<label class="select">Hora Inicio
											<select	required class="minute form-control pull-right" id="min0" name="min0" style="width: auto;">
												<option value="<?=substr($curso[0]->hora0, 3,5)?>"><?=substr($curso[0]->hora0, 3,2)?></option>
											</select>
												<p class="pull-right">:</p>												
											<select required class="hour form-control pull-right" id="hora0" name="hora0" style="width: auto;">
												<option value="<?=substr($curso[0]->hora0, 0,2)?>"><?=substr($curso[0]->hora0, 0,2)?></option>
											</select> 
											</label>
										</div>
										<br />
										<div style="width: 25rem;">
											<label class="select">Hora Fin
											<select	required class="minute form-control pull-right" id="min1" name="min1" style="width: auto;">
												<option value="<?=substr($curso[0]->hora1, 3,5)?>"><?=substr($curso[0]->hora1, 3,2)?></option>
											</select>
												<p class="pull-right">:</p>												
											<select required class="hour form-control pull-right" id="hora1" name="hora1" style="width: auto;">
												<option value="<?=substr($curso[0]->hora1, 0,2)?>"><?=substr($curso[0]->hora1, 0,2)?></option>
											</select> 
											</label>
										</div>
										<br />


									</fieldset>
								</div>
								<div class="col-md-6 col-xs-12">
									<fieldset>
										<legend>Datos de Incursión</legend>
										<div style="width: 25rem;">
											<label class="input"> <i class="icon-prepend fa fa-calendar"></i>
												<input required id="datepicker" type="text" name="inicio"
												placeholder="Fecha de Inicio" value="<?=$curso[0]->inicio?>">
											</label>
										</div>
										<br />
										<div style="width: 25rem;">
											<label class="input"> <i class="icon-prepend fa fa-calendar"></i>
												<input required id="datepicker2" type="text" name="fin"
												placeholder="Fecha de Finalización" value="<?=$curso[0]->fin?>">
											</label>
										</div>
										<br />
										<div style="width: 25rem;">
											Tipo de Entrada
											<div class="inline-group">
												<label class="radio"> <input type="radio" class="costo   "
													value="1"  <?= ($curso[0]->FK_costo==1) ? 'checked' : '' ?> name="costo" placeholder="costo"> <i></i>Gratuito
												</label> <label class="radio"> <input type="radio" value="2"
													class="costo"  <?= ($curso[0]->FK_costo==2) ? 'checked' : '' ?>  name="costo" placeholder="costo"> <i></i>De
													Pago
												</label> <label class="radio"> <input type="radio" value="3"
													class="costo"  <?= ($curso[0]->FK_costo==3) ? 'checked' : '' ?> name="costo" placeholder="costo"> <i></i>Donación
												</label>
											</div>
										</div><br />
										<label class="input">Numero de Entradas (0 es
											Ilimitado) <input style="width: 25rem;" type="number"
											name="entradas" min="0" placeholder="# Entradas"
											class="form-control" required value="<?=$curso[0]->entradas?>">
										</label> 
										<div style="width: 25rem;" id="precio"></div>
										<br /> <label class=""> <input type="checkbox"
											value="1" name="reserva"  <?= ($curso[0]->reserva==1) ? 'checked' : '' ?>  placeholder="reserva">Necesita
											Reservación
										</label> <hr /><br /> 

										<div class="row" style="width: 28rem;">
											<section class="col col-lg-12 col-md-12 col-sm-12 col-xs-12"
												id="busquedatodos">
												<label class="label">Observaciones</label> <label
													class="textarea"> <textarea  rows="5"
														class="custom-scroll" name="observaciones"><?=$curso[0]->observaciones?></textarea>
												</label>
											</section>
										</div>
									</fieldset>
								</div>
								<div class="col-md-10 col-xs-12">
									<fieldset id="imagenes">
										<legend> Galería de imagenes</legend>
										<small><cite title="Source Title">Para ver el archivo que va a
												cargar, pulse con el puntero en el boton de "Buscar"</cite></small>
										<hr/>
										<br/>
										<?php $i=1; foreach ($galeria as $imagen) {?>
										<section <?= ($i>1) ? 'id="img'.$i.'"' : ""?>class="col-md-5" style="width: 20rem;">
											<label class="label">Imagen <?=$i?> </label>
											<div class="input input-file">
												<span class="button"> <input class="imgGallery" name="img<?=$i?>"
													onchange="this.parentNode.nextSibling.value = this.value"
													type="file" multiple>Buscar
												</span><input id="imagen_mr<?=$i?>"
													placeholder="Agregar alguna imagen" type="text" required value="<?=$imagen->nombre_completo?>">
											</div>
											<a href="<?=$imagen->url?>" target="_blank">Vista Previa</a>	
										</section>
										<?php $i++; } ?>
									</fieldset>
									<div class="row">
											<section id="div_subir">
												<div class="pull-right">
													<input type="button" class="btn btn-danger"
														style="width: 100%;" onclick="suprImagen()" value="Eliminar">
												</div>
												<div class="pull-right">
													<input type="button" class="btn btn-primary"
														style="width: 100%;" id="newImg" value="Agregar">
												</div>
											</section>
										</div>
									<fieldset>
										<br />
										<div class="row">
											<section id="div_send ">
												<div class="pull-right">
													<input type="submit" class="btn btn-success"
														style="width: 100%;" id="boton_subir" value="Actualizar">
												</div>
											</section>
										</div>
									</fieldset>
								</div>



							</form>

</div>
<script type="text/javascript">

$('.hour').ready(function(){
	for (i = 00; i < 24 ; i ++){
		var value = (i<10) ? "0"+i : i;
		$('.hour').append("<option value="+value+">"+value+"</option>");
	}
});

$('.minute').ready(function(){
	for (i = 00; i < 60 ; i = i+5){
		var value = (i<10) ? "0"+i : i;
		$('.minute').append("<option value="+value+">"+value+"</option>");
	}
});

var ID = <?=$curso[0]->id?>;
var galeria = "<?=implode(",", $galeriaJS)?>".split(",");

$('#actualizar').ready(botonEliminar);
$('#newImg').click(nuevaImagen);

$('.costo').ready(checkPrecio);
$('.costo').click(checkPrecio);

var countImg = <?=sizeof($galeria) ?>;

function botonEliminar(){
	if(countImg>1){
		$('#div_subir').append('');
		countImg++;
	}
}

function nuevaImagen(){
	if(countImg==0){
		countImg++;
	}
	countImg++;
	
	$('#imagenes').append('<section id="img'+countImg+'"  class="col-md-5" style="width: 20rem;">'
			+'<label class="label">Imagen '+countImg+' </label>'
			+'<div class="input input-file">'
				+'<span class="button">' 
				+'<input class="imgGallery" name="img'+countImg+'"'
					+'onchange="this.parentNode.nextSibling.value = this.value"'
					+'type="file" multiple>Buscar'
				+'</span><input id="imagen_mr'+countImg+'"'
					+'placeholder="Agregar alguna imágen" type="text" required>'					
			+'</div>'
		+'</section>');	
	
}

function suprImagen() {

	var ValImg = $('#imagen_mr'+ countImg).val();

	for (i = 0 ; i < galeria.length ; i++) {
		if(galeria[i]==ValImg){
			eliminarImagen(ValImg);
		}
	}	
    $("#img" + countImg + "").remove();
    countImg--;
}

function eliminarImagen(img){
	$.ajax({
		data: {img:img,id:ID},
        type: "post",
        url: "/bo/evento/eliminarImagen"
		}).done(function( msg ){
			//alert(msg);
		})

}

function checkPrecio(){
    var valor = $('.costo:checked').val();
    
        if (valor == 1){ 
            $('#precio').html('');        
        }else if (valor == 2){
            $('#precio').html('<br /><label class="input">Valor de la Entrada'
                            +'<input style="width: 25rem;" type="number" name="precio" min="0" placeholder="$ 0.00" class="form-control" required value="<?=$curso[0]->precio?>" >'
                            +'</label>');
        }else if (valor ==3) {
            $('#precio').html('<br /><label class="input">Minimo Valor de Donación'
                            +'<input style="width: 25rem;" type="number" name="precio" min="0" placeholder="$ 0.00" class="form-control" required value="<?=$curso[0]->precio?>" >'
                            +'</label>');
        } 
                    
        
}

$( "#actualizar" ).submit(function( event ) {
	event.preventDefault();
	setiniciarSpinner();
	actualizar();
});

function ValidarVacio(nombre, direccion, telefono){
	if(nombre == ''){
		alert('Campo Nombre del almacen es requerido');
		return false;
	}else if(direccion == ''){
		alert('El campo direccion del almacen es requerido');
		return false;
	}else if(telefono == ''){
		alert('El campo telefono del almacen es requerido');
		return false;
	}else{
		return true;
	}
	
}


function actualizar()
{
            
	//var nombre = $("#nombre").val();
	//var descripcion = $("#descripcion").val();

	//var direccion = $("#direccion").val();
	//var telefono = $("#telefono").val();
	
	//if(ValidarVacio(nombre, direccion, telefono)){
	
	var dataF = new FormData($("#actualizar")[0]);	
	dataF.append('imgCount', countImg);
	
    for (var pair of dataF.entries()) {
        console.log(pair[0]+ ': [' + pair[1] + ']'); 
    }  
	
		$.ajax({
					data: dataF,
			        cache: false,
			        contentType: false,
			        processData: false,
                    type: "post",
                    url: "/bo/evento/actualizar"
		}).done(function( msg ){
				
                    bootbox.dialog({
				message: msg,
				title: 'Atención !!',
				buttons: {
                                    success: {
					label: "Aceptar",
					className: "btn-success",
					callback: function() {
                                                FinalizarSpinner();
						location.href="/bo/evento/listar";
                                        }
                                    }
				}
                    })
		});//Fin callback bootbox
	//}
		
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

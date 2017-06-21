<div id="spinner-div"></div>
<div class="row">
	<form id="actualizar" class="smart-form" role="form" method="POST"
								action="/bo/cursos/actualizar" enctype="multipart/form-data">

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
											<label for="" class="select">Tipo de Oferta <select
												id="oferta" name="oferta" onChange="facultad()" required>
													<option value=""  >-- Seleciona un tipo de Oferta --</option>
                                                <?php foreach ($oferta as $key) { ?>
                                                    <option
														value="<?= $key->id ?>" <?= ($key->id==$curso[0]->FK_oferta) ? 'selected' : '' ?> ><?= $key->nombre ?></option>
                                                <?php } ?>
                                            </select>
											</label>
										</div>
										<br />
										<div style="width: 25rem;">
											<label for="" class="select">Facultad <select id="facultad"
												required name="facultad" onChange="cupos()">
													<option value=""  >-- Seleciona una Facultad --</option>
                                                <?php foreach ($facultad as $key) { ?>
                                                    <option
														value="<?= $key->id ?>" <?= ($key->id==$curso[0]->FK_facultad) ? 'selected' : '' ?> ><?= $key->nombre ?></option>
                                                <?php } ?>
                                            </select>
											</label>
										</div>
										
										<br />


									</fieldset>
								<!--  </div>
								
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
										</div>-->
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

var ID = <?=$curso[0]->id?>;
//var galeria = "<?//=implode(",", $galeriaJS)?>//".split(",");

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
        url: "/bo/cursos/eliminarImagen"
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
                    url: "/bo/cursos/actualizar"
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
						location.href="/bo/cursos/listar";
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

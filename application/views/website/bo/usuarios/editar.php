<?php

function Activo($secciones, $id) {
    foreach ($secciones as $seccion) {
        if ($seccion->seccion == $id) {
            return true;
        }
    }
    return false;
}
?>
<!-- MAIN CONTENT -->
<div id="spinner-div"></div>

<section id="widget-grid" class="">
    <!-- START ROW -->
    <div class="row">

        <!-- NEW COL START -->
        <article class="col-sm-12 col-md-12 col-lg-12">
            <!-- Widget ID (each widget will need unique ID)-->
            <div class="jarviswidget" id="wid-id-1" data-widget-editbutton="false" data-widget-custombutton="false" data-widget-colorbutton="false">
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
                    <h2>Datos de Usuario</h2>
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
                        <ul id="myTab1" class="nav nav-tabs bordered">
                            <li id="tab1" class="active">
                                <a href="#s1" data-toggle="tab"><i class="fa fa-user"></i></a>
                            </li>
                        </ul>
                        <div id="myTabContent1" class="tab-content padding-10">
                            <div class="tab-pane fade in active" id="s1">

                                <div id="uno" class="row fuelux">


                                    <div id="myWizard" class="wizard">

                                        <ul class="steps">

                                            <li data-target="#step1">
                                                <span class="badge">1</span>Datos Personales<span class="chevron"></span>
                                            </li>
                                        </ul>
                                        <div id="acciones" class="actions">

                                            <button type="button" class="final btn btn-sm btn-success btn-next" data-last="Actualizar"> <!--disabled="disabled"-->
                                                Actualizar<i class="fa fa-arrow-right"></i>
                                            </button>
                                        </div>
                                    </div>
                                    <div class="step-content">
                                        <div class="form-horizontal" id="fuelux-wizard" >
                                            <div class="step-pane active" id="step1">
                                                <form method="post" id="dataUser" class="smart-form" role="form">
                                                    <fieldset>
                                                         <input type="hidden"  value="<?= $id?>" name="id" >
                                                        <legend>Información de Sesión</legend>
                                                        <section id="usuario" class="col col-6">
                                                            <label class="input"> <i class="icon-prepend fa fa-user"></i>
                                                                <input value="<?= $usuario[0]->username ?>" id="username" onkeyup="use_username()" required type="text" name="username" placeholder="Usuario">
                                                            </label>
                                                        </section>
                                                        <section id="correo" class="col col-6">
                                                            <label class="input"> <i class="icon-prepend fa fa-envelope-o"></i>
                                                                <input value="<?= $usuario[0]->email ?>" id="email" onkeyup="use_mail()" required type="email" name="email" placeholder="Dirección de Correo Electrónico">
                                                            </label>
                                                        </section>
                                                        <section class="col col-6">
                                                            <label class="input"> <i class="icon-prepend fa fa-lock"></i>
                                                                <input id="password"  onkeyup="confirm_pass()" required type="password" name="password" placeholder="Contraseña">
                                                            </label>
                                                        </section>
                                                        <section id="confirmar_password" class="col col-6">
                                                            <label class="input"> <i class="icon-prepend fa fa-lock"></i>
                                                                <input id="confirm_password" onkeyup="confirm_pass()" required type="password" name="confirm_password" placeholder="Confirme contraseña">
                                                            </label>
                                                        </section>

                                                    </fieldset> 
                                                    <fieldset>
                                                        <legend>Datos Personales del Usuario</legend>
                                                        <div class="row">
                                                            <input id="rol" required type="hidden" name="rol" value="<?= $rol ?>">
                                                            <?php if (Activo($secciones, 3)) { ?>
                                                                <section class="col col-6">
                                                                    <label class="input"> <i class="icon-prepend fa fa-user"></i>
                                                                        <input id="nombre" value="<?= $usuario[0]->nombre ?>" required type="text" name="nombre" placeholder="Nombre(s)">
                                                                    </label>
                                                                </section>
                                                                <section class="col col-6">
                                                                    <label class="input"> <i class="icon-prepend fa fa-user"></i>
                                                                        <input id="apellido" value="<?= $usuario[0]->apellido ?>" required type="text" name="apellido" placeholder="Apellidos (paterno y/o materno)">
                                                                    </label>
                                                                </section>																
                                                                <section class="col col-6">
                                                                    <label class="input"> <i class="icon-prepend fa fa-calendar"></i>
                                                                        <input required value="<?= $usuario[0]->nacimiento ?>" id="datepicker" type="text" name="nacimiento" placeholder="Fecha de nacimiento">
                                                                    </label>
                                                                </section>
                                                            <?php } ?>
                                                            <?php if (Activo($secciones, 4)) { ?>
                                                                <section class="col col-6" id="key">
                                                                    <label id="key_" class="input"> <i class="icon-prepend fa fa-barcode"></i>
                                                                        <input id="keyword" value="<?= $usuario[0]->keyword ?>" onkeyup="check_keyword()" placeholder="RFC" type="text" name="keyword">
                                                                    </label>
                                                                </section>	
                                                            <?php } ?>	
                                                            <?php if (Activo($secciones, 5)) { ?>
                                                                <section class="col col-6">																	
                                                                    <label class="select"> 
                                                                        <select id="sede" required name="sede">
                                                                            <?php foreach ($sedes as $key) { ?> 
                                                                                <option value="<?= $key->id ?>" <?= ($key->id == $org[0]->sede) ? "selected" : "" ?> >
                                                                                    <?= $key->nombre ?>
                                                                                </option>
                                                                            <?php } ?>
                                                                        </select>
                                                                    </label>
                                                                    Sede
                                                                </section>
                                                                <section class="col col-6" >
                                                                    <label  class="input"> <i class="icon-prepend fa fa-coffee"></i>
                                                                        <input id="cargo" placeholder="Cargo" value="<?= $org[0]->cargo ?>" type="text" name="cargo"><!-- id="_Cargo" id="cargo_" onkeyup="check_cargo()" -->
                                                                    </label>
                                                                </section>	
                                                                <section class="col col-6">																	
                                                                    <label class="select">
                                                                        <select id="jefe" required name="jefe">
                                                                            <option value="1">CEO</option>
                                                                        </select>
                                                                    </label>
                                                                    Jefe Directo : <?= $jefe[0]->nombre . ' ' . $jefe[0]->apellido ?>
                                                                </section>	

                                                            <?php } ?>
                                                            <?php if (Activo($secciones, 4)) { ?>
                                                                <section class="col col-6">																	
                                                                    <label class="select">
                                                                        <select id="tipo_fiscal" required name="fiscal">
                                                                            <?php foreach ($tipo_fiscal as $key) { ?> 
                                                                                <option value="<?= $key->id ?>" <?= ($key->id == $usuario[0]->id_fiscal) ? "selected" : "" ?> >
                                                                                    <?= $key->descripcion ?>
                                                                                </option>
                                                                            <?php } ?>
                                                                        </select>
                                                                    </label>
                                                                    Tipo de persona
                                                                </section>	
                                                            <?php } ?>
                                                        </div>			
                                                        <?php if (Activo($secciones, 10)) { ?>												
                                                            <div class="row">
                                                                <div id="tel" class="col-xs-12 col-sm-12 col-md-12 col-lg-12">

                                                                    <?php
                                                                    $telFijo = 0;
                                                                    $telMovil = 0;
                                                                    foreach ($telefonos as $num) {

                                                                        if ($num->tipo == "Fijo") {
                                                                            $telFijo++;
                                                                            $n_tipo_tel = $telFijo;
                                                                            $icon_tipo_tel = 'phone';
                                                                            $nombre_tipo_tel = 'fijo';
                                                                        } else {
                                                                            $telMovil++;
                                                                            $n_tipo_tel = $telMovil;
                                                                            $icon_tipo_tel = 'phone';
                                                                            $nombre_tipo_tel = 'movil';
                                                                        }

                                                                        $boton = ($n_tipo_tel > 0) ? "<a style='cursor: pointer;color: red;' onclick='delete_telefono(`default_$n_tipo_tel`)'>Eliminar <i class='fa fa-minus'></i></a>" : "";

                                                                        echo "<section id='tel_default_$n_tipo_tel' class='col col-6'>
                                                                                <label class='input'> <i class='icon-prepend fa fa-$icon_tipo_tel'></i>
                                                                                    <input value='$num->numero' id='$nombre_tipo_tel' type='tel' name='" . $nombre_tipo_tel . "[]' placeholder='(999) 99-99-99-99-99'>
                                                                                    <b class='tooltip tooltip-top-left'> Teléfono $nombre_tipo_tel</b>
                                                                                    $boton
                                                                                </label>
                                                                            </section>";
                                                                    }
                                                                    ?>
                                                                </div>
                                                                <section class="col col-6">
                                                                    <button type="button" onclick="agregar('1')" class="btn btn-primary">
                                                                        &nbsp;Agregar <i class="fa fa-mobile"></i>&nbsp;
                                                                    </button>
                                                                    <button type="button" onclick="agregar('2')" class="btn btn-primary">
                                                                        &nbsp;Agregar <i class="fa fa-phone"></i>&nbsp;
                                                                    </button>
                                                                </section>
                                                            </div>
                                                        <?php } ?>
                                                    </fieldset>
                                                    <?php if (Activo($secciones, 9)) { ?>
                                                        <fieldset>
                                                            <legend>Contacto de Referencia</legend>
                                                            <div class="row">
                                                                <section class="col col-6">
                                                                    <label class="input">
                                                                        <input placeholder="Nombre(s)" value="<?= $ref[0]->nombre ?>" type="text" name="nombre_co">
                                                                    </label>
                                                                </section>
                                                                <section class="col col-6">
                                                                    <label class="input"> 
                                                                        <input placeholder="Apellido(s)" value="<?= $ref[0]->apellido ?>" type="text" name="apellido_co">
                                                                    </label>
                                                                </section>
                                                                <section class="col col-6">
                                                                    <label class="input"> <i class="icon-prepend fa fa-mobile"></i>
                                                                        <input required name="contacto_co" value="<?= $ref[0]->keyword ?>" placeholder="(999) 99-99-99-99-99" type="tel">
                                                                    </label>
                                                                </section>
                                                            </div>
                                                        </fieldset>
                                                    <?php } ?>
                                                    <?php if (Activo($secciones, 13)) { ?>
                                                        <fieldset>
                                                            <legend>Currículo</legend>
                                                            <div class="row">
                                                                <section class="col col-10">
                                                                    <div class="click2edit"><div class="well"><?= $usuario[0]->curriculo ?></div></div>
                                                                    <br/><hr/><br/>
                                                                    <button id="edit" class="btn btn-primary" onclick="editar_curriculo()" type="button">Editar</button>
                                                                    <button id="save" class="btn btn-primary" onclick="guardar_curriculo()" type="button">Guardar</button>
                                                                    <div id="curriculo_html" ></div>
                                                                </section> 
                                                            </div>
                                                        </fieldset>
                                                    <?php } ?>
                                                    <?php if (Activo($secciones, 6)) { ?>
                                                        <fieldset>
                                                            <legend>Dirección del Usuario</legend>
                                                            <div id="dir" class="row">
                                                                
                                                                <section class="col col-6">
                                                                    <label class="input">
                                                                        Dirección de domicilio
                                                                        <input required type="text" value="<?= $dir[0]->calle ?>" name="calle">
                                                                        (Calle, No. Exterior, No. Interior)
                                                                    </label>
                                                                </section>
                                                                <section id="colonia"  class="col col-6">
                                                                    <label class="input">
                                                                        Colonia
                                                                        <input type="text"  value="<?= $dir[0]->colonia ?>" name="colonia" >
                                                                    </label>
                                                                </section>
                                                                <section id="municipio" class="col col-6">
                                                                    <label class="input">
                                                                        Delegación o Municipio
                                                                        <input type="text"  value="<?= $dir[0]->municipio ?>"  name="municipio" >
                                                                    </label>
                                                                </section>
                                                                <section id="municipio" class="col col-6">
                                                                    <label class="input">
                                                                        Ciudad - Estado
                                                                        <input type="text"  value="<?= $dir[0]->estado ?>"  name="estado" >
                                                                    </label>
                                                                </section>
                                                                <section class="col col-6">
                                                                    País
                                                                    <label class="select">
                                                                        <select id="pais" required name="pais">
                                                                            <?php foreach ($pais as $key) { ?>
                                                                                <option value="<?= $key->Code ?>" <?= ($key->Code == $dir[0]->pais) ? "selected" : "" ?> >
                                                                                    <?= $key->Name ?>
                                                                                </option>
                                                                            <?php } ?>
                                                                        </select>
                                                                    </label>
                                                                </section>
                                                                <section class="col col-6">
                                                                    <label class="input">
                                                                        Código postal
                                                                        <input required type="text"  value="<?= $dir[0]->cp ?>"  id="cp" name="cp">
                                                                    </label>
                                                                </section>
                                                            </div>
                                                        </fieldset>
                                                    <?php } ?>
                                                    <fieldset>
                                                        <!--<legend>Estadística</legend>-->
                                                        <div class="row">
                                                            <?php if (Activo($secciones, 11)) { ?>
                                                                <section class="col col-6">Estado civil
                                                                    <label class="select">
                                                                        <select name="civil">
                                                                            <?php
                                                                            foreach ($civil as $key) {
                                                                                if ($key->id_edo_civil == $usuario[0]->id_edo_civil) {
                                                                                    echo '<option selected value="' . $key->id_edo_civil . '">' . $key->descripcion . '</option>';
                                                                                } else
                                                                                    echo '<option value="' . $key->id_edo_civil . '">' . $key->descripcion . '</option>';
                                                                            }
                                                                            ?>
                                                                        </select>
                                                                    </label>
                                                                </section>
                                                                <section class="col col-6">Género&nbsp;
                                                                    <div class="inline-group">
                                                                        <?php foreach ($sexo as $value) { ?>
                                                                            <label class="radio">
                                                                                <input <?= ($value->id_sexo == $usuario[0]->id_sexo) ? 'checked' : '' ?> type="radio" value="<?= $value->id_sexo ?>" name="sexo" placeholder="sexo">
                                                                                <i></i><?= $value->descripcion ?></label>
                                                                        <?php } ?>
                                                                    </div>
                                                                </section>
                                                            <?php } ?>
                                                            <?php if (Activo($secciones, 7)) { ?>
                                                                <section class="col col-6">Estudio&nbsp;
                                                                    <div class="inline-group">
                                                                        <?php foreach ($estudios as $value) { ?>
                                                                            <label class="radio">
                                                                                <input <?= ($value->id_estudio == $usuario[0]->id_estudio) ? 'checked' : '' ?> type="radio" value="<?= $value->id_estudio ?>" name="estudios">
                                                                                <i></i><?= $value->descripcion ?></label>
                                                                        <?php } ?>
                                                                    </div>
                                                                </section>
                                                            <?php } ?>
                                                            <?php if (Activo($secciones, 8)) { ?>
                                                                <section class="col col-6">Ocupación&nbsp;
                                                                    <div class="inline-group">
                                                                        <?php foreach ($ocupacion as $value) { ?>
                                                                            <label class="radio">
                                                                                <input <?= ($value->id_ocupacion == $usuario[0]->id_ocupacion) ? 'checked' : '' ?> type="radio" value="<?= $value->id_ocupacion ?>" name="ocupacion">
                                                                                <i></i><?= $value->descripcion ?></label>
                                                                        <?php } ?>
                                                                    </div>
                                                                </section>
                                                                <section class="col col-6">Tiempo dedicado&nbsp;
                                                                    <div class="inline-group">
                                                                        <?php foreach ($tiempo_dedicado as $value) { ?>
                                                                            <label class="radio">
                                                                                <input <?= ($value->id_tiempo_dedicado == $usuario[0]->id_tiempo_dedicado) ? 'checked' : '' ?> type="radio" value="<?= $value->id_tiempo_dedicado ?>" name="tiempo_dedicado">
                                                                                <i></i><?= $value->descripcion ?></label>
                                                                        <?php } ?>
                                                                    </div>
                                                                </section>
                                                            <?php } ?>
                                                        </div>
                                                    </fieldset>

                                                </form>
                                            </div>												

                                        </div>
                                    </div>

                                </div>
                            </div>

                        </div><!-- s1 -->

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

<!-- END MAIN CONTENT -->
<!-- PAGE RELATED PLUGIN(S) -->
<style type="text/css">
    /*Now the CSS*/
    * {margin: 0; padding: 0;}
    .nombre{background: rgba(255,255,255,.3); width: 100px; margin-top: -5px; margin-left: -11px;}
    .todo{font-size: 11px; width: 100%; background: rgba(0,0,0,.5); margin-top: -4px; color: #FFF; cursor: pointer;}
    .todo1{font-size: 11px; width: 100%; background: rgba(70, 120, 250, .8); margin-top: -4px; color: #FFF; cursor: pointer;}
    .todo:hover{font-size: 11px; text-decoration: underline; width: 100%; margin-top:-4px; background: rgba(0,0,0,.7); color: #FFF; cursor: pointer;}
    .todo1:hover{font-size: 11px; text-decoration: underline; width: 100%; margin-top:-4px; background: rgba(70, 120, 250, 1); color: #FFF; cursor: pointer;}
    .tree1 ul {
        padding-top: 20px; position: relative;

        transition: all 0.5s;
        -webkit-transition: all 0.5s;
        -moz-transition: all 0.5s;
    }

    .tree1 li {
        float: left; text-align: center;
        list-style-type: none;
        position: relative;
        padding: 20px 5px 0 5px;

        transition: all 0.5s;
        -webkit-transition: all 0.5s;
        -moz-transition: all 0.5s;
    }

    /*We will use ::before and ::after to draw the connectors*/

    .tree1 li::before, .tree1 li::after{
        content: '';
        position: absolute; top: 0; right: 50%;
        border-top: 3px solid #ccc;
        width: 50%; height: 20px;
    }
    .tree1 li::after{
        right: auto; left: 50%;
        border-left: 3px solid #ccc;
    }

    /*We need to remove left-right connectors from elements without 
    any siblings*/
    .tree1 li:only-child::after, .tree1 li:only-child::before {
        display: none;
    }

    /*Remove space from the top of single children*/
    .tree1 li:only-child{ padding-top: 0;}

    /*Remove left connector from first child and 
    right connector from last child*/
    .tree1 li:first-child::before, .tree1 li:last-child::after{
        border: 0 none;
    }
    /*Adding back the vertical connector to the last nodes*/
    .tree1 li:last-child::before{
        border-right: 3px solid #ccc;
        border-radius: 0 5px 0 0;
        -webkit-border-radius: 0 5px 0 0;
        -moz-border-radius: 0 5px 0 0;
    }
    .tree1 li:first-child::after{
        border-radius: 5px 0 0 0;
        -webkit-border-radius: 5px 0 0 0;
        -moz-border-radius: 5px 0 0 0;
    }

    /*Time to add downward connectors from parents*/
    .tree1 ul ul::before{
        content: '';
        position: absolute; top: 0; left: 50%;
        border-left: 3px solid #ccc;
        width: 0; height: 20px;
    }

    .tree1 li a{

        height: 100px;
        width: 100px;
        border: 1px solid #ccc;
        padding: 5px 10px;
        text-decoration: none;
        color: #000;
        font-size: 13px;
        display: inline-block;

        transition: all 0.5s;
        -webkit-transition: all 0.5s;
        -moz-transition: all 0.5s;
    }

    /*Time for some hover effects*/
    /*We will apply the hover effect the the lineage of the element also*/
    .tree1 li a:hover, .tree1 li a:hover+ul li a {
        background: #c8e4f8; color: #000; border: 1px solid #94a0b4;
    }
    /*Connector styles on hover*/
    .tree1 li a:hover+ul li::after, 
    .tree1 li a:hover+ul li::before, 
    .tree1 li a:hover+ul::before, 
    .tree1 li a:hover+ul ul::before{
        border-color:  #94a0b4;
    }

    .packselected
    {
        border-top: solid 5px #CCC;
        border-bottom: solid 5px #CCC;
        -webkit-box-shadow: 0px 0px 10px #CCC;
        -moz-box-shadow: 0px 0px 10px #CCC;
        box-shadow: 0px 0px 10px #CCC;
    }
    /*Thats all. I hope you enjoyed it.
    Thanks :)*/
</style>
<script src="/template/js/plugin/jquery-form/jquery-form.min.js"></script>
<script src="/template/js/validacion.js"></script>
<script src="/template/js/plugin/fuelux/wizard/wizard.min.js"></script>
<script src="/template/js/plugin/summernote/summernote.min.js"></script>
<script type="text/javascript">
    
    var ID = <?=$id?>;
    
                                                                    $('#sede').ready(getJefe);
                                                                    $('#sede').change(getJefe);

                                                                    function getJefe() {
                                                                        var sede = $("#sede").val();
                                                                        $.ajax({
                                                                            type: "POST",
                                                                            url: "/bo/usuarios/jefes",
                                                                            data: {sede: sede}
                                                                        })
                                                                                .done(function (msg)
                                                                                {
                                                                                    $('#jefe').html(msg);

                                                                                });
                                                                    }

                                                                    $(document).ready(function () {

                                                                        // fuelux 

                                                                        var wizard = $('.wizard').wizard();

                                                                        wizard.on('finished', function (e, data) {

                                                                            $(".invalid").remove();

                                                                            var ids = new Array(
                                                                                    "#nombre",
                                                                                    "#apellido",
                                                                                    "#datepicker",
                                                                                    //"#keyword",
                                                                                    "#username",
                                                                                    "#email"//,
                                                                                    //"#password",
                                                                                    //"#confirm_password"

                                                                                    );
                                                                            var mensajes = new Array(
                                                                                    "Por favor ingresa tu nombre",
                                                                                    "Por favor ingresa tu apellido",
                                                                                    "Por favor ingresa tu fecha de nacimiento",
                                                                                    //"Por favor ingresa la Identificacion Fiscal",
                                                                                    "Por favor ingresa un nombre de usuario",
                                                                                    "Por favor ingresa un correo"//,
                                                                                    //"Por favor ingresa una contraseña",
                                                                                    //"Por favor confirma tu contraseña"
                                                                                    );

                                                                            var idss = new Array(
                                                                                    "#username"
                                                                                    );
                                                                            var mensajess = new Array(
                                                                                    "El nombre de usuario no puede contener espacios en blanco"
                                                                                    );
                                                                            var validacion_ = valida_espacios(idss, mensajess);
                                                                            var validacion = valida_vacios(ids, mensajes);
                                                                            if (validacion && validacion_)
                                                                            {
                                                                                setiniciarSpinner();
                                                                                $(".steps").slideUp();
                                                                                $(".steps").remove();
                                                                                $(".actions").slideUp();
                                                                                $(".actions").remove();
                                                                                $("#myWizard").append('<div class="progress progress-sm progress-striped active"><div id="progress" class="progress-bar bg-color-darken"  role="progressbar" style=""></div></div>');

                                                                                $.ajax({
                                                                                    type: "POST",
                                                                                    url: "/bo/usuarios/actualizar",
                                                                                    data: $('#dataUser').serialize()
                                                                                })
                                                                                        .done(function (msg) {

                                                                                            $("#progress").attr('style', 'width: 100%');
                                                                                            bootbox.dialog({
                                                                                                message: msg,
                                                                                                title: "Atención",
                                                                                                buttons: {
                                                                                                    success: {
                                                                                                        label: "Ok!",
                                                                                                        className: "btn-success",
                                                                                                        callback: function () {
                                                                                                            location.href = "/bo/usuarios/listar?rol=<?= $rol; ?>";
                                                                                                            //siguiente?id=<?= ''/* $_GET["rol"] */ ?>&&token="+email;
                                                                                                            FinalizarSpinner();
                                                                                                        }
                                                                                                    }
                                                                                                }
                                                                                            });
                                                                                        });
                                                                            } else
                                                                            {
                                                                                $.smallBox({
                                                                                    title: "<h1>Atención</h1>",
                                                                                    content: "<h3>Por favor revisa que todos los datos estén correctos</h3>",
                                                                                    color: "#C46A69",
                                                                                    icon: "fa fa-warning fadeInLeft animated",
                                                                                    timeout: 4000
                                                                                });
                                                                            }

                                                                        });

                                                                        pageSetUp();
                                                                    })
                                                                    $("#remove_step").click(function () {
                                                                        $("#tipo_plan").attr("name", "tipo_plan");
                                                                        $('.wizard').wizard('selectedItem', {
                                                                            step: 4
                                                                        });
                                                                        $("#step4").slideUp();
                                                                        $("#step4").remove();
                                                                        $("#paso4").slideUp();
                                                                        $("#paso4").remove();
                                                                        $(this).slideUp();
                                                                        $(this).remove();
                                                                    });

                                                                    /*
                                                                     CODIGO PARA QUITAR ELEMENTO HACIENDO CLICK EN ELLOS
                                                                     $("input").click(function() {
                                                                     $( this ).slideUp();
                                                                     $( this ).remove();
                                                                     });
                                                                     */
                                                                    function codpos()
                                                                    {
                                                                        var pais = $("#pais").val();
                                                                        if (pais == "MEX")
                                                                        {
                                                                            var cp = $("#cp").val();
                                                                            $.ajax({
                                                                                type: "POST",
                                                                                url: "/ov/perfil/cp",
                                                                                data: {cp: cp},
                                                                            })
                                                                                    .done(function (msg)
                                                                                    {
                                                                                        $("#colonia").remove();
                                                                                        $("#municipio").remove();
                                                                                        $("#estado").remove();
                                                                                        $("#dir").append(msg);
                                                                                    })
                                                                        }
                                                                    }

                                                                    function use_username()
                                                                    {
                                                                        $('#username').val($('#username').val().replace(" ", ""));
                                                                        var username = $("#username").val();
                                                                        $.ajax({
                                                                            type: "POST",
                                                                            url: "/ov/perfil/use_username_modificar",
                                                                            data: {username: username,id:ID},
                                                                        })
                                                                                .done(function (msg)
                                                                                {
                                                                                    $("#msg_usuario").remove();
                                                                                    $("#usuario").append("<div id='msg_usuario'>" + msg + "</div>")
                                                                                });
                                                                        validate_user_data();
                                                                    }
                                                                    function use_mail()
                                                                    {
                                                                        var mail = $("#email").val();
                                                                        $.ajax({
                                                                            type: "POST",
                                                                            url: "/ov/perfil/use_mail_modificar",
                                                                            data: {mail: mail,id:ID},
                                                                        })
                                                                                .done(function (msg)
                                                                                {
                                                                                    $("#msg_correo").remove();
                                                                                    $("#correo").append("<div id='msg_correo'>" + msg + "</div>")
                                                                                });
                                                                        validate_user_data();
                                                                    }


                                                                    function confirm_pass()
                                                                    {
                                                                        var password = $("#password").val();
                                                                        var confirm_password = $("#confirm_password").val();
                                                                        $.ajax({
                                                                            type: "POST",
                                                                            url: "/ov/perfil/confirm_password",
                                                                            data: {password: password, confirm_password: confirm_password},
                                                                        })
                                                                                .done(function (msg)
                                                                                {
                                                                                    $("#msg_confirm_password").remove();
                                                                                    $("#confirmar_password").append("<div id='msg_confirm_password'>" + msg + "</div>")
                                                                                });
                                                                        validate_user_data();
                                                                    }

                                                                    function validate_user_data()
                                                                    {
                                                                        var username = $("#username").val();
                                                                        var mail = $("#email").val();

                                                                        var password = $("#password").val();
                                                                        var confirm_password = $("#confirm_password").val();

                                                                        $("#validate_user_data").remove();
                                                                        
                                                                        $.ajax({
                                                                            type: "POST",
                                                                            url: "/ov/perfil/validate_user_data2",
                                                                            data: {id:ID,mail: mail, username: username, password: password, confirm_password: confirm_password},
                                                                        })
                                                                                .done(function (msg)
                                                                                {
                                                                                    $("#validate_user_data").remove();
                                                                                    $("#dataUser").append("<div id='validate_user_data'>" + msg + "</div>")
                                                                                });
                                                                    }

                                                                    function otra()
                                                                    {
                                                                        if ($("#otro:checked").val() == "on")
                                                                        {
                                                                            $("#b_persona").removeClass("hidden");
                                                                            $("#afiliado_value").attr("name", "afiliados");
                                                                        } else
                                                                        {
                                                                            $("#b_persona").addClass("hidden");
                                                                            $("#afiliado_value").attr("name", "");
                                                                        }
                                                                    }
                                                                    var id=0;
                                                                    function agregar(tipo)
                                                                    {
                                                                        if (tipo == 1)
                                                                        {
                                                                            $("#tel").append("<section id='tel_" + id + "' class='col col-6'><label class='input'> <i class='icon-prepend fa fa-mobile'></i><input type='tel' name='movil[]' placeholder='(999) 99-99-99-99-99'></label><a style='cursor: pointer;color: red;' onclick='delete_telefono(" + id + ")'>Eliminar <i class='fa fa-minus'></i></a></section>");
                                                                        } else
                                                                        {
                                                                            $("#tel").append("<section id='tel_" + id + "' class='col col-6'><label class='input'> <i class='icon-prepend fa fa-phone'></i><input type='tel' name='fijo[]' placeholder='(999) 99-99-99-99-99'></label><a style='cursor: pointer;color: red;' onclick='delete_telefono(" + id + ")'>Eliminar <i class='fa fa-minus'></i></a></section>");
                                                                        }

                                                                        id++;
                                                                    }
                                                                    function delete_telefono(id) {
                                                                        $("#tel_" + id + "").remove();
                                                                    }


                                                                    $(function ()
                                                                    {
                                                                        a = new Date();
                                                                        año = a.getFullYear() - 18;
                                                                        $("#datepicker").datepicker({
                                                                            changeMonth: true,
                                                                            numberOfMonths: 2,
                                                                            maxDate: año + "-12-31",
                                                                            dateFormat: "yy-mm-dd",
                                                                            changeYear: true,
                                                                            yearRange: "-99:+0",
                                                                        });
                                                                    });

                                                                    function check_keyword()
                                                                    {
                                                                        $("#msg_key").remove();
                                                                        $("#key_").append('<i id="ajax_" class="icon-append fa fa-spinner fa-spin"></i>');

                                                                        var keyword = $("#keyword").val();
                                                                        $.ajax({
                                                                            type: "POST",
                                                                            url: "/ov/perfil/use_keyword",
                                                                            data: {keyword: keyword},
                                                                        })
                                                                                .done(function (msg)
                                                                                {
                                                                                    $("#msg_key").remove();
                                                                                    $("#key").append("<p id='msg_key'>" + msg + "</msg>");
                                                                                    $("#ajax_").remove();
                                                                                });
                                                                    }
                                                                    function check_keyword_co()
                                                                    {
                                                                        $("#msg_key_co").remove();
                                                                        $("#key_1").append('<i id="ajax_1" class="icon-append fa fa-spinner fa-spin"></i>');
                                                                        var keyword = $("#keyword_co").val();
                                                                        $.ajax({
                                                                            type: "POST",
                                                                            url: "/ov/perfil/use_keyword",
                                                                            data: {keyword: keyword},
                                                                        })
                                                                                .done(function (msg)
                                                                                {
                                                                                    $("#msg_key_co").remove();
                                                                                    $("#key_co").append("<p id='msg_key_co'>" + msg + "</msg>");
                                                                                    $("#ajax_1").remove();
                                                                                });
                                                                    }


                                                                    function detalles(id)
                                                                    {
                                                                        $.ajax({
                                                                            type: "POST",
                                                                            url: "/ov/perfil/detalle_usuario",
                                                                            data: {id: id},
                                                                        })
                                                                                .done(function (msg)
                                                                                {
                                                                                    bootbox.dialog({
                                                                                        message: msg,
                                                                                        title: "Detalles",
                                                                                        buttons: {
                                                                                            success: {
                                                                                                label: "Cerrar!",
                                                                                                className: "btn-success",
                                                                                                callback: function () {
                                                                                                    //location.href="";
                                                                                                }
                                                                                            }
                                                                                        }
                                                                                    });
                                                                                });
                                                                    }

                                                                    function editar_curriculo() {
                                                                        $('.click2edit').summernote({focus: true});
                                                                    }
                                                                    ;
                                                                    function guardar_curriculo() {
                                                                        var aHTML = $('.click2edit').code(); //save HTML If you need(aHTML: array).
                                                                        $("#curriculo_html").html("<input value='" + aHTML + "' type='hidden' name='curriculo'>");
                                                                        $('.click2edit').destroy();
                                                                    }
                                                                    ;

</script>

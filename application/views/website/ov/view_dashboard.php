<?php

$ci = &get_instance ();
$ci->load->model ( "model_permissions" );
?>
<!-- MAIN CONTENT -->
<div id="content">

	<!-- row -->
	<div class="row">
		<br />
		<br />
		<br />
	</div>
	<!-- end row -->
	<div class="row">
		<div class="col-sm-12">
			<div class="well well-sm">
				<div class="row">
					<div class="col-sm-12 col-md-12 col-lg-6">
						<div class="well well-light well-sm no-margin no-padding">
							<div class="row">
								<div class="col-sm-12">
									<div id="myCarousel" class="carousel fade profile-carousel">
										<div class="air air-top-left padding-10">
											<h4 class="txt-color-white font-md"></h4>
										</div>
										<div class="carousel-inner">
											<!-- Slide 1 -->
											<div class="item active">
												<img src="/media/imagenes/m3.jpg" alt="demo user">
											</div>
										</div>
									</div>
								</div>

								<div class="col-sm-12">

									<div class="row">

										<div class="col-sm-3 profile-pic">
											<img class="<?php if($actividad) echo "online";?>"
												src="<?=$user?>" alt="demo user">
											<div class="padding-10">
												<a style="padding: 6px 2rem 6px 6px;"
													href="/ov/perfil_red/foto"><i
													class="fa fa-camera fa-2x fa-fw fa-lg"></i></a> <br>
												<br>
												<h4 class="font-md">
													<strong><?=$id?></strong> <br> <small>ID</small>
												</h4>
											</div>
										</div>
										<div class="col-sm-4">
											<h1><?=$usuario[0]->nombre?> <span class="semi-bold"><?=$usuario[0]->apellido?></span>
												<br> <small> <?php //echo $nivel_actual_red?></small>
											</h1>

											<ul class="list-unstyled ">
												<li>
													<div class="demo-icon-font">
														<img class="flag flag-<?=strtolower($pais)?>">
													</div>
												</li>
												<li>
													<p class="text-muted">
														<i class="fa fa-phone"></i>&nbsp;&nbsp;(<span
															class="txt-color-darken"><?=$telefono?></span>)</span>
													</p>
												</li>
												<li>
													<p class="text-muted">
														<i class="fa fa-envelope"></i>&nbsp;&nbsp;<a><?=$email?></a>
													</p>
												</li>
												<li>
													<p class="text-muted">
														<i class="fa fa-user"></i>&nbsp;&nbsp;<span
															class="txt-color-darken"><?=$username?></span>
													</p>
												</li>
												<li>
													<p class="text-muted">
														<i class="fa fa-calendar"></i>&nbsp;&nbsp;<span
															class="txt-color-darken">Ultima sesión: <a
															href="javascript:void(0);" rel="tooltip" title=""
															data-placement="top"
															data-original-title="Create an Appointment"><?=$ultima?></a></span>
													</p>
												</li>
												
												<div class="row">
													<br>
													
													
													<div class="col-sm-12">

														<br>

													</div>

												</div>
											</ul>
											<br>
										</div>
										
									</div>
								</div>
							</div>
						</div>
					</div>
					<div class="col-sm-12 col-md-12 col-lg-6">
						<!--Inica la secciion de la perfil y red-->
						<div class="well"
							style="box-shadow: 0px 0px 0px !important; border-color: transparent;">
							<fieldset>
								<legend>
									<b>Muro</b>
								</legend>
								<div class="row">
									<div role="widget"
										class="jarviswidget jarviswidget-color-blueDark jarviswidget-sortable"
										id="wid-id-1" data-widget-editbutton="false"
										data-widget-fullscreenbutton="false">
										<header role="heading">
											<div role="menu">
												<a data-toggle="dropdown" href="javascript:void(0);"></a>
												<ul
													class="dropdown-menu arrow-box-up-right color-select pull-right">
													<li><span class="bg-color-green"
														data-widget-setstyle="jarviswidget-color-green"
														rel="tooltip" data-placement="left"
														data-original-title="Green Grass"></span></li>
													<li><span class="bg-color-greenDark"
														data-widget-setstyle="jarviswidget-color-greenDark"
														rel="tooltip" data-placement="top"
														data-original-title="Dark Green"></span></li>
													<li><span class="bg-color-greenLight"
														data-widget-setstyle="jarviswidget-color-greenLight"
														rel="tooltip" data-placement="top"
														data-original-title="Light Green"></span></li>
													<li><span class="bg-color-purple"
														data-widget-setstyle="jarviswidget-color-purple"
														rel="tooltip" data-placement="top"
														data-original-title="Purple"></span></li>
													<li><span class="bg-color-magenta"
														data-widget-setstyle="jarviswidget-color-magenta"
														rel="tooltip" data-placement="top"
														data-original-title="Magenta"></span></li>
													<li><span class="bg-color-pink"
														data-widget-setstyle="jarviswidget-color-pink"
														rel="tooltip" data-placement="right"
														data-original-title="Pink"></span></li>
													<li><span class="bg-color-pinkDark"
														data-widget-setstyle="jarviswidget-color-pinkDark"
														rel="tooltip" data-placement="left"
														data-original-title="Fade Pink"></span></li>
													<li><span class="bg-color-blueLight"
														data-widget-setstyle="jarviswidget-color-blueLight"
														rel="tooltip" data-placement="top"
														data-original-title="Light Blue"></span></li>
													<li><span class="bg-color-teal"
														data-widget-setstyle="jarviswidget-color-teal"
														rel="tooltip" data-placement="top"
														data-original-title="Teal"></span></li>
													<li><span class="bg-color-blue"
														data-widget-setstyle="jarviswidget-color-blue"
														rel="tooltip" data-placement="top"
														data-original-title="Ocean Blue"></span></li>
													<li><span class="bg-color-blueDark"
														data-widget-setstyle="jarviswidget-color-blueDark"
														rel="tooltip" data-placement="top"
														data-original-title="Night Sky"></span></li>
													<li><span class="bg-color-darken"
														data-widget-setstyle="jarviswidget-color-darken"
														rel="tooltip" data-placement="right"
														data-original-title="Night"></span></li>
													<li><span class="bg-color-yellow"
														data-widget-setstyle="jarviswidget-color-yellow"
														rel="tooltip" data-placement="left"
														data-original-title="Day Light"></span></li>
													<li><span class="bg-color-orange"
														data-widget-setstyle="jarviswidget-color-orange"
														rel="tooltip" data-placement="bottom"
														data-original-title="Orange"></span></li>
													<li><span class="bg-color-orangeDark"
														data-widget-setstyle="jarviswidget-color-orangeDark"
														rel="tooltip" data-placement="bottom"
														data-original-title="Dark Orange"></span></li>
													<li><span class="bg-color-red"
														data-widget-setstyle="jarviswidget-color-red"
														rel="tooltip" data-placement="bottom"
														data-original-title="Red Rose"></span></li>
													<li><span class="bg-color-redLight"
														data-widget-setstyle="jarviswidget-color-redLight"
														rel="tooltip" data-placement="bottom"
														data-original-title="Light Red"></span></li>
													<li><span class="bg-color-white"
														data-widget-setstyle="jarviswidget-color-white"
														rel="tooltip" data-placement="right"
														data-original-title="Purity"></span></li>
													<li><a href="javascript:void(0);"
														class="jarviswidget-remove-colors" data-widget-setstyle=""
														rel="tooltip" data-placement="bottom"
														data-original-title="Reset widget color to default">Remove</a></li>
												</ul>
											</div>
											<span class="widget-icon"> <i
												class="fa fa-comments txt-color-white"></i>
											</span>
											<h2>Notificaciones</h2>
											<div role="menu">
												<!-- add: non-hidden - to disable auto hide -->
												<div>

													<ul class="dropdown-menu pull-right js-status-update">
														<li><a href="javascript:void(0);"><i
																class="fa fa-circle txt-color-green"></i> Online</a></li>
														<li><a href="javascript:void(0);"><i
																class="fa fa-circle txt-color-red"></i> Busy</a></li>
														<li><a href="javascript:void(0);"><i
																class="fa fa-circle txt-color-orange"></i> Away</a></li>
														<li class="divider"></li>
														<li><a href="javascript:void(0);"><i
																class="fa fa-power-off"></i> Log Off</a></li>
													</ul>
												</div>
											</div>
											<span style="display: none;" class="jarviswidget-loader"><i
												class="fa fa-refresh fa-spin"></i></span>
										</header>
										<!-- widget div-->
										<div style="display: block;" role="content">
											<!-- widget edit box -->
											<div class="jarviswidget-editbox">
												<div>
													<label>Title:</label> <input type="text">
												</div>
											</div>
											<!-- end widget edit box -->
											<div class="widget-body widget-hide-overflow no-padding">
												<!-- content goes here -->
												<!-- CHAT CONTAINER -->
												<div id="chat-container">
													<span><i class="fa fa-user"></i><b>!</b></span>
													<div class="chat-list-footer">
														<div class="control-group">
															<form class="smart-form">
																<section>
																	<label class="input"> <input id="filter-chat-list"
																		placeholder="Filter" type="text">
																	</label>
																</section>
															</form>
														</div>
													</div>
												</div>
												<!-- CHAT BODY -->
												<div id="chat-body" class="chat-body custom-scroll">
													<span id="" class="activity-dropdown"> <i
														class="fa fa-user"></i> Afiliados En Mi Red <b
														class="badge bg-color-red bounceIn animated"> <?php echo $numeroAfiliadosRed;?> </b>
													</span>
													<ul>
																    <?php
																				
																				foreach ( $notifies as $notify ) {
																					$fecha_inicio = substr ( $notify->fecha_inicio, 0, 10 );
																					$fecha_fin = substr ( $notify->fecha_fin, 0, 10 );
																					if (date ( "Y-m-d" ) >= $fecha_inicio && date ( "Y-m-d" ) <= $fecha_fin) {
																						echo '<li class="message">
																		<img src="/media/imagenes/notificacion.png" style="width: 5rem;" class="online" alt="">
																		<div class="message-text">
																			<time>
																				' . $fecha_inicio . '
																			</time> 
																				<a href="javascript:void(0);" class="username">' . $notify->nombre . '</a> 
																				' . $notify->descripcion . '
																		</div>
																	</li>';
																					}
																				}
																				?>		
																	

																	<?php
																	foreach ( $cuentasPorPagar as $cuenta ) {
																		echo '<li class="message">
																		<img src="/template/img/notificaciones/icon-deuda.png" style="width: 5rem;" class="online" alt="">
																		<div class="message-text">
																			<time>
																				' . $cuenta->fecha . '
																			</time> 
																				<a href="/ov/cabecera/email" class="username">Enviar Comprobante de Pago</a>
																				<br>
																				<span>Realizar la consignacion bancaria a </span><br>
																				<span>Banco  : <b>' . $cuenta->nombreBanco . '</b>,</span><br> 
																				<span>Cuenta : <b>' . $cuenta->cuenta . '</b>,</span><br>
																		';
																		if ($cuenta->otro)
																			echo '<span>Titular:	<b>' . $cuenta->otro . '</b>,</span><br>';
																		if ($cuenta->clabe)
																			echo '<span>Clabe:	<b>' . $cuenta->clabe . '</b>,</span><br>';
																		if ($cuenta->swift)
																			echo '<span>SWIFT:	<b>' . $cuenta->swift . '</b>,</span><br>';
																		if ($cuenta->dir_postal)
																			echo '<span>Dirección postal  :<b>' . $cuenta->dir_postal . '</b>,</span><br>';
																		echo '<span>Valor:	<b> $ ' . $cuenta->valor . '</b>,</span>
																		</div>
																	</li>';
																	}
																	?>																
																	
																	
																</ul>
												</div>
											</div>
										</div>
									</div>
								</div>
							</fieldset>
						</div>
						
						<!--Termina la secciion de perfil y red-->
					</div>
				</div>
			</div>
		</div>
	</div>
	<!-- end row -->
	<div>
		<div class="row">
			<div class="col-sm-12 col-md-12 col-lg-12">
				<div class="row">
					<div class="col-sm-12 col-md-12 col-lg-12">
						<!--Inica la secciion de la perfil y red-->
						<div class="well" style="">
							
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
	<div class="row">
		<!-- a blank row to get started -->
		<div class="col-sm-12">
			<br /> <br />
		</div>
	</div>
</div>
<!-- END MAIN CONTENT -->
<script>
function detalles(id)
{
	$.ajax({
		type: "POST",
		url: "/ov/perfil_red/detalle_usuario",
		data: {id: id},
	})
	.done(function( msg )
	{
		bootbox.dialog({
			message: msg,
			title: "Información Personal",
			buttons: {
				success: {
					label: "Cerrar!",
					className: "btn-success",
					callback: function() {
					//location.href="";
				}
			}
		}
	});
	});
}
</script>

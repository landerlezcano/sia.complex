
<!-- MAIN CONTENT -->
<div id="content">
	<div class="row">
		<div class="col-xs-12 col-sm-9 col-md-9 col-lg-9">
			<h1 class="page-title txt-color-blueDark">
				<a class="backHome" href="/bo"><i class="fa fa-home"></i> Menu</a> <span> > Red </span>
			</h1>
		</div>
	</div>
	<div class="well">
 <fieldset>
	<legend>Red</legend>
						<div class="row">
						<? foreach ($redes as $red ) { ?>
						<div class="col-lg-4 col-sm-4 col-md-4 col-xs-12">
							<a href="/ov/red/mi_red?id=<?= $red->id ?>">
								<div
									class="well well-sm txt-color-white text-center link_dashboard"
									style="background: <?=$style[0]->btn_2_color?>">
									<i class="fa fa-sitemap fa-3x"></i>
									<h5><?= $red->nombre;?></h5>
								</div>
							</a>
						</div>
						<?php } ?>
					</div>
		</fieldset>
</div>
</div>

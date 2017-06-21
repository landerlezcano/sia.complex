<!-- MAIN CONTENT -->
<div id="content" >

    <!-- row -->
    <div class="row">
        <br /><br /><br />
    </div>
    <!-- end row -->

    <div class="row">
        <div class="col-sm-12">
            <div class="well well-sm">
                <div class="row">
                    <div class="col-sm-12 col-md-12 col-lg-4" style="margin-top: 2rem;">
                        <div class="well well-light well-sm no-margin no-padding">
                            <div class="row">
                                <div class="col-sm-12">
                                    <div id="myCarousel" class="carousel fade profile-carousel">
                                        <div class="air air-top-left padding-10">
                                            <h4 class="txt-color-white font-md"></h4>
                                        </div>
                                        <div style="max-height: 100%;" class="carousel-inner">
                                            <!-- Slide 1 -->
                                            <div class="item active">
                                                <img src="/logo.jpg" alt="demo user">
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-sm-12">

                                    <div class="row">
                                        <div class="col-sm-3">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-12 col-md-12 col-lg-8">
                        <!--Inica la secciion de la perfil y red-->
                        <div class="well" style="box-shadow: 0px 0px 0px !important;border-color: transparent;">
                            <fieldset>
                                <legend><b>Sistema Integrado de Administración CUAM</b></legend>
                                <div class="row">
                                    <div class="col-sm-4">
                                        <a href="configuracion/">
                                            <div class="minh well well-sm txt-color-white text-center link_dashboard" style="background:<?= $style[0]->btn_2_color ?>">
                                                <i class="fa fa-wrench fa-5x"></i>
                                                <h3>Configuración</h3>
                                            </div>
                                        </a>
                                    </div>

                                    
                                    <div class="col-sm-4">
                                        <a href="altas/">
                                            <div class="minh well well-sm txt-color-white text-center link_dashboard" style="background:<?= $style[0]->btn_2_color ?>">
                                                <i class="fa fa-edit fa-5x"></i>
                                                <h3>Altas</h3>
                                            </div>
                                        </a>
                                    </div>

                                    <div class="col-sm-4">
                                        <a href="/bo/reportes">
                                            <div class="minh well well-sm txt-color-white text-center link_dashboard" style="background:<?= $style[0]->btn_2_color ?>">
                                                <i class="fa fa-book fa-5x"></i>
                                                <h3>Reportes</h3>
                                            </div>
                                        </a>
                                    </div>
                                </div>
                            </fieldset>
                            <!--Termina la sección de perfil y red-->
                            <footer>
                                <h3><b><i class="fa fa-home fa-3x"></i> Total Sedes :</b><i> <?php echo $afiliados[0]->total; ?></i></h3>
                            </footer>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- end row -->
        <div>
        </div>
    </div>
    <div class="row">
        <!-- a blank row to get started -->
        <div class="col-sm-12">
            <br />
            <br />
        </div>
    </div>
</div>
<!-- END MAIN CONTENT -->
<style>
    .minh
    {
        padding: 50px;
    }
    .link a:hover
    {
        text-decoration: none !important;
    }
</style>

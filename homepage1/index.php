
        <!--[if lt IE 7]>
            <p class="browsehappy">You are using an <strong>outdated</strong> browser. Please <a href="http://browsehappy.com/">upgrade your browser</a> to improve your experience.</p>
        <![endif]-->

        <!-- Add your site or application content here -->

         <!-- header Start
         ================================================= -->

        <section id="header">
            <div class="container">
                <div class="row">
                    <div class="col-md-6">
                        <div class="block-left">
							<nav class="navbar navbar-default" role="navigation">
							  <div class="container-fluid">
								<!-- Brand and toggle get grouped for better mobile display -->
								<div class="navbar-header">
								  <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1">
									<span class="sr-only">Toggle navigation</span>
									<span class="icon-bar"></span>
									<span class="icon-bar"></span>
									<span class="icon-bar"></span>
								  </button>
								  <div class="nav-logo" width="10" height="10">
									<a href="#"><img src="img/logo.png" alt="logo"></a>
								  </div>
								</div>

							</nav>
                        </div>
                    </div><!-- .col-md-6 -->

                    <div class="col-md-6">
                        <div class="block-right">
                            <div class="contact-area">
                                <ul>
                                    <li><i class="fa fa-phone-square"></i>+383-49-123-456</li>
                                    <li><i class="fa fa-envelope-o"></i>theappteam@gmail.com</li>
                                </ul>
                            </div>
                        </div>
                    </div><!-- .col-md-6 close -->
                </div><!-- .row close -->
            </div><!-- .container close -->
        </section><!-- #heder close -->

        <!-- Slider Start
        ============================================================== -->

        <section id="slider">
            <div class="container">
                <div class="row">
                    <div class="col-md-12">
                        <div class="block">
                            <div class="slider-text-area">
                                <div class="slider-text">
                                    <h2>APP TEAM<br></h2>
                                    <p class="sub-slider-text">Ideja më moderne!</p>
                                    <p class="slider-p">Me anë të APP Team, ju mund lehtë të bleni dhe porosisni <br>
                                    pjesë të ndryshmë për telefon. Duke e regjistruar dhe downloaduar aplikacionin tonë  <br>
                                    ju mund ti çaseni poashtu shumë sherbimeve tona.</p>
                                    <button type="button" class="btn btn-default edit-button-1"><a href="../shopping/index.php">BLENI</a></button>
                                </div>
                            </div>
                        </div>
                    </div><!-- .col-md-12 close -->
                </div><!-- .row close -->
            </div><!-- .container close -->
        </section><!-- #slider close -->




        <!-- Gallery Start
        ============================================================= -->

        <section id="gallery">
            <div class="container">
                <div class="row">
                    <div class="col-md-12">
                        <div class="block-top">
                            <div class="gallery-area">
                                <h1>Ofertat tona me te reja!</h1>
                                <p>Duke shtypur <b>butonin</b> poshte ju do te shkoni ne faqen per te blere produktin. <br />
                            </div>
                        </div>
                    </div><!-- .col-md-12 -->
                </div><!-- .row close -->
                <div class="row">
                    <div class="col-md-12">
                        <div class="block-bottom">
                            <div class="gallery-list" id="owl-demo">
                              <?php
                              include 'C:\xampp\htdocs\shopping\config.php';
                              $stmt=$conn->prepare("SELECT * FROM product WHERE oferta !='' ");
                              $stmt->execute();
                              $result=$stmt->get_result();
                              while($row=$result->fetch_assoc()){
                                ?>
                                <div class="gallery-items item">

                                    <div class="gallery-img">
                                      <span style="position:absolute; top:40px;left:25px;background:red;color:white;font-size:2em;">&nbsp; <?= $row['oferta'] ?>&nbsp; </span>

                                        <img src="<?= $row['product_image'] ?>" alt="img">
                                    </div>
                                    <div class="gallery-items-text">
                                      <p style="font-weight:bold; color:black;"><?= $row['product_name'] ?> NE CMIM SHUME TE LIRE <i style="color:grey">(Oferta mbaron pas <?= $row['oferta'] ?>/oreve)</i></p><Br>
                                        <button type="button" name="button"><a href="../shopping/index.php" style="font-weight: bold; size:40%">Bleni</a></button>
                                    </div>
                                </div><?php } ?>
                              </div>
                            </div>
                        </div>
                    </div><!-- .col-md-12 close -->
                </div><!-- .row close -->
            </div><!-- .container close -->
        </section><!-- #gallery close -->

        <section id="contant-2">
            <div class="container">
                <div class="row">
                    <div class="col-md-6">
                        <div class="block-left">
                            <div class="contant-2-img">
                                <img src="img/photo3.jpg" alt="img">
                            </div>
                        </div>
                    </div><!-- .col-md-6 close -->

                    <div class="col-md-6">
                        <div class="block-right">
                            <div class="contant-2-text-area">
                                <div class="contant-2-header">
                                    <h1>Ne ofrojme edhe servisime te shumta!<br>
                                </div>
                                <div class="contant-2-text">
                                   <h2>Jeni nevoje te disa pajisjeve per servisim <b>klikoni butonin poshte.</b></h3>
                                   <button type="button" class="btn btn-default edit-button-3"><a href="../shopping/servisimi.php">SERVISIMI</button>
                                </div>
                            </div>
                        </div>
                    </div><!-- .col-md-6 close -->
                </div><!-- .row close -->
            </div><!-- .container close -->
        </section><!-- #contant-2 close -->

        <section id="contant-1">
            <div class="container">
                <div class="row">
                    <div class="col-md-6">
                        <div class="block-left">
                            <div class="contant-1-text-area">
                                <div class="contant-1-head">
                                    <h1>Qellimi yne.. <br> Per ju!</h1>
                                </div>
                                <div class="contant-1-text">
                                    <h2>APP Team mundeson edhe dergesa pa nevoje per <br> kredit kartele.</h2>
                                    <p>Pas selektimit te produktit vendosni menyren e blerjes ne, <br /> paguaj pas porosise dhe veq pasi ta pranoni porosine dhe jeni te kenaqur, <br /> ju mund te kryeni pagesen e caktuar <br /> per produktin e juaj </p>

                                </div>
                            </div>
                        </div>
                    </div><!-- .col-md-6 close -->
                    <div class="col-md-6">
                        <div class="block-right">
                            <div class="block-right-img">
                                <img src="img/photo4.png" alt="img">
                            </div>
                        </div>
                    </div><!-- .col-md-6 close -->
                </div><!-- .row close -->
            </div><!-- .container close -->
        </section><!-- #contant-1 close -->


        <!-- Contant-2 Start
        =============================================================== -->



        <!-- testimonial Start
        ============================================================= -->

        <section id="testimonial">
            <div class="container">
                <div class="row">
                    <div class="col-md-12">
                        <div class="block">
                            <div class="testimonial-area">
                                <div class="tm-header">
                                    <h2>Cfare thone njerzit per ne?</h2>
                                </div>
                                <div class="tm-contant">
									<div class="tm-contant-items" id="slide-testimonial">
										<div class="tm-contant-list item">
											<div class="tm-img">
												<img src="img/profile.jpg" alt="img">
											</div>
											<div class="tm-text">
												<p>" Eshte nje nder apps me te lehte per tu perdorur! " <span>- Jack Rodney</span></p>
											</div>
										</div>
										<div class="tm-contant-list item">
											<div class="tm-img">
												<img src="img/profile2.jpeg" alt="img">
											</div>
											<div class="tm-text">
												<p>" Webfaqja me moderne deri me tani! " <span>- Ola Viks</span></p>
											</div>
										</div>
										<div class="tm-contant-list item">
											<div class="tm-img">
												<img src="img/pepole-img.png" alt="img">
											</div>
											<div class="tm-text">
												<p>" Pres qe se shpejti ta beni te ditur lokacionin e zyres suaj " <span>- Rona Burgundy</span></p>
											</div>
										</div>
									</div>
                                </div>
                            </div>
                        </div>
                    </div><!-- .col-md-12 close -->
                </div><!-- .row close -->
            </div><!-- .container close -->
        </section><!-- #testimonial close -->
<?php
include 'stdlib.php';

$site = new csite();

initialise_site($site);

$site->render();
?>

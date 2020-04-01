<?php
    $current_year = date('Y');
    $current_month = date('M');
    $current_day = date('d');
?>
    <link href="<?= base_url('assets/css/main.css') ?>" rel="stylesheet">
    <script type="text/javascript" src="<?= base_url('NewAssets/jquery'); ?>"></script>
    <!-- <nav class="navbar navbar-default navbar-fixed-top" id="myScrollspy">
        <div class="container">
            <div class="navbar-header">
                <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar">
                    <span class="sr-only">Toggle navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button> -->
                <!-- <img  class="login-logo navbar-brand img-size" src="<?= base_url('assets/images/popcom_logo-white.png')?>" alt="POPCOM_LOGO" style="width: 50%;" /> -->
            <!-- </div>
            <div id="navbar" class="navbar-collapse collapse">
                <ul class="nav navbar-nav navbar-right margin-t12">
                    <li><a href="<?=base_url('login/loginUser')?>">Login</a></li>
                </ul>
            </div>
        </div>
    </nav> -->

    <section class="container">
        <div class="row">
            <div class="col-xs-12 col-sm-6 padding-10p">
                <?php 
                    echo form_open(
                        $action = 'Login/loginUser',
                        $params = array(
                            'id' => 'login_form',
                            'class'=>'needs-validation',
                            'method' => 'post'
                        )
                    );
                ?>
                    <div class="login-form">
                        <div class="panel panel-default panel-login box-shadow">
                            <div class="panel-heading" >
                                <div class="row">
                                    <div class="col-xs-12 text-center">
                                        <img class="login-logo" src="<?=base_url('assets/images/login_logo.png')?>" alt="POPCOM_LOGO" width="10%">
                                    </div>
                                </div>
                            </div>
                            <div class="panel-body">
                                <div class="row">
                                    <div class="col-xs-12">
                                        <div class="login-form-holder">
                                            <div class="form-group text-center wrap-input100 validate-input">
                                                <input class="input100 form-control" type="text" name="<?=POST_USERNAME?>" placeholder="Username" required />
                                                <span class="focus-input100"></span>
                                                <span class="symbol-input100">
                                                    <i class="fa fa-smile-o"></i>
                                                </span>
                                            </div>
                                            <div class="form-group text-center wrap-input100 validate-input">
                                                <input class="input100 form-control" type="password" name="<?=POST_USERPASSWORD?>" placeholder="Password" required />
                                                <span class="focus-input100"></span>
                                                <span class="symbol-input100">
                                                    <i class="fa fa-lock"></i>
                                                </span>
                                            </div>
                                        </div>
                                        <script src="<?=CAPTCHA_API?>" async defer></script>
                                        <div class="g-recaptcha" data-sitekey="<?=CAPTCHA_CLIENT?>"></div>
                                        <div class="container-login100-form-btn">
                                            <button type="submit" class="login100-form-btn">
                                                Login
                                            </button>
                                        </div>
                                         <div class="errors">
                                            <?php echo validation_errors(); ?>
                                        </div>
                                        <div>
                                            <br>
                                            <p class="small text-center" >Copyright © 2019-Present. <br>Commission on Population and Development<br>Republic of the Philippines</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                <?php echo form_close(); ?>
            </div>
            <div class="col-xs-12 col-sm-6 padding-10p0">
                <h3 class="sans">Welcome to the Online RPFP Monitoring System Release Version 3.0</h3>
                <br>
                <p class="sans subheader">A Project of the RPFP (Responsible Parenthood and Family Planning) Program of the Commission on Population and Development</p>
                <br>
                <br>
                    <img class="dashboard-logo" src="<?=base_url('assets/images/executive_dashboard.jpg')?>" alt="Link to Executive Dashboard" width="5%">
                <br><br>
                    <img class="dashboard-logo" src="<?=base_url('assets/images/public_dashboard.jpg')?>" alt="Link to Public Dashboard" width="5%">
            </div>
        </div>
    </section>
<!-- 
    <section class="bg-img">
        <div class="container margin-t7 statisticsReport" >
            <div class="row">    
                <div class="col-md-12 col-sm-12 col-xs-12 border-1"> 
                    <div class="col-md-12 col-sm-12 col-xs-12">   
                        <div class="row">
                            <div class="col-sm-12 text-center">
                                <br>
                                <h4>Statistical Snapshot</h4>
                                <br>
                            </div>
                        </div> 
                    </div>
            
                    <div class="col-md-6 col-sm-12 col-xs-12"> 
                        <div class="row">
                            <div class="col-xs-9 col-sm-9">
                                <p>Couples encoded as of FY <?= $current_year; ?></p>
                                <p>Couples encoded as of Jan 1 to <?= $current_month; ?> <?= $current_day; ?>, <?= $current_year; ?></p>
                            </div>
                            <div class="col-xs-3 col-sm-3 text-right">
                                <p>1,563,385</p>
                                <p>270,532</p>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-sm-12">
                                <br>
                                <h5><b>Type of Participant for Yr <?= $current_year; ?></b></h5>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-xs-9 col-sm-9 padding-l5p">                              
                                <p><i class="fa fa-angle-double-right"></i> &nbsp; 4Ps:</p>
                                <p><i class="fa fa-angle-double-right"></i> &nbsp; Non-4Ps:</p>
                                <p><i class="fa fa-angle-double-right"></i> &nbsp; FBOs:</p>
                                <p><i class="fa fa-angle-double-right"></i> &nbsp; PMC:</p>
                                <p><i class="fa fa-angle-double-right"></i> &nbsp; Usapan Serye:</p>
                                <p><i class="fa fa-angle-double-right"></i> &nbsp; Others:</p>
                                <p style="color: red;"><b>TOTAL</b></p>
                            </div>
                            <div class="col-xs-3 col-sm-3 text-right">
                                <p>140,462</p>
                                <p>60,817</p>
                                <p>196</p>
                                <p>45,671</p>
                                <p>7,020</p>
                                <p>16,366</p>
                                <p style="color: red;"><b>555,460</b></p>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-sm-12">
                                <br>
                                <h5><b>Intention to Use for Yr <?= $current_year; ?></b></h5>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-xs-9 col-sm-9b padding-l5p">
                                <p><i class="fa fa-angle-double-right"></i> &nbsp; Intention to Use FP Method</p>
                                <p><i class="fa fa-angle-double-right"></i> &nbsp; Undecided</p>
                                <p><i class="fa fa-angle-double-right"></i> &nbsp; Currently Pregnant</p>
                                <p><i class="fa fa-angle-double-right"></i> &nbsp; No Intention to Use FP Method</p>
                            </div>
                            <div class="col-xs-3 col-sm-3 text-right">
                                <p>27,427</p>
                                <p>43,274</p>
                                <p>6,607</p>
                                <p>63,178</p>
                            </div>
                        </div>

                        <div class="row">
                            <br>
                        </div>
                    </div>
                    <div class="col-md-6 col-sm-12 col-xs-9">  -->
                        <!-- <div class="row">
                            <div class="col-xs-9 col-sm-9">
                                <h5><b>Summary of FP Users</b></h5>
                            </div>
                            <div class="col-xs-3 col-sm-3 text-right">
                                
                            </div>
                        </div> -->
<!-- 
                        <div class="row">
                            <div class="col-sm-12">
                                <h5><b>Modern FP Users for Yr <?= $current_year; ?></b></h5>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-xs-9 col-sm-9 padding-l5p">
                                <p><i class="fa fa-angle-double-right"></i> &nbsp; Condom:</p>
                                <p><i class="fa fa-angle-double-right"></i> &nbsp; IUD: </p>
                                <p><i class="fa fa-angle-double-right"></i> &nbsp; Pills:</p>
                                <p><i class="fa fa-angle-double-right"></i> &nbsp; Injectable:</p>
                                <p><i class="fa fa-angle-double-right"></i> &nbsp; Vasectomy:</p>
                                <p><i class="fa fa-angle-double-right"></i> &nbsp; Tubal Ligation:</p>
                                <p><i class="fa fa-angle-double-right"></i> &nbsp; Implant:</p>
                                <p><i class="fa fa-angle-double-right"></i> &nbsp; CMM/Billings: </p>
                                <p><i class="fa fa-angle-double-right"></i> &nbsp; BBT:</p>
                                <p><i class="fa fa-angle-double-right"></i> &nbsp; Sympto-Thermal:</p>
                                <p><i class="fa fa-angle-double-right"></i> &nbsp; SDM:</p>
                                <p><i class="fa fa-angle-double-right"></i> &nbsp; LAM:</p>
                                <p style="color: red;"><b>TOTAL</b></p>
                            </div>
                            <div class="col-xs-3 col-sm-3 text-right">
                                <p>10,681</p>
                                <p>3,373</p>
                                <p>6,415</p>
                                <p>1,243</p>
                                <p>1,106</p>
                                <p>120,920</p>
                                <p>10,681</p>
                                <p>3,373</p>
                                <p>6,415</p>
                                <p>1,243</p>
                                <p>1,106</p>
                                <p>120,920</p>
                                <p style="color: red;"><b>390,820</b></p>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-sm-12">
                                <br>
                                <h5><b>Non-Modern FP Users for Yr <?= $current_year; ?></b></h5>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-xs-9 col-sm-9 padding-l5p">
                                <p><i class="fa fa-angle-double-right"></i> &nbsp; Withdrawal:</p>
                                <p><i class="fa fa-angle-double-right"></i> &nbsp; Rhythm: </p>
                                <p><i class="fa fa-angle-double-right"></i> &nbsp; Calendar:</p>
                                <p><i class="fa fa-angle-double-right"></i> &nbsp; Abstinence:</p>
                                <p><i class="fa fa-angle-double-right"></i> &nbsp; Herbal:</p>
                                <p><i class="fa fa-angle-double-right"></i> &nbsp; No Method:</p>
                                <p style="color: red;"><b>TOTAL</b></p>
                            </div>
                            <div class="col-xs-3 col-sm-3 text-right">
                                <p>10,681</p>
                                <p>3,373</p>
                                <p>6,415</p>
                                <p>1,243</p>
                                <p>1,106</p>
                                <p>120,920</p>
                                <p style="color: red;"><b>190,820</b></p>
                            </div>
                        </div>

                        <div class="row">
                            <br>
                        </div>
                    </div>
                </div>
            </div> -->
            <!-- <div class="col-xs-12 col-sm-12 col-md-12">
                <div class="row">
                    <form class="form-horizontal form-label-left">
                        <div class="form-group">
                            <br>
                            <label class="control-label col-md-9 col-sm-9 col-xs-12 text-right margin-t7">Choose Year</label>
                            <div class="input-group col-md-3 col-sm-3 col-xs-12">
                                <select class="form-control">
                                    <?php for ($i = $current_year; $i > 2011; $i--): ?>
                                        <option value="<?=$i?>"><?= $i?></option>
                                    <?php endfor?>
                                </select>
                                <span class="input-group-btn">
                                    <button type="button" class="btn btn-primary btn-hover">Go</button>
                                </span>
                            </div>
                        </div>
                    </form>
                </div>
                <div class="row">
                    <br>
                    <h4 class="text-center">PERCENTAGE OF COUPLES ENCODED FOR YEAR <?= $current_year; ?></h4>
                    <br><br>
                    <div id="graph"></div>
                </div>
            </div>
            <div class="col-xs-12 col-sm-12 col-md-12">
                <div class="row">
                   <br>
                   <br>
                </div>
            </div> -->
        </div>
        <!-- <script>
            loadJs(base_url + 'NewAssets/templateJs', function() {
                loadJs(base_url + 'assets/js/graphJs/raphael-min.js', function() {
                    loadJs(base_url + 'assets/js/graphJs/morris.min.js', function() {
                        loadJs(base_url + 'assets/js/barGraph.js');
                    });
                });
            });  
        </script> -->
    </section>

    <!-- <footer>
        <p class="footer">Copyright © 2019-Present. <br>Commission on Population and Development, Republic of the Philippines</p>
    </footer> -->
</body>

<script>
    // $(function(){
    //     var navbar = $('.navbar');

    //     $(window).scroll(function(){
    //         if($(window).scrollTop() <= 40){
    //             navbar.removeClass('navbar-scroll');
    //         } else {
    //             navbar.addClass('navbar-scroll');
    //         }
    //     });
    // });
</script>
<script type="text/javascript" src="<?= base_url('NewAssets/bootstrapJs')?>"></script>
<script type="text/javascript" src="<?= base_url('NewAssets/sweetalertJs')?>"></script>
<script type="text/javascript" src="<?= base_url('NewAssets/popper')?>"></script>
<script type="text/javascript" src="<?= base_url('assets/js/login.js')?>"></script>

</html>
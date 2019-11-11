        <link href="<?= base_url('assets/css/main.css') ?>" rel="stylesheet">
        <style>
            body {
                background: darkgreen;
                overflow: hidden;
            }
        </style>
        <div class="container margin-t8p">
            <div class="row margin-top-100">
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
                    <div class="col-xs-12 col-sm-4 col-sm-offset-4">
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
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <?php echo form_close();?>
            </div>
        </div>       
    </body>
    <script type="text/javascript" src="<?= base_url('NewAssets/bootstrapJs')?>"></script>
    <script type="text/javascript" src="<?= base_url('NewAssets/sweetalertJs')?>"></script>

    <script type="text/javascript" src="<?= base_url('NewAssets/popper')?>"></script>
    <script type="text/javascript" src="<?= base_url('assets/js/login.js')?>"></script>
</html>
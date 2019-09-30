        <link href="<?= base_url('assets/css/main.css') ?>" rel="stylesheet">
        <div class="limiter">
            <div class="container-login100">
                <div class="wrap-login100">
                    <div class="login100-pic js-tilt p-top40" data-tilt>
                        <img src="<?= base_url('assets/images/popcom_logo.png') ?>" alt="IMG">
                    </div>
                    <?php
                        echo form_open(
                            $action = 'Login/loginUser',
                            $params = array(
                                'id' => 'login_form',
                                'class'=>'login100-form needs-validation',
                                'method' => 'post'
                            )
                        );
                        ?>
                        <span class="login100-form-title">
                            <h4>RPFP Online Login</h4>
                        </span>
                        <div class="form-group wrap-input100 validate-input">
                            
                            <input class="input100 form-control" type="text"
                                    name="<?=POST_USERNAME?>" placeholder="Username"
                            required />
                            <span class="focus-input100"></span>
                            <span class="symbol-input100">
                                <i class="fa fa-smile-o"></i>
                            </span>
                        </div>
                        <div class="form-group wrap-input100 validate-input">
                            <input class="input100 form-control" type="password"
                                name="<?=POST_USERPASSWORD?>" placeholder="Password"
                            required />
                            <span class="focus-input100"></span>
                            <span class="symbol-input100">
                                <i class="fa fa-lock"></i>
                            </span>
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
                    </form>
                </div>
            </div>
        </div>
    </body>
    <script type="text/javascript" src="<?= base_url('NewAssets/bootstrapJs')?>"></script>
    <script type="text/javascript" src="<?= base_url('NewAssets/sweetalertJs')?>"></script>

    <script type="text/javascript" src="<?= base_url('NewAssets/popper')?>"></script>
    <script type="text/javascript" src="<?= base_url('assets/js/login.js')?>"></script>
</html>
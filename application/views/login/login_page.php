<?php
defined('BASEPATH') or exit('No direct script access allowed');
?><!DOCTYPE html>
<html lang="en">
<head>
    <title>Login - HRMIS</title>
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
    <meta http-equiv="content-type" content="text/html; charset=UTF-8">
    <meta charset="utf-8">
    </head>
<body>
    <div class="container">
        <div class="row margin-top-100">
            <?php echo form_open('login/loginUser', array("id" => "login_form")); ?>
            <div class="login-form">
                <div class="col-xs-12 col-sm-4 col-sm-offset-4">
                    <div class="panel panel-default panel-login box-shadow">
                        <div class="panel-heading" >
                            <div class="row">
                                <div class="col-xs-12 text-center">
                                    <img class="login-logo" src="<?=base_url('assets/images')?>/hrmislogo.png">
                                </div>
                            </div>
                        </div>
                        <div class="panel-body">
                            <div class="row">
                                <div class="col-xs-12">
                                    <div class="login-form-holder">
                                        <div class="form-group text-center">
                                            <div class="input-group">
                                                <input type="text" class="form-control form-control-lg" placeholder="Username" name="<?=POST_USERNAME?>" />
                                                <span class="input-group-addon" ><i class="material-icons">person</i></span>
                                            </div>
                                        </div>
                                        <div class="form-group text-center">
                                            <div class="input-group margin-top-10">
                                                <input type="password" class="form-control" placeholder="Password" name="<?=POST_USERPASSWORD?>" />
                                                <span class="input-group-addon" ><i class="material-icons">lock</i></span>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group warning-message text-center btn-danger padding-5">
                                        <?php echo validation_errors(); ?>
                                    </div>
                                    <div class="form-group">
                                        <a id="login-button" class="btn btn-success form-control" onclick="$('#login_form').submit();" href="#">
                                            Login
                                        </a>
                                    </div>
                                    <div>
                                        <p class="text-center"><?= date('l M d, Y')?> <span id="clock" class="text-bold"></span></p>
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
<script>
    document.onkeydown=function(evt){
        var keyCode = evt ? (evt.which ? evt.which : evt.keyCode) : event.keyCode;
        if(keyCode == 13)
        {
            $('#login_form').submit();
        }
    }
</script>
</html>

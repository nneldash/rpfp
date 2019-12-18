<!DOCTYPE html>
<html lang="en">
<?php

CONST MY_PROFILE = 'profile';
CONST MY_PENDING = 'pending';
CONST MY_APPROVE = 'approve';
CONST MY_ACCOMPLISHMENT = 'accomplishment';
CONST MY_FORM_A = 'forma';
CONST MY_FORM_B = 'formb';
CONST MY_FORM_C = 'formc';

$links = array(
    MY_PROFILE => '#/Menu/profile',
    MY_PENDING => '#/Menu/pending',
    MY_APPROVE => '#/Menu/approve',
    MY_ACCOMPLISHMENT => '#/Menu/accomplishment',
    MY_FORM_A => '#/Menu/forma',
    MY_FORM_B => '#/Menu/formb',
    MY_FORM_C => '#/Menu/formc'
);

$profile = UserProfile::getFromVariable(empty($profile) ? BLANK : $profile);

$default_tab = $links[MY_PENDING];
if ($profile->isRegionalDataManager()) {
    $default_tab = $links[MY_APPROVE];
}

if (empty($title)) {
    $title = 'Online RPFP Monitoring System';
}

?>    
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">        
        <title><?= $title; ?></title>

        <link rel="icon" href="<?= base_url('assets/images/logo.png') ?>" type="image/gif">

        <script type="text/javascript" src="<?= base_url('assets/js/scriptLoader.js')?>"></script>

        <link href="<?= base_url('NewAssets/bootstrapCss'); ?>" rel="stylesheet" />
        <link href="<?= base_url('NewAssets/nProgress'); ?>" rel="stylesheet" />
        <link href="<?= base_url('NewAssets/customCss'); ?>" rel="stylesheet" />
        <link href="<?= base_url('NewAssets/fontAwesome'); ?>" rel="stylesheet" />
        <link href="<?= base_url('assets/css/style.css'); ?>" rel="stylesheet" />

        <link href="<?= base_url('NewAssets/datatablesBootstrap'); ?>" rel="stylesheet" />
        <link href="<?= base_url('NewAssets/datatablesResponsive'); ?>" rel="stylesheet" />

        <script>
            loadJs(base_url + 'NewAssets/templateJs', function() {
                window.default_tab = '<?= $default_tab ?>';
                loadJs(base_url + 'assets/js/menu.js', function() {
                    loadJs(base_url + 'NewAssets/nProgressJs', function() {
                        loadJs(base_url + 'NewAssets/bootstrapJs', function() {
                            loadJs(base_url + 'NewAssets/progressBarJs', function() {
                                loadJs(base_url + 'NewAssets/customJs', function() {
                                    loadJs(base_url + 'assets/js/systemTimeout.js');
                                });
                            });
                        });
                    });
                });
            });
        </script>

    </head>

    <body class="nav-sm" style="background: #fff;">
        <div class="container body">
            <div class="main_container">
                <div class="col-md-3 left_col">
                    <div class="left_col scroll-view">
                        <div class="navbar nav_title" style="border: 0;">
                          <a href="#" class="site_title">
                                <img src="<?=base_url('assets/images/logo.png')?>" style="width:22%" > 
                                <span>POPCOM</span>
                            </a>
                        </div>
                        <div class="clearfix"></div>
                        <br />
                        <div id="sidebar-menu" class="main_menu_side hidden-print main_menu">
                            <div class="menu_section">
                                <ul class="nav side-menu">
                                    <li>
                                        <a href="<?= $links[MY_PROFILE] ?>">
                                            <i class="fa fa-user"></i> Profile
                                        </a>
                                    </li>
                                    <?php if ($profile->isRegionalDataManager()) : ?>
                                        <li>
                                        <a href="<?= $links[MY_PENDING] ?>">
                                                <i class="fa fa-clock-o"></i> Pending
                                            </a>
                                        </li>
                                        <li>
                                            <a href="<?= $links[MY_APPROVE] ?>">
                                                <i class="fa fa-thumbs-o-up"></i> Approved
                                            </a>
                                        </li>
                                        <li>
                                            <a href="<?= $links[MY_FORM_A] ?>">
                                                <i class="fa fa-clipboard"></i> Form A
                                            </a>
                                        </li>
                                        <li>
                                            <a href="<?= $links[MY_FORM_B] ?>">
                                                <i class="fa fa-clipboard"></i> Form B
                                            </a>
                                        </li>
                                        <li>
                                            <a href="<?= $links[MY_FORM_C] ?>">
                                                <i class="fa fa-clipboard"></i> Form C
                                            </a>
                                        </li>
                                    <?php endif; ?>
                                    <?php if ($profile->isPMED()) : ?>
                                        <li>
                                            <a href="<?= $links[MY_FORM_A] ?>">
                                                <i class="fa fa-clipboard"></i> Form A
                                            </a>
                                        </li>
                                        <li>
                                            <a href="<?= $links[MY_FORM_B] ?>">
                                                <i class="fa fa-clipboard"></i> Form B
                                            </a>
                                        </li>
                                        <li>
                                            <a href="<?= $links[MY_FORM_C] ?>">
                                                <i class="fa fa-clipboard"></i> Form C
                                            </a>
                                        </li>
                                    <?php endif; ?>
                                    <?php if ($profile->isEncoder()) :?>
                                        <li>
                                            <a href="<?= base_url('forms')?>">
                                                <i class="fa fa-venus-mars"></i> Add Couple
                                            </a>
                                        </li>
                                        <li>
                                        <a href="<?= $links[MY_PENDING] ?>">
                                                <i class="fa fa-clock-o"></i> Pending
                                            </a>
                                        </li>
                                        <li>
                                        <a href="<?= $links[MY_APPROVE] ?>">
                                                <i class="fa fa-thumbs-o-up"></i> Approved
                                            </a>
                                        </li>
                                        <li>
                                        <a href="<?= $links[MY_ACCOMPLISHMENT] ?>">
                                                <i class="fa fa-clipboard"></i> Accomplishment Report
                                            </a>
                                        </li>
                                    <?php endif; ?>
                                    <?php if ($profile->isITDMU()) :?>
                                        <li>
                                            <a href="<?= base_url('forms')?>">
                                                <i class="fa fa-venus-mars"></i> RPFP Users
                                            </a>
                                        </li>
                                    <?php endif; ?>
                                    <li>
                                        <a href="<?= base_url('login/logoffUser')?>">
                                            <i class="fa fa-sign-out"></i> Logout
                                        </a>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="right_col" role="main">
                    <div class="clearfix"></div>
                    <div class="row">
                        <div class="col-md-12 col-sm-12 col-xs-12">
                            <div class="x_panel">
                                <div class="x_content">
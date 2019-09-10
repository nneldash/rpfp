<!DOCTYPE html>
<html lang="en">
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">        
        <title><?= $title; ?></title>

        <link rel="icon" href="<?= base_url('assets/images/logo.png') ?>" type="image/gif">
        <link href="<?= base_url('NewAssets/bootstrapCss') ?>" rel="stylesheet">
        <link href="<?= base_url('NewAssets/nProgress') ?>" rel="stylesheet">
        <link href="<?= base_url('NewAssets/customCss') ?>" rel="stylesheet">

        <link href="node_modules/gentelella/vendors/font-awesome/css/font-awesome.min.css" rel="stylesheet">

        <script type="text/javascript" src="<?= base_url('NewAssets/templateJs')?>"></script>
        <script type="text/javascript" src="<?= base_url('NewAssets/bootstrapJs')?>"></script>
    </head>

    <style>
        .nav-sm .navbar.nav_title a img {
            width: 80%!important;
        }
        .nav-sm .container.body .col-md-3.left_col {
            position: fixed!important;
        }
    </style>

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
                                        <a href="<?= base_url('menu')?>">
                                            <i class="fa fa-hourglass-start"></i> Pending
                                        </a>
                                    </li>
                                    <li>
                                        <a href="<?= base_url('menu/approve')?>">
                                            <i class="fa fa-thumbs-o-up"></i> Approved
                                        </a>
                                    </li>
                                    <li>
                                        <a>
                                            <i class="fa fa-file-text-o"></i> Summary
                                        </a>
                                    </li>
                                    <li>
                                        <a href="<?= base_url('logoffUser')?>">
                                            <i class="fa fa-sign-out"></i> Logout
                                        </a>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
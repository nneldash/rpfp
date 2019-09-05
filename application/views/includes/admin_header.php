<!DOCTYPE html>
<html lang="en">
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        <!-- Meta, title, CSS, favicons, etc. -->
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>Gentelella Alela! | </title>

        <link href="<?= base_url('NewAssets/bootstrapCss') ?>" rel="stylesheet">
        <link href="node_modules/gentelella/vendors/font-awesome/css/font-awesome.min.css" rel="stylesheet">
        <link href="node_modules/gentelella/vendors/nprogress/nprogress.css" rel="stylesheet">
        <link href="node_modules/gentelella/build/css/custom.min.css" rel="stylesheet">
    </head>

    <style>
        .nav-sm .navbar.nav_title a img {
            width: 80%!important;
        }
    </style>

    <body class="nav-md" style="background: #fff;">
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

                        <!-- sidebar menu -->
                        <div id="sidebar-menu" class="main_menu_side hidden-print main_menu">
                            <div class="menu_section">
                                <ul class="nav side-menu">
                                    <li><a><i class="fa fa-rocket"></i> Announcement <span class="fa fa-chevron-down"></span></a>
                                        <ul class="nav child_menu">
                                            <li><a href="#">Dashboard</a></li>
                                            <li><a href="#">Dashboard2</a></li>
                                            <li><a href="#">Dashboard3</a></li>
                                        </ul>
                                    </li>
                                </ul>
                            </div>
                        </div>
                        <!-- /sidebar menu -->
                    </div>
                </div>

                <!-- top navigation -->
                <div class="top_nav">
                    <div class="nav_menu">
                        <nav>
                            <div class="nav toggle">
                                <a id="menu_toggle"><i class="fa fa-bars"></i></a>
                            </div>

                            <ul class="nav navbar-nav navbar-right">
                                <li class="">
                                    <a href="javascript:;" class="user-profile dropdown-toggle" data-toggle="dropdown" aria-expanded="false">
                                        <img src="images/img.jpg" alt="">John Doe
                                        <span class=" fa fa-angle-down"></span>
                                    </a>
                                    <ul class="dropdown-menu dropdown-usermenu pull-right">
                                        <li><a href="login.html"><i class="fa fa-sign-out pull-right"></i> Log Out</a></li>
                                    </ul>
                                </li>
                            </ul>                        
                        </nav>
                    </div>    
                </div>
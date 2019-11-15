        <link href="<?= base_url('assets/css/main.css') ?>" rel="stylesheet">
        <script type="text/javascript" src="<?= base_url('NewAssets/jquery'); ?>"></script>
        <nav class="navbar navbar-default navbar-fixed-top" id="myScrollspy">
            <div class="container">
                <div class="navbar-header">
                    <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar">
                        <span class="sr-only">Toggle navigation</span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                    </button>
                    <!-- <img  class="login-logo navbar-brand img-size" src="<?= base_url('assets/images/popcom_logo-white.png')?>" alt="POPCOM_LOGO" style="width: 50%;" /> -->
                </div>
                <div id="navbar" class="navbar-collapse collapse">
                    <ul class="nav navbar-nav navbar-right margin-t12">
                        <li><a href="<?=base_url('login/loginUser')?>">Login</a></li>
                    </ul>
                </div>
            </div>
        </nav>

        <section class="bg-img">
            <div class="container">
                <div class="row">
                    <div class="col-xs-12 header-margin">
                        <h3 class="sans">Welcome to the Online RPFP Monitoring System Release Version 3.0</h3>
                        <p class="sans subheader">A Project of the Responsible Parenthood and Family Planning Program of the Commission on Population and Development</p>
                    </div>
                </div>
            </div>

            <div class="container padding-b5p">
                <div class="row">
                    <div class="col-xs-12"> 
                        <h3 class="ora">Announcements</h3>
                        <p class="small">News and updates from the POPCOM head office.</p>
                    </div>
                </div>
                <div class="row announce-margin">
                    <div class="col-xs-12" style="padding: 0">
                        <div class="col-xs-1 text-right" style="padding-left: 0; width: 1%">
                            <span><i class="fa fa-bookmark-o"></i></span>
                        </div>
                        <div class="col-xs-9">
                            <p class="small">September 3, 2019</p>
                            <p class="small flex">
                                Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod
                                tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam,
                                quis nostrud exercitation
                            </p>
                        </div>
                        <div class="col-xs-2"></div>
                    </div>
                    <div class="col-xs-12 margin-t15" style="padding: 0">
                        <div class="col-xs-1 text-right" style="padding-left: 0; width: 1%">
                            <span><i class="fa fa-bookmark-o"></i></span>
                        </div>
                        <div class="col-xs-9">
                            <p class="small">September 3, 2019</p>
                            <p class="small flex">
                                Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod
                                tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam,
                                quis nostrud exercitation
                            </p>
                        </div>
                        <div class="col-xs-2"></div>
                    </div>
                    <div class="col-xs-12 margin-t15" style="padding: 0">
                        <div class="col-xs-1 text-right" style="padding-left: 0; width: 1%">
                            <span><i class="fa fa-bookmark-o"></i></span>
                        </div>
                        <div class="col-xs-9">
                            <p class="small">September 3, 2019</p>
                            <p class="small flex">
                                Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod
                                tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam,
                                quis nostrud exercitation
                            </p>
                        </div>
                        <div class="col-xs-2"></div>
                    </div>
                </div>
            </div>
        </section>

        <footer>
            <p class="footer">Copyright © 2019-Present. <br>Commission on Population and Development, Republic of the Philippines</p>
        </footer>
    </body>

    <script>
        $(function(){
            var navbar = $('.navbar');

            $(window).scroll(function(){
                if($(window).scrollTop() <= 40){
                    navbar.removeClass('navbar-scroll');
                } else {
                    navbar.addClass('navbar-scroll');
                }
            });
        });
    </script>
    <script type="text/javascript" src="<?= base_url('NewAssets/bootstrapJs')?>"></script>
    <script type="text/javascript" src="<?= base_url('NewAssets/sweetalertJs')?>"></script>

</html>
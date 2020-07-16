<?php
defined('BASEPATH') or exit('No direct script access allowed');

$current_year = date('Y');
$current_month = date('M');
$current_day = date('d');
if (empty($title)) {
    $title = 'Online RPFP Monitoring System | Dashboard';
}
?>
<script>document.querySelector("head title").innerHTML = '<?=$title?>';</script>
<style>
    .border-1 {
        border: 1px solid #333;
    }
    p {
        margin-bottom: 0;
    }
    h5 {
        margin-top: 20px;
        margin-bottom: 0;
    }
    .fa {
        margin-left: 5%;
    }
    .btn-hover {
        border-radius: 0;
        background: #2a3e53;
    }
    .btn-hover:hover {
        color: #333;
        border: 1px solid #2a3e53;
        background: #fff;
    }
    .margin-t7 {
        margin-top: 7px;
    }
    .nav.side-menu>li.active>a {
        background: linear-gradient(#355633,#2f572c),#2b542a!important;
    }
    .left_col, .nav_title {
        background: #095017;
    }
</style>

<div class="container margin-t7 statisticsReport" >
    <div class="row">
        <div class="col-xs-12 text-center">
            <img class="login-logo" style="width: 30%" src="<?=base_url('assets/images/login_logo.png')?>" alt="POPCOM_LOGO" width="10%">
            <hr>
            <h3>PUBLIC DASHBOARD</h3>
            <hr>
            <br>    
        </div> 
        <div class="col-md-12 col-sm-12 col-xs-12 border-1"> 
            <div class="col-md-12 col-sm-12 col-xs-12">   
                <div class="row">
                    <div class="col-sm-12">
                        <br>
                        <h4><center>Statistical Snapshot</center></h4>
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
                        <h5>Type of Participant for Yr <?= $current_year; ?></h5>
                    </div>
                </div>

                <div class="row">
                    <div class="col-xs-9 col-sm-9">                              
                        <p><i class="fa fa-angle-double-right"></i> &nbsp; 4Ps:</p>
                        <p><i class="fa fa-angle-double-right"></i> &nbsp; Non-4Ps:</p>
                        <p><i class="fa fa-angle-double-right"></i> &nbsp; FBOs:</p>
                        <p><i class="fa fa-angle-double-right"></i> &nbsp; PMC:</p>
                        <p><i class="fa fa-angle-double-right"></i> &nbsp; Usapan Serye:</p>
                        <p><i class="fa fa-angle-double-right"></i> &nbsp; Others:</p>
                        <h5 style="color: red;"><b>TOTAL</b></h5>
                    </div>
                    <div class="col-xs-3 col-sm-3 text-right">
                        <p>140,462</p>
                        <p>60,817</p>
                        <p>196</p>
                        <p>45,671</p>
                        <p>7,020</p>
                        <p>16,366</p>
                        <h5 style="color: red;"><b>555,460</b></h5>
                    </div>
                </div>

                <div class="row">
                    <div class="col-sm-12">
                        <h5>Intention to Use for Yr <?= $current_year; ?></h5>
                    </div>
                </div>

                <div class="row">
                    <div class="col-xs-9 col-sm-9">
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
            <div class="col-md-6 col-sm-12 col-xs-9"> 
                <div class="row">
                    <div class="col-sm-12">
                        <h5>Modern FP Users for Yr <?= $current_year; ?></h5>
                    </div>
                </div>

                <div class="row">
                    <div class="col-xs-9 col-sm-9">
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
                        <h5 style="color: red;"><b>TOTAL</b></h5>
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
                        <h5 style="color: red;"><b>390,820</b></h5>
                    </div>
                </div>

                <div class="row">
                    <div class="col-sm-12">
                        <h5>Non-Modern FP Users for Yr <?= $current_year; ?></h5>
                    </div>
                </div>

                <div class="row">
                    <div class="col-xs-9 col-sm-9">
                        <p><i class="fa fa-angle-double-right"></i> &nbsp; Withdrawal:</p>
                        <p><i class="fa fa-angle-double-right"></i> &nbsp; Rhythm: </p>
                        <p><i class="fa fa-angle-double-right"></i> &nbsp; Calendar:</p>
                        <p><i class="fa fa-angle-double-right"></i> &nbsp; Abstinence:</p>
                        <p><i class="fa fa-angle-double-right"></i> &nbsp; Herbal:</p>
                        <p><i class="fa fa-angle-double-right"></i> &nbsp; No Method:</p>
                        <h5 style="color: red;"><b>TOTAL</b></h5>
                    </div>
                    <div class="col-xs-3 col-sm-3 text-right">
                        <p>10,681</p>
                        <p>3,373</p>
                        <p>6,415</p>
                        <p>1,243</p>
                        <p>1,106</p>
                        <p>120,920</p>
                        <h5 style="color: red;"><b>190,820</b></h5>
                    </div>
                </div>

                <div class="row">
                    <br>
                </div>
            </div>
        </div>
    </div>

    <!-- Bar Graph 1 -->
    <div class="col-xs-12 col-sm-12 col-md-12">
        <div class="row">
            <form class="form-horizontal form-label-left">
                <div class="form-group">
                    <br>
                    <br>
                    <label class="control-label col-md-9 col-sm-9 col-xs-12 text-right margin-t7">Choose Year</label>
                    <div class="input-group col-md-3 col-sm-3 col-xs-12">
                        <select class="form-control" id="percentage_year"> 
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
            <h4 class="text-center">PERCENTAGE OF COUPLES ENCODED/TARGETS/REACHED</h4>
            <br><br>
            <canvas id="barGraph1"></canvas>
        </div>
    </div>

    <!-- Bar Graph 2 -->
    <div class="col-xs-12 col-sm-12 col-md-12">
        <div class="row">
            <form class="form-horizontal form-label-left">
                <div class="form-group">
                    <br>
                    <br>
                    <label class="control-label col-md-9 col-sm-9 col-xs-12 text-right margin-t7">Choose Year</label>
                    <div class="input-group col-md-3 col-sm-3 col-xs-12">
                        <select class="form-control" id="percentage_year"> 
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
            <h4 class="text-center">NUMBER OF COUPLES/INDIVIDUALS REACHED</h4>
            <br><br>
            <canvas id="barGraph2"></canvas>
        </div>
    </div>

    <!-- Pie 1 -->
    <div class="col-xs-12 col-sm-12 col-md-12">
        <div class="row">
            <form class="form-horizontal form-label-left">
                <div class="form-group">
                    <br>
                    <br>
                    <label class="control-label col-md-9 col-sm-9 col-xs-12 text-right margin-t7">Choose Year</label>
                    <div class="input-group col-md-3 col-sm-3 col-xs-12">
                        <select class="form-control" id="percentage_year"> 
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
            <h4 class="text-center">METHOD MIX</h4>
            <br><br>
            <canvas id="pieChart1"></canvas>
        </div>
    </div>

    <!-- Bar Graph 3 -->
    <div class="col-xs-12 col-sm-12 col-md-12">
        <div class="row">
            <form class="form-horizontal form-label-left">
                <div class="form-group">
                    <br>
                    <br>
                    <label class="control-label col-md-9 col-sm-9 col-xs-12 text-right margin-t7">Choose Year</label>
                    <div class="input-group col-md-3 col-sm-3 col-xs-12">
                        <select class="form-control" id="percentage_year"> 
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
            <h4 class="text-center">WRA by Age Group</h4>
            <br><br>
            <canvas id="barGraph3"></canvas>
        </div>
    </div>

    <!-- Bar Graph 4 -->
    <div class="col-xs-12 col-sm-12 col-md-12">
        <div class="row">
            <form class="form-horizontal form-label-left">
                <div class="form-group">
                    <br>
                    <br>
                    <label class="control-label col-md-9 col-sm-9 col-xs-12 text-right margin-t7">Choose Year</label>
                    <div class="input-group col-md-3 col-sm-3 col-xs-12">
                        <select class="form-control" id="percentage_year"> 
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
            <h4 class="text-center">Unmet Need vs Served</h4>
            <br><br>
            <canvas id="barGraph4"></canvas>
        </div>
    </div>

    <div class="col-xs-12 col-sm-12 col-md-12">
        <div class="row">
           <br>
           <br>
        </div>
    </div>
</div>
<script>
    loadJs(base_url + 'NewAssets/templateJs', function() {
        loadJs(base_url + 'NewAssets/chartJS', function() {
            loadJs(base_url + 'assets/js/barGraph.js');
        });
    });  
</script>

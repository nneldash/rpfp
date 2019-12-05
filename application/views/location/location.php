<?php
    $data = $data;
    if (empty($data)) {
        $data = array (
            USERNAME => 'TEST',
            TIME_STAMP => 'TEST',
            LOC_LIST => array()
        );
    }
?>

<div class="container margin-t8p">
        <ul class="nav navbar-nav navbar-left margin-t12">
            <li><a class="save" href="https://psa.gov.ph/classification/psgc/">PSGC Reference</a></li>
        </ul>
</div>

<div class="body-padding">    
    <div class="">
        <div class="row">
            <div class="col padding-r3p padding-b8">
                <p class="small text-right">Locations - Region</p>
            </div>
        </div>        
        <div class="padding-t20">
            <div class="table-responsive">    
                <table class="table table-bordered margin-b0">
                    <thead>
                        <tr>
                            <th rowspan="3" class="text-center padding-0">
                                <p class="small">Region Code</p>                                    
                            </th>
                            <th colspan="7" class="text-center padding-0">
                                <p class="small">
                                    <b>
                                        Region Name
                                    </b>
                                </p>
                            </th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                            foreach ($data[LOC_LIST] as $region) {
                                $region = SpecificLocation::getFromVariable($region)->Region;
                        ?>
                        <tr>
                            <td class="text-center">
                                <p class="small">
                                    <b>
                                        <?= $region->Code ?>
                                    <b>
                                </p>
                            </td>
                            <td class="text-center">
                                <p class="small">
                                    <b>
                                        <?= $region->Description ?>
                                    <b>
                                </p>
                            </td>
                        </tr>
                        <?php
                            }
                        ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>    
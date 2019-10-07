<?php
    $profile = UserProfile::getProfileFromVariable($profile);
?>
<section class="content">
    <div class="container-fluid">
        <div class="row clearfix">
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                <div class="card">
                    <div class="header">
                        <h2>
                            Profile
                        </h2>
                    </div>
                    <div class="body text-12">
                        <form class="form-horizontal">
                            <div class="form-group form-float col-sm-offset-1">
                                <label class="col-sm-2 control-label">Name: </label>
                                <div class="col-sm-8">
                                    <input type="text" class="form-control" name="employee_name" value="<?= $profile->Firstname == N_A ? 'NOT LOGGED IN' : ucwords(strtolower($profile->Firstname)) ?>" readonly />
                                </div>
                            </div>
                            <div class="form-group form-float col-sm-offset-1">
                                <label class="col-sm-2 control-label">User: </label>
                                <div class="col-sm-8">
                                    <input type="text" class="form-control" name="employee_number" value="<?= $profile->User_id == N_A ? 'NOT LOGGED IN' : $profile->User_id ?>" readonly />
                                </div>
                            </div>
                            <div class="form-group form-float col-sm-offset-1">
                                <label class="col-sm-2 control-label">Position</label>
                                <div class="col-sm-8">
                                    <input type="text" class="form-control" name="position" value="" readonly />
                                </div>
                            </div>
                            <div class="form-group form-float col-sm-offset-1">
                                <label class="col-sm-2 control-label">Office: </label>
                                <div class="col-sm-8">
                                    <input type="text" class="form-control" name="office" value="" readonly />
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
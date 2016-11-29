<div class="panel panel-default">
    <div class="panel-heading">
        <h5 class="panel-title"><?= $title ?></h5>
    </div>
    <div class="panel-body">

        <form id="form" class="form-horizontal" action="<?= Uri::current() ?>" accept-charset="utf-8" method="post" name="form">

            <div class="form-group">
                <div class="col-sm-2 col-sm-offset-2">
                    <label class="control-label" for="form_hire_date">Hire date</label>
                </div>
                <div class="col-sm-6">
                    <input class="form-control datepicker" placeholder="Hire date" name="hire_date" value="<?= e(Input::post('hire_date', isset($staff)) && $staff['hire_date'] ? date("Y/m/d", strtotime($staff['hire_date'])) : '') ?>" type="text" id="form_hire_date" />

                    <?php if($val->error('hire_date')):?>
                        <p class="alert alert-warning"><?= $val->error('hire_date'); ?></p>
                    <?php endif; ?>
                </div>
            </div>

            <div class="form-group">
                <div class="col-sm-2 col-sm-offset-2">
                    <label class="control-label" for="form_staff_no">Staff No</label>
                </div>
                <div class="col-sm-6">
                    <input class="form-control" placeholder="Staff No" name="staff_no" value="<?= e(Input::post('staff_no', isset($staff)) ? sprintf('%07d', $staff['staff_no']) : '') ?>" type="text" id="form_staff_no" />
                    <?php if($val->error('staff_no')):?>
                        <p class="alert alert-warning"><?= $val->error('staff_no'); ?></p>
                    <?php endif; ?>
                </div>
            </div>

            <div class="form-group">
                <div class="col-sm-2 col-sm-offset-2">
                    <label class="control-label" for="form_name">Name</label>
                </div>
                <div class="col-sm-6">
                    <input class="form-control" placeholder="Name" name="name" value="<?= e(Input::post('name', isset($staff)) ? $staff['name'] : '') ?>" type="text" id="form_name" />
                    <?php if($val->error('name')):?>
                        <p class="alert alert-warning"><?= $val->error('name'); ?></p>
                    <?php endif; ?>
                </div>
            </div>

            <div class="form-group">
                <div class="col-sm-2 col-sm-offset-2">
                    <label class="control-label" for="form_department">Department</label>
                </div>
                <div class="col-sm-6">
                    <select class="form-control" name="department" id="form_department">
                        <option value="">Select</option>
                        <?php foreach ($department_arr as $key => $value):?>
                        <option value="<?= $key ?>"<?= (Input::post('department', isset($staff) ? $staff['department'] : '')) == $key ? ' selected="selected"' : '' ?>><?= $value ?></option>
                        <?php endforeach; ?>
                    </select>
                    <?php if($val->error('department')):?>
                        <p class="alert alert-warning"><?= $val->error('department'); ?></p>
                    <?php endif; ?>
                </div>
            </div>

            <div class="form-group">
                <div class="col-sm-2 col-sm-offset-2">
                    <label class="control-label" for="form_gender">Gender</label>
                </div>
                <div class="col-sm-6">
                    <?php foreach ($gender_arr as $key => $value):?>
                    <label class="radio-inline" for="form_gender_<?= $key ?>">
                        <?= $value ?><input id="form_gender_<?= $key ?>" name="gender" value="<?= $key ?>" type="radio"<?= (Input::post('gender', isset($staff) ? $staff['gender'] : '')) == $key ? ' checked="checked"' : '' ?> />
                    </label>
                    <?php endforeach; ?>
                    <?php if($val->error('gender')):?>
                        <p class="alert alert-warning"><?= $val->error('gender'); ?></p>
                    <?php endif; ?>
                </div>
            </div>

            <input name="fuel_csrf_token" value="<?= Security::fetch_token() ?>" type="hidden" id="form_fuel_csrf_token" />

            <div class="form-group">
                <div class="col-sm-offset-4 col-sm-6">
                    <input class="btn btn-success" name="check" value="Check" type="button" id="check_button" />
                </div>
            </div>

        </form>
    </div>
</div>

<?php echo Asset::js('staff.js'); ?>
<?php echo Asset::js('bootstrap-datepicker.js'); ?>
<?php echo Asset::js('setting_datepicker.js'); ?>
<?php echo Asset::css('datepicker.css'); ?>
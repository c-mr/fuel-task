<div class="panel panel-default">
    <div class="panel-heading">
        <h5 class="panel-title"><?= $title ?></h5>
    </div>
    <div class="panel-body">
        <form id="form" class="form-horizontal" action="<?= Uri::create('staff/'.$action) ?>" accept-charset="utf-8" method="post" name="conf_form">

            <div class="form-group">
                <div class="col-sm-2 col-sm-offset-2">
                    <label class="control-label" for="form_staff_no">Staff No</label>
                </div>
                <div class="col-sm-6">
                    <?= $staff_no ?>
                    <input name="staff_no" value="<?= $staff_no ?>" type="hidden" id="form_staff_no" />
                </div>
            </div>

            <div class="form-group">
                <div class="col-sm-2 col-sm-offset-2">
                    <label class="control-label" for="form_name">Name</label>
                </div>
                <div class="col-sm-6">
                    <?= $name ?>
                    <input name="name" value="<?= $name ?>" type="hidden" id="form_name" />
                </div>
            </div>

            <div class="form-group">
                <div class="col-sm-2 col-sm-offset-2">
                    <label class="control-label" for="form_department">Department</label>
                </div>
                <div class="col-sm-6">
                    <?= $department_arr[$department]; ?>
                    <input name="department" value="<?= $department ?>" type="hidden" id="form_department" />
                </div>
            </div>

            <div class="form-group">
                <div class="col-sm-2 col-sm-offset-2">
                    <label class="control-label" for="form_gender">Gender</label>
                </div>
                <div class="col-sm-6">
                    <?= $gender_arr[$gender]; ?>
                    <input name="gender" value="<?= $gender ?>" type="hidden" id="form_gender" />
                </div>
            </div>

            <input name="fuel_csrf_token" value="<?= Security::fetch_token() ?>" type="hidden" id="form_fuel_csrf_token" />

            <div class="form-group">
                <div class="col-sm-offset-3 col-sm-1">
                    <input class="btn btn-success" name="save" value="Save" type="button" id="save_button" />
                </div>
                <div class="col-sm-offset-1 col-sm-1">
                    <input class="btn btn-default" name="back" value="Back" type="button" id="back_button" />
                </div>
            </div>

        </form>

    </div>
</div>

<?php echo Asset::js('staff.js'); ?>
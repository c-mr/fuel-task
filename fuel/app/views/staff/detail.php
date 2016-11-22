<div class="panel panel-default">
    <div class="panel-heading">
        <h5 class="panel-title"><?= $title ?></h5>
    </div>
    <div class="panel-body">

        <table class="table table-bordered">
            <tbody>

                <tr>
                    <th class="active">Staff No</th>
                    <td><?= sprintf('%07d', $staff['staff_no']) ?></td>
                </tr>

                <tr>
                    <th class="active">Name</th>
                    <td><?= $staff['name'] ?></td>
                </tr>

                <tr>
                    <th class="active">Department</th>
                    <td><?= $department_arr[$staff['department']] ?></td>
                </tr>

                <tr>
                    <th class="active">Gender</th>
                    <td><?= $gender_arr[$staff['gender']] ?></td>
                </tr>

            </tbody>
        </table>

        <div class="row">
            <div class="col-sm-1">
                <?= Html::anchor('staff/edit/'.$staff['id'], 'Edit', ['class' => 'btn btn-primary']);?>
            </div>
            <div class="col-sm-1">
                <form id="form" class="form-horizontal" action="<?= Uri::create('staff/destory/'.$staff['id']) ?>" accept-charset="utf-8" method="post" name="delete_form">
                    <input name="fuel_csrf_token" value="<?= Security::fetch_token() ?>" type="hidden" id="form_fuel_csrf_token" />
                    <input name="id" value="<?= $staff['id'] ?>" type="hidden" id="id" />
                    <input class="btn btn-danger" name="delete_button" value="Delete" type="button" id="delete_button" />
                </form>
            </div>
        </div>

    </div>
</div>

<?php echo Asset::js('submit.js'); ?>
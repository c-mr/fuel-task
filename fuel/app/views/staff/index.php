<form id="form" class="form-horizontal" action="<?= Uri::current() ?>" accept-charset="utf-8" method="get" name="form">

<div id="serach_box" class="input-group">
    <span class="input-group-addon">Key Word</span>
    <input type="text" class="form-control" name="keyword" value="<?= e(Input::get('keyword') ? Input::get('keyword') : '') ?>" placeholder="Keyword">

    <span class="input-group-addon">
        <?php foreach ($gender_arr as $key => $value):?>
        <label style="padding-top: 0px;" class="radio-inline" for="form_gender_<?= $key ?>"><input id="form_gender_<?= $key ?>" name="gender" value="<?= $key ?>" type="radio"<?= Input::get('gender') == $key ? ' checked="checked"' : '' ?> /><?= $value ?></label>
        <?php endforeach; ?>
    </span>

    <span class="input-group-btn">
        <button type="button" class="btn btn-success" id="serach_button">Serach</button>
        <button type="button" class="btn btn-warning" id="reset_button">Reset</button>
    </span>
</div>

<table id="staffs-table" class="table table-striped">
    <thead>
        <tr>
            <th><span class="sort" id="sort_staff_no">Staff No</span><input value="staff_no" type="hidden" /></th>
            <th><span class="sort" id="sort_name">Name</span><input value="name" type="hidden" /></th>
            <th><span class="sort" id="sort_department">Department</span><input value="department" type="hidden" /></th>
            <th><span class="sort" id="sort_gender">Gender</span><input value="gender" type="hidden" /></th>
            <th>&nbsp</th>
        </tr>
    </thead>
    <tbody>
<?php
foreach ($staffs as $staff) {
?>
        <tr>
            <td><?= sprintf('%07d', $staff['staff_no']) ?></td>
            <td><?= $staff['name'] ?></td>
            <td><?= $department_arr[$staff['department']]; ?></td>
            <td><?= $gender_arr[$staff['gender']]; ?></td>
            <td><?php echo Html::anchor('staff/detail/'.$staff['id'],'Detail');?></td>
        </tr>
<?php
}
?>
    </tbody>
</table>
<input name="col" value="<?= e(Input::get('col') ? Input::get('col') : '') ?>" type="hidden" id="col" />
<input name="key" value="<?= e(Input::get('key') ? Input::get('key') : '') ?>" type="hidden" id="key" />


</form>

<?php echo Pagination::instance('pagination')->render(); ?>


<div class="row"><?php echo Html::anchor('staff/add','New Entry', ['class' => 'btn btn-primary']);?></div>

<?php echo Asset::js('staff.js'); ?>
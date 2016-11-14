<nav class="navbar navbar-default">
    <div class="container-fluid">
        <div class="navbar-header">
            <a class="navbar-brand" href="./">Staff List</a>
        </div>
    </div>
</nav>

<table class="table">
    <thead>
        <tr><th>社員番号</th><th>名前</th><th>部署</th><th>性別</th><th>&nbsp</th></tr>
    </thead>
    <tbody>
<?php
foreach ($staffs as $staff) {
?>
        <tr>
            <td><?= $staff["staff_no"] ?></td>
            <td><?= $staff["name"] ?></td>
            <td><?= $department_arr[$staff["department"]]; ?></td>
            <td><?= $gender_arr[$staff["gender"]]; ?></td>
            <td></td>
        </tr>
<?php
}
?>
    </tbody>
</table>

<?php echo Pagination::instance('pagination')->render(); ?>



<div><a class="btn btn-primary" href="./add">New Entry</a></div>
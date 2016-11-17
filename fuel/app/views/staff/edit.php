<div class="panel panel-default">
    <div class="panel-heading">
        <h5 class="panel-title"><?= $title ?></h5>
    </div>
    <div class="panel-body">

        <form class="form-horizontal" action="<?= Uri::current() ?>" accept-charset="utf-8" method="post">

<?= render('staff/_form'); ?>

        <input name="fuel_csrf_token" value="<?= Security::fetch_token() ?>" type="hidden" id="form_fuel_csrf_token" />
        <input name="act" value="update" type="hidden" id="form_act" />
        </form>

    </div>
</div>
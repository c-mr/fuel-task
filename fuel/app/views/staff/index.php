<ul class="nav nav-pills">
    <li class='<?php echo Arr::get($subnav, "index" ); ?>'><?php echo Html::anchor('staff/index','Index');?></li>
    <li class='<?php echo Arr::get($subnav, "detail" ); ?>'><?php echo Html::anchor('staff/detail','Detail');?></li>
    <li class='<?php echo Arr::get($subnav, "create" ); ?>'><?php echo Html::anchor('staff/create','Create');?></li>
    <li class='<?php echo Arr::get($subnav, "add" ); ?>'><?php echo Html::anchor('staff/add','Add');?></li>
    <li class='<?php echo Arr::get($subnav, "edit" ); ?>'><?php echo Html::anchor('staff/edit','Edit');?></li>
    <li class='<?php echo Arr::get($subnav, "update" ); ?>'><?php echo Html::anchor('staff/update','Update');?></li>
    <li class='<?php echo Arr::get($subnav, "destory" ); ?>'><?php echo Html::anchor('staff/destory','Destory');?></li>

</ul>
<p>Index</p>

<div><a class="btn btn-primary" href="./add">New Entry</a></div>
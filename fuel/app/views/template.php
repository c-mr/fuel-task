<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<title><?= $title ?></title>
	<?php echo Asset::css('bootstrap.css'); ?>
	<style>
		body { margin: 40px; }
	</style>
</head>
<body>
	<div class="container">
		<div class="col-md-12">
			<nav class="navbar navbar-default">
				<div class="container-fluid">
					<div class="navbar-header">
						<?php echo Html::anchor('./staff','Staff List', ['class' => 'navbar-brand']);?>
					</div>
				</div>
			</nav>
<?php echo $content; ?>
		</div>
		<footer>
		</footer>
	</div>
</body>
</html>

<?php

use app\helpers\Url;

?>
<h4 class="mb-10 font-weight-bold text-dark">
	<?= $activeStep['description'] ?>
</h4>



<h6 class="font-weight-bolder mb-3">
	General Information:
	<a href="<?= Url::current(['step' => 'general']) ?>">
		<i class="fa fa-edit"></i>
	</a>
</h6>
<div class="text-dark-50 line-height-lg">
	<div class="row">
		<div class="col-md-8">
			<div>
				<span class="font-weight-bolder">
					<?= $model->getAttributeLabel('category') ?>:
				</span> 
				<?= $model->category ?>
			</div>
			<div>
				<span class="font-weight-bolder">
					<?= $model->getAttributeLabel('menu') ?>:
				</span> 
				<?= $model->menu ?>
			</div>
		</div>
	</div>
</div>
		

<div class="separator separator-dashed my-5"></div>

<?= $this->render('_sub-content', [
	'model' => $model
]) ?>
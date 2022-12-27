<?php

use app\helpers\Html;
use app\widgets\Youtube;

$this->addJsFile('showmore/showMore.min');
$this->registerJs(<<< JS
	new ShowMore('.showmore', {
		config: {
		    type: "text",
		    limit: 120,
		    more: "→ read more",
		    less: "← read less"
		}
	});
JS);
?>
<div class="card card-custom">
	<div class="card-header">
		<div class="card-title">
			<h3 class="card-label">
				<?= $model->title ?>
			</h3>
		</div>
		<!-- <div class="card-toolbar">
			<a href="#" class="btn btn-sm btn-success font-weight-bold">
			<i class="flaticon2-cube"></i>Reports</a>
		</div> -->
	</div>
	<div class="card-body">
        <?= Youtube::widget(['videoId' => $model->videoId]) ?>
		<div class="mt-5">
			<div class="showmore">
				<?= $model->description ?>
			</div>
		</div>
	</div>
	<div class="card-footer d-flex justify-content-between">
		<?= Html::tag('a', 'View on Youtube', [
			'class' => 'btn btn-outline-secondary font-weight-bold',
			'target' => '_blank',
			'href' => $model->link
		]) ?>
	</div>
</div>
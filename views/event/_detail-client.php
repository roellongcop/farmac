<?php

use app\helpers\Html;
use app\widgets\Detail;
?>

<div class="row">
	
	<div class="col-md-12 text-center">
		<?= Html::image($model->photo, ['w' => 400], ['class' => 'img-fluid symbol']) ?>
	</div>
	<div class="col-md-12">
		<?= Detail::widget([
			'model' => $model,
			'attributes' => [
				'title:raw',
	            'description:ntext',
	            'start:raw',
	            'end:raw',
				'created_at' => [
	                'attribute' => 'created_at',
	                'format' => 'fulldate'
	            ],
	            'updated_at' => [
	                'attribute' => 'updated_at',
	                'format' => 'fulldate'
	            ],
	            'createdByEmail' => [
	                'attribute' => 'createdByEmail',
	                'format' => 'raw'
	            ],
	            'updatedByEmail' => [
	                'attribute' => 'updatedByEmail',
	                'format' => 'raw'
	            ],
			]
		]) ?>
	</div>
</div>
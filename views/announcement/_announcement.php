<?php

use app\helpers\Html;
?>

<?php $this->beginContent('@app/views/layouts/_card_wrapper.php') ?>
    <div class="row">
        <div class="col-md-5 text-center m-auto">
        	<?= Html::image($model->imageFileToken, [], [
        		'class' => 'img-fluid symbol',
        		'alt' => $model->title
        	]) ?>
        </div>
        <div class="col-md-7">
            <div class="d-flex justify-content-between">
            	<p class="font-weight-bolder display-4 text-dark-75 align-self-center"><?= $model->title ?></p>
            	<div>
            		<p class="font-weight-bold"><?= $model->createdAt ?></p>
            	</div>
            </div>
           <div>
                <?= $model->content ?>
                <div class="mt-10">
                	<?= $model->getImagePreviews($model->imageFileToken) ?>
                </div>
           </div>
        </div>
    </div>
<?php $this->endContent() ?>
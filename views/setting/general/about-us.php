<?php

use app\helpers\App;
use app\widgets\ActiveForm;
use app\widgets\TinyMce;

$this->registerJsFile(App::publishedUrl("/plugins/custom/tinymce/tinymce.bundle.js"), [
    'depends' => App::setting('theme')->appAssetClass
]);
?>
<?php $form = ActiveForm::begin(['id' => 'setting-general-notification-form']); ?>
    <h4 class="mb-10 font-weight-bold text-dark">About Us</h4>
	

	<div class="row">
		<div class="col-md-6">
			<div class="form-group required">
				<label class="control-label">Mission</label>
				<?= TinyMce::widget([
					'model' => $model,
					'attribute' => 'mission'
				]) ?>
			</div>
		</div>
		<div class="col-md-6">
			<div class="form-group required">
				<label class="control-label">Vision</label>
				<?= TinyMce::widget([
					'model' => $model,
					'attribute' => 'vision'
				]) ?>
			</div>
		</div>
	</div>

	<div class="my-5"></div>

	<div class="row">
		<div class="col-md-12">
			<div class="form-group required">
				<label class="control-label">Description</label>
				<?= TinyMce::widget([
					'model' => $model,
					'attribute' => 'description'
				]) ?>
			</div>
		</div>
	</div>


	<div class="my-5"></div>
	<div class="row">
		<div class="col-md-12">
			<?= $form->field($model, 'map')->textarea(['rows' => 8]) ?>
		</div>
	</div>
	<div class="form-group"> <br>
		<?= ActiveForm::buttons() ?>
	</div>
<?php ActiveForm::end(); ?>
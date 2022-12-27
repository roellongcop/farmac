<?php

use app\helpers\App;
use app\models\search\UserSearch;
use app\widgets\ActiveForm;
use app\widgets\BootstrapSelect;
use app\widgets\DatePicker;

/* @var $this yii\web\View */
/* @var $model app\models\User */

$this->title = 'Profile';
$this->params['breadcrumbs'][] = 'Update';
$this->params['searchModel'] = new UserSearch();
$this->params['wrapCard'] = false;
?>
<div class="user-my-account-page">
	<div class="row">
		<div class="col-md-8">
			<?php $this->beginContent('@app/views/layouts/_card_wrapper.php', [
	            'title' => 'Personal Information',
	            'stretch' => true
	        ]) ?>
				<?php $form = ActiveForm::begin(['id' => 'user-form-my-profile']); ?>
				    <div class="row">
				        <div class="col-md-4">
				            <?= $form->field($model, 'first_name')->textInput([
				                'maxlength' => true,
				            ]) ?>
				        </div>
				        <div class="col-md-4">
				            <?= $form->field($model, 'middle_name')->textInput(['maxlength' => true]) ?>
				        </div>
				        <div class="col-md-4">
				            <?= $form->field($model, 'last_name')->textInput(['maxlength' => true]) ?>
				        </div>
				    </div>

				    <div class="row">
				        <div class="col-md-4">
				            <?= DatePicker::widget([
				                'form' => $form,
				                'model' => $model,
				                'attribute' => 'birthdate'
				            ]) ?>
				        </div>
				        <div class="col-md-4">
				            <?= $form->field($model, 'age')->textInput(['maxlength' => true]) ?>
				        </div>
				        <div class="col-md-4">
				            <?= BootstrapSelect::widget([
				                'form' => $form,
				                'model' => $model,
				                'attribute' => 'sex',
				                'data' => [
				                    'Male' => 'Male',
				                    'Female' => 'Female',
				                ]
				            ]) ?>
				        </div>
				    </div>

				    <div class="row">
				        <div class="col-md-4">
				            <?= $form->field($model, 'contact_no')->textInput(['maxlength' => true]) ?>
				        </div>
				        <div class="col-md-4">
				            <?= $form->field($model, 'email')->textInput(['maxlength' => true]) ?>
				        </div>
				        <div class="col-md-4">
				            <?= $form->field($model, 'address')->textInput(['maxlength' => true]) ?>
				        </div>
				    </div>

					<div class="form-group"><br>
						<?= ActiveForm::buttons() ?>
				    </div>
				<?php ActiveForm::end(); ?>
	        <?php $this->endContent() ?>
		</div>
		<div class="col-md-4">
			<?php $this->beginContent('@app/views/layouts/_card_wrapper.php', [
	            'title' => 'Documents',
	            'stretch' => true
	        ]) ?>
	            <?php $this->beginContent('@app/views/file/_row-header.php') ?>
	                <?= App::foreach(
	                    $model->files, 
	                    fn($file) => $this->render('/file/_row', [
	                        'model' => $file
	                    ])
	                ) ?>
	            <?php $this->endContent() ?>
	        <?php $this->endContent() ?>
		</div>
	</div>
</div>
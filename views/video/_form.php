<?php

use app\widgets\ActiveForm;
use app\widgets\TinyMce;

/* @var $this yii\web\View */
/* @var $model app\models\Video */
/* @var $form app\widgets\ActiveForm */
?>
<?php $form = ActiveForm::begin(['id' => 'video-form']); ?>
    <div class="row">
        <div class="col-md-6">
			<?= $form->field($model, 'title')->textInput(['maxlength' => true]) ?>
        </div>
        <div class="col-md-6">
            <?= $form->field($model, 'link')->textInput(['maxlength' => true]) ?>
        </div>
    </div>
    <div class="row">
        <div class="col-md-12">
            <?= TinyMce::widget([
                'model' => $model,
                'attribute' => 'description'
            ]) ?>
        </div>
    </div>
    <div class="form-group mt-10">
        <?= ActiveForm::buttons() ?>
    </div>
<?php ActiveForm::end(); ?>
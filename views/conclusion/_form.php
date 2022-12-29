<?php

use app\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\Conclusion */
/* @var $form app\widgets\ActiveForm */
?>
<?php $form = ActiveForm::begin(['id' => 'conclusion-form']); ?>
    <div class="row">
        <div class="col-md-5">
			<?= $form->field($model, 'concern_id')->textInput() ?>
			<?= $form->field($model, 'conclusion')->textarea(['rows' => 6]) ?>
			<?= $form->field($model, 'conditions')->textarea(['rows' => 6]) ?>
            <?= ActiveForm::recordStatus([
                'model' => $model,
                'form' => $form,
            ]) ?>
        </div>
    </div>
    <div class="form-group">
        <?= ActiveForm::buttons() ?>
    </div>
<?php ActiveForm::end(); ?>
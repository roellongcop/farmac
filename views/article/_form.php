<?php

use app\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\Article */
/* @var $form app\widgets\ActiveForm */
?>
<?php $form = ActiveForm::begin(['id' => 'article-form']); ?>
    <div class="row">
        <div class="col-md-5">
			<?= $form->field($model, 'parent_id')->textInput() ?>
			<?= $form->field($model, 'category')->textInput(['maxlength' => true]) ?>
			<?= $form->field($model, 'menu')->textInput(['maxlength' => true]) ?>
			<?= $form->field($model, 'title')->textInput(['maxlength' => true]) ?>
			<?= $form->field($model, 'photo')->textInput(['maxlength' => true]) ?>
			<?= $form->field($model, 'content')->textarea(['rows' => 6]) ?>
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
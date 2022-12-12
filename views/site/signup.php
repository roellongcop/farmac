<?php

/* @var $form app\widgets\ActiveForm */
/* @var $model app\models\LoginForm */
use app\widgets\ActiveForm;

$this->title = 'Sign Up';
?>

<?php $form = ActiveForm::begin() ?>
    <p class="text-muted font-weight-bold font-size-h4">Enter your details to create your account</p>

    <?= $form->field($model, 'first_name')->textInput(['maxlength' => true]) ?>
    <div class="form-group">
        <?= ActiveForm::buttons() ?>
    </div>
<?php ActiveForm::end(); ?>


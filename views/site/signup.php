<?php

/* @var $form app\widgets\ActiveForm */
/* @var $model app\models\LoginForm */
use app\helpers\Html;
use app\helpers\Url;
use app\models\File;
use app\widgets\ActiveForm;
use app\widgets\BootstrapSelect;
use app\widgets\DatePicker;
use app\widgets\Dropzone;

$this->title = 'Sign Up Form';
?>

<div class="d-flex justify-content-between">
    <h2 class="text-dark font-weight-bold mb-10">
        <?= $this->title ?>
    </h2>

    <div>
        Already have an account? <?= Html::tag('a', 'Sign In', [
            'href' => Url::toRoute(['site/login']),
            'class' => ' font-weight-bold'
        ]) ?>
    </div>
</div>

<?php $form = ActiveForm::begin(['id' => 'ip-form']); ?>
    <p class="text-muted font-weight-bold lead text-uppercase">
        Personal Information
    </p>
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




    <p class="text-muted font-weight-bold lead text-uppercase mt-5">
        Credentials
    </p>

    <div class="row">
        <div class="col-md-4">
            <?= $form->field($model, 'password')->textInput(['maxlength' => true]) ?>
        </div>
        <div class="col-md-4">
            <?= $form->field($model, 'password_repeat')->textInput(['maxlength' => true]) ?>
        </div>
    </div>


    <p class="text-muted font-weight-bold lead text-uppercase mt-5">
        Upload Documents (ID's, CERTIFICATES)
    </p>


    <div class="row">
        <div class="col-md-8">
            <?= Dropzone::widget([
                'tag' => 'User',
                'model' => $model,
                'attribute' => 'documents',
                'acceptedFiles' => array_map(
                    fn($val)=> ".{$val}", File::EXTENSIONS['image']
                )
            ]) ?>
        </div>
    </div>



    <div class="form-group mt-10">
        <?= ActiveForm::buttons() ?>
    </div>
<?php ActiveForm::end(); ?>


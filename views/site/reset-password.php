<?php

/* @var $form app\widgets\ActiveForm */
/* @var $model app\models\LoginForm */
use app\helpers\App;
use app\helpers\Html;
use app\helpers\Url;
use app\widgets\ActiveForm;
$this->title = 'Reset Password';
$this->params['breadcrumbs'][] = $this->title;

$publishedUrl = App::publishedUrl();
?>
<div class="d-flex flex-column flex-root">
    <div class="login login-1 login-signin-on d-flex flex-column flex-lg-row flex-column-fluid bg-white" id="kt_login">
        <div class="login-aside d-flex flex-column flex-row-auto" style="background-color: #7EBFDB;">
            <div class="d-flex flex-column-auto flex-column pt-lg-40 pt-15">
                <a href="#" class="text-center mb-15">
                    <img src="<?= $publishedUrl . '/media/logos/logo-5.svg' ?>" alt="logo" class="h-70px" />
                </a>
                <h3 class="font-weight-bolder text-center font-size-h4 font-size-h1-lg text-white">Discover Amazing
                <br />Features &amp; Possibilites</h3>
            </div>
            <div class="aside-img d-flex flex-row-fluid bgi-no-repeat bgi-position-y-bottom bgi-position-x-center" style="background-image: url(<?= $publishedUrl . '/media/svg/illustrations/payment.svg' ?>)"></div>
        </div>
        <div class="login-content flex-row-fluid d-flex flex-column justify-content-center position-relative overflow-hidden p-7 mx-auto">
            <div class="d-flex flex-column-fluid flex-center">
                
                <div class="login-form login-forgot-password">
                    <?php $form = ActiveForm::begin([
                        'id' => 'kt_login_forgot_form',
                        'errorCssClass' => 'is-invalid',
                        'successCssClass' => 'is-valid',
                        'validationStateOn' => 'input',
                        'options' => [
                            'class' => 'form',
                            'novalidate' => 'novalidate'
                        ],
                        'action' => ['reset-password', 'prt' => $model->password_reset_token]
                    ]); ?>
                        <div class="pb-13 pt-lg-0 pt-5">
                            <h3 class="font-weight-bolder text-dark font-size-h4 font-size-h1-lg">Reset Password </h3>
                            <p class="text-muted font-weight-bold font-size-h4">Enter your new password</p>
                        </div>
                        <?= $form->field($model, 'password')->passwordInput([
                            'class' => 'form-control form-control-solid h-auto p-6 rounded-lg font-size-h6',
                            'placeholder' => 'Password',
                        ])->label(false) ?>
                        <?= $form->field($model, 'password_repeat')->passwordInput([
                            'class' => 'form-control form-control-solid h-auto p-6 rounded-lg font-size-h6',
                            'placeholder' => 'Password',
                        ])->label(false) ?>
                        <div class="form-group">
                        <div class="form-group d-flex flex-wrap pb-lg-0">
                        <button type="submit" id="" class="btn btn-primary font-weight-bolder font-size-h6 px-8 py-4 my-3 mr-4">Submit</button>
                            <?= Html::tag('a', 'Cancel', [
                                'href' => Url::toRoute(['site/login']),
                                'class' => 'btn btn-light-primary font-weight-bolder font-size-h6 px-8 py-4 my-3'
                            ]) ?>
                        </div>
                    <?php ActiveForm::end(); ?>
                </div>
            </div>
        </div>
    </div>
</div>
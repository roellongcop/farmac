<?php

/* @var $form app\widgets\ActiveForm */
/* @var $model app\models\LoginForm */
use app\helpers\App;
use app\widgets\Alert;
use app\widgets\ActiveForm;
use app\helpers\Html;
$this->title = 'Sign Up';
$this->params['breadcrumbs'][] = $this->title;

$publishedUrl = App::publishedUrl();
?>
<form class="form" novalidate="novalidate" id="kt_login_signup_form">
        <div class="pb-13 pt-lg-0 pt-5">
            <h3 class="font-weight-bolder text-dark font-size-h4 font-size-h1-lg">Sign Up</h3>
            <p class="text-muted font-weight-bold font-size-h4">Enter your details to create your account</p>
        </div>
        <div class="form-group">
            <input class="form-control form-control-solid h-auto p-6 rounded-lg font-size-h6" type="text" placeholder="Fullname" name="fullname" autocomplete="off" />
        </div>
        <div class="form-group">
            <input class="form-control form-control-solid h-auto p-6 rounded-lg font-size-h6" type="email" placeholder="Email" name="email" autocomplete="off" />
        </div>
        <div class="form-group">
            <input class="form-control form-control-solid h-auto p-6 rounded-lg font-size-h6" type="password" placeholder="Password" name="password" autocomplete="off" />
        </div>
        <div class="form-group">
            <input class="form-control form-control-solid h-auto p-6 rounded-lg font-size-h6" type="password" placeholder="Confirm password" name="cpassword" autocomplete="off" />
        </div>
        <div class="form-group d-flex align-items-center">
            <label class="checkbox mb-0">
                <input type="checkbox" name="agree" />
                <span></span>
            </label>
            <div class="pl-2">I Agree the
            <a href="#" class="ml-1">terms and conditions</a></div>
        </div>
        <div class="form-group d-flex flex-wrap pb-lg-0 pb-3">
        <button type="button" id="kt_login_signup_submit" class="btn btn-primary font-weight-bolder font-size-h6 px-8 py-4 my-3 mr-4">Submit</button>
            <button type="button" id="kt_login_signup_cancel" class="btn btn-light-primary font-weight-bolder font-size-h6 px-8 py-4 my-3">Cancel</button>
        </div>
    </form>
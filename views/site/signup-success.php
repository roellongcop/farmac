<?php

use app\helpers\Html;
use app\helpers\Url;


$this->title = 'Sign Up Success';
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


<div>
    <p class="">
        Thank you for signing up to FARMAC.
    </p>
    <p>
        We sent an email to <strong><?= $user->email ?></strong> in order to verify your account.
    </p>
    <?= Html::tag('a', 'Resend Verification', [
        'href' => Url::toRoute(['site/resend-verification', 'vt' => $user->verification_token]),
        'class' => 'btn btn-success font-weight-bold'
    ]) ?>
</div>
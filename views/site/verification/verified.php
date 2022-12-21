<?php

use app\helpers\Html;
use app\helpers\Url;


$this->title = 'Account Verification';
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
    <p>
        Thank you for verifying!
    </p>
    <p>
        <strong><?= $user->email ?> was successfully verified.</strong>
    </p>
    <p>
        The administrator 
    </p>


    <?= Html::tag('a', 'Login Here', [
        'href' => Url::toRoute(['site/login']),
        'class' => 'btn btn-success font-weight-bold'
    ]) ?>
</div>
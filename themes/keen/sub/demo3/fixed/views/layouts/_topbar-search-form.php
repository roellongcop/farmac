<?php

use app\widgets\ActiveForm;
use app\widgets\Search;
?>

<div style="width: 25vw;">
    <?php $form = ActiveForm::begin(['action' => $searchAction, 'method' => 'get']); ?>
        <?= Search::widget([
            'submitOnclick' => true,
            'model' => $searchModel,
            'options' => [
                'style' => 'margin-top: 20px;'
            ]
        ]) ?>
    <?php ActiveForm::end(); ?>
</div>

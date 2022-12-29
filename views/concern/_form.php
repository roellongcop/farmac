<?php

use app\helpers\App;
use app\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\Concern */
/* @var $form app\widgets\ActiveForm */
?>
<?php $form = ActiveForm::begin(['id' => 'concern-form']); ?>
    <div class="row" >
        <div class="col-md-6">
            <?php $this->beginContent('@app/views/layouts/_card_wrapper.php', [
                'title' => 'Concern Details',
                'stretch' => true
            ]) ?>
    			<?= $form->field($model, 'name')->textInput(['maxlength' => true]) ?>
                <?= $form->field($model, 'description')->textarea(['rows' => 5]) ?>
    			<?= $form->field($model, 'fallback_message')->textarea(['rows' => 5]) ?>

            <?php $this->endContent() ?>
        </div>
        <div class="col-md-6">
            <?php $this->beginContent('@app/views/layouts/_card_wrapper.php', [
                'title' => 'Rules',
                'stretch' => true
            ]) ?>
                <?= $this->render('form/rules', [
                    'model' => $model
                ]) ?>
            <?php $this->endContent() ?>
        </div>
    </div>
    <?php $this->beginContent('@app/views/layouts/_card_wrapper.php') ?>
        <?= ActiveForm::buttons() ?>
    <?php $this->endContent() ?>
<?php ActiveForm::end(); ?>
<?php

use app\models\Concern;
use app\widgets\ActiveForm;
use app\widgets\BootstrapSelect;
use app\widgets\TinyMce;

/* @var $this yii\web\View */
/* @var $model app\models\Conclusion */
/* @var $form app\widgets\ActiveForm */

$this->addJsFile('js/conclusion');
?>
<?php $form = ActiveForm::begin(['id' => 'conclusion-form']); ?>
    <div class="row">
        <div class="col-md-6">
            <?= BootstrapSelect::widget([
                'multiple' => true,
                'form' => $form,
                'model' => $model,
                'attribute' => 'concern_id',
                'data' => Concern::dropdown()
            ]) ?>
            <?= $form->field($model, 'conclusion')->textarea(['rows' => 10]) ?>
        </div>
        <div class="col-md-6">
            <div class="form-group required">
                <label class="control-label"><?= $model->getAttributeLabel('conditions') ?></label>
            </div>
            <div class="conditions-container">
                <?= $this->render('/concern/_conclusion-input', [
                    'model' => $model->concern,
                    'conclusion' => $model
                ]) ?>
            </div>
        </div>
    </div>
    <div class="form-group">
        <?= ActiveForm::buttons() ?>
    </div>
<?php ActiveForm::end(); ?>
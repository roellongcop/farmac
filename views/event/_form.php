<?php

use app\helpers\Html;
use app\models\File;
use app\widgets\ActiveForm;
use app\widgets\DateTimePicker;
use app\widgets\Dropzone;

/* @var $this yii\web\View */
/* @var $model app\models\Event */
/* @var $form app\widgets\ActiveForm */
?>

    <div class="row">
        <div class="col-md-4">
            <?php $this->beginContent('@app/views/layouts/_card_wrapper.php', [
                'title' => 'Event Form',
                'stretch' => true
            ]) ?>
                <?php $form = ActiveForm::begin(['id' => 'event-form']); ?>
                    <?= $form->field($model, 'title')->textInput(['maxlength' => true]) ?>
        			<?= $form->field($model, 'description')->textarea(['rows' => 6]) ?>

                    <div class="row">
                        <div class="col-md-6">
                            <?= DateTimePicker::widget([
                                'form' => $form,
                                'model' => $model,
                                'attribute' => 'start',
                            ]) ?>
                        </div>
                        <div class="col-md-6">
                            <?= DateTimePicker::widget([
                                'form' => $form,
                                'model' => $model,
                                'attribute' => 'end',
                            ]) ?>
                        </div>
                    </div>

                    <div class="form-group">
                        <label>Color</label>
                        <?= $model->color ?>
                        <div class="radio-inline">
                            <label class="radio">
                                <?= Html::input('radio', 'Event[color]', 'info', [
                                    'checked' => $model->color == 'info'
                                ]) ?>
                                <span></span> Purple
                            </label>
                            <label class="radio">
                                <?= Html::input('radio', 'Event[color]', 'success', [
                                    'checked' => $model->color == 'success'
                                ]) ?>
                                <span></span> Green
                            </label>
                            <label class="radio">
                                <?= Html::input('radio', 'Event[color]', 'danger', [
                                    'checked' => $model->color == 'danger'
                                ]) ?>
                                <span></span> Red
                            </label>
                        </div>
                    </div>
                   
                    <div class="text-center mt-10">
                        <?= Dropzone::widget([
                            'maxFiles' => 1,
                            'tag' => 'Event',
                            'files' => $model->imageFiles,
                            'model' => $model,
                            'attribute' => 'photo',
                            'acceptedFiles' => File::imageExtensions()
                        ]) ?>
                    </div>


                    <div class="form-group mt-20">
                        <?= ActiveForm::buttons() ?>
                    </div>
                <?php ActiveForm::end(); ?>
            <?php $this->endContent() ?>
        </div>
        <div class="col-md-8">
            <?php $this->beginContent('@app/views/layouts/_card_wrapper.php', [
                'title' => 'Calendar'
            ]) ?>
                <?= $this->render('_calendar') ?>
            <?php $this->endContent() ?>
        </div>
    </div>



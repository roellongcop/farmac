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
<?php $form = ActiveForm::begin(['id' => 'event-form']); ?>
    <div class="row">
        <div class="col-md-4">
            <?php $this->beginContent('@app/views/layouts/_card_wrapper.php', [
                'title' => 'Event Form',
                'stretch' => true
            ]) ?>
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
                            <span></span> Blue
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
<?php ActiveForm::end(); ?>



<div class="modal fade" id="modal-event" tabindex="-1" role="dialog" aria-labelledby="modal-eventLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg modal-scrollable" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modal-eventLabel">Update Event</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <i aria-hidden="true" class="ki ki-close"></i>
                </button>
            </div>
            <div class="modal-body">
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-light-primary font-weight-bold" data-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary font-weight-bold btn-save-event">Save changes</button>
            </div>
        </div>
    </div>
</div>
<?php

use app\helpers\Html;
use app\widgets\ActiveForm;
use app\widgets\DateTimePicker;
use app\widgets\ImageGallery;

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
                <?= $form->field($model, 'url')->textInput(['maxlength' => true]) ?>
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
                            <?= Html::input('radio', 'Event[color]', 'primary', [
                                'checked' => $model->color == 'primary'
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
                    <?= Html::image($model->photo, ['w' => 200], [
                        'class' => 'img-thumbnail event-photo',
                        'loading' => 'lazy',
                    ] ) ?>
                    <div class="my-5"></div>
                    <?= ImageGallery::widget([
                        'buttonTitle' => 'Choose Photo',
                        'fixedSize' => false,
                        'tag' => 'Event',
                        'model' => $model,
                        'attribute' => 'photo',
                        'ajaxSuccess' => "
                            if(s.status == 'success') {
                                $('.event-photo').attr('src', s.src);
                            }
                        ",
                    ]) ?> 
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
    <div class="form-group">
        <?= ActiveForm::buttons() ?>
    </div>
<?php ActiveForm::end(); ?>
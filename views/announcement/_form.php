<?php

use app\models\File;
use app\widgets\ActiveForm;
use app\widgets\Dropzone;
use app\widgets\TinyMce;

/* @var $this yii\web\View */
/* @var $model app\models\Announcement */
/* @var $form app\widgets\ActiveForm */
?>
<?php $form = ActiveForm::begin(['id' => 'announcement-form']); ?>
    <div class="row">
        <div class="col-md-6">
			<?= $form->field($model, 'title')->textInput(['maxlength' => true]) ?>
            <div class="form-group required">
                <label class="control-label">Content</label>
                <?= TinyMce::widget([
                    'model' => $model,
                    'attribute' => 'content'
                ]) ?>
            </div>
        </div>
        <div class="col-md-6">
            <div class="form-group">
                <label class="control-label">Upload Photos</label>
                <?= Dropzone::widget([
                    'tag' => 'Announcements',
                    'files' => $model->imageFiles,
                    'model' => $model,
                    'attribute' => 'photos',
                    'acceptedFiles' => File::imageExtensions()
                ]) ?>
            </div>
        </div>
    </div>
    <div class="form-group">
        <?= ActiveForm::buttons() ?>
    </div>
<?php ActiveForm::end(); ?>
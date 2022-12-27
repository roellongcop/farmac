<?php

use app\helpers\App;
use app\models\File;
use app\models\search\UserSearch;
use app\widgets\ActiveForm;
use app\widgets\BootstrapSelect;
use app\widgets\DatePicker;
use app\widgets\Dropzone;

/* @var $this yii\web\View */
/* @var $model app\models\User */

$this->title = 'Profile';
$this->params['breadcrumbs'][] = 'Update';
$this->params['searchModel'] = new UserSearch();
$this->params['wrapCard'] = false;
$this->addJsFile('js/my-profile');
?>


<div class="modal fade" id="modal-add-documents" tabindex="-1" role="dialog" aria-labelledby="modal-add-documentsLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modal-add-documentsLabel">Add Documents</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <i aria-hidden="true" class="ki ki-close"></i>
                </button>
            </div>
            <div class="modal-body">
				<?= Dropzone::widget([
					'tag' => 'User',
					'model' => $model,
					'attribute' => 'documents',
					'inputName' => 'hidden',
					'success' => <<< JS
						var self = this;
						KTApp.block('body', {
							overlayColor: '#000',
							state: 'warning',
							message: 'Please wait...'
						})
						$.ajax({
							url: app.baseUrl + 'user/add-document',
							data: {
								id: {$model->user_id},
								token: s.file.token
							},
							method: 'post',
							dataType: 'json',
							success: function(s) {
								if(s.status == 'success') {
									self.removeFile(file);
									$('#table-file').DataTable({
										responsive: true,
										destroy: true,
										pageLength: 5,
										order: [[0, 'desc']],
								        columns: [
								            null,
								            { "width": "20%" },
								        ]
									}).row.add($(s.row)).draw();
								}
								else {
									Swal.fire('Error', s.errorSummary, 'error');
								}
								KTApp.unblock('body');
							},
							error: function(e) {
								Swal.fire('Error', e.responseText, 'error');
								KTApp.unblock('body');
							}
						});
					JS,
					'maxFiles' => 10,
				]) ?>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-light-primary font-weight-bold" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>

<div class="user-my-account-page">
	<div class="row">
		<div class="col-md-12">
			<?php $this->beginContent('@app/views/layouts/_card_wrapper.php', [
	            'title' => 'Personal Information',
	            'stretch' => true,
	        ]) ?>
				<?php $form = ActiveForm::begin(['id' => 'user-form-my-profile']); ?>
				    <div class="row">
				        <div class="col-md-4">
				            <?= $form->field($model, 'first_name')->textInput([
				                'maxlength' => true,
				            ]) ?>
				        </div>
				        <div class="col-md-4">
				            <?= $form->field($model, 'middle_name')->textInput(['maxlength' => true]) ?>
				        </div>
				        <div class="col-md-4">
				            <?= $form->field($model, 'last_name')->textInput(['maxlength' => true]) ?>
				        </div>
				    </div>

				    <div class="row">
				        <div class="col-md-4">
				            <?= DatePicker::widget([
				                'form' => $form,
				                'model' => $model,
				                'attribute' => 'birthdate'
				            ]) ?>
				        </div>
				        <div class="col-md-4">
				            <?= $form->field($model, 'age')->textInput(['maxlength' => true]) ?>
				        </div>
				        <div class="col-md-4">
				            <?= BootstrapSelect::widget([
				                'form' => $form,
				                'model' => $model,
				                'attribute' => 'sex',
				                'data' => [
				                    'Male' => 'Male',
				                    'Female' => 'Female',
				                ]
				            ]) ?>
				        </div>
				    </div>

				    <div class="row">
				        <div class="col-md-4">
				            <?= $form->field($model, 'contact_no')->textInput(['maxlength' => true]) ?>
				        </div>
				        <div class="col-md-4">
				            <?= $form->field($model, 'email')->textInput(['maxlength' => true]) ?>
				        </div>
				        <div class="col-md-4">
				            <?= $form->field($model, 'address')->textInput(['maxlength' => true]) ?>
				        </div>
				    </div>

					<div class="form-group"><br>
						<?= ActiveForm::buttons() ?>
				    </div>
				<?php ActiveForm::end(); ?>
	        <?php $this->endContent() ?>
		</div>
		<div class="col-md-12">
			<?php $this->beginContent('@app/views/layouts/_card_wrapper.php', [
	            'title' => 'Documents',
	            'stretch' => true,
				'toolbar' => <<< HTML
					<div class="card-toolbar">
						<button type="button" class="btn btn-light-primary font-weight-bold" data-toggle="modal" data-target="#modal-add-documents">
						Add Documents
						</button>
					</div>
				HTML
	        ]) ?>
	        	
	            <?php $this->beginContent('@app/views/file/_row-header.php') ?>
	                <?= App::foreach(
	                    $model->files, 
	                    fn($file) => $this->render('/file/_row', [
	                        'model' => $file
	                    ])
	                ) ?>
	            <?php $this->endContent() ?>
	        <?php $this->endContent() ?>
		</div>
	</div>
</div>

<?php
/* @var $this yii\web\View */
/* @var $searchModel app\models\search\UserSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Dashboard';
$this->params['searchModel'] = $searchModel; 
$this->params['wrapCard'] = false;
?>
<div class="dashboard-page">

	<div class="row">
		<div class="col-md-4">
			<?= $this->render('_top-inquiries') ?>
		</div>
		<div class="col-md-4">
			<?= $this->render('_top-unsolved-inquiries') ?>
		</div>
		<div class="col-md-4">
			<?= $this->render('_top-solved-inquiries') ?>
		</div>
	</div>
	<div class="row">
		<div class="col-md-4">
			<?= $this->render('_announcement') ?>
		</div>
		<div class="col-md-4">
			<?= $this->render('_event') ?>
		</div>
		<div class="col-md-4">
			<?= $this->render('_video') ?>
		</div>
	</div>
</div>
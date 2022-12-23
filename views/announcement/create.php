<?php

use app\models\search\AnnouncementSearch;

/* @var $this yii\web\View */
/* @var $model app\models\Announcement */

$this->title = 'Create Announcement';
$this->params['breadcrumbs'][] = ['label' => 'Announcements', 'url' => $model->indexUrl];
$this->params['breadcrumbs'][] = 'Create';
$this->params['searchModel'] = new AnnouncementSearch();
?>
<div class="announcement-create-page">
	<?= $this->render('_form', [
		'model' => $model,
	]) ?>
</div>
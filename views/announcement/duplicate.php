<?php

use app\models\search\AnnouncementSearch;

/* @var $this yii\web\View */
/* @var $model app\models\Announcement */

$this->title = 'Duplicate Announcement: ' . $originalModel->mainAttribute;
$this->params['breadcrumbs'][] = ['label' => 'Announcements', 'url' => $model->indexUrl];
$this->params['breadcrumbs'][] = ['label' => $originalModel->mainAttribute, 'url' => $originalModel->viewUrl];
$this->params['breadcrumbs'][] = 'Duplicate';
$this->params['searchModel'] = new AnnouncementSearch();
$this->params['showCreateButton'] = true; 
?>
<div class="announcement-duplicate-page">
	<?= $this->render('_form', [
        'model' => $model,
    ]) ?>
</div>
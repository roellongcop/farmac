<?php

use app\models\search\AnnouncementSearch;

/* @var $this yii\web\View */
/* @var $model app\models\Announcement */

$this->title = 'Update Announcement: ' . $model->mainAttribute;
$this->params['breadcrumbs'][] = ['label' => 'Announcements', 'url' => $model->indexUrl];
$this->params['breadcrumbs'][] = ['label' => $model->mainAttribute, 'url' => $model->viewUrl];
$this->params['breadcrumbs'][] = 'Update';
$this->params['searchModel'] = new AnnouncementSearch();
$this->params['showCreateButton'] = true; 
?>
<div class="announcement-update-page">
	<?= $this->render('_form', [
        'model' => $model,
    ]) ?>
</div>
<?php

use app\widgets\Anchors;
use app\widgets\Detail;
use app\models\search\AnnouncementSearch;

/* @var $this yii\web\View */
/* @var $model app\models\Announcement */

$this->title = 'Announcement: ' . $model->mainAttribute;
$this->params['breadcrumbs'][] = ['label' => 'Announcements', 'url' => $model->indexUrl];
$this->params['breadcrumbs'][] = $model->mainAttribute;
$this->params['searchModel'] = new AnnouncementSearch();
$this->params['showCreateButton'] = true; 
?>
<div class="announcement-view-page">
    <?= Anchors::widget([
    	'names' => ['update', 'duplicate', 'delete', 'log'], 
    	'model' => $model
    ]) ?> 
    <?= Detail::widget(['model' => $model]) ?>
</div>
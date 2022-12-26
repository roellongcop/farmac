<?php

use app\models\search\EventSearch;

/* @var $this yii\web\View */
/* @var $model app\models\Event */

$this->title = 'Event: Calendar';
$this->params['breadcrumbs'][] = ['label' => 'Events', 'url' => $model->indexUrl];
$this->params['breadcrumbs'][] = 'Calendar';
$this->params['searchModel'] = new EventSearch();
$this->params['showCreateButton'] = true; 
?>
<div class="event-view-page">
    <?= $this->render('_calendar') ?>
</div>
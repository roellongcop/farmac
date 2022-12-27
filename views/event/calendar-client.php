<?php

use app\models\search\EventSearch;

/* @var $this yii\web\View */
/* @var $model app\models\Event */

$this->title = 'Calendar';
$this->params['breadcrumbs'][] = 'Calendar';
$this->params['searchModel'] = new EventSearch();
$this->params['page'] = 'calendar';
?>
<div class="event-view-page">
    <?= $this->render('_calendar') ?>
</div>
<?php

use yii\widgets\ListView;

/* @var $this yii\web\View */
/* @var $searchModel app\models\search\AnnouncementSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Announcements';
$this->params['breadcrumbs'][] = $this->title;
$this->params['searchModel'] = $searchModel; 
$this->params['wrapCard'] = false; 
?>
<div class="announcement-index-page">
    <?= ListView::widget([
        'dataProvider' => $dataProvider,
        'itemView' => '_announcement',
    ]); ?>
</div>
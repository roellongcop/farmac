<?php

use yii\widgets\ListView;

/* @var $this yii\web\View */
/* @var $searchModel app\models\search\AnnouncementSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'News and Updates';
$this->params['breadcrumbs'][] = $this->title;
$this->params['searchModel'] = $searchModel; 
$this->params['wrapCard'] = false; 
$this->params['page'] = 'announcement'; 
?>
<div class="announcement-index-page">
    <?= ListView::widget([
        'pager' => ['class' => 'app\widgets\LinkPager'],
        'dataProvider' => $dataProvider,
        'itemView' => '_announcement',
        'layout' => <<< HTML
            <div class="col-md-12 mb-5">
                <div class="d-flex justify-content-between align-items-center">
                    <div>{summary}</div>
                    <div>{pager}</div>
                </div>
            </div>
            {items}
            <div class="col-md-12">
                <div class="d-flex justify-content-between align-items-center">
                    <div>{summary}</div>
                    <div>{pager}</div>
                </div>
            </div>
        HTML,
    ]); ?>
</div>
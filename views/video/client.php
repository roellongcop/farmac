<?php

use yii\widgets\ListView;

/* @var $this yii\web\View */
/* @var $searchModel app\models\search\VideoSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Videos';
$this->params['breadcrumbs'][] = $this->title;
$this->params['searchModel'] = $searchModel; 
$this->params['wrapCard'] = false;
$this->params['page'] = 'video';
?>
<div class="video-index-page">
	<?= ListView::widget([
        'pager' => ['class' => 'app\widgets\LinkPager'],
        'dataProvider' => $dataProvider,
        'options' => [
            'tag' => 'div',
            'class' => 'row',
            'id' => 'list-wrapper',
        ],
        'summaryOptions' => [
            'class' => 'col-12'
        ],
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
        'itemView' => '_video',
        'beforeItem' => function ($model, $key, $index, $widget) {
            return '<div class="col-md-6">';
        },
        'afterItem' => function ($model, $key, $index, $widget) {
            return '</div>';
        },
    ]); ?>
</div>
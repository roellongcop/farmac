<?php

use app\helpers\Html;
use app\widgets\BulkAction;
use app\widgets\FilterColumn;
use app\widgets\Grid;
use yii\widgets\ListView;

/* @var $this yii\web\View */
/* @var $searchModel app\models\search\VideoSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Videos';
$this->params['breadcrumbs'][] = $this->title;
$this->params['searchModel'] = $searchModel; 
$this->params['wrapCard'] = false;
?>
<div class="video-index-page">
	<?= ListView::widget([
        'dataProvider' => $dataProvider,
        'options' => [
            'tag' => 'div',
            'class' => 'row',
            'id' => 'list-wrapper',
        ],
        'summaryOptions' => [
            'class' => 'col-12'
        ],
        'layout' => "{summary}\n{items}\n<div class='col-12'>{pager}</div>",
        'itemView' => '_video',
        'beforeItem' => function ($model, $key, $index, $widget) {
            return '<div class="col-lg-4 col-md-6 col-sm-6 pb-1">';
        },
        'afterItem' => function ($model, $key, $index, $widget) {
            return '</div>';
        },
    ]); ?>
</div>
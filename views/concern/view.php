<?php

use app\helpers\App;
use app\helpers\Html;
use app\models\search\ConcernSearch;
use app\widgets\Anchors;
use app\widgets\Detail;

/* @var $this yii\web\View */
/* @var $model app\models\Concern */

$this->title = 'Concern: ' . $model->mainAttribute;
$this->params['breadcrumbs'][] = ['label' => 'Concerns', 'url' => $model->indexUrl];
$this->params['breadcrumbs'][] = $model->mainAttribute;
$this->params['searchModel'] = new ConcernSearch();
$this->params['showCreateButton'] = true; 
$this->params['wrapCard'] = false; 

$decisionTree = $model->decisionTree;
?>
<div class="concern-view-page">
    <?php $this->beginContent('@app/views/layouts/_card_wrapper.php') ?>
        <?= Anchors::widget([
        	'names' => ['update', 'duplicate', 'delete', 'log'], 
        	'model' => $model
        ]) ?> 
        <?= Detail::widget(['model' => $model]) ?>
    <?php $this->endContent() ?>

    <?php $this->beginContent('@app/views/layouts/_card_wrapper.php', [
        'title' => 'Decision Table'
    ]) ?>
        <div class="table-responsive">
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>#</th>
                        <?= App::foreach($decisionTree['keys'], fn ($key) => Html::tag('th', $key)) ?>
                    </tr>
                </thead>
                <tbody>
                    <?= App::foreach($decisionTree['data'], function ($data, $index, $counter) {

                        return Html::tag('tr', Html::tag('td', $counter) . App::foreach($data, fn ($d) => Html::tag('td', $d)));
                    }) ?>
                </tbody>
            </table>
        </div>
    <?php $this->endContent() ?>
</div>
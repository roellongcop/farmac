<?php

use app\helpers\App;
use app\models\search\UserSearch;
use app\widgets\Anchor;
use app\widgets\Anchors;
use app\widgets\Detail;

/* @var $this yii\web\View */
/* @var $model app\models\User */

$this->title = 'User: ' . $model->mainAttribute;
$this->params['breadcrumbs'][] = ['label' => 'Users', 'url' => $model->indexUrl];
$this->params['breadcrumbs'][] = $model->mainAttribute;
$this->params['searchModel'] = new UserSearch();
$this->params['showCreateButton'] = true; 
$this->params['wrapCard'] = false; 
?>
<div class="user-view-page">
    <?= Anchors::widget([
    	'names' => ['update', 'duplicate', 'log'], 
    	'model' => $model,
    ]) ?> 
    <?= App::if($model->dashboardVisitable, Anchor::widget([
        'title' => 'User Dashboard', 
        'link' => ['user/dashboard', 'slug' => $model->slug],
        'options' => [
            'class' => 'btn btn-warning',
            'data-method' => 'post',
            'data-confirm' => 'Your account will be logout!'
        ]
    ])) ?>

    <?= Anchor::widget([
        'title' => 'User Activities', 
        'link' => ['log/index', 'userSlug' => $model->slug],
        'options' => ['class' => 'btn btn-secondary']
    ]) ?>

    <div class="my-2"></div>
    <div class="row">
        <div class="col-md-6">
            <?php $this->beginContent('@app/views/layouts/_card_wrapper.php', [
                'title' => 'User Details',
                'stretch' => true
            ]) ?>
                <?= Detail::widget([
                    'model' => $model
                ]) ?>
            <?php $this->endContent() ?>
        </div>
        <div class="col-md-6">
            <?php $this->beginContent('@app/views/layouts/_card_wrapper.php', [
                'title' => 'Profile'
            ]) ?>
                <?= Detail::widget(['model' => $model->userProfile]) ?>
            <?php $this->endContent() ?>

            <?php $this->beginContent('@app/views/layouts/_card_wrapper.php', [
                'title' => 'Documents'
            ]) ?>
                <?php $this->beginContent('@app/views/file/_row-header.php') ?>
                    <?= App::foreach(
                        $model->userProfile->files, 
                        fn($file) => $this->render('/file/_row', [
                            'model' => $file
                        ])
                    ) ?>
                <?php $this->endContent() ?>
            <?php $this->endContent() ?>
        </div>
    </div>
</div>
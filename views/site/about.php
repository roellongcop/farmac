<?php
/* @var $this yii\web\View */
use app\helpers\Html;

$this->title = 'About';
$this->params['breadcrumbs'][] = $this->title;
$this->params['wrapCard'] = false;
$this->params['activeMenuLink'] = '/about';
?>
<div class="site-about">
    <div class="row">
        <div class="col-md-6">
            <?php $this->beginContent('@app/views/layouts/_card_wrapper.php', [
                'title' => 'Welcome'
            ]) ?>
                <?= $aboutUs->description ?>
            <?php $this->endContent() ?>
            <?php $this->beginContent('@app/views/layouts/_card_wrapper.php', [
                'title' => 'Mission'
            ]) ?>
                <?= $aboutUs->mission ?>
            <?php $this->endContent() ?>
            <?php $this->beginContent('@app/views/layouts/_card_wrapper.php', [
                'title' => 'Vision'
            ]) ?>
                <?= $aboutUs->vision ?>
            <?php $this->endContent() ?>
        </div>
        <div class="col-md-6">
            <?php $this->beginContent('@app/views/layouts/_card_wrapper.php', [
                'title' => 'Map',
                'stretch' => true
            ]) ?>
                <?= $aboutUs->map ?>
            <?php $this->endContent() ?>
        </div>
    </div>
</div>

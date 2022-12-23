<?php

namespace app\tests\fixtures;

class VideoFixture extends \yii\test\ActiveFixture
{
    public $modelClass = 'app\models\Video';
    public $dataFile = '@app/tests/fixtures/data/video.php';
    public $depends = ['app\tests\fixtures\UserFixture'];
}
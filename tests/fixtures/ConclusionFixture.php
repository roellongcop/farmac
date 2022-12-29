<?php

namespace app\tests\fixtures;

class ConclusionFixture extends \yii\test\ActiveFixture
{
    public $modelClass = 'app\models\Conclusion';
    public $dataFile = '@app/tests/fixtures/data/conclusion.php';
    public $depends = ['app\tests\fixtures\UserFixture'];
}
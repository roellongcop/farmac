<?php

namespace app\tests\fixtures;

class ConcernFixture extends \yii\test\ActiveFixture
{
    public $modelClass = 'app\models\Concern';
    public $dataFile = '@app/tests/fixtures/data/concern.php';
    public $depends = ['app\tests\fixtures\UserFixture'];
}
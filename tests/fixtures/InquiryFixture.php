<?php

namespace app\tests\fixtures;

class InquiryFixture extends \yii\test\ActiveFixture
{
    public $modelClass = 'app\models\Inquiry';
    public $dataFile = '@app/tests/fixtures/data/inquiry.php';
    public $depends = ['app\tests\fixtures\UserFixture'];
}
<?php

namespace app\tests\fixtures;

class ArticleFixture extends \yii\test\ActiveFixture
{
    public $modelClass = 'app\models\Article';
    public $dataFile = '@app/tests/fixtures/data/article.php';
    public $depends = ['app\tests\fixtures\UserFixture'];
}
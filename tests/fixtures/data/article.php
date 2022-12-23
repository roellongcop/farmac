<?php

use app\models\Article;
use yii\db\Expression;

$model = new \app\helpers\FixtureData(function($params) {
    return [
		'parent_id' => 'Parent ID',
		'category' => 'Category',
		'menu' => 'Menu',
		'title' => 'Title',
		'photo' => 'Photo',
		'content' => 'Content',
		'record_status' => Article::RECORD_ACTIVE,
        'created_by' => 1,
        'updated_by' => 1,
		'created_at' => new Expression('UTC_TIMESTAMP'),
        'updated_at' => new Expression('UTC_TIMESTAMP'),
    ];
});

$model->add('1');
$model->add('inactive', [], [
	'record_status' => Article::RECORD_INACTIVE
]);

return $model->getData();
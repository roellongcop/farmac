<?php

namespace app\modules\chat\models;

use Yii;
use app\modules\chat\helpers\App;
use app\modules\chat\helpers\Url;

class User extends \app\models\User
{
	public function fields()
	{
		$fields = parent::fields();

		$fields['fullname'] = 'fullname';
      	$fields['photoLink'] = 'photoLink';
      	$fields['timestamp'] = 'timestamp';

		return $fields;
	}

   	public function getPhotoLink()
   	{
      	return Url::image($this->photo, ['w' => 30]);
   	}

	public static function available()
	{
		return self::find()
			->where(['<>', 'id', App::identity('id')])
			->available()
			->all();
	}
}

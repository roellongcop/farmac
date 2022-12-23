<?php

namespace app\helpers;


class ArrayHelper extends \yii\helpers\ArrayHelper
{
   public static function combine($array)
   {
   		return array_combine($array, $array);
   }
}
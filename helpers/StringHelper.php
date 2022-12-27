<?php

namespace app\helpers;

class StringHelper extends \yii\helpers\StringHelper
{
    public static function combine($array)
    {
        return array_combine($array, $array);
    }
}
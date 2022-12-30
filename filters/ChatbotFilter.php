<?php

namespace app\filters;

use app\helpers\App;
use app\models\Chat;

class ChatbotFilter extends \yii\base\ActionFilter
{
    public function beforeAction($action)
    {
        if (!parent::beforeAction($action)) {
            return false;
        }

        if (App::isLogin()) {

            $chat = Chat::findOrCreate(['user_id' => App::identity('id')]);
            if ($chat->isNewRecord) {
                $chat->message = App::setting('chatbot')->welcome_message;
                $chat->type = Chat::TYPE_CHATBOT;
                $chat->save();
            }
        }
        return true;
    }
}
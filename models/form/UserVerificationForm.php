<?php

namespace app\models\form;

use app\models\User;
use app\models\form\CustomEmailForm;

class UserVerificationForm extends \yii\base\Model
{
    public $verification_token;

    private $_user;

   
    public function rules()
    {
        return [
            [['verification_token'], 'required'],
            ['verification_token', 'exist', 'targetClass' => 'app\models\User', 'targetAttribute' => 'verification_token']
        ];
    }

    public function activate()
    {
        if (!$this->validate()) {
            return ;
        }

        $user = $this->getUser();
        $user->status = User::STATUS_ACTIVE;

        if ($user->save()) {
            $mailer = new CustomEmailForm([
                'to' => $user->email,
                'subject' => 'Account Activation',
                'template' => 'account-activation',
                'parameters' => [
                    'user' => $user,
                ],
            ]);
            return $mailer->send();
        }
    }

    public function verify()
    {
        if (!$this->validate()) {
            return ;
        }

        $user = $this->getUser();
        $user->is_blocked = User::UNBLOCKED;
        $user->generateEmailVerificationToken();

        if ($user->save()) {
            return $user;
        }
    }


    public function getUser()
    {
        if ($this->_user === null) {
            $this->_user =  User::findOne(['verification_token' => $this->verification_token]);
        }

        return $this->_user;
    }
}
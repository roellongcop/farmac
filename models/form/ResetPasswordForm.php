<?php

namespace app\models\form;

use app\models\User;

class ResetPasswordForm extends \yii\base\Model
{
    public $password_reset_token; 
    public $password; 
    public $password_repeat; 

    public $_user; 

    public function rules()
    {
        return [
            [['password_reset_token', 'password', 'password_repeat'], 'required'],
            ['password_reset_token', 'exist', 'targetClass' => 'app\models\User', 'targetAttribute' => 'password_reset_token'],
            ['password_reset_token', 'validateToken'],
            [['password', 'password_repeat'], 'string', 'min' => 6],
            ['password_repeat', 'compare', 'compareAttribute'=>'password', 'message' => 'Passwords don\'t match'],

        ];
    }

    public function validateToken($attribute, $params)
    {
        if (($user = $this->getUser()) != null) {
            if ($user->is_blocked == User::BLOCKED) {
                $this->addError($attribute, 'User is blocked.');
            }

            if ($user->status == User::STATUS_DELETED) {
                $this->addError($attribute, 'User is deleted.');
            }

            if ($user->status == User::STATUS_INACTIVE) {
                $this->addError($attribute, 'User is inactive.');
            }

            if ($user->record_status == User::RECORD_INACTIVE) {
                $this->addError($attribute, 'User record is inactive.');
            }
        }
    }

    public function getUser()
    {
        if ($this->_user == null) {
            $this->_user = User::findOne(['password_reset_token' => $this->password_reset_token]);
        }

        return $this->_user;
    }

    public function reset()
    {
        if ($this->validate()) {
            $user = $this->getUser();
            $user->setPassword($this->password);
            $user->generatePasswordResetToken();

            if ($user->save()) {
                return $user;
            }
        }
    }
}
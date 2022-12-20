<?php

namespace app\models\form;

use app\helpers\App;
use app\models\Notification;
use app\models\Role;
use app\models\User;
use app\models\form\CustomEmailForm;
use app\models\form\user\UserProfileForm;
use yii\db\Expression;

class SignupForm extends \yii\base\Model
{
    public $first_name;
    public $middle_name;
    public $last_name;
    public $birthdate;
    public $age;
    public $sex;
    public $contact_no;
    public $email;
    public $address;
    public $documents;
    public $password;
    public $password_repeat;

    public function rules()
    {
        return [
            [['first_name', 'last_name', 'age', 'birthdate', 'sex', 'address', 'email', 'documents', 'password', 'password_repeat'], 'required'],
            [['first_name', 'last_name', 'birthdate', 'sex', 'contact_no', 'email', 'password', 'password_repeat'], 'string', 'max' => 225],
            [['age'], 'integer'],
            [['email'], 'email'],
            [['email'], 'trim'],
            [['password', 'password_repeat'], 'string', 'min' => 6],
            ['password_repeat', 'compare', 'compareAttribute'=>'password', 'message' => 'Passwords don\'t match'],
            ['birthdate', 'validateBirthDate'],
            ['email', 'email'],
            [['email'], 'trim'],
            ['sex', 'in', 'range' => [
                'Male', 'Female'
            ]],
            ['email', 'validateEmail']
        ];
    }

    public function validateEmail($attribute, $params)
    {
        $user = User::findOne(['email' => $this->email]);
        if ($user) {
            $this->addError('email', 'Email already exist.');
        }
    }

    public function validateBirthDate($attribute, $params)
    {
        $current_date = strtotime(App::formatter()->asDateToTimezone('', 'Y-m-d'));
        $birthdate = strtotime($this->birthdate);

        if ($birthdate > $current_date) {
            $this->addError('birthdate', 'Birthdate is greater than current date');
        }
    }


    public function signup()
    {
        if (! $this->validate()) {
            return ;
        }

        $explode = explode('@', $this->email);


        $user = new User([
            'role_id' => Role::CLIENT,
            'status' => User::STATUS_INACTIVE,
            'is_blocked' => User::BLOCKED
        ]);
        $user->username = $explode[0];
        $user->email = $this->email;
        $user->setPassword($this->password);

        if ($user->save()) {
            
            $profile = new UserProfileForm([
                'user_id' => $user->id,
                'first_name' => $this->first_name,
                'middle_name' => $this->middle_name,
                'last_name' => $this->last_name,
                'birthdate' => $this->birthdate,
                'age' => $this->age,
                'sex' => $this->sex,
                'contact_no' => $this->contact_no,
                'email' => $this->email,
                'address' => $this->address,
                'documents' => $this->documents,
            ]);

            if ($profile->save()) {
                $roles = [
                    Role::DEVELOPER,
                    Role::SUPERADMIN,
                    Role::ADMIN,
                ];

                $data = App::foreach(User::findAll(['role_id' => $roles]), function ($adminUser) use($user) {
                    return [
                        'status' => Notification::STATUS_UNREAD,
                        'record_status' => 1,
                        'user_id' => $adminUser->id,
                        'type' => 'signup',
                        'link' => $user->getViewUrl(true, true),
                        'message' => 'New User Registration',
                        'token' => App::randomString(10) . time() . $adminUser->id,
                        'created_by' => $user->id,
                        'updated_by' => $user->id,
                        'created_at' => new Expression('UTC_TIMESTAMP'),
                        'updated_at' => new Expression('UTC_TIMESTAMP'),
                    ];
                } , false);

                Notification::batchInsert($data);


                $mailer = new CustomEmailForm([
                    'to' => $user->email,
                    'subject' => 'FARMAC Signup',
                    'template' => 'signup',
                    'parameters' => [
                        'user' => $user,
                    ],
                ]);
                $mailer->send();
                return $user;
            }

            $this->addError('profile', $profile->errors);

        }

        $this->addError('user', $user->errors);

    }

    public function beforeValidate()
    {
        if (! parent::beforeValidate()) {
            return false;
        }

        $this->age = App::formatter()->asAge($this->birthdate);


        return true;
    }
}
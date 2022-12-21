<?php

namespace app\controllers;

use app\helpers\App;
use app\helpers\Html;
use app\models\User;
use app\models\form\ContactForm;
use app\models\form\LoginForm;
use app\models\form\PasswordResetForm;
use app\models\form\SignupForm;

class SiteController extends Controller
{
    const PUBLIC_ACTIONS = [
        'resend-verification',
        'verify',
        'signup-success', 
        'signup', 
        'login', 
        'reset-password', 
        'contact',
        'test-email'
    ];

    public function actionTestEmail()
    {
        $messages = App::foreach(\app\models\User::findAll(['role_id' => 1]), function($user) {
            $model = new \app\models\form\CustomEmailForm([
                'to' => 'abelgernale17@gmail.com',
                'subject' => 'Approved Ambulance Request',
                'template' => 'signup',
                'parameters' => [
                    'user' => $user,
                ],
            ]);
            return $model->send('multiple');
        }, false);

        $result = \Yii::$app->mailer->sendMultiple($messages);

        var_dump($result); die;
    }


    public function behaviors()
    {
        $behaviors = parent::behaviors();
        $behaviors['AccessControl'] = [
            'class' => 'app\filters\AccessControl',
            'publicActions' => self::PUBLIC_ACTIONS
        ];
        $behaviors['VerbFilter'] = [
            'class' => 'app\filters\VerbFilter',
            'verbActions' => [
                'logout' => ['post'],
            ]
        ];

        return $behaviors;
    }

    public function beforeAction($action)
    {
        switch ($action->id) {
            case 'login':
            case 'reset-password':
            case 'contact':
                $this->layout = 'login';
                break;
            
            case 'signup':
            case 'signup-success':
            case 'verify':
                $this->layout = 'frontend';
                break;
            default:
                # code...
                break;
        }
        return parent::beforeAction($action);
    }

   
    public function actions()
    {
        return [
            'error' => [
                'class' => 'yii\web\ErrorAction',
                'layout' => 'error'
            ],
            'captcha' => [
                'class' => 'yii\captcha\CaptchaAction',
                'fixedVerifyCode' => YII_ENV_TEST ? 'testme' : null,
            ],
        ];
    }

    public function actionResendVerification($vt)
    {
        $user = User::findOrFailed($vt, 'verification_token');

        if ((new SignupForm())->sendEmail($user)) {
            App::success('Email verification was resent.');
        }
        else {
            App::danger('There\'s an error sending an email.');
        }

        return $this->redirect(['signup-success', 'vt' => $user->verification_token]);
    }


    public function actionVerify($vt='', $status='')
    {
        $user = User::findOrFailed($vt, 'verification_token');

        if ($status) {
            return $this->render("verification/{$status}", [
                'user' => $user
            ]);
        }

        if ($user->is_blocked == User::UNBLOCKED) {
            App::success('User already verified');

            if ($user->status != User::STATUS_ACTIVE) {
                return $this->redirect(['verify', 
                    'vt' => $user->verification_token, 
                    'status' => 'in-active'
                ]);
            }

            return $this->redirect(['verify', 
                'vt' => $user->verification_token, 
                'status' => 'already-verified'
            ]);
        }

        $user->is_blocked = User::UNBLOCKED;
        $user->generateEmailVerificationToken();
        if ($user->save()) {
            App::success('User verified');

            if ($user->status != User::STATUS_ACTIVE) {
                return $this->redirect(['verify', 
                    'vt' => $user->verification_token, 
                    'status' => 'in-active'
                ]);
            }

            return $this->redirect(['verify', 
                'vt' => $user->verification_token, 
                'status' => 'verified'
            ]);
        }


        App::danger($model->errors);
        
        return $this->redirect(['verify', 
            'vt' => $user->verification_token, 
            'status' => 'verified'
        ]);
    }

    public function actionSignupSuccess($vt='')
    {
        $user = User::findOrFailed($vt, 'verification_token');

        return $this->render('signup-success', [
            'user' => $user
        ]);
    }

    public function actionSignup()
    {
        $model = new SignupForm([
            'sex' => 'Male',
            'age' => 0
        ]);

        if ($model->load(App::post())) {
            if (($user = $model->signup()) != null) {
                return $this->redirect(['signup-success', 'vt' => $user->verification_token]);
            }

            App::danger(Html::errorSummary($model));
        }


        return $this->render('signup', [
            'model' => $model
        ]);
    }

    public function actionResetPassword()
    {
        $model = new PasswordResetForm();
        if ($model->load(App::post())) {
            if (($user = $model->process()) != null) {
                if ($model->hint) {
                    App::success("Your password hint is: '{$user->password_hint}'.");
                }
                else {
                    App::success("Email sent.");
                }
            }
            else {
                App::danger($model->errors);
            }
        }

        return $this->redirect(['login']);
    }

    /**
     * Displays homepage.
     *
     * @return string
     */
    public function actionIndex()
    {
        if (App::isLogin()) {
            return $this->redirect(['dashboard/index']);
        }

        return $this->render('index');
    }

    /**
     * Login action.
     *
     * @return Response|string
     */
    public function actionLogin()
    {
        if (!App::isGuest()) {
            return $this->goHome();
        }

        $model = new LoginForm();
        $PSR = new PasswordResetForm();
        if ($model->load(App::post()) && $model->login()) {
            return $this->goBack();
        }

        $model->password = '';
        return $this->render('login', [
            'model' => $model,
            'PSR' => $PSR,
        ]);
    }

    /**
     * Logout action.
     *
     * @return Response
     */
    public function actionLogout()
    {
        App::logout();

        return $this->goHome();
    }

    /**
     * Displays contact page.
     *
     * @return Response|string
     */
    public function actionContact()
    {
        $model = new ContactForm();
        if ($model->load(App::post()) && $model->contact()) {
            App::success('Thank you for contacting us. We will respond to you as soon as possible.');
            return $this->refresh();
        }
        return $this->render('contact', [
            'model' => $model,
        ]);
    }

    /**
     * Displays about page.
     *
     * @return string
     */
    public function actionAbout()
    {
        return $this->render('about');
    }
}
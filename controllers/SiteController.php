<?php

namespace app\controllers;

use app\helpers\App;
use app\helpers\ArrayHelper;
use app\helpers\ChatbotHelper;
use app\helpers\Html;
use app\models\Chat;
use app\models\Concern;
use app\models\User;
use app\models\form\ContactForm;
use app\models\form\ForgotPasswordForm;
use app\models\form\LoginForm;
use app\models\form\PasswordResetForm;
use app\models\form\ResetPasswordForm;
use app\models\form\SignupForm;
use app\models\form\UserVerificationForm;

class SiteController extends Controller
{
    const PUBLIC_ACTIONS = [
        'forgot-password',
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
            case 'forgot-password':
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


    public function actionVerify($vt='')
    {
        $model = new UserVerificationForm(['verification_token' => $vt]);
        if ($model->verify()) {
            App::success('User account was verified');
        }
        else {
            App::danger(Html::errorSummary($model));
        }

        return $this->redirect(['login']);
        
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

    public function actionResetPassword($prt)
    {
        $model = new ResetPasswordForm(['password_reset_token' => $prt]);
        if ($model->load(App::post())) {
            if (($user = $model->reset()) != null) {
                App::success("Password reset successfully.");
                return $this->redirect(['login']);
            }
            else {
                App::danger($model->errors);
            }
        }

        return $this->render('reset-password', [
            'model' => $model
        ]);
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
        return $this->render('about', [
            'aboutUs' => App::setting('aboutUs')
        ]);
    }

    public function actionForgotPassword()
    {
        $model = new ForgotPasswordForm();
        if ($model->load(App::post())) {
            if (($user = $model->process()) != null) {
                if ($model->hint) {
                    App::success("Your password hint is: '{$user->password_hint}'.");
                }
                else {
                    App::success("We've sent an email for resetting your password.");
                }
            }
            else {
                App::danger($model->errors);
            }

            return $this->redirect(['login']);
        }
       

        return $this->render('forgot-password', [
            'model' => $model,
        ]);
    }

    public function actionInitChatbotData($user_id='')
    {
        // $session_id = $session_id ?: App::session('id');
        $user_id = $user_id ?: App::identity('id');

        $messages = Chat::find()
            ->where(['user_id' => $user_id])
            ->limit(20)
            ->orderBy(['id' => SORT_DESC])
            ->all();

        $totalMessages = Chat::find()
            ->where(['user_id' => $user_id])
            ->count();

        $minimumMessageId = Chat::find()
            ->where(['user_id' => $user_id])
            ->min('id');

        $concerns = Concern::all();

        return $this->asJson([
            'status' => 'success',
            'messages' => array_reverse($messages),
            'totalMessages' => $totalMessages,
            'minimumMessageId' => $minimumMessageId,
            'concerns' => $concerns,
        ]);
    }

    public function actionChatPoll($user_id='')
    {
        session_write_close();
        ignore_user_abort(false);
        set_time_limit(0);

        // $session_id = $session_id ?: App::session('id');
        $user_id = $user_id ?: App::identity('id');

        $counter = rand(2, 5);
        $maxMessageId_post = (int) (App::post('maxMessageId') ?: 0);
        $minMessageId_post = (int) (App::post('minMessageId') ?: 0);
        $totalMessages_post = (int) (App::post('totalMessages') ?: 0);

        for ($i=0; $i < $counter; $i++) { 
            $response = [];

            $totalMessages = Chat::find()
                ->where(['user_id' => $user_id])
                ->count();

            if ($totalMessages > 0 && ($totalMessages != $totalMessages_post)) {
                $response['totalMessages'] = $totalMessages;
            }

            $messages = Chat::find()
                ->where(['user_id' => $user_id])
                ->andWhere(['>', 'id', $maxMessageId_post])
                ->orderBy(['id' => SORT_DESC])
                ->limit(20)
                ->all();

            if ($messages) {
                $response['messages'] = array_reverse($messages);
            }

            if ($response) {
                $response['status'] = 'success';
                return $this->asJson($response);
            }
            
            sleep(1);
        }

        return $this->asJson([
            'status' => 'failed',
            'errorSummary' => 'no changes'
        ]);
    }

    public function actionLoadPreviousMessages($user_id='')
    {
        // $session_id = $session_id ?: App::session('id');
        $user_id = $user_id ?: App::identity('id');
        
        if (($post = App::post()) != null) {
            $minMessageId = (int) (App::post('minMessageId') ?: 1);

            $messages = Chat::find()
                ->where(['user_id' => $user_id])
                ->andWhere(['<', 'id', $minMessageId])
                ->orderBy(['id' => SORT_DESC])
                ->limit(20)
                ->all();

            if ($messages) {
                return $this->asJson([
                    'status' => 'success',
                    'messages' => array_reverse($messages)
                ]);
            }
            return $this->asJson([
                'status' => 'failed',
                'errorSummary' => 'no messages'
            ]);
        }

        return $this->asJson([
            'status' => 'failed',
            'errorSummary' => 'No post data'
        ]);
    }

    public function actionSendNewMessage()
    {
        if (($post = App::post()) != null) {
            $session = \Yii::$app->session;
            
            if (ChatbotHelper::changingConcern($post['hiddenMessage'])) {
                $session->remove('concern_id');
                $session->remove('questions');
                $session->remove('activeQuestion');

                $concernId = ChatbotHelper::getConcernId($post['hiddenMessage']);

                $session['concern_id'] = $concernId;
                $session['questions'] = ChatbotHelper::getQuestions();
                $session['activeQuestion'] = ChatbotHelper::getActiveQuestion();

                Chat::addUser($post['message'], $post['hiddenMessage']);
                Chat::response($session['activeQuestion']);

                return $this->asJson(['status' => 'success', $session]);
            }


            if (($activeQuestion = $session['activeQuestion'] ?? null) != null) {
                if (!in_array(trim(strtolower($post['message'])), array_map('strtolower', $activeQuestion['expected_answers']))) {

                    Chat::addUser($post['message'], $post['hiddenMessage']);
                    Chat::addChatbot('Ang sagot ay wala sa pagpipilian maaring sumagot lamang ng nasa pagpipilian');
                    Chat::response($activeQuestion);

                    return $this->asJson([
                        'status' => 'failed',
                        'errorSummary' => 'Answer not expected'
                    ]);
                }


                Chat::addUser($post['message'], $post['hiddenMessage']);

                $session['questions'] = ChatbotHelper::updateQuestions($post['message']);
                $session['activeQuestion'] = ChatbotHelper::getActiveQuestion();

                if ($session['activeQuestion'] === false) {
                    // Chat::addChatbot('Maraming salamat sa pagsagot');
                    Chat::conclusion($session['concern_id'], $session['questions']);

                    $session->remove('concern_id');
                    $session->remove('questions');
                    $session->remove('activeQuestion');
                }
                else {
                    Chat::addChatbot($session['activeQuestion']['label']);
                    Chat::expectedAnswers($session['activeQuestion']);
                }

                return $this->asJson(['status' => 'success', $session]);
            }
            else {

                if (($concern = Concern::findOne(['name' => $post['message']])) != null) {
                    $session['concern_id'] = $concern->id;
                    $session['questions'] = ChatbotHelper::getQuestions();
                    $session['activeQuestion'] = ChatbotHelper::getActiveQuestion();

                    Chat::addUser($post['message'], $post['hiddenMessage']);
                    Chat::response($session['activeQuestion']);
                }
                else {
                    Chat::addUser($post['message'], $post['hiddenMessage']);
                    if (($predict = ChatbotHelper::predict($post['message'])) != null) {
                        Chat::addChatbot('Ang ibig mo bang sabihin ay:');
                        Chat::addChatbot($predict);
                    }
                    else {
                        Chat::addChatbot(App::setting('chatbot')->default_message);
                    }
                }

                return $this->asJson(['status' => 'success', $session]);
            }
            
        }

        return $this->asJson([
            'status' => 'failed',
            'errorSummary' => 'No post data'
        ]);
    }
}
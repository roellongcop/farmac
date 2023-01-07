<?php

namespace app\models;

use app\helpers\App;
use app\helpers\ArrayHelper;
use app\helpers\Html;
use app\widgets\Anchor;
use app\widgets\Label;

/**
 * This is the model class for table "{{%chats}}".
 *
 * @property int $id
 * @property int $user_id
 * @property int $reply_id
 * @property string $session_id
 * @property string|null $message
 * @property string|null $hidden_message
 * @property int $status
 * @property int $type
 * @property int $record_status
 * @property int $created_by
 * @property int $updated_by
 * @property string $created_at
 * @property string $updated_at
 */
class Chat extends ActiveRecord
{
    const ANSWERED = 0;
    const UN_ANSWERED = 1;
    const TRAINED = 2;

    const TYPE_CHATBOT = 0;
    const TYPE_USER = 1;

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%chats}}';
    }

    public function config()
    {
        return [
            'controllerID' => 'chat',
            'mainAttribute' => 'id',
            'paramName' => 'id',
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return $this->setRules([
            [['user_id', 'reply_id', 'status', 'type'], 'integer'],
            [['message'], 'required'],
            [['message'], 'string'],
            [['session_id', 'hidden_message'], 'string', 'max' => 255],
            ['user_id', 'exist', 'targetRelation' => 'user', 'when' => fn($model) => $model->user_id],
            ['reply_id', 'exist', 'targetRelation' => 'reply', 'when' => fn($model) => $model->reply_id],
            ['status', 'in', 'range' => [
                self::ANSWERED,
                self::UN_ANSWERED,
                self::TRAINED
            ]],
            ['type', 'in', 'range' => [
                self::TYPE_CHATBOT,
                self::TYPE_USER,
            ]],
            [['message', 'hidden_message'], 'trim'],
            [['hidden_message'], 'safe'],
        ]);
    }

    public function fields()
    {
        $fields = parent::fields();
        $fields['timeSent'] = 'timeSent';
        $fields['displayMessage'] = 'displayMessage';


        return $fields;
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return $this->setAttributeLabels([
            'id' => 'ID',
            'user_id' => 'User ID',
            'reply_id' => 'Reply ID',
            'session_id' => 'Session ID',
            'message' => 'Message',
            'hidden_message' => 'Hidden Message',
            'status' => 'Status',
            'type' => 'Type',
        ]);
    }

    /**
     * {@inheritdoc}
     * @return \app\models\query\ChatQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new \app\models\query\ChatQuery(get_called_class());
    }
     
    public function gridColumns()
    {
        return [
            'session_id' => [
                'attribute' => 'session_id', 
                'format' => 'raw',
                'value' => function($model) {
                    return Anchor::widget([
                        'title' => $model->session_id,
                        'link' => $model->viewUrl,
                        'text' => true
                    ]);
                }
            ],
            'message' => ['attribute' => 'message', 'format' => 'raw'],
            'reply' => [
                'attribute' => 'reply_id', 
                'label' => 'reply', 
                'format' => 'raw', 
                'value' => 'replyList'
            ],
            'user_email' => [
                'label' => 'User email',
                'attribute' => 'userEmail', 
                'format' => 'raw',
                'value' => 'userEmail'
            ],
            'status' => ['attribute' => 'status', 'format' => 'raw', 'value' => 'statusBadge'],
            'type' => ['attribute' => 'type', 'format' => 'raw', 'value' => 'typeBadge'],
            // 'reply_id' => ['attribute' => 'reply_id', 'format' => 'raw'],
        ];
    }

    public function detailColumns()
    {
        return [
            // 'reply_id:raw',
            'session_id:raw',
            'userEmail:raw',
            'message:raw',
            'statusBadge:raw',
            'typeBadge:raw',
        ];
    }

    public function beforeSave($insert)
    {
        if (!parent::beforeSave($insert)) {
            return false;
        }

        $this->message = $this->setTheMessage();
        
        if ($insert) {
            $this->user_id = App::ifElse(App::identity(), fn($user) => $user->id, 0);
            $this->session_id = App::session('id');
        }

        return true;
    }

    public function setTheMessage()
    {
        $replace = $this->replace();

        $message = $this->message;

        foreach ($replace as $key => $data) {
            if (str_contains($message, $key)) {
                $value = is_callable($data['value']) ? call_user_func($data['value']): $data['value'];

                $message = str_replace($key, $value, $message);
            }
        }

        return $message;
    }

    public function replace()
    {
        $chatbot = App::setting('chatbot');

        return [
            '[CHATBOT_NAME]' => [
                'description' => 'Chatbot Name',
                'value' => $chatbot->name
            ],
        ];
    }

    public function getReply()
    {
        return $this->hasOne(Chat::class, ['id' => 'reply_id']);
    }

    public function getUserEmail()
    {
        return App::if($this->user, fn($user) => $user->email);
    }

    public function getUser()
    {
        return $this->hasOne(User::class, ['id' => 'user_id']);
    }

    public function getStatusBadge()
    {
        $param = App::params('chat_status')[$this->status];

        if ($param) {
            return Label::widget(['options' => $param]);
        }
    }


    public function getTypeBadge()
    {
        $param = App::params('chat_type')[$this->type];

        if ($param) {
            return Label::widget(['options' => $param]);
        }
    }

    public function getDefaultGridColumns()
    {
        return [
            'serial',
            'checkbox',
            'session_id',
            'message',
            'reply',
            'status',
            'type',
            'created_at',
            'active',
        ];
    }

    public function getReplyList()
    {
        return App::ifElse(
            $this->replies, 
            fn($replies) => Html::tag('ul', 
                App::foreach($replies, fn($chat) => Html::tag('li', $chat->displayMessage))
            ), 
            'Default Message'
        );
    }

    public function dateDiff($date1, $date2, $format="days")
    {
        $date1 = new \DateTime($date1);
        $date2 = new \DateTime($date2);

        $diff = $date1->diff($date2);

        return $diff->{$format};
    }

    public function getTimeSent()
    {
        $start = date("Y-m-d", strtotime(App::formatter()->asDateToTimezone('', 'Y-m-d H:i:s'))); 
        $end = date("Y-m-d", strtotime($this->created_at)); 

        $day   = $this->dateDiff($start, $end);
        $month = $this->dateDiff($start, $end, 'm');
        $year  = $this->dateDiff($start, $end, 'y');

        if ($year > 1) {
            return implode(' AT ', [
                date('M d, Y', strtotime($this->createdAt)),
                date('h:i A', strtotime($this->createdAt)),
            ]);
        }
        elseif ($month > 1 || $day >= 6) {
            return implode(' AT ', [
                date('M d', strtotime($this->createdAt)),
                date('h:i A', strtotime($this->createdAt)),
            ]);
        }
        elseif ($day > 1 || $start != $end) {
            return implode(' AT ', [
                date('D', strtotime($this->createdAt)),
                date('h:i A', strtotime($this->createdAt)),
            ]);
        }
        else {
            return date('h:i A', strtotime($this->createdAt));
        }
    }

    public function getReplies()
    {
        return $this->hasMany(Chat::class, ['reply_id' => 'id']);
    }

    // public static function response($training, $chat)
    // {
        // if ($training->suggestion == 'ai') {
        //     $faker = \Faker\Factory::create();
        //     $response = $faker->randomElement($training->response);
        //     $model = new self([
        //         'session_id' => App::session('id'),
        //         'reply_id' => $chat->id,
        //         'type' => self::TYPE_CHATBOT,
        //         'message' => $response,
        //         'status' => self::ANSWERED 
        //     ]);
        //     $model->save();
        // }
        // else {
        //     foreach ($training->response as $response) {
        //         $model = new self([
        //             'session_id' => App::session('id'),
        //             'reply_id' => $chat->id,
        //             'type' => self::TYPE_CHATBOT,
        //             'message' => $response,
        //             'status' => self::ANSWERED 
        //         ]);
        //         $model->save();
        //     }
        // }
    // }

    public static function dummy()
    {
        $chat = new Chat([
            'session_id' => App::session('id'),
            'type' => Chat::TYPE_CHATBOT,
            'message' => App::setting('chatbot')->default_message,
            'status' => Chat::ANSWERED 
        ]);
        $chat->save();
    }

    public function getTotalPerUser()
    {
        return self::find()
            ->where(['user_id' => $this->user_id])
            ->count();
    }

    public function getTotalPerSession()
    {
        return self::find()
            ->where(['session_id' => $this->session_id])
            ->count();
    }

    public function getDisplayMessage()
    {
        return nl2br($this->message);
    }

    public static function addUser($message='', $hiddenMessage='')
    {
        $chat = new self([
            'type' => self::TYPE_USER,
            'message' => $message,
            'hidden_message' => $hiddenMessage,
            'status' => self::ANSWERED
        ]);
        return $chat->save();
    }

    public static function addMultipleChatbot($messages=[], $hiddenMessages=[])
    {
        if ($messages) {
            foreach ($messages as $key => $message) {
                self::addChatbot($message, $hiddenMessage[$key] ?? '');
            }
        }
    }

    public static function addChatbot($message='', $hiddenMessage='')
    {
        $chat = new self([
            'type' => self::TYPE_CHATBOT,
            'message' => $message,
            'hidden_message' => $hiddenMessage,
            'status' => self::ANSWERED
        ]);
        $chat->save();
    }

    public static function response($helpdesk=[])
    {
        if ($helpdesk) {
            self::addChatbot(implode("\n", [
                $helpdesk->question,
                self::expectedAnswers($helpdesk->expectedAnswers)
            ]));
        }
    }

    public static function expectedAnswers($expectedAnswers=[])
    {
        if ($expectedAnswers) {
            // self::addChatbot(
                return implode(' ', [
                    App::foreach($expectedAnswers, fn ($ans) => Html::tag('a', $ans, [
                        'href' => '#',
                        'data-message' => trim($ans),
                        'data-hidden_message' => trim($ans),
                        'class' => 'btn btn-outline-success btn-pill mb-1 btn-hidden-message',
                    ])),
                    Html::tag('a', 'Kanselahin', [
                        'href' => '#',
                        'data-message' => 'Kanselahin',
                        'data-hidden_message' => Helpdesk::CANCEL_PATTERN,
                        'class' => 'btn btn-outline-danger btn-pill mb-1 btn-hidden-message',
                    ])
                ]);
            // );
        }
    }

    // tree decision making algo
    public static function oldConclusion($concern_id, $questions)
    {

        if ($concern_id && $questions) {
            $concern = Concern::findOne($concern_id);

            if ($concern) {

                $decisionTree = $concern->decisionTree['data'];

                $conclusions = [];


                foreach ($decisionTree as $dt) {
                    $counter = 0;
                    foreach ($questions as $question) {
                        if (isset($dt[$question['label']])) {
                            if (trim(strtolower($dt[$question['label']])) == trim(strtolower($question['answer']))) {
                                $counter++;
                            }
                        }
                    }
                    if ($counter == $concern->totalRules) {
                        $conclusions[] = $dt['conclusion'];
                        $counter = 0;
                    }
                }

             

                if ($conclusions) {
                    foreach ($conclusions as $conclusion) {
                        self::addChatbot($conclusion);
                    }
                }
                else {
                    self::addChatbot($concern->fallback_message);
                }
            }
        }
    }

    public static function filterConclusion($question, $answer, $decisionTree)
    {
        $data = [];

        foreach ($decisionTree as $index => $dt) {

            if (isset($dt[$question])) {
                if ($dt[$question] == $answer) {
                    
                    $data[] = $dt;
                    break;
                }
            }
        }

        return $data;
    }

    public static function conclusion($concern_id)
    {

        if (($concern = Concern::findOne($concern_id)) != null) {

            $decisionTree = $concern->decisionTree['data'];

            $helpdesks = Helpdesk::dropdown('question', 'answer', [
                'status' => Helpdesk::COMPLETED,
                'user_id' => App::identity('id'),
                'concern_id' => $concern->id
            ]);

            foreach ($helpdesks as $question => $answer) {
                $decisionTree = self::filterConclusion($question, $answer, $decisionTree);
            }

            $conclusion = App::if($decisionTree[0] ?? [], fn ($d) => $d['conclusion']);
         

            if ($conclusion) {
                self::addChatbot($conclusion);
            }
            else {
                self::addChatbot($concern->fallback_message);
            }

            Helpdesk::updateAll(['status' => Helpdesk::FINISHED], [
                'status' => Helpdesk::COMPLETED,
                'user_id' => App::identity('id'),
                'concern_id' => $concern->id
            ]);
        }
    }
}
<?php

namespace app\models;

use app\helpers\App;
use app\helpers\ArrayHelper;
use app\widgets\Anchor;
use app\helpers\Html;
use yii\db\Expression;
use yii\db\Query;

/**
 * This is the model class for table "{{%helpdesks}}".
 *
 * @property int $id
 * @property int $user_id
 * @property int $concern_id
 * @property string $question
 * @property string|null $expectation
 * @property int $status
 * @property int $record_status
 * @property int $created_by
 * @property int $updated_by
 * @property string $created_at
 * @property string $updated_at
 */
class Helpdesk extends ActiveRecord
{
    const CONCERN_PATTERN = '/concern-';

    const PENDING = 0;
    const COMPLETED = 1;
    const ABANDONED = 2;
    const FINISHED = 3;

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%helpdesks}}';
    }

    public function config()
    {
        return [
            'controllerID' => 'helpdesk',
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
            [['user_id', 'concern_id', 'status'], 'integer'],
            [['question', 'user_id', 'concern_id', 'status'], 'required'],
            [['expectation'], 'safe'],
            [['question', 'answer'], 'string', 'max' => 255],
            ['user_id', 'exist', 'targetRelation' => 'user'],
            ['concern_id', 'exist', 'targetRelation' => 'concern'],
            ['status', 'in', 'range' => [
                self::PENDING,
                self::COMPLETED,
                self::ABANDONED,
            ]]
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return $this->setAttributeLabels([
            'id' => 'ID',
            'user_id' => 'User ID',
            'concern_id' => 'Concern ID',
            'question' => 'Question',
            'expectation' => 'Expectation',
            'status' => 'Status',
        ]);
    }

    /**
     * {@inheritdoc}
     * @return \app\models\query\HelpdeskQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new \app\models\query\HelpdeskQuery(get_called_class());
    }

    public function getUser()
    {
        return $this->hasOne(User::class, ['id' => 'user_id']);
    }

    public function getConcern()
    {
        return $this->hasOne(Concern::class, ['id' => 'concern_id']);
    }
     
    public function gridColumns()
    {
        return [
            'user_id' => [
                'attribute' => 'user_id', 
                'format' => 'raw',
                'value' => function($model) {
                    return Anchor::widget([
                        'title' => $model->user_id,
                        'link' => $model->viewUrl,
                        'text' => true
                    ]);
                }
            ],
            'concern_id' => ['attribute' => 'concern_id', 'format' => 'raw'],
            'question' => ['attribute' => 'question', 'format' => 'raw'],
            'expectation' => ['attribute' => 'expectation', 'format' => 'raw'],
        ];
    }

    public function detailColumns()
    {
        return [
            'user_id:raw',
            'concern_id:raw',
            'question:raw',
            'expectation:raw',
        ];
    }



    public static function getConcernId($message)
    {
        $explode = explode(self::CONCERN_PATTERN, $message);

        return $explode[1] ?? 0;
    }

    public static function changingConcern($message)
    {
        if (App::isLogin()) {
            $changingConcern = str_contains($message, self::CONCERN_PATTERN);

            if ($changingConcern) {
                self::addConcern(self::getConcernId($message));
                return true;
            }
        }
    }

    public static function addConcern($concern)
    {
        if (App::isLogin()) {
            $identity = App::identity();
            $concern = is_object($concern) ? $concern: Concern::findOne($concern);

            if ($concern) {
                self::updateAll(['status' => self::ABANDONED], ['user_id' => $identity->id]);

                $data = App::foreach($concern->rules, function($rule) use($concern, $identity) {
                    return [
                        'user_id' => $identity->id,
                        'concern_id' => $concern->id,
                        'question' => $rule['label'],
                        'expectation' => json_encode($rule['sub'] ?? []),
                        'status' => Helpdesk::PENDING,
                        'record_status' => Helpdesk::RECORD_ACTIVE,
                        'created_by' => $identity->id,
                        'updated_by' => $identity->id,
                        'created_at' => new Expression('UTC_TIMESTAMP'),
                        'updated_at' => new Expression('UTC_TIMESTAMP'),
                    ];
                }, false);
                Helpdesk::batchInsert(array_values($data));
            }

            return true;
        }
    }

    public static function activeHelpdesk()
    {
        if (App::isLogin()) {
            $helpdesk = self::find()
                ->where([
                    'user_id' => App::identity('id'),
                    'status' => self::PENDING
                ])
                ->orderBy(['id' => SORT_ASC])
                ->one();

            if ($helpdesk) {
                return $helpdesk;
            }
        }
    }

    public function getExpectedAnswers()
    {
        return ArrayHelper::map($this->expectation, 'label', 'label');
    }

    public function behaviors()
    {
        $behaviors = parent::behaviors();
        $behaviors['JsonBehavior']['fields'] = [
            'expectation', 
        ];

        return $behaviors;
    }

    public function completed($answer='')
    {
        $this->answer = $answer;
        $this->status = self::COMPLETED;
        $this->save();
        if ($this->save()) {
                    
        }
        else {
            dd($this->errors);
        }

        $this->refresh();
    }

    public static function predict($query='')
    {
        $keywords = explode(' ', trim($query));
        $condition = [];
        $orderBy = [];

        if (count($keywords) == 1) {
            $condition = ['LIKE', 'name', trim($query)];
            $rawQuery = (new Query())
                ->select(['COUNT("*")'])
                ->where(['LIKE', 'name', trim($query)])
                ->createCommand()
                ->rawSql;

            $orderBy = ["({$rawQuery})" => SORT_DESC];
        }
        else {
            $condition = ['or'];
            $orders = [];
            foreach ($keywords as $keyword) {
                $condition[] = ['LIKE', 'name', trim($keyword)];

                $rawQuery = (new Query())
                    ->select(['COUNT("*")'])
                    ->where(['LIKE', 'name', trim($keyword)])
                    ->createCommand()
                    ->rawSql;

                $orders[] = "({$rawQuery})";
            }

            $orderByQuery = implode(' + ', $orders);

            $orderBy = ["({$orderByQuery})" => SORT_DESC];
        }

        $orderBy['LENGTH(name)'] = SORT_ASC;

        $training = Concern::find()
            ->where($condition)
            ->orderBy($orderBy)
            ->limit(3)
            ->all();


        if ($training) {
            $predict = App::foreach($training, fn ($t) => Html::tag('a', $t->name, [
                'href' => '#',
                'data-message' => $t->name,
                'data-hidden_message' => self::CONCERN_PATTERN . $t->id,
                'class' => 'btn btn-outline-success btn-pill mb-1 btn-hidden-message',
            ]));
            return $predict;
        }
    }

    public function getSubconclusions()
    {
        $array = ArrayHelper::map($this->expectation, 'label', 'sub');


        $data = $array[$this->answer] ?? '';

        if ($data) {
            return array_values(ArrayHelper::map($data, 'label', 'label'));
        }
    }
}
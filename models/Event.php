<?php

namespace app\models;

use app\helpers\App;
use app\helpers\Html;
use app\helpers\StringHelper;
use app\helpers\Url;
use app\widgets\Anchor;
use yii\db\Expression;

/**
 * This is the model class for table "{{%events}}".
 *
 * @property int $id
 * @property string $title
 * @property string|null $description
 * @property string|null $start
 * @property string|null $end
 * @property string|null $slug
 * @property string|null $photo
 * @property int $record_status
 * @property int $created_by
 * @property int $updated_by
 * @property string $created_at
 * @property string $updated_at
 */
class Event extends ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%events}}';
    }

    public function config()
    {
        return [
            'controllerID' => 'event',
            'mainAttribute' => 'title',
            'paramName' => 'token',
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return $this->setRules([
            [['title', 'color', 'start', 'end'], 'required'],
            [['description'], 'string'],
            [['start', 'end',], 'safe'],
            [['title', 'photo'], 'string', 'max' => 255],
            [['start', 'end'], 'validateDate'],
        ]);
    }


    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return $this->setAttributeLabels([
            'id' => 'ID',
            'title' => 'Title',
            'description' => 'Description',
            'start' => 'Start',
            'end' => 'End',
            'photo' => 'Photo',
            'tablePhoto' => 'Photo'
        ]);
    }

    public function validateDate($attribute, $params)
    {
        $start = strtotime($this->start);
        $end = strtotime($this->end);

        if ($start > $end) {
            $this->addError($attribute, 'Start date must less than end date');
        }
    }

    /**
     * {@inheritdoc}
     * @return \app\models\query\EventQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new \app\models\query\EventQuery(get_called_class());
    }
     
    public function gridColumns()
    {
        return [
            'photo' => [
                'label' => 'photo',
                'attribute' => 'title', 
                'format' => 'raw',
                'value' => 'tablePhoto'
            ],
            'title' => [
                'attribute' => 'title', 
                'format' => 'raw',
                'value' => function($model) {
                    return Anchor::widget([
                        'title' => $model->title,
                        'link' => $model->viewUrl,
                        'text' => true
                    ]);
                }
            ],
            'description' => ['attribute' => 'description', 'format' => 'raw'],
            'start' => ['attribute' => 'start', 'format' => 'raw'],
            'end' => ['attribute' => 'end', 'format' => 'raw'],
        ];
    }

    public function getTablePhoto()
    {
        return Html::image($this->photo, ['w' => 50], [
            'class' => 'img-fluid symbol'
        ]);
    }

    public function detailColumns()
    {
        return [
            'tablePhoto:raw',
            'title:raw',
            'description:raw',
            'color:raw',
            'start:raw',
            'end:raw',
        ];
    }

    public function getImageFiles()
    {
        return File::findAll(['token' => $this->photo]);
    }

    public function behaviors()
    {
        $behaviors = parent::behaviors();
  
        $behaviors['SluggableBehavior'] = [
            'class' => 'yii\behaviors\SluggableBehavior',
            'attribute' => 'title',
            'ensureUnique' => true,
        ];

        $behaviors['DateBehavior'] = [
            'class' => 'app\behaviors\DateBehavior',
            'inFormat' => 'Y-m-d H:i:s',
            'outFormat' => 'm/d/Y h:i:s A',
            'attributes' => [
                'start',
                'end',
            ]
        ];

        return $behaviors;
    }

    public static function recent($limit=5)
    {
        return self::find()
            ->orderBy(['id' => SORT_DESC])
            ->limit($limit)
            ->all();
    }

    public function getTruncatedContent($len=200)
    {
        return StringHelper::truncate(strip_tags($this->description), $len);
    }

    public function getClientUrlByTitle()
    {
        return Url::toRoute(['event/calendar-client']);
    }

    public function afterSave($insert, $changedAttributes)
    {
        parent::afterSave($insert, $changedAttributes);

        if ($insert) {
            $data = App::foreach(User::findAll(['role_id' => Role::CLIENT]), fn ($user) => [
                'status' => Notification::STATUS_UNREAD,
                'user_id' => $user->id,
                'type' => 'event',
                'link' => $this->clientUrlByTitle,
                'message' => "There is a new event *{$this->title}*",
                'token' => time() . $user->id,
                'record_status' => self::RECORD_ACTIVE,
                'created_by' => App::identity('id'),
                'updated_by' => App::identity('id'),
                'created_at' => new Expression('UTC_TIMESTAMP'),
                'updated_at' => new Expression('UTC_TIMESTAMP'),
            ], false);

            Notification::batchInsert($data);
        }
    }
}
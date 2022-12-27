<?php

namespace app\models;

use app\helpers\Html;
use app\helpers\StringHelper;
use app\widgets\Anchor;
use app\widgets\Youtube;

/**
 * This is the model class for table "{{%videos}}".
 *
 * @property int $id
 * @property string $title
 * @property string|null $description
 * @property string|null $link
 * @property string|null $slug
 * @property int $record_status
 * @property int $created_by
 * @property int $updated_by
 * @property string $created_at
 * @property string $updated_at
 */
class Video extends ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%videos}}';
    }

    public function config()
    {
        return [
            'controllerID' => 'video',
            'mainAttribute' => 'title',
            'paramName' => 'slug',
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return $this->setRules([
            [['title', 'link'], 'required'],
            [['description', 'link'], 'string'],
            [['title'], 'string', 'max' => 255],
            ['link', 'url']
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
            'link' => 'Link',
        ]);
    }

    /**
     * {@inheritdoc}
     * @return \app\models\query\VideoQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new \app\models\query\VideoQuery(get_called_class());
    }
     

    public function getDefaultGridColumns()
    {
        return [
            'serial',
            'checkbox',
            // 'video',
            'title',
            'description',
            'active',
            'created_at',
            'last_updated'
        ];
    }

    public function gridColumns()
    {
        return [
            // 'video' => [
            //     'label' => 'video',
            //     'attribute' => 'title', 
            //     'format' => 'raw',
            //     'value' => fn ($model) => Youtube::widget(['videoId' => $model->videoId])
            // ],
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
            'link' => ['attribute' => 'link', 'format' => 'raw'],
        ];
    }

    public function detailColumns()
    {
        return [
            'title:raw',
            'description:raw',
            // 'link:raw',
        ];
    }

    public function behaviors()
    {
        $behaviors['SluggableBehavior'] = [
            'class' => 'yii\behaviors\SluggableBehavior',
            'attribute' => 'title',
            'ensureUnique' => true,
        ];

        return $behaviors;
    }

    public function getVideoId()
    {
        preg_match("/^(?:http(?:s)?:\/\/)?(?:www\.)?(?:m\.)?(?:youtu\.be\/|youtube\.com\/(?:(?:watch)?\?(?:.*&)?v(?:i)?=|(?:embed|v|vi|user|shorts)\/))([^\?&\"'>]+)/", $this->link, $matches);

        return $matches[1] ?? '';
    }

    public function getClientDescription($limit = 150)
    {
        if (strlen($this->description) > $limit) {
            return StringHelper::truncate($this->description, $limit) 
                . Html::tag('a', 'See more', [
                    'class' => 'font-weight-bold see-more cursor-pointer', 
                    'data-toggle' => 'collapse',
                    'href' => "#description-{$this->id}"
                ]);
        }
        
        return $this->description;
    }
}
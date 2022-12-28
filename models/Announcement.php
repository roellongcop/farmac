<?php

namespace app\models;

use app\helpers\App;
use app\helpers\Html;
use app\helpers\Url;
use app\widgets\Anchor;

/**
 * This is the model class for table "{{%announcements}}".
 *
 * @property int $id
 * @property string $title
 * @property string|null $content
 * @property string|null $photos
 * @property int $record_status
 * @property int $created_by
 * @property int $updated_by
 * @property string $created_at
 * @property string $updated_at
 */
class Announcement extends ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%announcements}}';
    }

    public function config()
    {
        return [
            'controllerID' => 'announcement',
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
            [['title'], 'required'],
            [['content'], 'string'],
            [['title'], 'string', 'max' => 255],
            [['photos'], 'safe']
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
            'content' => 'Content',
            'photos' => 'Photos',
        ]);
    }

    /**
     * {@inheritdoc}
     * @return \app\models\query\AnnouncementQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new \app\models\query\AnnouncementQuery(get_called_class());
    }

    public function getDefaultGridColumns()
    {
        return [
            'serial',
            'checkbox',
            'photo',
            'title',
            'active',
            'created_at',
            'last_updated'
        ];
    }
     
    public function gridColumns()
    {
        return [
            'photo' => [
                'label' => 'photo',
                'attribute' => 'title', 
                'format' => 'raw',
                'value' => fn ($model) => Html::image($model->imageFileToken, ['w' => 50], [
                    'class' => 'img-fluid symbol'
                ])
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
            'content' => ['attribute' => 'content', 'format' => 'raw'],
            // 'photos' => ['attribute' => 'photos', 'format' => 'raw'],
        ];
    }

    public function detailColumns()
    {
        return [
            'title:raw',
            'content:raw',
            'imagePreviews:raw',
        ];
    }

    public function behaviors()
    {
        $behaviors = parent::behaviors();
        $behaviors['JsonBehavior']['fields'] = [
            'photos', 
        ];
        $behaviors['SluggableBehavior'] = [
            'class' => 'yii\behaviors\SluggableBehavior',
            'attribute' => 'title',
            'ensureUnique' => true,
        ];

        return $behaviors;
    }

    public function getImageFileToken()
    {
        $imageFile = $this->imageFile;

        return $imageFile ? $imageFile->token: '';
    }

    public function getImageFile()
    {
        $imageFiles = $this->imageFiles;

        return $imageFiles[0] ?? '';
    }

    public function getImageFiles()
    {
        return File::findAll(['token' => $this->photos]);
    }

    public function getImagePreviews($token='')
    {
        return App::foreach($this->imageFiles, function($file) use($token) {
            return $token == $file->token ? '': Html::tag('a', 
                Html::image($file->token, ['w' => 150], [
                    'class' => 'img-fluid symbol m-2',
                    'style' => 'height: 150px;width: 150px;'
                ]), 
                [
                    'href' => $file->viewerUrl,
                    'target' => '_blank'
                ]
            );
        });
    }
}
<?php

namespace app\models;

use app\widgets\Anchor;

/**
 * This is the model class for table "{{%articles}}".
 *
 * @property int $id
 * @property int $parent_id
 * @property string $category
 * @property string $menu
 * @property string $title
 * @property string $photo
 * @property string|null $content
 * @property int $record_status
 * @property int $created_by
 * @property int $updated_by
 * @property string $created_at
 * @property string $updated_at
 */
class Article extends ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%articles}}';
    }

    public function config()
    {
        return [
            'controllerID' => 'article',
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
            [['parent_id'], 'integer'],
            [['category', 'menu', 'title', 'photo'], 'required'],
            [['content'], 'string'],
            [['category', 'menu', 'title', 'photo'], 'string', 'max' => 255],
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return $this->setAttributeLabels([
            'id' => 'ID',
            'parent_id' => 'Parent ID',
            'category' => 'Category',
            'menu' => 'Menu',
            'title' => 'Title',
            'photo' => 'Photo',
            'content' => 'Content',
        ]);
    }

    /**
     * {@inheritdoc}
     * @return \app\models\query\ArticleQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new \app\models\query\ArticleQuery(get_called_class());
    }
     
    public function gridColumns()
    {
        return [
            'parent_id' => [
                'attribute' => 'parent_id', 
                'format' => 'raw',
                'value' => function($model) {
                    return Anchor::widget([
                        'title' => $model->parent_id,
                        'link' => $model->viewUrl,
                        'text' => true
                    ]);
                }
            ],
            'category' => ['attribute' => 'category', 'format' => 'raw'],
            'menu' => ['attribute' => 'menu', 'format' => 'raw'],
            'title' => ['attribute' => 'title', 'format' => 'raw'],
            'photo' => ['attribute' => 'photo', 'format' => 'raw'],
            'content' => ['attribute' => 'content', 'format' => 'raw'],
        ];
    }

    public function detailColumns()
    {
        return [
            'parent_id:raw',
            'category:raw',
            'menu:raw',
            'title:raw',
            'photo:raw',
            'content:raw',
        ];
    }
}
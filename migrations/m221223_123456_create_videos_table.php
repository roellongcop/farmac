<?php

/**
 * Handles the creation of table `{{%videos}}`.
 */
class m221223_123456_create_videos_table extends \app\migrations\Migration
{
    public function tableName()
    {
        return '{{%videos}}';
    }

    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable($this->tableName(), $this->attributes([
            'title' => $this->string()->notNull(),
            'description' => 'LONGTEXT',
            'link' => $this->text(),
            'slug' => $this->string(),
        ]));
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable($this->tableName());
    }
}
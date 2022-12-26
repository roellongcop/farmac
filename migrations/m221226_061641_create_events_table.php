<?php

/**
 * Handles the creation of table `{{%events}}`.
 */
class m221226_061641_create_events_table extends \app\migrations\Migration
{
    public function tableName()
    {
        return '{{%events}}';
    }

    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable($this->tableName(), $this->attributes([
            'title' => $this->string()->notNull(),
            'description' => $this->text(),
            'start' => $this->datetime(),
            'end' => $this->datetime(),
            'slug' => $this->string(),
            'photo' => $this->string(),
            'color' => $this->string(),
            'url' => $this->string(),
            'token' => $this->string(),
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
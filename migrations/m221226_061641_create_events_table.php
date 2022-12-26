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
            'name' => $this->string()->notNull()->unique(),
            'description' => $this->text(),
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
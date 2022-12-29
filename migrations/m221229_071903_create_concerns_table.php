<?php

/**
 * Handles the creation of table `{{%concerns}}`.
 */
class m221229_071903_create_concerns_table extends \app\migrations\Migration
{
    public function tableName()
    {
        return '{{%concerns}}';
    }

    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable($this->tableName(), $this->attributes([
            'name' => $this->string()->notNull()->unique(),
            'description' => $this->text(),
            'rules' => $this->text(),
            'fallback_message' => $this->text(),
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
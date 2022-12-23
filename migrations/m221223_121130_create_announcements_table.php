<?php

/**
 * Handles the creation of table `{{%announcements}}`.
 */
class m221223_121130_create_announcements_table extends \app\migrations\Migration
{
    public function tableName()
    {
        return '{{%announcements}}';
    }

    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable($this->tableName(), $this->attributes([
            'title' => $this->string()->notNull(),
            'content' => 'MEDIUMTEXT',
            'photos' => $this->text(),
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
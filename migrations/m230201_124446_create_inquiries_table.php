<?php

/**
 * Handles the creation of table `{{%inquiries}}`.
 */
class m230201_124446_create_inquiries_table extends \app\migrations\Migration
{
    public function tableName()
    {
        return '{{%inquiries}}';
    }

    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable($this->tableName(), $this->attributes([
            'user_id' => $this->bigInteger(20)->notNull()->defaultValue(0),
            'concern_id' => $this->bigInteger(20)->notNull()->defaultValue(0),
            'name' => $this->string(),
            'status' => $this->tinyInteger(20)->notNull()->defaultValue(0),
        ]));

        $this->createIndexes($this->tableName(), [
            'user_id' => 'user_id',
            'concern_id' => 'concern_id',
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable($this->tableName());
    }
}
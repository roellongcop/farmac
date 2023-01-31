<?php

/**
 * Handles the creation of table `{{%helpdesks}}`.
 */
class m230107_024310_create_helpdesks_table extends \app\migrations\Migration
{
    public function tableName()
    {
        return '{{%helpdesks}}';
    }

    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable($this->tableName(), $this->attributes([
            'user_id' => $this->bigInteger(20)->notNull()->defaultValue(0),
            'concern_id' => $this->bigInteger(20)->notNull()->defaultValue(0),
            'question' => $this->string()->notNull(),
            'answer' => $this->string(),
            'expectation' => $this->text(),
            'status' => $this->tinyInteger(2)->notNull()->defaultValue(0),
            'counter' => $this->integer()->notNull()->defaultValue(0),
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
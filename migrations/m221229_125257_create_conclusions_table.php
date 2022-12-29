<?php

/**
 * Handles the creation of table `{{%conclusions}}`.
 */
class m221229_125257_create_conclusions_table extends \app\migrations\Migration
{
    public function tableName()
    {
        return '{{%conclusions}}';
    }

    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable($this->tableName(), $this->attributes([
            'concern_id' => $this->bigInteger(20)->notNull()->defaultValue(0),
            'conclusion' => 'LONGTEXT',
            'conditions' => $this->text(),
            'token' => $this->string(),
        ]));

        $this->createIndexes($this->tableName(), [
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
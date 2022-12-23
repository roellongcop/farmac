<?php

/**
 * Handles the creation of table `{{%articles}}`.
 */
class m221223_125655_create_articles_table extends \app\migrations\Migration
{
    public function tableName()
    {
        return '{{%articles}}';
    }

    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable($this->tableName(), $this->attributes([
            'parent_id' => $this->bigInteger(20)->notNull()->defaultValue(0),
            'category' => $this->string()->notNull(),
            'menu' => $this->string()->notNull(),
            'title' => $this->string()->notNull(),
            'photo' => $this->string(),
            'content' => $this->text(),
            'sort' => $this->smallInteger(6)->notNull()->defaultValue(0),
            'slug' => $this->string()->notNull(),
        ]));

        $this->createIndexes($this->tableName(), [
            'parent_id' => 'parent_id',
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
<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%moving_regions}}`.
 */
class m211021_152736_create_moving_regions_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%moving_regions}}', [
            'id' => $this->primaryKey(),
            'name' => $this->string(),
            'sort' => $this->integer(),
            'link' => $this->string(),
        ]);

    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%moving_regions}}');
    }
}

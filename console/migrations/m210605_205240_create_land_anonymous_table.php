<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%land_anonymous}}`.
 */
class m210605_205240_create_land_anonymous_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%land_anonymous}}', [
            'id' => $this->primaryKey(),
            'name' => $this->string(),
            'min_price' => $this->integer(),
            'count' => $this->integer(),
            'points_json' => 'JSON NOT NULL',
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%land_anonymous}}');
    }
}

<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%booking_stay_nearby_category}}`.
 */
class m210218_204838_create_booking_stay_nearby_category_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%booking_stay_nearby_category}}', [
            'id' => $this->primaryKey(),
            'name' => $this->string()->notNull(),
            'group' => $this->string()->notNull(),
            'sort' => $this->integer()->defaultValue(0)
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%booking_stay_nearby_category}}');
    }
}

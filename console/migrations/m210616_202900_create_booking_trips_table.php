<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%booking_trips}}`.
 */
class m210616_202900_create_booking_trips_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%booking_trips}}', [
            'id' => $this->primaryKey(),
            'user_id' => $this->integer()->notNull(),
            'legal_id' => $this->integer(),
            'name' => $this->string()->notNull()->unique(),
            'name_en' => $this->string(),
            'slug' => $this->string()->notNull()->unique(),
            'created_at' => $this->integer()->notNull(),
            'updated_at' => $this->integer(),
            'type_id' => $this->integer()->notNull(),
            'main_photo_id' => $this->integer(),
            'status' => $this->integer()->notNull(),
            'description' => $this->text(),
            'description_en' => $this->text(),
            'rating' => $this->decimal(5, 0)->defaultValue(0),
            'filling' => $this->integer(),
            'views' => $this->integer()->defaultValue(0),
            'public_at' => $this->integer(),
            'cost_base' => $this->integer(),
            'meta_json' => 'JSON NOT NULL',
            'cancellation' => $this->integer(),
            'prepay' => $this->integer(),
        ]);

        $this->createIndex('{{%idx-booking_trips-type_id}}', '{{%booking_trips}}', 'type_id');
        $this->addForeignKey(
            '{{%fk-booking_trips-type_id}}',
            '{{%booking_trips}}',
            'type_id',
            '{{%booking_trips_type}}',
            'id',
            'CASCADE',
            'RESTRICT'
            );

        $this->createIndex('{{%idx-booking_trips-legal_id}}', '{{%booking_trips}}', 'legal_id');
        $this->addForeignKey(
            '{{%fk-booking_trips-legal_id}}',
            '{{%booking_trips}}',
            'legal_id',
            '{{%admin_user_legals}}',
            'id',
            'CASCADE',
            'RESTRICT'
        );
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%booking_trips}}');
    }
}

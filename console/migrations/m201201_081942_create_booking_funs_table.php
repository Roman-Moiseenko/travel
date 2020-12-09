<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%booking_funs}}`.
 */
class m201201_081942_create_booking_funs_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_general_ci ENGINE=InnoDB';
        $this->createTable('{{%booking_funs}}', [
            'id' => $this->primaryKey(),
            'legal_id' => $this->integer(),
            'user_id' => $this->integer()->notNull(),
            'type_id' => $this->integer()->notNull(),
            'times_json' => 'JSON',
            'type_time' => $this->integer(),
            'name' => $this->string(),
            'name_en' => $this->string(),
            'slug' => $this->string(),
            'description' => $this->string(),
            'description_en' => $this->string(),
            'main_photo_id' => $this->integer(),
            'status' => $this->integer()->notNull(),
            'created_at' => $this->integer()->notNull(),
            //Финансы
            'quantity' => $this->integer()->defaultValue(1),
            'cancellation' => $this->integer(),
            'pay_bank' => $this->boolean(),
            'check_booking' => $this->integer(),
            //Рейтинг
            'rating' => $this->float(),
            'views' => $this->integer(),
            'public_at' => $this->integer(),
            //Цена
            'cost_adult' => $this->integer(),
            'cost_child' => $this->integer(),
            'cost_preference' => $this->integer(),
            //Адрес
            'adr_address' => $this->string(),
            'adr_latitude' => $this->string(),
            'adr_longitude' => $this->string(),
            //Параметры
            'params_limit_on' => $this->boolean(),
            'params_limit_min' => $this->integer(),
            'params_limit_max' => $this->integer(),
            'params_annotation' => $this->string(),
            'params_work_mode' => 'JSON NOT NULL', //Режим дня

        ], $tableOptions);

        $this->createIndex('{{%idx-booking_funs-type_id}}', '{{%booking_funs}}','type_id');
        $this->createIndex('{{%idx-booking_funs-legal_id}}', '{{%booking_funs}}','legal_id');
        $this->createIndex('{{%idx-booking_funs-user_id}}', '{{%booking_funs}}','user_id');

        $this->addForeignKey('{{%fk-booking_funs-type_id}}', '{{%booking_funs}}', 'type_id', '{{%booking_funs_type}}', 'id', 'CASCADE', 'RESTRICT');
        $this->addForeignKey('{{%fk-booking_funs-legal_id}}', '{{%booking_funs}}', 'legal_id', '{{%admin_user_legals}}', 'id', 'CASCADE', 'RESTRICT');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%booking_funs}}');
    }
}

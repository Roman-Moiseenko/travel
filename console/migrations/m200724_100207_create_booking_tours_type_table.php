<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%booking_tours_type}}`.
 */
class m200724_100207_create_booking_tours_type_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_general_ci ENGINE=InnoDB';
        $this->createTable('{{%booking_tours_type}}', [
            'id' => $this->primaryKey(),
            'name' => $this->string()->notNull(),
            'slug' => $this->string(),
            'sort' => $this->integer(),
        ], $tableOptions);

        $this->insert('{{%booking_tours_type}}',[
            'name' => 'Экскурсии по городу',
            'sort' => '1'
        ]);
        $this->insert('{{%booking_tours_type}}',[
            'name' => 'Выездные экскурсии',
            'sort' => '2'
        ]);
        $this->insert('{{%booking_tours_type}}',[
            'name' => 'Водные',
            'sort' => '3'
        ]);
        $this->insert('{{%booking_tours_type}}',[
            'name' => 'Экстримальные',
            'sort' => '4'
        ]);
        $this->insert('{{%booking_tours_type}}',[
            'name' => 'Гастрономические',
            'sort' => '5'
        ]);
        $this->insert('{{%booking_tours_type}}',[
            'name' => 'Ночные',
            'sort' => '6'
        ]);
        $this->insert('{{%booking_tours_type}}',[
            'name' => 'Замки/Форты',
            'sort' => '7'
        ]);
        $this->insert('{{%booking_tours_type}}',[
            'name' => 'Детские',
            'sort' => '8'
        ]);
        $this->insert('{{%booking_tours_type}}',[
            'name' => 'Куршская коса',
            'sort' => '9'
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%booking_tours_type}}');
    }
}

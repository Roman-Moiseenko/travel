<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%booking_cars_type}}`.
 */
class m201105_190657_create_booking_cars_type_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_general_ci ENGINE=InnoDB';
        $this->createTable('{{%booking_cars_type}}', [
            'id' => $this->primaryKey(),
            'name' => $this->string()->notNull(),
            'slug' => $this->string(),
            'sort' => $this->integer(),
        ], $tableOptions);
        $this->insert('{{%booking_cars_type}}',[
            'name' => 'Автомобиль',
            'sort' => '1'
        ]);
        $this->insert('{{%booking_cars_type}}',[
            'name' => 'Мотоцикл',
            'sort' => '2'
        ]);
        $this->insert('{{%booking_cars_type}}',[
            'name' => 'Квадрацикл',
            'sort' => '3'
        ]);
        $this->insert('{{%booking_cars_type}}',[
            'name' => 'Скутер',
            'sort' => '4'
        ]);
        $this->insert('{{%booking_cars_type}}',[
            'name' => 'Гироскутер',
            'sort' => '5'
        ]);
        $this->insert('{{%booking_cars_type}}',[
            'name' => 'Электросамокат',
            'sort' => '6'
        ]);
        $this->insert('{{%booking_cars_type}}',[
            'name' => 'Велосипед',
            'sort' => '7'
        ]);
        $this->insert('{{%booking_cars_type}}',[
            'name' => 'Гидромотоцикл',
            'sort' => '8'
        ]);
        $this->insert('{{%booking_cars_type}}',[
            'name' => 'Лодка',
            'sort' => '9'
        ]);
        $this->insert('{{%booking_cars_type}}',[
            'name' => 'Катер',
            'sort' => '10'
        ]);
        $this->insert('{{%booking_cars_type}}',[
            'name' => 'Яхта',
            'sort' => '11'
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%booking_cars_type}}');
    }
}

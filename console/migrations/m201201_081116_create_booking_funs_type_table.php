<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%booking_funs_type}}`.
 */
class m201201_081116_create_booking_funs_type_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_general_ci ENGINE=InnoDB';
        $this->createTable('{{%booking_funs_type}}', [
            'id' => $this->primaryKey(),
            'name' => $this->string()->notNull(),
            'slug' => $this->string(),
            'sort' => $this->integer(),
        ], $tableOptions);
        $this->insert('{{%booking_funs_type}}',[
            'name' => 'Выставки/Музеи',
            'sort' => '1'
        ]);
        $this->insert('{{%booking_funs_type}}',[
            'name' => 'Рестораны',
            'sort' => '2'
        ]);
        $this->insert('{{%booking_funs_type}}',[
            'name' => 'Прокат оборудования',
            'sort' => '3'
        ]);
        $this->insert('{{%booking_funs_type}}',[
            'name' => 'Сауны/Бани',
            'sort' => '4'
        ]);
        $this->insert('{{%booking_funs_type}}',[
            'name' => 'Аттракционы',
            'sort' => '5'
        ]);
        $this->insert('{{%booking_funs_type}}',[
            'name' => 'Тир/Стрельбище',
            'sort' => '6'
        ]);
        $this->insert('{{%booking_funs_type}}',[
            'name' => 'Конные прогулки',
            'sort' => '7'
        ]);
        $this->insert('{{%booking_funs_type}}',[
            'name' => 'Морские прогулки',
            'sort' => '8'
        ]);
        $this->insert('{{%booking_funs_type}}',[
            'name' => 'Прогулки по воздуху',
            'sort' => '9'
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%booking_funs_type}}');
    }
}

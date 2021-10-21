<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%moving_agents}}`.
 */
class m211021_174258_create_moving_agents_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%moving_agents}}', [
            'id' => $this->primaryKey(),
            'type' => $this->integer(),
            'sort' => $this->integer(),
            'region_id' => $this->integer(),

            'email' => $this->string(),
            'phone' => $this->string(),
            'description' => $this->text(),
            'photo' => $this->string(),

            'person_surname' => $this->string(),
            'person_firstname' => $this->string(),
            'person_secondname' => $this->string(),

            'address_address' => $this->string(),
            'address_latitude' => $this->string(),
            'address_longitude' => $this->string(),
        ]);

        $this->createIndex('{{%idx-moving_agents-region_id}}', '{{%moving_agents}}', 'region_id');
        $this->addForeignKey(
            '{{%fk-moving_agents-region_id}}',
            '{{%moving_agents}}',
            'region_id',
            '{{%moving_regions}}',
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
        $this->dropTable('{{%moving_agents}}');
    }
}

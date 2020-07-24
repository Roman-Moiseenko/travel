<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%user_personal}}`.
 */
class m200716_180515_create_user_personal_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_general_ci ENGINE=InnoDB';
        $this->createTable('{{%user_personal}}', [
            'id' => $this->primaryKey(),
            'user_id' => $this->integer()->notNull()->unique(),
            'surname' => $this->string(),
            'firstname' => $this->string(),
            'secondname' => $this->string(),
            'country' => $this->string(2),
            'index' => $this->string(),
            'town' => $this->string(),
            'address' => $this->string(),
            'dateborn' => $this->integer(),
            'photo' => $this->string(),
            'phone' => $this->string(15),
        ], $tableOptions);

        $this->createIndex('{{%idx-user_personal-user_id}}', '{{%user_personal}}', 'user_id');

        $this->addForeignKey('{{%fk-user_personal-user_id}}', '{{%user_personal}}', 'user_id', '{{%users}}', 'id', 'CASCADE');

    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%user_personal}}');
    }
}

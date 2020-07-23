<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%admin_user_personal}}`.
 */
class m200722_191110_create_admin_user_personal_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {

        $this->createTable('{{%admin_user_personal}}', [
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
            'position' => $this->string(),
        ]);

        $this->createIndex('{{%idx-admin_user_personal-user_id}}', '{{%admin_user_personal}}', 'user_id');

        $this->addForeignKey('{{%fk-admin_user_personal-user_id}}', '{{%admin_user_personal}}', 'user_id', '{{%admin_users}}', 'id', 'CASCADE');

    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%admin_user_personal}}');
    }
}

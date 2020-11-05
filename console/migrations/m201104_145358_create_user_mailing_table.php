<?php

use booking\entities\mailing\Mailing;
use booking\entities\user\User;
use booking\entities\user\UserMailing;
use yii\db\Migration;

/**
 * Handles the creation of table `{{%user_mailing}}`.
 */
class m201104_145358_create_user_mailing_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%user_mailing}}', [
            'id' => $this->primaryKey(),
            'user_id' => $this->integer()->notNull(),
            'new_tours' => $this->boolean()->notNull()->defaultValue(true),
            'new_cars' => $this->boolean()->notNull()->defaultValue(true),
            'new_stays' => $this->boolean()->notNull()->defaultValue(true),
            'new_funs' => $this->boolean()->notNull()->defaultValue(true),
            'new_promotions' => $this->boolean()->notNull()->defaultValue(true),
            'news_blog' => $this->boolean()->notNull()->defaultValue(true),
        ]);
        $this->createIndex('{{%idx-user_mailing-user_id}}', '{{%user_mailing}}', 'user_id');
        $this->addForeignKey('{{%fk-user_mailing-user_id}}', '{{%user_mailing}}', 'user_id', '{{%users}}', 'id', 'CASCADE');
        $users = User::find()->all();
        foreach ($users as $user) {
            $this->insert('{{%user_mailing}}', [
                'user_id' => $user->id
            ]);
        }

    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%user_mailing}}');
    }
}

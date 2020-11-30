<?php

use booking\entities\admin\Preferences;
use booking\entities\admin\User;
use yii\db\Migration;

/**
 * Handles the creation of table `{{%admin_user_preferences}}`.
 */
class m201130_124255_create_admin_user_preferences_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_general_ci ENGINE=InnoDB';
        $this->createTable('{{%admin_user_preferences}}', [
            'id' => $this->primaryKey(),
            'user_id' => $this->integer()->notNull()->unique(),
            'params_json' => $this->text(),

        ], $tableOptions);

        $this->createIndex('{{%idx-admin_user_preferences-user_id}}', '{{%admin_user_preferences}}', 'user_id');
        $this->addForeignKey('{{%fk-admin_user_preferences-user_id}}', '{{%admin_user_preferences}}', 'user_id', '{{%admin_users}}', 'id', 'CASCADE');
        $users = User::find()->all();
        foreach ($users as $user) {
            //$user->preferences = Preferences::create();
            $this->insert('{{%admin_user_preferences}}', [
                'user_id' => $user->id,
                'params_json' => '{}',
            ]);

        }
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%admin_user_preferences}}');
    }
}

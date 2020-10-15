<?php

use yii\db\Migration;

/**
 * Class m201015_105401_add_personal_agreement_field
 */
class m201015_105401_add_personal_agreement_field extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('{{%user_personal}}', 'agreement', $this->boolean()->defaultValue(false));
        $this->update('{{%user_personal}}', ['agreement' => false]);
        $this->addColumn('{{%admin_user_personal}}', 'agreement', $this->boolean()->defaultValue(false));
        $this->update('{{%admin_user_personal}}', ['agreement' => false]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropColumn('{{%user_personal}}', 'agreement');
        $this->dropColumn('{{%admin_user_personal}}', 'agreement');
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m201015_105401_add_personal_agreement_field cannot be reverted.\n";

        return false;
    }
    */
}

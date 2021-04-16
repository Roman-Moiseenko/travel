<?php

use yii\db\Migration;

/**
 * Class m210415_133222_add_shops_ad_contact_assign_primary
 */
class m210415_133222_add_shops_ad_contact_assign_primary extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->alterColumn('{{%shops_ad_info_address}}', 'address', $this->string()->notNull()->defaultValue(''));
        $this->addPrimaryKey('{{%pk-shops_ad_info_address}}', '{{%shops_ad_info_address}}', ['shop_id', 'address']);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m210415_133222_add_shops_ad_contact_assign_primary cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m210415_133222_add_shops_ad_contact_assign_primary cannot be reverted.\n";

        return false;
    }
    */
}

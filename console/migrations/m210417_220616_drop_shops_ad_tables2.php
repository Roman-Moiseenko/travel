<?php

use yii\db\Migration;

/**
 * Class m210417_220616_drop_shops_ad_tables2
 */
class m210417_220616_drop_shops_ad_tables2 extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->dropForeignKey('{{%fk-shops_ad_product-main_photo_id}}', '{{%shops_ad_product}}');
        $this->dropForeignKey('{{%fk-shops_ad-main_photo_id}}', '{{%shops_ad}}');
        $this->dropTable('{{%shops_ad_product_photos}}');
        $this->dropTable('{{%shops_ad_product_material_assign}}');
        $this->dropTable('{{%shops_ad_info_address}}');
        $this->dropTable('{{%shops_ad_contact_assign}}');
        $this->dropTable('{{%shops_ad_product}}');
        $this->dropTable('{{%shops_ad_photos}}');
        $this->dropTable('{{%shops_ad}}');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m210417_220616_drop_shops_ad_tables2 cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m210417_220616_drop_shops_ad_tables2 cannot be reverted.\n";

        return false;
    }
    */
}

<?php

use booking\entities\office\PriceList;
use booking\entities\shops\Shop;
use yii\db\Migration;

/**
 * Class m210530_081045_add_office_price_list_row
 */
class m210530_081045_add_office_price_list_row extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->insert('{{%office_price_list}}', [
            'key' => Shop::class,
            'name' => 'Оплата размещения товара в Витрине',
            'amount' => 1.00,
            'period' => PriceList::PERIOD_MONTH,
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m210530_081045_add_office_price_list_row cannot be reverted.\n";
        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m210530_081045_add_office_price_list_row cannot be reverted.\n";

        return false;
    }
    */
}

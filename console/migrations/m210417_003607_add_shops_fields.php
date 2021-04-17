<?php

use yii\db\Migration;

/**
 * Class m210417_003607_add_shops_fields
 */
class m210417_003607_add_shops_fields extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('{{%shops}}','meta_json', 'JSON NOT NULL');
        $this->addColumn('{{%shops}}','main_photo_id', $this->integer());
        $this->addColumn('{{%shops}}','slug', $this->string()->unique());
        $this->addColumn('{{%shops}}','views', $this->integer()->defaultValue(0));
        $this->addColumn('{{%shops}}','work_mode_json', 'JSON NOT NULL');
        $this->addColumn('{{%shops}}','active_products', $this->integer());
        $this->addColumn('{{%shops}}','free_products', $this->integer());
        $this->addColumn('{{%shops}}','ad', $this->boolean()->defaultValue(false));

    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m210417_003607_add_shops_fields cannot be reverted.\n";

        return false;
    }

}

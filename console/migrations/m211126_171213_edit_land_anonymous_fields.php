<?php

use yii\db\Migration;

/**
 * Class m211126_171213_edit_land_anonymous_fields
 */
class m211126_171213_edit_land_anonymous_fields extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->dropColumn('{{%land_anonymous}}', 'count');
        $this->renameColumn('{{%land_anonymous}}', 'min_price', 'cost');
        $this->addColumn('{{%land_anonymous}}', 'slug', $this->string());
        $this->addColumn('{{%land_anonymous}}', 'title', $this->string());
        $this->addColumn('{{%land_anonymous}}', 'description', $this->text());
        $this->addColumn('{{%land_anonymous}}', 'content', 'MEDIUMTEXT');
        $this->addColumn('{{%land_anonymous}}', 'photo', $this->string());


        $this->addColumn('{{%land_anonymous}}', 'meta_json', 'JSON NOT NULL');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m211126_171213_edit_land_anonymous_fields cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m211126_171213_edit_land_anonymous_fields cannot be reverted.\n";

        return false;
    }
    */
}

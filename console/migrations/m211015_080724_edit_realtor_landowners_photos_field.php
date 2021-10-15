<?php

use yii\db\Migration;

/**
 * Class m211015_080724_edit_realtor_landowners_photos_field
 */
class m211015_080724_edit_realtor_landowners_photos_field extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->renameColumn('{{%realtor_landowners_photos}}', 'landowners_id', 'landowner_id');

        $this->dropForeignKey('{{%fk-realtor_landowners_photos-landowners_id}}', '{{%realtor_landowners_photos}}');
        $this->dropIndex('{{%idx-realtor_landowners_photos-landowners_id}}', '{{%realtor_landowners_photos}}');

        $this->createIndex('{{%idx-realtor_landowners_photos-landowner_id}}', '{{%realtor_landowners_photos}}', 'landowner_id');
        $this->addForeignKey(
            '{{%fk-realtor_landowners_photos-landowner_id}}',
            '{{%realtor_landowners_photos}}',
            'landowner_id',
            '{{%realtor_landowners}}',
            'id',
            'CASCADE',
            'RESTRICT'
        );
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m211015_080724_edit_realtor_landowners_photos_field cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m211015_080724_edit_realtor_landowners_photos_field cannot be reverted.\n";

        return false;
    }
    */
}

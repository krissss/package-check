<?php

use console\migrations\Migration;

/**
 * Class m180713_061545_init
 */
class m180713_061545_init extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('packagist', [
            'id' => $this->primaryKey(),
            'vendor' => $this->string(50)->notNull(),
            'package' => $this->string(50)->notNull(),
            'latest_version' => $this->string(20)->notNull(),
            'version_updated_at' => $this->integer()->notNull(),
            'type' => $this->string(),
            'repository' => $this->string(),
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m180713_061545_init cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m180713_061545_init cannot be reverted.\n";

        return false;
    }
    */
}

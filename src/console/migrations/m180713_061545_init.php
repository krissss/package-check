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
            'vendor' => $this->string(50)->notNull()->comment('供应商'),
            'package' => $this->string(50)->notNull()->comment('包名'),
            'latest_version' => $this->string(20)->comment('最新版本'),
            'version_updated_at' => $this->integer()->comment('版本更新时间'),
            'type' => $this->string()->comment('包类型'),
            'homepage' => $this->string()->comment('主页'),
            'repository' => $this->string()->comment('代码地址'),
            'latest_version_package' => $this->text()->comment('最新版本信息'),
            'package_info' => $this->text()->comment('包信息'),
            'updated_at' => $this->integer()->notNull()->defaultValue(0)->comment('更新时间'),
        ], $this->setTableComment('php 包管理'));

        $this->createTable('packagist_need_send', [
            'id' => $this->primaryKey(),
            'packagist_id' => $this->integer()->notNull()->comment('Packagist ID'),
        ], $this->setTableComment('需要发送的包'));
        $this->addForeignKeyCustom('packagist_need_send', 'packagist_id', 'packagist');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('packagist_need_send');
        $this->dropTable('packagist');
    }
}

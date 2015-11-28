<?php

use yii\db\Schema;
use yii\db\Migration;

class m151128_091557_text extends Migration
{
    public function up()
    {
    	$this->execute("DROP TABLE IF EXISTS text");
    	$this->createTable('text', [
    			'id' => Schema::TYPE_PK,
    			'phone' => Schema::TYPE_INTEGER . ' NOT NULL',
    			'text' => Schema::TYPE_INTEGER . ' NOT NULL',
    			'type' => Schema::TYPE_INTEGER . ' NOT NULL',
    			'created_at' =>Schema::TYPE_BIGINT . ' NOT NULL',
    	],'CHARACTER SET utf8 COLLATE utf8_general_ci ENGINE=InnoDB');
    }

    public function down()
    {
        echo "m151128_091557_text cannot be reverted.\n";
        $this->execute("DROP TABLE IF EXISTS text");
        return true;
    }
    
    /*
    // Use safeUp/safeDown to run migration code within a transaction
    public function safeUp()
    {
    }
    
    public function safeDown()
    {
    }
    */
}

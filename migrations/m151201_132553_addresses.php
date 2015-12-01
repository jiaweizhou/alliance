<?php

use yii\db\Schema;
use yii\db\Migration;

class m151201_132553_addresses extends Migration
{
    public function up()
    {
    	$this->execute("DROP TABLE IF EXISTS addresses");
    	$this->createTable('addresses', [
    			'id' => Schema::TYPE_PK,
    			'userid' => Schema::TYPE_INTEGER . ' NOT NULL',
    			'address' => Schema::TYPE_STRING . ' NOT NULL',
    			'name' => Schema::TYPE_STRING . ' NOT NULL',
    			'aphone' => Schema::TYPE_STRING . ' NOT NULL',
    			'postcode' => Schema::TYPE_STRING . ' NOT NULL DEFAULT ""',
    			'isdefault' => Schema::TYPE_INTEGER . 'NOT NULL DEFAULT 0',
    			'created_at' =>Schema::TYPE_BIGINT . ' NOT NULL',
    			],'CHARACTER SET utf8 COLLATE utf8_general_ci ENGINE=InnoDB');
    	$this->addForeignKey('addresuserid', 'addresses', 'userid', 'users', 'id','CASCADE','CASCADE');
    	 
    }

    public function down()
    {
        echo "m151201_132553_addresses cannot be reverted.\n";
        $this->execute("DROP TABLE IF EXISTS addresses");
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

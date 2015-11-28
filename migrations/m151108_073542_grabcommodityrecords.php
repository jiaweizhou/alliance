<?php

use yii\db\Schema;
use yii\db\Migration;

class m151108_073542_grabcommodityrecords extends Migration
{
    public function up()
    {
    	$this->execute("DROP TABLE IF EXISTS grabcommodityrecords");
    	$this->createTable('grabcommodityrecords', [
    			'id' => Schema::TYPE_PK,
    			'userid'=>Schema::TYPE_INTEGER . ' NOT NULL',
    			'grabcommodityid'=>Schema::TYPE_INTEGER . ' NOT NULL',
    			 
    			'count'=>Schema::TYPE_INTEGER . ' NOT NULL',
    			 
    			'numbers' =>Schema::TYPE_STRING .'(8000) '. ' DEFAULT ""',
    			 
    			'type' => Schema::TYPE_INTEGER . ' NOT NULL',
    			 
    			'created_at' => Schema::TYPE_BIGINT . ' NOT NULL',
    			'isgotback' =>Schema::TYPE_INTEGER . ' NOT NULL DEFAULT 0',
    	],'CHARACTER SET utf8 COLLATE utf8_general_ci ENGINE=InnoDB');
    	 
    	$this->addForeignKey('crecorduidKey', 'grabcommodityrecords', 'userid', 'users', 'id','CASCADE','CASCADE');
    	$this->addForeignKey('crecordgidKey', 'grabcommodityrecords', 'grabcommodityid', 'grabcommodities', 'id','CASCADE','CASCADE');
    	
    }

    public function down()
    {
        echo "m151108_073542_grabcommodityrecords cannot be reverted.\n";
        $this->execute("DROP TABLE IF EXISTS grabcommodityrecords");
        return false;
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

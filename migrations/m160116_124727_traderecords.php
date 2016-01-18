<?php

use yii\db\Schema;
use yii\db\Migration;

class m160116_124727_traderecords extends Migration
{
    public function up()
    {
    	$this->execute("DROP TABLE IF EXISTS traderecords");
    	$this->createTable('traderecords', [
    			'id' => Schema::TYPE_PK,
    			'userid' => Schema::TYPE_INTEGER . ' NOT NULL',
    			
    			'count' => Schema::TYPE_INTEGER . ' NOT NULL DEFAULT 0',
    			
    			'type' => Schema::TYPE_INTEGER . ' NOT NULL DEFAULT 0',
    			
    			'description'=>Schema::TYPE_STRING,
    			
    			'cardid' => Schema::TYPE_INTEGER . ' NOT NULL DEFAULT 0',
    			'created_at' => Schema::TYPE_BIGINT . ' NOT NULL',
    			
    			'ishandled' => Schema::TYPE_INTEGER . ' NOT NULL DEFAULT 0',
    			'handled_at' => Schema::TYPE_BIGINT . ' NOT NULL DEFAULT 0',
    			
    	],"CHARACTER SET utf8 COLLATE utf8_general_ci ENGINE=InnoDB");
    	//$this->createIndex('userid', 'tbmessages', 'userid');
    	$this->addForeignKey('recorduserid', 'traderecords', 'userid', 'users', 'id','CASCADE','CASCADE');
    	 
    }

    public function down()
    {
        echo "m160116_124727_traderecords cannot be reverted.\n";
        $this->execute("DROP TABLE IF EXISTS traderecords");
        
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

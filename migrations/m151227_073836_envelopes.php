<?php

use yii\db\Schema;
use yii\db\Migration;

class m151227_073836_envelopes extends Migration
{
    public function up()
    {
    	$this->execute("DROP TABLE IF EXISTS envelopes");
    	$this->createTable('envelopes', [
    			'id' => Schema::TYPE_PK,
    			'userid' => Schema::TYPE_INTEGER . ' NOT NULL',
    			'count' => Schema::TYPE_INTEGER . ' NOT NULL DEFAULT 0',
    			'type' => Schema::TYPE_INTEGER . ' NOT NULL DEFAULT 0',
    	
    			'created_at' => Schema::TYPE_BIGINT . ' NOT NULL',
    	],"CHARACTER SET utf8 COLLATE utf8_general_ci ENGINE=InnoDB");
    	//$this->createIndex('userid', 'tbmessages', 'userid');
    	$this->addForeignKey('envelopessuserid', 'envelopes', 'userid', 'users', 'id','CASCADE','CASCADE');
    	 
    }

    public function down()
    {
        echo "m151227_073836_envelopes cannot be reverted.\n";
        $this->execute("DROP TABLE IF EXISTS envelopes");
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

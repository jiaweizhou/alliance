<?php

use yii\db\Schema;
use yii\db\Migration;

class m151214_064832_realauth extends Migration
{
    public function up()
    {
    	$this->execute("DROP TABLE IF EXISTS realauth");
    	$this->createTable('realauth', [
    			'id' => Schema::TYPE_PK,
    			'userid' => Schema::TYPE_INTEGER . ' NOT NULL',
    			'realname' => Schema::TYPE_STRING . ' NOT NULL',
    			'idcard' => Schema::TYPE_STRING . ' NOT NULL',
    			'picture' => Schema::TYPE_STRING . ' NOT NULL',
    			'created_at' =>Schema::TYPE_BIGINT . ' NOT NULL',
    	],'CHARACTER SET utf8 COLLATE utf8_general_ci ENGINE=InnoDB');
    	$this->addForeignKey('realauthuserid', 'realauth', 'userid', 'users', 'id','CASCADE','CASCADE');
    	 
    }

    public function down()
    {
        echo "m151214_064832_realauth cannot be reverted.\n";
        $this->execute("DROP TABLE IF EXISTS realauth");
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

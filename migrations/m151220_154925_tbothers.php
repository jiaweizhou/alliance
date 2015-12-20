<?php

use yii\db\Schema;
use yii\db\Migration;

class m151220_154925_tbothers extends Migration
{
    public function up()
    {
    	$this->execute("DROP TABLE IF EXISTS tbothers");
    	$this->createTable('tbothers', [
    			'id' => Schema::TYPE_PK,
    			'userid' => Schema::TYPE_INTEGER . ' NOT NULL',
    			'title' => Schema::TYPE_STRING . ' NOT NULL',
    			'content' => Schema::TYPE_STRING . ' NOT NULL',
    			 
    			'pictures'=>Schema::TYPE_STRING .'(2550) '. ' NOT NULL DEFAULT ""',
    			'created_at' => Schema::TYPE_BIGINT . ' NOT NULL',
    	],"CHARACTER SET utf8 COLLATE utf8_general_ci ENGINE=InnoDB");
    	//$this->createIndex('userid', 'tbmessages', 'userid');
    	$this->addForeignKey('tbothersuserid', 'tbothers', 'userid', 'users', 'id','CASCADE','CASCADE');
    	
    }

    public function down()
    {
        echo "m151220_154925_tbothers cannot be reverted.\n";
        $this->execute("DROP TABLE IF EXISTS tbothers");
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

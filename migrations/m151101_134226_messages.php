<?php

use yii\db\Schema;
use yii\db\Migration;

class m151101_134226_messages extends Migration
{
    public function up()
    {
    	$this->execute("DROP TABLE IF EXISTS messages");
    	$this->createTable('messages', [
    			'id' => Schema::TYPE_PK,
    			'userid' => Schema::TYPE_INTEGER . ' NOT NULL',
    			'content' => Schema::TYPE_STRING . ' NOT NULL',
    			'pictures' => Schema::TYPE_STRING.'(2550) ' . ' DEFAULT ""',
    			'created_at' => Schema::TYPE_BIGINT . ' NOT NULL',
    	],"CHARACTER SET utf8 COLLATE utf8_general_ci ENGINE=InnoDB");
    	$this->createIndex('userid', 'messages', 'userid');
    	$this->addForeignKey('msguserid', 'messages', 'userid', 'users', 'id','CASCADE','CASCADE');
    }

    public function down()
    {
        echo "m151101_134226_messages cannot be reverted.\n";
        $this->dropTable('messages');
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

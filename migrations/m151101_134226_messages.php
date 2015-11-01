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
    			'created_at' => Schema::TYPE_BIGINT . ' NOT NULL',
    	],"CHARACTER SET utf8 COLLATE utf8_general_ci ENGINE=InnoDB");
    	$this->createIndex('userid', 'messages', 'userid');
    	$this->addForeignKey('msguserid', 'messages', 'userid', 'users', 'id','CASCADE','CASCADE');
    	$this->createTable('messagetopictures', [
    			'id' => Schema::TYPE_PK,
    			'messageid' => Schema::TYPE_INTEGER . ' NOT NULL',
    			'picture' => Schema::TYPE_STRING . ' NOT NULL',
    	],'CHARACTER SET utf8 COLLATE utf8_general_ci ENGINE=InnoDB');
    	$this->addForeignKey('mpKey', 'messagetopictures', 'messageid', 'messages', 'id','CASCADE','CASCADE');
    	//$this->addForeignKey('apppid', 'msgtoapp', 'appid', 'app', 'id','CASCADE','CASCADE');
    	$this->createIndex('msgid', 'messagetopictures', 'messageid');
    }

    public function down()
    {
        echo "m151101_134226_messages cannot be reverted.\n";
        $this->dropTable('messagetopictures');
        $this->dropTable('messages');
        $this->dropForeignKey('mpKey', 'messagetopictures');
        $this->dropForeignKey('msguserid', 'messages');
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

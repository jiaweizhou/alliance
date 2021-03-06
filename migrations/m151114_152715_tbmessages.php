<?php

use yii\db\Schema;
use yii\db\Migration;

class m151114_152715_tbmessages extends Migration
{
    public function up()
    {
    	$this->execute("DROP TABLE IF EXISTS tbmessages");
    	$this->createTable('tbmessages', [
    			'id' => Schema::TYPE_PK,
    			'userid' => Schema::TYPE_INTEGER . ' NOT NULL',
    			'title' => Schema::TYPE_STRING . ' NOT NULL',
    			'content' => Schema::TYPE_STRING . ' NOT NULL',
    			
    			'pictures'=>Schema::TYPE_STRING .'(2550) '. ' NOT NULL DEFAULT ""',
    			
    			'likecount'=>Schema::TYPE_INTEGER . ' DEFAULT 0',
    			'replycount'=>Schema::TYPE_INTEGER . ' DEFAULT 0',
    			
    			'created_at' => Schema::TYPE_BIGINT . ' NOT NULL',
    	],"CHARACTER SET utf8 COLLATE utf8_general_ci ENGINE=InnoDB");
    	$this->createIndex('userid', 'tbmessages', 'userid');
    	$this->addForeignKey('tbmsguserid', 'tbmessages', 'userid', 'users', 'id','CASCADE','CASCADE');
    	//$this->addForeignKey('mpKey', 'messagetopictures', 'messageid', 'messages', 'id','CASCADE','CASCADE');
    	//$this->addForeignKey('apppid', 'msgtoapp', 'appid', 'app', 'id','CASCADE','CASCADE');
    }

    public function down()
    {
        echo "m151114_152715_talkbar cannot be reverted.\n";
        $this->execute("DROP TABLE IF EXISTS tbmessages");
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

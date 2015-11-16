<?php

use yii\db\Schema;
use yii\db\Migration;

class m151116_114755_tbreplys extends Migration
{
    public function up()
    {
    	$this->execute("DROP TABLE IF EXISTS tbreplys");
    	$this->createTable('tbreplys', [
    			'id' => Schema::TYPE_PK,
    			'tbmessageid' => Schema::TYPE_INTEGER . ' NOT NULL',
    			'content' => Schema::TYPE_STRING . ' NOT NULL',
    			'fromid' => Schema::TYPE_INTEGER . ' NOT NULL',
    			'toid' => Schema::TYPE_INTEGER . ' NOT NULL',
    			'isread' => Schema::TYPE_BOOLEAN . ' NOT NULL DEFAULT FALSE',
    			'created_at' => Schema::TYPE_BIGINT . ' NOT NULL DEFAULT 0',
    			],"CHARACTER SET utf8 COLLATE utf8_general_ci ENGINE=InnoDB");
    	$this->createIndex('tbreply-msgid', 'tbreplys', 'tbmessageid');
    	$this->addForeignKey('tbmsgidKey', 'tbreplys', 'tbmessageid', 'tbmessages', 'id','CASCADE','CASCADE');
    	$this->addForeignKey('tbfromidKey', 'tbreplys', 'fromid', 'users', 'id','CASCADE','CASCADE');
    }

    public function down()
    {
        echo "m151116_114755_tbmessagereplys cannot be reverted.\n";
        $this->execute("DROP TABLE IF EXISTS tbreplys");
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

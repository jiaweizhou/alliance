<?php

use yii\db\Schema;
use yii\db\Migration;

class m151101_135649_replys extends Migration
{
    public function up()
    {
    	$this->execute("DROP TABLE IF EXISTS replys");
    	$this->createTable('replys', [
    			'id' => Schema::TYPE_PK,
    			'messageid' => Schema::TYPE_INTEGER . ' NOT NULL',
    			'content' => Schema::TYPE_STRING . ' NOT NULL',
    			'fromid' => Schema::TYPE_INTEGER . ' NOT NULL',
    			'toid' => Schema::TYPE_INTEGER . ' NOT NULL',
    			'isread' => Schema::TYPE_BOOLEAN . ' NOT NULL DEFAULT FALSE',
    			'created_at' => Schema::TYPE_BIGINT . ' NOT NULL DEFAULT 0',
    	],"CHARACTER SET utf8 COLLATE utf8_general_ci ENGINE=InnoDB");
    	$this->createIndex('reply-msgid', 'replys', 'messageid');
    	$this->addForeignKey('msgidKey', 'replys', 'messageid', 'messages', 'id','CASCADE','CASCADE');
    	$this->addForeignKey('fromidKey', 'replys', 'fromid', 'users', 'id','CASCADE','CASCADE');
    }

    public function down()
    {
        echo "m151101_135649_replys cannot be reverted.\n";
        $this->dropForeignKey('msgidKey', 'replys');
        $this->dropForeignKey('fromidKey', 'replys');
        //$this->dropForeignKey('toid', 'replys');
        $this->dropTable('reply');
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

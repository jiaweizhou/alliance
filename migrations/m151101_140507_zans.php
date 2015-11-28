<?php

use yii\db\Schema;
use yii\db\Migration;

class m151101_140507_zans extends Migration
{
	public function safeUp()
    {
    	$this->execute("DROP TABLE IF EXISTS zans");
    	$this->createTable('zans', [
    			'id' => Schema::TYPE_PK,
    			'userid' => Schema::TYPE_INTEGER . ' NOT NULL',
    			'messageid' => Schema::TYPE_INTEGER . ' NOT NULL',
    			'created_at' => Schema::TYPE_BIGINT . ' NOT NULL DEFAULT 0',
    			 
    	],'CHARACTER SET utf8 COLLATE utf8_general_ci ENGINE=InnoDB');
    	$this->addForeignKey('msgZan', 'zans', 'msgid', 'messages', 'id','CASCADE','CASCADE');
    	$this->addForeignKey('myZan', 'zans', 'userid', 'users', 'id','CASCADE','CASCADE');
    	 
    }

    public function safeDown()
    {
        $this->dropForeignKey('myZan', 'zans');
        $this->dropForeignKey('msgZan', 'zans');
        $this->dropTable('zans');
    }
}

<?php

use yii\db\Schema;
use yii\db\Migration;

class m151116_134819_tblikes extends Migration
{
    public function up()
    {
    	$this->execute("DROP TABLE IF EXISTS tblikes");
    	$this->createTable('tblikes', [
    			'id' => Schema::TYPE_PK,
    			'userid' => Schema::TYPE_INTEGER . ' NOT NULL',
    			'tbmessageid' => Schema::TYPE_INTEGER . ' NOT NULL',
    			'created_at' =>Schema::TYPE_BIGINT . ' NOT NULL',
    			],'CHARACTER SET utf8 COLLATE utf8_general_ci ENGINE=InnoDB');
    	$this->addForeignKey('tbmsglike', 'tblikes', 'tbmessageid', 'tbmessages', 'id','CASCADE','CASCADE');
    	$this->addForeignKey('tbmylike', 'tblikes', 'userid', 'users', 'id','CASCADE','CASCADE');
    }

    public function down()
    {
        echo "m151116_134819_tblikes cannot be reverted.\n";
        $this->execute("DROP TABLE IF EXISTS tblikes");
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

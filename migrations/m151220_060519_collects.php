<?php

use yii\db\Schema;
use yii\db\Migration;

class m151220_060519_collects extends Migration
{
    public function up()
    {
    	$this->execute("DROP TABLE IF EXISTS collects");
    	$this->createTable('collects', [
    			'id' => Schema::TYPE_PK,
    			'userid' => Schema::TYPE_INTEGER . ' NOT NULL',
    			'messageid' => Schema::TYPE_INTEGER . ' NOT NULL',
    			'created_at' =>Schema::TYPE_BIGINT . ' NOT NULL',
    	],'CHARACTER SET utf8 COLLATE utf8_general_ci ENGINE=InnoDB');
    	$this->addForeignKey('collectsmsgid', 'collects', 'messageid', 'messages', 'id','CASCADE','CASCADE');
    	$this->addForeignKey('collectsuserid', 'collects', 'userid', 'users', 'id','CASCADE','CASCADE');
    	 
    }

    public function down()
    {
        echo "m151220_060519_collects cannot be reverted.\n";
        $this->execute("DROP TABLE IF EXISTS collects");
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

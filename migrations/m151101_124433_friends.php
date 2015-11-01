<?php

use yii\db\Schema;
use yii\db\Migration;

class m151101_124433_friends extends Migration
{
    public function up()
    {
    	$this->execute("DROP TABLE IF EXISTS friends");
    	$this->createTable('friends', [
    			'id' => Schema::TYPE_PK,
    			'myid'=> Schema::TYPE_INTEGER . ' NOT NULL',
    			'friendid' => Schema::TYPE_INTEGER . ' NOT NULL',
    	],'CHARACTER SET utf8 COLLATE utf8_general_ci ENGINE=InnoDB');
    	//$this->createIndex( 'userid','usertocards', 'userid');
    	$this->addForeignKey('myidKey', 'friends', 'myid', 'users', 'id','CASCADE','CASCADE');
    	$this->addForeignKey('frindidKey', 'friends', 'friendid', 'users', 'id','CASCADE','CASCADE');
    	 
    }

    public function down()
    {
        echo "m151101_124433_friends cannot be reverted.\n";
        $this->dropTable('friends');
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

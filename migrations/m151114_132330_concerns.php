<?php

use yii\db\Schema;
use yii\db\Migration;

class m151114_132330_concerns extends Migration
{
    public function up()
    {
    	$this->execute("DROP TABLE IF EXISTS concerns");
    	$this->createTable('concerns', [
    			'id' => Schema::TYPE_PK,
    			'myid'=> Schema::TYPE_INTEGER . ' NOT NULL',
    			'concernid' => Schema::TYPE_INTEGER . ' NOT NULL',
    			'created_at' =>Schema::TYPE_BIGINT . ' NOT NULL DEFAULT 0',
    	],'CHARACTER SET utf8 COLLATE utf8_general_ci ENGINE=InnoDB');
    	//$this->createIndex( 'userid','usertocards', 'userid');
    	$this->addForeignKey('concernsmyidKey', 'concerns', 'myid', 'users', 'id','CASCADE','CASCADE');
    	$this->addForeignKey('concernidKey', 'concerns', 'concernid', 'users', 'id','CASCADE','CASCADE');
    	
    }

    public function down()
    {
        echo "m151114_132330_concerns cannot be reverted.\n";
        $this->dropTable('concerns');
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

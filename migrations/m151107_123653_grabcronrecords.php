<?php

use yii\db\Schema;
use yii\db\Migration;

class m151107_123653_grabcronrecords extends Migration
{
    public function up()
    {
    	$this->execute("DROP TABLE IF EXISTS grabcornrecords");
    	$this->createTable('grabcornrecords', [
    			'id' => Schema::TYPE_PK,
    			'userid'=>Schema::TYPE_INTEGER . ' NOT NULL',
    			'grabcornid'=>Schema::TYPE_INTEGER . ' NOT NULL',
    			
    			'count'=>Schema::TYPE_INTEGER . ' NOT NULL',
    			
    			'numbers' =>Schema::TYPE_STRING . ' DEFAULT ""',
    			
    			'type' => Schema::TYPE_INTEGER . ' NOT NULL',
    			
    			'created_at' => Schema::TYPE_BIGINT . ' NOT NULL',

    	],'CHARACTER SET utf8 COLLATE utf8_general_ci ENGINE=InnoDB');
    	
    	$this->addForeignKey('recorduidKey', 'grabcornrecords', 'userid', 'users', 'id','CASCADE','CASCADE');
    	$this->addForeignKey('recordgidKey', 'grabcornrecords', 'grabcornid', 'grabcorns', 'id','CASCADE','CASCADE');
    	 
    }

    public function down()
    {
        echo "m151107_123653_grabcornrecords cannot be reverted.\n";
        $this->execute("DROP TABLE IF EXISTS grabcornrecords");
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

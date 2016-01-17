<?php

use yii\db\Schema;
use yii\db\Migration;

class m151027_135904_usertocards extends Migration
{
    public function up()
    {
    	$this->execute("DROP TABLE IF EXISTS usertocards");
    	$this->createTable('usertocards', [
    			'id' => Schema::TYPE_PK,
    			'userid'=> Schema::TYPE_INTEGER . ' NOT NULL',
    			'cardnumber' => Schema::TYPE_STRING . ' NOT NULL',
    			'name'=> Schema::TYPE_STRING . ' NOT NULL',
    			'idcard' => Schema::TYPE_STRING . ' NOT NULL',
    			'lphone' => Schema::TYPE_STRING . ' NOT NULL',
    			
    			'bankname' => Schema::TYPE_STRING . ' NOT NULL',
    			'bankcode' => Schema::TYPE_STRING . ' NOT NULL',
    			'location' => Schema::TYPE_STRING . ' NOT NULL'
    			],'CHARACTER SET utf8 COLLATE utf8_general_ci ENGINE=InnoDB');
    	$this->createIndex( 'userid','usertocards', 'userid');
    	$this->addForeignKey('useridKey', 'usertocards', 'userid', 'users', 'id','CASCADE','CASCADE');
    	//$this->createIndex('phone', 'user', 'phone',true);
    }

    public function down()
    {
        echo "m151027_135904_usertocards cannot be reverted.\n";
        $this->dropTable('usertocards');
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

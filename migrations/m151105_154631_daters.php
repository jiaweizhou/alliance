<?php

use yii\db\Schema;
use yii\db\Migration;

class m151105_154631_daters extends Migration
{
    public function up()
    {
    	$this->execute("DROP TABLE IF EXISTS daters");
    	$this->createTable('daters', [
    			'id' => Schema::TYPE_PK,
    			'userid' => Schema::TYPE_INTEGER ,
    			'picture' =>Schema::TYPE_STRING . ' NOT NULL',
    			'sex' => Schema::TYPE_INTEGER,
    			'age'=>Schema::TYPE_INTEGER,
    			'hobbyid' => Schema::TYPE_INTEGER . ' NOT NULL',
    			'content' => Schema::TYPE_STRING . ' NOT NULL',
    			
    			'longitude' => Schema::TYPE_DOUBLE . ' DEFAULT 0',
    			'latitude' => Schema::TYPE_DOUBLE . ' DEFAULT 0',
    			
    			//'profession' => Schema::TYPE_STRING . ' NOT NULL',
    			'created_at' => Schema::TYPE_BIGINT . ' NOT NULL DEFAULT 0',
    	],'CHARACTER SET utf8 COLLATE utf8_general_ci ENGINE=InnoDB');
    	$this->addForeignKey('datershobbyidKey', 'daters', 'hobbyid', 'hobbies', 'id','CASCADE','CASCADE');
    	$this->addForeignKey('datersuseridKey', 'daters', 'userid', 'users', 'id','CASCADE','CASCADE');
    }

    public function down()
    {
        echo "m151105_154631_daters cannot be reverted.\n";
        $this->execute("DROP TABLE IF EXISTS daters");
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

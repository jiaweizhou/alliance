<?php

use yii\db\Schema;
use yii\db\Migration;

class m151105_113251_recommendations extends Migration
{
    public function up()
    {
    	$this->execute("DROP TABLE IF EXISTS recommendations");
    	$this->createTable('recommendations', [
    			'id' => Schema::TYPE_PK,
    			'userid' => Schema::TYPE_INTEGER ,
    			'title' => Schema::TYPE_STRING . ' NOT NULL',
    			'kindid' => Schema::TYPE_INTEGER . ' NOT NULL',
    			'location' => Schema::TYPE_BIGINT . ' NOT NULL',
    			'sellerphone' => Schema::TYPE_STRING . ' DEFAULT ""',
    			'reason' => Schema::TYPE_STRING . ' DEFAULT ""',
    			'pictures' => Schema::TYPE_STRING.'(2550) ' . ' DEFAULT ""',
    			//'profession' => Schema::TYPE_STRING . ' NOT NULL',
    			'created_at' => Schema::TYPE_BIGINT . ' NOT NULL DEFAULT 0',
    			],'CHARACTER SET utf8 COLLATE utf8_general_ci ENGINE=InnoDB');
    	$this->addForeignKey('rcuseridKey', 'recommendations', 'userid', 'users', 'id','CASCADE','CASCADE');
    	$this->addForeignKey('rcpid', 'recommendations', 'kindid', 'kindsofrecommendation', 'id','CASCADE','CASCADE');
    }

    public function down()
    {
        echo "m151105_113251_recommendations cannot be reverted.\n";
        $this->execute("DROP TABLE IF EXISTS recommendations");
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

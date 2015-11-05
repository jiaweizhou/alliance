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
    			'kind' => Schema::TYPE_INTEGER . ' NOT NULL',
    			'location' => Schema::TYPE_BIGINT . ' NOT NULL',
    			'sellerphone' => Schema::TYPE_STRING . ' DEFAULT ""',
    			'reason' => Schema::TYPE_STRING . ' DEFAULT ""',
    			'picture1' => Schema::TYPE_TEXT . ' DEFAULT ""',
    			'picture2' => Schema::TYPE_TEXT . ' DEFAULT ""',
    			'picture3' => Schema::TYPE_TEXT . ' DEFAULT ""',
    			'picture4' => Schema::TYPE_TEXT . ' DEFAULT ""',
    			'picture5' => Schema::TYPE_TEXT . ' DEFAULT ""',
    			'picture6' => Schema::TYPE_TEXT . ' DEFAULT ""',
    			'picture7' => Schema::TYPE_TEXT . ' DEFAULT ""',
    			'picture8' => Schema::TYPE_TEXT . ' DEFAULT ""',
    			'picture9' => Schema::TYPE_TEXT . ' DEFAULT ""',
    			//'profession' => Schema::TYPE_STRING . ' NOT NULL',
    			'created_at' => Schema::TYPE_BIGINT . ' NOT NULL DEFAULT 0',
    			],'CHARACTER SET utf8 COLLATE utf8_general_ci ENGINE=InnoDB');
    	$this->addForeignKey('rcuseridKey', 'recommendations', 'userid', 'users', 'id','CASCADE','CASCADE');
    	$this->addForeignKey('rcpid', 'recommendations', 'kind', 'kindsofrecommendation', 'id','CASCADE','CASCADE');
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

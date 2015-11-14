<?php

use yii\db\Schema;
use yii\db\Migration;

class m151108_073345_grabcommodities extends Migration
{
    public function up()
    {
    	$this->execute("DROP TABLE IF EXISTS grabcommodities");
    	$this->createTable('grabcommodities', [
    			'id' => Schema::TYPE_PK,
    			'picture'=>Schema::TYPE_STRING . ' NOT NULL DEFAULT ""',
    			 
    			'picture1'=>Schema::TYPE_STRING . ' NOT NULL DEFAULT ""',
    			'picture2'=>Schema::TYPE_STRING . ' NOT NULL DEFAULT ""',
    			'picture3'=>Schema::TYPE_STRING . ' NOT NULL DEFAULT ""',
    			'picture4'=>Schema::TYPE_STRING . ' NOT NULL DEFAULT ""',
    			'picture5'=>Schema::TYPE_STRING . ' NOT NULL DEFAULT ""',
    			'picture6'=>Schema::TYPE_STRING . ' NOT NULL DEFAULT ""',
    			
    			'detail1'=>Schema::TYPE_STRING . ' NOT NULL DEFAULT ""',
    			'detail2'=>Schema::TYPE_STRING . ' NOT NULL DEFAULT ""',
    			'detail3'=>Schema::TYPE_STRING . ' NOT NULL DEFAULT ""',
    			'detail4'=>Schema::TYPE_STRING . ' NOT NULL DEFAULT ""',
    			'detail5'=>Schema::TYPE_STRING . ' NOT NULL DEFAULT ""',
    			'detail6'=>Schema::TYPE_STRING . ' NOT NULL DEFAULT ""',
    			'detail7'=>Schema::TYPE_STRING . ' NOT NULL DEFAULT ""',
    			'detail8'=>Schema::TYPE_STRING . ' NOT NULL DEFAULT ""',
    			'detail9'=>Schema::TYPE_STRING . ' NOT NULL DEFAULT ""',
    			
    			'kind' => Schema::TYPE_INTEGER . 'NOT NULL',
    			'title' => Schema::TYPE_STRING . ' NOT NULL',
    			'version' => Schema::TYPE_STRING . ' NOT NULL',
    			 
    			'needed' => Schema::TYPE_INTEGER . ' NOT NULL',
    			'remain' => Schema::TYPE_INTEGER . ' NOT NULL',
    			 
    			'created_at' => Schema::TYPE_BIGINT . ' NOT NULL',
    			'date' => Schema::TYPE_BIGINT . ' NOT NULL',
    			'end_at' => Schema::TYPE_BIGINT . ' NOT NULL',
    	
    			'islotteried'=>Schema::TYPE_INTEGER . ' DEFAULT 0',
    			'winneruserid' => Schema::TYPE_BIGINT . ' DEFAULT 0',
    			'winnerrecordid' => Schema::TYPE_BIGINT . ' DEFAULT 0',
    			'winnernumber' => Schema::TYPE_BIGINT . ' DEFAULT 0',
    			'foruser' =>Schema::TYPE_INTEGER . ' DEFAULT 0',
    	],'CHARACTER SET utf8 COLLATE utf8_general_ci ENGINE=InnoDB');
    }

    public function down()
    {
        echo "m151108_073345_grabcommodities cannot be reverted.\n";
        $this->execute("DROP TABLE IF EXISTS grabcommodities");
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

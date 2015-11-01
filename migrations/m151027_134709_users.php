<?php

use yii\db\Schema;
use yii\db\Migration;

class m151027_134709_users extends Migration
{
    public function up()
    {
    	$this->execute("DROP TABLE IF EXISTS users");
    	$this->createTable('users', [
    			'id' => Schema::TYPE_PK,
    			'phone' => Schema::TYPE_STRING . ' NOT NULL',
    			'pwd' => Schema::TYPE_STRING . ' NOT NULL',
    			'authKey' => Schema::TYPE_STRING . ' NOT NULL',
    			'fatherid' =>  Schema::TYPE_STRING ,
    			'directalliancecount'=>Schema::TYPE_BIGINT . ' DEFAULT 0',
    			'allalliancecount'=>Schema::TYPE_BIGINT . ' DEFAULT 0',
    			'corns'=>Schema::TYPE_BIGINT . ' DEFAULT 0',
    			'alliancerewards'=>Schema::TYPE_BIGINT . ' DEFAULT 0',
    			'nickname' => Schema::TYPE_STRING . '(20) ',
    			'thumb' => Schema::TYPE_STRING,
    			'gender' => Schema::TYPE_STRING,
    			'area' => Schema::TYPE_STRING,
    			'job' => Schema::TYPE_STRING,
    			'hobby' => Schema::TYPE_STRING,
    			'signature' => Schema::TYPE_STRING,
    			'created_at' => Schema::TYPE_BIGINT . ' NOT NULL DEFAULT 0',
    			'updated_at' => Schema::TYPE_BIGINT . ' NOT NULL DEFAULT 0',
    			
    			'channel'=> Schema::TYPE_STRING,
    			'platform' => Schema::TYPE_STRING,
    			],'CHARACTER SET utf8 COLLATE utf8_general_ci ENGINE=InnoDB');
    	//$this->createIndex('user', 'user', 'user',true);
    	$this->createIndex('phone', 'users', 'phone',true);
    }

    public function down()
    {
        echo "m151027_134709_users cannot be reverted.\n";
        $this->dropTable('users');
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

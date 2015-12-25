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
    			'fatherid' =>  Schema::TYPE_INTEGER . ' DEFAULT 0',
    			'directalliancecount'=>Schema::TYPE_BIGINT . ' DEFAULT 0',
    			'allalliancecount'=>Schema::TYPE_BIGINT . ' DEFAULT 0',
    			
    			'corns'=>Schema::TYPE_BIGINT . ' DEFAULT 0',
    			'envelope' => Schema::TYPE_BIGINT . ' DEFAULT 0',
    			'cornsforgrab' => Schema::TYPE_BIGINT . ' DEFAULT 0',
    			
    			'alliancerewards'=>Schema::TYPE_BIGINT . ' DEFAULT 0',
    			'nickname' => Schema::TYPE_STRING . '(20) NOT NULL',
    			'thumb' => Schema::TYPE_STRING. ' NOT NULL DEFAULT "" ',
    			'gender' => Schema::TYPE_INTEGER. ' NOT NULL DEFAULT 0 ',
    			'area' => Schema::TYPE_STRING. ' NOT NULL DEFAULT "" ',
    			'job' => Schema::TYPE_STRING. ' NOT NULL DEFAULT "" ',
    			
    			'background'=>Schema::TYPE_STRING. ' NOT NULL DEFAULT "" ',
    			'invitecode'=>Schema::TYPE_STRING. ' NOT NULL DEFAULT "" ',
    			'paypwd'=>Schema::TYPE_STRING . ' NOT NULL DEFAULT "" ',
    			
    			'hobby' => Schema::TYPE_STRING. ' NOT NULL DEFAULT "" ',
    			'signature' => Schema::TYPE_STRING . ' DEFAULT "" ',
    			'created_at' => Schema::TYPE_BIGINT . ' NOT NULL DEFAULT 0',
    			'updated_at' => Schema::TYPE_BIGINT . ' NOT NULL DEFAULT 0',
    			
    			'friendcount' =>Schema::TYPE_INTEGER . ' DEFAULT 0',
    			'concerncount' =>Schema::TYPE_INTEGER . ' DEFAULT 0',
    			'isdraw' =>Schema::TYPE_INTEGER . ' NOT NULL DEFAULT 0',
    			'channel'=> Schema::TYPE_STRING . ' NOT NULL DEFAULT "" ',
    			'platform' => Schema::TYPE_STRING . ' NOT NULL DEFAULT "" ',
    			
    			'status'=>Schema::TYPE_INTEGER . ' NOT NULL DEFAULT 0',
    			
    			],'CHARACTER SET utf8 COLLATE utf8_general_ci ENGINE=InnoDB');
    	//$this->createIndex('user', 'user', 'user',true);
    	$this->createIndex('phone', 'users', 'phone',true);
    }

    public function down()
    {
        echo "m151027_134709_users cannot be reverted.\n";
        $this->dropTable('users');
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

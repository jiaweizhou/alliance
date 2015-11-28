<?php

use yii\db\Schema;
use yii\db\Migration;

class m151125_123607_admin extends Migration
{
public function safeUp()
    {
    	$this->execute("DROP TABLE IF EXISTS admin");
    	$this->createTable('admin', [
    			'id' => Schema::TYPE_PK,
    			'name' => Schema::TYPE_STRING . '(20) NOT NULL',
    			'pwd' => Schema::TYPE_STRING . ' NOT NULL',
    			],'CHARACTER SET utf8 COLLATE utf8_general_ci ENGINE=InnoDB');
    	//$this->createIndex('user', 'user', 'user',true);
    	$this->createIndex('name', 'admin', 'name',true);
    }
    
    
    public function safeDown()
    {
    	$this->dropTable('admin');
    }
}

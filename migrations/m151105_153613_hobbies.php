<?php

use yii\db\Schema;
use yii\db\Migration;

class m151105_153613_hobbies extends Migration
{
    public function up()
    {
    	$this->execute("DROP TABLE IF EXISTS hobbies");
    	$this->createTable('hobbies', [
    			'id' => Schema::TYPE_PK,
    			'hobby' => Schema::TYPE_STRING . ' NOT NULL DEFAULT "" ',
    	],'CHARACTER SET utf8 COLLATE utf8_general_ci ENGINE=InnoDB');
    	$this->createIndex('hobbies-id', 'hobbies', 'id');
    }

    public function down()
    {
        echo "m151105_153613_hobbies cannot be reverted.\n";
        $this->execute("DROP TABLE IF EXISTS hobbies");
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

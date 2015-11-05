<?php

use yii\db\Schema;
use yii\db\Migration;

class m151105_113544_recommendationcomments extends Migration
{
    public function up()
    {
    	$this->execute("DROP TABLE IF EXISTS recommendationcomments");
    	$this->createTable('recommendationcomments', [
    			'id' => Schema::TYPE_PK,
    			'userid' => Schema::TYPE_INTEGER ,
    			'recommendationid' => Schema::TYPE_INTEGER . ' NOT NULL',
    			'content' => Schema::TYPE_STRING . ' NOT NULL',
    			//'profession' => Schema::TYPE_STRING . ' NOT NULL',
    			'created_at' => Schema::TYPE_BIGINT . ' NOT NULL DEFAULT 0',
    			],'CHARACTER SET utf8 COLLATE utf8_general_ci ENGINE=InnoDB');
    	$this->addForeignKey('rdrcKey', 'recommendationcomments', 'recommendationid', 'recommendations', 'id','CASCADE','CASCADE');
    	$this->addForeignKey('rduseridKey', 'recommendationcomments', 'userid', 'users', 'id','CASCADE','CASCADE');
    }

    public function down()
    {
        echo "m151105_113544_recommendationcomments cannot be reverted.\n";
        $this->execute("DROP TABLE IF EXISTS recommendationcomments");
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

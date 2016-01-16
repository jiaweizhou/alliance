<?php

use yii\db\Schema;
use yii\db\Migration;

class m151103_152426_applyjobs extends Migration
{
    public function up()
    {
    	$this->execute("DROP TABLE IF EXISTS applyjobs");
    	$this->createTable('applyjobs', [
    			'id' => Schema::TYPE_PK,
    			'userid' => Schema::TYPE_INTEGER ,
    			'jobproperty' => Schema::TYPE_INTEGER . ' NOT NULL',
    			'title' => Schema::TYPE_STRING . ' NOT NULL',
    			'degree' => Schema::TYPE_INTEGER . ' NOT NULL',
    			'work_at' => Schema::TYPE_BIGINT . ' NOT NULL',
				'status' => Schema::TYPE_STRING . ' NOT NULL',
    			'herphone' => Schema::TYPE_STRING . ' NOT NULL DEFAULT ""',
    			'hidephone' => Schema::TYPE_INTEGER . ' DEFAULT 0',
    			'content' => Schema::TYPE_STRING . ' NOT NULL',
    			'professionid'=> Schema::TYPE_INTEGER,
    			
    			'longitude' => Schema::TYPE_FLOAT . ' DEFAULT 0',
    			'latitude' => Schema::TYPE_FLOAT . ' DEFAULT 0',
    			
    			//'profession' => Schema::TYPE_STRING . ' NOT NULL',
    			'created_at' => Schema::TYPE_BIGINT . ' NOT NULL DEFAULT 0',
    	],'CHARACTER SET utf8 COLLATE utf8_general_ci ENGINE=InnoDB');
    	$this->addForeignKey('ajuseridKey', 'applyjobs', 'userid', 'users', 'id','CASCADE','CASCADE');
    	$this->addForeignKey('ajpid', 'applyjobs', 'professionid', 'professions', 'id','CASCADE','CASCADE');
    }

    public function down()
    {
        echo "m151103_152426_applyjobs cannot be reverted.\n";
        $this->dropForeignKey('ajuseridKey', 'applyjobs');
        $this->dropForeignKey('ajpid', 'applyjobs');
        $this->dropTable('applyjobs');
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

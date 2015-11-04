<?php

use yii\db\Schema;
use yii\db\Migration;

class m151103_151919_professions extends Migration
{
    public function up()
    {
    	$this->execute("DROP TABLE IF EXISTS professions");
    	$this->createTable('professions', [
    			'id' => Schema::TYPE_PK,
    			'profession' => Schema::TYPE_STRING . ' NOT NULL DEFAULT "" ',
    	],'CHARACTER SET utf8 COLLATE utf8_general_ci ENGINE=InnoDB');
    	$this->createIndex('reply-msgid', 'professions', 'id');
    	//$this->createIndex('reply-msgid', 'professions', 'id');
    	
    }

    public function down()
    {
        echo "m151103_151919_professions cannot be reverted.\n";
        $this->dropTable('professions');
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

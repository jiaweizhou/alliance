<?php

use yii\db\Schema;
use yii\db\Migration;

class m151105_113250_kindsofrecommendation extends Migration
{
    public function up()
    {
    	$this->execute("DROP TABLE IF EXISTS kindsofrecommendation");
    	$this->createTable('kindsofrecommendation', [
    			'id' => Schema::TYPE_PK,
    			'kind' => Schema::TYPE_STRING . ' NOT NULL DEFAULT "" ',
    			],'CHARACTER SET utf8 COLLATE utf8_general_ci ENGINE=InnoDB');
    	$this->createIndex('kindsofrecommendation-id', 'kindsofrecommendation', 'id');
    }

    public function down()
    {
        echo "m151105_113812_kindsofrecommendation cannot be reverted.\n";
        $this->execute("DROP TABLE IF EXISTS kindsofrecommendation");
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

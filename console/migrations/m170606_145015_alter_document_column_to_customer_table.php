<?php

use yii\db\Migration;

class m170606_145015_alter_document_column_to_customer_table extends Migration
{
    public function up(){
        $this->alterColumn('{{%customer}}', 'document', $this->string());//timestamp new_data_type
    }

    public function down() {
        $this->alterColumn('{{%customer}}','document',  $this->integer(14) );//int is old_data_type
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

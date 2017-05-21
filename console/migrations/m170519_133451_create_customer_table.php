<?php

use yii\db\Migration;

/**
 * Handles the creation of table `customer`.
 */
class m170519_133451_create_customer_table extends Migration
{
    /**
     * @inheritdoc
     */
    public function up()
    {
        $this->createTable('{{%customer}}', [
            'id' => $this->primaryKey(),
            'name' => $this->string()->notNull(),
            'birthday' => $this->date()->notNull(),
            'document' => $this->integer(14),
            'agency' => $this->string(),
            'registry' => $this->string(),
            'address' => $this->string(),
            'complement' => $this->string(),
            'zip_code' => $this->string(),
            'neighbourhood' => $this->string(),
            'city' => $this->string(),
            'state' => $this->string(),
            'phone1' => $this->string(),
            'phone2' => $this->string(),
            'phone3' => $this->string(),
            'mail' => $this->string(),
            'customer_password' => $this->string(),
            'observation' => $this->text(),
            'telemarketing' => $this->string()
        ]);
    }

    /**
     * @inheritdoc
     */
    public function down()
    {
        $this->dropTable('{{%customer}}');
    }
}

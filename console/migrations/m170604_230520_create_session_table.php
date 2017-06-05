<?php

use yii\db\Migration;
use yii\db\Schema;

/**
 * Handles the creation of table `session`.
 */
class m170604_230520_create_session_table extends Migration
{
    /**
     * @inheritdoc
     */
    public function up()
    {
        $this->createTable('session', [
            'id' => $this->primaryKey(),
            'id' => $this->string(40),
            'expire' => $this->integer(),
            'data' => Schema::TYPE_BINARY,
            'user_id' => $this->integer(),
            'last_write' => Schema::TYPE_TIMESTAMP,
        ]);
    }

    /**
     * @inheritdoc
     */
    public function down()
    {
        $this->dropTable('session');
    }
}

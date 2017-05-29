<?php

use yii\db\Migration;

/**
 * Handles adding name_column_birthday to table `user`.
 */
class m170529_223607_add_name_column_birthday_column_to_user_table extends Migration
{
    /**
     * @inheritdoc
     */
    public function up()
    {
        $this->addColumn('user', 'name', $this->string());
        $this->addColumn('user', 'birthday', $this->date());
    }

    /**
     * @inheritdoc
     */
    public function down()
    {
        $this->dropColumn('user', 'name');
        $this->dropColumn('user', 'birthday');
    }
}

<?php

use yii\db\Migration;

/**
 * Handles adding folder to table `customer`.
 */
class m170529_231829_add_folder_column_to_customer_table extends Migration
{
    /**
     * @inheritdoc
     */
    public function up()
    {
        $this->addColumn('customer', 'folder', $this->string());
    }

    /**
     * @inheritdoc
     */
    public function down()
    {
        $this->dropColumn('customer', 'folder');
    }
}

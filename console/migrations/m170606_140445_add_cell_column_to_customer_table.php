<?php

use yii\db\Migration;

/**
 * Handles adding cell to table `customer`.
 */
class m170606_140445_add_cell_column_to_customer_table extends Migration
{
    /**
     * @inheritdoc
     */
    public function up()
    {
        $this->addColumn('customer', 'cell', $this->string());
    }

    /**
     * @inheritdoc
     */
    public function down()
    {
        $this->dropColumn('customer', 'cell');
    }
}

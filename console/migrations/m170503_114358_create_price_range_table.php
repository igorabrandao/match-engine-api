<?php

use yii\db\Migration;

/**
 * Handles the creation of table `price_range`.
 */
class m170503_114358_create_price_range_table extends Migration
{
    /**
     * @inheritdoc
     */
    public function up()
    {
        $this->createTable('price_range', [
            'id' => $this->primaryKey(),
            'description' => $this->string(255)->notNull(),
            'min_price' => $this->decimal(10,2),
            'max_price' => $this->decimal(10,2),
        ]);
    }

    /**
     * @inheritdoc
     */
    public function down()
    {
        $this->dropTable('price_range');
    }
}

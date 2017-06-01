<?php

use yii\db\Migration;

/**
 * Handles adding latitude_longitude to table `company`.
 */
class m170601_202802_add_latitude_longitude_columns_to_company_table extends Migration
{
    /**
     * @inheritdoc
     */
    public function up()
    {
        $this->addColumn('company', 'latitude', $this->string(18));
        $this->addColumn('company', 'longitude', $this->string(18));
    }

    /**
     * @inheritdoc
     */
    public function down()
    {
        $this->dropColumn('company', 'latitude');
        $this->dropColumn('company', 'longitude');
    }
}

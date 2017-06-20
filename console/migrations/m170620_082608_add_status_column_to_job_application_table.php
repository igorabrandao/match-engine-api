<?php

use yii\db\Migration;

/**
 * Handles adding status to table `job_application`.
 */
class m170620_082608_add_status_column_to_job_application_table extends Migration
{
    /**
     * @inheritdoc
     */
    public function up()
    {
        $this->addColumn('job_application', 'status', $this->integer()->notNull()->defaultValue(0));
    }

    /**
     * @inheritdoc
     */
    public function down()
    {
        $this->dropColumn('job_application', 'status');
    }
}

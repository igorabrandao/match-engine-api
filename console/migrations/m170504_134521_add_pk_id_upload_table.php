<?php

use yii\db\Migration;

class m170504_134521_add_pk_id_upload_table extends Migration
{
    public function up()
    {
        $this->addPrimaryKey('upload_pk', 'upload', 'id');
    }

    public function down()
    {
        echo "m170504_134521_add_pk_id_upload_table cannot be reverted.\n";

        return false;
    }
}

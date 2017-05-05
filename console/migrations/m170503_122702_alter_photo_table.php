<?php

use yii\db\Migration;

class m170503_122702_alter_photo_table extends Migration
{
    public function up()
    {
        $this->renameTable("photo", "upload");
    }

    public function down()
    {
        $this->renameTable("upload", "photo");
    }
}

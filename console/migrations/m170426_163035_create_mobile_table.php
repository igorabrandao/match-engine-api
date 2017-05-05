<?php

use yii\db\Migration;

/**
 * Handles the creation of table `mobile`.
 * Has foreign keys to the tables:
 *
 * - `user`
 */
class m170426_163035_create_mobile_table extends Migration
{
    /**
     * @inheritdoc
     */
    public function up()
    {
        $tableOptions = ($this->db->driverName === 'mysql') ? 'ENGINE=InnoDB DEFAULT CHARSET=latin1' : null;

        $this->createTable('mobile', [
            'id' => $this->primaryKey(),
            'registration' => $this->text()->notNull(),
            'os' => $this->string(255)->notNull(),
            'user_id' => $this->integer(),
        ], $tableOptions);

        // creates index for column `user_id`
        $this->createIndex(
            'idx-mobile-user_id',
            'mobile',
            'user_id'
        );

        // add foreign key for table `user`
        $this->addForeignKey(
            'fk-mobile-user_id',
            'mobile',
            'user_id',
            'user',
            'id',
            'CASCADE'
        );
    }

    /**
     * @inheritdoc
     */
    public function down()
    {
        // drops foreign key for table `user`
        $this->dropForeignKey(
            'fk-mobile-user_id',
            'mobile'
        );

        // drops index for column `user_id`
        $this->dropIndex(
            'idx-mobile-user_id',
            'mobile'
        );

        $this->dropTable('mobile');
    }
}

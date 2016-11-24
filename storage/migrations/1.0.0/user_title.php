<?php 

use Phalcon\Db\Column;
use Phalcon\Db\Index;
use Phalcon\Db\Reference;
use Phalcon\Mvc\Model\Migration;

/**
 * Class UserTitleMigration_100
 */
class UserTitleMigration_100 extends Migration
{
    /**
     * Define the table structure
     *
     * @return void
     */
    public function morph()
    {
        $this->morphTable('user_title', [
                'columns' => [
                    new Column(
                        'id',
                        [
                            'type' => Column::TYPE_INTEGER,
                            'unsigned' => true,
                            'notNull' => true,
                            'autoIncrement' => true,
                            'size' => 10,
                            'first' => true
                        ]
                    ),
                    new Column(
                        'uid',
                        [
                            'type' => Column::TYPE_INTEGER,
                            'notNull' => true,
                            'size' => 11,
                            'after' => 'id'
                        ]
                    ),
                    new Column(
                        'title_id',
                        [
                            'type' => Column::TYPE_INTEGER,
                            'notNull' => true,
                            'size' => 11,
                            'after' => 'uid'
                        ]
                    ),
                    new Column(
                        'created_at',
                        [
                            'type' => Column::TYPE_DATETIME,
                            'default' => "1900-01-01 00:00:00",
                            'notNull' => true,
                            'size' => 1,
                            'after' => 'title_id'
                        ]
                    ),
                    new Column(
                        'updated_at',
                        [
                            'type' => Column::TYPE_DATETIME,
                            'default' => "1900-01-01 00:00:00",
                            'notNull' => true,
                            'size' => 1,
                            'after' => 'created_at'
                        ]
                    )
                ],
                'indexes' => [
                    new Index('PRIMARY', ['id'], 'PRIMARY'),
                    new Index('titleid_uid_unique', ['uid', 'title_id'], 'UNIQUE'),
                    new Index('user_title_uid_index', ['uid'], null),
                    new Index('user_title_title_id_index', ['title_id'], null)
                ],
                'options' => [
                    'TABLE_TYPE' => 'BASE TABLE',
                    'AUTO_INCREMENT' => '1',
                    'ENGINE' => 'InnoDB',
                    'TABLE_COLLATION' => 'utf8_unicode_ci'
                ],
            ]
        );
    }

    /**
     * Run the migrations
     *
     * @return void
     */
    public function up()
    {

    }

    /**
     * Reverse the migrations
     *
     * @return void
     */
    public function down()
    {

    }

}

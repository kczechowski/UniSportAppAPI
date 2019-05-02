<?php


use Phinx\Migration\AbstractMigration;

class CreateWorkoutsTable extends AbstractMigration
{
    /**
     * Change Method.
     *
     * Write your reversible migrations using this method.
     *
     * More information on writing migrations is available here:
     * http://docs.phinx.org/en/latest/migrations.html#the-abstractmigration-class
     *
     * The following commands can be used in this method and Phinx will
     * automatically reverse them when rolling back:
     *
     *    createTable
     *    renameTable
     *    addColumn
     *    addCustomColumn
     *    renameColumn
     *    addIndex
     *    addForeignKey
     *
     * Any other destructive changes will result in an error when trying to
     * rollback the migration.
     *
     * Remember to call "create()" or "update()" and NOT "save()" when working
     * with the Table class.
     */

    public function change()
    {
        $workoutsTable = $this->table('workouts');
        $workoutsTable->addColumn('user_id', 'integer')
            ->addForeignKey('user_id', 'users', 'id', ['delete'=> 'CASCADE', 'update'=> 'NO_ACTION'])
            ->addColumn('start_time', 'datetime')
            ->addColumn('end_time', 'datetime')
            ->addColumn('type', 'string', ['limit' => 255])
            ->addColumn('title', 'string', ['limit' => 255])
            ->addColumn('message', 'string', ['limit' => 255])
            ->addColumn('calories', 'integer')
            ->addColumn('distance', 'integer')
            ->addColumn('created_at', 'datetime')
            ->addColumn('updated_at', 'datetime', ['null' => true])
            ->save();
    }
}

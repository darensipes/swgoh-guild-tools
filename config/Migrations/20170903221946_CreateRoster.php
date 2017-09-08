<?php
use Migrations\AbstractMigration;

class CreateRoster extends AbstractMigration
{
    public function up()
    {

        $this->table('roster', ['id' => false, 'primary_key' => ['player', 'toon']])
            ->addColumn('player', 'string', [
                'default' => '',
                'limit' => 100,
                'null' => false,
            ])
            ->addColumn('toon', 'string', [
                'default' => '',
                'limit' => 100,
                'null' => false,
            ])
            ->addColumn('level', 'integer', [
                'default' => null,
                'limit' => 2,
                'null' => false,
                'signed' => false,
            ])
            ->addColumn('stars', 'integer', [
                'default' => null,
                'limit' => 1,
                'null' => false,
                'signed' => false,
            ])
            ->addColumn('gear', 'integer', [
                'default' => null,
                'limit' => 2,
                'null' => false,
                'signed' => false,
            ])
            ->addColumn('created', 'datetime', [
                'default' => null,
                'limit' => null,
                'null' => true,
            ])
            ->addColumn('modified', 'datetime', [
                'default' => null,
                'limit' => null,
                'null' => true,
            ])
            ->create();
    }

    public function down()
    {
        $this->dropTable('roster');
    }
}

<?php
use Migrations\AbstractMigration;

class CreateShips extends AbstractMigration
{

    public function up()
    {
        $this->table('ships', ['id' => false, 'primary_key' => ['member', 'ship']])
            ->addColumn('member', 'string', [
                'default' => '',
                'limit' => 100,
                'null' => false,
            ])
            ->addColumn('ship', 'string', [
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
            ->addColumn('power', 'integer', [
                'default' => null,
                'limit' => 6,
                'null' => true,
            ])
            ->addColumn('max_power', 'integer', [
                'default' => null,
                'limit' => 6,
                'null' => true,
            ])
            ->addColumn('light_side', 'boolean', [
                'default' => null,
                'limit' => null,
                'null' => true,
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
        $this->dropTable('ships');
    }
}

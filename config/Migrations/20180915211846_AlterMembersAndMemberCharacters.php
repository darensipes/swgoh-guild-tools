<?php
use Migrations\AbstractMigration;

class AlterMembersAndMemberCharacters extends AbstractMigration
{

    public function up()
    {
        $this->table('members')
            ->changeColumn('swgoh_name', 'string', [
                'default' => '',
                'limit' => 150,
                'null' => true,
            ])
            ->update();

        $this->table('member_characters')
            ->addColumn('zetas', 'integer', [
                'after' => 'gear',
                'default' => null,
                'length' => 1,
                'null' => false,
            ])
            ->update();

        $this->table('members')
            ->addColumn('swgoh_number', 'integer', [
                'after' => 'name',
                'default' => null,
                'length' => 10,
                'null' => false,
            ])
            ->update();
    }

    public function down()
    {
        $this->table('member_characters')
            ->removeColumn('zetas')
            ->update();

        $this->table('members')
            ->changeColumn('swgoh_name', 'string', [
                'default' => null,
                'length' => 150,
                'null' => false,
            ])
            ->removeColumn('swgoh_number')
            ->update();
    }
}

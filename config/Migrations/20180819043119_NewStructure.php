<?php
use Migrations\AbstractMigration;

class NewStructure extends AbstractMigration
{

    public $autoId = false;

    public function up()
    {
        $this->table('roster')->drop()->save();
        $this->table('ships')->drop()->save();

        $this->table('characters')
            ->addColumn('id', 'integer', [
                'autoIncrement' => true,
                'default' => null,
                'limit' => 10,
                'null' => false,
                'signed' => false,
            ])
            ->addPrimaryKey(['id'])
            ->addColumn('name', 'string', [
                'default' => null,
                'limit' => 150,
                'null' => false,
            ])
            ->addColumn('light_side', 'boolean', [
                'default' => null,
                'limit' => null,
                'null' => true,
            ])
            ->create();

        $this->table('factions')
            ->addColumn('id', 'integer', [
                'autoIncrement' => true,
                'default' => null,
                'limit' => 10,
                'null' => false,
            ])
            ->addPrimaryKey(['id'])
            ->addColumn('name', 'string', [
                'default' => null,
                'limit' => 45,
                'null' => false,
            ])
            ->create();

        $this->table('factions_characters')
            ->addColumn('faction_id', 'integer', [
                'default' => null,
                'limit' => 10,
                'null' => false,
            ])
            ->addColumn('character_id', 'integer', [
                'default' => null,
                'limit' => 10,
                'null' => false,
                'signed' => false,
            ])
            ->addPrimaryKey(['faction_id', 'character_id'])
            ->addIndex(
                [
                    'character_id',
                ]
            )
            ->addIndex(
                [
                    'faction_id',
                ]
            )
            ->create();

        $this->table('factions_ships')
            ->addColumn('faction_id', 'integer', [
                'default' => null,
                'limit' => 10,
                'null' => false,
            ])
            ->addColumn('ship_id', 'integer', [
                'default' => null,
                'limit' => 10,
                'null' => false,
                'signed' => false,
            ])
            ->addPrimaryKey(['faction_id', 'ship_id'])
            ->addIndex(
                [
                    'faction_id',
                ]
            )
            ->addIndex(
                [
                    'ship_id',
                ]
            )
            ->create();

        $this->table('guilds')
            ->addColumn('id', 'integer', [
                'autoIncrement' => true,
                'default' => null,
                'limit' => 10,
                'null' => false,
                'signed' => false,
            ])
            ->addPrimaryKey(['id'])
            ->addColumn('name', 'string', [
                'default' => null,
                'limit' => 150,
                'null' => false,
            ])
            ->addColumn('swgoh_number', 'integer', [
                'default' => null,
                'limit' => 10,
                'null' => false,
                'signed' => false,
            ])
            ->addColumn('slug', 'string', [
                'default' => null,
                'limit' => 150,
                'null' => false,
            ])
            ->addColumn('sync_utc_hour', 'integer', [
                'default' => '0',
                'limit' => 2,
                'null' => false,
                'signed' => false,
            ])
            ->addIndex(
                [
                    'slug',
                ],
                ['unique' => true]
            )
            ->create();

        $this->table('member_characters')
            ->addColumn('id', 'integer', [
                'autoIncrement' => true,
                'default' => null,
                'limit' => 10,
                'null' => false,
                'signed' => false,
            ])
            ->addPrimaryKey(['id'])
            ->addColumn('member_id', 'integer', [
                'default' => null,
                'limit' => 10,
                'null' => false,
                'signed' => false,
            ])
            ->addColumn('character_id', 'integer', [
                'default' => null,
                'limit' => 10,
                'null' => false,
                'signed' => false,
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
            ->addIndex(
                [
                    'member_id',
                    'character_id',
                ],
                ['unique' => true]
            )
            ->addIndex(
                [
                    'character_id',
                ]
            )
            ->addIndex(
                [
                    'member_id',
                ]
            )
            ->create();

        $this->table('member_ships')
            ->addColumn('id', 'integer', [
                'autoIncrement' => true,
                'default' => null,
                'limit' => 10,
                'null' => false,
                'signed' => false,
            ])
            ->addPrimaryKey(['id'])
            ->addColumn('member_id', 'integer', [
                'default' => null,
                'limit' => 10,
                'null' => false,
                'signed' => false,
            ])
            ->addColumn('ship_id', 'integer', [
                'default' => null,
                'limit' => 10,
                'null' => false,
                'signed' => false,
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
            ->addIndex(
                [
                    'member_id',
                    'ship_id',
                ],
                ['unique' => true]
            )
            ->addIndex(
                [
                    'member_id',
                ]
            )
            ->addIndex(
                [
                    'ship_id',
                ]
            )
            ->create();

        $this->table('members')
            ->addColumn('id', 'integer', [
                'autoIncrement' => true,
                'default' => null,
                'limit' => 10,
                'null' => false,
                'signed' => false,
            ])
            ->addPrimaryKey(['id'])
            ->addColumn('guild_id', 'integer', [
                'default' => null,
                'limit' => 10,
                'null' => false,
                'signed' => false,
            ])
            ->addColumn('name', 'string', [
                'default' => null,
                'limit' => 150,
                'null' => false,
            ])
            ->addColumn('swgoh_name', 'string', [
                'default' => null,
                'limit' => 150,
                'null' => false,
            ])
            ->addColumn('ally_code', 'string', [
                'default' => null,
                'limit' => 11,
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
            ->addIndex(
                [
                    'guild_id',
                ]
            )
            ->create();

        $this->table('ships')
            ->addColumn('id', 'integer', [
                'autoIncrement' => true,
                'default' => null,
                'limit' => 10,
                'null' => false,
                'signed' => false,
            ])
            ->addPrimaryKey(['id'])
            ->addColumn('name', 'string', [
                'default' => null,
                'limit' => 150,
                'null' => false,
            ])
            ->addColumn('light_side', 'boolean', [
                'default' => null,
                'limit' => null,
                'null' => true,
            ])
            ->create();

        $this->table('factions_characters')
            ->addForeignKey(
                'character_id',
                'characters',
                'id',
                [
                    'update' => 'NO_ACTION',
                    'delete' => 'NO_ACTION'
                ]
            )
            ->addForeignKey(
                'faction_id',
                'factions',
                'id',
                [
                    'update' => 'NO_ACTION',
                    'delete' => 'NO_ACTION'
                ]
            )
            ->update();

        $this->table('factions_ships')
            ->addForeignKey(
                'faction_id',
                'factions',
                'id',
                [
                    'update' => 'NO_ACTION',
                    'delete' => 'NO_ACTION'
                ]
            )
            ->addForeignKey(
                'ship_id',
                'ships',
                'id',
                [
                    'update' => 'NO_ACTION',
                    'delete' => 'NO_ACTION'
                ]
            )
            ->update();

        $this->table('member_characters')
            ->addForeignKey(
                'character_id',
                'characters',
                'id',
                [
                    'update' => 'NO_ACTION',
                    'delete' => 'NO_ACTION'
                ]
            )
            ->addForeignKey(
                'member_id',
                'members',
                'id',
                [
                    'update' => 'NO_ACTION',
                    'delete' => 'NO_ACTION'
                ]
            )
            ->update();

        $this->table('member_ships')
            ->addForeignKey(
                'member_id',
                'members',
                'id',
                [
                    'update' => 'NO_ACTION',
                    'delete' => 'NO_ACTION'
                ]
            )
            ->addForeignKey(
                'ship_id',
                'ships',
                'id',
                [
                    'update' => 'NO_ACTION',
                    'delete' => 'NO_ACTION'
                ]
            )
            ->update();

        $this->table('members')
            ->addForeignKey(
                'guild_id',
                'guilds',
                'id',
                [
                    'update' => 'NO_ACTION',
                    'delete' => 'NO_ACTION'
                ]
            )
            ->update();
    }

    public function down()
    {
        $this->table('factions_characters')
            ->dropForeignKey(
                'character_id'
            )
            ->dropForeignKey(
                'faction_id'
            )->save();

        $this->table('factions_ships')
            ->dropForeignKey(
                'faction_id'
            )
            ->dropForeignKey(
                'ship_id'
            )->save();

        $this->table('member_characters')
            ->dropForeignKey(
                'character_id'
            )
            ->dropForeignKey(
                'member_id'
            )->save();

        $this->table('member_ships')
            ->dropForeignKey(
                'member_id'
            )
            ->dropForeignKey(
                'ship_id'
            )->save();

        $this->table('members')
            ->dropForeignKey(
                'guild_id'
            )->save();

        $this->table('characters')->drop()->save();
        $this->table('factions')->drop()->save();
        $this->table('factions_characters')->drop()->save();
        $this->table('factions_ships')->drop()->save();
        $this->table('guilds')->drop()->save();
        $this->table('member_characters')->drop()->save();
        $this->table('member_ships')->drop()->save();
        $this->table('members')->drop()->save();
        $this->table('ships')->drop()->save();
    }
}

<?php
namespace App\Controller;

use App\Controller\AppController;
use Cake\Http\Exception\NotFoundException;
use Cake\Utility\Hash;

/**
 * MemberShips Controller
 *
 * @property \App\Model\Table\MemberShipsTable $MemberShips
 *
 * @method \App\Model\Entity\MemberShip[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class MemberShipsController extends AppController
{

    public function ship($shipId = null, $guildSlug = null)
    {
        $guild = $this->MemberShips->Members->Guilds
            ->find()
            ->where(['Guilds.slug' => $guildSlug])
            ->first();

        if (empty($guild)) {
            throw new NotFoundException('Guild not found!', 404);
        }

        $ship = $this->MemberShips->Ships
            ->find()
            ->contain([
                'Factions' => function ($q) {
                    return $q->orderAsc('name');
                }
            ])
            ->where(['Ships.id' => $shipId])
            ->first();

        if (empty($ship)) {
            throw new NotFoundException('Character not found!', 404);
        }

        $memberShips = $this->MemberShips
            ->find()
            ->where([
                'MemberShips.ship_id' => $shipId,
                'Members.guild_id' => $guild->id
            ])
            ->contain([
                'Members'
            ])
            ->orderAsc('Members.name');

        $this->set(compact('guild', 'ship', 'memberShips'));
    }

    public function stars($guildSlug = null)
    {
        $guild = $this->MemberShips->Members->Guilds
            ->find()
            ->where(['Guilds.slug' => $guildSlug])
            ->first();

        if (empty($guild)) {
            throw new NotFoundException('Guild not found!', 404);
        }

        $memberShips = $this->MemberShips
            ->find()
            ->select([
                'ship_id' => 'Ships.id',
                'member_swgoh_name' => 'Members.swgoh_name',
                'stars' => 'MemberShips.stars'
            ])
            ->where([
                'Members.guild_id' => $guild->id
            ])
            ->contain([
                'Members',
                'Ships'
            ])
            ->enableHydration(false)
            ->orderAsc('Members.name')
            ->orderAsc('Ships.name');

        if ($this->request->getQuery('side') === 'light') {
            $memberShips->where([
                'Ships.light_side' => 1
            ]);
        } elseif ($this->request->getQuery('side') === 'dark') {
            $memberShips->where([
                'Ships.light_side' => 0
            ]);
        }

        $memberShips = Hash::combine($memberShips->toArray(), '{n}.ship_id', '{n}.stars', '{n}.member_swgoh_name');

        $ships = $this->MemberShips->Ships->find('list')->orderAsc('name')->toArray();
        $members = $this->MemberShips->Members->find('list', ['keyField' => 'swgoh_name', 'valueField' => 'name'])->orderAsc('name')->toArray();

        $this->set(compact('guild', 'ships', 'members', 'memberShips'));
    }

    public function level($guildSlug = null)
    {
        $guild = $this->MemberShips->Members->Guilds
            ->find()
            ->where(['Guilds.slug' => $guildSlug])
            ->first();

        if (empty($guild)) {
            throw new NotFoundException('Guild not found!', 404);
        }

        $memberShips = $this->MemberShips
            ->find()
            ->select([
                'ship_id' => 'Ships.id',
                'member_swgoh_name' => 'Members.swgoh_name',
                'level' => 'MemberShips.level'
            ])
            ->where([
                'Members.guild_id' => $guild->id
            ])
            ->contain([
                'Members',
                'Ships'
            ])
            ->enableHydration(false)
            ->orderAsc('Members.name')
            ->orderAsc('Ships.name');

        if ($this->request->getQuery('side') === 'light') {
            $memberShips->where([
                'Ships.light_side' => 1
            ]);
        } elseif ($this->request->getQuery('side') === 'dark') {
            $memberShips->where([
                'Ships.light_side' => 0
            ]);
        }

        $memberShips = Hash::combine($memberShips->toArray(), '{n}.ship_id', '{n}.level', '{n}.member_swgoh_name');

        $ships = $this->MemberShips->Ships->find('list')->orderAsc('name')->toArray();
        $members = $this->MemberShips->Members->find('list', ['keyField' => 'swgoh_name', 'valueField' => 'name'])->orderAsc('name')->toArray();

        $this->set(compact('guild', 'ships', 'members', 'memberShips'));
    }
}

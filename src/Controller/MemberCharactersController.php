<?php
namespace App\Controller;

use App\Controller\AppController;
use Cake\Http\Exception\NotFoundException;
use Cake\Utility\Hash;

/**
 * MemberCharacters Controller
 *
 *
 * @method \App\Model\Entity\MemberCharacter[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class MemberCharactersController extends AppController
{

    public function character($characterId = null, $guildSlug = null)
    {
        $guild = $this->MemberCharacters->Members->Guilds
            ->find()
            ->where(['Guilds.slug' => $guildSlug])
            ->first();

        if (empty($guild)) {
            throw new NotFoundException('Guild not found!', 404);
        }

        $character = $this->MemberCharacters->Characters
            ->find()
            ->contain([
                'Factions' => function ($q) {
                    return $q->orderAsc('name');
                }
            ])
            ->where(['Characters.id' => $characterId])
            ->first();

        if (empty($character)) {
            throw new NotFoundException('Character not found!', 404);
        }

        $memberCharacters = $this->MemberCharacters
            ->find()
            ->where([
                'MemberCharacters.character_id' => $characterId,
                'Members.guild_id' => $guild->id
            ])
            ->contain([
                'Members'
            ])
            ->orderAsc('Members.name');

        $this->set(compact('guild', 'character', 'memberCharacters'));
    }

    public function stars($guildSlug = null)
    {
        $guild = $this->MemberCharacters->Members->Guilds
            ->find()
            ->where(['Guilds.slug' => $guildSlug])
            ->first();

        if (empty($guild)) {
            throw new NotFoundException('Guild not found!', 404);
        }

        $memberCharacters = $this->MemberCharacters
            ->find()
            ->select([
                'character_id' => 'Characters.id',
                'member_swgoh_number' => 'Members.swgoh_number',
                'stars' => 'MemberCharacters.stars'
            ])
            ->where([
                'Members.guild_id' => $guild->id
            ])
            ->contain([
                'Members',
                'Characters'
            ])
            ->enableHydration(false)
            ->orderAsc('Members.name')
            ->orderAsc('Characters.name');

        if ($this->request->getQuery('side') === 'light') {
            $memberCharacters->where([
                'Characters.light_side' => 1
            ]);
        } elseif ($this->request->getQuery('side') === 'dark') {
            $memberCharacters->where([
                'Characters.light_side' => 0
            ]);
        }

        $memberCharacters = Hash::combine($memberCharacters->toArray(), '{n}.character_id', '{n}.stars', '{n}.member_swgoh_number');

        $characters = $this->MemberCharacters->Characters->find('list')->orderAsc('name')->toArray();
        $members = $this->MemberCharacters->Members->find('list', ['keyField' => 'swgoh_number', 'valueField' => 'name'])->orderAsc('name')->toArray();

        $this->set(compact('guild', 'characters', 'members', 'memberCharacters'));
    }

    public function level($guildSlug = null)
    {
        $guild = $this->MemberCharacters->Members->Guilds
            ->find()
            ->where(['Guilds.slug' => $guildSlug])
            ->first();

        if (empty($guild)) {
            throw new NotFoundException('Guild not found!', 404);
        }

        $memberCharacters = $this->MemberCharacters
            ->find()
            ->select([
                'character_id' => 'Characters.id',
                'member_swgoh_number' => 'Members.swgoh_number',
                'level' => 'MemberCharacters.level'
            ])
            ->where([
                'Members.guild_id' => $guild->id
            ])
            ->contain([
                'Members',
                'Characters'
            ])
            ->enableHydration(false)
            ->orderAsc('Members.name')
            ->orderAsc('Characters.name');

        if ($this->request->getQuery('side') === 'light') {
            $memberCharacters->where([
                'Characters.light_side' => 1
            ]);
        } elseif ($this->request->getQuery('side') === 'dark') {
            $memberCharacters->where([
                'Characters.light_side' => 0
            ]);
        }

        $memberCharacters = Hash::combine($memberCharacters->toArray(), '{n}.character_id', '{n}.level', '{n}.member_swgoh_number');

        $characters = $this->MemberCharacters->Characters->find('list')->orderAsc('name')->toArray();
        $members = $this->MemberCharacters->Members->find('list', ['keyField' => 'swgoh_number', 'valueField' => 'name'])->orderAsc('name')->toArray();

        $this->set(compact('guild', 'characters', 'members', 'memberCharacters'));
    }

    public function gear($guildSlug = null)
    {
        $guild = $this->MemberCharacters->Members->Guilds
            ->find()
            ->where(['Guilds.slug' => $guildSlug])
            ->first();

        if (empty($guild)) {
            throw new NotFoundException('Guild not found!', 404);
        }

        $memberCharacters = $this->MemberCharacters
            ->find()
            ->select([
                'character_id' => 'Characters.id',
                'member_swgoh_number' => 'Members.swgoh_number',
                'gear' => 'MemberCharacters.gear'
            ])
            ->where([
                'Members.guild_id' => $guild->id
            ])
            ->contain([
                'Members',
                'Characters'
            ])
            ->enableHydration(false)
            ->orderAsc('Members.name')
            ->orderAsc('Characters.name');

        if ($this->request->getQuery('side') === 'light') {
            $memberCharacters->where([
                'Characters.light_side' => 1
            ]);
        } elseif ($this->request->getQuery('side') === 'dark') {
            $memberCharacters->where([
                'Characters.light_side' => 0
            ]);
        }

        $memberCharacters = Hash::combine($memberCharacters->toArray(), '{n}.character_id', '{n}.gear', '{n}.member_swgoh_number');

        $characters = $this->MemberCharacters->Characters->find('list')->orderAsc('name')->toArray();
        $members = $this->MemberCharacters->Members->find('list', ['keyField' => 'swgoh_number', 'valueField' => 'name'])->orderAsc('name')->toArray();

        $this->set(compact('guild', 'characters', 'members', 'memberCharacters'));
    }
}

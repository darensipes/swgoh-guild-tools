<?php
namespace App\Controller;

use App\Controller\AppController;
use Cake\Http\Exception\NotFoundException;

/**
 * Guilds Controller
 *
 *
 * @method \App\Model\Entity\Guild[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class GuildsController extends AppController
{

    /**
     * Index method
     *
     * @return \Cake\Http\Response|void
     */
    public function index()
    {
        $guilds = $this->Guilds
            ->find()
            ->orderAsc('name');

        $this->set(compact('guilds'));
    }

    public function members($slug = null)
    {
        $guild = $this->Guilds
            ->find()
            ->contain([
                'Members' => function($q) {
                    return $q->orderAsc('name');
                }
            ])
            ->where(['Guilds.slug' => $slug])
            ->first();

        if (empty($guild)) {
            throw new NotFoundException('Guild not found!', 404);
        }

        $this->set('guild', $guild);
    }

    public function characters($slug = null)
    {
        $guild = $this->Guilds
            ->find()
            ->where(['Guilds.slug' => $slug])
            ->first();

        if (empty($guild)) {
            throw new NotFoundException('Guild not found!', 404);
        }

        $this->loadModel('Characters');
        $averageSubquery = $this->Characters->MemberCharacters
            ->find();
        $averageSubquery
            ->select(['average' => $averageSubquery->func()->avg('MemberCharacters.stars')])
            ->contain([
                'Members'
            ])
            ->where([
                'Members.guild_id' => $guild->id,
                'MemberCharacters.character_id = Characters.id'
            ]);

        $characters = $this->Characters
            ->find()
            ->select(['average' => $averageSubquery])
            ->select($this->Characters)
            ->contain([
                'Factions' => function ($q) {
                    return $q->orderAsc('name');
                }
            ])
            ->orderAsc('name');

        $this->set('guild', $guild);
        $this->set('characters', $characters);
    }

    public function ships($slug = null)
    {
        $guild = $this->Guilds
            ->find()
            ->where(['Guilds.slug' => $slug])
            ->first();

        if (empty($guild)) {
            throw new NotFoundException('Guild not found!', 404);
        }

        $this->loadModel('Ships');
        $averageSubquery = $this->Ships->MemberShips
            ->find();
        $averageSubquery
            ->select(['average' => $averageSubquery->func()->avg('MemberShips.stars')])
            ->contain([
                'Members'
            ])
            ->where([
                'Members.guild_id' => $guild->id,
                'MemberShips.ship_id = Ships.id'
            ]);

        $ships = $this->Ships
            ->find()
            ->select(['average' => $averageSubquery])
            ->select($this->Ships)
            ->contain([
                'Factions' => function ($q) {
                    return $q->orderAsc('name');
                }
            ])
            ->orderAsc('name');

        $this->set('guild', $guild);
        $this->set('ships', $ships);
    }
}

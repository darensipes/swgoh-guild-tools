<?php
namespace App\Controller;

use App\Controller\AppController;
use Cake\Http\Exception\NotFoundException;

/**
 * Members Controller
 */
class MembersController extends AppController
{

    /**
     * Characters method
     *
     * @param string|null $guild The Guild Slug.
     * @param string|null $member The Member Slug.
     * @return \Cake\Http\Response|void
     * @throws \Cake\Http\Exception\NotFoundException When record not found.
     */
    public function characters($guild = null, $member = null)
    {
        $member = $this->Members
            ->find()
            ->contain([
                'MemberCharacters' => [
                    'Characters' => [
                        'Factions' => function ($q) {
                            return $q->orderAsc('name');
                        }
                    ]
                ],
                'Guilds'
            ])
            ->where(['Members.swgoh_name' => $member])
            ->first();

        if (empty($member)) {
            throw new NotFoundException('Member not found!', 404);
        }

        $this->set('member', $member);
    }

    /**
     * Ships method
     *
     * @param string|null $guild The Guild Slug.
     * @param string|null $member The Member Slug.
     * @return \Cake\Http\Response|void
     * @throws \Cake\Http\Exception\NotFoundException When record not found.
     */
    public function ships($guild = null, $member = null)
    {
        $member = $this->Members
            ->find()
            ->contain([
                'MemberShips' => [
                    'Ships' => [
                        'Factions' => function ($q) {
                            return $q->orderAsc('name');
                        }
                    ]
                ],
                'Guilds'
            ])
            ->where(['Members.swgoh_name' => $member])
            ->first();

        if (empty($member)) {
            throw new NotFoundException('Member not found!', 404);
        }

        $this->set('member', $member);
    }
}

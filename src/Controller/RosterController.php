<?php
namespace App\Controller;

use App\Controller\AppController;
use Cake\Utility\Hash;

/**
 * Roster Controller
 *
 * @property \App\Model\Table\RosterTable $Roster
 *
 * @method \App\Model\Entity\Roster[] paginate($object = null, array $settings = [])
 */
class RosterController extends AppController
{

    public function stars()
    {
        $inventories = $this->Roster
            ->find()
            ->order([
                'Roster.member' => 'asc',
                'Roster.toon' => 'asc',
            ]);

        $lightSide = null;
        if ($this->request->getQuery('side')) {
            if (strtolower($this->request->getQuery('side')) == 'light') {
                $inventories->where(['Roster.light_side' => true]);
                $lightSide = true;
            } elseif (strtolower($this->request->getQuery('side')) == 'dark') {
                $inventories->where(['Roster.light_side' => false]);
                $lightSide = false;
            }
        }

        if ($this->request->getQuery('eligible')) {
            $inventories->where(['Roster.member IN' => $this->Roster->getUniqueMembers(65)]);
        }

        $toons = $this->Roster->getUniqueToons($lightSide);

        $roster = Hash::combine($inventories->toArray(), '{n}.toon', '{n}.stars', '{n}.member');

        $this->set('toons', $toons);
        $this->set(compact('roster'));
        $this->set('_serialize', ['roster']);
    }

    public function gear()
    {
        $inventories = $this->Roster
            ->find()
            ->order([
                'Roster.member' => 'asc',
                'Roster.toon' => 'asc',
            ]);

        $lightSide = null;
        if ($this->request->getQuery('side')) {
            if (strtolower($this->request->getQuery('side')) == 'light') {
                $inventories->where(['Roster.light_side' => true]);
                $lightSide = true;
            } elseif (strtolower($this->request->getQuery('side')) == 'dark') {
                $inventories->where(['Roster.light_side' => false]);
                $lightSide = false;
            }
        }

        if ($this->request->getQuery('eligible')) {
            $inventories->where(['Roster.member IN' => $this->Roster->getUniqueMembers(65)]);
        }

        $toons = $this->Roster->getUniqueToons($lightSide);

        $roster = Hash::combine($inventories->toArray(), '{n}.toon', '{n}.gear', '{n}.member');

        $this->set('toons', $toons);
        $this->set(compact('roster'));
        $this->set('_serialize', ['roster']);
    }

    public function level()
    {
        $inventories = $this->Roster
            ->find()
            ->order([
                'Roster.member' => 'asc',
                'Roster.toon' => 'asc',
            ]);

        $lightSide = null;
        if ($this->request->getQuery('side')) {
            if (strtolower($this->request->getQuery('side')) == 'light') {
                $inventories->where(['Roster.light_side' => true]);
                $lightSide = true;
            } elseif (strtolower($this->request->getQuery('side')) == 'dark') {
                $inventories->where(['Roster.light_side' => false]);
                $lightSide = false;
            }
        }

        if ($this->request->getQuery('eligible')) {
            $inventories->where(['Roster.member IN' => $this->Roster->getUniqueMembers(65)]);
        }

        $toons = $this->Roster->getUniqueToons($lightSide);

        $roster = Hash::combine($inventories->toArray(), '{n}.toon', '{n}.level', '{n}.member');

        $this->set('toons', $toons);
        $this->set(compact('roster'));
        $this->set('_serialize', ['roster']);
    }

    public function power()
    {
        $inventories = $this->Roster
            ->find()
            ->order([
                'Roster.member' => 'asc',
                'Roster.toon' => 'asc',
            ]);

        $lightSide = null;
        if ($this->request->getQuery('side')) {
            if (strtolower($this->request->getQuery('side')) == 'light') {
                $inventories->where(['Roster.light_side' => true]);
                $lightSide = true;
            } elseif (strtolower($this->request->getQuery('side')) == 'dark') {
                $inventories->where(['Roster.light_side' => false]);
                $lightSide = false;
            }
        }

        if ($this->request->getQuery('eligible')) {
            $inventories->where(['Roster.member IN' => $this->Roster->getUniqueMembers(65)]);
        }

        $toons = $this->Roster->getUniqueToons($lightSide);

        $roster = Hash::combine($inventories->toArray(), '{n}.toon', '{n}.power', '{n}.member');

        $this->set('toons', $toons);
        $this->set(compact('roster'));
        $this->set('_serialize', ['roster']);
    }

    public function average()
    {
        $toons = $this->Roster->find();
        $toons
            ->select(['Roster.toon', 'star_avg' => $toons->func()->avg('Roster.stars')])
            ->group([
                'Roster.toon'
            ])
            ->order(['star_avg' => 'asc']);

        $lightSide = null;
        if ($this->request->getQuery('side')) {
            if (strtolower($this->request->getQuery('side')) == 'light') {
                $toons->where(['Roster.light_side' => true]);
                $lightSide = true;
            } elseif (strtolower($this->request->getQuery('side')) == 'dark') {
                $toons->where(['Roster.light_side' => false]);
                $lightSide = false;
            }
        }

        $this->set('toons', $toons);
        $this->set('_serialize', ['toons']);
    }

    public function toons()
    {
        $toons = $this->Roster->getUniqueToons();
        $this->set('toons', $toons);
        $this->set('_serialize', ['toons']);
    }

    public function members()
    {
        $members = $this->Roster->getUniqueMembers();
        $this->set('members', $members);
        $this->set('_serialize', ['members']);
    }

    public function toon($toonId = null)
    {
        $toon = $this->Roster
            ->find()
            ->where([
                'Roster.toon' => $toonId
            ])
            ->order([
                'Roster.member' => 'asc',
            ]);

        $this->set('toonId', $toonId);
        $this->set('toon', $toon);
        $this->set('_serialize', ['toon']);
    }

    public function member($memberId = null)
    {
        $member = $this->Roster
            ->find()
            ->where([
                'Roster.member' => $memberId
            ])
            ->order([
                'Roster.toon' => 'asc',
            ]);

        $this->set('memberId', $memberId);
        $this->set('member', $member);
        $this->set('_serialize', ['member']);
    }
}

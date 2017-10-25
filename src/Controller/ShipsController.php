<?php
namespace App\Controller;

use App\Controller\AppController;
use Cake\Utility\Hash;

/**
 * Ships Controller
 *
 * @property \App\Model\Table\ShipsTable $Ships
 *
 * @method \App\Model\Entity\Ships[] paginate($object = null, array $settings = [])
 */
class ShipsController extends AppController
{

    public function stars()
    {
        $inventories = $this->Ships
            ->find()
            ->order([
                'Ships.member' => 'asc',
                'Ships.ship' => 'asc',
            ]);

        $lightSide = null;
        if ($this->request->getQuery('side')) {
            if (strtolower($this->request->getQuery('side')) == 'light') {
                $inventories->where(['Ships.light_side' => true]);
                $lightSide = true;
            } elseif (strtolower($this->request->getQuery('side')) == 'dark') {
                $inventories->where(['Ships.light_side' => false]);
                $lightSide = false;
            }
        }

        if ($this->request->getQuery('eligible')) {
            $inventories->where(['Ships.member IN' => $this->Ships->getUniqueMembers(65)]);
        }

        $ships = $this->Ships->getUniqueShips($lightSide);

        $roster = Hash::combine($inventories->toArray(), '{n}.ship', '{n}.stars', '{n}.member');

        $this->set('ships', $ships);
        $this->set(compact('roster'));
        $this->set('_serialize', ['roster']);
    }

    public function level()
    {
        $inventories = $this->Ships
            ->find()
            ->order([
                'Ships.member' => 'asc',
                'Ships.ship' => 'asc',
            ]);

        $lightSide = null;
        if ($this->request->getQuery('side')) {
            if (strtolower($this->request->getQuery('side')) == 'light') {
                $inventories->where(['Ships.light_side' => true]);
                $lightSide = true;
            } elseif (strtolower($this->request->getQuery('side')) == 'dark') {
                $inventories->where(['Ships.light_side' => false]);
                $lightSide = false;
            }
        }

        if ($this->request->getQuery('eligible')) {
            $inventories->where(['Ships.member IN' => $this->Ships->getUniqueMembers(65)]);
        }

        $ships = $this->Ships->getUniqueShips($lightSide);

        $roster = Hash::combine($inventories->toArray(), '{n}.ship', '{n}.level', '{n}.member');

        $this->set('ships', $ships);
        $this->set(compact('roster'));
        $this->set('_serialize', ['roster']);
    }

    public function average()
    {
        $ships = $this->Ships->find();
        $ships
            ->select(['Ships.ship', 'star_avg' => $ships->func()->avg('Ships.stars')])
            ->group([
                'Ships.ship'
            ])
            ->order(['star_avg' => 'asc']);

        $lightSide = null;
        if ($this->request->getQuery('side')) {
            if (strtolower($this->request->getQuery('side')) == 'light') {
                $ships->where(['Ships.light_side' => true]);
                $lightSide = true;
            } elseif (strtolower($this->request->getQuery('side')) == 'dark') {
                $ships->where(['Ships.light_side' => false]);
                $lightSide = false;
            }
        }

        $this->set('ships', $ships);
        $this->set('_serialize', ['ships']);
    }

    public function ships()
    {
        $ships = $this->Ships->getUniqueShips();
        $this->set('ships', $ships);
        $this->set('_serialize', ['ships']);
    }

    public function members()
    {
        $members = $this->Ships->getUniqueMembers();
        $this->set('members', $members);
        $this->set('_serialize', ['members']);
    }

    public function ship($shipId = null)
    {
        $ship = $this->Ships
            ->find()
            ->where([
                'Ships.ship' => $shipId
            ])
            ->order([
                'Ships.member' => 'asc',
            ]);

        $this->set('shipId', $shipId);
        $this->set('ship', $ship);
        $this->set('_serialize', ['ship']);
    }

    public function member($memberId = null)
    {
        $member = $this->Ships
            ->find()
            ->where([
                'Ships.member' => $memberId
            ])
            ->order([
                'Ships.ship' => 'asc',
            ]);

        $this->set('memberId', $memberId);
        $this->set('member', $member);
        $this->set('_serialize', ['member']);
    }


}

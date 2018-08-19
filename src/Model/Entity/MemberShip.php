<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * MemberShip Entity
 *
 * @property int $id
 * @property int $member_id
 * @property int $ship_id
 * @property int $level
 * @property int $stars
 * @property \Cake\I18n\FrozenTime $created
 * @property \Cake\I18n\FrozenTime $modified
 *
 * @property \App\Model\Entity\Member $member
 * @property \App\Model\Entity\Ship $ship
 */
class MemberShip extends Entity
{

    /**
     * Fields that can be mass assigned using newEntity() or patchEntity().
     *
     * Note that when '*' is set to true, this allows all unspecified fields to
     * be mass assigned. For security purposes, it is advised to set '*' to false
     * (or remove it), and explicitly make individual fields accessible as needed.
     *
     * @var array
     */
    protected $_accessible = [
        'member_id' => true,
        'ship_id' => true,
        'level' => true,
        'stars' => true,
        'created' => true,
        'modified' => true,
        'member' => true,
        'ship' => true
    ];
}

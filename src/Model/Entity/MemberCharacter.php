<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * MemberCharacter Entity
 *
 * @property int $id
 * @property int $member_id
 * @property int $character_id
 * @property int $level
 * @property int $stars
 * @property int $gear
 * @property \Cake\I18n\FrozenTime $created
 * @property \Cake\I18n\FrozenTime $modified
 *
 * @property \App\Model\Entity\Member $member
 * @property \App\Model\Entity\Character $character
 */
class MemberCharacter extends Entity
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
        'character_id' => true,
        'level' => true,
        'stars' => true,
        'gear' => true,
        'created' => true,
        'modified' => true,
        'member' => true,
        'character' => true
    ];
}

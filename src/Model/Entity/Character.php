<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;
use Cake\Utility\Hash;
use Cake\Utility\Inflector;

/**
 * Character Entity
 *
 * @property int $id
 * @property string $name
 * @property int $light_side
 *
 * @property \App\Model\Entity\MemberCharacter[] $member_characters
 * @property \App\Model\Entity\Faction[] $factions
 */
class Character extends Entity
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
        'name' => true,
        'light_side' => true,
        'member_characters' => true,
        'factions' => true
    ];

    protected function _getFactionList()
    {
        if ($this->has('factions')) {
            return join(', ', Hash::extract($this->factions, '{n}.name'));
        }

        return null;
    }

    protected function _getSlug()
    {
        return strtolower(Inflector::slug($this->name));
    }
}

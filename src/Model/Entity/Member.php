<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * Member Entity
 *
 * @property int $id
 * @property int $guild_id
 * @property string $name
 * @property string $swgoh_name
 * @property string $ally_code
 * @property \Cake\I18n\FrozenTime $created
 * @property \Cake\I18n\FrozenTime $modified
 *
 * @property \App\Model\Entity\Guild $guild
 * @property \App\Model\Entity\MemberCharacter[] $member_characters
 * @property \App\Model\Entity\MemberShip[] $member_ships
 */
class Member extends Entity
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
        'guild_id' => true,
        'name' => true,
        'swgoh_name' => true,
        'ally_code' => true,
        'created' => true,
        'modified' => true,
        'guild' => true,
        'member_characters' => true,
        'member_ships' => true
    ];

    protected function _getUrl()
    {
        return 'https://swgoh.gg/u/' . $this->swgoh_name . '/';
    }

    protected function _getCharactersUrl()
    {
        return 'https://swgoh.gg/u/' . $this->swgoh_name . '/collection/';
    }

    protected function _getShipsUrl()
    {
        return 'https://swgoh.gg/u/' . $this->swgoh_name . '/ships/';
    }
}

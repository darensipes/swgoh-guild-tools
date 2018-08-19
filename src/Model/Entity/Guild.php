<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * Guild Entity
 *
 * @property int $id
 * @property string $name
 * @property string $slug
 *
 * @property \App\Model\Entity\Member[] $members
 */
class Guild extends Entity
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
        'slug' => true,
        'members' => true
    ];

    protected function _getUrl()
    {
        return 'https://swgoh.gg/g/' . $this->swgoh_number . '/' . $this->slug . '/';
    }
}

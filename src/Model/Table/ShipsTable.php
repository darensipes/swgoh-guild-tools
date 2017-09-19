<?php
namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Utility\Hash;
use Cake\Validation\Validator;

/**
 * Ships Model
 *
 * @method \App\Model\Entity\Ships get($primaryKey, $options = [])
 * @method \App\Model\Entity\Ships newEntity($data = null, array $options = [])
 * @method \App\Model\Entity\Ships[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\Ships|bool save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\Ships patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\Ships[] patchEntities($entities, array $data, array $options = [])
 * @method \App\Model\Entity\Ships findOrCreate($search, callable $callback = null, $options = [])
 *
 * @mixin \Cake\ORM\Behavior\TimestampBehavior
 */
class ShipsTable extends Table
{

    /**
     * Initialize method
     *
     * @param array $config The configuration for the Table.
     * @return void
     */
    public function initialize(array $config)
    {
        parent::initialize($config);

        $this->setTable('ships');
        $this->setDisplayField('member');
        $this->setPrimaryKey(['member', 'ship']);

        $this->addBehavior('Timestamp');
    }

    /**
     * Default validation rules.
     *
     * @param \Cake\Validation\Validator $validator Validator instance.
     * @return \Cake\Validation\Validator
     */
    public function validationDefault(Validator $validator)
    {
        $validator
            ->scalar('member')
            ->allowEmpty('member', 'create');

        $validator
            ->scalar('ship')
            ->allowEmpty('ship', 'create');

        $validator
            ->integer('level')
            ->requirePresence('level', 'create')
            ->notEmpty('level');

        $validator
            ->integer('stars')
            ->requirePresence('stars', 'create')
            ->notEmpty('stars');

        $validator
            ->integer('power')
            ->requirePresence('power', 'create')
            ->notEmpty('power');

        $validator
            ->integer('max_power')
            ->requirePresence('max_power', 'create')
            ->notEmpty('max_power');

        return $validator;
    }

    public function getUniqueMembers()
    {
        $members = $this
             ->find()
             ->select(['Ships.member'])
             ->group(['Ships.member'])
             ->orderAsc('Ships.member')
             ->hydrate(false)
             ->toArray();

        return Hash::extract($members, '{n}.member');
    }

    public function getUniqueShips($lightSide = null)
    {
        $ships = $this
             ->find()
             ->select(['Ships.ship'])
             ->group(['Ships.ship'])
             ->orderAsc('Ships.ship')
             ->hydrate(false);

        if ($lightSide === true) {
            $ships->where(['Ships.light_side' => true]);
        } elseif ($lightSide === false) {
            $ships->where(['Ships.light_side' => false]);
        }

        return Hash::extract($ships->toArray(), '{n}.ship');
    }
}

<?php
namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Utility\Hash;
use Cake\Validation\Validator;

/**
 * Roster Model
 *
 * @method \App\Model\Entity\Roster get($primaryKey, $options = [])
 * @method \App\Model\Entity\Roster newEntity($data = null, array $options = [])
 * @method \App\Model\Entity\Roster[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\Roster|bool save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\Roster patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\Roster[] patchEntities($entities, array $data, array $options = [])
 * @method \App\Model\Entity\Roster findOrCreate($search, callable $callback = null, $options = [])
 *
 * @mixin \Cake\ORM\Behavior\TimestampBehavior
 */
class RosterTable extends Table
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

        $this->setTable('roster');
        $this->setDisplayField('member');
        $this->setPrimaryKey(['member', 'toon']);

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
            ->scalar('toon')
            ->allowEmpty('toon', 'create');

        $validator
            ->integer('level')
            ->requirePresence('level', 'create')
            ->notEmpty('level');

        $validator
            ->integer('stars')
            ->requirePresence('stars', 'create')
            ->notEmpty('stars');

        $validator
            ->integer('gear')
            ->requirePresence('gear', 'create')
            ->notEmpty('gear');

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

    public function getUniqueMembers($level = 0)
    {
        $members = $this
             ->find()
             ->select(['Roster.member'])
             ->group(['Roster.member'])
             ->where(['Roster.level >=' => $level])
             ->orderAsc('Roster.member')
             ->hydrate(false)
             ->toArray();

        return Hash::extract($members, '{n}.member');
    }

    public function getUniqueToons($lightSide = null)
    {
        $toons = $this
             ->find()
             ->select(['Roster.toon'])
             ->group(['Roster.toon'])
             ->orderAsc('Roster.toon')
             ->hydrate(false);

        if ($lightSide === true) {
            $toons->where(['Roster.light_side' => true]);
        } elseif ($lightSide === false) {
            $toons->where(['Roster.light_side' => false]);
        }

        return Hash::extract($toons->toArray(), '{n}.toon');
    }
}

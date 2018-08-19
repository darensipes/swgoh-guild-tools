<?php
namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * Ships Model
 *
 * @property \App\Model\Table\MemberShipsTable|\Cake\ORM\Association\HasMany $MemberShips
 * @property \App\Model\Table\FactionsTable|\Cake\ORM\Association\BelongsToMany $Factions
 *
 * @method \App\Model\Entity\Ship get($primaryKey, $options = [])
 * @method \App\Model\Entity\Ship newEntity($data = null, array $options = [])
 * @method \App\Model\Entity\Ship[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\Ship|bool save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\Ship|bool saveOrFail(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\Ship patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\Ship[] patchEntities($entities, array $data, array $options = [])
 * @method \App\Model\Entity\Ship findOrCreate($search, callable $callback = null, $options = [])
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
        $this->setDisplayField('name');
        $this->setPrimaryKey('id');

        $this->hasMany('MemberShips', [
            'foreignKey' => 'ship_id'
        ]);
        $this->belongsToMany('Factions', [
            'foreignKey' => 'ship_id',
            'targetForeignKey' => 'faction_id',
            'joinTable' => 'factions_ships'
        ]);
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
            ->integer('id')
            ->allowEmpty('id', 'create');

        $validator
            ->scalar('name')
            ->maxLength('name', 150)
            ->requirePresence('name', 'create')
            ->notEmpty('name');

        $validator
            ->boolean('light_side')
            ->allowEmpty('light_side');

        return $validator;
    }
}

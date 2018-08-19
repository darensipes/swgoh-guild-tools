<?php
namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * Factions Model
 *
 * @property \App\Model\Table\CharactersTable|\Cake\ORM\Association\BelongsToMany $Characters
 * @property \App\Model\Table\ShipsTable|\Cake\ORM\Association\BelongsToMany $Ships
 *
 * @method \App\Model\Entity\Faction get($primaryKey, $options = [])
 * @method \App\Model\Entity\Faction newEntity($data = null, array $options = [])
 * @method \App\Model\Entity\Faction[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\Faction|bool save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\Faction|bool saveOrFail(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\Faction patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\Faction[] patchEntities($entities, array $data, array $options = [])
 * @method \App\Model\Entity\Faction findOrCreate($search, callable $callback = null, $options = [])
 */
class FactionsTable extends Table
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

        $this->setTable('factions');
        $this->setDisplayField('name');
        $this->setPrimaryKey('id');

        $this->belongsToMany('Characters', [
            'foreignKey' => 'faction_id',
            'targetForeignKey' => 'character_id',
            'joinTable' => 'factions_characters'
        ]);
        $this->belongsToMany('Ships', [
            'foreignKey' => 'faction_id',
            'targetForeignKey' => 'ship_id',
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
            ->maxLength('name', 45)
            ->requirePresence('name', 'create')
            ->notEmpty('name');

        return $validator;
    }
}

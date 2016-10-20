<?php
namespace BitKiller\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * Exchanges Model
 *
 * @method \BitKiller\Model\Entity\Exchange get($primaryKey, $options = [])
 * @method \BitKiller\Model\Entity\Exchange newEntity($data = null, array $options = [])
 * @method \BitKiller\Model\Entity\Exchange[] newEntities(array $data, array $options = [])
 * @method \BitKiller\Model\Entity\Exchange|bool save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \BitKiller\Model\Entity\Exchange patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \BitKiller\Model\Entity\Exchange[] patchEntities($entities, array $data, array $options = [])
 * @method \BitKiller\Model\Entity\Exchange findOrCreate($search, callable $callback = null)
 */
class ExchangesTable extends Table
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

        $this->table('exchanges');
        $this->displayField('id');
        $this->primaryKey('id');
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
            ->requirePresence('uuid', 'create')
            ->notEmpty('uuid')
            ->add('uuid', 'unique', ['rule' => 'validateUnique', 'provider' => 'table']);

        $validator
            ->requirePresence('time', 'create')
            ->notEmpty('time');

        $validator
            ->allowEmpty('type');

        return $validator;
    }

    /**
     * Returns a rules checker object that will be used for validating
     * application integrity.
     *
     * @param \Cake\ORM\RulesChecker $rules The rules object to be modified.
     * @return \Cake\ORM\RulesChecker
     */
    public function buildRules(RulesChecker $rules)
    {
        $rules->add($rules->isUnique(['uuid']));

        return $rules;
    }
}

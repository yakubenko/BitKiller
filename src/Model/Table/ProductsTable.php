<?php
namespace BitKiller\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * Products Model
 *
 * @property \Cake\ORM\Association\BelongsTo $Categories
 * @property \Cake\ORM\Association\BelongsTo $Vendors
 * @property \Cake\ORM\Association\BelongsTo $ParentProducts
 * @property \Cake\ORM\Association\HasMany $Prices
 * @property \Cake\ORM\Association\HasMany $ChildProducts
 *
 * @method \BitKiller\Model\Entity\Product get($primaryKey, $options = [])
 * @method \BitKiller\Model\Entity\Product newEntity($data = null, array $options = [])
 * @method \BitKiller\Model\Entity\Product[] newEntities(array $data, array $options = [])
 * @method \BitKiller\Model\Entity\Product|bool save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \BitKiller\Model\Entity\Product patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \BitKiller\Model\Entity\Product[] patchEntities($entities, array $data, array $options = [])
 * @method \BitKiller\Model\Entity\Product findOrCreate($search, callable $callback = null)
 *
 * @mixin \Cake\ORM\Behavior\TimestampBehavior
 */
class ProductsTable extends Table
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

        $this->table('products');
        $this->displayField('title');
        $this->primaryKey('id');

        $this->addBehavior('Timestamp');

        $this->belongsTo('Categories', [
            'foreignKey' => 'category_id',
            'joinType' => 'INNER',
            'className' => 'BitKiller.Categories'
        ]);
        $this->belongsTo('Vendors', [
            'foreignKey' => 'vendor_id',
            'className' => 'BitKiller.Vendors'
        ]);
        $this->belongsTo('ParentProducts', [
            'className' => 'BitKiller.Products',
            'foreignKey' => 'parent_id'
        ]);
        $this->hasMany('Prices', [
            'foreignKey' => 'product_id',
            'className' => 'BitKiller.Prices'
        ]);
        $this->hasMany('ChildProducts', [
            'className' => 'BitKiller.Products',
            'foreignKey' => 'parent_id'
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
            ->requirePresence('title', 'create')
            ->notEmpty('title')
            ->add('title', 'unique', ['rule' => 'validateUnique', 'provider' => 'table']);

        $validator
            ->allowEmpty('slug')
            ->add('slug', 'unique', ['rule' => 'validateUnique', 'provider' => 'table']);

        $validator
            ->allowEmpty('extcode');

        $validator
            ->requirePresence('type', 'create')
            ->notEmpty('type');

        $validator
            ->integer('active')
            ->allowEmpty('active');

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
        $rules->add($rules->isUnique(['title']));
        $rules->add($rules->isUnique(['slug']));
        $rules->add($rules->existsIn(['category_id'], 'Categories'));
        $rules->add($rules->existsIn(['vendor_id'], 'Vendors'));
        $rules->add($rules->existsIn(['parent_id'], 'ParentProducts'));

        return $rules;
    }
}

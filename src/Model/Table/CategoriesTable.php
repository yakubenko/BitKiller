<?php
namespace BitKiller\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * Categories Model
 *
 * @property \Cake\ORM\Association\HasMany $Products
 *
 * @method \BitKiller\Model\Entity\Category get($primaryKey, $options = [])
 * @method \BitKiller\Model\Entity\Category newEntity($data = null, array $options = [])
 * @method \BitKiller\Model\Entity\Category[] newEntities(array $data, array $options = [])
 * @method \BitKiller\Model\Entity\Category|bool save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \BitKiller\Model\Entity\Category patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \BitKiller\Model\Entity\Category[] patchEntities($entities, array $data, array $options = [])
 * @method \BitKiller\Model\Entity\Category findOrCreate($search, callable $callback = null)
 *
 * @mixin \Cake\ORM\Behavior\TimestampBehavior
 */
class CategoriesTable extends Table
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

        $this->table('categories');
        $this->displayField('title');
        $this->primaryKey('id');

        $this->addBehavior('Timestamp');

        $this->hasMany('Products', [
            'foreignKey' => 'category_id',
            'className' => 'BitKiller.Products'
        ]);
		
		$this->belongsTo('Exchanges',[
			'className' => 'Bitkiller.Exchanges',
			'foreignKey' => 'exchanges_uuid',
			'bindingKey' => 'uuid'
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
            ->allowEmpty('id', 'create')
            ->add('id', 'unique', ['rule' => 'validateUnique', 'provider' => 'table']);

        $validator
            ->integer('parent')
            ->allowEmpty('parent');

        $validator
            ->integer('active')
            ->allowEmpty('active');

        $validator
            ->requirePresence('title', 'create')
            ->notEmpty('title')
            ->add('title', 'unique', ['rule' => 'validateUnique', 'provider' => 'table']);

        $validator
            ->requirePresence('slug', 'create')
            ->notEmpty('slug')
            ->add('slug', 'unique', ['rule' => 'validateUnique', 'provider' => 'table']);

        $validator
            ->allowEmpty('extcode');

        $validator
            ->integer('elements_count')
            ->allowEmpty('elements_count');

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
        $rules->add($rules->isUnique(['id']));
        $rules->add($rules->isUnique(['title']));
        $rules->add($rules->isUnique(['slug']));

        return $rules;
    }


	public function processUpload($categories,$uuid)
	{
		$res = [];
		
		foreach($categories as $category) {
			if(!empty($category['id'])) {
				try {
					$oldCategory = $this->get($category['id']);
				} catch (\Cake\Datasource\Exception\RecordNotFoundException $ex) {
					$res['errors'][] = 'Element '.$category['id'].' '.$ex->getMessage();
					continue;
				}
				
			} elseif(!empty($category['extcode'])) {
				$oldCategory = $this->find()->where(['extcode'=>$category['extcode']])->first();
			}
			
			$category['exchanges_uuid'] = $uuid;
			
			$categoryEntity = (!empty($oldCategory))?$this->patchEntity($oldCategory, $category):$this->newEntity($category);
			
			if($this->save($categoryEntity)) {
				$res['categories']['uploaded'][] = 'Category '.$category['title'].' saved/updated with id';
			} else {
				$res['categories']['errors'][] = 'Category '.$category['title'].' coud not be saved/updated';
			}
		}
		
		return $res;
	}
}

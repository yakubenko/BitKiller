<?php
namespace BitKiller\Controller\Api;

use BitKiller\Controller\AppController;
use Cake\Filesystem\File;

/**
 * Categories Controller
 *
 * @property \BitKiller\Model\Table\CategoriesTable $Categories
 */
class CategoriesController extends AppController
{
	public function initialize() 
	{
		parent::initialize();
		
		if(!$this->request->is('json')) {
			$this->response->statusCode(403);
			echo "Only JSON requests are allowed";
			$this->autoRender = false;
			exit(1);
		}
	}
	
    public function index()
    {
		
		$categories = $this->Categories->find('all')->contain(['Exchanges'])->toArray();
		$response['categories'] = $categories;
		
		$this->set(compact('response'));
		$this->set('_serialize', ['response']);
		
    }

	
    public function view($id = null)
    {
        try {
			$category = $this->Categories->get($id, [
				'contain' => ['Products']
			]);
			
			$response['category'] = $category;
			
		} catch(\Cake\Datasource\Exception\RecordNotFoundException $e) {
			$this->response->statusCode(404);
			$response['error'] = "Category with id ".$id." does not exist";
			$response['category'] = [];
		}
		
        $this->set('response', $response);
        $this->set('_serialize', ['response']);
    }

    /**
     * Add method
     *
     * @return \Cake\Network\Response|void Redirects on successful add, renders view otherwise.
     */
    public function add()
    {	
		$response = [];
		
		if($this->request->is('post')) {
			$catalog = FALSE;
			$catalogField = $this->request->data('catalog');
			
			if(is_array($catalogField) && !empty($catalogField['tmp_name'])) {
				$file = new File($catalogField['tmp_name']);
				$catalog = json_decode($file->read(),true);
				
			} elseif(!empty($this->request->data('catalog'))) {
				$catalog = json_decode($this->request->data('catalog'),true);
			}
			
			if($catalog && is_array($catalog['categories'])) {
				$response['catalog_found'] = 'yes';
				$response['catalog_cnt'] = count($catalog['categories']);
				$response['exchange_uuid'] = $this->request->uuid;
				
				$exchangeEntity = $this->Categories->Exchanges->newEntity([
					'uuid' => $this->request->uuid,
					'type' => 'categories'
				]);
				$this->Categories->Exchanges->save($exchangeEntity);
				
				$response['upload_result'] = $this->Categories->processUpload($catalog['categories'],  $this->request->uuid);
				$this->response->statusCode(201);
				
			} else {
				$this->response->statusCode(400);
				$response['error'] = 'There is no any categories in recieved request';
			}
		}
		
		$this->set('response', $response);
		$this->set('_serialize', ['response']);
    }

    /**
     * Edit method
     *
     * @param string|null $id Category id.
     * @return \Cake\Network\Response|void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $response = [];
		
		try {
			$category = $this->Categories->get($id, [
				'contain' => []
			]);
			
		} catch (\Cake\Datasource\Exception\RecordNotFoundException $ex) {
			$response['error'] = "Category with id ".$id." could not be found";
			$this->response->statusCode(404);
			$this->set(compact('response'));
			$this->set('_serialize', ['response']);
			return;
		}
		
		$newCategory = $this->request->input('json_decode',true);
		
        if ($this->request->is(['patch', 'put']) && !empty($newCategory['category']['title'])) {
			$newCategory['category']['exchanges_uuid'] = $this->request->uuid;
            $category = $this->Categories->patchEntity($category, $newCategory['category']);
			
			
            if ($this->Categories->save($category)) {
				$this->Categories->Exchanges->save($this->Categories->Exchanges->newEntity([
					'uuid'=>$this->request->uuid,
					'type'=>'category_edit'
				]));
				
				$this->response->statusCode(200);
                $response['category'] = $category;
            } else {
				$this->response->statusCode(500);
                $response['error'] = "Category with id ".$id." coud not be updated with received data";
            }
			
        } else {
			$this->response->statusCode(400);
			$response['error'] = "Did not received any data";
		}
		
        $this->set(compact('response'));
        $this->set('_serialize', ['response']);
    }

    /**
     * Delete method
     *
     * @param string|null $id Category id.
     * @return \Cake\Network\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $category = $this->Categories->get($id);
        if ($this->Categories->delete($category)) {
            $this->Flash->success(__('The category has been deleted.'));
        } else {
            $this->Flash->error(__('The category could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }
}

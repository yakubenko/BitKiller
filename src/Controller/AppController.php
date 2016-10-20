<?php
namespace BitKiller\Controller;

use Cake\Controller\Controller;
use Cake\Event\Event;
use Cake\Utility\Text;

class AppController extends Controller {
	
	public function initialize()
    {
        parent::initialize();

        $this->loadComponent('RequestHandler');
        $this->loadComponent('Flash');
		
		$this->request->uuid = Text::uuid();
    }
}

<?php
App::uses('AppController', 'Controller');
/**
 * Customers Controller
 *
 * @property Customer $Customer
 * @property PaginatorComponent $Paginator
 * @property SessionComponent $Session
 */
class CustomersController extends AppController {

    public $uses = array('Customer', 'CustomerLocation');
/**
 * Components
 *
 * @var array
 */
	public $components = array('Paginator', 'Session');

/**
 * index method
 *
 * @return void
 */
	public function index() {
		$this->Customer->recursive = 0;
        if ($this->request->is('post')) {
            $search = $this->request->data['Customer']['search'];
            $this->Paginator->settings = array(
                'conditions' => array('OR' => ['Customer.name ILIKE' => "%{$search}%", 'Customer.name_en ILIKE' => "%{$search}%"]),
                'limit' => 10
            );
        }
        $this->Paginator->settings['conditions']['enable !='] ='D';
        $this->Paginator->settings['order'] = array('Customer.name');
		$this->set('customers', $this->Paginator->paginate());
	}

/**
 * view method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function view($id = null) {
		if (!$this->Customer->exists($id)) {
			throw new NotFoundException(__('Invalid customer'));
		}
		$options = array('conditions' => array('Customer.' . $this->Customer->primaryKey => $id));
		$this->set('customer', $this->Customer->find('first', $options));
	}

/**
 * add method
 *
 * @return void
 */
	public function add() {
		if ($this->request->is('post')) {
			$this->Customer->create();
			if ($this->Customer->save($this->request->data)) {
				$this->Session->setFlash(__('The customer has been saved.'));
				return $this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The customer could not be saved. Please, try again.'));
			}
		}
	}

/**
 * edit method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function edit($id = null) {
		if (!$this->Customer->exists($id)) {
			throw new NotFoundException(__('Invalid customer'));
		}
		if ($this->request->is(array('post', 'put'))) {
			if ($this->Customer->save($this->request->data)) {
				$this->Session->setFlash(__('The customer has been saved.'));
				return $this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The customer could not be saved. Please, try again.'));
			}
		} else {
			$options = array('conditions' => array('Customer.' . $this->Customer->primaryKey => $id));
			$this->request->data = $this->Customer->find('first', $options);
		}
	}

/**
 * delete method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function delete($id = null) {
		$this->Customer->id = $id;
		if (!$this->Customer->exists()) {
			throw new NotFoundException(__('Invalid customer'));
		}
		$data = [];
        $data['Customer']['id'] = $id;
        $data['Customer']['enable'] = 'D';
		if ($this->Customer->save($data)) {
			$this->Session->setFlash(__('The customer has been deleted.'));
		} else {
			$this->Session->setFlash(__('The customer could not be deleted. Please, try again.'));
		}
		return $this->redirect(array('action' => 'index'));
	}
    
    public function locations($id = null) {
        $this->Customer->id = $id;
		if (!$this->Customer->exists()) {
			throw new NotFoundException(__('Invalid customer'));
		}
        $this->set('customer_id', $id);
        $this->set('locations', $this->CustomerLocation->find('all', array('conditions'=>array('customer_id'=>$id, 'enable !='=>'D'), 'order'=>array('branch_name', 'zone_name'))));
    }
    
    public function add_location($id = null) {
        $this->Customer->id = $id;
		if (!$this->Customer->exists()) {
			throw new NotFoundException(__('Invalid customer'));
		}
        $this->set('customer_id', $id);
        if ($this->request->is(array('post', 'put'))) {
			if ($this->CustomerLocation->save($this->request->data)) {
				$this->Session->setFlash(__('The customer location has been saved.'));
				return $this->redirect(array('action' => 'locations', $id));
			} else {
				$this->Session->setFlash(__('The customer location could not be saved. Please, try again.'));
			}
		}
    }
    
    public function edit_location($id = null, $location_id){
        $this->Customer->id = $id;
		if (!$this->Customer->exists()) {
			throw new NotFoundException(__('Invalid customer'));
		}
        $this->CustomerLocation->id = $location_id;
		if (!$this->CustomerLocation->exists()) {
			throw new NotFoundException(__('Invalid customer location'));
		}
        $this->set('customer_id', $id);
        if ($this->request->is(array('post', 'put'))) {
			if ($this->CustomerLocation->save($this->request->data)) {
				$this->Session->setFlash(__('The customer location has been saved.'));
				return $this->redirect(array('action' => 'locations', $id));
			} else {
				$this->Session->setFlash(__('The customer location could not be saved. Please, try again.'));
			}
		} else {
			$options = array('conditions' => array('CustomerLocation.' . $this->CustomerLocation->primaryKey => $location_id));
			$this->request->data = $this->CustomerLocation->find('first', $options);
		}
    }
    
    public function del_location($id = null, $location_id) {
		$this->Customer->id = $id;
		if (!$this->Customer->exists()) {
			throw new NotFoundException(__('Invalid customer'));
		}
        $this->CustomerLocation->id = $location_id;
		if (!$this->CustomerLocation->exists()) {
			throw new NotFoundException(__('Invalid customer location'));
		}

        $data = [];
        $data['CustomerLocation']['id'] = $location_id;
        $data['CustomerLocation']['enable'] = 'D';
		if ($this->CustomerLocation->save($data)) {
			$this->Session->setFlash(__('The customer location has been deleted.'));
		} else {
			$this->Session->setFlash(__('The customer location could not be deleted. Please, try again.'));
		}
		return $this->redirect(array('action' => 'locations', $id));
	}
}

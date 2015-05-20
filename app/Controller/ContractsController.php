<?php
App::uses('AppController', 'Controller');
/**
 * Contracts Controller
 *
 * @property Contract $Contract
 * @property PaginatorComponent $Paginator
 * @property SessionComponent $Session
 */
class ContractsController extends AppController {

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
	public function index($status = 'A') {
		$this->Contract->recursive = 0;
        if ($this->request->is('post')) {
            $search = $this->request->data['Contract']['search'];
            $options['conditions']['OR'] = [
                            'Serial.serial_no ILIKE'=>"%{$search}%",
                            'Product.name ILIKE'=>"%{$search}%",
                            'Customer.name ILIKE'=>"%{$search}%"
                        ];
        }
        
        $options['order'] = ['contract_expire DESC'];
        $options['limit'] = 10;
		$this->set('contracts', $this->Contract->find('all', $options));
	}

/**
 * view method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function view($id = null) {
		if (!$this->Contract->exists($id)) {
			throw new NotFoundException(__('Invalid contract'));
		}
		$options = array('conditions' => array('Contract.' . $this->Contract->primaryKey => $id));
		$this->set('contract', $this->Contract->find('first', $options));
	}

/**
 * add method
 *
 * @return void
 */
	public function add() {
		if ($this->request->is('post')) {
			$this->Contract->create();
			if ($this->Contract->save($this->request->data)) {
				$this->Session->setFlash(__('The contract has been saved.'));
				return $this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The contract could not be saved. Please, try again.'));
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
		if (!$this->Contract->exists($id)) {
			throw new NotFoundException(__('Invalid contract'));
		}
		if ($this->request->is(array('post', 'put'))) {
			if ($this->Contract->save($this->request->data)) {
				$this->Session->setFlash(__('The contract has been saved.'));
				return $this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The contract could not be saved. Please, try again.'));
			}
		} else {
			$options = array('conditions' => array('Contract.' . $this->Contract->primaryKey => $id));
			$this->request->data = $this->Contract->find('first', $options);
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
		$this->Contract->id = $id;
		if (!$this->Contract->exists()) {
			throw new NotFoundException(__('Invalid contract'));
		}
		$this->request->allowMethod('post', 'delete');
		if ($this->Contract->delete()) {
			$this->Session->setFlash(__('The contract has been deleted.'));
		} else {
			$this->Session->setFlash(__('The contract could not be deleted. Please, try again.'));
		}
		return $this->redirect(array('action' => 'index'));
	}
}

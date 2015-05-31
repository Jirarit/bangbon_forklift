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
	public $helpers = array('Flag');

/**
 * index method
 *
 * @return void
 */
	public function index() {
		$this->Contract->recursive = 0;
        if ($this->request->is('post')) {
            $search = $this->request->data['Contract']['search'];
            $this->Paginator->settings = array(
                'conditions' => array('OR' => array(
                                                'Customer.name ILIKE' => "%{$search}%", 
                                                'Customer.name_en ILIKE' => "%{$search}%",
                                                'Product.name ILIKE' => "%{$search}%", 
                                                'Serial.serial_no ILIKE' => "%{$search}%"
                                            )),
                'limit' => 10
            );
            if(isset($this->request->data['Contract']['status'])){
                $this->Paginator->settings['conditions']['Contract.status'] = $this->request->data['Contract']['status'];
            }
            if(isset($this->request->data['Contract']['start_form'])){
                $this->Paginator->settings['conditions']['Contract.contract_date >='] = $this->request->data['Contract']['start_form'];
            }
            if(isset($this->request->data['Contract']['start_to'])){
                $this->Paginator->settings['conditions']['Contract.contract_date <='] = $this->request->data['Contract']['start_to'];
            }
            if(isset($this->request->data['Contract']['expire_form'])){
                $this->Paginator->settings['conditions']['Contract.contract_date >='] = $this->request->data['Contract']['expire_form'];
            }
            if(isset($this->request->data['Contract']['expire_to'])){
                $this->Paginator->settings['conditions']['Contract.contract_date <='] = $this->request->data['Contract']['expire_to'];
            }
        }
        $this->Paginator->settings['joins'] = array(
                                                array(
                                                    "table" => "info.product_serials",
                                                    "alias" => "Serial",
                                                    "type" => "LEFT",
                                                    "conditions" => array(
                                                        "Contract.product_serial_id = Serial.id"
                                                    )
                                                ),
                                                array(
                                                    "table" => "info.products",
                                                    "alias" => "Product",
                                                    "type" => "LEFT",
                                                    "conditions" => array(
                                                        "Contract.product_id = Product.id"
                                                    )
                                                ),
                                                array(
                                                    "table" => "info.customers",
                                                    "alias" => "Customer",
                                                    "type" => "LEFT",
                                                    "conditions" => array(
                                                        "Contract.customer_id = Customer.id"
                                                    )
                                                ),
                                            );
        $this->Paginator->settings['order'] = array('Contract.contract_date');
		$this->set('contracts', $this->Paginator->paginate());
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
		$products = $this->Contract->Serial->productWithSerial();
		$customers = $this->Contract->CustomerLocation->customerWithLocation();
		$this->set(compact('products', 'customers'));
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
		$products = $this->Contract->Serial->productWithSerial();
		$customers = $this->Contract->CustomerLocation->customerWithLocation();
		$this->set(compact('products', 'customers'));
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

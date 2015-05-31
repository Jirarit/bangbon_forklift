<?php
App::uses('AppController', 'Controller');
/**
 * ProductBrands Controller
 *
 * @property ProductBrand $ProductBrand
 * @property PaginatorComponent $Paginator
 * @property SessionComponent $Session
 */
class ProductBrandsController extends AppController {

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
		$this->ProductBrand->recursive = 0;
        if ($this->request->is('post')) {
            $search = $this->request->data['ProductBrand']['search'];
            $this->Paginator->settings = array(
                'conditions' => array('OR' => array('ProductBrand.name ILIKE' => "%{$search}%", 'ProductBrand.name_en ILIKE' => "%{$search}%")),
                'limit' => 10
            );
        }
        $this->Paginator->settings['conditions']['ProductBrand.enable !='] = 'D';
        $this->Paginator->settings['order'] = array('ProductBrand.name');
		$this->set('productBrands', $this->Paginator->paginate());
	}

/**
 * view method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function view($id = null) {
		if (!$this->ProductBrand->exists($id)) {
			throw new NotFoundException(__('Invalid product brand'));
		}
		$options = array('conditions' => array('ProductBrand.' . $this->ProductBrand->primaryKey => $id));
		$this->set('productBrand', $this->ProductBrand->find('first', $options));
	}

/**
 * add method
 *
 * @return void
 */
	public function add() {
		if ($this->request->is('post')) {
			$this->ProductBrand->create();
			if ($this->ProductBrand->save($this->request->data)) {
				$this->Session->setFlash(__('The product brand has been saved.'));
				return $this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The product brand could not be saved. Please, try again.'));
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
		if (!$this->ProductBrand->exists($id)) {
			throw new NotFoundException(__('Invalid product brand'));
		}
		if ($this->request->is(array('post', 'put'))) {
			if ($this->ProductBrand->save($this->request->data)) {
				$this->Session->setFlash(__('The product brand has been saved.'));
				return $this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The product brand could not be saved. Please, try again.'));
			}
		} else {
			$options = array('conditions' => array('ProductBrand.' . $this->ProductBrand->primaryKey => $id));
			$this->request->data = $this->ProductBrand->find('first', $options);
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
		$this->ProductBrand->id = $id;
		if (!$this->ProductBrand->exists()) {
			throw new NotFoundException(__('Invalid product brand'));
		}
		$data = array();
        $data['ProductBrand']['id'] = $id;
        $data['ProductBrand']['enable'] = 'D';
		if ($this->ProductBrand->save($data)) {
			$this->Session->setFlash(__('The product brand has been deleted.'));
		} else {
			$this->Session->setFlash(__('The product brand could not be deleted. Please, try again.'));
		}
		return $this->redirect(array('action' => 'index'));
	}
}

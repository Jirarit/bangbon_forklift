<?php
App::uses('AppController', 'Controller');
/**
 * ProductCategories Controller
 *
 * @property ProductCategory $ProductCategory
 * @property PaginatorComponent $Paginator
 * @property SessionComponent $Session
 */
class ProductCategoriesController extends AppController {

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
		$this->ProductCategory->recursive = 0;
        if ($this->request->is('post')) {
            $search = $this->request->data['ProductCategory']['search'];
            $this->Paginator->settings = array(
                'conditions' => array('OR' => ['ProductCategory.name ILIKE' => "%{$search}%", 'ProductCategory.name_en ILIKE' => "%{$search}%"]),
                'limit' => 10
            );
        }
        $this->Paginator->settings['order'] = array('ProductCategory.name');
		$this->set('productCategories', $this->Paginator->paginate());
	}

/**
 * view method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function view($id = null) {
		if (!$this->ProductCategory->exists($id)) {
			throw new NotFoundException(__('Invalid product category'));
		}
		$options = array('conditions' => array('ProductCategory.' . $this->ProductCategory->primaryKey => $id));
		$this->set('productCategory', $this->ProductCategory->find('first', $options));
	}

/**
 * add method
 *
 * @return void
 */
	public function add() {
		if ($this->request->is('post')) {
			$this->ProductCategory->create();
			if ($this->ProductCategory->save($this->request->data)) {
				$this->Session->setFlash(__('The product category has been saved.'));
				return $this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The product category could not be saved. Please, try again.'));
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
		if (!$this->ProductCategory->exists($id)) {
			throw new NotFoundException(__('Invalid product category'));
		}
		if ($this->request->is(array('post', 'put'))) {
			if ($this->ProductCategory->save($this->request->data)) {
				$this->Session->setFlash(__('The product category has been saved.'));
				return $this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The product category could not be saved. Please, try again.'));
			}
		} else {
			$options = array('conditions' => array('ProductCategory.' . $this->ProductCategory->primaryKey => $id));
			$this->request->data = $this->ProductCategory->find('first', $options);
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
		$this->ProductCategory->id = $id;
		if (!$this->ProductCategory->exists()) {
			throw new NotFoundException(__('Invalid product category'));
		}
		//$this->request->allowMethod('post', 'delete');
		if ($this->ProductCategory->delete()) {
			$this->Session->setFlash(__('The product category has been deleted.'));
		} else {
			$this->Session->setFlash(__('The product category could not be deleted. Please, try again.'));
		}
		return $this->redirect(array('action' => 'index'));
	}
}

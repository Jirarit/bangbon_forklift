<?php
App::uses('AppController', 'Controller');
/**
 * Products Controller
 *
 * @property Product $Product
 * @property PaginatorComponent $Paginator
 * @property SessionComponent $Session
 */
class ProductsController extends AppController {

    public $uses = array('Product', 'ProductCategory', 'ProductProperty', 'ProductBrand', 'ProductSerial');
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
	public function index($category = 'ALL') {
        $this->Session->delete('ADD_PRODUCT');
		$this->Product->recursive = 0;
        if ($this->request->is('post')) {
            $search = $this->request->data['Product']['search'];
            $this->Paginator->settings = array(
                'conditions' => array('OR' => ['Product.name ILIKE' => "%{$search}%", 'Product.name_en ILIKE' => "%{$search}%"]),
                'limit' => 10
            );
        }
        $this->Paginator->settings['conditions']['Product.enable !='] = 'D';
        $this->Paginator->settings['order'] = array('Customer.name');
		$this->set('products', $this->Paginator->paginate());
	}

/**
 * view method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function view($id = null) {
		if (!$this->Product->exists($id)) {
			throw new NotFoundException(__('Invalid product'));
		}
		$options = array('conditions' => array('Product.' . $this->Product->primaryKey => $id));
		$this->set('product', $this->Product->find('first', $options));
	}
    
    public function view_property($id = null) {
        $product = $this->Product->findById($id);
		if (empty($product)) {
			throw new NotFoundException(__('Invalid product'));
		}
        $this->ProductProperty->useProperty($product['Category']['code']);
        $property = $this->ProductProperty->findById($id);
		$this->set('product_id', $id);
		$this->set('product', $product);
		$this->set('property', $property);
	}
    
    public function view_serial($id = null) {
        $product = $this->Product->findById($id);
		if (empty($product)) {
			throw new NotFoundException(__('Invalid product'));
		}
		$this->set('product_id', $id);
		$this->set('product', $product);
		$this->set('serials', $this->ProductSerial->find('all', array('conditions'=>['product_id'=>$id, 'status !='=>'D'], 'order'=>'serial_no')));
	}

/**
 * add method
 *
 * @return void
 */
	public function add() {
		if ($this->request->is('post')) {
            $this->Session->write('ADD_PRODUCT.Product', $this->request->data['Product']);
            $this->Session->write('ADD_PRODUCT.Property.code', $this->ProductCategory->field('code',['id'=>$this->request->data['Product']['category_id']]));
			return $this->redirect(array('action' => 'add_property'));
		}
        $this->request->data = $this->Session->read('ADD_PRODUCT');
        if(empty($this->request->data['Product']['price'])) $this->request->data['Product']['price'] = '0.00';
        if(empty($this->request->data['Product']['cost'])) $this->request->data['Product']['cost'] = '0.00';
        $this->set('category_opt', $this->ProductCategory->find('list',array('conditions'=>['enable'=>'Y'], 'order'=>['sort', 'name'])));
        $this->set('brand_opt', $this->ProductBrand->find('list',array('conditions'=>['enable'=>'Y'], 'order'=>['name'])));
	}

    public function add_property() {
        $session_data = $this->Session->read('ADD_PRODUCT');
        if(empty($session_data['Product']['category_id']) || empty($session_data['Property']['code'])){
            return $this->redirect(array('action' => 'add'));
        }

        if ($this->request->is('post')) {
            $this->Session->write("ADD_PRODUCT.Property", $this->request->data['Property']);
			return $this->redirect(array('action' => 'add_serial'));
		}
        $this->request->data['Property'] = $session_data['Property'];
	}
    
    public function add_serial() {
        $session_data = $this->Session->read('ADD_PRODUCT');
        if(empty($session_data['Product']) || empty($session_data['Property'])){
            return $this->redirect(array('action' => 'add_property'));
        }
        
        $this->set('serials', (empty($session_data['Serial']) ? [] : $session_data['Serial']));
    }
    
    public function add_serial_rm($serial_key){
        $this->Session->delete('ADD_PRODUCT.Serial.'.$serial_key);
        $this->Session->write('ADD_PRODUCT.Serial',array_values($this->Session->read('ADD_PRODUCT.Serial')));
        return $this->redirect(array('action' => 'add_serial'));
    }
    
    public function add_serial_add(){
        if ($this->request->is('post')) {
            $serial = $this->Session->read('ADD_PRODUCT.Serial');
            if(empty($serial)) $serial = [];
            array_push($serial, $this->request->data['Serial']);
            $this->Session->write('ADD_PRODUCT.Serial', $serial);
            return $this->redirect(array('action' => 'add_serial'));
		}
    }
    
    public function submit_add() {
        $data = $this->Session->read('ADD_PRODUCT');
        if(empty($data['Product']) || empty($data['Property'])){
            $this->Session->setFlash(__('Invalid data.'));
            return $this->redirect(array('action' => 'add_serial'));
        }
        
        $productSource = $this->Product->getDataSource();
        $productSource->begin();
        
        $d = [];
        $d['Product'] = $data['Product'];
        if(!$this->Product->save($d)){
            $this->Session->setFlash(__('The product cannot create.'));
            return $this->redirect(array('action' => 'add'));
        }
        $product_id = $this->Product->id;
        
        $d = [];
        $d = $data['Property'];
        $d['id'] = $product_id;
        $this->ProductProperty->useProperty($data['Property']['code']);
        if(!$this->ProductProperty->save($d)){
            $this->Session->setFlash(__('The product property cannot create.'));
            return $this->redirect(array('action' => 'add_property'));
        }
        
        if(!empty($data['Serial'])){
            foreach($data['Serial'] as $k => $serial){
                $d = [];
                $d['ProductSerial']['product_id'] = $product_id;
                $d['ProductSerial']['serial_no'] = $serial['no'];
                $d['ProductSerial']['manufacture_date'] = $serial['date'];
                $d['ProductSerial']['status'] = $serial['status'];
                $this->ProductSerial->create();
                if(!$this->ProductSerial->save($d)){
                    $this->Session->setFlash(__('Serial '.$serial['no'].' cannot create.'));
                    $this->Session->write("ADD_PRODUCT.Serial.{$k}.error", 'error');
                    return $this->redirect(array('action' => 'add_serial'));
                }else{
                    $this->Session->delete("ADD_PRODUCT.Serial.{$k}.error");
                }
            }
        }
        
        $productSource->commit();
        $this->Session->setFlash(__('The product has been saved.'));
        $this->Session->delete("ADD_PRODUCT");
        return $this->redirect(array('action' => 'index'));
    }

/**
 * edit method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function edit($id = null) {
		if (!$this->Product->exists($id)) {
			throw new NotFoundException(__('Invalid product'));
		}
		if ($this->request->is(array('post', 'put'))) {
			if ($this->Product->save($this->request->data)) {
				$this->Session->setFlash(__('The product has been saved.'));
				return $this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The product could not be saved. Please, try again.'));
			}
		} else {
			$options = array('conditions' => array('Product.' . $this->Product->primaryKey => $id));
			$this->request->data = $this->Product->find('first', $options);
		}
        $this->set('category_opt', $this->ProductCategory->find('list',array('conditions'=>['enable'=>'Y'], 'order'=>['sort', 'name'])));
        $this->set('brand_opt', $this->ProductBrand->find('list',array('conditions'=>['enable'=>'Y'], 'order'=>['name'])));
	}

    public function edit_property($id = null) {
        $product = $this->Product->findById($id);
        if (empty($product)) {
			throw new NotFoundException(__('Invalid product'));
		}
        
        $this->ProductProperty->useProperty($product['Category']['code']);
        $property = $this->ProductProperty->findById($id);
        if (empty($property)) {
			throw new NotFoundException(__('Invalid property'));
		}
        
		if ($this->request->is(array('post', 'put'))) {
			if ($this->ProductProperty->save($this->request->data['Property'])) {
				$this->Session->setFlash(__('The property has been updated.'));
				return $this->redirect(array('action' => 'view_property', $id));
			} else {
				$this->Session->setFlash(__('The property could not be updated. Please, try again.'));
			}
		} else {
			$this->request->data['Property'] = $property['ProductProperty'];
		}
        $this->set('product_id', $id);
        $this->set('product', $product);
	}

    public function create_serial($product_id = null) {
        return $this->redirect(array('action' => 'view_serial', $product_id));
	}

    public function update_serial($product_id = null) {
        if ($this->request->is(array('post', 'put'))) {
            if(!$this->ProductSerial->save($this->request->data['Serial'])){
                $this->Session->setFlash(__('The serial could not be updated. Please, try again.'));
                return $this->redirect(array('action' => 'view_serial', $product_id));
            }
        }
        $this->Session->setFlash(__('The serial has been updated.'));
        return $this->redirect(array('action' => 'view_serial', $product_id));
	}
    
    public function delete_serial($product_id, $serial_id){
        $this->Product->id = $product_id;
		if (!$this->Product->exists()) {
			throw new NotFoundException(__('Invalid product'));
		}
        $data = [];
        $data['ProductSerial']['id'] = $serial_id;
        $data['ProductSerial']['status'] = 'D';
		if ($this->ProductSerial->save($data)) {
			$this->Session->setFlash(__('The serial has been deleted.'));
		} else {
			$this->Session->setFlash(__('The serial could not be deleted. Please, try again.'));
		}
        return $this->redirect(array('action' => 'view_serial', $product_id));
    }
    
    public function activity($product_id, $serial_id) {
        $this->Product->id = $product_id;
		if (!$this->Product->exists()) {
			throw new NotFoundException(__('Invalid product'));
		}
        $this->ProductSerial->id = $serial_id;
		if (!$this->ProductSerial->exists()) {
			throw new NotFoundException(__('Invalid serial'));
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
		$this->Product->id = $id;
		if (!$this->Product->exists()) {
			throw new NotFoundException(__('Invalid product'));
		}
        $data = [];
        $data['Product']['id'] = $id;
        $data['Product']['enable'] = 'D';
		if ($this->Product->save($data)) {
			$this->Session->setFlash(__('The product has been deleted.'));
		} else {
			$this->Session->setFlash(__('The product could not be deleted. Please, try again.'));
		}
		return $this->redirect(array('action' => 'index'));
	}
}

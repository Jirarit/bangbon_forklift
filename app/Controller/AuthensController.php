<?php
App::uses('AppController', 'Controller');
/**
 * Description of AuthensController
 *
 * @author Win
 */
class AuthensController extends AppController{
    
    public $uses = array("User");
    
    public $autoLogin = array('root', 'password');
    
    public function login() {
        $this->layout = FALSE;
        
        if ($this->request->is('post')) {
            $login = $this->request->data['User']['login'];
            $pass = md5(md5($this->request->data['User']['password']));
            $remember_me = @$this->request->data['User']['remember_me'];
        }elseif(!empty($this->autoLogin) && count($this->autoLogin) === 2){
            $login = $this->autoLogin[0];
            $pass = md5(md5($this->autoLogin[1]));
            $remember_me = FALSE;
        }

        if(isset($login)){
            $user = $this->User->find('first', array('conditions'=>array('User.login'=>$login)));
            if(empty($user) || 'D' === $user['User']['enable']){
                $this->Session->setFlash(__('* Invalie user.'));
                return $this->redirect(array('action' => 'login'));
            }
            
            if($pass != $user['User']['pass']){
                $this->Session->setFlash(__('* Password wrong.'));
                return $this->redirect(array('action' => 'login'));
            }
            
            $user = array_replace($user['UserProfile'], $user['User']);
            $this->Session->write('USER', $user);
            
            if($remember_me == 'on'){
                $this->Cookie->write('USER', $user, TRUE, '10 days');
            }
            
            return $this->redirect(array('controller'=>'Home', 'action' => 'index'));
        }
    }
    
    public function logout() {
        $this->Session->destroy();
        $this->Cookie->destroy();
        $this->redirect(array('action'=>'login'));
    }
}

<?php
/**
 * Application level Controller
 *
 * This file is application-wide controller file. You can put all
 * application-wide controller-related methods here.
 *
 * CakePHP(tm) : Rapid Development Framework (http://cakephp.org)
 * Copyright (c) Cake Software Foundation, Inc. (http://cakefoundation.org)
 *
 * Licensed under The MIT License
 * For full copyright and license information, please see the LICENSE.txt
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright     Copyright (c) Cake Software Foundation, Inc. (http://cakefoundation.org)
 * @link          http://cakephp.org CakePHP(tm) Project
 * @package       app.Controller
 * @since         CakePHP(tm) v 0.2.9
 * @license       http://www.opensource.org/licenses/mit-license.php MIT License
 */

App::uses('Controller', 'Controller');

/**
 * Application Controller
 *
 * Add your application-wide methods in the class below, your controllers
 * will inherit them.
 *
 * @package		app.Controller
 * @link		http://book.cakephp.org/2.0/en/controllers.html#the-app-controller
 */
class AppController extends Controller {
    var $uses = array('Menu');
    var $components = array('Session', 'Cookie', 'RequestHandler');
    
    var $ignoreSession = array('CakeError::*', 'Authens::*');
    
    var $loginPage = "Authens::login";
    
    public function beforeFilter() {
        parent::beforeFilter();

        /* Use Cookie if Session not exist */
        if($this->Session->check('USER') === FALSE && $this->Cookie->check('USER') === TRUE){
            $this->Session->write("USER", $this->Cookie->read("USER"));
        }

        /* Check Session and redirect page */
        $page = array("{$this->name}::$this->action", "{$this->name}::*", "*::*");
        if($this->Session->check('USER') === TRUE && in_array($this->loginPage, $page)){
            /* Session exists and current page = login page => redirect to Home */
            $this->redirect(array('controller'=>'Home', 'action'=>'index'));
        }elseif($this->Session->check('USER') === FALSE && array_intersect($this->ignoreSession, $page) === array()){
            /* Session not exists and current page require session => redirect to Login */
            $this->redirect(array('controller'=>'Authens', 'action'=>'login'));
        }

        /* Set left menus */
        $this->set('menus', $this->Menu->accessible_menu('L'));

        /* Handle mobile */
        $is_mobile = $this->RequestHandler->isMobile();
        $this->set('is_mobile', $is_mobile);
    }
}

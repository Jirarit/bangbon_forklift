<?php
/* {{{
 * CHANGE LOGs
 * 
 * 150411.0923          First create file upload component                  WIN
}}} */
App::uses('Component', 'Controller');

class FileUploadComponent extends Component {

    public $components = array();

    /**
     * URL to file location
     * Full link for access to file
     *
     * @access private
     * @var string link
     * Ex. http://localhost/files
     */
    private $_url = NULL;

    /**
     * Path to buffer location
     * Local diractory for contain file before file server pulling
     *
     * @access private
     * @var string path
     */
    private $_path2file = NULL;

    /**
     * Enable debug request and response
     *
     * @access private
     * @var boolean
     */
    private $_debug = FALSE;
    
    public function initialize(Controller $controller) {
        $config = Configure::read('FileUpload');
        $this->_url = isset($config['url']) ? $config['url'] : FULL_BASE_URL . DS . "files";
        $this->_path2file = isset($config['path2file']) ? $config['path2file'] : ROOT . DS . "files";
        $this->_debug = isset($config['debug']) ? $config['debug'] : $this->_debug;
    }
    
    public function enableDebug(){
        $this->_debug = TRUE;
    }

    public function collect($class, $file_info, $description = "") { /*{{{
     * class = P=Public / T=Protect / E=Encrypt
     * 1. Prepare data
     * 2. Move file to collect path
     */
        $file_name = $this->generateName();
        $link2file = $this->_url . "/" . $file_name;
        $path2file = $this->_path2file . DS . $file_name;

        $file['class'] = $class;
        $file['name'] = pathinfo($file_info['name'], PATHINFO_FILENAME);
        $file['ext'] = pathinfo($file_info['name'], PATHINFO_EXTENSION);
        $file['size'] = $file_info['size'];
        $file['mime'] = $file_info['type'];
        $file['description'] = $description;
        $file['link2file'] = $link2file;
        
        rename($file_info['tmp_name'], $path2file);
        chmod($path2file, 0777);

        return $file;
    } /* }}} */
    
    private function generateName(){
        list($d, $t) = explode(':',date('ymd:His'));
        $m = sprintf("%06d",reset(explode(' ', microtime())) * 100000);
        return $d . DS . $d . $t . $m;
    }
}
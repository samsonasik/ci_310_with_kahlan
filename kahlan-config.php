<?php
// ./kahlan-config.php
use Kahlan\Filter\Filter;
 
define('CI_VERSION', '3.1.0');
define('ENVIRONMENT', 'development');
define('APPPATH', 'application/');
define('VIEWPATH', 'application/views/');
define('BASEPATH', 'system/');
 
require_once BASEPATH . 'core/Common.php';
function &get_instance()
{
    return CI_Controller::get_instance();
}
 
Filter::register('ci.autoloader', function($chain) {
    $this->autoloader()->addClassMap([
        // core
        'CI_Controller' =>  BASEPATH . 'core/Controller.php',
        'CI_Uri' =>  BASEPATH . 'core/URI.php',
        'CI_Model' => BASEPATH . 'core/Model.php',
        
        // controllers
        'Welcome' => APPPATH . 'controllers/Welcome.php',
        
        // models
        'Welcome_model' => APPPATH . 'models/Welcome_model.php',
    ]);
    return $chain->next();
});
Filter::apply($this, 'namespaces', 'ci.autoloader');
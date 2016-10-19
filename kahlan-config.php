<?php
// ./kahlan-config.php
use Kahlan\Filter\Filter;
use Kahlan\Reporter\Coverage;
use Kahlan\Reporter\Coverage\Driver\Xdebug;
 
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

Filter::register('kahlan.coverage', function($chain) {
    
    if (!extension_loaded('xdebug')) {
        return;
    }
    
    $reporters = $this->reporters();
    $coverage = new Coverage([
        'verbosity' => $this->commandLine()->get('coverage'),
        'driver'    => new Xdebug(),
        'path'      => 'application',
        'colors'    => !$this->commandLine()->get('no-colors'),
        'exclude'   => [
            'application/views/errors/cli/*.php',
            'application/views/errors/html/*.php',
            'application/config/*.php',
        ],
    ]);
    
    $reporters->add('coverage', $coverage);
});
Filter::apply($this, 'coverage', 'kahlan.coverage');
 
Filter::register('ci.autoloader', function($chain) {
    $this->autoloader()->addClassMap([
        // core
        'CI_Controller' =>  BASEPATH . 'core/Controller.php',
        'CI_URI'        =>  BASEPATH . 'core/URI.php',
        'CI_Model'      => BASEPATH . 'core/Model.php',
        
        // controllers
        'Welcome'       => APPPATH . 'controllers/Welcome.php',
        
        // models
        'Welcome_model' => APPPATH . 'models/Welcome_model.php',
    ]);
    return $chain->next();
});
Filter::apply($this, 'namespaces', 'ci.autoloader');
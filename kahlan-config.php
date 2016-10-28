<?php
// ./kahlan-config.php
use Composer\Autoload\ClassMapGenerator;
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
    $this->autoloader()->addClassMap(
        ClassMapGenerator::createMap(BASEPATH . 'core')
    );
    $this->autoloader()->addClassMap(
        ClassMapGenerator::createMap(APPPATH . 'controllers')
    );
    $this->autoloader()->addClassMap(
        ClassMapGenerator::createMap(APPPATH . 'models')
    );
    
    return $chain->next();
});
Filter::apply($this, 'namespaces', 'ci.autoloader');
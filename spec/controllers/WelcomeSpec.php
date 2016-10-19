<?php
 
use Kahlan\Plugin\Double;
 
describe('Welcome', function () {
      
    describe('->index()', function () {
          
        it('contains welcome message to specific passed name parameter', function() {
            define('UTF8_ENABLED', TRUE); // used by CI_Uri    

            allow('is_cli')->toBeCalled()->andReturn(false); // to disable _parse_argv call
            $uri = Double::instance(['extends' => 'CI_Uri']);
            allow($uri)->toReceive('segment')->with(3)->andReturn('samsonasik');
            
            $welcome_model = Double::instance(['extends' => 'Welcome_model']);
            allow($welcome_model)->toReceive('greeting')->with('samsonasik')->andReturn('Hello samsonasik');
                        
            $controller = new Welcome();                         
            $controller->uri  = $uri;
            $controller->welcome = $welcome_model;
             
            ob_start();
            $controller->index();
            $actual = ob_get_clean();
              
            expect($actual)->toContain('Hello samsonasik, Welcome to CodeIgniter!');
              
        });
    });
      
});
<?php
  
describe('Welcome_model', function () {
      
    describe('->greeting()', function () {
          
        it('return "Hello Guest" if passed parameter of greeting is empty string', function() {
            
            $expected = 'Hello Guest';
            
            $model = new Welcome_model();
            $actual = $model->greeting('');
            
            expect($actual)->toBe($expected);
              
        });
        
        it('return "Hello $name" if passed $name parameter of greeting is not empty string', function() {
            
            $name = 'samsonasik';
            $expected = 'Hello ' . $name;
            
            $model = new Welcome_model();
            $actual = $model->greeting($name);
            
            expect($actual)->toBe($expected);
              
        });
        
    });
      
});
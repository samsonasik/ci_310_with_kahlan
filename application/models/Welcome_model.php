<?php

class Welcome_model extends CI_Model
{
    public function __construct()
    {
        parent::__construct();
    }
    
    public function greeting($name)
    {
        if (trim($name) === '') {
            return 'Hello Guest';
        }
        
        return 'Hello ' . $name;
    }
}
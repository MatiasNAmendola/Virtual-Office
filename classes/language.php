<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

class language
{
    private $lang;
    
    function __construct(){
        $this->lang = include('/var/office.mihaelisaev.com/language/ru.php');
    }

    public function get($key){
        return array_key_exists($key, $this->lang) ? $this->lang[$key] : '';
    }
}
?>

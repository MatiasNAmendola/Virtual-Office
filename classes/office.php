<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of office
 *
 * @author Mihael
 */
class office {
    
    private $AUTHORIZATION;
    private $DBSCHEMA;
    private $DB;
    
    public function __construct() {
        $this->AUTHORIZATION = new authorization();
        $this->DBSCHEMA = new dbSchema();
        $this->DB = new mysqliDB();
        $this->SESSION_USERS_TAG = $this->DBSCHEMA->TABLE_USERS;
    }
    
    public function getCurrentOfficeInfo(){
        return $this->DB->selectRow("SELECT * FROM office WHERE Id=?",1);
    }
    
        
}

?>

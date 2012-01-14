<?php

/**
 * Staff
 *
 * @author Mihael Isaev
 */
class staff {
    const USER_EMAIL = 0;
    const USER_LOGIN = 1;
    
    private $authorization;
    private $DB_SCHEMA;
    private $DB;
    public  $SESSION_USERS_TAG;
    public  $ORGANIZATION_ID;
    
    /**
     * Constructor
     */
    public function __construct()
    {
        $this->authorization = new authorization();
        $this->DB_SCHEMA = new dbSchema();
        $this->DB = new mysqliDB();
        $this->SESSION_USERS_TAG = $this->DB_SCHEMA->TABLE_USERS;
        $this->ORGANIZATION_ID = $SESSION[$this->SESSION_USERS_TAG][IdOrganization];
    }
    
    /**
     * Get any info about staff
     * @param type USER_*
     * @return type String/int
     */
    public function getInfo($key){
        switch($key){
            case $this::USER_EMAIL:
                return $_SESSION[$this->authorization->SESSION_USERS_TAG][Email];
                break;
            case $this::USER_LOGIN:
                return $_SESSION[$this->authorization->SESSION_USERS_TAG][Login];
                break;
        }
    }
    
    /**
     * Add new department 
     */
    public function addDepartment($name){
        
    }
    
    /**
     * Add new post 
     */
    public function addPost($name){
        
    }
    
    /**
     * Add new staff 
     */
    public function addStaff(){
        
    }
}

?>

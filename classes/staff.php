<?php

/**
 * Staff
 *
 * @author Mihael Isaev
 */
class staff {
    const STAFF_EMAIL      = 0;
    const STAFF_LOGIN      = 1;
    const STAFF_FIRSTNAME  = 2;
    const STAFF_SECONDNAME = 3;
    const STAFF_THIRDNAME  = 4;
    
    private $AUTHORIZATION;
    private $DBSCHEMA;
    private $DB;
    public  $SESSION_USERS_TAG;
    public  $IDORGANIZATION;
    
    /**
     * Constructor
     */
    public function __construct()
    {
        $this->AUTHORIZATION = new authorization();
        $this->DBSCHEMA = new dbSchema();
        $this->DB = new mysqliDB();
        $this->SESSION_USERS_TAG = $this->DBSCHEMA->TABLE_USERS;
        $this->IDORGANIZATION = $SESSION[$this->SESSION_USERS_TAG][IdOrganization];
    }
    
    /**
     * Get any info about staff
     * @param type STAFF_*
     * @return type String/int
     */
    public function getInfo($key){
        switch($key){
            case $this::STAFF_EMAIL:
                return $_SESSION[$this->AUTHORIZATION->SESSION_USERS_TAG][Email];
                break;
            case $this::STAFF_LOGIN:
                return $_SESSION[$this->AUTHORIZATION->SESSION_USERS_TAG][Login];
                break;
            case $this::STAFF_FIRSTNAME:
                return $_SESSION[$this->AUTHORIZATION->SESSION_USERS_TAG][NameFirst];
                break;
            case $this::STAFF_SECONDNAME:
                return $_SESSION[$this->AUTHORIZATION->SESSION_USERS_TAG][NameSecond];
                break;
            case $this::STAFF_THIRDNAME:
                return $_SESSION[$this->AUTHORIZATION->SESSION_USERS_TAG][NameThird];
                break;
        }
    }
    
    /**
     * Add new department
     * @return boolean true/false
     */
    public function addDepartment($name){
        $result = $db->insert("INSERT INTO ".$this->DBSCHEMA->TABLE_DEPARTMENTS
                             ." (".$this->DBSCHEMA->CELL_DEPARTMENTS_IDORGANIZATION
                             .", ".$this->DBSCHEMA->CELL_DEPARTMENTS_NAME
                             .") VALUES (?,?)", 
                             $this->IDORGANIZATION,
                             $name);
        if(!$result)
            return false;
        else
            return true;
    }
    
    /**
     * Add new post 
     */
    public function addPost($name){
        $result = $db->insert("INSERT INTO ".$this->DBSCHEMA->TABLE_POSTS
                             ." (".$this->DBSCHEMA->CELL_POSTS_IDORGANIZATION
                             .", ".$this->DBSCHEMA->CELL_POSTS_NAME
                             .") VALUES (?,?)", 
                             $this->IDORGANIZATION,
                             $name);
        if(!$result)
            return false;
        else
            return true;
    }
    
    /**
     * Add new staff 
     */
    public function addStaff(){
        
    }
    
    /**
     * Get rooms is staff
     * @return array workplaces
     */
    public function getRooms($staff){
        $result = $db->selectRow('SELECT * FROM '.$this->DBSCHEMA->TABLE_WORKPLACE.' WHERE '.$this->DBSCHEMA->CELL_WORKPLACE_IDSTAFF.' = ?', $staff);

        if(!$result)
            return false;
        else
            return $result;
    }
}

?>

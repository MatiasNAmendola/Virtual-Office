<?php

/**
 * Workplace
 *
 * @author Alexandr Forofontov
 */
class workplace{
    private $AUTH;
    private $DBSCHEMA;
    private $DB;
    public  $SESSION_USERS_TAG;
    public  $IDORGANIZATION;
    private $STAFF;
    
    public function __construct()
    {
        $this->AUTH = new authorization();
        $this->DBSCHEMA = new dbSchema();
        $this->DB = new mysqliDB();
        $this->SESSION_USERS_TAG = $this->DBSCHEMA->TABLE_USERS;
        $this->STAFF = $_SESSION[$this->SESSION_USERS_TAG];
       // $this->IDORGANIZATION = $SESSION[$this->SESSION_USERS_TAG][IdOrganization];
    }
    
    public function getCountWorkplaces(){
        $this->DB->select("SELECT * FROM ".$this->DBSCHEMA->TABLE_WORKPLACE
                          ." WHERE "
                          .$this->DBSCHEMA->CELL_WORKPLACE_IDSTAFF."=?", $this->STAFF[Id]);
        return $this->DB->queryInfo[num_rows];
    }
}
?>

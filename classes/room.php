<?php

/**
 * Room
 *
 * @author Alexandr Forofontov
 */
class room{
    private $AUTHORIZATION;
    private $DBSCHEMA;
    private $DB;
    public  $SESSION_USERS_TAG;
    public  $IDORGANIZATION;
    public function __construct()
    {
      //  $this->AUTHORIZATION = new authorization();
        $this->DBSCHEMA = new dbSchema();
        $this->DB = new mysqliDB();
      //  $this->SESSION_USERS_TAG = $this->DBSCHEMA->TABLE_USERS;
       // $this->IDORGANIZATION = $SESSION[$this->SESSION_USERS_TAG][IdOrganization];
    }
    /**
     * Add new room 
     */
    public function addRoom($name,$parent){
       // return $this->DBSCHEMA->CELL_ROOMS_PARENT;
        
        $result = $this->DB->insert("INSERT INTO ".$this->DBSCHEMA->TABLE_ROOMS
                             ." (".$this->DBSCHEMA->CELL_ROOMS_NAME
                             .", ".$this->DBSCHEMA->CELL_ROOMS_PARENT
                             .") VALUES (?,?)", 
                             $name,
                             $parent);
        if(!$result)
            return false;
        else
            return true;
         
         
    }
}
?>

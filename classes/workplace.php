<?php

/**
 * Workplace
 *
 * @author Alexandr Forofontov
 */
class workplace{
    private $AUTHORIZATION;
    private $DBSCHEMA;
    private $DB;
    public  $SESSION_USERS_TAG;
    public  $IDORGANIZATION;
    public function __construct()
    {
        $this->AUTHORIZATION = new authorization();
        $this->DBSCHEMA = new dbSchema();
        $this->DB = new mysqliDB();
        $this->SESSION_USERS_TAG = $this->DBSCHEMA->TABLE_USERS;
       // $this->IDORGANIZATION = $SESSION[$this->SESSION_USERS_TAG][IdOrganization];
    }
    /**
     * Add new workplace 
     */
    public function addWorkplace($room,$staff){
        $result = $db->insert("INSERT INTO ".$this->DBSCHEMA->TABLE_WORKPLACE
                             ." (".$this->DBSCHEMA->CELL_WORKPLACE_IDROOM
                             .", ".$this->DBSCHEMA->CELL_WORKPLACE_IDSTAFF
                             .") VALUES (?,?)", 
                             $room,
                             $staff);
        if(!$result)
            return false;
        else
            return true;
    }
    /**
     * Get array of strings workplaces is room
     * @return array workplaces is room
     */
    public function getWorkplacesIsRoom($room){
        $result = $db->selectRow('SELECT * FROM '.$this->DBSCHEMA->TABLE_WORKPLACE.' WHERE '.$this->DBSCHEMA->CELL_WORKPLACE_IDROOM.' = ?', $room);

        if(!$result)
            return false;
        else
            return $result;
    }
}
?>

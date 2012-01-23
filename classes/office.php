<?php

/**
 * Class office
 *
 * @author Alexandr Forofontov
 */
class office{
    
    private $DBSCHEMA;
    private $DB;
    
    public function __construct()
    {
        $this->DBSCHEMA = new dbSchema();
        $this->DB = new mysqliDB();
    }
    /**
     * Add new office 
     * @param String $name
     * @param Integer $date (unix time)
     * @return boolean 
     */
    public function addOffice($name,$date){
       $result = $this->DB->insert("INSERT INTO ".$this->DBSCHEMA->TABLE_OFFICE
                             ." (".$this->DBSCHEMA->CELL_OFFICE_NAME
                             .", ".$this->DBSCHEMA->CELL_OFFICE_DATEREGISTER
                             .") VALUES (?,?)", 
                             $name,
                             $date);
        if(!$result)
            return false;
        else
            return true;
         
         
    }
}
?>

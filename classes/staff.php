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
    const STAFF_FULLNAME   = 5;
    
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
            case self::STAFF_EMAIL:
                return $_SESSION[$this->AUTHORIZATION->SESSION_USERS_TAG][Email];
                break;
            case self::STAFF_LOGIN:
                return $_SESSION[$this->AUTHORIZATION->SESSION_USERS_TAG][Login];
                break;
            case self::STAFF_FIRSTNAME:
                return $_SESSION[$this->AUTHORIZATION->SESSION_USERS_TAG][NameFirst];
                break;
            case self::STAFF_SECONDNAME:
                return $_SESSION[$this->AUTHORIZATION->SESSION_USERS_TAG][NameSecond];
                break;
            case self::STAFF_THIRDNAME:
                return $_SESSION[$this->AUTHORIZATION->SESSION_USERS_TAG][NameThird];
                break;
            case self::STAFF_FULLNAME:
                $stringBuffer = new StringBuffer();
                $stringBuffer->append($this->getInfo(self::STAFF_FIRSTNAME));
                $stringBuffer->append('&nbsp;');
                $stringBuffer->append($this->getInfo(self::STAFF_SECONDNAME));
                $stringBuffer->append('&nbsp;');
                $stringBuffer->append($this->getInfo(self::STAFF_THIRDNAME));
                return $stringBuffer->toString();
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
     * Get all workplace is staff
     * @param integer $staff 
     * @return array workplaces
     */
    public function getCountWorkplace($staff){
        $result = $this->DB->select('SELECT * FROM '.$this->DBSCHEMA->TABLE_WORKPLACE.' WHERE '.$this->DBSCHEMA->CELL_WORKPLACE_IDSTAFF.' = ?', $staff);
        if(!$result)
            return false;
        else
            return $result;
    }
    
    /**
     * Get workplace info by ID
     * @param integer $workplace 
     * @return array workplace
     */
    public function getWorkplaceInfoById($workplace){
        $result = $this->DB->selectRow('SELECT * FROM '.$this->DBSCHEMA->TABLE_WORKPLACE.' WHERE '.$this->DBSCHEMA->CELL_WORKPLACE_IDSTAFF.' = ?', $staff);

        if(!$result)
            return false;
        else
            return $result;
    }
    /**
     * Set "Id" current workplace 
     * @param integer $staff 
     * @param integer $workplace 
     * @return boolean
     */
    public function setCurrentWorkplaceId($staff,$workplace) {
        if (!$staff) return false;
        if (!$workplace) return false;
        $_SESSION[$staff]['CurrentWorkplace']=$workplace;
        return true;
    }
    /**
     * Get "Id" current workplace 
     * @param integer $staff 
     * @return integer - Id
     */
    public function getCurrentWorkplaceId($staff) {
        return $_SESSION[$staff]['CurrentWorkplace'];
    }
}

?>

<?

/**
 * Authorization and registration
 * Created by Isaev Mihael
 */

class authorization
{
    const STATE_LOGIN_EMPTY_LOGIN    = 0;
    const STATE_LOGIN_WRONG_LOGIN    = 1;
    const STATE_LOGIN_EMPTY_PASSWORD = 2;
    const STATE_LOGIN_SHORT_PASSWORD = 3;
    const STATE_LOGIN_WRONG_PASSWORD = 4;
    const STATE_LOGIN_SUCCESS        = 5;
    private $DB_SCHEMA;
    private $DB;
    
    /**
     * Constructor
     */
    public function __construct()
    {
        $this->DB_SCHEMA = new dbSchema();
        $this->DB = new mysqliDB();
    }
    
    /**
     * Function for check authorization state
     * for current user session
     * @return boolean true/false
     */
    public function checkAuthorization($session){
    
    }
    
    /**
     * Function for signIn user with login and password
     * @return STATE_LOGIN
     */
    public function login($login, $password){
      $this->DB->selectRow('SELECT * FROM '.$this->DB_SCHEMA->TABLE_USERS.' WHERE '.$this->DB_SCHEMA->CELL_USERS_LOGIN.' = ?', $login);
      
      if (!strlen(trim($login))){
        return STATE_LOGIN_EMPTY_LOGIN;
      }elseif(!$this->DB->queryInfo['num_rows']){
        return STATE_LOGIN_WRONG_LOGIN;
      }
      
      $passwordMD5 = md5($password);
      $this->DB->selectRow('SELECT * FROM '.$this->DB_SCHEMA->TABLE_USERS.' WHERE '.$this->DB_SCHEMA->CELL_USERS_LOGIN.' = ? AND '.$this->DB_SCHEMA->CELL_USERS_PASSWORD.' = ?', $login, $passwordMD5);
      
      if (!strlen($password)) {
        return STATE_LOGIN_EMPTY_PASSWORD;
      }elseif(strlen($password)<6){
        return STATE_LOGIN_SHORT_PASSWORD;
      }elseif(!$this->DB->queryInfo['num_rows']){
        return STATE_LOGIN_WRONG_PASSWORD;
      }
      
      return STATE_LOGIN_SUCCESS;
    }
    
    /**
     *
     *
     */
    public function logout(){
    
    }
    
    /**
     *
     *
     */
    public function register(){
    
    }
}
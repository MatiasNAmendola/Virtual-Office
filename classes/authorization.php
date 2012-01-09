<?

/**
 * Authorization and registration
 * Created by Isaev Mihael
 */

class authorization extends mysqliDB
{
    const STATE_LOGIN_EMPTY_LOGIN    = 0;
    const STATE_LOGIN_WRONG_LOGIN    = 1;
    const STATE_LOGIN_EMPTY_PASSWORD = 2;
    const STATE_LOGIN_SHORT_PASSWORD = 3;
    const STATE_LOGIN_WRONG_PASSWORD = 4;
    const STATE_LOGIN_SUCCESS        = 5;
    const DB_SCHEMA;
    
    /**
     * Constructor
     */
    public function __construct()
    {
        DB_SCHEMA = new dbSchema();
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
      $resultForLogin = parent::selectRow('SELECT * FROM '.DB_SCHEMA->TABLE_USERS.' WHERE '.DB_SCHEMA->CELL_USERS_LOGIN.' = ?', $login);
      
      if (!strlen(trim($login))){
        return STATE_LOGIN_EMPTY_LOGIN;
      }elseif(!parent::queryInfo['num_rows']){
        return STATE_LOGIN_WRONG_LOGIN;
      }
      
      $passwordMD5 = md5($password);
      $resultForLoginAndPassword = parent::selectRow('SELECT * FROM '.DB_SCHEMA->TABLE_USERS.' WHERE '.DB_SCHEMA->CELL_USERS_LOGIN.' = ? AND '.DB_SCHEMA->CELL_USERS_PASSWORD.' = ?', $login, $passwordMD5);
      
      if (!strlen($password)) {
        return STATE_LOGIN_EMPTY_PASSWORD;
      }elseif(strlen($password)<6){
        return STATE_LOGIN_SHORT_PASSWORD;
      }elseif(!parent::queryInfo['num_rows']){
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
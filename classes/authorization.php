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
    
    const LOGIN_BY_EMAIL             = 0;
    const LOGIN_BY_LOGIN             = 1;
    
    const REGISTRATION_STATUS_FREE   = 0;
    const REGISTRATION_STATUS_INVITE = 1;
    const REGISTRATION_STATUS_CLOSED = 2;
    
    private $DB_SCHEMA;
    private $DB;
    public  $SESSION_USERS_TAG;
    private $REGISTRATION_STATUS;
    private $L;
    
    /**
     * Constructor
     */
    public function __construct()
    {
        $this->DB_SCHEMA = new dbSchema();
        $this->DB = new mysqliDB();
        $this->SESSION_USERS_TAG = $this->DB_SCHEMA->TABLE_USERS;
        $this->REGISTRATION_STATUS = self::REGISTRATION_STATUS_INVITE;
        $this->L = new language();
    }
    
    /**
     * Registration status getter
     * @return int 0-2
     */
    public function getRegistrationStatus(){
        return $this->REGISTRATION_STATUS;
    }
    
    /**
     * Function for check authorization state
     * for current user session
     * @return boolean true/false
     */
    public function checkAuthorization(){
        if (!isset($_SESSION[$this->SESSION_USERS_TAG]))
            return false;
        else
            return true;
    }
    
    /**
     * Function for signIn user with login and password
     * @return STATE_LOGIN
     */
    public function login($userData, $loginBy){
      $return = array();
      $errors = 0;
      
      $login = $userData[login];
      $password = $userData[password];
      switch($loginBy){
          case $this::LOGIN_BY_EMAIL:
              $CELL_USERS_LOGIN = $this->DB_SCHEMA->CELL_USERS_EMAIL;
              break;
          case $this::LOGIN_BY_LOGIN:
              $CELL_USERS_LOGIN = $this->DB_SCHEMA->CELL_USERS_LOGIN;
              break;
          default:
              $CELL_USERS_LOGIN = $this->DB_SCHEMA->CELL_USERS_LOGIN;
      }
        
      $this->DB->selectRow('SELECT * FROM '.$this->DB_SCHEMA->TABLE_USERS.' WHERE '.$CELL_USERS_LOGIN.' = ?', $login);
      
      if (!strlen(trim($login)))
        $return[login] = $this->L->get('label_loginState_emptyLogin');
      elseif(!$this->DB->queryInfo['num_rows'])
        $return[login] = $this->L->get('label_loginState_wrongLogin');
      else $return[login] = '';
      
      $passwordMD5 = md5($password);
      $userInfo = $this->DB->selectRow('SELECT * FROM '.$this->DB_SCHEMA->TABLE_USERS.' WHERE '.$CELL_USERS_LOGIN.' = ? AND '.$this->DB_SCHEMA->CELL_USERS_PASSWORD.' = ?', $login, $passwordMD5);
      
      if (!strlen($password))
        $return[password] = $this->L->get('label_loginState_emptyPassword');
      elseif(strlen($password)<6)
        $return[password] = $this->L->get('label_loginState_lengthPassword');
      elseif(!$this->DB->queryInfo['num_rows'])
        $return[password] = $this->L->get('label_loginState_wrongPassword');
      else $return[password] = '';
      
      foreach ($return as $value)
        if(strlen($value))
          $errors++;
      
      if($errors>0)
          $return[status] = 'error';
      else
      {
          $this->setAuthorized($userInfo);
          $return[status] = 'success';
          $staff = new staff();
          $return[firstTime] = $staff->isFirstTime();
      }    
      
      return $return;
    }
    
    /**
     *
     *
     */
    public function logout(){
        session_destroy();
    }
    
    /**
     * Registration
     * @param Array user information
     */
    public function register($userData){
        $return = array();
        $errors = 0;
        
        $firstName          = $userData[firstName];
        $secondName         = $userData[secondName];
        $email              = $userData[email];
        $password           = $userData[password];
        $passwordConfirm    = $userData[passwordConfirm];
        $invite             = $userData[invite];
        $captcha            = $_SESSION[captcha_register][captcha_keystring];
        $captchaConfirm     = $userData[captchaConfirm];
        
        if (!strlen(trim($firstName)))
            $return[firstName] = 'Не указано имя';
        elseif(!preg_match('|^[a-zA-Zа-яёіїєґА-ЯЁІЇЄҐ-\s\-\(\)]+$|u', $firstName))
            $return[firstName] = 'Запрещенные символы в имени';
        else $return[firstName] = '';
        
        if (!strlen(trim($secondName)))
            $return[secondName] = 'Не указано имя';
        elseif(!preg_match('|^[a-zA-Zа-яёіїєґА-ЯЁІЇЄҐ-\s\-\(\)]+$|u', $secondName))
            $return[secondName] = 'Запрещенные символы в фамилии';
        else $return[secondName] = '';
        
        $this->DB->selectRow('SELECT * FROM staff WHERE Email = ?', $email);
        if (!strlen(trim($email)))
            $return[email] = 'Не указан email';
        elseif(!preg_match("/^[a-z0-9](([_\.-]?[a-z0-9]+)*){0,19}@([a-z0-9]([_-]?[a-z0-9]+)?\.){1,3}[a-z]{2,6}$/i", $email))
            $return[email] = 'Неверный формат email';
        elseif($this->DB->queryInfo[num_rows]>0)
            $return[email] = 'Данный email уже используется';
        else $return[email] = '';
        
        if (!strlen($password))
            $return[password] = 'Не указан пароль';
        elseif(strlen($password)<6)
            $return[password] = 'Длина пароля менее 6 символов';
        else $return[password]='';

        if (!strlen($passwordConfirm))
            $return[passwordConfirm] = 'Не указан повтор пароля';
        elseif($password !== $passwordConfirm)
            $return[passwordConfirm] = 'Пароли не совпадают';
        else $return[passwordConfirm]='';
        
        if ($this->getRegistrationStatus() == self::REGISTRATION_STATUS_INVITE)
            if(!strlen($invite))
                $return[invite] = 'Введите код приглашения';
            elseif(!$this->checkInvite($invite))
                $return[invite] = 'Неверный код';
            else $return[invite] = '';
        
        if (!strlen($captchaConfirm))
            $return[captchaConfirm] = 'Введите код защиты';
        elseif($captcha !== $captchaConfirm)
            $return[captchaConfirm] = 'Код защиты не совпадает';
        else $return[captchaConfirm]='';
        
        foreach ($return as $value)
            if(strlen($value))
                $errors++;
        
        if($errors>0)
            $return[status] = 'error';
        else{
            $password = md5($password);
            $insert = $this->DB->insert('INSERT INTO '.$this->DB_SCHEMA->TABLE_USERS.' ('.$this->DB_SCHEMA->CELL_USERS_EMAIL.',
                                                                                        '.$this->DB_SCHEMA->CELL_USERS_PASSWORD.',
                                                                                        '.$this->DB_SCHEMA->CELL_USERS_FIRST_NAME.',
                                                                                        '.$this->DB_SCHEMA->CELL_USERS_SECOND_NAME.') VALUES (?,?,?,?)', 
                                                                                                            $email, $password, $firstName, $secondName);
            if(!$insert)
                $return[status] = 'error';
            else{
                $newUser = $this->DB->selectRow('SELECT * FROM '.$this->DB_SCHEMA->TABLE_USERS.' WHERE Id=?', $this->DB->queryInfo[insert_id]);
                $this->setAuthorized($newUser);
                $return[status] = 'success';
            }
        }
        
        return $return;
    }
    
    public function checkInvite($invite){
        $this->DB->selectRow('SELECT * FROM invite WHERE Code=? AND Used=?', $invite, 0);
        if($this->DB->queryInfo[num_rows]>0)
            return true;
        else
            return false;
    }
    
    private function setAuthorized($userInfo){
        $_SESSION[$this->DB_SCHEMA->TABLE_USERS] = $userInfo;
    }
}
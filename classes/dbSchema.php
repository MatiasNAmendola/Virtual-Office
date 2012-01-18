<?

/**
 * Schema for db
 * constants with db tables names
 * Created by Isaev Mihael
 */

class dbSchema
{
    public $TABLE_USERS = 'staff';
    public $CELL_USERS_LOGIN    = 'Login';
    public $CELL_USERS_EMAIL    = 'Email';
    public $CELL_USERS_PASSWORD = 'Password';
    
    public $TABLE_DEPARTMENTS = 'departments';
    public $CELL_DEPARTMENTS_IDORGANIZATION    = 'IdOrganization';
    public $CELL_DEPARTMENTS_NAME              = 'Name';
    
    public $TABLE_POSTS = 'posts';
    public $CELL_POSTS_IDORGANIZATION    = 'IdOrganization';
    public $CELL_POSTS_NAME              = 'Name';
}
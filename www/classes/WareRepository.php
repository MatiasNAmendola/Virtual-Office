<?

/**
 * Класс "Организация"
 * 
 */

class WareRepository extends mysqliDB
{
    
    public function __construct()
    {
        parent::__construct();
    }
    
    public function __destruct()
    {
        parent::__destruct();
    }
    
    public function SelectById($id)
    {
        if (!intval($id))
            return false;
        
        $result = parent::selectRow('SELECT * FROM Organizations WHERE Id=?', $id);
        
        if (!$result || !$this->queryInfo['num_rows'])
            return false;
        return $result;
    }
    
    public function SelectByUserId($id)
    {
        if (!intval($id))
            return false;
        
        $result = parent::select('SELECT o.* FROM Organizations o 
			INNER JOIN OrganizationUsers ou ON ou.IdOrganization = o.Id
			WHERE ou.IdUser = ?
			ORDER BY o.FullName', $id);
        
        if (!$result || !$this->queryInfo['num_rows'])
            return false;
        return $result;
    }
    
    public function Update($id, $params = array())
    {
        if (!is_array($params) || !sizeof($params))
            return false;
		
		if (!$org = $this->SelectById($id))
			return false;
        
        $sql = 'UPDATE Organizations SET ';
        
        $sqlParams = array();
        foreach ($params as $param => $value) {
            $sqlParams[] = $param.' = ?';
        }
        
        $sql .= implode(', ', $sqlParams);
        
        $result = parent::update($sql, implode(', ', $params));

        if (!$result || !$this->queryInfo['affected_rows'])
            return false;
        return true;
    }
    
    public function Insert($params = array())
    {
        if (!is_array($params) || !sizeof($params))
            return false;
        
        $sql = 'INSERT INTO Organizations ';
        
        $sqlParams = array();
        foreach ($params as $param => $value) {
            $sqlParams[] = $param;
        }
        
        $sql .= '('.implode(', ', $sqlParams).') VALUES (%s)';
        
        $result = parent::insert($sql, implode(', ', $params));

        if (!$result || !$this->queryInfo['insert_id'])
            return false;
        return $this->queryInfo['insert_id'];
    }
    
    public function Delete($id)
    {
        if (!intval($id))
            return false;
        
		parent::transactionStart();
		
        $result = parent::delete('DELETE FROM Organizations WHERE Id = ?', $id);        
        if (!$result || !$this->queryInfo['affected_rows']) {
			parent::transactionRollBack();
            return false;
		}
		
		$result = parent::delete('DELETE FROM OrganizationUsers WHERE Id = ?', $id);
		if (!$result || !$this->queryInfo['affected_rows']) {
			parent::transactionRollBack();
            return false;
		}
		
		$result = parent::delete('DELETE FROM OrganizationStores WHERE Id = ?', $id);
		if (!$result || !$this->queryInfo['affected_rows']) {
			parent::transactionRollBack();
            return false;
		}
		
		parent::transactionCommit();
        return true;
    }
}
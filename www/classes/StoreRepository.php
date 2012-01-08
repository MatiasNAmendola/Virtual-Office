<?

/**
 * Класс "Склады"
 * 
 */

class StoreRepository extends mysqliDB
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
        
        $result = parent::selectRow('SELECT * FROM Stores WHERE Id=?', $id);
        
        if (!$result || !$this->queryInfo['num_rows'])
            return false;
        return $result;
    }
    
    public function SelectByUserId($id)
    {
        if (!intval($id))
            return false;
        
        $result = parent::select('SELECT s.* FROM Stores s 
			INNER JOIN OrganizationStores os ON os.IdStore=s.Id
			INNER JOIN OrganizationUsers ou ON ou.IdOrganization = s.OrganizationId
			WHERE ou.IdUser = ?
			ORDER BY s.Name', $id);
        
        if (!$result || !$this->queryInfo['num_rows'])
            return false;
        return $result;
    }
    
    public function Update($id, $name, $address, $phones)
    {
		if (!strlen($name) || !strlen($address) || !strlen($phones))
			return false;
		
        if (!$store = $this->SelectById($id))
            return false;
        
		if (strlen($name))
			$store['Name'] = $name;
		if (strlen($address))
			$store['Address'] = $address;
		if (strlen($phones))
			$store['Phones'] = $phones;
		
        $sql = 'UPDATE Stores SET Name = ?, Address = ?, Phones = ?
			WHERE Id = ?';
        
        $result = parent::update($sql, $store['Name'], $store['Address'], $store['Phones'], $id);

        if (!$result || !$this->queryInfo['affected_rows'])
            return false;
        return true;
    }
    
    public function Insert($params = array())
    {
        if (!is_array($params) || !sizeof($params))
            return false;
        
        $sql = 'INSERT INTO Stores ';
        
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
        $result = parent::delete('DELETE FROM Stores WHERE Id = ?', $id);
        
        if (!$result || !$this->queryInfo['affected_rows']) {
			parent::transactionRollBack();
            return false;
		}
		
		$result = parent::delete('DELETE FROM OrganizationStores WHERE IdStore = ?', $id);
        
        if (!$result || !$this->queryInfo['affected_rows']) {
			parent::transactionRollBack();
            return false;
		}
		
		parent::transactionCommit();		
        return true;
    }
	
	public function ChangeOrganization($id, $oldOrgId, $newOrgId)
	{
		
		
	}
	
	public function AddToOrganization($id, $orgId)
	{
		
		
	}
	
	public function DeleteFromOrganization($id, $orgId)
	{
		
		
	}
}
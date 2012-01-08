<?
class uploadFile
{
    public function parse($file) {
		$db = new mysqliDB();
		$db->simpleQuery("CREATE TABLE IF NOT EXISTS `test` (`Id` INT( 11 ) NOT NULL AUTO_INCREMENT PRIMARY KEY ,
												`Name` VARCHAR( 100 ) NOT NULL ,
												`Email` VARCHAR( 100 ) NOT NULL ,
												`DateBirth` VARCHAR( 11 ) NOT NULL ,
												`DateRegister` INT( 11 ) NOT NULL ,
												`Status` VARCHAR( 3 ) NOT NULL) ENGINE = MYISAM ;");
		if (($handle = fopen($file, "r")) !== FALSE) {
			while (($data = fgetcsv($handle, 1000, ";")) !== FALSE) {
				$date_register = $this->makeTime($data[3]);
				echo $data[0].'<br>';
				$db->insert("INSERT INTO test (Name,
											   Email,
											   DateBirth,
											   DateRegister,
											   Status) VALUES (?,?,?,?,?)", $data[0],
																		    $data[1],
																			$data[2],
																			$date_register,
																			$data[4]);
			}
			fclose($handle);
		}
    }
    
    public function dropTable() {
		$db = new mysqliDB();
		$db->simpleQuery("DROP TABLE `test`");
    }
    
    public function changeAnyRowAndShow() {
		$db = new mysqliDB();
		$result = $db->selectRow("SELECT * FROM test ORDER BY RAND()");
		if($result[Status]=="On"){
			$newStatus = "Off";
		}else{
			$newStatus = "On";
		}
		$db->update("UPDATE test SET Status = ? WHERE Id = ?", $newStatus, $result[Id]);
		$newResult = $db->selectRow("SELECT * FROM test WHERE Id = ?", $result[Id]);
		return $newResult;
    }
    
    public function getExtension($filename) {
		$path_info = pathinfo($filename);
		return $path_info['extension'];
	}
	
	private function makeTime($dateString) {
		$date = explode(" ", $dateString);
		$date_day = explode(".", $date[0]);
		$date_time = explode(":", $date[1]);
		$return = mktime($date_time[0], $date_time[1], 0, $date_day[1], $date_day[0], $date_day[2]);
		return $return;
	}
}
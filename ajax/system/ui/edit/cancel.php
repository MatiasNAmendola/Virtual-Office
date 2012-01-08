<?
    $db = new mysqliDB();
    $return = "";
    switch($_POST[what]){
        case "department":
                $result = $db->selectRow('SELECT * FROM department WHERE Id = ?', $_POST[id]);
                $return .= "<span onclick=\"EditStart('department', '".$_POST[id]."');\">";
                $return .= $result[Name];
                $return .= "</span>";
            break;
    }
    
    if ($return=="") {
        echo json_encode(array('status' => 'error', 'message' => 'error'));
        exit();
    }
    
    echo json_encode(array('status' => 'ok', 'data' => $return));
    exit();
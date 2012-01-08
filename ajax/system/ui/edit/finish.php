<?
    $db = new mysqliDB();
    $return = "";
    switch($_POST[what]){
        case "department":
                $db->update("UPDATE department SET Name =? WHERE Id = ?", array($_POST[value], $_POST[id]));
                $return .= "<span onclick=\"EditStart('department', '".$_POST[id]."');\">";
                $return .= $_POST[value];
                $return .= "</span>";
            break;
    }
    
    if ($return=="") {
        echo json_encode(array('status' => 'error', 'message' => 'error'));
        exit();
    }
    
    echo json_encode(array('status' => 'ok', 'data' => $return));
    exit();
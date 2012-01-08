<?
    $db = new mysqliDB();
    $return = "";
    switch($_POST[what]){
        case "department":
                $result = $db->selectRow('SELECT * FROM department WHERE Id = ?', $_POST[id]);
                $return = "<input type=\"text\" class=\"departmentEdit".$_POST[id]."\" autofocus=\"autofocus\" onblur=\"EditCancel('department', '".$_POST[id]."');\" onkeypress=\"if(event.keyCode == 13){EditFinish('department', '".$_POST[id]."');}\" value=\"".$result[Name]."\">";
            break;
    }
    
    if ($return=="") {
        echo json_encode(array('status' => 'error', 'message' => 'error'));
        exit();
    }
    
    echo json_encode(array('status' => 'ok', 'data' => $return));
    exit();
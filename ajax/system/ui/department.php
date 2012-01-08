<?
$department_html = "<div class=\"SectionView\">";
//Подключаемся к БД
$db = new mysqliDB();
//Получаем список отделов
$department = $db->select('SELECT * FROM department WHERE IdOrganization = ? ORDER BY Name', $_SESSION[staff][IdOrganization]);
if($db->queryInfo[num_rows]>0){
    //Выводим кол-во
    //$department_summary = "0-".$db->queryInfo[num_rows];
}

$department_lines = "<div class=\"ListView\">";
$department_lines .= "<div class=\"department\">";
$department_lines .= "<span class=\"num\">";
$department_lines .= "+";
$department_lines .= "</span>";
$department_lines .= "<input type=\"text\" class=\"newDepartmentName\" placeholder=\"Введите имя нового отдела и нажмите Enter\" onkeypress=\"if(event.keyCode == 13){Add('department');}\">";
$department_lines .= "</div>";

//В цикле достаем записи
for($i=0;$i<$db->queryInfo[num_rows];$i++){
    $department_lines .= "<div class=\"department\">";
    $department_lines .= "<span class=\"num\">";
    $department_lines .= $i+1;
    $department_lines .= ".</span>";
    $department_lines .= "<span class=\"name name".$department[$i][Id]."\">";
    $department_lines .= "<span onclick=\"EditStart('department', '".$department[$i][Id]."');\">";
    $department_lines .= $department[$i][Name];
    $department_lines .= "</span>";
    $department_lines .= "</span>";
    $department_lines .= "</div>";
}
$department_lines .= "</div>";

$department_html .= $department_summary;
$department_html .= $department_lines;
$department_html .= "</div>";

$data = $department_html;
echo json_encode(array('title' => 'Отделы', 'data' => $data));
exit();
?>
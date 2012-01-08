<?
	require_once 'config.php';
?>
<!doctype html>
<html>
    <head>
        <title>TEST - CSV to MYSQL :)</title>
        <meta http-equiv="X-UA-Compatible"content="IE=EmulateIE7">
        <meta http-equiv="content-type" content="text/html; charset=utf-8">
        <link type="text/css" href="/content/css/style.css" rel="stylesheet">
        <script src="/content/scripts/jquery-1.6.2.min.js"></script>
    </head>
    <body>
        <?
			if($_POST['dropTable']){
				$file = new uploadFile();
				$file->dropTable();
			}
			if($_FILES['file']){
				$file = new uploadFile();
				if($file->getExtension($_FILES['file']['name'])=='csv'){
					$file->parse($_FILES['file']['tmp_name']);
					$row = $file->changeAnyRowAndShow();
					if($row){
					?>
						<h2>Измененная ячейка</h2>
						<table>
							<tbody>
								<tr>
									<td><?=$row[SecondName];?></td>
									<td><?=$row[FirstName];?></td>
									<td><?=$row[Email];?></td>
									<td><?=$row[DateBirth];?></td>
									<td><?=date('d.m.Y H:i', $row[DateRegister]);?></td>
									<td><?=$row[Status];?></td>
								</tr>
							</tbody>
						</table>
					<?
					}
				}
			}
			
			$db = new mysqliDB();
			$query = $db->select("SELECT * FROM test");
			if(!$db->queryInfo['num_rows']){
        ?>
        <div class="Upload">
			<form method="post" enctype="multipart/form-data">
				<h2>Выберите файл с данными CSV для загрузки</h2>
				<input type="file" name="file">
				<input type="submit">
			</form>
        </div>
        <?
			}else{
		?>
		<div class="Data">
			<h2>Полная выборка из БД</h2>
			<table>
				<thead>
					<tr>
						<td>Фамилия Имя</td>
						<td>Email</td>
						<td>Дата рождения</td>
						<td>Зарегистрирован</td>
						<td>Статус</td>
					</tr>
				</thead>
				<tbody>
				<?
					for($i=0;$i<count($query);$i++){
				?>
					<tr>
						<td><?=$query[$i][Name];?></td>
						<td><?=$query[$i][Email];?></td>
						<td><?=$query[$i][DateBirth];?></td>
						<td><?=date('d.m.Y H:i', $query[$i][DateRegister]);?></td>
						<td><?=$query[$i][Status];?></td>
					</tr>
				<?
					}
				?>
				</tbody>
			</table>
			<form method="POST">
				<input type="hidden" name="dropTable" value="1">
				<input type="submit" value="Удалить таблицу">
			</form>
        </div>
        <?	}?>
    </body>
</html>
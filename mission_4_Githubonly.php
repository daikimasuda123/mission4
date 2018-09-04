<!DOCTYPE html>
<html lang="ja">
<head>
<meta http-equiv="content-type"charset="UTF-8">
<title>Mission4掲示板</title>

<?php
//データベースに接続
$dsn = 'データベース名';
$user = 'ユーザー名';
$password = 'パスワード';
$pdo = new PDO($dsn,$user,$password);

//テーブルを作る
$sql= "CREATE TABLE IF NOT EXISTS tbtest4"
. "id INT PRIMARY KEY AUTO_INCREMENT,"
. "name char(32),"
. "comment TEXT,"
. "date TIMESTAMP,"
. "password VARCHAR(50)"
.");";
$stmt = $pdo->query($sql);
$sql ='SHOW TABLES';
$result = $pdo -> query($sql);
foreach ($result as $row)
{
	echo $row[0];
	echo '<br>';
}
echo "<hr>";
$sql ='SHOW CREATE TABLE tbtest4';
$result = $pdo -> query($sql);
foreach ($result as $row)
{    //列の作成がおかしいとWarningを返す
print_r($row);
}
echo "<hr>";

?>

</head>
<body>
<form action=""method="post">
<input type="text" name= "names" placeholder="名前" value="<?php echo $data1;?>"><BR>
<?php
echo"<br/>";
?>

<input type="text" name="kome"placeholder="コメント" value="<?php echo $data2;?>"><BR>
<?php
echo "<br />";
?>

<input type = "password" name ="pasu" placeholder="パスワード" value=""<BR>
<input type="submit" name="send" value="送信">
</form>
<?php
echo "<br />";
?>

<form action=""method="post">
<input type="text" name="delnumber"placeholder="削除対象番号(半角)" value="">
<?php	
echo "<br />";
?>
<input type="password" name="pasu"placeholder="パスワード" value=""<BR>
<input type="submit" name="delete" value="削除">
</form>

<?php	
echo "<br />";
?>

<form action="" method="post">
	<input type ="text" name="henshu" placeholder="編集対象番号">
<br>	<input type ="text" name="henshun" placeholder="編集後の名前">
<br>	<input type ="text" name="henshuc" placeholder="編集後のコメント">
<br>	<input type ="password" name="pasu" placeholder="パスワード">
	<input type ="submit" value="編集">
</form>
<?php	
echo "<br />";
?>
</form>

<?php
//パスワード処理
$sql=$pdo->prepare("INSERT INTO tbtest4(pass) VALUES(:pass)");
$sql->bindParam(':pass',$pass,PDO::PARAM_STR);
$pass='kaijo';
$sql->execute();

$name=$_POST['names'];
$kome=$_POST['kome'];
$pasu=$_POST['pasu'];
$kesu=$_POST['delnumber']; //削除の実装
$id=$kesu;
if(!empty($kesu)&&($kesu)==($id))
{
	if(($pasu) ==($pass))
	{
	$sql="delete from tbtest4 where id=$id";
	$result = $pdo->query($sql);
	}
}
?>

<?php


//編集の実装

$henshu=$_POST['henshu'];
$henshun=$_POST['henshun'];
$henshuc=$_POST['henshuc'];
if(!empty($henshu)&&($henshun)&&!empty($henshuc))
{
	if(($pasu)==($pass))
	{			
	$id=$henshu;
	$na=$henshun;
	$co=$henshuc;
	$sql="update tbtest4 set name='$na', comment='$co' where id=$id";
	$result=$pdo->query($sql);
	}
}							//編集機能

//ここから投稿機能
if(!empty($name)&&($kome))
{
	if(($pasu)==($pass))
	{


$sql = $pdo -> prepare("INSERT INTO tbtest4 (id,name,comment,date,password) VALUES (:id, :name, :comment, :date, :password)");
$sql -> bindValue(':id', $id, PDO::PARAM_INT);
$sql -> bindParam(':name', $name, PDO::PARAM_STR);
$sql -> bindParam(':comment', $comment, PDO::PARAM_STR);
$sql -> bindParam(':date', $date, PDO::PARAM_STR);
$sql -> bindParam(':password', $password, PDO::PARAM_STR);
$name = $_POST['names'];
$comment = $_POST['kome'];
$sql -> execute();
	}
}


//ここから3-6
$sql = 'SELECT * FROM tbtest4';
$results = $pdo -> query($sql);
foreach ($results as $row)
{
//$rowの中にはテーブルのカラム名が入る
echo $row['id'].',';
echo $row['name'].',';
echo $row['comment'].' ';
echo $row['date'].'<br>';
}




$pdo->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);

?>





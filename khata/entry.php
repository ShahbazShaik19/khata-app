<?php $name= $_REQUEST['name']; ?>

<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title></title>
</head>
<body>
	<script>
	    function redirect(){
	        window.location.replace("http://shahbaz.ml/khata/history.php?name=<?php echo $name ?>");
	    }
	</script>
	<div style="margin: auto; width: 100%; height: 100%; text-align: center; padding-top: 50%;">PROCESSING....</div>
</body>
</html>

<?php
	if($_REQUEST['radio']=="cr"){
		$cr= intval($_REQUEST['amount']);
		$dr= 0;
	}
	else{
		$dr= intval($_REQUEST['amount']);
		$cr= 0;
	}

	$date= $_REQUEST['date'];
	$remark= $_REQUEST['remark'];
	// echo $name;



	$db = mysqli_connect("localhost","root","","test");
	//$db = mysqli_connect($host,$user,$pass,$db);

	if(!$db)
	{
	    die("Connection failed: ".mysqli_connect_error());
	}

	$sql= "INSERT INTO `".$name."` (`time`, `cr`, `dr`, `remark`) VALUES ('$date',$cr,$dr,'$remark');";
	if(mysqli_query($db, $sql)){
		echo "<script> redirect(); </script>";
  	}
   	else
    	echo mysqli_error($db);

    mysqli_close($db);
 ?>
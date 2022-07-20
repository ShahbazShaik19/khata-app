<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>ADD</title>
    <script>
        function redirect(){
            window.location.replace("../index.php");
        }
    </script>
</head>
<body>
	<?php
        header("Content-type: text/html; charset=utf-8");

		$db = mysqli_connect("localhost","root","","test");
		//$db = mysqli_connect($host,$user,$pass,$db);

		if(!$db)
		{
		    die("Connection failed: ".mysqli_connect_error());
		}
        mysqli_query("SET NAMES 'utf-8'");


		// Taking all 3 values from the form data(input)
		        $name =  $_REQUEST['name'];
                //echo $name;
		        $village = $_REQUEST['village'];
		        $tel = $_REQUEST['tel'];
		          
		        // Performing insert query execution
		        $sql = "INSERT INTO accounts  VALUES ('$name','$village','$tel')";
		          
		        if(mysqli_query($db, $sql)){
		            //echo "<h3>data stored in a database successfully." 
		                //. " Please browse your localhost php my admin" 
		                //. " to view the updated data</h3>";
                        // echo "<h3>first</h3>";
		            $sql= "CREATE TABLE `".$name."` (id int NOT NULL AUTO_INCREMENT, time varchar(20), cr int(10), dr int(10), remark varchar(300), PRIMARY KEY (id));"; 
		        	if(mysqli_query($db, $sql)){
                        // echo "<h3>second</h3>";
		        		$sql= "INSERT INTO completed_id VALUES('$name',0);";
		        		if(mysqli_query($db, $sql))
	                        echo "<script> redirect(); </script>";
		        		else
		        			echo mysqli_error($db);
                    echo "<script> redirect(); </script>";
		        		}
		  
		           // echo nl2br("\nname\n"
		               //."$village\n $tel");
		        } else{
		            echo "ERROR: Hush! Sorry $sql. " 
		                . mysqli_error($db);
		        }

                mysqli_close($db);
    ?>
</body>
</html>
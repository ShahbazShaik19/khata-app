<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>SHF</title>
	<link rel="stylesheet" type="text/css" href="styles.css?v=<?php echo time()?>">
	<link rel="stylesheet" type="text/css" href="search.css?v=<?php echo time()?>">

    <link crossorigin="use-credentials" rel="manifest" href="manifest.json" />

	<!-- <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script> -->
</head>
<script>
    function add(elem){
        if(elem.innerHTML!="X")
            elem.innerHTML="X";
        else
            elem.innerHTML="ADD";
    }
</script>
<body>
	<details>
        <summary>
            <span id="add"  onclick="add(this)">ADD</span>
        </summary>
                <div id="form">
	                    <form action="khata/process.php" method="POST">
	                        <br>
	            		    <label>Name: <br><input type="text" name="name" class="form_input" required></label><br>
	            		    <label>Village: <br><input type="text" name="village" class="form_input"></label><br>
	            		    <label>Tel: <br><input type="text" name="tel" pattern="[0-9]{10}" inputmode="numeric" class="form_input"></label><br><br>
	            		    
	            		    <input type="submit" id="btn" value="SUBMIT">
	            	    </form>
                </div>
    </details>

	<!--input type="search" name=""-->
<br>
<hr>
<br>
<!-- <div class="input-group">
	<div class="form-outline"> -->
		<input type="text" name="search" onkeyup="search_accounts(this)" id="search">
		<label id="span" for="search">Search</label>
	<!-- </div>
</div> -->
<br>
<h2 id="acc">ACCOUNTS</h2>
	<?php
     header("Content-type: text/html; charset=utf-8");


		$host='sql307.epizy.com';
		$user='epiz_30037702';
		$pass='fAOyHnNjWwrzde';
		$db='epiz_30037702_first';

		// $db = mysqli_connect("localhost","root","","test");
		$db = mysqli_connect($host,$user,$pass,$db);

		if(!$db)
		{
		    die("Connection failed: ".mysqli_connect_error());
		}
    mysqli_query("SET NAMES 'utf-8'");

		$name="";
		$data2=0;
		$records = mysqli_query($db,"select * from accounts;"); // fetch data from database

		while($data = mysqli_fetch_array($records))
		{
	?>
		<div class="accounts" onclick="fetch(this)">
			<?php
				echo $name= $data['name'];
				// $records = mysqli_query($db,"select sum(cr)-sum(dr) from ".$name.";"); // fetch data from database

				// if(mysqli_num_rows($records)>0){
				// 	while($data2 = mysqli_fetch_array($records)){
				// 		echo $data2[0];
				// 	}
				// }
				// else
				// 	echo "0";

			?>
			
		</div>

	<?php
		}
		mysqli_close($db);
	?>

<script>
    if ('serviceWorker' in navigator) {
      // Register a service worker hosted at the root of the
      // site using the default scope.
      navigator.serviceWorker.register('/service-worker.js').then(function(registration) {
        console.log('Service worker registration succeeded:', registration);
      }, /*catch*/ function(error) {
        console.log('Service worker registration failed:', error);
      });
    } else {
      console.log('Service workers are not supported.');
    }
  </script>
    

</body>

<script>
    function fetch(elem){
        //document.write("<h1>"+elem.innerHTML+"</h1>");
        window.location.href="khata/history.php?name="+elem.innerHTML;
    }

    function search_accounts(elem) {
    	var input= elem.value.toLowerCase();
    	//document.write(input);
    	var acc= document.getElementsByClassName('accounts');
    	for (var i = 0; i < acc.length; i++) {
    		if(!acc[i].innerHTML.toLowerCase().includes(input)){
    			acc[i].style.display= "none";
    		}
    		else
    			acc[i].style.display= "block";
    	}
    }
</script>



</html>
<!DOCTYPE html>
<html>
<head>
	<?php $name =  $_REQUEST['name'];  ?>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
	<link rel="stylesheet" type="text/css" href="history.css?v=<?php echo time()?>">
	<title><?php echo $name ?></title>
	<style type="text/css">
		

		/*#invoice{
			white-space: pre;
		}*/
	</style>
</head>
<body>
	<?php

    $host='sql307.epizy.com';
	$user='epiz_30037702';
	$pass='fAOyHnNjWwrzde';
	$db='epiz_30037702_first';

	// $db = mysqli_connect("localhost","root","","test");
	$db = mysqli_connect($host,$user,$pass,$db);

	if(!$db){
		   die("Connection failed: ".mysqli_connect_error());
	}
	$tel=0;
    $qry= "select * from accounts where name='".$name."';";
    $records = mysqli_query($db,$qry); // fetch data from database

		while($data = mysqli_fetch_array($records))
		{
            echo "first";
    ?>

		<div id="accounts">
			<p class="accounts"><span>Name &nbsp;&nbsp; :&nbsp; </span><?php echo $data['name']; ?></p>
        	<p class="accounts"><span>Village&nbsp; :&nbsp; </span><?php echo $data['village']; ?></p>
        	<p class="accounts"><span>Phone &nbsp;&nbsp;&nbsp;:&nbsp; </span><?php echo $tel=$data['tel']; ?></p>

		</div>
	<?php
		}
		$max_id=0;
		$total=0;
	    $qry= "select sum(cr)-sum(dr) from `".$name."`;";
	    $records = mysqli_query($db,$qry); // fetch data from database

			while($data = mysqli_fetch_array($records))
            
			{
                echo "second";
                $total= $data[0];
				if($data[0]==0){
				    $qry= "select max(id) from `".$name."`;";
				    $records = mysqli_query($db,$qry); // fetch data from database

						while($data2 = mysqli_fetch_array($records)){
							if($data2[0]=="")
								$max_id=0;
							else
								$max_id= $data2[0];
						}





					$sql= "UPDATE completed_id SET id=".$max_id." WHERE name='".$name."'";
					if(mysqli_query($db, $sql)){
						//....
				  	}
				   	else
				    	echo mysqli_error($db);
				}
	?>
				<div id="amount"><?php echo $total?><div id="inner_amount">BALANCE</div></div>

	<?php }
		$id=0;
		$qry= "select id from completed_id where name='".$name."';";
	    $records = mysqli_query($db,$qry); // fetch data from database

			while($data = mysqli_fetch_array($records)){
				$id= $data[0];
			}
	?>


	<div class="top">
		<form method="POST" id="form" action="entry.php?name=<?php echo $name  ?>">
			<input type="number" name="amount" placeholder="amount" required>
			<br>
			<span id="radio_span">
				<input type="radio" name="radio" id="radio1" value="cr" required>
				<label for="radio1" id="label1">CR</label>
				<input type="radio" name="radio" id="radio2" value="dr" required>
				<label for="radio2" id="label2">DR</label>
			</span>

			<input type="date" name="date" value="<?php echo date('Y-m-d') ?>">
			<br><br>
			<input type="text" name="remark" placeholder="remark..." >
			<input type="submit" value="SUBMIT">
		</form>
	</div>
	<hr><br><br>

	<table cellpadding="0" cellspacing="0">
		<tr>
			<th>S.No.</th>
			<th>DATE</th>
			<th>AMOUNT</th>
			<th>REMARK</th>
		</tr>
		<?php
			$amount= 0;
			$amount_color= "";
			$records = mysqli_query($db,"select * from `".$name."` order by id desc;"); // fetch data from database

			while($data = mysqli_fetch_array($records)){
				$amount= "-".$data['dr'];
				$amount_color= "red"; 
				// echo $amount;
				if($amount==0){
					$amount= "+".$data['cr'];
					$amount_color="green";
				}
		?>
			<tr <?php if($id>=$data['id'])
						echo " class= completed_id"; 
					  else echo " class= incomplete_id";
				?>
			>
				<td><?php echo $data['id'] ?></td>
				<td><?php echo date("d/m/y",strtotime($data['time'])) ?></td>
				<td style="color: <?php echo $amount_color ?>;"><?php echo ($amount) ?></td>
				<td class="tooltip"><?php echo substr($data['remark'],0,16) ?><span class="tooltip_text"><?php echo $data['remark'] ?></span></td>
			</tr>
			<?php
				}
				mysqli_close($db);
			?>
	</table>

	<a href="" id="whatsapp" data-action="share/whatsapp/share"><i class="fa fa-whatsapp"></i></a>
</body>
<script type="text/javascript">
	function htmltostring(html){
		var temp= document.createElement("div");
		temp.innerHTML= html;

		return temp.innerText;
	}


	var completed= document.getElementsByClassName("incomplete_id");
	var invoice="";
	invoice+="<br>%0a=====================%0a<br>";
	for (var i = 0; i < completed.length; i++) {
		invoice+="¦&nbsp;&nbsp;&nbsp;";
		for (var j = 1; j < completed[i].cells.length-1; j++) {
			if(j==2)
				invoice+=(completed[i].cells[j].innerHTML).padEnd(5," ")+"&nbsp;&nbsp;¦&nbsp;&nbsp;&nbsp;";
			else
				invoice+=completed[i].cells[j].innerHTML+"&nbsp;&nbsp;&nbsp;¦&nbsp;&nbsp;&nbsp;";
		}
		invoice+="<br>%0a=====================%0a<br>";
	}
	
	// var div_content= div.textContent || div.innerText || "";
	// document.write(htmltostring(invoice));

	var total= "%0aTotal Amount= ₹ ";
	total+= <?php echo $total  ?>;
	total+= "%2f";
	// document.write(total);

	document.getElementById('whatsapp').href="http://wa.me/+91<?php echo $tel ?>?text="+htmltostring(invoice)+total;

	//amount color green or red
	var amt= document.getElementById('amount');
	if (amt.innerHTML[0]=='-')
		amt.style.color="red";

	else if(amt.innerHTML[0]=='0')
		amt.style.color="white";
	else{
		amt.style.color="green";
		amt.innerHTML= '+'+amt.innerHTML;
	}

</script>
</html>



<!--
    display previous transactions by accessing the table which has the same name as $name...

    ** sessions **
-->
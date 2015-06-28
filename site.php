<?php

include('lock.php');

$site_id=$_GET['baby'];
$ses_sql=mysqli_query($dbc,"SELECT * FROM project WHERE PROJECT_ID='$site_id'");

$row=mysqli_fetch_array($ses_sql,MYSQLI_ASSOC);;
$site_desc=$row['P_DESCRIPTION'];
$sitename=$row['P_NAME'];
$dos=$row['START'];
$bhk=$row['BHK'];
$cstatus=$row['STATUS'];
$cemail=$row['C_EMAIL'];
$_SESSION['site_id']=$row['PROJECT_ID'];
$resultask=mysqli_query($dbc,"SELECT * FROM Q_A WHERE PROJECT_ID='$site_id'");

?>

<!DOCTYPE html>
<html lang="en" class="no-js">
	<head>
		<meta charset="UTF-8">
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.11.0/jquery.min.js"></script>

		<link href='http://fonts.googleapis.com/css?family=PT+Sans:400,700' rel='stylesheet' type='text/css'>
		<link rel="stylesheet" href="site/css/reset.css"> <!-- CSS reset -->
		<link rel="stylesheet" href="site/css/style.css"> <!-- Gem style -->
		<script src="js/modernizr.js"></script> <!-- Modernizr -->
		<script type="text/javascript" src="site/js/jquery.cycle.all.js"></script> 

		<title>Converge: Contractor's group</title>
		<script language="javascript">
		$(document).ready(function(){
			$('#slider1') .cycle({
				fx: 'fade', //'scrollLeft,scrollDown,scrollRight,scrollUp',blindX, blindY, blindZ, cover, curtainX, curtainY, fade, fadeZoom, growX, growY, none, scrollUp,scrollDown,scrollLeft,scrollRight,scrollHorz,scrollVert,shuffle,slideX,slideY,toss,turnUp,turnDown,turnLeft,turnRight,uncover,ipe ,zoom
				speed:  'slow', 
				timeout: 2000 
			});
		});	
		</script>
		
	</head>
<body>
	<header role="converge">
	<div align="left"><a href="index.html"><h1 class="toptitle">CONVERGE</h1><!img src="logo.png" id="main-logo"></a></div>
	</header>
	
		<div class="nav-bar">
		<nav class="main-nav">
		<div class="greeting">
			Hello <?php echo $login_session; ?>
		</div>
		<div class="buttons">
			<ul align="right">
			<li><a class="cd-signin" href="index.html">Log Out</a></li>
			</ul>
		</div>
		</nav>
	</div>
	
	<div class="one">
		<div class="sitename"><h1>Site: <?php echo $sitename ?></h1></div>
		<div class="imslide">
			<div class="slider">
			<ul id="slider1">
			<li><?php echo '<img src="data:image;base64,'.$row["IMAGE1"].'">'; ?></li>
			<li><?php echo '<img src="data:image;base64,'.$row["IMAGE2"].'">'; ?></li>
			<li><?php echo '<img src="data:image;base64,'.$row["IMAGE3"].'">'; ?></li>
			</ul>
			</div>
		</div>
	</div>
	<div class="two">
		<div class="dtitle">Description</div>
		<div class="message">
		<?php echo $site_desc; ?><br /><br />
		Date of start: <?php echo $dos; ?><br/><br />
		Current Status: <?php echo $cstatus; ?> <br/><br />
		BHK :: <?php echo $bhk; ?> <br /><br />
		Contractor Contact Information : <?php echo $cemail; ?> <br/>
		</div>
	</div>
	<div style="float:left; width:15%;">
	</div>
	<div class="qanda">
		<div class="queries">Queries :</div> 
		<?php
			while($row=$resultask->fetch_assoc()){
		?>
		<div class="question">
			QUE: <?php echo $row["QUESTION"]; ?>
		</div>
		<div class="answer">
			ANS: <?php echo $row["ANSWER"]; ?>
		</div>
		<?php
		}
		?>
		<div class="Ask_button">
		<form action=""  method="post" enctype="multipart/form-data">
		<input type="text" class="writeque" name="question">
		<input type="submit" class="askone" value="Ask_Question" name="askbutton">
		</form>
	</div>
	</div>

</body>
</html>

<?php

	if(isset($_POST['askbutton'])){
		$que=$_POST['question'];
		$ans="";
		$q="INSERT INTO q_a (PROJECT_ID, QUESTION, ANSWER, U_EMAIL) VALUES (?, ?, ?, ?)"or die ("Invalid Query".mysql_error());
		$stmt=mysqli_prepare($dbc,$q);
		mysqli_stmt_bind_param($stmt, "isss", $siteid, $que, $ans, $login_email);
		$siteid=$_SESSION['site_id'];
		mysqli_stmt_execute($stmt);	
		
	

		$ar = mysqli_stmt_affected_rows($stmt);
		if($ar){
			echo "<script>alert('question entered ')</script>";
	
		}
		else{
			echo "<script>alert('Alert question Not entered ')</script>";
		}
	}
?>


<!DocType html>
<html>
	<head>
		<meta charset="utf-8"/>
		<title>Student Plattform</title>
		<link rel ="stylesheet" type="text/css" href="startPageStyle.css"/>
	</head>
<body>
	<div id="container">
		<nav id="navbar">
			<ul class="links_startpage">
				<li class="lists"><a class="links" href="startpage.php" title="Startpage">Startpage</a></li>
				<li class="lists"><a class="links" href="index.php" title="Subjects">Subjects</a></li>
				<li class="lists"><a class="links" href="add_subject.php" title="Add">Add subject</a></li>
				<li class="lists"><a class="links" href="add_summary.php" title="Add">Add summary</a></li>
			</ul>
		</nav>
	</div>
<?php
	$host = "localhost";
	$dbname = "student_platform";
	$username= "student_platform";
	$password = "123456";

	$dsn = "mysql:host=$host;dbname=$dbname";
	$attr = array(PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC);
	$pdo = new PDO($dsn, $username, $password, $attr);
?>
	<div id="second_container">
		<section class="column">
			<section class="index_textblock">
				<ul class="list_subjects">
					<li>
<?php
	if(!empty($_POST))
	{
		if($_POST['subject_name'] !== "")
		{
			$_POST = null;
			$subject_name = filter_input(INPUT_POST, 'subject_name');
			$statement = $pdo->prepare("INSERT INTO subjects (name) VALUES (:subject_name)");
			$statement->bindParam(":subject_name", $subject_name);
			if(!$statement->execute())
				print_r($statement->errorInfo());
		}
	}
	foreach($pdo->query("SELECT * FROM subjects ORDER BY name") as $row)
	{	
		echo "<li><a href=\"summaries.php?subject_id={$row['id']}\">{$row['name']}</a></li>";
	}
?>
					</li>
				</ul>
			</section>
		</section>
	</div>
</body>
</html>
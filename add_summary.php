<?php

	$host = "localhost";
	$dbname = "student_platform";
	$username= "student_platform";
	$password = "123456";
	$dsn = "mysql:host=$host;dbname=$dbname";
	$attr = array(PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC);
	$pdo = new PDO($dsn, $username, $password, $attr);

?>
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

		<div id="second_container">
			<section class="column">
				<section class="add_summary_textblock">
					<form action="add_summaries.php" method="POST">
						<p>
							<label for="author_name">Name: </label>
							<input type="text" name="author_name">
						</p>
						<p>
							<label for="title">Title: </label>
							<input type="text" name="title">
						</p>
						<p>
							<label id="lable_post_summary" for="content">Summary: </label>
							<textarea id="textarea_post_summary" type="text" name="content" rows="5" cols="50"></textarea>
						</p>
						<p>
							<label for="subject_id">Subject: </label>
							<select name="subject_id"> 
						</p>
						</form>
				</section>
			</section>
		</div>
	</div>
<?php
	foreach($pdo->query("SELECT * FROM subjects ORDER BY name") as $row)
	{
		echo "<option value=\"{$row['id']}\">{$row['name']}</option>";					
	}
?>
							</select>
						<form action="add_summaries.php" method="POST">
							<input type="submit" value="Add summary">
						</form>
</body>
</html>
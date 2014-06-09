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

	if(!empty($_POST))
	{
		if(isset($_POST['author_name']) && isset($_POST['title']) && isset($_POST['content']) && isset($_POST['subject_id']))
		{

			if($_POST['author_name'] !== "" && $_POST['title'] !== "" && $_POST['content'] !== "" && $_POST['subject_id'] !== "")
			{
				$author_name = filter_input(INPUT_POST, 'author_name', FILTER_SANITIZE_SPECIAL_CHARS, FILTER_FLAG_STRIP_LOW);
				$title = filter_input(INPUT_POST, 'title', FILTER_SANITIZE_SPECIAL_CHARS, FILTER_FLAG_STRIP_LOW);
				$content = filter_input(INPUT_POST, 'content', FILTER_SANITIZE_SPECIAL_CHARS, FILTER_FLAG_STRIP_LOW);
				$subject_id = filter_input(INPUT_POST, 'subject_id', FILTER_VALIDATE_INT);
				$statement = $pdo->prepare("INSERT INTO summaries (subject_id, author_name, date, title, content) VALUES (:subject_id, :author_name, NOW(), :title, :content)");
				$statement->bindParam(":subject_id", $subject_id);
				$statement->bindParam(":author_name", $author_name);
				$statement->bindParam(":title", $title);
				$statement->bindParam(":content", $content);
				
				if(!$statement->execute())
					print_r($statement->errorInfo());
			}
		}
		else if(isset($_POST['summary_id']) && isset($_POST['author_name']) && isset($_POST['content']))
		{
			if($_POST['summary_id'] !== "" && $_POST['author_name'] !== "" && $_POST['content']) 
			{
				$summary_id = filter_input(INPUT_POST, 'summary_id', FILTER_VALIDATE_INT);
				$author_name = filter_input(INPUT_POST, 'author_name', FILTER_SANITIZE_SPECIAL_CHARS, FILTER_FLAG_STRIP_LOW);
				$content = filter_input(INPUT_POST, 'content', FILTER_SANITIZE_SPECIAL_CHARS, FILTER_FLAG_STRIP_LOW);
				$statement = $pdo->prepare("INSERT INTO comments (summary_id, author_name, date,  content) VALUES (:summary_id, :author_name, NOW(), :content)");
				$statement->bindParam(":summary_id", $summary_id);
				$statement->bindParam(":author_name", $author_name);
				$statement->bindParam(":content", $content);
				
				if(!$statement->execute())
					print_r($statement->errorInfo());
			}
		}
	}
	if(!empty($_GET) && isset($_GET['summary_id']))
	{
		if ($_GET['summary_id'] !== "")	
		{
			$summary_id = filter_input(INPUT_GET, "summary_id", FILTER_VALIDATE_INT);
			$sum_statement = $pdo->prepare("SELECT summaries.*, subjects.name AS 'subject_name' FROM summaries JOIN subjects ON summaries.subject_id=subjects.id WHERE summaries.id=:summary_id");
			$sum_statement->bindParam(":summary_id", $summary_id);
			if($sum_statement->execute())
			{
				if($row = $sum_statement->fetch())
				{
					echo "<h1>{$row['title']}</h1> 
							<p>{$row['date']}</p>
							<p>Av: {$row['author_name']}</p>
							<p>Subject: {$row['subject_name']}</p>
							<p>{$row['content']}</p>
							<p><a href=\"summaries.php\">Tillbaka</a></p>";	
					echo "<form action=\"summaries.php?summary_id={$row['id']}\" method=\"POST\">";
					echo "<input type=\"hidden\" name=\"summary_id\" value=\"{$row['id']}\" />";
					?>
					<form action="summaries.php" method="POST">
						<p>
							<label for="author_name">Your name:</label>
							<input type="text" name="author_name" />
						</p>
						<p>
							<label for="content">Comment:</label>
							<textarea type="text" name="content" rows="5" cols="30"></textarea>
						</p>
						<input type="submit" />
					</form>
</html>
</body>
					<?php

					$com_statement = $pdo->prepare ("SELECT * FROM comments WHERE summary_id=:summary_id ORDER BY date DESC");
					$com_statement->bindParam(":summary_id", $summary_id);
					if($com_statement->execute())
					{
						while($comment = $com_statement->fetch())
						{
							echo "<p>{$comment['author_name']} ({$comment['date']}): {$comment['content']}</p>";
						}
					}
					else
					{
						print_r($com_statement->errorInfo());
					}
				}
			}
			else 
			
				print_r($sum_statement->errorInfo());
		}
	}
	else
	{
		echo "<ul>";
		foreach($pdo->query("SELECT * FROM summaries ORDER BY date DESC") as $row)
		{
			echo "<li><a href=\"?summary_id={$row['id']}\">{$row['title']}, 
			av {$row['author_name']} ({$row['date']})</a></li>";
		}
		echo "</ul>";
	}
?>
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
				<section class="add_subject_textblock">
					<form action="add_subject.php" method="POST">
						<p>
							<label class="label_add_subject" for="subject_name">Subject name: </label>
							<input class="input_add_subject" type="text" name="subject_name" />
						</p>
						<input type="submit" value="Add" />
					</form>
				</section>
			</section>
		</div>
	</div>
</body>
</html>
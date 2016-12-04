<?php
	$db = mysqli_connect('localhost', 'root', '', '157A')
	or die('Error connecting to MySQL server');
?>


<!DOCTYPE html>
	<head>
		<link rel="stylesheet" type="text/css" href="styleSheet.css" >
		<title>Higher Education Degree Database</title>
                <meta http-equiv="Content-Type" content="text/html 
                    charset=UTF-8" />
                <meta name="Author" content="Charles Bocage" />
                <meta name="description" content="This is a CS157A sample
			page" />
	</head>
	<body>
		<div class="centered">
			<h1>Higher Education Degree Database</h1><br />
			<B>Team Members:</B> Tim Bly, (insert your names) <br /><br />
		</div>
		<hr>
		<B>Relations:</B>
		<ol>
			<li><a href="/157AProject/index.php?query=select * from colleges;" >Colleges</a></li>
			<li><a href="/157AProject/index.php?query=select * from courseprereqs;" >Course Prerequisites</a></li>
			<li><a href="/157AProject/index.php?query=select * from courses;" >Courses</a></li>
			<li><a href="/157AProject/index.php?query=select * from degreerequirescourse;" >Degree Requires Course</a></li>
			<li><a href="/157AProject/index.php?query=select * from degrees;" >Degrees</a></li>
			<li><a href="/157AProject/index.php?query=select * from departments;" >Departments</a></li>
			<li><a href="/157AProject/index.php?query=select * from occupationrequiresdegree;" >Occupation Requires Degree</a></li>
			<li><a href="/157AProject/index.php?query=select * from occupations;" >Occupations</a></li>
			<li><a href="/157AProject/index.php?query=select * from universities;" >Universities</a></li>
		</ol>
		<hr>
		<B>Queries:</B>
		<ol>
			<li><a href="/157AProject/index.php?query=SELECT drc.courseName, drc.courseNum, c.description FROM 
			`degreerequirescourse` AS drc INNER JOIN courses AS c ON c.number = drc.courseNum 
			WHERE drc.courseNum LIKE 'MATH%' AND drc.degreeName='BS in Computer Science' 
			AND drc.uName='San Jose State University'" >Query 1</a>&nbsp;What are the course names, numbers and 
			descriptions of all the math classes needed for a Bachelor’s degree in Computer Science at San Jose State?
			</li>
			<li><a href="/157AProject/index.php?query=SELECT o.name, o.avgSalary FROM occupations o, 
			occupationRequiresDegree ord 
			WHERE o.avgSalary = (SELECT MAX(avgSalary) FROM occupations) AND o.name = ord.occupationName AND 
			ord.degreeName = 'High school diploma or equivalent'" >Query 2</a>&nbsp;What job(s) have the highest 
			average salary that do not require a college degree?
			</li>
			<li><a href="/157AProject/index.php?query=SELECT DISTINCT c.dName FROM courses AS c 
			INNER JOIN degreerequirescourse AS drc ON c.number=drc.courseNum 
			WHERE drc.degreeName='BS in Computer Engineering' AND drc.uName='San Jose State University'" >
			Query 3</a>&nbsp;Which different departments do I need to take courses from in order to 
			get a Bachelor’s degree in Computer Engineering at San Jose State?
			</li>
			<li><a href="/157AProject/index.php?query=SELECT AVG(genderRate), AVG(gradRate), AVG(employmentRate) 
			FROM degrees WHERE uName='San Jose State University'" >
			Query 4</a>&nbsp;What are the average gender, graduation and employment rates across all 
			degrees offered at San Jose State University?
			</li>
			<li><a href="/157AProject/index.php?query=SELECT dName, COUNT(dName) AS occurrence 
			FROM degrees GROUP BY dName ORDER BY occurrence DESC LIMIT 1" >
			Query 5</a>&nbsp;What department offers the most degrees?
			</li>
		</ol>
		<hr>
		<B>Ad-hoc Query:</B>

			<FORM class="queryForm" METHOD=GET ACTION="">
				<table>
					<tr>
						<td align = left>
							<strong>Please enter your query here<br></strong>
							(We support Select, Insert, <br>Update and Delete queries)
						</td>
						<td>
							<textarea rows="10" cols="50" name="query"></textarea>
						</td>
					</tr>
				<tr align = right>
						<td>
						</td>
						<td>
							<input type=reset value="Clear">
							<input type=submit value="Submit" name="btnQuery">
						</td>
				</table>
			</FORM>


		<div id="results">
		<hr>
			<?php
				if (isset($_REQUEST['query']))
				{
					mysqli_query($db, $_REQUEST['query']) or die('Error querying database');
					$result = mysqli_query($db, $_REQUEST['query']);
					$qInfo = mysqli_fetch_fields( $result );
					echo '<table style="width:100%" padding: 15px>' . '<tr>';
					foreach($qInfo as $val){
						echo '<th>' . $val->name . '</th>';
					}
					echo '</tr>';
					
					while($row = mysqli_fetch_array($result)){
						echo '<tr>';
						foreach($qInfo as $val){
							echo '<td>' . $row[$val->name] . '</td>';
						}
						echo '</tr>';
					}
				}
				else
				{
					print "We have no query";
				}
			?>
		</div>
	</body>
</html>

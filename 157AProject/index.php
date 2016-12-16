<?php
if (session_status() == PHP_SESSION_NONE) {
	session_name("permaSess");
		session_start();
}
?>

<!DOCTYPE html>
	<head>
		<link rel="stylesheet" type="text/css" href="styleSheet.css" >
		<title>Higher Education Degree Database</title>
          <meta http-equiv="Content-Type" content="text/html
              charset=UTF-8" />
          <meta name="Author" content="Team Flash" />
          <meta name="description" content="College Degrees Browser" />
					<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>
					<script type="text/javascript">
					function auto_load(input, db){
								$.ajax({
										url: "query.php",
										type: "POST",
										cache: false,
										data: {
												'query': input,
												'qType': db
										},
										success: function(data, db){
												console.log(data);
												console.log(db);
												$("#auto_load_div").html(data);
										}
								});
						}
						function clear_contents(element){
							element.value = '';
						}
						</script>
	</head>
	<body onload="auto_load('');">
		<div class="centered">
			<h1>Higher Education Degree Database</h1><br />
			<p class="left"><B>Team Members:</B> Tim Bly, David Burke, Mark Bragg, Bishal Wagle</p><br/>
		</div>
		<hr>
		<B>Relations:</B>
		<ol>
			<li><a href="#" onclick="auto_load('select * from colleges;', 'Query');" >Colleges</a></li>
			<li><a href="#" onclick="auto_load('select * from courseprereqs;', 'Query');" >Course Prerequisites</a></li>
			<li><a href="#" onclick="auto_load('select * from courses;', 'Query');" >Courses</a></li>
			<li><a href="#" onclick="auto_load('select * from degreerequirescourse;', 'Query');" >Degree Requires Course</a></li>
			<li><a href="#" onclick="auto_load('select * from degrees;', 'Query');" >Degrees</a></li>
			<li><a href="#" onclick="auto_load('select * from departments;', 'Query');" >Departments</a></li>
			<li><a href="#" onclick="auto_load('select * from occupationrequiresdegree;', 'Query');" >Occupation Requires Degree</a></li>
			<li><a href="#" onclick="auto_load('select * from occupations;', 'Query');" >Occupations</a></li>
			<li><a href="#" onclick="auto_load('select * from universities;', 'Query');" >Universities</a></li>
		</ol>
		<hr>
		<B>Queries:</B>
		<ol>
			<li><a href="#"
				   onclick="auto_load('SELECT drc.courseName, drc.courseNum, c.description ' +
                   'FROM degreerequirescourse AS drc INNER JOIN courses AS c ON c.number = drc.courseNum ' +
                   'WHERE drc.courseNum LIKE \'MATH%\' AND drc.degreeName=\'BS in Computer Science\' ' +
                   'AND drc.uName=\'San Jose State University\';', 'Query');" >
				Query 1
				</a>&nbsp;What are the course names, numbers and
            descriptions of all the math classes needed for a Bachelor’s degree in Computer Science at San Jose State?
			</li>
			<li><a href="#" onclick="auto_load('SELECT o.name, o.avgSalary FROM occupations o, occupationRequiresDegree ord ' +
            'WHERE o.avgSalary = (SELECT MAX(avgSalary) FROM occupations) AND o.name = ord.occupationName ' +
            'AND ord.degreeName = \'High school diploma or equivalent\';', 'Query');" >Query 2</a>&nbsp;What job(s) have the highest
			average salary that do not require a college degree?
			</li>
			<li><a href="#" onclick="auto_load('SELECT DISTINCT c.dName FROM courses AS c ' +
            'INNER JOIN degreerequirescourse AS drc ON c.number=drc.courseNum ' +
            'WHERE drc.degreeName=\'BS in Computer Engineering\' AND drc.uName=\'San Jose State University\';', 'Query');" >
			Query 3</a>&nbsp;Which different departments do I need to take courses from in order to
			get a Bachelor’s degree in Computer Engineering at San Jose State?
			</li>
			<li><a href="#" onclick="auto_load('SELECT AVG(genderRate), AVG(gradRate), AVG(employmentRate) ' +
            'FROM degrees WHERE uName=\'San Jose State University\';', 'Query');" >
			Query 4</a>&nbsp;What are the average gender, graduation and employment rates across all
			degrees offered at San Jose State University?
			</li>
			<li><a href="#" onclick="auto_load('SELECT dName, COUNT(dName) AS occurrence ' +
            'FROM degrees GROUP BY dName ORDER BY occurrence DESC LIMIT 1;', 'Query');" >
			Query 5</a>&nbsp;What department offers the most degrees?
			</li>
		</ol>
		<hr>
		<B>Ad-hoc Query:</B><br>

		<table class="center">
			<tr>
				<td align=left>
					<strong>Please enter your query here<br></strong>
					(We support Select, Insert, <br>Update and Delete queries)
				</td>
				<td>
					<textarea rows="10" id="qForm" cols="50" name="query"></textarea>
				</td>
			</tr>
			<tr align = right>
				<td>
				</td>
				<td>
					<input type=reset value="Clear" onclick="clear_contents(qForm);">
					<input type=button onclick="auto_load(document.getElementById('qForm').value, 'Query')" value="Submit" name="btnQuery">
				</td>
			</tr>
		</table>

      <hr>
      <B>Additional Functionality:</b>
      <h3>Explore Transactions</h3>

              <table class="center">
				<tr>
					<td>
						<a href="index.php" target="_blank"><strong>Start Another Page</strong></a>
					</td>
				</tr>
				<tr>
					<td>
						<p>BEGIN TRANSACTION </p>
						<a href="#" onclick="auto_load('', 'newTransaction')" > New Transaction </a> &nbsp;
					</td>
                </tr>
                  <tr>
					<td>
						<p>Autocommit: </p><a href="#" onclick="auto_load('', 'autocommitOn')" > On </a> &nbsp;
						<a href="#" onclick="auto_load('', 'autocommitOff')" >&nbsp; Off </a>
					</td>
                  </tr>
                  <tr>
                     <td>
						<a href="#" onclick="auto_load('', 'commit')" >Commit Your Work</a>
                     </td>
                  </tr>
                  <tr>
                     <td>
						<a href="#" onclick="auto_load('', 'rollback')" >Rollback Your Work</a>
                     </td>
                  </tr>
              </table>

      <hr>

		<div id="auto_load_div"></div>

	</body>
</html>

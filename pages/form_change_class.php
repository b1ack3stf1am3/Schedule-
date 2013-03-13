<?php
$conn=open_db();
// Execute SELECT query
$sql = "SELECT course_id, course_name FROM courses";
$results = $conn->query($sql);
$class_options = $results->fetch_all();
// Close connection
$conn->close();
extract($class_options);
?>
<ul>
	<?php foreach($class_options as $class){
		echo "<li><a href=\"actions/change_class.php?id=$class[0]\">$class[1]</a></li>";
	}?>
</ul>


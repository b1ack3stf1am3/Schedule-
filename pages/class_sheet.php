<?php 
// Connect to DB
$conn=open_db();
// Execute SELECT query
$sql = "SELECT CAST(GROUP_CONCAT(CONCAT_WS(
',',course_name,mycourse_teacher,mycourse_room,mycourse_sem,mycourse_period,mycourses.course_id,courses.course_number)
 SEPARATOR '|') AS CHAR) AS schedule FROM mycourses LEFT JOIN courses ON
mycourses.course_id=courses.course_id GROUP BY mycourse_period ORDER BY mycourse_sem";

// Fetch all results as an array ($results->fetch_all()
$results = $conn->query($sql);

// Debugging output
if($conn->errno > 0) {?>
	<code><strong>Error # <?php echo $conn->errno?></strong>: <?php echo $conn->error?><br/>
	<strong>SQL:</strong> <?php echo $sql ?>
	</code>
<?php
}

$block_list = $results->fetch_all();
// Close connection
$conn->close();
// Display array of results with print_r
?>
<pre><?php print_r($block_list);?></pre>


<table class="table table-bordered">
	<thead>
		<tr>
			<th>Term SEM 1<br/>(08/15/12-10/21/12)</th>
			<th>Term SEM 2<br/>(10/22/12-01/02/13)</th>
			<th>Term SEM 3<br/>(01/03/13-03/19/13)</th>
			<th>Term SEM 4<br/>(03/20/13-05/22/13)</th>
		<tr>
	</thead>
	<tbody>
	<?php foreach($block_list as $block){
			$semester = explode('|',$block[0]);?>
			<tr> <?php
			foreach($semester as $course){
				// explode $course on comma
				$course_data = explode(',',$course);
?>
						<td colspan="<?php echo blocklen($course_data[7])?>">
								<span class="course_name"><?php echo $course_data[0]?></span><br/>
								<span class="course_teacher"><?php echo $course_data[1],$course_data[2]?></span><br/>
								<span class="course_room">Room: #<?php echo$course_data[3]?></span>
								<span class="course_edit"><a href=<?php echo "./?p=form_change_class&id=$course_data[6]"?>>Change</a>
								<a href=<?php echo "actions/delete_class.php?id=$course_data[6]"?>>Remove</a></span></td>
			
		<?php }?>
		</tr>
	<?php } ?>
	</tbody>
</table>

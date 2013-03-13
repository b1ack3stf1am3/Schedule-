<?php



function blocklen($course_id) {
	$last_char=substr($course_id,-1);
	$sem=0;
	if(is_numeric($last_char)) {
		$sem=1;
	}else {
		$sem=2;
	} 
	return $sem;
}

function open_db() {
	return new mysqli(DB_HOST,DB_USER,DB_PASS,DB_NAME);
}

function format_phone($phone) {
	return '('.substr($phone,0,3).') '.substr($phone,3,3).'-'.substr($phone,-4);
}

/**
 * Outputs an iput element with the given attribute values
 * This function also examines SESSION data for previously
 * entered values with the smae name
 */
function input($name, $placeholder, $value=null, $class='') {
	if($value == null && isset($_SESSION['POST'][$name])) {
		$value = $_SESSION['POST'][$name] ;
		
		// Remove from session data
		unset($_SESSION['POST'][$name]);
		
		if($value =='') {
			$class = 'class="error"';
		} else {
			$class = '';
		}
	}elseif($value != null) {
		$class = '';
	}
	 else {
		$value = '';
		$class = '';
	}
	return "<input $class type=\"text\" name=\"$name\" placeholder=\"$placeholder\" value=\"$value\" />";
}
	

/**
 * Generates an HTML select element with the given name
 * attribute and option elements
 * this function also exam ines session data for previously
 * submitted value
 * @param unknown_type $name
 * @param unknown_type $options Array of options in the form value => text
 * HTML select element
 */
function dropdown($name, $options) {
	$select = "<select name=\"$name\">";
	
	// Add option elements to select element
	foreach($options as $value => $text) {
		if(isset($_SESSION['POST'][$name]) && $_SESSION['POST'][$name] == $value) {
			unset($_SESSION['POST'][$name]);
			$selected = 'selected="selected"';
		} else {
			$selected = '';
		}
		$select .= "<option $selected value=\"$value\">$text</option>";
	}
	
	$select .= "</select>";
	return $select;
}


function radio($name, $options) {
	$radio = '';
	
	foreach($options as $value => $text) {
		if(isset($_SESSION['POST'][$name]) && $_SESSION['POST'][$name] == $value) {
			$checked = 'checked="checked"';
	} else {
		$checked = '';
	}
	$radio .="<label><input type=\"radio\" name=\"$name\" value=\"$value\" $checked />$text</label>";
	}
	
	return $radio;
}



/**
 * Query the provided tabe for all rows, sorted by name, useing the fields table_id and table_name
 * @param unknown_type $table name of DB table
 * @param unknown_type $default_value value of first optoin (1st key in array)
 * @param unknown_type $default_name name of firwst option (1st value in array)
 */
function get_options($table,$default_value,$default_name='Select') {
	$options = array($default_value => $default_name);
	
	$id_field = $table.'_id';
	$name_field = $table.'_name';
	
	// Connect to DB
	$conn=open_db();
	
	
	//Query tabe for id's and names
	$sql = "SELECT $id_field, $name_field FROM {$table}s ORDER BY $name_field";
	$results = $conn->query($sql);
	
	// Loop ove rresult set, adding all rows to $options
	while(($row = $results->fetch_assoc()) != null) {
		$key = $row[$id_field];
		$value = $row[$name_field];
		$options[$key] = $value;
	}
	// Close DB connections
	$conn->close();
	
	return $options;
}


?>
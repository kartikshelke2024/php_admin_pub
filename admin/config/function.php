<?php
function mysqli_escape_array($db=null,$array=array()){
    $safe_array =array();
	foreach($array as $key=>$value){
		$safe_array[$key] = mysqli_real_escape_string($db,$array[$key]);
	}
	return $safe_array;
}


// Fill DropDown

function populateDropdown($dropdownId, $data, $selectedValue = null) {
    $html = '<select class="form-control" id="' . $dropdownId . '" name="' . $dropdownId . '">';
    foreach ($data as $item) {
        $selected = ($item[0] == $selectedValue) ? 'selected' : '';
        $html .= '<option value="' . $item[0] . '" ' . $selected . '>' . $item[1] . '</option>';
    }
    $html .= '</select>';
    return $html;
}


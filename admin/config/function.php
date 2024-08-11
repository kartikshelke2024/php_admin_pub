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
    
    if (!empty($data)) {
        foreach ($data as $item) {
            $selected = isset($item[0]) && $item[0] == $selectedValue ? 'selected' : '';
            $html .= '<option value="' . htmlspecialchars($item[0] ?? '') . '" ' . $selected . '>' . htmlspecialchars($item[1] ?? '') . '</option>';
        }
    } else {
        $html .= '<option value="">No options available</option>';
    }

    $html .= '</select>';
    return $html;
}


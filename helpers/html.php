<?php
/**
Functions
https://webdev.id
*/

// options(['name' => 'gender'], ['M' => 'Male', 'F' => 'Female'], ['input_field', 'default'])
function options($attr, $data, $selected = false, $print = true) 
{
	if (empty($attr['class'])) {
		$attr['class'] = 'form-control';
	} else {
		$attr['class'] = $attr['class'] . ' form-control';
	}
	
	foreach ($attr as $key => $val) {
		$attribute[] = $key . '="' . $val . '"'; 
	}
	$attribute = join($attribute, ' ');
	
	if ($selected) {
		if (!is_array($selected)) {
			$selected = [$selected];
		}
	}
	
	
	$result = '
	<select '. $attribute .'>';
		foreach($data as $key => $value) 
		{
			
			$option_selected = '';
			if ($selected) {
				if ( empty($_REQUEST[$selected[0]]) ) {
					if (in_array( $key, $selected)) {
						$option_selected = true;
					}
				} else {
					if ($key == $_REQUEST[$selected[0]]) {
						$option_selected = true;
					}
				}
			}
			
			if ($option_selected) {
				$option_selected = ' selected';
			}
			$result .= '<option value="'.$key.'"'.$option_selected.'>'.$value.'</option>';
		}
		
	$result .= '</select>';
	
	if ($print) {
		echo $result;
	} else {
		return $result;
	}
	
}

function checkbox($data, $checked = []) 
{
	if (!is_array($data)) {
		$data[] = ['name' => $data, 'id' => $data];
	}
	// echo '<pre>'; print_r($data); die;
	foreach ($data as $key => $val) {
		$attr_checked = in_array($val['name'], $checked) ? ' checked' : '';
		$attr_class = !empty($val['class']) ? ' class="'.$val['class'].'"' : '';
		$parent_class = !empty($val['parent_class']) ? $val['parent_class'] : '';
		echo '<div class="checkbox '.$parent_class.'">
			<input type="checkbox" '. $attr_class .' name="'.$val['name'].'" id="'.$val['id'].'"'.$attr_checked.' >
			<label for="'.$val['id'].'">' . $val['label'] . '</label>
		</div>';
	}
}

function btn_submit($data = []) {
	$html = $attr = '';
	// echo '<pre>'; print_r($data);
	foreach ($data as $key => $val) {
		if (key_exists('attr', $val)) {
			foreach($val['attr'] as $key_attr => $val_attr) {
				$attr .= $key_attr . '="' . $val_attr . '"';
			}
		}
			
		$html .= '<button type="submit" class="btn '.$val['btn_class'].' btn-xs"'.$attr.'>
							<span class="btn-label-icon"><i class="'.$val['icon'].'"></i></span> '.$val['text'].'
			</button>';
	}
	
	return $html;
}

function btn_action($data = []) {

	$html = '<div class="form-inline btn-action-group">';
	$attr = '';
	foreach ($data as $key => $val) {
		if ($key == 'edit') {
			$html .= '<a href="'.$data[$key]['url'].'" class="btn btn-success btn-xs mr-1">
						<span class="btn-label-icon"><i class="fa fa-edit pr-1"></i></span> Edit
					</a>';
		}
		
		else if ($key == 'delete') {
			$html .= '<form method="post" action="'. $data[$key]['url'] .'">
					<button type="submit" data-action="delete-data" data-delete-title="'.$data[$key]['delete-title'].'" class="btn btn-danger btn-xs">
						<span class="btn-label-icon"><i class="fa fa-times pr-1"></i></span> Delete
					</button>
					<input type="hidden" name="delete" value="delete"/>
					<input type="hidden" name="id" value="'.$data[$key]['id'].'"/>
				</form>';
		}
		else {
			
			if (key_exists('attr', $data[$key])) {
				foreach($data[$key]['attr'] as $key_attr => $val_attr) {
					$attr .= $key_attr . '="' . $val_attr . '"';
				}
			}
			// print_r($attr); die;
			$html .= '<a href="'.$data[$key]['url'].'" class="btn '.$data[$key]['btn_class'].' btn-xs mr-1" ' . $attr . '>
						<span class="btn-label-icon"><i class="'.$data[$key]['icon'].'"></i></span>&nbsp;'.$data[$key]['text'].'
					</a>';
			
		}
	}
	
	$html .= '</div>';
	return $html;
}

function btn_label($data) 
{
	$icon = '';
	if (key_exists('icon', $data)) {
		$icon = '<span class="btn-label-icon"><i class="' . $data['icon'] . ' pr-1"></i></span> ';
	}
	$html = '
		<a href="'.$data['url'].'" class="'.$data['class'].'">'.$icon. $data['label'] . '</a>';
	return $html;
}
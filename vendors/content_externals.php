<?php

function to_externals($data = null) {

$externals = "";

foreach ($data as $k => $v) {
	$v = base64_encode($v);
	$externals .= "#$k" . '[' . "$v" . ']';
}

return $externals;

}

function parse_externals($data) {
$custom_types = array();

$start_tag = 0;
$start_data = 0;
$end_data = 0;
$nest_level = 0;

for($i=0; $i < strlen($data); $i++) {
	$c = $data[$i];

	if ($c == '#') {
	if ($nest_level == 0 )
		$start_tag = $i +1;
	}

	if ($c == '[') {
		$nest_level++;
		if ($nest_level == 1)
			$start_data = $i +1;
	}

	if ($c == ']') {
                if ($nest_level == 1) {
                        $end_data = $i -1;

			$tag = substr($data, $start_tag, $start_data - $start_tag -1);
			$type_data = substr($data, $start_data, $end_data - $start_data +1);
			$custom_types[$tag] = base64_decode($type_data);
		}
                $nest_level--;
        }

}

return $custom_types;
}
?>

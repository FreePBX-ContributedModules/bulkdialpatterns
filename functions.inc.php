<?PHP
/*
This File is placed here for FreePBX Module Purposes. FreePBX calls unpon this module everytime FreePBX is reloaded.

Thoughts are to perhaps allow phone reboots and rebuilds when the user reloads freepbx configuration

1866NXXXXXX
1866NXXXXXXX
1877NXXXXXX
1888NXXXXXX
2800NXXXXXX
911
NXXNXXXXXX
NXXXXXX
ZNXXNXXXXXX

*/
function bulkdialpatterns_hook_core($viewing_itemid, $target_menuid) {
	global $db;
	if ($target_menuid == 'routing')	{
		$html = '<tr><td colspan="2"><h5>';
		$html .= _("Bulk Dial Patterns");
		$html .= '<hr></h5></td></tr>';
		$html .= '<tr>';
		$html .= '<td><a href="#" class="info">';
		$html .= _("Source").'<span>'._("Each Pattern Should Be Entered On A New Line").'.</span></a>:</td>';
		$html .= '<td><textarea name="bulk_patterns" rows="10" cols="40">';
		if(isset($_REQUEST['extdisplay'])) {
			$sql = 'SELECT `match_pattern_pass` FROM `outbound_route_patterns` WHERE `route_id` = '. $_REQUEST['extdisplay'];
			$result = $db->query($sql);
			while($row =& $result->fetchRow(DB_FETCHMODE_ASSOC)) {
				$html .= $row['match_pattern_pass']."\n";
			}
			
		}
		$html .= '</textarea></td></tr>';
		return $html;
	}
}

function bulkdialpatterns_hookProcess_core($viewing_itemid, $request) {
	global $db;
	if (($request['display'] == 'routing') && (isset($request['bulk_patterns'])))	{
		$_POST['pattern_pass'] = "";
		$data = explode("\n",$request['bulk_patterns']);
		$_POST['pattern_pass'] = $data;
		$count = count($data);
		$_POST['prepend_digit'] = array_fill(0, $count, '');
		$_POST['pattern_prefix'] = array_fill(0, $count, '');
		$_POST['match_cid'] = array_fill(0, $count, '');
		
		/*
		$sql = 'DELETE FROM `outbound_route_patterns` WHERE `outbound_route_patterns`.`route_id` = '.$_REQUEST['extdisplay'];
		$db->query($sql);
		
		foreach($data as $value){
			$sql = "INSERT INTO outbound_route_patterns (route_id, match_pattern_pass) VALUES ('".$_REQUEST['extdisplay']."','".$value."')";
			$db->query($sql);
		}
				*/
	}
}
?>
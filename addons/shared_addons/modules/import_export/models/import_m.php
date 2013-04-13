<?php defined('BASEPATH') OR die('No direct script access allowed');
/**
 * Import/Export Module
 *
 * @author		Zac Vineyard
 * @package		PyroCMS\Addons\Modules\Import_Export\Models
 */
class Import_m extends MY_Model
{
	public function get_fields($table_name)
	{
		$sql = 'SHOW FIELDS FROM '.$table_name;
		$query = $this->db->query($sql);
		foreach ($query->result() as $row)
		{
	    	$fields[$row->Field] = array(
				//'field' => $row->Field,
				'type' => $row->Type,
			);
		}
		return $fields;
	}
}
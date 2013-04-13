<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
/**
 * Import/Export Module
 *
 * @author		Zac Vineyard
 * @package		PyroCMS\Addons\Modules\Import_Export\Models
 */
class Export_m extends MY_Model
{
	public function get_sites()
	{
		$sql = 'SELECT * FROM core_sites';
		$query = $this->db->query($sql);
		foreach ($query->result() as $row)
		{
	    	$sites[] = array(
				'name' => $row->name,
				'ref' => $row->ref,
			);
		}
		return $sites;
	}

	public function get_all_db_tables($prefix)
	{
		$tables = array();
		$query = $this->db->query("SHOW TABLES LIKE '%".$this->db->escape_str($prefix)."_%'");
		foreach ($query->result() as $row)
		{
		    $row = (array) $row;
		    $tables[] = $row['Tables_in_'.$this->db->database.' (%'.$prefix.'_%)'];
		}
		return $tables;
	}

	public function export($table = '', $type = 'xml')
	{
		switch ($table)
		{
			case 'users':
				$data_array = $this->db
					->select('users.id, email, IF(active = 1, "Y", "N") as active', FALSE)
					->select('first_name, last_name, display_name, company, lang, gender, website')
					->join('profiles', 'profiles.user_id = users.id')
					->get('users')
					->result_array();
				break;

			case 'files':
				$data_array = $this->db
					->select('files.*, file_folders.name folder_name, file_folders.slug')
					->join('file_folders', 'files.folder_id = file_folders.id')
					->get('files')
					->result_array();
				break;

			default:
				$data_array = $this->db
					->get($table)
					->result_array();
				break;
		}
		//force_download($table.'.'.$type, $this->format->factory($data_array)->{'to_'.$type}());
		return $this->format->factory($data_array)->{'to_'.$type}();
	}
}
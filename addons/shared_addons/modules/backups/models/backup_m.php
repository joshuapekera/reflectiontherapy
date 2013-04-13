<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Backup_m extends MY_Model
{
	/**
	 * Construct
	 **/
	function __construct()
	{
		parent::__construct();

		// Load in each of the backup methods
		foreach($this->get_backup_methods() as $row)
		{
			try 
			{
				$this->load->model($this->get_model_name($row));
			}
			catch(Exception $e)
			{}
		}

		// Load in the Dead model too.
		$this->load->model('backup_none_m');
	}
	
	/**
	 * Get Backup Methods
	 * Gets the backup methods which are being used.
	 **/
	public function get_backup_methods()
	{
		return array('amazons3', 'email', 'dropbox');
	}
	
	/**
	 * Get Backup Model
	 * Returns the model given a backup short name
	 * @param string $short Short name
	 * @return Object Backup Method Model
	 **/
	public function get_backup_model($short)
	{
		$model = 'backup_'.$short.'_m';
		return $this->{$model};
	}
	
	/**
	 * Get Backup Name
	 * Gets the name of a specific backup method
	 * @param string $name Short name
	 * @return string Friendly name
	 **/
	public function get_backup_name($name)
	{
		return $this->{$name}->core_get_name();	
	}
	
	/**
	 * Get Form Backup Methods
	 * Gets all of the options to be displayed in the Backup Methods field on the Preset form
	 * @return array Options
	 **/
	public function get_form_backup_methods()
	{
		$methods = array();
		$methods['none'] = lang('backups_none_account_name');
		foreach($this->get_backup_methods() as $row)
		{
			$methods['-- '.lang('backups_add_account').' --'][$row] = sprintf(lang('backups_backup_method_add_account'), $this->get_backup_model($row)->core_get_name());
			
			$group = '-- '.$this->get_backup_model($row)->core_get_name().' --';
			
			$accounts = $this->get_backup_model($row)->core_get_accounts();
			if(!empty($accounts))
			{
				$methods[$group] = $accounts;
			}
		}
		return $methods;
	}

	/**
	 * Get Form Vackup Methods Simplistic
	 * Returns just the names of backup methods
	 * @return array Backup methods
	 **/
	public function get_form_backup_methods_simplistic()
	{
		$methods = array();
		foreach($this->get_backup_methods() as $row)
		{
			$methods[$row] = $this->get_backup_model($row)->core_get_name();
		}
		return $methods;
	}
	
	/**
	 * Get Form Backup Fields
	 * Gets all of fields from all the backup methods
	 * @param array $data Form data
	 * @return string Backup fields
	 **/
	public function get_form_backup_fields($data = false)
	{
		$return = '';
		foreach($this->get_backup_methods() as $row)
		{
			$return .= $this->get_model($row)->core_get_form_inputs($data);
		}
		return $return;
	}
	
	/**
	 * Get Form Validation Rules
	 * Gets all of the valiation rules for a backup method
	 * @param string $method Short name of backup method
	 * @return array Validation rules
	 **/
	public function get_form_validation_rules($method)
	{
		return $this->get_model($method)->core_get_form_validation_rules();
	}
	
	/**
	 * Get Model Name
	 * Get name of Backup Method's Model
	 **/
	public function get_model_name($method)
	{
		if($method == NULL)
			return 'backup_none_m';

		return 'backup_'.$method.'_m';
	}
	
	/**
	 * Validation Populate Fields
	 * Repopulate fields after validaiton failure
	 * @return array Fields with content
	 **/
	public function validation_populate_fields()
	{
		$data = array();
		foreach($this->get_backup_methods() as $row)
		{
			array_push($data, $this->get_model($row)->core_validate_populate());
		}
		
		return $data;
	}
	
	/**
	 * Is Backup Method
	 * Checks if given method is a backup method or not
	 * @param string $method Short name
	 * @return bool
	 **/
	public function is_backup_method($method)
	{
		$methods = $this->get_backup_methods();
		foreach($methods as $row)
			if($row == $method)
				return true;
				
		return false;
	}
	
	/**
	 * Get Model
	 * Gets the model
	 * @param string $method Short name
	 * @return Object Model
	 **/
	public function get_model($method)
	{
		return $this->{$this->get_model_name($method)};
	}
	
	/**
	 * Backup
	 * Runs the backup
	 * @param int $preset_id Preset ID
	 * @param bool $download Direct Download (snapshot) or delivery via account
	 * @return bool Success or failure
	 **/
	public function backup($preset_id = false, $download = false)
	{
		if($preset_id != false)
		{
			$preset = $this->presets_m->get_preset($preset_id);
		
			if($preset == NULL || ($download == false && $preset->account_id == NULL))
				return false;
		}
		
		$this->load->dbutil();
		$this->load->helper('file');
		$this->load->library('zip');
		
		$filename = date('Y-m-d H-i-s').(($preset_id == false) ? '' : ' - PID'.$preset_id);
		
		$preferences = array(
			'format' => 'txt',
		);

		if($preset_id != false && $preset->tables != NULL)
		{
			$all_tables = $this->presets_m->get_tables();
			$selected_tables = explode(', ', $preset->tables_raw);
			$final_tables = array();
			
			for($i=0; $i<count($selected_tables); $i++)
			{
				// Selected tables represents the prefixes
				if($preset->tables_type == 'prefix') {
					foreach($all_tables as $row) {
						$pos = strpos($row, $selected_tables[$i]);
						if($pos !== false && $pos === 0) {
							$final_tables[] = $row;
						}
					}
				} elseif(in_array($selected_tables[$i], $all_tables)) {	
					$final_tables[] = $selected_tables[$i];
				}
			}
			$preferences['tables'] = $final_tables;
		}
		
		
		$backup =& $this->dbutil->backup($preferences);
		$backup .= 'SET FOREIGN_KEY_CHECKS=0;';
		$path = UPLOAD_PATH.'backups/';
		$raw_file = $path.$filename;
		$file = $raw_file.'.zip';
		
		if(!file_exists($path))
			mkdir($path);
		
		if($preset_id == false || $download != false)
		{
			$this->zip->add_data($filename.'.sql', $backup);
			$this->zip->download($file);
			return true;
		}
		
		$this->zip->add_data($filename.'.sql', $backup);
		$this->zip->archive($file);
		
		$result = $this->get_model($preset->account_type)->core_backup($preset, $file);
		
		if($result)
		{
			// It's gone well. We can clear the error log now too.
			$data = array();
			$data['last_run'] = date('Y:m:d H:i:s');
			$this->presets_m->update_preset($data, $preset_id);
			$this->presets_m->clear_error($preset_id);
			unlink($file);
			return true;
		}
		
		return false;
	}
}
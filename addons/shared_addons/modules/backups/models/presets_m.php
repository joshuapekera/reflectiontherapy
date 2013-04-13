<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Presets_m extends MY_Model
{
	/**
	 * Construct
	 **/
	function __construct()
	{
		parent::__construct();
		$this->lang->load('backups');
	}
	
	/**
	 * Get Presets
	 * Gets all of the Presets stored in the DB
	 * @return array Preset data
	 **/
	public function get_presets()
	{
		return $this->_prepare_presets($this->_prepare_presets_statement()->get()->result());
	}
	
	/**
	 * Get Preset
	 * Gets the preset info stored for one preset
	 * @param int $preset_is Preset ID
	 * @return Object Preset data
	 **/
	public function get_preset($preset_id)
	{
		$result = $this->_prepare_presets($this->_prepare_presets_statement()->where('backup_presets.preset_id', $preset_id)->get()->result());
		return $result[0];
	}

	/**
	 * Get Presets By Account ID
	 * Returns all Presets where the Account ID matches the given ID
	 * @param int $account_id Account ID
	 * @return array Presets
	 **/
	public function get_presets_by_account_id($account_id)
	{
		return $this->_prepare_presets($this->_prepare_presets_statement()->where('backup_presets.account_id', $account_id)->get()->result());
	}
	
	/**
	 * Prepare Presets Statement
	 * Builds up the generic statement for getting Preset data
	 **/
	private function _prepare_presets_statement()
	{
		return $this->db
		->select('preset_id, name, description, public_key, backup_presets.account_id, username, password, path, bucket, created_on, last_run, tables, backup_accounts.account_type AS account_type, last_run_error')
		->from('backup_presets')
		->join('backup_accounts', 'backup_presets.account_id = backup_accounts.account_id', 'left')
		->order_by('created_on', 'desc');
	}	
	
	/**
	 * Prepare Presets
	 * Prepares the raw Preset Data. Adds extra fields and makes it human readable
	 * 
	 * @param array $presets Preset data
	 * @return array Formatted Preset data
	 **/
	private function _prepare_presets($presets)
	{
		if(empty($presets))
			return false;

		foreach($presets as $row)
		{
			$row->created_on_friendly = date(lang('backups_date_friendly'), strtotime($row->created_on));
			
			if($row->last_run == NULL)
				$row->last_run_friendly = lang('backups_never_run');
			else
				$row->last_run_friendly = date(lang('backups_date_friendly'), strtotime($row->last_run));
			
			$row->account_type_friendly = $this->backup_m->get_model($row->account_type)->core_get_name();
			
			$row->has_error = false;
			$row->last_run_error_message = '';
			
			$pos = strpos($row->tables, 'prefixes:');
			if($pos !== false) {
				$row->tables_type = 'prefix';
				$row->tables_raw = str_replace('prefixes:', '', $row->tables);
				$row->tables_friendly = lang('backups_tables_prefix_with').' '.$row->tables_raw;
			} elseif($row->tables == null) {
				$row->tables_type = 'all';
				$row->tables_raw = $row->tables;
				$row->tables_friendly = lang('backups_all_tables');
			} else {
				$row->tables_type = 'specific';
				$row->tables_raw = $row->tables;
				$row->tables_friendly = $row->tables;
			}

			
			if($row->last_run_error != NULL)
			{
				$row->has_error = true;
				$row->last_run_error_message = lang($row->last_run_error);
			}	
			
			$row->url = site_url().'/backups/run/'.$row->preset_id.'/'.$row->public_key;
		}
		return $presets;
	}
	
	/**
	 * Update Preset
	 * Updates the given preset with the given data
	 * @param array $data Updated data
	 * @param int $preset Preset to update
	 * @return int Preset ID
	 **/
	public function update_preset($data, $preset)
	{
		$this->db->where('preset_id', $preset)->update('backup_presets', $data);
		return $preset;
	}
	
	/**
	 * Create Preset
	 * Creates a Preset with the given data
	 * @param array $data Preset Data
	 * @return int Preset ID
	 **/
	public function create_preset($data)
	{
		$data['public_key'] = random_string('alnum', 10);
		$this->db->insert('backup_presets', $data);
		return $this->db->insert_id();
	}
	
	/**
	 * Delete Preset
	 * Deletes a given preset
	 * @param int $preset_id Preset ID to delete
	 * @return true
	 **/	
	public function delete_preset($preset_id)
	{
		$this->db->delete('backup_presets', array('preset_id' => $preset_id));
		return true;
	}

	/**
	 * Get Accounts
	 * Gets all accounts
	 * @return array Accounts data
	 **/	
	public function get_accounts()
	{
		$result = $this->db
			->select('*')
			->from('backup_accounts')
			->order_by('account_type', 'asc')
			->get()
			->result();
		
		return $this->_prepare_accounts($result);
	}

	/**
	 * Get Accounts
	 * Gets a single accounts information
	 * @param int $account_id
	 * @return Object Account data
	 **/
	public function get_account($account_id)
	{
		$result = $this->db
			->select('*')
			->from('backup_accounts')
			->where('account_id', $account_id)
			->get()
			->result();
		$result = $this->_prepare_accounts($result);
		return $result[0];
	}

	/**
	 * Prepare Accounts
	 * Prepares the account information adding extra fields, etc.
	 * @param array $data Account data
	 * @return array $data Formatted account data
	 **/
	private function _prepare_accounts($data)
	{
		if(empty($data))
			return NULL;
		

		foreach($data as $row)
		{
			$row->account_type_friendly = $this->backup_m->get_model($row->account_type)->core_get_name();
			$row->info = $this->backup_m->get_model($row->account_type)->core_present_account($row);
			$row->presets = $this->get_presets_by_account_id($row->account_id);
		}
		
		return $data;
	}

	/**
	 * Delete Account
	 * Deletes a given Account
	 * @param int $preset_id Preset ID to be deleted
	 * @return true
	 **/
	public function delete_account($preset_id)
	{
		$this->db->delete('backup_accounts', array('account_id' => $preset_id));
		return true;
	}
	
	/**
	 * Get Tables
	 * Gets a list of DB tables available
	 * @return array Tables
	 **/
	public function get_tables()
	{
		return $this->db->list_tables();
	}
	
	/**
	 * Set Error
	 * Sets an error on the Preset
	 * @param int $preset_id Preset ID
	 * @param string $error The error
	 **/
	public function set_error($preset_id, $error)
	{
		$data = array();
		$data['last_run_error'] = $error;
		$this->update_preset($data, $preset_id);
	}
	
	/**
	 * Clear Error
	 * Clears an error from a preset
	 * @param int $preset_id Preset ID
	 **/
	public function clear_error($preset_id)
	{
		$data = array();
		$data['last_run_error'] = NULL;
		$this->update_preset($data, $preset_id);
	}
}
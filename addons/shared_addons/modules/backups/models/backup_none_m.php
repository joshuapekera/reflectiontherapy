<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Backup_none_m extends MY_Model
{
	/**
	 * ---- Core Methods (all required) ----
	 **/
	 
	/**
	 * Core Get Name
	 * Gets the human readable name of the backup method
	 * @return string Backup Name
	 **/
	public function core_get_name()
	{
		return lang('backups_none_name');
	}

	/**
	 * Core Get Short Name
	 * Gets the unique name of this backup method. Should be unix friendly. 
	 * @return string Short name
	 **/
	public function core_get_short_name()
	{
		return 'email';
	}

	/**
	 * Core Get Fields
	 * Gets the fields and properties that are used by the backup method
	 * @param array $data Data to populate the fields with
	 * @return array Fields
	 **/
	public function core_get_fields($data = false){}
	
	/**
	 * Core Get Table View
	 * Returns the table rows to present the data when viewing a Preset
	 * @param object $preset_data Data to use
	 * @return string Table rows
	 **/
	public function core_get_table_view($preset_data){}

	/**
	 * Get Field With Prefix
	 * Prepends the shortname of the backup method to the field name
	 * @param string $field Field name
	 * @return string $field prefixed with the short name
	 **/
	private function _get_field_with_prefix($field)
	{
		return $this->core_get_short_name().'_'.$field;
	}
	
	/**
	 * Core Get Accounts
	 * Gets the accounts that use this backup method.
	 * @return array Accounts data
	 **/
	public function core_get_accounts(){}
	
	/**
	 * Core Get Form Inputs
	 * Gets the form inputs to present the user with
	 * @param array $data Data to populate it with
	 * @return string Form fields
	 **/
	public function core_get_form_inputs($data = false){}
	
	/**
	 * Core Get Form Validation Rules
	 * Gets the validation rules for the fields
	 * @return array Validation rules
	 **/
	public function core_get_form_validation_rules(){}
	
	/**
	 * Core Handle Account
	 * Handles the creation/updating of the account
	 * @param array $form_data Submitted data
	 * @param int $account_id Account ID if updating
	 * @return int Account ID
	 **/
	public function core_handle_account($form_data, $account_id = false)
	{}
	
	/**
	 * Core Validate Callback
	 * Validates the account details (verify connections etc.)
	 * @return bool Success or failure
	 **/
	public function core_validate_callback(){}
	
	/**
	 * Core Validate Populate
	 * Sets the form fields post validation
	 * @return array Form fields
	 **/
	public function core_validate_populate(){}
	
	/**
	 * Core Backup
	 * Handles the backup for this backup method
	 * @param Object $preset Preset Data
	 * @param string $file Path to file where backup has been generated
	 * @return bool Success or failure
	 **/
	public function core_backup($preset, $file){}

	/**
	 * Core Present Account
	 * Returns a human readable version for each account
	 * @param Object $row Account details
	 * @return string Presentable row
	 **/
	public function core_present_account($row)
	{
	}
}
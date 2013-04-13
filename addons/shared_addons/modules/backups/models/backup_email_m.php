<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Backup_email_m extends MY_Model
{
	/**
	 * Construct
	 **/
	function __construct()
	{
		parent::__construct();
		$this->lang->load('backups_'.$this->core_get_short_name());
	}
	
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
		return lang('backups_email_name');
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
	public function core_get_fields($data = false)
	{
		return array(
			array(
				'field' => $this->_get_field_with_prefix('email_address'),
				'label' => lang('backups_email_address'),
				'rules' => 'required|valid_email',
				'input' => form_input($this->_get_field_with_prefix('email_address'), ((($data != false && $this->core_get_short_name() == $data->account_type) ? $data->username : set_value($this->_get_field_with_prefix('email_address')))), 'maxlength="70" placeholder="'.lang('backups_email_address_placeholder').'"'),
				'is_required' => true,
				'row_class' => 'even',
				'db_alias' => 'username'
			)
		);	
	}
	
	/**
	 * Core Get Table View
	 * Returns the table rows to present the data when viewing a Preset
	 * @param object $preset_data Data to use
	 * @return string Table rows
	 **/
	public function core_get_table_view($preset_data)
	{
		$inputs = '<tr>
			<td style="width:20%; font-weight: bold;">'.lang('backups_backup_method').'</td>
			<td>'.$this->core_get_name().'</td>
		</tr>		
		';
		
		foreach($this->core_get_fields() as $field)
		{
			$inputs .= '
			<tr>
				<td style="width:20%; font-weight: bold;">'.$field['label'].'</td>
				<td>'.$preset_data->{$field['db_alias']}.'</td>
			</tr>
			';
		}
		return $inputs;
	}

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
	public function core_get_accounts()
	{
		$data = $this->db
			->select('account_id, account_type, username, bucket, path')
			->from('backup_accounts')
			->where('account_type', $this->core_get_short_name())
			->order_by('account_type', 'asc')
			->get()
			->result();
		$result = array();
		foreach($data as $row)
		{
			$result[$row->account_id] = $row->username;
		}
		
		return $result;
	}
	
	/**
	 * Core Get Form Inputs
	 * Gets the form inputs to present the user with
	 * @param array $data Data to populate it with
	 * @return string Form fields
	 **/
	public function core_get_form_inputs($data = false)
	{
		$inputs = '';
		foreach($this->core_get_fields($data) as $field)
		{
			$inputs .= '<li class="'.$field['row_class'].' backup_choice '.$this->core_get_short_name().'">
					<label for="'.$field['field'].'">'.$field['label'].'<span>'.(($field['is_required']) ? ' *' : '').'</span></label>
					<div class="input">
					'.$field['input'].'
					</div>
				
			</li>';
		}
		return $inputs;
	}
	
	/**
	 * Core Get Form Validation Rules
	 * Gets the validation rules for the fields
	 * @return array Validation rules
	 **/
	public function core_get_form_validation_rules()
	{
		return $this->core_get_fields();
	}
	
	/**
	 * Core Handle Account
	 * Handles the creation/updating of the account
	 * @param array $form_data Submitted data
	 * @param int $account_id Account ID if updating
	 * @return int Account ID
	 **/
	public function core_handle_account($form_data, $account_id = false)
	{
		// Re-use email accounts if they already exist.
		$result = $this->core_get_accounts();
		foreach($result as $a_id => $email)
		{
			
			if($email == $form_data[$this->_get_field_with_prefix('email_address')] && $a_id != false)
				return $a_id;
		}
		
		$data['account_type'] = $this->core_get_short_name();
		$data['username'] = $form_data[$this->_get_field_with_prefix('email_address')];
		$data['password'] = '';
		$data['bucket'] = '';
		$data['path'] = '';

		if($account_id != false)
		{
			$this->db->where('account_id', $account_id)->update('backup_accounts', $data);
			return $account_id;
		}

		$this->db->insert('backup_accounts', $data);
		return $this->db->insert_id();
	}
	
	/**
	 * Core Validate Callback
	 * Validates the account details (verify connections etc.)
	 * @return bool Success or failure
	 **/
	public function core_validate_callback()
	{
		// No post processing required for the email apart from the validation.
		return true;
	}
	
	/**
	 * Core Validate Populate
	 * Sets the form fields post validation
	 * @return array Form fields
	 **/
	public function core_validate_populate()
	{
		$data = array();
		$data['email_address'] = set_value($this->_get_field_with_prefix('email_address'));
		return $data;
	}
	
	/**
	 * Core Backup
	 * Handles the backup for this backup method
	 * @param Object $preset Preset Data
	 * @param string $file Path to file where backup has been generated
	 * @return bool Success or failure
	 **/
	public function core_backup($preset, $file)
	{
		$this->load->library('email');
		$this->email->to($preset->username);
		$this->email->from($this->settings->get('server_email'), $this->settings->get('site_name'));
		
		$this->email->subject('['.date('Y-m-d').'] - Backup - '.$preset->name);
		
		$message = sprintf(lang('backups_email_delivery_message'), 
		date(lang('backups_date_friendly')), $preset->name, $preset->description, ($preset->tables == NULL) ? lang('backups_all') : $preset->tables, 'admin/backups/view/'.$preset->preset_id);
		
		$this->email->message($message);
		$this->email->attach($file);
		
		if($this->email->send())
			return true;
		
		$this->presets_m->set_error($preset->preset_id, 'backups_email_errors_send_fail');
		return false;
	} 

	/**
	 * Core Present Account
	 * Returns a human readable version for each account
	 * @param Object $row Account details
	 * @return string Presentable row
	 **/
	public function core_present_account($row)
	{
		return $row->username;
	}
}
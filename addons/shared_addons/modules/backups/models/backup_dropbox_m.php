<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Backup_dropbox_m extends MY_Model
{
	/**
	 * Construct
	 **/
	public function __construct()
	{
		parent::__construct();


		$this->load->library('dropbox', $this->get_params());

		$this->lang->load('backups_'.$this->core_get_short_name());
		
		// Specific JS for this backup method
		$this->template->append_metadata('
				<script type="text/javascript">
				var auth_win = false;
				function auth(url)
				{
					auth_win = window.open(url, "auth", "width=960,height=650");
				}

				function check_status()
				{
					if(jQuery(\'#'.$this->_get_field_with_prefix('oauth_token_secret').'\').val()
						&& jQuery(\'#'.$this->_get_field_with_prefix('oauth_token').'\').val())
					{
						jQuery(\'#'.$this->_get_field_with_prefix('oauth_btn').'\').fadeOut();
						jQuery(\'#'.$this->_get_field_with_prefix('auth_controls').'\').html(\''.lang('backups_dropbox_auth_complete').'\');
					}
				}

				function check_drop_file_path(){
					if(jQuery(\'#'.$this->_get_field_with_prefix('path').'\').val() == "specific")
					{
						jQuery(\'#'.$this->_get_field_with_prefix('path_specific').', .flag\').fadeIn();
					} 
					else 
					{
						jQuery(\'#'.$this->_get_field_with_prefix('path_specific').', .flag\').fadeOut();		
					}
					
				}
				
				jQuery(function($){				
					
					check_drop_file_path();
					$(\'#'.$this->_get_field_with_prefix('path').'\').change(function (){
						check_drop_file_path();
					});
					
				});
				</script>
		');	
		 
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
		return lang('backups_dropbox_name');		
	}
	
	/**
	 * Core Get Short Name
	 * Gets the unique name of this backup method. Should be unix friendly. 
	 * @return string Short name
	 **/
	public function core_get_short_name()
	{
		return 'dropbox';
	}
	
	/**
	 * Core Get Fields
	 * Gets the fields and properties that are used by the backup method
	 * @param array $data Data to populate the fields with
	 * @return array Fields
	 **/
	public function core_get_fields($data = false)
	{
		$drop = $this->dropbox->get_request_token(site_url('admin/backups/oauth_endpoint'));
		$this->session->set_userdata('token_secret', $drop['token_secret']);

		return array(
			array(
				'field' => $this->_get_field_with_prefix('oauth_token_secret'),
				'label' => lang('backups_dropbox_auth'),
				'rules' => 'required|trim',
				'input' => '<div id="'.$this->_get_field_with_prefix('auth_controls').'"></div>'.
					'<button type="button" id="'.$this->_get_field_with_prefix('oauth_btn').'" onclick="auth(\''.$drop['redirect'].'\'); return false;">'.(($data != false && $this->core_get_short_name() == $data->account_type) ? lang('backups_dropbox_auth_button_change') : lang('backups_dropbox_auth_button')).'</button>'.
					form_input($this->_get_field_with_prefix('oauth_token_secret'), (($data != false && $this->core_get_short_name() == $data->account_type) ? $data->password : set_value($this->_get_field_with_prefix('oauth_token_secret'))), 'style="display:none" id="'.$this->_get_field_with_prefix('oauth_token_secret').'"').
					form_input($this->_get_field_with_prefix('oauth_token'), (($data != false && $this->core_get_short_name() == $data->account_type) ? $data->username : set_value($this->_get_field_with_prefix('oauth_token'))), 'style="display:none" id="'.$this->_get_field_with_prefix('oauth_token').'"'),
				'is_required' => true,
				'row_class' => 'even',
				'db_alias' => 'username'
			),
						
			array(
				'field' => $this->_get_field_with_prefix('path'),
				'label' => lang('backups_dropbox_backup_path'),
				'rules' => 'trim',
				'input' => form_input($this->_get_field_with_prefix('path'), (($data != false && $this->core_get_short_name() == $data->account_type) ? $data->path : set_value($this->_get_field_with_prefix('path')))).' '.lang('backups_dropbox_backup_path_label'),
				'is_required' => false,
				'row_class' => '',
				'db_alias' => 'path'
			)			
			
		);	
	}

	private function get_params()
	{
		$params = array();
		$params['key'] = 'a2o0Mzk4Y3pfczcyZGdrNmIyeWRkc29hcw==';
		$params['secret'] = 'a2xqNDkwX19kLDM5cnRjeWN3YWNyc3RyOXI=';

		return $params;
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

		$this->dropbox->set_oauth_access(array(
			'oauth_token' => $preset_data->username,
			'oauth_token_secret' => $preset_data->password
		));

		$dump = $this->dropbox->account();

		if(isset($dump->error))
		{
			$str = lang('backups_dropbox_auth_status_bad');
		}
		else
		{
			$str = sprintf(lang('backups_dropbox_auth_status_good'), $dump->email, round($dump->quota_info->normal / 1073741824, 2), round($dump->quota_info->quota / 1073741824, 2));
		}

		$inputs .= '<tr>
			<td style="width:20%; font-weight: bold;">'.lang('backups_dropbox_auth_status').'</td>
			<td>'.$str.'</td>
		</tr>		
		';
		
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
			->select('account_id, account_type, username, password, bucket, path')
			->from('backup_accounts')
			->where('account_type', $this->core_get_short_name())
			->order_by('account_type', 'asc')
			->get()
			->result();
		$result = array();
		
		foreach($data as $row)
		{
			$this->dropbox->set_oauth_access(array(
				'oauth_token' => $row->username,
				'oauth_token_secret' => $row->password
			));

			$account = $this->dropbox->account();
			if(!isset($account->error))
				$result[$row->account_id] = $account->email.' ('.$row->username.') - '.$row->path;
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
		$data['account_type'] = $this->core_get_short_name();
		$data['username'] = $form_data[$this->_get_field_with_prefix('oauth_token')];
		$data['password'] = $form_data[$this->_get_field_with_prefix('oauth_token_secret')];
		$data['bucket'] = '';
		$data['path'] = $this->_validate_path($form_data[$this->_get_field_with_prefix('path')]);
		
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
		$has_passed = true;
		
		$this->dropbox->set_oauth_access(array(
			'oauth_token' => $this->input->post($this->_get_field_with_prefix('oauth_token')),
			'oauth_token_secret' => $this->input->post($this->_get_field_with_prefix('oauth_token_secret'))
		));

		$result = $this->dropbox->account();

		if(isset($result->error))
		{
			$this->form_validation->set_message('preset_form_validate', lang('backups_dropbox_validate_token'));
			$has_passed = false;
		}

		// Check that the path validates
		if($this->input->post($this->_get_field_with_prefix('path')) != '')
		{
			$path = $this->input->post($this->_get_field_with_prefix('path'));
			if(!preg_match('([^\0]+)', $path))
			{
				$this->form_validation->set_message('preset_form_validate', lang('backups_dropbox_validate_path'));
				$has_passed = false;
			}
		}

		return $has_passed;
	}
	
	/**
	 * Core Validate Populate
	 * Sets the form fields post validation
	 * @return array Form fields
	 **/
	public function core_validate_populate()
	{
		$data = array();
		$data['oauth_token'] = set_value($this->_get_field_with_prefix('oauth_token'));
		$data['oauth_token_secret'] = set_value($this->_get_field_with_prefix('oauth_token_secret'));
		$data['bucket'] = '';
		$data['path'] = set_value($this->_get_field_with_prefix('path'));
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
		$this->dropbox->set_oauth_access(array(
			'oauth_token' => $preset->username,
			'oauth_token_secret' => $preset->password
		));

		$check = $this->dropbox->account();
		if(isset($check->error))
		{
			return false;
		}

		$res = $this->dropbox->add($preset->path, $file);
		return !isset($res->error);
	} 

	/**
	 * Core Present Account
	 * Returns a human readable version for each account
	 * @param Object $row Account details
	 * @return string Presentable row
	 **/
	public function core_present_account($row)
	{
		$this->dropbox->set_oauth_access(array(
			'oauth_token' => $row->username,
			'oauth_token_secret' => $row->password
		));

		$data = $this->dropbox->account();
		if(isset($data->error))
		{
			return '';
		}
		return $data->email.' ('.$row->username.') '.(($row->path == NULL) ? '' : ' - '.$row->path);
	}
	
	/**
	 * Validate Path
	 * Validates a provided file path
	 **/
	private function _validate_path($path)
	{
		$path = trim($path);
		if($path == '')
			return $path;
		
		if(substr($path, -1) != '/')
			$path .= '/';
			
		if($path[0] == '/')
			$path = substr($path, 1);
		
		return $path;
	}
}
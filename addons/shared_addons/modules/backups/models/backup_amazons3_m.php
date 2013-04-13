<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Backup_amazons3_m extends MY_Model
{

	// Access Key
	private $_access;
	// Secret Key
	private $_secret;
	// S3 object
	private $_s3;
	// Buckets
	private $_buckets;
	private $_bucket;
	// Checks if authentication has been completed.
	private $_auth_has_been_called = false;
	
	/**
	 * Construct
	 **/
	public function __construct()
	{
		parent::__construct();
		$this->load->helper('amazons3');

		$this->lang->load('backups_'.$this->core_get_short_name());
		
		// Specific JS for this backup method
		$this->template->append_metadata('
				<script type="text/javascript">
				function check_as3_file_path(){
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
					
					check_as3_file_path();
					$(\'#'.$this->_get_field_with_prefix('path').'\').change(function (){
						check_as3_file_path();
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
		return lang('backups_amazons3_name');		
	}
	
	/**
	 * Core Get Short Name
	 * Gets the unique name of this backup method. Should be unix friendly. 
	 * @return string Short name
	 **/
	public function core_get_short_name()
	{
		return 'amazons3';
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
				'field' => $this->_get_field_with_prefix('access_key'),
				'label' => lang('backups_amazons3_access_key'),
				'rules' => 'required|trim',
				'input' => form_input($this->_get_field_with_prefix('access_key'), 
				(($data != false && $this->core_get_short_name() == $data->account_type) ? $data->username : set_value($this->_get_field_with_prefix('access_key'))), 'maxlength="70" placeholder="'.lang('backups_amazons3_access_key_placeholder').'"'),
				'is_required' => true,
				'row_class' => 'even',
				'db_alias' => 'username'
			),
			
			array(
				'field' => $this->_get_field_with_prefix('secret_key'),
				'label' => lang('backups_amazons3_secret_key'),
				'rules' => 'required|trim',
				'input' => form_input($this->_get_field_with_prefix('secret_key'), (($data != false && $this->core_get_short_name() == $data->account_type) ? $data->password : set_value($this->_get_field_with_prefix('secret_key'))), 'maxlength="70" placeholder="'.lang('backups_amazons3_secret_key_placeholder').'"'),
				'is_required' => true,
				'row_class' => '',
				'db_alias' => 'password'
			),
			
			array(
				'field' => $this->_get_field_with_prefix('bucket'),
				'label' => lang('backups_amazons3_bucket'),
				'rules' => 'required|trim',
				'input' => form_input($this->_get_field_with_prefix('bucket'), (($data != false && $this->core_get_short_name() == $data->account_type) ? $data->bucket : set_value($this->_get_field_with_prefix('bucket'))), 'maxlength="70" placeholder="'.lang('backups_amazons3_bucket_placeholder').'"'),
				'is_required' => true,
				'placeholder' => lang('backups_amazons3_bucket_placeholder'),
				'row_class' => 'even',
				'db_alias' => 'bucket'
			),
			
			array(
				'field' => $this->_get_field_with_prefix('path_specific'),
				'label' => lang('backups_amazons3_path'),
				'rules' => 'trim',
				'input' => form_dropdown($this->_get_field_with_prefix('path'), array('root' => lang('backups_amazons3_path_root'), 'specific' => lang('backups_amazons3_path_other')), 

					(($data != false && $this->core_get_short_name() == $data->account_type) ?
									
									(
										($data->path == NULL) ?
												'root' 
												: 'specific'
										
									)

									:

									$this->input->post($this->_get_field_with_prefix('path'))


					)

					, 'id="'.$this->_get_field_with_prefix('path').'"'). form_input($this->_get_field_with_prefix('path_specific'), (($data != false && $this->core_get_short_name() == $data->account_type) ? $data->path : set_value($this->_get_field_with_prefix('path_specific'))), 'maxlength="70" id="'.$this->_get_field_with_prefix('path_specific').'" style="margin-left: 10px;" placeholder="'.lang('backups_amazons3_path_other_placeholder').'"'),
				'is_required' => true,
				'row_class' => '',
				'db_alias' => 'path'
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
			->select('account_id, account_type, username, password, bucket, path')
			->from('backup_accounts')
			->where('account_type', $this->core_get_short_name())
			->order_by('account_type', 'asc')
			->get()
			->result();
		$result = array();
		
		foreach($data as $row)
		{
			$result[$row->account_id] = $row->username.' - '.$row->bucket.' - '.$row->path;
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
		$data['username'] = $form_data[$this->_get_field_with_prefix('access_key')];
		$data['password'] = $form_data[$this->_get_field_with_prefix('secret_key')];
		$data['bucket'] = $form_data[$this->_get_field_with_prefix('bucket')];
		$data['path'] = ($form_data[$this->_get_field_with_prefix('path')] == 'root') ? '' : $this->_validate_path($form_data[$this->_get_field_with_prefix('path_specific')]);
		
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
		// Authenticate the account
		$this->auth($this->input->post($this->_get_field_with_prefix('access_key')), $this->input->post($this->_get_field_with_prefix('secret_key')));
		
		if(!$this->set_bucket($this->input->post($this->_get_field_with_prefix('bucket'))) && $this->input->post($this->_get_field_with_prefix('bucket')) != '')
		{
			$this->form_validation->set_message('preset_form_validate', 

				sprintf(
					lang('backups_amazons3_validation_failed'), 
					$this->input->post($this->_get_field_with_prefix('bucket'))));

			$has_passed = false;
		}
		// Check that the path validates
		if($this->input->post($this->_get_field_with_prefix('path')) == 'specific')
		{
			$path = $this->input->post($this->_get_field_with_prefix('path_specific'));
			if(!preg_match('([^\0]+)', $path))
			{
				$this->form_validation->set_message('preset_form_validate', lang('backups_amazons3_validation_path'));
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
		$data['access_key'] = set_value($this->_get_field_with_prefix('access_key'));
		$data['secret_key'] = set_value($this->_get_field_with_prefix('secret_key'));
		$data['bucket'] = set_value($this->_get_field_with_prefix('bucket'));
		$data['backup_path'] = set_value($this->_get_field_with_prefix('backup_path'));
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
		$this->auth($preset->username, $preset->password);
		if(!$this->set_bucket($preset->bucket))
		{
			$this->presets_m->set_error($preset->preset_id, 'backups_amazons3_errors_no_bucket_or_auth');
			return false;
		}
		
		if($this->_s3->putObjectFile($file, $this->_bucket, $this->_validate_path($preset->path).basename($file), S3::ACL_PRIVATE))
			return true;
			
		$this->presets_m->set_error($preset->preset_id, 'backups_amazons3_errors_put_file');
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
		return $row->username.' - '.$row->password.' - '.$row->bucket.(($row->path == NULL) ? '' : ' - '.$row->path);
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
	
	/**
	 * Auth
	 * Authenticates with Amazon S3
	 * @param string $access Access Key
	 * @param string $secret Secret Key
	 * @return true
	 **/
	private function auth($access, $secret)
	{
		$this->_access = $access;
		$this->_secret = $secret;
		$this->_s3 = create_s3($access, $secret);
		$this->_auth_has_been_called = true;
		return true;
	}
	
	/**
	 * Get Buckets
	 * Gets the buckets on the Amazon S3 account
	 * @return array Buckets
	 **/
	private function get_buckets()
	{
		$buckets = @$this->_s3->listBuckets();
		$this->_buckets = $buckets;
		if($buckets == NULL)
			return false;
		
		return $buckets;
	}
	
	/**
	 * Set Bucket
	 * Sets the target bucket
	 * @return bool Success or failure
	 **/
	public function set_bucket($bucket)
	{
		if(!$this->_auth_has_been_called)
			return false;
			
		if($this->bucket_exists($bucket))
		{
			$this->_bucket = $bucket;
			return true;
		}
		
		return false;
	}

	/**
	 * Bucket exists
	 * Check if a bucket exists
	 * @param string $bucket Bucket to check
	 * @return bool Success or failure
	 **/
	private function bucket_exists($bucket)
	{
		if($this->get_buckets() != false)
		{
			foreach($this->_buckets as $row)
			{
				if($bucket == $row)
					return true;
			}
			
		}
		
		return false;
	}
}
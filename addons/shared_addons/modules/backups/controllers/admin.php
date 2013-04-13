<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Admin extends Admin_Controller {
	
	
	/**
	 * Construct
	 **/
	function __construct()
	{
		parent::__construct();
		$this->load->model('presets_m');
		$this->load->model('backup_m');

		$this->load->library('form_validation');

		$this->lang->load('backups');

		if(version_compare(CMS_VERSION, '2.1', '>='))
		{
			$this->template->append_js('module::core.js');
		}
		else
		{
			$this->template->append_metadata( js('core.js', 'backups'));
		}
	}

	/**
	 * Index
	 * Preset display page
	 **/
	public function index()
	{
		$this->template->active_section = 'presets';
		$data['presets'] = $this->presets_m->get_presets();
		$this->template->build('admin/index', $data);
	}
	
	/**
	 * Preset
	 * Displays and processes the Presets form. Used for editing and creation.
	 * @param int $preset_id Preset ID if editing
	 **/
	public function preset($preset_id = false)
	{
		$this->template->active_section = 'add_preset';
		$this->load->library('form_validation');
		
		if($preset_id != false)
		{
			$preset = $this->presets_m->get_preset($preset_id);
			if(empty($preset))
			{
				$this->session->set_flashdata('error', lang('backups_preset_not_found'));
				redirect('admin/backups/');
			}
		}		
		
		$data['backup_methods'] = $this->backup_m->get_form_backup_methods();
		
		if(isset($_POST['name']))
		{
			// Form submitted 
			$new_account_required = false; 
			
			$this->form_validation->set_rules('name', lang('backups_name'), 'required|trim');
			$this->form_validation->set_rules('description', lang('backups_description'), 'trim');
			$this->form_validation->set_rules('method', lang('backups_backup_method'), 'required|callback_preset_form_validate');
			$this->form_validation->set_rules('tables_select', lang('backups_tables'), 'required');
			
			
			if($this->backup_m->is_backup_method($this->input->post('method')))
			{
				$this->form_validation->set_rules($this->backup_m->get_form_validation_rules($this->input->post('method')));
			}
			
			if($this->form_validation->run() == false)
			{				
				$data['preset'] = false;
				$data['accounts'] = false;
				
				$data['form_data']['name'] = set_value('name');
				$data['form_data']['description'] = set_value('description');
				$data['form_data']['tables_select'] = set_value('tables_select');
				$data['form_data']['tables_selection'] = $this->presets_m->get_tables();
				
				$data['form_data']['tables_picked'] = ($this->input->post('tables_selection') != false) ? $this->input->post('tables_selection') : array();
				$data['form_data']['prefix'] = set_value('prefix');
				$data['form_data']['method'] = set_value('method');

				//Add in each of the methods
				array_push($data['form_data'], $this->backup_m->validation_populate_fields());
				
				$data['backup_fields'] = $this->backup_m->get_form_backup_fields();
				
				$this->template->build('admin/presets_form', $data);
				return true;
			}
			else 
			{
				// Time to handle the submission
				$preset_info = array();
				
				$preset_info['name'] = $this->input->post('name');
				$preset_info['description'] = $this->input->post('description');
				
				$tables_check = (isset($_POST['tables_selection'])) ? implode(', ', $this->input->post('tables_selection')) : NULL;
				
				switch ($this->input->post('tables_select')) {
					case 'specific':
						$preset_info['tables'] = $tables_check;
					break;
					case 'prefix':
						$preset_info['tables'] = 'prefixes:'.$this->input->post('prefix');
					break;
					default:
						$preset_info['tables'] = null;
					break;
				}

				$account_id = $this->input->post('method');
				
				// Determine if they want to create a new account
				if($this->backup_m->is_backup_method($account_id))
				{
					$account_id = $this->backup_m->get_model($account_id)->core_handle_account($this->input->post());
				}

				if($account_id == 'none')
				{
					$account_id = NULL;
				}

				$preset_info['account_id'] = $account_id;
				$preset_info['created_on'] = date('Y:m:d H:i:s');
				
				
				if($preset_id == NULL)
				{
					$pid = $this->presets_m->create_preset($preset_info);
					$this->session->set_flashdata('success', lang('backups_preset_created'));
				}
				else 
				{
					$pid = $this->presets_m->update_preset($preset_info, $preset_id);
					$this->session->set_flashdata('success', lang('backups_preset_updated'));
				}
				
				redirect('admin/backups/view/'.$pid);								
			}
				
		}
		else 
		{
			// Load the form			
			
			$data['form_data']['name'] = ($preset_id != false) ? $preset->name : '';
			$data['form_data']['description'] = ($preset_id != false) ? $preset->description : '';
			
			if($preset_id != false){
				switch ($preset->tables_type) {
					case 'prefix':
						$table_select = 'prefix';
					break;

					case 'specific':
						$table_select = 'specific';
					break;

					default:
						$table_select = 'all';
					break;
				}

			}
				
			$data['form_data']['tables_select'] = ($preset_id != false) ? $table_select : 'all';
			
			$data['form_data']['tables_selection'] = $this->presets_m->get_tables();
			$data['form_data']['tables_picked'] = ($preset_id != false) ? explode(', ', $preset->tables) : array();
			$data['form_data']['tables'] = ($preset_id != false) ? $preset->tables_raw : '';

			
			$data['form_data']['prefix'] = ($preset_id != false) ? $preset->tables_raw : '';
			$data['form_data']['method'] = ($preset_id != false) ? $preset->account_id : '';
			
			$data['preset'] = false;
			$data['accounts'] = false;
			
			$data['backup_fields'] = $this->backup_m->get_form_backup_fields();
			
			$this->template->build('admin/presets_form', $data);
		}
	}

	/**
	 * View
	 * Displays the Preset's details
	 * @param int $preset_id Preset ID
	 **/
	public function view($preset_id)
	{		
		$data['preset'] = $this->_check_preset($preset_id);
		$data['preset_account'] = $this->backup_m->get_model($data['preset']->account_type)->core_get_table_view($data['preset']);

		$this->template->build('admin/view_preset', $data);
	}
	
	/**
	 * Delete
	 * Delete's a Preset
	 * @param int $preset_id Preset ID
	 **/
	public function delete($preset_id)
	{
		$data['preset'] = $this->_check_preset($preset_id);
		$this->presets_m->delete_preset($preset_id);
		$this->session->set_flashdata('success', lang('backups_preset_deleted'));
		redirect('admin/backups');
	}

	/**
	 * Preset Form validate
	 * The callback used to validate a backup methods fields. These are unknown until runtime.
	 * @param string $method Form data used as a hook
	 * @return bool
	 **/
	public function preset_form_validate($method)
	{
		if($this->backup_m->is_backup_method($method))
		{	
			return $this->backup_m->get_model($method)->core_validate_callback();
		}
		
		return true;
	}
	
	/**
	 * Run
	 * Use to run a backup method using its account manually via the Admin UI
	 * @param int $preset_id Preset ID
	 **/
	public function run($preset_id)
	{
		$this->load->model('backup_m');
		if($this->backup_m->backup($preset_id))
		{
			$this->session->set_flashdata('success', lang('backups_passed'));
			redirect('admin/backups/view/'.$preset_id);
		}
		else 
		{
			$this->session->set_flashdata('error', lang('backups_failed'));
			redirect('admin/backups/view/'.$preset_id);	
		}
		
		return true;
	}
	
	/**
	 * Snapshot
	 * Generates a downloadable snapshot of the DB. Optionally is can produce a snapshot a Preset's configuration
	 * @param $preset_id Preset ID
	 **/
	public function snapshot($preset_id = false)
	{
		if($preset_id == false)
			$this->backup_m->backup();
		else
			$this->backup_m->backup($preset_id, true);
	}

	/**
	 * Check Preset
	 * Used internally to check if a Preset exists. If it doesnt exist it redirects the user, otherwise it returns the data.
	 * @param int $pid Preset ID
	 * @return mixed
	 **/
	private function _check_preset($pid)
	{
		$preset = $this->presets_m->get_preset($pid);
		
		if(empty($preset))
		{
			$this->session->set_flashdata('error', 'Sorry, the Preset could not be found.');
			redirect('admin/backups');
		}
		return $preset;
	}
	
	/**
	 * Accounts
	 * Displays all of the accounts
	 **/
	public function accounts()
	{
		$this->template->active_section = 'accounts';
		$section = 'accounts';
		$data['accounts'] = $this->presets_m->get_accounts();
		$this->template->build('admin/accounts', $data);
	}

	/**
	 * Accounts Form
	 * Displays and processes the Accounts form
	 * @param int $account_id Account ID
	 **/
	public function accounts_form($account_id = false)
	{
		$this->template->active_section = 'add_account';
		$section = 'accounts';
		$data = array();
		$data['form_data'] = array();
		$this->load->library('form_validation');

		if($account_id != false)
		{
			$account = $this->presets_m->get_account($account_id);
			
			if($account == null)
			{
				$this->session->set_flashdata('error', lang('backups_accounts_no_account'));
				redirect('admin/backups/accounts');
			}

		}
		else
			$account = false;


		if(isset($_POST['method']))
		{
			$this->form_validation->set_rules('method', lang('backups_backup_method'), 'required|callback_preset_form_validate');

			if($this->backup_m->is_backup_method($this->input->post('method')))
			{
				$this->form_validation->set_rules($this->backup_m->get_form_validation_rules($this->input->post('method')));
			}

			if($this->form_validation->run() == false)
			{
				$data['backup_methods'] = $this->backup_m->get_form_backup_methods_simplistic();

				$data['backup_fields'] = $this->backup_m->get_form_backup_fields();

				array_push($data['form_data'], $this->backup_m->validation_populate_fields());

				$data['form_data']['method'] = set_value('method');

				$this->template->build('admin/accounts_form', $data);
				return true;
			}
			else
			{
				// Form validated successfully.
				$account_details = $this->input->post();
				if($account_id == false)
				{
					// Create new account
					$res = $this->backup_m->get_model($this->input->post('method'))->core_handle_account($account_details);
					
					$this->session->set_flashdata('success', lang('backups_account_created'));
				}
				else
				{
					$res = $this->backup_m->get_model($this->input->post('method'))->core_handle_account($account_details, $account_id);
					$this->session->set_flashdata('success', lang('backups_account_updated'));
				}

				redirect('admin/backups/accounts');
				return true;
			}
		}

		$data['form_data']['method'] = ($account_id != false) ? $account->account_type : '';
		
		$data['backup_methods'] = $this->backup_m->get_form_backup_methods_simplistic();

		$data['backup_fields'] = $this->backup_m->get_form_backup_fields($account);

		
		$this->template->build('admin/accounts_form', $data);
	}

	/**
	 * Delete Account
	 * Delete's an account. If there are dependencies on this account, then they are removed. 
	 * @param int $account_id Account ID
	 **/
	public function delete_account($account_id)
	{
		$account = $this->presets_m->get_account($account_id);
		if(empty($account))
		{
			$this->session->set_flashdata('error', lang('backups_account_not_found'));
			redirect('admin/backups/accounts');
		}

		// Get all the presets using this account
		$presets = $this->presets_m->get_presets_by_account_id($account_id);
		if(!empty($presets))
		{
			// What we're going to update
			$data = array();
			$data['account_id'] = NULL;

			foreach($presets as $preset)
			{
				$this->presets_m->update_preset($data, $preset->preset_id);
				$this->presets_m->clear_error($preset->preset_id);
			}
		}

		$this->presets_m->delete_account($account_id);
		$this->session->set_flashdata('success', lang('backups_account_deleted'));
		redirect('admin/backups/accounts');
	}

	public function oauth_endpoint()
	{
		$this->load->model('backup_dropbox_m');
		$oauth = $this->dropbox->get_access_token($this->session->userdata('token_secret'));

		echo '<script type="text/javascript">
				var wind = self.opener;

				wind.document.getElementById(\'dropbox_oauth_token_secret\').value = \''.$oauth['oauth_token_secret'].'\';
				wind.document.getElementById(\'dropbox_oauth_token\').value = \''.$oauth['oauth_token'].'\';
				
				wind.check_status();
				self.close();
			</script>';
	}
	
}
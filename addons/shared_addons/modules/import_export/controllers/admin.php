<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
/**
 * Import/Export Module -> Import
 *
 * @author 		Zac vineyard
 * @website		http://zacvineyard.com
 * @package 	PyroCMS
 * @subpackage 	Import/Export Module
 */
class Admin extends Admin_Controller
{
	/**
	 * The current active section
	 * @access protected
	 * @var string
	 */
	protected $section = 'import';

	public function __construct()
	{
		parent::__construct();

		// Load all the required classes
		$this->load->library('form_validation');
		$this->lang->load('ie');
		$this->load->model('import_m');

		// Set the validation rules
		$this->item_validation_rules = array(
			array(
				'field' => 'name',
				'label' => 'Name',
				'rules' => 'trim|max_length[100]|required'
			),
			array(
				'field' => 'slug',
				'label' => 'Slug',
				'rules' => 'trim|max_length[100]|required'
			)
		);

		// Set partials
		//$this->template->append_js('module::admin.js')->append_css('module::admin.css');
	}

	/**
	 * Upload a PyroCMS XML export file
	 */
	public function index()
	{
		// XML Upload
		$this->template->title($this->module_details['name'])->build('admin/import');
	}

	public function upload()
	{
		$config['upload_path'] = 'uploads/'.SITE_REF.'/import_export';
		$config['allowed_types'] = 'xml';
		//$config['max_size']	= '5000';
		$config['remove_spaces'] = true; 
		$config['overwrite'] = true;

		$this->load->library('upload', $config);

		if (!$this->upload->do_upload())
		{
			$this->session->set_flashdata('error', lang('ie:upload_error'));
			redirect('admin/'.$this->module_details['slug']);
		}
		else
		{
			$data = $this->upload->data();
			if($this->input->post('btnAction') == 'import')
			{
				$this->parse($data['file_name']);
			}
			elseif($this->input->post('btnAction') == 'wp_import')
			{
				$this->wp_parse($data['file_name']);
			}
		}
	}

	public function parse($file)
	{
		$xml = file_get_contents('uploads/'.SITE_REF.'/import_export/'.$file);
		$obj = simplexml_load_string($xml);

		// Site prefix
		$site_ref = (string) $obj->site_ref;

		// CMS version of content
		$cms_version = (string) $obj->cms_version;

		// CMS edition of content
		$cms_edition = (string) $obj->cms_edition;

		// Which modules are there? Should probably go through an installer. (STILL NEEDED)
		//echo '<pre>';
		//print_r($obj->{$site_ref.'_modules'});
		//die();

		// If versions don't match, freak out
		if(CMS_VERSION != $cms_version)
		{
			// Redirect
			$this->session->set_flashdata('error', str_replace("%s",$cms_version,lang('ie:version_mismatch')));
			redirect('admin/'.$this->module_details['slug']);
		}

		// If editions don't match, freak out
		if(CMS_EDITION != $cms_edition)
		{
			// Redirect
			$this->session->set_flashdata('error', str_replace("%s",$cms_edition,lang('ie:edition_mismatch')));
			redirect('admin/'.$this->module_details['slug']);
		}

		// The loop below needs to be a class (STILL NEEDED)

		foreach($obj as $table_name => $table_data)
		{
			// Transform $table_name (STILL NEEDED)
			//$table_name = str_replace($site_ref."_","default_",$table_name);

			if(!strstr($table_name,"ci_sessions"))
			{
				if ($this->db->table_exists($table_name))
				{
					// Get db table field types
					$fields = $this->import_m->get_fields($table_name);

					// Empty the table, with exception for users table
					if(strstr($table_name,"users") || strstr($table_name,"profiles"))
					{
						if($this->input->post('import_users') == 'accept')
						{
							$this->db->empty_table($table_name);
						}						
					}
					else
					{
						$this->db->empty_table($table_name);
					}

					// Insert data from XML
					foreach($table_data->item as $record)
					{
						$out = array();
						foreach($record as $k => $v)
						{
							// If value is empty, check column type and type accordingly, else build string
							if((string) $v == null)
							{
								if(strstr($fields[$k]['type'],'int(') || strstr($fields[$k]['type'],'datetime'))
								{
									$out[$k] = intval($v);
								}
								else
								{
									$out[$k] = "";
								}
							}
							else
							{
								$out[$k] = (string) $v;
							}
						}

						if((strstr($table_name,"blog") && !strstr($table_name,"blog_categories")) && ($this->input->post('import_users') == 'accept'))
						{
							$out['author_id'] = $this->session->userdata('id');
						}

						if(strstr($table_name,"users") || strstr($table_name,"profiles")) {
							if($this->input->post('import_users') == 'accept')
							{
								$sql = $this->db->insert_string($table_name,$out);
								$this->db->query($sql);
							}
						}
						else
						{
							$sql = $this->db->insert_string($table_name,$out);
							$this->db->query($sql);
						}
					}
				}
			}
		}

		// Redirect
		$this->session->set_flashdata('success', lang('ie:import_success'));
		redirect('admin/'.$this->module_details['slug']);

	}
	
	public function get_filtered_xml($file)
	{
		$xml = file_get_contents('uploads/'.SITE_REF.'/import_export/'.$file);
		
		return simplexml_load_string($xml);
	}

	public function wp_parse($file) 
	{
		set_time_limit(0);

		$this->load->library('wp_import');
				
		// Defaults
		$comments = array();		
		
		// Get the XML from the uploaded file
		$xml = $this->get_filtered_wp_xml($file);
		
		// Load the wp_import Library
		$this->load->library('wp_import');
		
		// Check for duplicate post titles
		$titles = $this->wp_import->has_duplicate_titles($xml);
		
		if ($titles)
		{
			$this->template
				->title($this->module_details['name'])
				->set('items', $titles)
				->build('admin/duplicates');
			return;
		}

		// Import Categories
		$this->wp_import->categories($xml);
		
		// Import Tags
		$this->wp_import->tags($xml);
		
		// Import Posts
		$this->wp_import->posts($xml);
		
		// Import Comments
		$this->wp_import->comments($xml);
		
		// Import Users
		$this->wp_import->users($xml); // Currently only imports users who aren't already in the system

		// Import Pages
		$this->wp_import->pages($xml);
		$this->session->set_flashdata('success', lang('ie:import_wp_success'));

		redirect('admin/import_export');
	}

	public function get_filtered_wp_xml($file)
	{
		$xml = file_get_contents('uploads/'.SITE_REF.'/import_export/'.$file);
		
		return simplexml_load_string(str_replace(array(
			'content:encoded',
			'excerpt:encoded',
			'wp:',
		), array(
			'content',
			'excerpt',
			'',
		), $xml));
	}
}

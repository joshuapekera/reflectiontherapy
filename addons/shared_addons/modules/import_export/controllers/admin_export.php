<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
/**
 * Import/Export Module -> Export
 *
 * @author 		Zac vineyard
 * @website		http://zacvineyard.com
 * @package 	PyroCMS
 * @subpackage 	Import/Export Module
 */
class Admin_export extends Admin_Controller
{
	/**
	 * The current active section
	 * @access protected
	 * @var string
	 */
	protected $section = 'export';

	public function __construct()
	{
		parent::__construct();

		// Load all the required classes
		$this->lang->load('ie');
		$this->load->model('export_m');
		$this->load->helper('download');
		$this->load->library('format'); // From core
	}

	/**
	 * Export form
	 */
	public function index()
	{	
		// Get all sites in the system
		/*
		$sites = $this->export_m->get_sites();
		
		$site_list = array();
		
		foreach($sites as $site)
		{
			$site_list[$site['ref']] = $site['name'];
		}
		*/
		$this->form_validation->set_rules('btnAction', 'btnAction', 'required');

		if ($this->form_validation->run() == FALSE)
		{
			$this->template->title($this->module_details['name'])
						   //->set('sites',$site_list)
						   ->build('admin/export');
		}
		else
		{
			$this->_export_site(SITE_REF);
		}
	}

	/**
	 * Export to XML
	 */
	public function _export_site($prefix)
	{
		$table_list = $this->export_m->get_all_db_tables($prefix);

		// Sort
		asort($table_list);

		$output = "";

		// Set databse prefix for counting
		$this->db->set_dbprefix($prefix.'_');

		if($table_list)
		{
			foreach ($table_list as $key => $table)
			{
				// If database isn't empty, add to output
				if($this->db->count_all($table) > 0)
				{
					$output .= $this->_prep_xml($this->export_m->export($table,'xml'),$table);
				}
			}
		}

		// Reset databse prefix
		$this->db->set_dbprefix(SITE_REF.'_');

		$output = $this->_finalize_xml($output,$prefix);
		force_download($prefix.'_'.time().'.xml', $output);
	}

	/*
	public function export_blog()
	{
		// Build the complete XML file
		//$output = str_replace('<xml>','<xml><blog>',str_replace('</xml>','</blog>',$this->export_m->export('blog','xml')));
		$output = $this->_prep_first_table($this->export_m->export('blog','xml'),'blog');
		$output .= $this->_prep_last_table($this->export_m->export('blog_categories','xml'),'blog_categories');
		
		$obj = simplexml_load_string($output);
		echo '<pre>';
		print_r($obj);
		die();
		//force_download('blog.xml', $output);
		//return $output;
	}
	*/

	function _prep_xml($xml,$table)
	{
		$xml = str_replace('<?xml version="1.0" encoding="utf-8"?>','',$xml);
		$xml = str_replace('<xml>','<'.$table.'>',$xml);
		$xml = str_replace('</xml>','</'.$table.'>',$xml);
		return $xml;
	}

	function _finalize_xml($xml,$prefix)
	{
		$xml = '<?xml version="1.0" encoding="utf-8"?><xml><cms_version>'.CMS_VERSION.'</cms_version><cms_edition>'.CMS_EDITION.'</cms_edition><site_ref>'.$prefix.'</site_ref>'.$xml.'</xml>';
		return $xml;
	}

}

<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class CI_Ajax {

	var $rows				= array();
	var $heading			= array();
	var $auto_heading		= TRUE;	
	var $caption			= NULL;	
	var $template 			= NULL;
	var $newline			= "\n";
	var $empty_cells		= "";
	
	
	function CI_Ajax()
	{
		log_message('debug', "Ajax Class Initialized");
	}

	
	function set_js($filename, $base_url, $folder, $type)
	{
		if($type == "js")
		{
			return "\n<script type='text/javascript' src='".$base_url.$folder.$filename."'></script>\n";
		}
		else if($type == "css")
		{
			return "\n<link rel='stylesheet' href='".$base_url.$folder.$filename."'>\n";
		}
	}
	function set_customerfile($filestring)
	{
		return "\n".$filestring."\n";
	}
	
	

}


/* End of file Table.php */
/* Location: ./system/libraries/ajax.php */
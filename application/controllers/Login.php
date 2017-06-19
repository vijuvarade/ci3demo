<?php
class Login extends CI_Controller {
	
	function __construct()
	{
			parent::__construct();
			//$this->load->library('xml_dynamicform'); 
			$this->load->library('session');
			$this->output->set_header('Last-Modified:'.gmdate('D, d M Y H:i:s').'GMT');
			$this->output->set_header('Cache-Control: no-store, no-cache, must-revalidate');
			$this->output->set_header('Cache-Control: post-check=0, pre-check=0',false);
			$this->output->set_header('Pragma: no-cache');
			
			
	}
	
	function index()
	{
		if($this->session->IS_LOGED_IN_DEMOATS() != 0){
				redirect(base_url().'dashboard');
			}
			elseif($this->session->IS_LOGED_IN_DEMOATS() == 1)
			{
				redirect(base_url().'login');
			}
		
		$this->load->helper("form");
		//$this->load->library('ajax');
		$this->load->helper("html");
		$this->load->library('form_validation');
		$js_files = "";
		$data['js_files'] 	=  $js_files;
		$this->load->view('vsp_login', $data);
		//$data['main_content'] = 'login_form';
		//$this->load->view('includes/template', $data);	
	}
	function test(){
		echo 'test function'; exit;
	}
	function validate_credentials()
	{		
		$this->load->helper("form");
		$this->load->model('User_model');
		$this->load->library('form_validation');
		$this->load->helper("html");
		
		$query = $this->User_model->validate();
		//$this->db->_error_message();
		
		//field name, error message, validation rules
		$this->form_validation->set_rules('user_name', 'Email address', 'trim|required');
		$this->form_validation->set_rules('user_pass', 'Password', 'trim|required');
		
		//$data['redirectPopup'] = '';
		if($this->form_validation->run() == FALSE)
		{
			$value =  validation_errors('<div>');
			echo '<div class="alert alert-danger alert-dismissable">
                   <i class="fa fa-ban"></i><button aria-hidden="true" data-dismiss="alert" class="close" type="button">×</button>
                '.$value.'</div>';
		
		}else if($query){ // if the user's credentials validated...
		
		//$rows = $query->result_array();
		//echo "<pre>";
		//print_r($rows); exit;
		
		foreach ($query->result() as $row){ 
			$this->session->set_userdata('UID_DEMOATS', $row->u_id);
			$this->session->set_userdata('UTYPE_DEMOATS', $row->u_type_id);
			$this->session->set_userdata('UEMAIL_DEMOATS', $row->user_email);
		}
		
		$this->session->set_userdata(array('IS_LOGED_IN_DEMOATS' => true));
		//redirect('welcome');
		if($this->session->userdata('UTYPE_DEMOATS') == 1) {  // hiring mgr login 
			//redirect(base_url().'user');
			echo '1';	
		}else{  //admin or super admin 1,2
			
			//redirect(base_url().'user');
			echo '2';	
		}
		exit;
		}else{  // incorrect username or password
				echo '<div class="alert alert-danger alert-dismissable">
                   <i class="fa fa-ban"></i><button aria-hidden="true" data-dismiss="alert" class="close" type="button">×</button>
                Invalid login credentials</div>';
			
			exit;
		}
		exit;
	}

	function logout()
	{
		/*$this->session->unset_userdata('IS_LOGED_IN_DEMOATS');
		$this->session->unset_userdata('UEMAIL_DEMOATS');
		$this->session->unset_userdata('UTYPE_DEMOATS');
		$this->session->unset_userdata('UID_DEMOATS');
*/		$this->session->sess_destroy();
		redirect(base_url().'login');
		//$this->index();
	}


function auto_login()
	{
		$this->load->database();
		$this->load->helper("form");
		$this->load->model('User_model');
		$this->load->library('session');
		$this->load->helper('url');
	
		$user = base64_decode($this->uri->segment(3));
		$pass = base64_decode($this->uri->segment(4));

		$this->db->where('user_email',$user);
		$this->db->where('user_pass', $pass);
		$this->db->where('is_active',1);
		$query = $this->db->get('tbl_user');
		
		
		if($query){ 
		foreach ($query->result() as $row){ 
			$this->session->set_userdata('UID_DEMOATS', $row->u_id);
			$this->session->set_userdata('UTYPE_DEMOATS', $row->u_type_id);
			$this->session->set_userdata('UEMAIL_DEMOATS', $row->user_email);
		}
		
		$this->session->set_userdata('IS_LOGED_IN_DEMOATS',true);
		//redirect('welcome');

		if($query->num_rows()>0){
			if($this->session->userdata('UTYPE_DEMOATS') == 4) {  // hiring mgr login 
				redirect(base_url().'jobsSmgr/jobsSmgrList');
			}else /*if($this->session->userdata('UTYPE_DEMOATS') == 3 || $this->session->userdata('UTYPE_DEMOATS')== 1)*/ {  
				redirect(base_url());
			}
		}
		exit;
		}
		
	}


}

?>
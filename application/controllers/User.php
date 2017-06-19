<?PHP
class User extends CI_Controller {
	function __construct()
	{
		parent::__construct();
		//$this->load->helper("restrict_pages");
		
		if($this->session->IS_LOGED_IN_DEMOATS() == 0){
		redirect('login');
		}
		
		////////// Only super admin and admin have access to this page/////////////// By Pravin
		if($this->session->userdata('UTYPE_DEMOATS') != 1 and $this->session->userdata('UTYPE_DEMOATS') != 2 ){
			show_error('Access denied !',500,'Security check');
		}
		////////////////////////////////////////////////////////////////////////////////
		
		
		
	}
	

	function index()
	{
		$this->userList();
	}

	function addUserOnload(){
		$data['js_files'] = '';
		$data['main_content'] = 'tpl_addUserOnload';
		$this->load->view('includes/template', $data);	
	}
	
	function addUser(){
		
		$this->load->helper("form");
		$this->load->helper('url');
		$this->load->helper("html");
		$this->load->library('Ajax');
		$this->load->library('form_validation');
		$this->load->model('user_model');
		$data['js_files'] = '';
		
		$data['userType'] = $this->user_model->getUserTypeList();
		$this->load->view('tpl_addUser', $data);
		//$this->load->view('includes/template', $data);
	}


	function addUserAjax()
    {
		$this->load->helper("form");
		$this->load->helper('url');
		$this->load->helper("html");
		$this->load->library('Ajax');
		$this->load->library('form_validation');
		$this->load->model('user_model');
		$this->load->model('systeminfo_model');
		$data['js_files'] = '';
		//field name, error message, validation rules
		$this->form_validation->set_rules('first_name', 'Fist name', 'trim|required');
		$this->form_validation->set_rules('last_name', 'Last name', 'trim|required');
		$this->form_validation->set_rules('user_email', 'Email', 'trim|required|callback_duplicate_user_email');
		$this->form_validation->set_rules('designation', 'Job Title', 'trim|required');
		//$this->form_validation->set_rules('user_name', 'User Name', 'trim|required|callback_duplicate_user_name');
		$this->form_validation->set_rules('user_pass', 'Password', 'trim|required|min_length[4]|max_length[32]');
		$this->form_validation->set_rules('user_pass2', 'Password confirmation', 'trim|required|matches[user_pass]');
		$this->form_validation->set_rules('u_type_id', 'User type select ', 'trim|required');
		
		//$data['redirectPopup'] = '';
		if($this->form_validation->run() == FALSE)
		{
			$value =  validation_errors('<div>');
			//if($value){
			echo "<div id='errors' class='alert alert-error'><button type='button' class='close' data-dismiss='alert'>×</button>
			<strong>Following error(s) occur while saving data.</strong><br><br>".$value."</div>";
			//}
		}
		else
		{	
			$insert_id = $this->user_model->insert_user();
			if($insert_id)
			{
				//$this->send_mail_confirmation($insert_id);  //new function to send user confirmation mails
				echo "1";
				exit;			
				
			}else{
				echo "Error in inserting database...";
			}
	  }
	  exit;
	}
	
	function send_mail_confirmation($user_id=''){
		//Send mail to user
		$this->load->model('user_model');
		$this->load->model('systeminfo_model');
		$this->load->library('email');
		if(isset($_POST['user_id']) &&!empty($_POST['user_id']))
		{
			$user_id=$_POST['user_id'];
		}

				$result = $this->user_model->getUserById($user_id);
				$fetch=$result->row();
				
				$system=$this->systeminfo_model->get_system_info();	
				$data = $system->result(); 
				$system_info= $data[0];
				
				if($fetch->u_id)
				{	
				
					// For Supporting document
					$message ='';
					$SupportDocURL='';
					
					if($fetch->u_type_id == 1 || $fetch->u_type_id == 2 || $fetch->u_type_id == 3){//Super Admin, Admin, Recruiter
						$SupportDocURL= base_url()."supportManual1.0.0/EasyWeb_ATS_Recruiter_Manual.html";
					}
					if($fetch->u_type_id == 4){ //Hiring MGR
						$SupportDocURL= base_url()."HMsupportManual1.0.0/EasyWeb_ATS_Hiring_Manager_Manual.html";
					}
		
				$message .= '<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
				<html xmlns="http://www.w3.org/1999/xhtml">
				<head>
				<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
				<title>'.$system_info->company_name.'</title>
				<link rel="stylesheet" href="'.base_url().'css/CalibariFontStylesheet.css" type="text/css" charset="utf-8" />
				</head>
				<body style="margin-top:0;font-family:Calibri;font-size:11px;">
				<table width="600" border="0">
				  	<tr>
						<td colspan="2">Dear '.$fetch->first_name.',</td>
					</tr>
					<tr>
						<td colspan="2">&nbsp;</td>
					</tr>
					<tr>
						<td colspan="2">This email is to confirm your registration to our online recruitment system. 
						Please see below for confirmation of your data:</td>
					</tr>
					<tr>
						<td colspan="2">&nbsp;</td>
					</tr>
					<tr>
						<td>Username:</td>
						<td>'.$fetch->user_email.'</td>
					</tr>
					<tr>
						<td>Password:</td>
						<td>'.$fetch->user_pass.'</td>
					</tr>
					<tr>
						<td>Login URL:</td>
						<td><a href="'.base_url().'login">'.base_url().'login</a></td>
					</tr>
					<tr>
						<td colspan="2">&nbsp;</td>
					</tr>';
				if($fetch->u_type_id == 1 || $fetch->u_type_id == 2 || $fetch->u_type_id == 3 || $fetch->u_type_id == 4){	
					
			$message .='<tr>
						<td colspan="2">You can download a guide to using this '.$system_info->company_name.' here: 
						<a href="'.$SupportDocURL.'">Download</a>
						</td>
					</tr>
					<tr>
						<td colspan="2">&nbsp;</td>
					</tr>';
				}
					
			$message .='<tr>
						<td colspan="2">If you have any questions about this process then please contact the recruitment contact at on '.$system_info->contact_no.' / '.$system_info->website_email.'</td>
					</tr>
					<tr>
						<td colspan="2">&nbsp;</td>
					</tr>
					<tr>
						<td colspan="2" align="left">'.strip_tags($system_info->company_signature,'<h1><h2><h3><h4><h5><h6><a><table><tr><td><i><em><b><div><img><br>').'</td>
					</tr>
					<tr>
						<td colspan="2">&nbsp;</td>
					</tr>	
				</table>
				</body>
				</html>
				';
					//echo $message;
					//exit;
					$this->load->library('email');
					$this->email->initialize(array(
						'protocol' => 'smtp',
						'mailtype' => 'html',
						'charset' => 'iso-8859-1',
						'wordwrap' => TRUE,
						'smtp_host' => 'smtp.sendgrid.net',
						'smtp_user' => USERNAME_SENDGRID,
						'smtp_pass' => PASSWORD_SNRDGRID,
						'smtp_port' => 587,
						'crlf' => "\r\n",
						'newline' => "\r\n"
						));
																																		
					$this->email->from(FROM_EMAIL,FROM_EMAIL_ALIAS);
					$this->email->to($fetch->user_email); 
					//$this->email->bcc('easywebad@gmail.com'); 
					$this->email->subject('Confirmation of registration to EasyWeb ATS Portal');
					$this->email->message($message);  
					
                    if($this->email->send()){
                        $this->user_model->update_welcome_timestamp($fetch->u_id);
                    }
					
				} 
				echo "1";
				exit;
				
	}
	
	
	function editUser($u_id='')
    {
		$this->load->helper('url');
		$this->load->helper("form");
		$this->load->helper('url');
		$this->load->helper("html");
		$this->load->model('user_model');
		$this->load->model('interview_schedule_model');
		$this->load->library('form_validation');
		
		//$jobid = $this->input->post();
		if(isset($u_id) and !empty($u_id)){
		$data['userType'] = $this->user_model->getUserTypeList();	
		$result = $this->user_model->getUserById($u_id);
		$fetch=$result->row();
		
		$data['fetch'] =  $fetch;
		$data['u_id'] =  $u_id;
		$data['js_files'] = '';
		//$data['main_content'] = 'tpl_editUser';
		//$this->load->view('includes/template', $data);
		$this->load->view('tpl_editUser', $data);
		}else{
		show_error('<h1 style="font:Verdana, Geneva, sans-serif; font-size:22px;"> Wrong id in url !</h1>');	
		}
		
		//$this->load->view('tpl_jobPost');
	}
	
	
	
	function editUserAjax()
    {
		$this->load->helper("form");
		$this->load->helper('url');
		$this->load->helper("html");
		$this->load->library('Ajax');
		$this->load->library('form_validation');
		$this->load->model('user_model');
		$this->load->model('interview_schedule_model');
		$data['js_files'] = '';
		
		$this->form_validation->set_rules('first_name', 'Fist name', 'trim|required');
		$this->form_validation->set_rules('last_name', 'Last name', 'trim|required');
		$this->form_validation->set_rules('user_email', 'Email', 'trim|required|callback_duplicate_user_email');
		$this->form_validation->set_rules('designation', 'Job Title', 'trim|required');
		//$this->form_validation->set_rules('user_name', 'User Name', 'trim|required|callback_duplicate_user_name');
		$this->form_validation->set_rules('user_pass', 'Password', 'trim|required|min_length[4]|max_length[32]');
		$this->form_validation->set_rules('user_pass2', 'Password confirmation', 'trim|required|matches[user_pass]');
		$this->form_validation->set_rules('u_type_id', 'User type select ', 'trim|required');
		
		//$data['redirectPopup'] = '';
		if($this->form_validation->run() == FALSE)
		{
			//echo "Error: Please fill all required fields.";
			$value =  validation_errors('<div>');
			//if($value){
			echo "<div id='errors' class='alert alert-error'><button type='button' class='close' data-dismiss='alert'>×</button>
			<strong>Following error(s) occur while saving data.</strong><br><br>".$value."</div>";
			//}
		}
		else
		{		
				if($this->user_model->edit_user())
				{
					//echo "<pre>";print_r($_POST);echo"</pre>";
					//we have tbl_interviewer_list table, while sending interview email we get designation from this table to we must have to udpate new designation
					$updated_designation = array('email'=>$this->input->post('user_email'),
												 'first_name'=>$this->input->post('first_name'),
												 'last_name'=>$this->input->post('last_name'),
												 'contact_no'=>$this->input->post('contact_no'),
												 'designation'=>$this->input->post('designation'));
					$this->interview_schedule_model->update_interviewer($updated_designation);	
					echo "1";
				}else{
						echo "Error while updating record to database...";
					 }
		}
		exit;
		//$this->load->view('tpl_jobPost');
	}
	
	function new_pagination()
	{
		if(isset($_REQUEST['new_page_setting']) && $_REQUEST['new_page_setting']!=''){
			$this->session->set_userdata('USER_DYNAMIC_PER_PAGE', $_REQUEST['new_page_setting']);
			echo '1';
			exit;
		} else{
			echo '0';
			exit;
		}
	}
	function userList($orderby = "tbl_user.u_id", $direction = "DESC"){
		$this->load->model('user_model');
		$this->load->helper("form");
		
        $this->load->helper('url');
		$this->load->library('pagination');
		$this->load->helper("html");
		
		//$this->load->library('MY_Input');
		$likearray=array();
		$link='';
		$start = 0;
	
		if(isset($_REQUEST['per_page']) and !empty($_REQUEST['per_page']))
			$start=$_REQUEST['per_page'];
		else
			$start=0;
		if(isset($_REQUEST['u_id']) && $_REQUEST['u_id']!='')
		{
			$link.="&u_id=".$_REQUEST['u_id'];
			$likearray['tbl_user.u_id'] = $_REQUEST['u_id'];
			$data['set_u_id'] = $_REQUEST['u_id'];
		}
		
		
		if(isset($_REQUEST['user_name']) && $_REQUEST['user_name']!='')
		{
			$link.="&user_name=".$_REQUEST['user_name'];
			$likearray['tbl_user.user_email'] = $_REQUEST['user_name'];
			$data['set_user_name'] = $_REQUEST['user_name'];
		}
		
		if(isset($_REQUEST['first_name']) && $_REQUEST['first_name']!='')
		{
			$link.="&first_name=".trim($_REQUEST['first_name']);
			$likearray['tbl_user.first_name'] = trim($_REQUEST['first_name']);
			$data['set_first_name'] =trim($_REQUEST['first_name']);
		}
		if(isset($_REQUEST['last_name']) && $_REQUEST['last_name']!='')
		{
			$link.="&last_name=".trim($_REQUEST['last_name']);
			$likearray['tbl_user.last_name'] = trim($_REQUEST['last_name']);
			$data['set_last_name'] = trim($_REQUEST['last_name']);
		}
        if(isset($_REQUEST['user_type']) && $_REQUEST['user_type']!='')
        {
            $link.="&user_type=".trim($_REQUEST['user_type']);
            $likearray['tbl_user.u_type_id'] = trim($_REQUEST['user_type']);
            $data['set_user_type'] = trim($_REQUEST['user_type']);
        }
		
		if($orderby == "")
		{
			$orderby = "tbl_user.u_id";
		}
		else
		{
			$orderby = $orderby;
		}

		if($this->session->userdata('USER_DYNAMIC_PER_PAGE')!='')
			{
				$page= $this->session->userdata('USER_DYNAMIC_PER_PAGE');
			}
			else {
				$page= PER_PAGE;
			}
			
			
		$resultarray				= $this->user_model->recent_record($start, $page, $orderby, $direction, $likearray); // return recent 5 record along with user
		$data['results']			= $resultarray[0];
		$data['record_count']		= $resultarray[1];
		
        $data['user_type_list'] = $this->user_model->getUserTypeList();
        
		//Paging start here 
		$config['base_url'] 		= base_url()."user/userList/".$orderby."/".$direction."/?".(($link !='')? $link:"");
		
		$config['total_rows'] 		= $data['record_count'];
		//$config['per_page'] 		= 2; 
		$config['per_page'] 		= $page; 
		//$config['num_links']      = $row_start;
		$config['uri_segment']      = 5;
		$config['page_query_string']= TRUE;
		$config['full_tag_open'] 	= FULL_TAG_OPEN;
		$config['full_tag_close']	= FULL_TAG_CLOSE;
		$config['first_link'] 		= FIRST_LINK;
		$config['first_tag_open'] 	= FIRST_TAG_OPEN;
		$config['first_tag_close'] 	= FIRST_TAG_CLOSE;
		$config['last_link'] 		= LAST_LINK;
		$config['last_tag_open'] 	= LAST_TAG_OPEN;
		$config['last_tag_close'] 	= LAST_TAG_CLOSE;
		$config['next_link'] 		= NEXT_LINK;
		$config['next_tag_open'] 	= NEXT_TAG_OPEN;
		$config['next_tag_close'] 	= NEXT_TAG_CLOSE;
		$config['prev_link'] 		= PREV_LINK;
		$config['prev_tag_open'] 	= PREV_TAG_OPEN;
		$config['prev_tag_close'] 	= PREV_TAG_CLOSE;
		$config['cur_tag_open'] 	= CURRENT_TAG_OPEN;
		$config['cur_tag_close'] 	= CURRENT_TAG_CLOSE;
		$config['num_tag_open'] 	= MID_TAG_OPEN;
		$config['num_tag_close'] 	= MID_TAG_CLOSE;
		$this->pagination->initialize($config);
		$navigation 				= $this->pagination->create_links();
		//Paging end 
		$data['js_files'] 			= '<script language="javascript" >
			function confirmSubmit(mn){
			var msg;
			msg= "Are you sure you want to "+mn+" ? ";
			var agree=confirm(msg);
			if (agree)
			return true ;
			else
			return false ;
			}
			</script>
			';
		//$data['results'] = $this->user_model->get_all_user();
		$data['navigation'] 		= $navigation;
		$data['new_direction']		= ($direction == "DESC") ? "ASC" : "DESC" ;
		$data['index_page'] 		= index_page();
		$data['base_url']   		= base_url();
		
		if($start)
		$data['paging_url']   		= $config['base_url']."&per_page=".$_REQUEST['per_page'];
	    else
		$data['paging_url']   		= $config['base_url'];
		
		$data['main_content'] 		= 'tpl_userList';
		$this->load->view('includes/template', $data);
		//$this->load->view('itemlist');	
	
	}

	
	function deleteUser($u_id){
		$this->load->helper('url');
        $this->load->model('user_model');
		$this->load->model('interview_schedule_model');
		
		$result = $this->user_model->getUserById($u_id);
		$user_arr=$result->row();
		
		foreach ($user_arr as $key => $val) {
			
			if($key == 'user_email'){
				$user_email = $val;
			}
			
		}
		
		$this->interview_schedule_model->delete_interviewer($user_email);
		
		
		$this->user_model->delete_user($u_id);

		$this->user_model->insert_del_log($u_id);//added

        redirect('user/userList','location'); //redirect setelahnya
    }

    //Added
    function delList(){
		if($this->session->userdata('UTYPE_DEMOATS') != 1 ){
			show_error('Access denied !',500,'Security check');
		}
		$this->load->helper('form');
		$this->load->helper("html");
		$this->load->helper('url');

    	$this->load->model('user_model');

    	$delUserLogDetails = $this->user_model->getdelLogList();
		$data['results']			= $delUserLogDetails[0];
		$data['record_count']		= $delUserLogDetails[1];
		$data['js_files'] 			= '<script language="javascript" >
			function confirmSubmit(mn){
			var msg;
			msg= "Are you sure you want to "+mn+" ? ";
			var agree=confirm(msg);
			if (agree)
			return true ;
			else
			return false ;
			}
			</script>
			';

    	$data['main_content'] 		= 'tpl_delLogList';
		$this->load->view('includes/template', $data);	

    }

    //Added for Restore User
    function restoreUser($u_id=''){
		if($this->session->userdata('UTYPE_DEMOATS') != 1 ){
			show_error('Access denied !',500,'Security check');
		}
		/*ini_set('display_errors',1);
		ini_set('display_startup_errors',1);
		error_reporting(-1);*/
    	$this->load->model('user_model');

    	$restoreUserDetails = $this->user_model->restoreUserById($u_id);

    	redirect('user/delList','user'); 

    }

	function duplicate_user_name($str)
	{
		$this->load->library('form_validation');
		$this->load->model('user_model');
		$u_id = (int) $this->input->post('u_id');
		//$email = trim($this->input->post('email_address'));
		$result_query = $this->user_model->is_username_exist($str,$u_id);
		if(!empty($result_query))
		{
		$this->form_validation->set_message('duplicate_user_name', "<div>The user already exists with $str name.<div>");		
		return false;
		}
		else
		{
		return true;
		}
	}
	
	
	function duplicate_user_email($str)
	{
		$this->load->library('form_validation');
		$this->load->model('user_model');
		$u_id = (int) $this->input->post('u_id');
		//$email = trim($this->input->post('email_address'));
		$result_query = $this->user_model->is_user_email_exist($str,$u_id);
		if(!empty($result_query))
		{
		$this->form_validation->set_message('duplicate_user_email', "<div>The user already exists with $str email.<div>");		
		return false;
		}
		else
		{
		return true;
		}
	}
}
?>

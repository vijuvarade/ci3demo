<?php
class User_model extends CI_Model {
	
   function __construct(){
        parent::__construct();
    }
	
	
	function recent_record($start, $limit, $orderby = "tbl_user.u_id", $direction = "DESC", $likearray="") //return blog and user information regarding this blog data 
	{
		//Get count
		$this->load->database();
		$this->db->select('tbl_user.u_id',false);
		$this->db->from('tbl_user');
		$this->db->join('tbl_user_type','tbl_user.u_type_id=tbl_user_type.u_type_id','left');
		$this->db->like($likearray,"before");
		if($this->session->userdata('UTYPE_DEMOATS') == 2){
			$this->db->where('tbl_user.u_type_id <>',1); // Admin should not be able to edit super admin user type
		}
$this->db->where('del_status', 1);//added
		$query = $this->db->get();
		$count = $query->num_rows();
		
		//Get result query
		$this->db->select('*',false);
		$this->db->from('tbl_user');
		$this->db->join('tbl_user_type','tbl_user.u_type_id=tbl_user_type.u_type_id','left');
		$this->db->like($likearray,"before");
		$this->db->order_by($orderby, $direction); 
		$this->db->limit($limit,$start);
		if($this->session->userdata('UTYPE_DEMOATS') == 2){
			$this->db->where('tbl_user.u_type_id <>',1); // Admin should not be able to edit super admin user type
		}
$this->db->where('del_status', 1);//added
		$query = $this->db->get();
		
		//echo "<pre>";
		//echo $this->db->last_query();
		
		
		if ($query->num_rows() > 0)
		{
			return array($query, $count);
		}
		else
		{
			return 0;
		}
	}
function all_user_emailToTrigger ($condition='',$type=''){
		 	$this->db->select('user_email,u_id');
			 $this->db->from('tbl_user');
			$user_list=array();
			 if($condition!='')
			 {
				 $this->db->where('u_type_id',$condition);
			 }
			$this->db->order_by('user_email ASC');
			 $query =$this->db->get();
			 if ($query->num_rows() > 0)
				{
					$data=$query->result_array();
					
					foreach($data as $key=>$val)
					{
						$user_list[$val['u_id']]= $val['user_email'];
					}
					return $user_list;
				}
				else
				{
					return $user_list;
				}
				
}
function all_user_email($condition='',$type)
	{
		
		 $this->db->select('first_name,last_name,u_id');
		 $this->db->from('tbl_user');
		 if($condition!='')
		 {
			 $this->db->where('u_type_id',$condition);
			 if($this->session->userdata('UTYPE_DEMOATS')!="" && $condition==3) // This is for when any user logs in with type rescruiter ie u_type_id 3
			{
			$this->db->or_where('u_type_id',$this->session->userdata('UTYPE_DEMOATS'));		
			}
			 		
		 }
		 $this->db->order_by('first_name ASC');
		 $query =$this->db->get();
		// echo $this->db->last_query();
		 if ($query->num_rows() > 0)
			{
				return $this->user_email_to_array($query->result_array(),$type);
			}
			else
			{
				return 0;
			}
		 
	}


function new_recruit_list()
	{

		 $condition= array(1,2,3);
		 $this->db->select('first_name,last_name,u_id,u_type_id');
		 $this->db->from('tbl_user');
		 $this->db->where_in('u_type_id',$condition);
		$this->db->order_by('first_name ASC');
		 $query =$this->db->get();
		$user_list=array();
		 if ($query->num_rows() > 0)
			{
				$userdata=$query->result_array();
				foreach($userdata as $key=>$val)
				{
					$user_list['']= "--Select--";
					$user_list[$val['u_id']]= $val['first_name']." ".$val['last_name'];
				}
				return $user_list;
			}
			else
			{
				return 0;
			}
		 
	}


function all_job_recruit($type)
	{

		 $condition= array(1,2,3);
		 $this->db->select('first_name,last_name,u_id,u_type_id');
		 $this->db->from('tbl_user');
		 $this->db->where_in('u_type_id',$condition);
		
		 $query =$this->db->get();
		// echo $this->db->last_query();
		 if ($query->num_rows() > 0)
			{
				return $this->user_email_to_array($query->result_array(),$type);
			}
			else
			{
				return 0;
			}
		 
	}

function user_email_to_array($data,$to_from)
	{
		/*if($this->session->userdata('UTYPE_DEMOATS')==1)
		{
			$to_from=1;
		}*/
		$user_list=array();
		if(count($data)>0){
			if($to_from=='')
			{
				foreach($data as $key=>$val)
				{
					$user_list['']= "--Select--";
					$user_list[$val['u_id']]= $val['first_name']." ".$val['last_name'];
				}
			} else 
				if($to_from=='to')
				{
					$user_list['candidate']='Candidate';
					$user_list['hiring_mgr']='Hiring manager recruiting for this role';
					$user_list['recruiting_mgr']='Recruiter managing this role';
					$user_list['all_user']='all user';
					$user_list['system_email']='System email';

					foreach($data as $key=>$val)
					{
						$user_list[$val['u_id']]= $val['first_name']." ".$val['last_name'];
					}
				}

				 else {
					$user_list['hiring_mgr']='Hiring manager recruiting for this role';
					$user_list['logged_in_user']='Logged in user';
					$user_list['recruiting_mgr']='Recruiter managing this role';
					$user_list['system_email']='System email';
					
					foreach($data as $key=>$val)
						{
							$user_list[$val['u_id']]= $val['first_name']." ".$val['last_name'];
						}
				}
			return $user_list;
		} else {
			return $user_list;
		}
		
	}
	function get_user_by_type($condition='')
	{
		 $this->db->select('first_name,last_name,user_email,u_id');
		 $this->db->from('tbl_user');
		 if($condition!='')
		 {	
			 $this->db->where('u_type_id',$condition);
		 }
		 $query =$this->db->get();
		 if ($query->num_rows() > 0)
			{
				return $query->result_array();
			}
			else
			{
				return 0;
			}
		 
	}

function get_user_by_type_multiple($condition)
	{
		 $this->db->select('user_email,u_id');
		 $this->db->from('tbl_user');
		 if(is_array($condition) and count($condition)>0 )
		 {	
			 $this->db->where($condition);
		 }
		 $query =$this->db->get();
		 if ($query->num_rows() > 0)
			{
				return $query->result_array();
			}
			else
			{
				return 0;
			}
		 
	}
	
	
	
	
	function forgot_password($user_email)
	{
		
		$this->load->database();
		$this->db->select('u_id,user_pass, first_name, last_name, user_email, designation, contact_no');
		$this->db->from('tbl_user');
		$this->db->or_where('user_email', $user_email); 
		$this->db->limit('1','');
		
		$query = $this->db->get();
		if ($query->num_rows() > 0)
		{
			return $query->result_array();
		}
		else
		{
			return array();
		}
	}
	
	function forgot_password_email($user_email)
	{
		$this->load->database();
		$this->db->select('user_pass, first_name, last_name, user_email, designation, contact_no');
		$this->db->from('tbl_user');
		$this->db->or_where('user_email', $user_email); 
		$this->db->limit('1','');
		
		$query = $this->db->get();
		if ($query->num_rows() > 0)
		{
			return $query;
		}
		else
		{
			return array();
		}
	}
	
	
	function forgot_agencypassword($user_email)
	{
	    $this->load->database();
		$this->db->select('agencyuser_pass,first_name,last_name,agencyuser_email');
		$this->db->from('tbl_agencyuser');
		
		//$this->db->where('user_name', $user_email); 
		$this->db->where('agencyuser_email', $user_email); 
		$this->db->limit('1','');
		$query = $this->db->get();
		//echo "<pre>";
		//echo $this->db->last_query();
		if ($query->num_rows() > 0)
		{
			//$row = $query->result_array();
			
			return $query;
		}
		else
		{
			return 0;
		}
	}
	
	
	
	
	function insert_user()
	{
		global $pre_filter;
			
		$new_member_insert_data = array(
			'first_name' => $this->input->post('first_name'),
			'last_name' => $this->input->post('last_name'),
			'user_email' => strtolower($this->input->post('user_email')),
			'designation'=>$this->input->post('designation'),	
			'contact_no' => $this->input->post('contact_no'),
			'insert_user_signature' => $pre_filter['user_signature'],
			'user_pass' => $this->input->post('user_pass'),
			'u_type_id' => $this->input->post('u_type_id')
			);
		
		if($this->input->post('u_type_id')== 5){
						$new_member_insert_data['is_active'] = '0';
			  }
		
		$this->load->database();
		$insert = $this->db->insert('tbl_user', $new_member_insert_data);
		
		//echo "<pre>".$insert;
		//echo $this->db->last_query();
		//exit;
		
		$user_id  =  $this->db->insert_id();
		return $user_id;
	}
	
	
	function edit_user(){
			
			$id=$this->input->post('u_id');
			global $pre_filter;
			$new_member_insert_data = array(
			'first_name' => $this->input->post('first_name'),
			'last_name' => $this->input->post('last_name'),
			'user_email' => strtolower($this->input->post('user_email')),
			'designation'=>$this->input->post('designation'),	
			'contact_no' => $this->input->post('contact_no'),
			'insert_user_signature' => $pre_filter['user_signature'],
			'user_pass' => $this->input->post('user_pass'),
			'u_type_id' => $this->input->post('u_type_id')
			);
		
			if($this->input->post('u_type_id')== 5){
						$new_member_insert_data['is_active'] = '0';
			  }
	
			$this->load->database();
            $this->db->where('u_id', $id);
            $flgreturn = $this->db->update('tbl_user', $new_member_insert_data); 
			return $flgreturn;
	}
	
	
	function getUserById($id)
	{

        $this->db->where('u_id ',$id);
        $query = $this->db->get('tbl_user');
       // $fetch = $query->row();
		return $query;
    }
	

	
	function getUserTypeList() 
	{
			$this->load->database();
			$this->db->select('u_type_id,utype_name');
	        $this->db->from('tbl_user_type');
			if($this->session->userdata('UTYPE_DEMOATS') == 2){
				$this->db->where('u_type_id <>',1); // Admin should not be able to add super admin user type
			}	
			
			
			$query = $this->db->get();
			$data[' ']= '-User Type-';	
		    if ($query->num_rows() > 0)
		   {
			 
			  
			  foreach ($query->result() as $row)
   			  {
				$data[$row->u_type_id ]= $row->utype_name;	
			  }
			return $data;
		   }
		   else
		   {
			return $data;
		   }
      }
	
	

	/////////////////////////////////////////////////////////


	function get_username($username) {
        $this->load->database();
		$this->db->select('username');
		$this->db->where('username', $username);
		
		$query = $this->db->get('tbl_user');
		$query->num_rows();
	    return $query->num_rows();
    }

	
	/*function is_username_exist($user_name,$id='') {
        $this->load->database();
		$this->db->select('user_name');
		if($id){
		$this->db->where('user_name', $user_name);
		$this->db->where('u_id !=', $id); 
		}else{
		$this->db->where('user_name', $user_name);
		}
		
		$query = $this->db->get('tbl_user');
		return $query->num_rows();
    }
	*/
	
	function is_user_email_exist($user_email,$id='') {
        $this->load->database();
		$this->db->select('user_email');
		if($id){
		$this->db->where('user_email', $user_email);
		$this->db->where('u_id !=', $id); 
		}else{
		$this->db->where('user_email', $user_email);
		}
		$query = $this->db->get('tbl_user');
		return $query->num_rows();
    }
	
	function delete_user($id) {
        $this->load->database();
        //$this->db->delete('tbl_user', array('u_id' => $id)); 
        $del_status_array=array('del_status' => 2);//2-in-active

       	$this->db->where('u_id', $id);
      	$this->db->update('tbl_user', $del_status_array); 

    }

    function insert_del_log($id){//added

    	$new_del_log_insert_data = array(
			'deleted_id' => $id,
			'who_del' =>$this->session->userdata('UID_DEMOATS'),
			'del_type' => 'tbl_user',
			'del_time'=>date('Y-m-d H:i:s'),
			'log_status'=>'delete'
			);

    	$this->load->database();
    	$this->db->insert('tbl_delete_logs', $new_del_log_insert_data);

    }

    function getdelLogList(){ //added

    	$this->load->database();
//Get count
		$this->db->select('u1.u_id,u1.first_name,u1.last_name,u1.u_type_id,tbl_delete_logs.*');
		$this->db->select('u2.first_name as wfname,u2.last_name as wlname,u2.u_type_id as wutype_id');
		$this->db->from('tbl_delete_logs');

		$this->db->join('tbl_user u1', 'tbl_delete_logs.deleted_id= u1.u_id',"left");
		$this->db->join('tbl_user u2', 'tbl_delete_logs.who_del = u2.u_id',"left");

		$this->db->where('tbl_delete_logs.log_status','delete');
		$query = $this->db->get();
		$count = $query->num_rows();


//Get Query
    	$this->db->select('u1.u_id,u1.first_name,u1.last_name,u1.u_type_id,tbl_delete_logs.*');
		$this->db->select('u2.first_name as wfname,u2.last_name as wlname,u2.u_type_id as wutype_id');
		$this->db->from('tbl_delete_logs');

		$this->db->join('tbl_user u1', 'tbl_delete_logs.deleted_id= u1.u_id',"left");
		$this->db->join('tbl_user u2', 'tbl_delete_logs.who_del = u2.u_id',"left");

    	$this->db->where('tbl_delete_logs.log_status','delete');
		$query = $this->db->get();

		//print_r($this->db->last_query());exit;
		if ($query->num_rows() > 0)
		{
			return array($query, $count);
		}
		else
		{
			return 0;
		}

    }

    function restoreUserById($id){

    	$this->load->database();
       
//This is for update "tbl_user"       
        $restore_status_array=array('del_status' => 1);//1 - Active

       	$this->db->where('u_id', $id);
      	$this->db->update('tbl_user', $restore_status_array); 

//This is for update "tbl_delete_logs"
      	$restore_status_array=array('log_status' => 'restore',
      								'who_restore'=> $this->session->userdata('UID_DEMOATS')
      								);//1 - Active

       	$this->db->where('deleted_id', $id);
      	$this->db->update('tbl_delete_logs', $restore_status_array); 

    }
	
	function validate()
	{

		$this->db->where('user_email', trim(strtolower($this->input->post('user_name',TRUE))));
		$this->db->where('user_pass', trim($this->input->post('user_pass',TRUE)));
		$this->db->where('is_active', 1);
		$query = $this->db->get('tbl_user');
		//echo $this->db->last_query();
		//exit; 
		if($query->num_rows() == 1)
		{
			return $query;
		}else{
			return 0;
		}
	}
	
	function validate_agency()
	{
	
		//$custome_where = '(user_name = "'.$this->input->post('user_name').'" OR user_email = "'.$this->input->post('user_name').'")';
		//$custome_where = '(agencyuser_email = "'.$this->input->post('user_name').'")';
		//$this->db->where($custome_where);
		
		$this->db->where('agencyuser_email', trim($this->input->post('user_name')));
		$this->db->where('agencyuser_pass', trim($this->input->post('user_pass')));
		$this->db->where('is_active', 1);
		$query = $this->db->get('tbl_agencyuser');
		//echo $this->db->last_query();
		//exit; 
		if($query->num_rows() == 1)
		{
			return $query;
		}else{
			return 0;
		}
	}
	
	
	
	
	
	
	
		
	
	function block_user($id){
		$this->load->database();
		$this->db->where('u_id', $id);
        $flgRetn = $this->db->update('tbl_user', array("is_active"=> 0));
	}
	
	function active_user($id){
		$this->load->database();
		$this->db->where('u_id', $id);
        $flgRetn = $this->db->update('tbl_user', array("is_active"=> 1));
	}
	
	
	/*send grid quries*/
	function get_user_email_by_agency($AgencyID)
	{
		$this->db->select('a.*');
		$this->db->from('tbl_agencyuser a');
		$this->db->where('a.ag_id',$AgencyID);
		return $q=$this->db->get()->result_array();
	}
	
	function getUserSignatureById($id)
	{
		$this->db->select('insert_user_signature');
        $this->db->where('u_id ',$id);
        $query = $this->db->get('tbl_user');
		$result=$query->result_array();
		
		$data["  "]="--Select--";
		foreach($result[0] as $key=>$value){
			$data[str_replace("_"," ",$key)] = str_replace("_"," ",$key);
		}
		return $data;
		
    }
	
	function user_job_details ($jobid=''){
	
		$this->db->select('user_pass,user_email,first_name,job_id,job_title',false);
		$this->db->from('tbl_jobs');
		$this->db->join('tbl_user','tbl_jobs.hiring_manager=tbl_user.u_id','left');
		$this->db->where('tbl_jobs.job_id',$jobid);
		$query = $this->db->get();
	
		if ($query->num_rows() > 0){
			return $query->result_array();
		}else{
			return array();
		}
	
	}
    
    function update_welcome_timestamp($id){
        
        $this->load->database();
        $this->db->where('u_id', $id);
        $flgRetn = $this->db->update('tbl_user', array("welcome_mail"=> time()));
        echo $flgRetn; exit;
    }

	function getFilteredSignature($userdata){
		$utype = array(1=>'Super Admin',
									  2=>'Admin',
									  3=>'Recruiter',	
									  4=>'HiringMgr',
									  5=>'Interviewer');
		$userdata['user_type']=$utype[$userdata['u_type_id']];
		$filteredMsg=$userdata['insert_user_signature'];
		foreach($userdata as $key=>$alertData)
		{
			$filteredMsg = str_replace('{'.$key.'}',$alertData ,$filteredMsg);
			$filteredMsg = str_replace('{'.$key.'&ndash; no data available!}',$alertData ,$filteredMsg);
			$filteredMsg = $filteredMsg;
		}
		
		return $filteredMsg;
	}

function get_user_by_id($uid='')
	{
		 $this->db->select('*');
		 $this->db->from('tbl_user');
		 if($uid!='')
		 {	
			 $this->db->where('u_id',$uid);
		 }
		 $query =$this->db->get();
		 if ($query->num_rows() > 0)
			{
				$res=$query->result_array();
				return $res[0];
			}
			else
			{
				return 0;
			}
		 
	}

		
//Required for ZOHO
	function getHiringManagerForZoho($id)
	{

        $hiringManager='';
	    $this->db->where('u_id ',$id);
        $query = $this->db->get('tbl_user');
       	$arrData = $query->result_array();
		if(is_array($arrData) and count($arrData)>0){
			$hiringManager=	$arrData[0]['first_name']." ".$arrData[0]['last_name'];
			return $hiringManager;
		}
		else{
			return 'N/A';
		}
		
	}

}
?>
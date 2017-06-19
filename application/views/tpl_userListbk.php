<script src="https://code.jquery.com/jquery-latest.js"></script>
<script type="text/javascript" src="<?php echo base_url();?>tinymce/js/tinymce.min.js"></script>
<script>
function loadPage(url,pid){
			$('#'+pid).empty().append("<div id='loading'><img src='<?PHP echo base_url();?>images/loading.gif' alt='Loading' /></div>");
			$('#'+pid).load(url,function(){
			//alert('Load was performed.');
			});
}
function pagination_per(page_val)
{
	$(document).ready(function(){ 
	var tokenname = "<?PHP echo $this->security->get_csrf_token_name();?>";
	var tokenvalue = "<?PHP echo $this->security->get_csrf_hash();?>";
	$.ajax({
		   type: "POST",
		   url: "<?PHP echo base_url();?>user/new_pagination",
		   data: {new_page_setting:page_val,tokenname:tokenvalue},
		   dataType: 'html',
		   success: function(msg){ 
			if(msg==1)
			{
				window.location="<?PHP echo base_url();?>user/userlist";
			}
			 else {
				 alert('Record per page setting problem.');
			 }
		   }
		});
	});
}

function send_confirm_message(url,val)
{
	
	var base_url="<?PHP echo base_url();?>";
	$(document).ready(function(){
	//var tokenname = "<?PHP echo $this->security->get_csrf_token_name();?>";
	var tokenvalue = "<?PHP echo $this->security->get_csrf_hash();?>";
	//var cct = "<?php echo $this->config->item("csrf_cookie_name"); ?>";
	//console.log(tokenname);
	//console.log(tokenvalue);
	$.ajax({
		   type: "POST",
		   url: base_url+url,
		   data: {user_id: val, <?PHP echo $this->security->get_csrf_token_name();?>: tokenvalue},
		   dataType: 'html',
		   success: function(msg){ 
			if(msg==1)
			{
					$('#userList').empty().append("<div id='errors' class='alert alert-success'><button type='button' class='close' data-dismiss='alert'>�</button>Message sent successfully</div>");
					setTimeout('redirectPage()',2000);
					$('body').css('cursor', 'wait');
			}
			 else {
				 alert('Message sending problem.');
			 }
		   }
		});
	});
}

function redirectPage()
{
	window.location="<?PHP echo base_url();?>user/userList";
}
</script>
<table width="101%" border="0">
<tr>
<td valign="top">
<div id="userList">

<table width="100%" border="0" align="left" cellpadding="0" cellspacing="0">
      <tr>
        <td valign="top" ><table width="100%" border="0" cellspacing="0" cellpadding="0">
          <td align="left" valign="top">           
          <div style=" float:right; width:35%">
		<?PHP  //echo anchor('jobPost','Add Jobs','class="btn btn-info"');?>
		<input type="button" class="btn btn-success" value="Add User" onclick="loadPage('<?PHP echo base_url();?>user/addUser','userList')" /> 
        </div>  
<!--Added-->

<?PHP if($this->session->userdata('UTYPE_DEMOATS') == 1) {  //supper admin ?>
<div style=" float:right; width:25%">
    <a href="<?PHP echo base_url();?>user/delList">
      <input type="button" class="btn btn-success" value="Show delete logs" /> 
    </a>
</div>
<?PHP } ?>
<!--Added-->
<h1>User List</h1>
</td></tr>

          <tr>
            <td valign="top">

              <table width="100%" border="0" cellspacing="0" cellpadding="0">
                <tr>
                  <td valign="top">
                   <?PHP
			$this->config->set_item('csrf_protection', TRUE);
				   echo form_open(base_url().'user/userList/u_id/'.$new_direction);?>
                  <table width="100%" border="0" cellspacing="2" cellpadding="0">
                    <tr>
                      <td width="123" align="left" valign="middle"  class="textcontent_lable">User ID:<br />
<label><?PHP echo form_input('u_id',set_value('u_id',(isset($arrEdit['set_u_id']))?$arrEdit['set_u_id']:''),'','class="input"');?></label></td>
                      <td width="20" align="left" valign="middle">&nbsp;</td>
                      <td width="148" align="left" valign="middle" class="textcontent_lable">User Email:<br />
<label><?PHP echo form_input('user_name',set_value('user_name',(isset($arrEdit['set_user_name']))?$arrEdit['set_user_name']:''),'','class="input"');?></label></td>
                      <td width="20" align="left" valign="middle">&nbsp;</td>
                       <td width="148" align="left" valign="middle" class="textcontent_lable">First Name:<br />
<label><?PHP echo form_input('first_name',set_value('first_name',(isset($arrEdit['set_first_name']))?$arrEdit['set_first_name']:''),'','class="input"');?></label></td>
                      <td width="20" align="left" valign="middle">&nbsp;</td>
                      <td width="148" align="left" valign="middle" class="textcontent_lable">Last Name:<br />
<label><?PHP echo form_input('last_name',set_value('last_name',(isset($arrEdit['set_last_name']))?$arrEdit['set_last_name']:''),'','class="input"');?></label></td>
                      <td width="20" align="left" valign="middle">&nbsp;</td>
                      <td width="148" align="left" valign="middle" class="textcontent_lable">User Type:<br />
                        <label><?PHP echo form_dropdown("user_type", $user_type_list,'',
                  'id="user_type"'); ?></label></td>
                      <td width="20" align="left" valign="middle">&nbsp;</td>
                      <td width="753" align="left" valign="bottom"><?PHP echo form_submit('SAVE', 'Search','class="btn"'); ?></td>
                    </tr>
                  </table>
                  <?PHP echo form_close(); ?>
                  </td>
             </tr>
                 <tr>
                 <td align="right">&nbsp;</td>
                </tr>

                <tr>
                <td align="left">
                <?PHP $attributes = array('id' => 'userForm','name' => 'userForm'); echo form_open_multipart('', $attributes); ?> 
 
                <table width="100%" border="0" align="center" cellpadding="0" cellspacing="0"  class="table table-hover">
                        <tr>
                        
                            <td width="3%" align="center" class="navbar-inner">ID</td>
                            <td width="12%" align="center" class="navbar-inner">Name</td>
                            <td width="14%" align="center" class="navbar-inner">Contact No</td>
                            <td width="25%" align="center" class="navbar-inner">User Email</td>
                            <td width="14%" align="center" class="navbar-inner">User Type</td>
                            <td width="12%" align="center" class="navbar-inner">Send Welcome Email</td>
                            <td width="12%" align="center" class="navbar-inner">Last Sent On</td>
                            <td width="8%" align="center" class="navbar-inner">Edit</td>
                            <td width="8%" align="center" class="navbar-inner">Delete</td>
                        
                        </tr>
                <?php
                if($record_count > 0){
					foreach ($results->result() as $row){ 
					?>
                    <tr>
                        <td align="center" class="textcontent"><?PHP echo $row->u_id;?>
                        <!--<a href="javascript:void(0);" onclick="popupwindow('<?PHP echo 'viewUserRecord/'.$row->u_id;?>',650,850);"></a>-->
                        </td>
                        <td align="center" class="textcontent"><?PHP echo (isset($row->first_name))?$row->first_name." ".$row->last_name:'';?></td>
                        <td align="center" class="textcontent"><?PHP echo (isset($row->contact_no))?$row->contact_no:'';?></td>
                        <td align="center" class="textcontent"><?PHP echo (isset($row->user_email))?$row->user_email:'';?></td>
                        <td align="center" class="textcontent"><?PHP echo (isset($row->utype_name))?$row->utype_name:'';?></td>
                        
                        <td align="center" class="textcontent">
                            <a href="javascript:void(0);" onclick="return send_confirm_message('user/send_mail_confirmation/',<?php echo isset($row->u_id)?$row->u_id:'';?>)">
                            <img src="<?php echo base_url();?>images/resend_mail.jpg" alt="Send Message" />
                            </a>
                        </td>
                        <td align="center" class="textcontent" style="font-size:14px;">
                            <?php echo (isset($row->welcome_mail) && trim($row->welcome_mail)!='')?date("d-M-Y h:ia",$row->welcome_mail):'N/A'; ?>
                        </td>
                        <td align="center" class="textcontent">
                        <img  style="cursor:pointer;" src='<?PHP echo base_url()."images/admin/edit.png"?>' onclick="loadPage('<?PHP echo base_url().'user/editUser/'.$row->u_id.'/'.session_id();?>','userList')">
                        
                        
                        </td>
                        <td align="center" class="textcontent"><?PHP echo anchor('user/deleteUser/'.$row->u_id.'/'.session_id(),"<img src='".base_url()."images/admin/delete.png'",'onclick="return confirmSubmit(\'delete this User\')"');?></td>
                    </tr>
                     
                <?PHP 
				}
			 
			 }else {  ?>

  <tr>
    <td colspan="16"><?PHP echo 'There are no records found.';?></td>
    </tr>
    			<?PHP 
			}
            ?>

  
</table>

</form>

                  
                  </td>
            </tr>
            
              </table>
              
               <table align="center" width="100%"><tr><td align="left" style="padding-top:0px;">
              <?PHP echo $navigation;?> 
              </td>
              <td align="right" style="padding-top:0px;">
            		 <div class="btn-group">
                    <button class="btn dropdown-toggle" data-toggle="dropdown">
                    Records per page
                    <span class="caret-up"></span>
                    </button>
                    <ul class="dropdown-menu dropup-menu" style="text-align:center;">
                    <li><a href="javascript:void(0);" onclick="pagination_per(25)" id="pagination">25</a></li>
                    <li><a href="javascript:void(0);" onclick="pagination_per(50)" id="pagination">50</a></li>
                    <li><a href="javascript:void(0);" onclick="pagination_per(100)" id="pagination">100</a></li>
                    </ul>
                    </div>
              
              
              </td>
              </tr></table>
              
              </td>
            </tr>
        </table></td>
      </tr>
    </table>

</div>
</td>
</tr>

</table>
  
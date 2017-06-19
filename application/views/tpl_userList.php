  <!-- Content Header (Page header) -->
                <section class="content-header">
                    <h1>
                       Users List
                       
                    </h1>
                    <ol class="breadcrumb">
                        <li><a href="<?php echo base_url();?>dashboard"><i class="fa fa-dashboard"></i> Home</a></li>
                        <li><a href="<?php echo base_url();?>user">Users</a></li>
                        <li class="active">Users List</li>
                    </ol>
                </section>

                <!-- Main content -->
                <section class="content">
                    <div class="row">
                        <div class="col-xs-12">
                         
                            <div class="box">
                               
                                <div class="box-body table-responsive">
                                    <table id="example1" class="table table-bordered table-striped">
                                        <thead>


                                            <tr>
                                                <th>ID</th>
                                                <th>Name</th>
                                                <th>Contact No</th>
                                                <th>User Email</th>
                                                <th>User Type</th>
                                                <th>Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>

         <?php
                if($record_count > 0){
          foreach ($results->result() as $row){ 
          ?>

            <tr>
              <td><?PHP echo $row->u_id;?></td>
              <td><?PHP echo (isset($row->first_name))?$row->first_name." ".$row->last_name:'';?></td>
              <td><?PHP echo (isset($row->contact_no))?$row->contact_no:'';?></td>
              <td> <?PHP echo (isset($row->user_email))?$row->user_email:'';?></td>
              <td><?PHP echo (isset($row->utype_name))?$row->utype_name:'';?></td>
              <td> 
                  
                  <?PHP echo anchor('user/deleteUser/'.$row->u_id.'/'.session_id(),"<img src='".base_url()."images/admin/delete.png'",'onclick="return confirmSubmit(\'delete this User\')"');?>
              <img  style="cursor:pointer;" src='<?PHP echo base_url()."img/admin/edit.png"?>' onclick="loadPage('<?PHP echo base_url().'user/editUser/'.$row->u_id.'/'.session_id();?>','userList')">

                |  <?PHP echo anchor('user/deleteUser/'.$row->u_id.'/'.session_id(),"<img src='".base_url()."images/admin/delete.png'",'onclick="return confirmSubmit(\'delete this User\')"');?>
                </td>
           </tr>
                                      
                 <?PHP 
             } // end of foreach
       
       }else {  ?>

    <tr>
    <td colspan="6"><?PHP echo 'There are no records found.';?></td>
    </tr>
          <?PHP 
      }
            ?>                       
                                    </table>
                                </div><!-- /.box-body -->
                            </div><!-- /.box -->
                        </div>
                    </div>

                </section><!-- /.content -->




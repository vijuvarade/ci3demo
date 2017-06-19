 <!-- sidebar: style can be found in sidebar.less -->
                <section class="sidebar">
                    <!-- Sidebar user panel -->
                    <div class="user-panel">
                        <div class="pull-left image">
                            <img src="<?PHP echo base_url();?>img/avatar3.png" class="img-circle" alt="User Image" />
                        </div>
                        <div class="pull-left info">
                            <p>Hello, Vijay</p>

                            <a href="#"><i class="fa fa-circle text-success"></i> Online</a>
                        </div>
                    </div>
                   
                    <!-- sidebar menu: : style can be found in sidebar.less -->
                    <ul class="sidebar-menu">
                        <li class="active">
                            <a href="<?PHP echo base_url();?>">
                                <i class="fa fa-dashboard"></i> <span>Dashboard</span>
                            </a>
                        </li>
                     
                          <li class="treeview">
                            <a href="#">
                                <i class="fa fa-th-list"></i> <span>User</span>
                                <i class="fa fa-angle-left pull-right"></i>
                            </a>
                            <ul class="treeview-menu">
                              <li><a href="<?PHP echo base_url();?>user"><i class="fa fa-angle-double-right"></i> User List</a></li>
                                <li><a href="<?PHP echo base_url();?>user/adduser"><i class="fa fa-angle-double-right"></i> Add New User</a></li>
                            </ul>
                        </li>
                        

                        <li class="treeview">
                            <a href="#">
                                <i class="fa fa-folder"></i> <span>Product</span>
                                <i class="fa fa-angle-left pull-right"></i>
                            </a>
                            <ul class="treeview-menu">
                              <li><a href="<?PHP echo base_url();?>product/"><i class="fa fa-angle-double-right"></i> Product List</a></li>
                                <li><a href="<?PHP echo base_url();?>product/addProduct"><i class="fa fa-angle-double-right"></i> Add New Product</a></li>
                            </ul>
                        </li>

                        <li class="treeview">
                            <a href="#">
                                <i class="fa fa-folder"></i> <span>Cateory</span>
                                <i class="fa fa-angle-left pull-right"></i>
                            </a>
                            <ul class="treeview-menu">
                              <li><a href="<?PHP echo base_url();?>category/"><i class="fa fa-angle-double-right"></i> Cateory List</a></li>
                                <li><a href="<?PHP echo base_url();?>category/addcat"><i class="fa fa-angle-double-right"></i> Add New Cateory</a></li>
                            </ul>
                        </li>
                        
                       
                    </ul>
                </section>
                <!-- /.sidebar -->
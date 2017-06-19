       <!-- header logo: style can be found in header.less -->
        <header class="header">
            <a href="<?PHP echo base_url()?>" class="logo">
                <!-- Add the class icon to your logo image or logo icon to add the margining -->
               ZenAdmin Test
            </a>
            <!-- Header Navbar: style can be found in header.less -->
            <nav class="navbar navbar-static-top" role="navigation">
                <!-- Sidebar toggle button-->
                <a href="#" class="navbar-btn sidebar-toggle" data-toggle="offcanvas" role="button">
                    <span class="sr-only">Toggle navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </a>
                <div class="navbar-right">
                    <ul class="nav navbar-nav">
                                               <!-- User Account: style can be found in dropdown.less -->
                        <li class="dropdown user user-menu">
                            <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                                <i class="glyphicon glyphicon-user"></i>
                                <span>Vijay Varade <i class="caret"></i></span>
                            </a>
                            <ul class="dropdown-menu">
                                <!-- User image -->
                                <li class="user-header bg-light-blue">
                                    <img src="<?PHP echo base_url();?>img/avatar3.png" class="img-circle" alt="User Image" />
                                    <p>
                                        Vijay Varade - Sr. PHP Developer
                                        <small>Member since July. 2010</small>
                                    </p>
                                </li>
                              
                                <li class="user-footer">
                                    <div class="pull-left">
                                        <a href="#" class="btn btn-default btn-flat">Profile</a>
                                    </div>
                                    <div class="pull-right">
                                        <a href="<?PHP echo base_url()?>login/logout" class="btn btn-default btn-flat">Sign out</a>
                                    </div>


                                </li>
                            </ul>
                        </li>
                    </ul>
                </div>
            </nav>
        </header>
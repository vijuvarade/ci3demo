<!DOCTYPE html>
<html class="bg-black">
    <head>
        <meta charset="UTF-8">
        <title>VSmartPay | Log in</title>
        <meta content='width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no' name='viewport'>
        <!-- bootstrap 3.0.2 -->
        <link href="css/bootstrap.min.css" rel="stylesheet" type="text/css" />
        <!-- font Awesome -->
        <link href="css/font-awesome.min.css" rel="stylesheet" type="text/css" />
        <!-- Theme style -->
        <link href="css/AdminLTE.css" rel="stylesheet" type="text/css" />

        <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
        <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
        <!--[if lt IE 9]>
          <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
          <script src="https://oss.maxcdn.com/libs/respond.js/1.3.0/respond.min.js"></script>
        <![endif]-->


       

    </head>
    <body class="bg-black">

       <div class="form-box" id="login-box">
            <div class="header">Sign In</div>
           <?PHP $attributes = array('id' => 'loginfrm'); echo form_open('', $attributes); ?>
                <div class="body bg-gray">
                    <div class="form-group">
                        <input type="text" name="user_name" id="user_name" class="form-control" placeholder="User ID"/>
                    </div>
                    <div class="form-group">
                        <input type="password" name="user_pass" id="user_pass" class="form-control" placeholder="Password"/>
                    </div>          
                 <!--   <div class="form-group">
                        <input type="checkbox" name="remember_me"/> Remember me
                    </div>-->

                  <span id="errmsg"></span>

                
                </div>


               


                <div class="footer">     

                    <button type="submit" class="btn bg-olive btn-block">Sign me in</button>  
                   
                    <p>
                        <?PHP echo anchor(base_url().'forgotPass','I forgot my password','');?>
                   </p>
                    
                   <!--<a href="register.html" class="text-center">Register a new membership</a>-->
                </div>
            </form>

            <div class="margin text-center">
                <span>Sign in using social networks</span>
                <br/>
                <button class="btn bg-light-blue btn-circle"><i class="fa fa-facebook"></i></button>
                <button class="btn bg-aqua btn-circle"><i class="fa fa-twitter"></i></button>
                <button class="btn bg-red btn-circle"><i class="fa fa-google-plus"></i></button>

            </div>
        </div>



        <!-- jQuery 2.0.2 -->
        <script src="http://ajax.googleapis.com/ajax/libs/jquery/2.0.2/jquery.min.js"></script>
        <!-- Bootstrap -->
        <script src="js/bootstrap.min.js" type="text/javascript"></script>        
 <!-- Login Form -->
<script type="text/javascript">
    $(document).ready(function(){
    $('#loginfrm').submit(function(){
       // alert(1);
       // $("#return_msg").empty().append("<div id='loading'><img src='<?PHP echo base_url();?>images/loading.gif' alt='Loading' /></div>");
        var var_form_data = $('#loginfrm').serialize();
       
        $.ajax({
                type: 'POST',
                url: "<?PHP echo base_url();?>login/validate_credentials",
                data: var_form_data,
                //data: 'user_name='+user_name+'user_pass='+user_pass+'recruit_agency='+recruit_agency,
                dataType: 'html',
                success: function (data){
              //  alert(data)
                if(data==1 || data==2 || data==3 )
                {
                    //redirectPage();
                    setTimeout(redirectPage(data),500);
                    var data ="<div id='success' class='alert alert-success'>Logging in.....</div>"
                    $('body').css('cursor', 'wait');
                }
                
                $("#login_erbox").show();
                $("#errmsg").html(data);
               
                return false;
                }
        });
        return false;
    });
});

function redirectPage(rd)
{
    var furl = 'dashboard/';
    
    if(rd==4){
        furl='dashboard/';
    }else if(rd==3){
    }
    window.location="<?PHP echo base_url();?>"+furl+"";
    }

</script>
<!-- Login Form -->

    </body>
</html>
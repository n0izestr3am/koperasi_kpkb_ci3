<?php $this->load->view('include/header'); ?>
<!DOCTYPE html>
<!--[if IE 8]>         <html class="no-js lt-ie9" lang="en" > <![endif]-->
<!--[if gt IE 8]><!--> <html class="no-js" lang="en" > <!--<![endif]-->

<head>    
  <link href='<?php echo config_item('img'); ?>favicon.png' type='image/x-icon' rel='shortcut icon'>
    
 <title><?php echo config_item('web_title'); ?></title>
    <!-- Bootstrap core CSS -->
 

<link href="<?php echo config_item('bootstrap'); ?>css/bootstrap.min.css" rel="stylesheet">
    <!-- Custom styles for this template -->
    <link href="<?php echo base_url(); ?>assets/login/css/login.css" rel="stylesheet">
    <link href="<?php echo base_url(); ?>assets/login/css/animate-custom.css" rel="stylesheet">
   <script type="text/javascript" src="<?php echo base_url(); ?>assets/login/js/jquery.min.js"></script>   
     <script src="<?php echo base_url(); ?>assets/login/js/custom.modernizr.html" type="text/javascript" ></script>
   
  </head>
    <body>
 <script type="text/javascript" src="<?php echo base_url(); ?>assets/login/md5.js"></script>
   <div class="container" id="login-block">
        <div class="row">
          <div class="col-sm-6 col-md-4 col-sm-offset-3 col-md-offset-4">
             
             <div class="login-box clearfix animated flipInY">
            <div class="login-logo">
<a href="#"><img class="img-responsive" src="<?php echo config_item('img'); ?>logo.png" width="150" height="150" alt="Company Logo" /></a>
                </div> 
                
                <div class="login-form">
             	<?php echo form_open('secure', array('id' => 'FormLogin')); ?>
                <input type="TEXT" name="username" placeholder="Username" class="input-field" autofocus required/>
                <input type="password" name="password" placeholder="Password" class="input-field" required/>
                <input id="form_submit" type="submit" class="btn btn-login" value="Login" />
                		
              	<?php echo form_close(); ?>

				<div id='ResponseInput'></div>
              
                </div>                
             </div>
          </div>
      </div>
      </div>
     
        <!-- End Login box -->
      <footer class="container">
        <p id="footer-text"><?php echo config_item('web_footer'); ?></p>
      </footer>

        <script>window.jQuery || document.write('<script src="js/jquery-1.9.1.min.js"><\/script>')</script> 
        <script src="<?php echo base_url(); ?>assets/login/js/bootstrap.min.js"></script> 
        <script src="<?php echo base_url(); ?>assets/login/js/placeholder-shim.min.js"></script>        
        <script src="<?php echo base_url(); ?>assets/login/js/custom.js"></script>
		<script>
$(function(){
	//------------------------Proses Login Ajax-------------------------//
	$('#FormLogin').submit(function(e){
		e.preventDefault();
		$.ajax({
			url: $(this).attr('action'),
			type: "POST",
			cache: false,
			data: $(this).serialize(),
			dataType:'json',
			success: function(json){
				//response dari json_encode di controller

				if(json.status == 1){ window.location.href = json.url_home; }
				if(json.status == 0){ $('#ResponseInput').html(json.pesan); }
				if(json.status == 2){
					$('#ResponseInput').html(json.pesan);
					$('#InputPassword').val('');
				}
			}
		});
	});

	//-----------------------Ketika Tombol Reset Diklik-----------------//
	$('#ResetData').click(function(){
		$('#ResponseInput').html('');
	});
});
</script>
    </body>
</html>


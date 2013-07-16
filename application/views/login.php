
<div id="columncontent">
  <div id="container">


    <h1 align="center">Login<br /><img src="images/sitewide/blubar.gif" alt="" width="540" height="5" /></h1>
    <div class="welcometext" align="left"> 
	


				</div>
 <!--Facebook-->
      


<!--Choose a location-->
<div class="list">

  </div>
 <?php $display = "" ?>


<span style = "font-weight: bold; color: red;">

</span>


<div id = "EmailForm" style = "<?php echo $display; ?>">

<?php echo validation_errors(); ?>
<?php echo $this->ion_auth->errors(); ?>
<?php echo $this->ion_auth->messages(); ?>


<form action="myaccount/login_user" method="post" name="ELForm" id="ELForm" enctype="multipart/form-data" >

<label for = "Email">Your Email Address: </label>
<input type="text" name="Email" id="Email" size="42" maxlength="200" value="<?php echo set_value('Email'); ?>" style="border:2px solid #000" >
<br /><br />

<label for = "Password">Password: </label>
<input type="password" name="Password" id="Password" size="42" maxlength="200" value="" style="border:2px solid #000" >
<br /><br />


<input type="text" name="firstname" id="firstname" size="42" maxlength="200" value="" style="border:2px solid #000"  >





<input type="submit" name="submit" id="submit" value="Login">

</form>
</div>
</div>
</div>
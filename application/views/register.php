<div id="columncontent">
  <div id="container">


    <h1 align="center">Register<br /><img src="images/sitewide/blubar.gif" alt="" width="540" height="5" /></h1>
    <div class="welcometext" align="left"> 
	


				</div>
 <!--Facebook-->
      


<!--Choose a location-->
<div class="list">

  </div>
 <?php $display = "" ?>


<span style = "font-weight: bold; color: red;">
<?php 
	if($this->input->get('success'))
	{

		if($this->input->get('success')==1)
			echo "Your Email Message was Successfully Sent";
		if($this->input->get('success')!=1)
			echo "Your Email Message was not sent. Please try again. If this problem persists, please send an email to webmaster@zoomtanzania.com";
	}

?>
</span>


<div id = "EmailForm" >

<?php echo validation_errors(); ?>


<form action="myaccount/registeruser" method="post" name="ELForm" id="ELForm" enctype="multipart/form-data" >


<label for = "FirstName">Your First Name: </label>
<input type="text" name="FirstName" id="FirstName" size="42" maxlength="200" value="<?php echo set_value('FirstName'); ?>" style="border:2px solid #000" >
<br /><br />

<!-- <label for = "LastName">Your Last Name: </label>
<input type="text" name="LastName" id="LastName" size="42" maxlength="200" value="<?php echo set_value('LastName'); ?>" style="border:2px solid #000" >
<br /><br /> -->

<label for = "Email">Your Email Address: </label>
<input type="text" name="Email" id="Email" size="42" maxlength="200" value="<?php echo set_value('Email'); ?>" style="border:2px solid #000" >
<br /><br />

<label for = "EmailConf">Confirm Your Email Address: </label>
<input type="text" name="EmailConf" id="EmailConf" size="42" maxlength="200" value="<?php echo set_value('EmailConf'); ?>" style="border:2px solid #000" >
<br /><br /><br />

<label for = "Password">Password: </label>
<input type="password" name="Password" id="Password" size="42" maxlength="200" value="" style="border:2px solid #000" >
<br /><br />

<label for = "PassConf">Confirm Password: </label>
<input type="password" name="PassConf" id="PassConf" size="42" maxlength="200" value="" style="border:2px solid #000" >
<br /><br /><br />


ZoomTanzania.com is supported by advertising.  The information requested below will be used only to target on-site banner ads that most closely reflect your interests.<br /><br />

<label for = "AreaID">Select Area Closest to you where you live: </label>
<select name="AreaID" id="AreaID"   style="border:2px solid #000; width: 200px" >
	<option value = "">-- Select Area --</option>
	<?php foreach($areas->result() as $area): ?>
		<option value = "<?php echo $area->AreaID ?>"><?php echo $area->Descr ?></option>
	<?php endforeach; ?>
</select>
<br /><br /><br />

<label for = "GenderID">What is Your Gender?: </label>
<select name="GenderID" id="GenderID"   style="border:2px solid #000; width: 200px" >
	<option value = "">-- Select Gender --</option>
	<option value = "1">Female</option>
	<option value = "2">Male</option>
</select>
<br /><br />

<label >When were you born?: </label>
<select name="BirthMonthID" id="BirthMonthID"   style="border:2px solid #000; width: 150px" >
	<option value = "">-- Select Month --</option>
	<option value = "1">January</option>
	<option value = "2">February</option>
	<option value = "3">March</option>
	<option value = "4">April</option>
	<option value = "5">May</option>
	<option value = "6">June</option>
	<option value = "7">July</option>
	<option value = "8">August</option>
	<option value = "9">September</option>
	<option value = "10">October</option>
	<option value = "11">November</option>
	<option value = "12">December</option>
</select>
<select name="BirthYearID" id="BirthYearID"   style="border:2px solid #000; width: 150px" >
	<option value = "">-- Select Year --</option>
	<?php 
		$currentYear = date("Y"); 
		for($i=$currentYear-1; $i>=1950; $i--):
	?>
		<option value = "<?php echo $i ?>"><?php echo $i ?></option>
	<?php endfor; ?>
</select>

<br /><br />

<label for = "SelfIdentifiedTypeID">How would you best describe yourself?: </label>
<select name="SelfIdentifiedTypeID" id="SelfIdentifiedTypeID"   style="border:2px solid #000; width: 200px" >
	<option value = "">-- Select One --</option>
	<?php foreach($selfidentifiedtypes->result() as $selfidentifiedtype): ?>
		<option value = "<?php echo $selfidentifiedtype->SelfIdentifiedTypeID ?>"><?php echo $selfidentifiedtype->Descr ?></option>
	<?php endforeach; ?>
</select>
<br /><br /><br />

<label for = "EducationLevelID">What is the hightest level of education you have achieved?: </label>
<select name="EducationLevelID" id="EducationLevelID"   style="border:2px solid #000; width: 200px" >
	<option value = "">-- Select One --</option>
	<?php foreach($educationlevels->result() as $educationlevel): ?>
		<option value = "<?php echo $educationlevel->EducationLevelID ?>"><?php echo $educationlevel->Descr ?></option>
	<?php endforeach; ?>
</select>
<br /><br />

<br /><br />


<input type="submit" name="submit" id="submit" value="Register">

</form>
</div>
</div>
</div>
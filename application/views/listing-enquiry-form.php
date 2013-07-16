<?php if(isset($otherBusinessesObj) or isset($featuredBusinessesObj)): ?>
<div id="columncontent">
  <div id="container">


    <h1 align="center">Send an Enquiry to <?php echo $catMeta->H1Text ?><br /><img src="images/sitewide/blubar.gif" alt="" width="540" height="5" /></h1>
    <div class="welcometext" align="left"> 
	


				</div>
 <!--Facebook-->
      


<!--Choose a location-->
<div class="list">

  </div>
 <?php $display = "" ?>
<?php endif; ?>

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



<div id = "EmailForm" style = "<?php echo $display; ?>">

<?php if(in_array($listing->ListingTypeID, array("10","12")) and $this->session->userdata('jobclicks') >= 3 ): ?>
<p style = "font-weight: bold; font-size:16px; color:red">Sorry, you've already applied to 3 jobs today</p>
<?php else: ?>
<?php echo validation_errors(); ?>
<?php echo $error; ?>
<?php if(isset($otherBusinessesObj) or isset($featuredBusinessesObj)): ?>
	<form action="querysix" method="post" name="ELForm" id="ELForm" enctype="multipart/form-data" >
<?php else: ?>
	<form action="sendlistingemail" method="post" name="ELForm" id="ELForm" enctype="multipart/form-data" >
<?php endif; ?>
<label for = "Email">* Your Email Address: </label>
<input type="text" name="Email" id="Email" size="42" maxlength="200" value="<?php echo set_value('Email'); ?>" style="border:2px solid #000" >
<br /><br />

<label for = "ConfirmEmail">* Confirm Email: </label>
<input type="text" name="ConfirmEmail" id="ConfirmEmail" size="42" maxlength="200" value="<?php echo set_value('ConfirmEmail'); ?>" style="border:2px solid #000" >
<br /><br />

<label for = "EmailFile[]">File: </label>
<input type="file" name="EmailFile" id="EmailFile"  value="" class="multi max-5" accept="txt|pdf|doc|docx|rtf|xls|xlsx|ppt|pptx|gif|jpg|jpeg|tiff" size="42" style="border:2px solid #000" >
<br /><br />

<label for = "SubjectLine">* Subject Line: </label>
<input type="text" name="SubjectLine" id="SubjectLine" size="42" maxlength="200" value="<?php echo set_value('SubjectLine'); ?>" style="border:2px solid #000" >
<br /><br />

<label for = "EmailBody">* Your Message: </label>
<textarea cols="30" rows="5" name="EmailBody" id="EmailBody" style="border:2px solid #000" value="<?php echo set_value('EmailBody'); ?>"></textarea>
<br /><br />

<br /><span class = "captcha-imageBL"><?php echo $cap['image'] ?></span><br />
<label for = "CaptchaEntry">* Match Text (<a href="javascript:void(0);" class = "captcha-refresh">Refresh</a>): </label>
<input type="text" name="CaptchaEntry" id="CaptchaEntry" size="42" maxlength="200" value="" style="border:2px solid #000" >
<br /><br />

<input type="text" name="firstname" id="firstname" size="42" maxlength="200" value="" style="border:2px solid #000"  >




<?php if(isset($otherBusinessesObj) or isset($featuredBusinessesObj)): ?>
<div class = "categories" align = "center" >

	<?php $i=0; ?>
    <?php if($featuredBusinessesObj->num_rows() != 0): ?>	
	<?php foreach($featuredBusinessesObj->result() as $Listing): ?>


	<?php $url= url_title(str_replace("&", "And",$Listing->ListingTitle)); ?>

		<?php if($Listing->HasExpandedListing): ?>
	  	<div style = "max-height:184px; min-height:184px;">
		  	<a href="<?php echo $url; ?>">
	  	

		<img src="<?php echo LISTINGUPLOADEDDOCS ?>/<?php echo $Listing->LogoImage ?>" alt="<?php echo $Listing->ListingTitle ?>" style = "max-width:75px; min-width:75px;" />
		

	  	</a><br />
	
	  	<input type="checkbox" name="ListingIDs[]" id="ListingIDs<?php echo $Listing->ListingID ?>" class="ListingIDs" value="<?php echo $Listing->ListingID ?>">

	  	<a href="<?php echo $url; ?>"> <span class="smallcategory"><?php echo $Listing->ListingTitle ?></a><br />
	      </span>
	  	
	      
	    </div>

	    <?php if($i==2): ?>
	    <!-- <div style = "clear: both;"></div> -->
	    <?php $i=-1; ?>
		<?php endif; ?>
			
	    <?php $i++; ?>
		<?php endif; ?>
	<?php endforeach; ?>
		<?php endif; ?>
</div>
	<div style = "clear: both;"></div>
	<?php if($otherBusinessesObj->num_rows() != 0): ?>	
	<?php foreach($otherBusinessesObj->result() as $Listing): ?>


	<?php $url= url_title(str_replace("&", "And",$Listing->ListingTitle)); ?>

		<?php if($Listing->HasExpandedListing): ?>
		<?php else: ?>
			<input type="checkbox" name="ListingIDs[]" id="ListingIDs<?php echo $Listing->ListingID ?>" class="ListingIDs" value="<?php echo $Listing->ListingID ?>"><a href="<?php echo $url; ?>"> <span class="smallcategory"><?php echo $Listing->ListingTitle ?></a><br />
	      </span>

	    
	<?php endif; ?>
			
		
	<?php endforeach; ?>

	

	<?php endif; ?>



</div>
</div>
<?php endif; ?>

<input type="submit" name="submit" id="submit" value="Send Email">
<a id="CancelEmailForm"><input type="button" name="cancel" id="cancel" value="Cancel"></a>
<?php if(!isset($otherBusinessesObj) or !isset($featuredBusinessesObj)): ?>
<input type="hidden" name="ListingID" id="ListingID" value="<?php echo $listing->ListingID; ?>">
<input type="hidden" name="ListingTypeID" id="ListingTypeID" value="<?php echo $listing->ListingTypeID; ?>">
<?php else: ?>
<input type="hidden" name="CategoryURL" id="CategoryURL" value="<?php echo $catMeta->URLSafeTitleDashed; ?>">
<input type="hidden" name="CategoryID" id="CategoryID" value="<?php echo $CategoryID; ?>">
<?php endif; ?>
<input type="hidden" name="FileCount" id="fileCount" value="0">
</form>
<?php endif; ?>
</div>

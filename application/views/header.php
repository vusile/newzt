<!DOCTYPE html>
<html lang="en">
<head>
<base href = "<?php echo base_url(); ?>" />
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<META NAME="country" CONTENT="Tanzania">
<?php
		if(isset($Meta->BrowserTitle) and ($Meta->BrowserTitle != '' ))
			$BrowserTitle = $Meta->BrowserTitle;

		else if(isset($Meta->H1Text) and $Meta->H1Text !='')
			$BrowserTitle = $Meta->H1Text;		

		else if(isset($Meta->CategoryH1Text) and $Meta->CategoryH1Text != '')
			$BrowserTitle = $Meta->CategoryH1Text;

		else if(isset($Meta->ParentSectionH1Text))
			$BrowserTitle = $Meta->ParentSectionH1Text;

		else if(isset($Meta->SectionH1Text) and $Meta->SectionH1Text !='' and !isset($Meta->ParentSectionH1Text))
			$BrowserTitle = $Meta->SectionH1Text;


		else if(isset($Meta->catH1Text) and $Meta->catH1Text !='')
			$BrowserTitle = $Meta->catH1Text;
		else if(isset($Meta->TitleTag) and $Meta->TitleTag != '')
			$BrowserTitle = $Meta->TitleTag;
		else if(isset($Meta->Title) and $Meta->Title != '')
			$BrowserTitle = $Meta->Title;

		if(isset($Meta->MetaDescr) and $Meta->MetaDescr != '')
			$MetaDescr = $Meta->MetaDescr;
		else
			$MetaDescr = '';


	?>
	<title>
		<?php echo $BrowserTitle; ?> 

		<?php if (isset($PageLocation)): ?>
			in <?php echo $PageLocation; ?>
		<?php endif; ?>


	</title>

	<META NAME="description" CONTENT="<?php echo strip_tags($MetaDescr); ?>">

	<script>

</script>
		<link href="styles/common.css" rel="stylesheet" type="text/css" />
		<link rel="shortcut icon" href="../favicon.ico">
        <!-- // <script type="text/javascript" src="js/jquery.roundabout.min.js"></script> -->
		<link rel="stylesheet" type="text/css" href="styles/megamenudefault.css" />
		<link rel="stylesheet" type="text/css" href="styles/megamenucomponent.css" />
<!-- 		<link href="styles/legacy/menu.css" rel="stylesheet" type="text/css" /> -->
		<link href="styles/tabcontent.css" rel="stylesheet" type="text/css" />
		<!-- <link href="styles/ui-lightness/jquery-ui-1.8.18.custom.css" rel="stylesheet" type="text/css" /> -->
		<link href="styles/style_tourism.css" rel="stylesheet" type="text/css" />
		<link href="styles/ui-lightness/jquery-ui-1.10.3.custom.css" rel="stylesheet" type="text/css" />
		<link href="styles/style_categories.css" rel="stylesheet" type="text/css" />
		<link href="styles/style_widepage.css" rel="stylesheet" type="text/css" />
		<link href="styles/timepicker.css" rel="stylesheet" type="text/css" />
		<link href="styles/jquery.timepicker.css" rel="stylesheet" type="text/css" />
		<link href="css/style_photogallery.css" rel="stylesheet" type="text/css" />
		<link rel="stylesheet" type="text/css" href="styles/legacy/skin.css" />
		<link href="styles/footer.css?323343" rel="stylesheet" type="text/css" />
		<link href="styles/exchange.css" rel="stylesheet" type="text/css" />
		<link href="styles/validation.css" rel="stylesheet" type="text/css" />
		<link href="styles/scroll.css" rel="stylesheet" type="text/css" />
		<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.8.3/jquery.min.js"></script>
        <!-- // <script type="text/javascript" src="js/legacy/jquery-ui-1.8.12.custom.min.js"></script> -->
        <script type="text/javascript" src="js/jquery-ui-1.10.3.custom.min.js"></script>
        <!-- // <script type="text/javascript" src="js/jquery.ui.slider.min.js"></script> -->
        <script src="js/tabcontent.js" type="text/javascript"></script>
         <script src="js/jquery-timepicker.js" type="text/javascript"></script>
         <script src="js/jquery.validate.min.js" type="text/javascript"></script>
         <script src="js/jquery.imageScroller.js" type="text/javascript"></script>

		<script src="js/jquery.maskedinput.min.js"></script>
		<script src="js/modernizr.custom.js"></script>
		<script src="js/forms.js"></script>
      <script src="js/modernizr.custom.63321.js"></script>
        <script src="js/cbpHorizontalMenu.js"></script>
        <script type="text/javascript" src="http://jquery-multifile-plugin.googlecode.com/svn/trunk/jquery.MultiFile.js"></script>

		<script>
			// $(function() {
			// 	cbpHorizontalMenu.init();
			// });

			$(document).ready(function(){
				$('#cbp-hrmenu > ul > li').hover(
					function(){
						$(this).addClass('cbp-hropen');
					},
					function(){
						$(this).removeClass('cbp-hropen');
					}
				);


				
				$('.calendar').datepicker();
				
				$('.time').timepicker({
					hourGrid: 4,
					minuteGrid: 10,
					timeFormat: 'hh:mm tt'
				});
				$('.time2').timepicker();

				$("#form4").validate();


				$("#ELForm").validate({
				  rules: {
				    Email: {
				      required: true,
				      email:true
				    },	
    			   	 ConfirmEmail: {
				      required: true,
				      equalTo: '#Email'
				    },
				    SubjectLine: {
				      required: true
				    },
				    EmailBody: {
				      required: true
				    },				    
				    CaptchaEntry: {
				      required: true,
				      remote: {
				      		url:"ajax_validate_captcha",
				      }
				    },
				    <?php if(isset($getQuotes)): ?>
				    "ListingIDs[]": {
				      required: true,
				      minlength: 1
				    },	
				    <?php endif; ?>

				  },
				  messages: {
				    Email: {
				      required: "We need your email address to contact you",
				      email: "Please enter a valid email"
				    },

    			   	 ConfirmEmail: {
				      required: "Please confirm your email.",
				      equalTo: "The email you typed doesn't match the one you typed above."

				    },
				    SubjectLine: {
				      required: "A subject line is required"
				    },
				    EmailBody: {
				      required: "Please type in a message for your enquiry"
				    },				    
				    CaptchaEntry: {
				      required: "Please verify that your human by typing the letters in the image above",
				      remote: "Incorrect Captcha"
				    },
				    <?php if(isset($getQuotes)): ?>
				    "ListingIDs[]": {
				      required: "Please Select Atleast One Business",
				      
				    },	
				    <?php endif; ?>


				  }
				});


				$(".phone").mask("+255 999 999 999");
		

				//REAL ESTATE SEARCH FORM
				$("#form4 :input").attr("disabled", true);

				$("#form4 #CategoryID").attr("disabled", false);
				$("#form4 #search").attr("disabled", false);				

				$('#form4 #CategoryID').on('change', function() {
				  
				  switch(this.value)
				  {
				  	case '87':
				  	case '322':
				  	case '323':
				  	case '324':
					$("#form4 :input").attr("disabled", true);
					$("#form4 #CategoryID").attr("disabled", false);
					$("#form4 #TermID").attr("disabled", false);
					$("#form4 #LocationID").attr("disabled", false);
					$("#form4 #AmenityID").attr("disabled", false);
					$("#form4 #MinRent").attr("disabled", false);
					$("#form4 #MaxRent").attr("disabled", false);					
					$("#form4 #Beds").attr("disabled", false);
					$("#form4 #Baths").attr("disabled", false);
					$("#form4 #Currency").attr("disabled", false);
					$("#form4 #search").attr("disabled", false);
					$("#form4 #MinPriceDIV").hide('slow');
					$("#form4 #MaxPriceDIV").hide('slow');
					$("#form4 #MinRentDIV").show('slow');
					$("#form4 #MaxRentDIV").show('slow');
					$("#form4 #TermIDDIV").show('slow');
					$("#form4 #BathsDIV").show('slow');
					$("#form4 #BedsDIV").show('slow');
					$("#form4 #AmenityIDDIV").show('slow');
				  	
				  	break;


				  	case '286':
				  	case '398':
				  	case '399':
					$("#form4 :input").attr("disabled", true);
					$("#form4 #CategoryID").attr("disabled", false);
					$("#form4 #TermID").attr("disabled", false);
					$("#form4 #LocationID").attr("disabled", false);
					$("#form4 #MinRent").attr("disabled", false);
					$("#form4 #MaxRent").attr("disabled", false);					
					$("#form4 #Currency").attr("disabled", false);
					$("#form4 #search").attr("disabled", false);
					$("#form4 #MinPriceDIV").hide('slow');
					$("#form4 #MaxPriceDIV").hide('slow');
					$("#form4 #BathsDIV").hide('slow');
					$("#form4 #BedsDIV").hide('slow');
					$("#form4 #AmenityIDDIV").hide('slow');
					$("#form4 #TermIDDIV").show('slow');
					$("#form4 #MinRentDIV").show('slow');
					$("#form4 #MaxRentDIV").show('slow');
				  	
				  	break;

				  	case '287':
				  	case '288':
					$("#form4 :input").attr("disabled", true);
					$("#form4 #CategoryID").attr("disabled", false);
					$("#form4 #LocationID").attr("disabled", false);
					$("#form4 #MinPrice").attr("disabled", false);
					$("#form4 #MaxPrice").attr("disabled", false);					
					$("#form4 #Currency").attr("disabled", false);
					$("#form4 #search").attr("disabled", false);
					$("#form4 #MinRentDIV").hide('slow');
					$("#form4 #MaxRentDIV").hide('slow');	
					$("#form4 #TermIDDIV").hide('slow');		
					$("#form4 #BathsDIV").hide('slow');
					$("#form4 #BedsDIV").hide('slow');	
					$("#form4 #AmenityIDDIV").hide('slow');					
					$("#form4 #MinPriceDIV").show('slow');
					$("#form4 #MaxPriceDIV").show('slow');
				  	
				  	break;

				  	case '89':
					$("#form4 :input").attr("disabled", true);
					$("#form4 #AmenityID").attr("disabled", false);
					$("#form4 #CategoryID").attr("disabled", false);
					$("#form4 #LocationID").attr("disabled", false);
					$("#form4 #MinPrice").attr("disabled", false);
					$("#form4 #MaxPrice").attr("disabled", false);					
					$("#form4 #Currency").attr("disabled", false);
					$("#form4 #search").attr("disabled", false);
					$("#form4 #Beds").attr("disabled", false);
					$("#form4 #Baths").attr("disabled", false);
					$("#form4 #MinRentDIV").hide('slow');
					$("#form4 #MaxRentDIV").hide('slow');
					$("#form4 #TermIDDIV").hide('slow');	
					$("#form4 #MinPriceDIV").show('slow');
					$("#form4 #MaxPriceDIV").show('slow');
				  	
				  	break;

				  	default:
				  	// alert(this.value);
				  	break;
				  }

				});



				//CARS SEARCH FORM
				$("#form3 :input").attr("disabled", true);
				$("#form3 #CategoryID").attr("disabled", false);
				$("#form3 #search").attr("disabled", false);

				$('#form3 #CategoryID').on('change', function() {
				  
				  switch(this.value)
				  {

				  	case '401':
						$("#form3 :input").attr("disabled", true);
						$("#form3 #CategoryID").attr("disabled", false);
						$("#form3 #LocationID").attr("disabled", false);
						$("#form3 #MinPrice").attr("disabled", false);
						$("#form3 #MaxPrice").attr("disabled", false);	
						$("#form3 #search").attr("disabled", false);
						$("#form3 #Currency").attr("disabled", false);
						$("#form3 #MakeIDDIV").hide('slow');
						$("#form3 #TransmissionIDDIV").hide('slow');
						$("#form3 #FourWheelDriveDIV").hide('slow');
						$("#form3 #KilometersDIV").hide('slow');
						$("#form3 #YearToDIV").hide('slow');
						$("#form3 #YearFromDIV").hide('slow');
				  	break;


				  	case '84':
						$("#form3 :input").attr("disabled", true);
						$("#form3 #CategoryID").attr("disabled", false);
						$("#form3 #LocationID").attr("disabled", false);
						$("#form3 #MakeID").attr("disabled", false);
						$("#form3 #TransmissionID").attr("disabled", false);
						$("#form3 #Kilometers").attr("disabled", false);
						$("#form3 #FourWheelDrive").attr("disabled", false);
						$("#form3 #MinPrice").attr("disabled", false);
						$("#form3 #MaxPrice").attr("disabled", false);	
						$("#form3 #search").attr("disabled", false);
						$("#form3 #Currency").attr("disabled", false);
						$("#form3 #YearFrom").attr("disabled", false);
						$("#form3 #YearTo").attr("disabled", false);
						$("#form3 #MakeIDDIV").show('slow');
						$("#form3 #TransmissionIDDIV").show('slow');
						$("#form3 #FourWheelDriveDIV").show('slow');
						$("#form3 #KilometersDIV").show('slow');
						$("#form3 #YearToDIV").show('slow');
						$("#form3 #YearFromDIV").show('slow');  	
				  	break;

				  	case '85':
				  	case '86':
						$("#form3 :input").attr("disabled", true);
						$("#form3 #CategoryID").attr("disabled", false);
						$("#form3 #LocationID").attr("disabled", false);
						$("#form3 #Kilometers").attr("disabled", false);
						$("#form3 #MinPrice").attr("disabled", false);
						$("#form3 #MaxPrice").attr("disabled", false);	
						$("#form3 #search").attr("disabled", false);
						$("#form3 #Currency").attr("disabled", false);
						$("#form3 #YearFrom").attr("disabled", false);
						$("#form3 #YearTo").attr("disabled", false);
						$("#form3 #TransmissionIDDIV").hide('slow');
						$("#form3 #FourWheelDriveDIV").hide('slow');
						$("#form3 #MakeIDDIV").hide('slow');
						$("#form3 #KilometersDIV").show('slow');
						$("#form3 #YearToDIV").show('slow');
						$("#form3 #YearFromDIV").show('slow');		  	
				  	break;

				  	

				  	default:
						$("#form3 :input").attr("disabled", true);
						$("#form3 #CategoryID").attr("disabled", false);
						$("#form3 #LocationID").attr("disabled", false);
						$("#form3 #MakeID").attr("disabled", false);
						$("#form3 #TransmissionID").attr("disabled", false);
						$("#form3 #Kilometers").attr("disabled", false);
						$("#form3 #FourWheelDrive").attr("disabled", false);
						$("#form3 #MinPrice").attr("disabled", false);
						$("#form3 #MaxPrice").attr("disabled", false);	
						$("#form3 #search").attr("disabled", false);
						$("#form3 #Currency").attr("disabled", false);
						$("#form3 #YearFrom").attr("disabled", false);
						$("#form3 #YearTo").attr("disabled", false);
						$("#form3 #MakeIDDIV").show('slow');
						$("#form3 #TransmissionIDDIV").show('slow');
						$("#form3 #FourWheelDriveDIV").show('slow');
						$("#form3 #KilometersDIV").show('slow');
						$("#form3 #YearToDIV").show('slow');
						$("#form3 #YearFromDIV").show('slow');
				  	break;
				  }

				});

			});
		</script>
		<script>
		
		</script>

        <script type="text/javascript" src="js/jquery.jcarousel.js"></script>
        <!--<script type="text/javascript" src="js/jquery.jcarousel.min.js"></script>-->
        <script>
	$(document).ready(function() {
		$('.CategorySelect').change(function() {
			if ($(this).val() != '') {
				$(this).closest("form").attr('action', $(this).val());
				$(this).closest("form").submit();
			}
		});
	});
</script>

        <style type = "text/css">
        	.menubox {clear: both;}
        </style>
        
</head>

<body>
	<div id="loginbar">
		
	<?php if(!$this->ion_auth->logged_in()): ?>
		<div id="loginbutton"><a  href="myaccount">log in</a>  |   <a  href="myaccount/register">register</a> </div>
	<?php else:  ?>
		<div id="loginbutton"><a  href="myaccount">My Account</a>  |   <a  href="myaccount/logout">logout</a> </div>
	<?php endif; ?>

		<div id="searchbutton"><input name="zoomsearch" type="text" id="zoomsearch" value="search in zoomtanzania" size="30" maxlength="70" />
	  <a  href="#">  <input name="zoom search" type="button" value="zoom search" /> 
		  
	</a>        
	<input name="zoomidsearch" type="text" id="zoomidsearch" value="# zoom ID" size="10" maxlength="70" />
	  <a  href="#">  
	  <input name="idsearch" type="button" value="#search by ID" />
		  
	</a></div></div>
	<div id="page">
	

	<?php if(isset($home)): ?>
	<div id="header" align="center">
			<div align="left" class="smallads">
				<img src="http://placehold.it/180x90" />
			</div>
			<div style = "margin-top:0px;">
				<a href = "<?php echo base_url(); ?>"><img src="images/sitewide/logoZoom.png" width="359" height="120" style=""/></a>
			</div>
			<div align="right" class="smallads">
				<img src="http://placehold.it/180x90" />
			</div>
	</div>
	<?php else: ?>
	<div id="headersitewide">
		<div style = "width:275px;position:absolute; top:10%; height:6.25em; margin-top:-0.313em">
			<a href = "<?php echo base_url(); ?>"><img src="images/sitewide/logoZoom.jpg" alt="" width="275" height="91" style=""/></a>
		</div>
		<div style = "width:728px;position:absolute; left:290px; top:10%; height:6.25em; margin-top:-0.313em" align="right">
			<img src="http://placehold.it/728x90" alt="" />
		</div>
	</div>
	<?php endif; ?>

	<div id = "messages"></div>
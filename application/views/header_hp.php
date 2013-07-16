<!DOCTYPE html>
<html lang="en">
<head>
<base href = "<?php echo base_url(); ?>" />
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<META NAME="country" CONTENT="Tanzania">
<?php
		if(isset($Meta->H1Text) and $Meta->H1Text !='')
			$BrowserTitle = $Meta->H1Text;		
		else if(isset($Meta->BrowserTitle) and ($Meta->BrowserTitle != '' ))
			$BrowserTitle = $Meta->BrowserTitle;
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
		<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.8.3/jquery.min.js"></script>
        <!-- // <script type="text/javascript" src="js/legacy/jquery-ui-1.8.12.custom.min.js"></script> -->
        <script type="text/javascript" src="js/jquery-ui-1.10.3.custom.min.js"></script>
        <!-- // <script type="text/javascript" src="js/jquery.ui.slider.min.js"></script> -->
        <script src="js/tabcontent.js" type="text/javascript"></script>
         <script src="js/jquery-timepicker.js" type="text/javascript"></script>
         <script src="js/jquery.validate.min.js" type="text/javascript"></script>

		<script src="js/jquery.maskedinput.min.js"></script>
		<script src="js/modernizr.custom.js"></script>
      <script src="js/modernizr.custom.63321.js"></script>
        <script src="js/cbpHorizontalMenu.js"></script>
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


				// $('#mycarousel').roundabout();
				$('.calendar').datepicker();
				$('.time').timepicker({
					hourGrid: 4,
					minuteGrid: 10,
					timeFormat: 'hh:mm tt'
				});
				$('.time2').timepicker();

				$("form").validate();


				$(".phone").mask("+255 999 999 999");
		


			});
		</script>
		<script>
		
		</script>

        <script type="text/javascript" src="js/jquery.jcarousel.js"></script>
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
        <!--<script type="text/javascript" src="js/jquery.jcarousel.min.js"></script>-->
        
</head>

<body>
	<div id="loginbar"><div id="loginbutton"><a  href="#">log in</a>  |   <a  href="#">register</a> </div><div id="searchbutton"><input name="zoomsearch" type="text" id="zoomsearch" value="search in zoomtanzania" size="30" maxlength="70" />
	  <a  href="#">  <input name="zoom search" type="button" value="zoom search" /> 
		  
	</a>        
	<input name="zoomidsearch" type="text" id="zoomidsearch" value="# zoom ID" size="10" maxlength="70" />
	  <a  href="#">  
	  <input name="idsearch" type="button" value="#search by ID" />
		  
	</a></div></div>
	<div id="page">
		<div id="header" align="center">
			<div align="left"><img src="http://placehold.it/180x150" /></div>
	
			<div><img src="images/sidewide/logoZoom.png" width="359" height="120" style=""/></div><div align="right"><img src="http://placehold.it/180x150" /></div>
	</div>
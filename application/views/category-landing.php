<div id="fb-root"></div>
<script>(function(d, s, id) {
  var js, fjs = d.getElementsByTagName(s)[0];
  if (d.getElementById(id)) return;
  js = d.createElement(s); js.id = id;
  js.src = "//connect.facebook.net/en_US/all.js#xfbml=1&appId=231785620286787";
  fjs.parentNode.insertBefore(js, fjs);
}(document, 'script', 'facebook-jssdk'));</script>


<script>
function search(SearchTerm,ID)
{

	var curURL = document.URL;
	var URL = new Array();
	URL[0]=curURL;

	if (curURL.indexOf("LocationID")) {URL =curURL.split("?LocationID");}

	 if ($.browser.msie)
		window.location = URL[0] + "?" + SearchTerm + "=" + ID;
	
	else
		window.location.replace(URL[0] + "?" + SearchTerm + "=" + ID);
		
}
</script>
<div id="fb-root"></div>
<script>(function(d, s, id) {
  var js, fjs = d.getElementsByTagName(s)[0];
  if (d.getElementById(id)) return;
  js = d.createElement(s); js.id = id;
  js.src = "//connect.facebook.net/en_US/all.js#xfbml=1&appId=231785620286787";
  fjs.parentNode.insertBefore(js, fjs);
}(document, 'script', 'facebook-jssdk'));</script>
<div id="columncontent">
  <div id="container">


    <h1 align="center"><?php echo $catMeta->catH1Text ?> in <?php echo $PageLocation; ?><br /><img src="images/sitewide/blubar.gif" alt="" width="540" height="5" /></h1>
    <div class="welcometext" align="left"> 
	
		<!--Breadcrumbs-->
		
      <div class="smallbreadcrumbs"><!-- <a href="#">Home</a> &gt;<a href="#"> <?php echo $listing->ParentSection; ?></a> &gt; <a href="#"><?php echo $listing->Category; ?></a> &gt; <?php echo $listing->ListingTitle; ?></p> -->

<div class="fb-like" data-href="http://www.facebook.com/pages/ZoomTanzaniacom/196820157025531" data-send="true" data-width="572" data-show-faces="true"></div>
				</div>
 <!--Facebook-->
      
  <?php 
    $queryString = "";
    $quotesLocationString = "";
    if($this->input->get(NULL, TRUE))
    {
      foreach($this->input->get(NULL, TRUE) as $parameter=>$value)
      {
        if($parameter == "LocationID" or $parameter == "offset"){
        	if($parameter == "LocationID")
        		$quotesLocationString .= "&" . $parameter . "=" . $value;

        }
        else  $queryString .= "&" . $parameter . "=" . $value;
      }

  	  $quotesLocationString .= $queryString;
    }
  ?>

<!--Choose a location-->
<div class="list">
    <div><span class="uppercap">Choose a location</span><br />
    <span class="smallcategory"><a href="<?php echo current_url(); ?>?LocationID=1<?php echo $queryString ?>">Dar Es Salaam </a>    |     <a href="<?php echo current_url(); ?>?LocationID=13<?php echo $queryString ?>">Zanzibar </a>    |     <a href="<?php echo current_url(); ?>?LocationID=9-16<?php echo $queryString ?>">Arusha/Moshi </a>    |    </span>
    <form style = "width:100px; display:inline;" action = "" method = "post">

      <select name="CategorySelect" id="CategorySelect" class = "CategorySelect" style ="display:inline;" onChange=search('LocationID',this.value) >
      <option value="">Other Areas</option>
      <?php foreach($locations->result() as $location): ?>
        <option value="<?php echo $location->LocationID ?>" ><?php echo $location->Title; ?></option>
      <?php endforeach; ?>
    </select>
  <form>
  </div>
  </div>

     
<!--h2 title and button-->

    <?php $ListingTypeID = $Featured_listings_result_obj->row()->ListingTypeID; ?>
  	<div class="list pullleft"  clear: "none;">
      <h2 style = "width:250px;"><br />
      <?php if($ListingTypeID != 9): ?>
      	Featured 
      <?php endif; ?>
      	<?php echo $catMeta->catH1Text ?>
      </h2>
  </div>
  <div class="pullright">

	       	<img src="images/sitewide/button_post.png" alt="post a listing" />
	       	<a href = "getquotes?CategoryID=<?php echo $catMeta->CategoryID . $quotesLocationString; ?>" ><img src="images/sitewide/button_quote.png" alt="Request a Quote" title = "TIP:  Use the 'Filter Listings' fields above to narrow your options before opening the group inquiry form."/></a>
			<!-- <form name = "se" id = "se" method="post" action = "request-quote" style = "display: inline;">
				<input type="hidden" name="ListingResults" value="<?php echo $quoteRequestString; ?>">
				<input type="hidden" name="CategoryID" value="93">	
				<input type="hidden" name="CategoryURL" value="AirlinesinTanzania">	
	       		<input type = "image" name = "SGI" id = "SGI" src="images/sitewide/button_quote.png"  title = "TIP:  Use the 'Filter Listings' fields above to narrow your options before opening the group inquiry form." />
			</form> -->
		</div>

       

	
	<!--Close Titles and tools-->
   
</div>
    
    <!--Business & Categories Landing Page featured-->

    <div class="categories" align="center">
    

    <?php $i=0; ?>
    <?php if($Featured_listings_result_obj->num_rows() != 0): ?>	
	<?php foreach($Featured_listings_result_obj->result() as $Listing): ?>

		<?php if($ListingTypeID == 9): ?>
			<?php $url="listingdetail?ListingID=" . $Listing->ListingID; ?>
		<?php else: ?>
			<?php $url= url_title(str_replace("&", "And",$Listing->ListingTitle)); ?>
		<?php endif; ?>
		<?php if($Listing->HasExpandedListing): ?>
	  <div><a href="<?php echo $url; ?>">
	  	
		<?php if($ListingTypeID==9): ?>
	  		<img src="<?php echo LISTINGUPLOADEDDOCS ?>/<?php echo $Listing->ELPTypeThumbnailImage; ?>" alt="<?php echo $Listing->ListingTitle ?>"  />
	  	<?php else: ?>
	  		<img src="<?php echo LISTINGUPLOADEDDOCS ?>/<?php echo $Listing->LogoImage ?>" alt="<?php echo $Listing->ListingTitle ?>"  />
		<?php endif; ?>

	  	</a><br /><a href="<?php echo $url; ?>"> <span class="smallcategory"><?php echo $Listing->ListingTitle ?></a><br />
	      </span><span class="smallcategorynormal"><?php echo trim(str_replace("Other", $Listing->LocationOther, $Listing->Location)); ?>
	  	</span>
	      </h2>
	    </div>
			<?php $i++; ?>
		<?php endif; ?>
	<?php endforeach; ?>
	<?php endif; ?>
	
		
	<?php if($i%3 != 0): ?>
	
	<?php if(($i+1)%3 == 0): ?>
	<div><a href="#"><img src="images/sitewide/B_feauture.png" alt="Feature Your Business Here"  /></a>
	    </div>
	<?php elseif(($i+2)%3 == 0): ?>
		<div><a href="#"><img src="images/sitewide/B_feauture.png" alt="Feature Your Business Here"  /></a>
	    </div>
	    	<div><a href="#"><img src="images/sitewide/B_feauture.png" alt="Feature Your Business Here"  /></a>
	    </div>
	<?php endif; ?>
	<?php endif; ?>

	 </div>
	 
	 <!--Business & Categories Landing Page All list in 2 row for all the categories in the section or subsection-->
	 <?php if($ListingTypeID != 9): ?>
	 <div class="list">
      <div><h2>All <?php echo $catMeta->catH1Text ?></h2>
      <ul>
      <?php foreach($Listings_result_obj->result() as $Listing): ?>
      <li> 
    	<a href="<?php echo url_title($Listing->ListingTitle); ?>">
    	<span class="smallcategory"><?php echo $Listing->ListingTitle; ?></span></a><br>
     
    	
     		<?php echo trim(str_replace("Other", $Listing->LocationOther, $Listing->Location)); ?>
			

     		</li>
      <?php endforeach; ?>
      </ul>
      
      </div>
  
		</div>
	<?php endif; ?>



</div>
    <div class="welcometext" align="left"> 
	
		

      <!--Page Text-->
      <p>
        
		<?php if(isset($pageText)): ?>
			<?php echo $pageText; ?><br>
		<?php endif; ?>
       
      </p>
      </div>
      </div>
      </div>
     

      

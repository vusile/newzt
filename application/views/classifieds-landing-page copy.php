<script>(function(d, s, id) {
  var js, fjs = d.getElementsByTagName(s)[0];
  if (d.getElementById(id)) return;
  js = d.createElement(s); js.id = id;
  js.src = "//connect.facebook.net/en_US/all.js#xfbml=1&appId=231785620286787";
  fjs.parentNode.insertBefore(js, fjs);
}(document, 'script', 'facebook-jssdk'));</script>
<div id="columncontent">
<div id="container">
    <h1 align="center"> <?php echo $sectionMeta->H1Text ?> in <?php echo $PageLocation ?><img src="images/sitewide/blubar.gif" alt="" width="540" height="5" /></h1>
    <div class="welcometext" align="left"> 
    <!--breadcrumbs TO SET-->
<!--       <div class="smallbreadcrumbs"><a href="#">Home</a> &gt;<a href="#"> <?php echo $listing->ParentSection; ?></a> &gt; <a href="#"><?php echo $listing->Category; ?></a> &gt; <?php echo $listing->ListingTitle; ?></div> -->
      <!--facebook page  inside welcometext-->
    <div class="fb-like" data-href="http://www.facebook.com/pages/ZoomTanzaniacom/196820157025531" data-send="true" data-width="572" data-show-faces="true"></div>
	</div>
 
    
      <!--choose a location inside a line-->
<div class="list">
    <div><span class="uppercap">Choose a location</span><br />
    <span class="smallcategory"><a href="<?php echo current_url(); ?>?LocationID=1">Dar Es Salaam </a>       |         <a href="<?php echo current_url(); ?>?LocationID=13">Zanzibar </a>          |      <a href="<?php echo current_url(); ?>?LocationID=9-16">  Arusha/Moshi </a>           </span>
    <form style = "width:100px; display:inline;" action = "" method = "post">

      <select name="CategorySelect" id="CategorySelect" class = "CategorySelect" style ="display:inline;" onChange=search('LocationID',this.value) >
      <option value="">Select Area</option>
      <?php foreach($locations->result() as $location): ?>
        <option value="<?php echo $location->LocationID ?>" ><?php echo $location->Title; ?></option>
      <?php endforeach; ?>
    </select>
  <form>
  </div>
  </div>
  
  
  <!--container close / open pagination / title h2 and buttons-->
  
      
    
    
<!--pagination MINI STYLE-->
<?php $paginate= $this->pagination->create_links(); echo $paginate; ?>


<div class="welcometext">
       <div class="pullright"><img src="images/sitewide/button_classified.png" width="127" height="36" alt="classified" /></div>
        <div> 
<h2 style = "width:300px;"> <?php echo $sectionMeta->H1Text ?>  <?php echo $this->pagination->total_rows; ?> available in <?php echo $PageLocation ?></h2>
        </div>
        </div> 
    </div>

    <!--CONTENT FOR CLASSIFIEDS - VEHICLES. REAL ESTATE. BUY AND SELL-->
    
    <div class="categories">

<?php foreach($listings->result() as $listing): ?>
<?php if($listing->ListingTypeID == 1): ?>
    <?php continue; ?>
  <?php else: ?>
  <?php


    if($listing->ListingTypeID != 15)
    {

      if($listing->ListingTypeID == 6 or $listing->ListingTypeID==7)
      {
          if(isset($listing->RentUS))
            $price = '$US ' . number_format($listing->RentUS);
          else
            $price = 'TZS ' . number_format($listing->RentTZS);

          $price .= '/' . $listing->Term;
      }
      else
      {
          if(isset($listing->PriceUS))
            $price = '$US ' . number_format($listing->PriceUS);
          else
            $price = 'TZS ' . number_format($listing->PriceTZS);    

      }
    }
    if($SectionID == 55)
    {
      if($listing->ListingTypeID==3)
       $ListingTitle = $listing->ListingTitle;
     else
      $ListingTitle = $listing->VehicleYear . ' ' . $listing->Make . ' ' . $listing->ModelOther;
    }
    else
      $ListingTitle = $listing->ListingTitle;

  ?>
  <div>

    <?php if($listing->ELPTypeThumbnailImage): ?>
    <a href="listingdetail?ListingID=<?php echo $listing->ListingID; ?>">
    <img src="http://www.zoomtanzania.com/ListingUploadedDocs/<?php echo $listing->ELPTypeThumbnailImage; ?>" alt="<?php echo $ListingTitle; ?>" width = "150"  /></a>
    <?php elseif($listing->FileNameForTN): ?>
    <a href="listingdetail?ListingID=<?php echo $listing->ListingID; ?>">
    <img src="http://www.zoomtanzania.com/ListingImages/CategoryThumbnails/<?php echo $listing->FileNameForTN; ?>" alt="<?php echo $ListingTitle; ?>" width = "150"  /></a>

    <?php else: ?>
      <a href="listingdetail?ListingID=<?php echo $listing->ListingID; ?>">
    <img src="images/sitewide/no_image.jpg" alt="<?php echo $ListingTitle; ?>" width = "150"  /></a>
    <?php endif; ?>
    <br> <a href="listingdetail?ListingID=<?php echo $listing->ListingID; ?>"><?php echo $ListingTitle ?></a><br>
    <?php if(isset($price)): ?>
    <?php echo $price; ?>
    <?php endif; ?>

    <?php if($listing->RecurrenceID): ?>

    <?php else: ?>  
    <?php if($listing->EventStartDate): ?>
    <?php echo date('M d', strtotime($listing->EventStartDate)) ?>
    <?php endif; ?>

    <?php if($listing->EventEndDate): ?>
    - <?php echo date('M d', strtotime($listing->EventEndDate)) ?>
    <?php endif; ?>
    <?php endif; ?>


          <br /><span class="smallcategorynormal"> <?php echo $listing->Location ?></span>
	      </h3>
	    </div>
    <?php endif; ?>
<?php endforeach; ?>

          <div><a href="#">
		 <img src="images/sitewide/C_postfree.png" alt="Tourism and travels" width = "150" height = "150" />
		  </a>
		  
          </div>
	    </ul>
    </div>
    <div class="welcometext" align="left"> 
                  <?php if(isset($pageTextObj) and $pageTextObj->num_rows() > 0): ?>
          <?php echo $pageTextObj->row()->Descr; ?><br>
        <?php endif; ?> 
        
<!--pagination MINI STYLE-->
<?php echo $paginate; ?>
</div>
  


</div>
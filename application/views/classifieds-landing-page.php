<script>(function(d, s, id) {
  var js, fjs = d.getElementsByTagName(s)[0];
  if (d.getElementById(id)) return;
  js = d.createElement(s); js.id = id;
  js.src = "//connect.facebook.net/en_US/all.js#xfbml=1&appId=231785620286787";
  fjs.parentNode.insertBefore(js, fjs);
}(document, 'script', 'facebook-jssdk'));</script>
<div id="columncontent">
<div id="container">
    <h1 align="center"> 

    <?php if(isset($sectionMeta->CategoryH1Text)): ?>
      <?php echo $sectionMeta->CategoryH1Text ?> 
    <?php elseif(isset($sectionMeta->SectionH1Text)):?>
      <?php echo $sectionMeta->SectionH1Text ?> 
    <?php endif; ?>


      in <?php echo $PageLocation ?><img src="images/sitewide/blubar.gif" alt="" width="540" height="5" /></h1>
    <div class="welcometext" align="left"> 

    <?php $listing=$listings->row(); ?> 

<p class="smallbreadcrumbs">
  <a href="">Home</a> &gt;

<?php if(isset($sectionMeta->SectionH1Text) and !isset($sectionMeta->ParentSectionH1Text))  : ?>
   <a href="<?php echo url_title(str_replace("&", "And",$sectionMeta->Section)); ?>"> <?php echo $sectionMeta->SectionH1Text; ?></a>
  <?php endif; ?>  

  <?php if(isset($sectionMeta->ParentSectionH1Text))  : ?>
   <a href="<?php echo url_title(str_replace("&", "And",$sectionMeta->ParentSection)); ?>"> <?php echo $sectionMeta->ParentSectionH1Text; ?></a>
  <?php endif; ?>

  <?php if(isset($sectionMeta->CategoryH1Text)): ?>
   &gt; <a href="<?php echo url_title(str_replace("&", "And",$sectionMeta->Category)); ?>"><?php echo $sectionMeta->CategoryH1Text ?></a> 
  <?php endif; ?>
</p>
      <!--facebook page  inside welcometext-->
    <div class="fb-like" data-href="http://www.facebook.com/pages/ZoomTanzaniacom/196820157025531" data-send="true" data-width="572" data-show-faces="true"></div>
	</div>

  <?php 
    $queryString = "";
    if($this->input->get(NULL, TRUE))
    {
      foreach($this->input->get(NULL, TRUE) as $parameter=>$value)
      {
        if($parameter == "LocationID" or $parameter == "offset"){}
        else $queryString .= "&" . $parameter . "=" . $value;
      }
    }
  ?>
 
    
      <!--choose a location inside a line-->
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
  
  
  <!--container close / open pagination / title h2 and buttons-->
  
      
    
    
<!--pagination MINI STYLE-->
<?php $paginate= $this->pagination->create_links(); echo $paginate; ?>


<div class="welcometext">
       <div class="pullright"><img src="images/sitewide/button_classified.png" width="127" height="36" alt="classified" /></div>
        <div> 
<h2 style = "width:300px;"> 

     <?php if(isset($sectionMeta->CategoryH1Text)): ?>
      <?php echo $sectionMeta->CategoryH1Text ?> 
    <?php elseif(isset($sectionMeta->SectionH1Text)):?>
      <?php echo $sectionMeta->SectionH1Text ?> 
    <?php endif; ?>

  <?php echo $this->pagination->total_rows; ?> available in <?php echo $PageLocation ?></h2>
        </div>
        </div> 
    </div>

  
    <!--CONTENT FOR CLASSIFIEDS - VEHICLES. REAL ESTATE. BUY AND SELL-->


    <?php if ($sectionMeta->SectionID==59) $class = "events"; else $class = "categories"; ?>
	
    <div class="<?php echo $class ?>">


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

    if($listing->SquareFeet)
        $ListingTitle .= " " . number_format($listing->SquareFeet) . " ft<sup>2</sup>/" . number_format($listing->SquareFeet / 3.28084) . " m<sup>2</sup>";
    if($listing->SquareMeters)
        $ListingTitle .= " " . number_format($listing->SquareMeters * 3.28084) . " ft<sup>2</sup>/" . number_format($listing->SquareMeters). " m<sup>2</sup>";


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
      <?php switch ($listing->RecurrenceID) {
        case '1':
          echo "Weekly on " . $listing->RecurrenceDays;
          break;        

        case '2':
          echo "Bi-Weekly on " . $listing->RecurrenceDays;
          break;

        case '3':
          echo "Monthly on the " . $listing->MonthlyRepeat . " of Each Month";
          break;
        
        // case '4':
        //   echo "Yearly on ";
        //   break;
        
        default:
          # code...
          break;
      } ?>
    <?php else: ?>  
    <?php if($listing->EventStartDate): ?>
    <?php echo date('M d', strtotime($listing->EventStartDate)) ?>
    <?php endif; ?>

    <?php if($listing->EventEndDate): ?>
    - <?php echo date('M d', strtotime($listing->EventEndDate)) ?>
    <?php endif; ?>
    <?php endif; ?>


          <br />
          <span class="smallcategorynormal">
            <?php echo str_replace('Other', $listing->LocationOther , $listing->Location); ?>
          </span>
	      </h3>
	    </div>
    <?php endif; ?>
<?php endforeach; ?>

          <div><a href="#">
		 <img src="images/sitewide/C_postfree.png" alt="Post for Free" width = "150" height = "150" />
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
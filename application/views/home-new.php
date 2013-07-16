  <script type="text/javascript" src="js/carousel.js" language="javascript"></script>
  <!--MAIN CONTENT!--><div id="main"><!--FIRST ROW TOP-->
  <div class="bannerextrapage"><img src="http://placehold.it/728x90" width="728" height="90" /></div>
	<div id="homerow1">
<div id="box_left">
    <h4> Movie schedules     <img src="images/sitewide/blubar.gif" alt="" width="170" height="5" /></h4>
    <ul id="my-movies-carousel" class="jcarousel-skin-tango-movies-carousel">
    <?php foreach($movieSchedulesObj->result() as $movieTheatre): ?>
      <li> <a href="<?php echo url_title(str_replace("&", "And",$movieTheatre->TheatreName)); ?>" ><?php echo $movieTheatre->TheatreName ?><br />
        <?php echo $movieTheatre->Location ?><br /></a>
        <a href="<?php echo url_title(str_replace("&", "And",$movieTheatre->TheatreName)); ?>" ><img class="left" src="http://www.zoomtanzania.com/ListingImages/<?php echo $movieTheatre->Flier  ?>" width="130" height="200" alt="<?php echo $movieTheatre->TheatreName; ?>" /></a>
        </li>

  <?php endforeach; ?>
    </ul>
  </div>

  <div class="container">

  <div><h4> Upcoming Special Events<img src="images/sitewide/blubar.gif" alt="" width="540" height="5" /></h4></div>
    <ul id="mycarousel" class="jcarousel-skin-tango">
    <?php foreach($specialEventsObj->result() as $specialEvent):  ?>
      
    <li>
      <a href="listingdetail?ListingID=<?php echo $specialEvent->ListingID; ?>"><img src="http://www.zoomtanzania.com/ListingImages/HomepageThumbnails/<?php echo $specialEvent->ELPTypeThumbnailImage ?>" alt="<?php echo $specialEvent->ListingTitle; ?>" width="100"  /></a><br />
      <a href = "listingdetail?ListingID=<?php echo $specialEvent->ListingID; ?>"><?php echo $specialEvent->ListingTitle ?> <strong><?php echo date('M d', strtotime($specialEvent->EventStartDate)) ?>
        <?php if($specialEvent->EventEndDate): ?>
        - <?php echo date('M d', strtotime($specialEvent->EventEndDate)) ?>
        <?php endif; ?>
      </strong></a>
    </li>
    <?php endforeach; ?>
  </ul>

  	
  
    </div>
    <div id="box_left">
    <h4>Latest Travel Special<br />
      <img src="images/sitewide/blueline.gif" alt="" width="170" height="5" /></h4>
    <ul class="imageList">
      <?php $travelSpecial = $travelSpecialObj->row(); ?>
      <li> <a href="listingdetail?ListingID=<?php echo $travelSpecial->ListingID; ?>" ><?php echo $travelSpecial->ListingTitle; ?></a>
        <a href = "listingdetail?ListingID=<?php echo $travelSpecial->ListingID; ?>">
        <img class="left" src="http://www.zoomtanzania.com/ListingUploadedDocs/<?php echo $travelSpecial->ELPTypeThumbnailImage; ?>"   alt="<?php echo $travelSpecial->ListingTitle; ?>" />
        </a></li>
    </ul>
  </div>
</div>



<!--SECONND CONTENT ROW + CLASSIFIED TABS-->
<div id="homerow2"><div id="box_left">
    <h4>Latest Featured Business<br />
      <img src="images/sitewide/blueline.gif" alt="" width="170" height="5" /></h4>
    <ul class="imageList">
      <?php $featuredListing= $featuredBusinessObj->row(); ?>
        <li><a href="<?php echo url_title($featuredListing->ListingTitle); ?>" ><?php echo $featuredListing->ListingTitle; ?></a>
        <a href="<?php echo url_title($featuredListing->ListingTitle); ?>" ><img class="left" src="http://www.zoomtanzania.com/ListingUploadedDocs/<?php echo $featuredListing->LogoImage ?>" width="141"  alt="" /><br />
         </a></li>
         <li class="box_social">
          <a href="#" >
        <img class="left" src="images/home/hp_socialnetwork_new.gif" width="180" height="144" alt="" /><br />
        <img src="images/home/facebook_ok.gif" width="35" height="36" />   <img src="images/home/twitter_ok.gif" width="35" height="36" />     <img src="images/home/youtube_ok.gif" width="35" height="36" /> </a></li>
    </ul>

</div>



<div class="classifieds_box">
  <h4 align="center">LATEST Classifieds</h4><img src="images/sitewide/blubar.gif" alt="" width="730" height="4" /><br/><div><ul>
      <?php $latestJob = $jobsObj->row(); ?>
      <li><h2><a href="#">Latest  Tanzania Job Vacancy <br /></a></h2>
      <img src="images/sitewide/blubar.gif" alt="" width="295" height="4" /></li>
      <li><a href="listingdetail?ListingID=<?php echo $latestJob->ListingID ?>"><?php echo $latestJob->ShortDescr ?></a>
        <br />
        <?php echo $latestJob->ListingTitle ?><br />
        <?php if($latestJob->Location): ?>
           <?php echo $latestJob->Location ?>
        <?php else: ?>
           <?php echo $latestJob->LocationOther ?>
        <?php endif; ?>
        <hr />
        <em>Deadline: <?php echo date("d/m/Y",strtotime($latestJob->Deadline)); ?></em> <br />
        <br />
      </li>



      <li><a href="tanzania-jobs-and-employment"><img src="images/sitewide/button_viewall.png" width="127" height="36" alt="view all" /></a><a href="#"><img src="images/sitewide/button_job.png" width="127" height="36" /></a></li>
</ul></div><div><ul>
      <?php
        $latestVehicle = $vehiclesObj->row();
       if($latestVehicle->ListingTypeID==3)
          $ListingTitle = $latestVehicle->ListingTitle;
       else
         $ListingTitle = $latestVehicle->VehicleYear . ' ' . $latestVehicle->Make . ' ' . $latestVehicle->ModelOther;
      ?>
      <li>
        <h2><a href="#">Latest Tanzania Vehicle <br />
        </a></h2>
        <img src="images/sitewide/blubar.gif" alt="" width="295" height="5" /></li>
      <li><a href="http://www.zoomtanzania.com/listingdetail?ListingID=<?php echo $latestVehicle->ListingID; ?>"><img src="<?php echo CATEGORY_THUMB_NAILS . $latestVehicle->FileNameForTN; ?>" alt="" width="120" height="85" align="baseline" /></a><a href="listingdetail?ListingID=<?php echo $latestVehicle->ListingID; ?>"><?php echo $ListingTitle   ?></a><a href="http://www.zoomtanzania.com/listingdetail?ListingID=<?php echo $latestVehicle->ListingID; ?>"></a><br />
          <?php if($latestVehicle->PriceUS): ?>
           <?php echo '$US ' . number_format($latestVehicle->PriceUS) ?>
        <?php else: ?>
           <?php echo 'TZS ' . number_format($latestVehicle->PriceTZS) ?>
        <?php endif; ?><br />
        <hr />
        <?php if($latestVehicle->Location): ?>
           <?php echo $latestVehicle->Location ?>
        <?php else: ?>
           <?php echo $latestVehicle->LocationOther ?>
        <?php endif; ?><br />
      <br />
      </li><li><a href="used-cars-trucks-and-boats"><img src="images/sitewide/button_viewall.png" width="127" height="36" alt="view all" /></a><a href="#"><img src="images/sitewide/button_vehicle.png" width="127" height="36" /></a></li>
</ul></div><div><ul>
      <?php $latestRealEstate = $realEstateObj->row(); ?>
      <li>
        <h2><a href="#">Latest Tanzania Real Estate <br />
        </a></h2><img src="images/sitewide/blubar.gif" alt="" width="295" height="5" /></li>
      <li><a href="listingdetail?ListingID=<?php echo $latestRealEstate->ListingID; ?>"><img src="<?php echo CATEGORY_THUMB_NAILS . $latestRealEstate->FileNameForTN; ?>" width="120" height="85" /></a><a href="listingdetail?ListingID=<?php echo $latestRealEstate->ListingID; ?>"><?php echo $latestRealEstate->ListingTitle; ?></a> <br />
        <?php 
        if($latestRealEstate->ListingTypeID == 6 or $latestRealEstate->ListingTypeID==7)
        {
          if(isset($latestRealEstate->RentUS))
            $price = '$US ' . number_format($latestRealEstate->RentUS);
          else
            $price = 'TZS ' . number_format($latestRealEstate->RentTZS);

          $price .= '/' . $latestRealEstate->Term;
        }
        else
        {
            if(isset($latestRealEstate->PriceUS))
              $price = '$US ' . number_format($latestRealEstate->PriceUS);
            else
              $price = 'TZS ' . number_format($latestRealEstate->PriceTZS);    

        }
        ?>
        <?php echo $price; ?>
          <br />
        <hr />
      <?php if($latestRealEstate->Location): ?>
           <?php echo $latestRealEstate->Location ?>
        <?php else: ?>
           <?php echo $latestRealEstate->LocationOther ?>
        <?php endif; ?><br />
      <br />
      </li><li><a href="tanzania-real-estate"><img src="images/sitewide/button_viewall.png" width="127" height="36" alt="view all" /></a><a href="#"><img src="images/sitewide/button_property.png" width="127" height="36" /></a></li>
</ul></div><div><ul>
    
      <?php $latestFsbo = $fsboObj->row(); ?>
      <li><h2><a href="#">Latest Tanzania Buy and Sell <br />
      </a></h2><img src="images/sitewide/blubar.gif" alt="" width="295" height="5" /></li>
      <li><a href="listingdetail?ListingID=<?php echo $latestFsbo->ListingID; ?>"><img src="<?php echo CATEGORY_THUMB_NAILS . $latestFsbo->FileNameForTN; ?>" alt="" width="120" height="85" /></a><a href="http://www.zoomtanzania.com/listingdetail?ListingID=<?php echo $latestFsbo->ListingID; ?>"><?php echo $latestFsbo->ListingTitle; ?></a><br />
        <?php if($latestFsbo->PriceUS): ?>
           <?php echo '$US ' . number_format($latestFsbo->PriceUS) ?>
        <?php else: ?>
           <?php echo 'TZS ' . number_format($latestFsbo->PriceTZS) ?>
        <?php endif; ?><br />
        <hr />
        <?php if($latestFsbo->Location): ?>
           <?php echo $latestFsbo->Location ?>
        <?php else: ?>
           <?php echo $latestFsbo->LocationOther ?>
        <?php endif; ?><br /><br />
        <br />
      </li><li><a href="steals-deals-and-classifieds"><img src="images/sitewide/button_viewall.png" width="127" height="36" alt="view all" /></a><a href="#"><img src="images/sitewide/button_classified.png" width="127" height="36" /></a></li>
</ul></div>
</div>
</div>

<div class="bannerextrapage clear"><img src="http://placehold.it/728x90" width="728" height="90" /></div>



<!-- Exchange + rates-->

<div id="homerow4">

  <?php if(isset($rates)): ?>

  <div class="exchange">
    <ul>
      <li>
        <h2>exchange rates</h2><img src="images/sitewide/blueline.gif" width="130" height="3" /><i><br />
        <img src="images/home/icon_exchangerates.png" width="26" height="16" align="texttop" /> <?php echo date("D, d M Y",strtotime(TODAY_CURRENT_DATE_IN_TZ)); ?></i>
      </li>
     <?php foreach($rates->result() as $rate): ?>
          <li> <h2> 1 <?php echo $rate->currency; ?> <br />
        Buy: <?php echo $rate->buy; ?><br />
        Sell: <?php echo $rate->sell; ?><br /></h2></li>
     <?php endforeach; ?>
    </ul>
  </div>

  <?php endif; ?>


  <?php if(isset($tidesObj)): ?>
  <?php if($tidesObj->num_rows() > 0): ?>

  <div class="exchange">
  <ul><li><h2>tide and lunar</h2>
    <img src="images/sitewide/blueline.gif" width="130" height="3" /><br />
    <i><img src="images/home/icon_tidelunar.png" width="50" height="16" align="texttop" /> <?php echo date("D, d M Y",strtotime(TODAY_CURRENT_DATE_IN_TZ)); ?></i>
  </li>

  <?php foreach($tidesObj->result() as $tide): ?>
  <li>

  <?php if($tide->High == 1): ?>
   <h2>High <?php echo date('h:i A', strtotime($tide->tideDate)); ?><br />
  <?php else: ?>
   <h2>Low <?php echo date('h:i A', strtotime($tide->tideDate)); ?><br />
  <?php endif; ?>
  <?php echo $tide->Measurement ?> m</h2><br />
  </li>

  <?php endforeach; ?>

  <?php 

  $tomorrow = new DateTime(TODAY_CURRENT_DATE_IN_TZ);
  $week = new DateTime(TODAY_CURRENT_DATE_IN_TZ);
  $tomorrow = $tomorrow->add(new DateInterval('P1D'));
  $week = $week->add(new DateInterval('P7D'));

  ?>
  <li><a href = "tides?StartDate=<?php echo $tomorrow->format("Y-m-d"); ?>&EndDate=<?php echo $tomorrow->format("Y-m-d"); ?>"> Tomorrow</a> <br /> <a href = "tides?EndDate=<?php echo $week->format("Y-m-d"); ?>">Next Seven Days</a> <br /> <a href = "tides">Full Schedule</a></li>

  </ul>
  </div>
  <?php endif; ?>
  <?php endif; ?>
</div>
  
  </div><!--MAIN FINISH-->
	<script type="text/javascript" src="js/carousel-other.js" language="javascript"></script>
  <style type = "text/css">
    select { max-width:200px;}
  </style>

  <div id="main">
  <div id="sidebar">

  <?php if(isset($searchForm) and strlen($searchForm) > 0): ?>
  <h4 align="center">Search<img src="images/sitewide/blubar.gif" alt="" width="200" height="5" /></h4>
    <?php echo $searchForm; ?>
  <?php endif; ?>


  <?php if(isset($featuredBusinessObj)):?>
    <?php if($featuredBusinessObj->num_rows() > 0):?>
    <div id="box_left">
      <h4> Latest Featured Businesses  <img src="images/sitewide/blubar.gif" alt="" width="200" height="5" /></h4>
       <ul id="my-movies-carousel" class="jcarousel-skin-tango-sidebar1">
      <?php foreach($featuredBusinessObj->result() as $featuredBusiness): ?>
        <li> <a href="<?php echo url_title($featuredBusiness->ListingTitle); ?>" ><?php echo $featuredBusiness->ListingTitle ?>
          </a><br />
          <a href="<?php echo url_title($featuredBusiness->ListingTitle); ?>" ><img class="left" src="<?php echo LISTINGUPLOADEDDOCS ?>/<?php echo $featuredBusiness->LogoImage  ?>" width = "165" alt="<?php echo $featuredBusiness->ListingTitle; ?>" /></a>
          </li>

    <?php endforeach; ?>
      </ul>
    </div>
    <?php endif; ?>
    <?php endif; ?>


  <?php if(isset($travelSpecialsObj)): ?> 
    <?php if($travelSpecialsObj->num_rows() > 0): ?> 
    <div id="box_left">
      <h4>Latest Travel Specials<br />
        <img src="images/sitewide/blueline.gif" alt="" width="180" height="5" /></h4>
      <ul id="sidebar1" class="jcarousel-skin-tango-sidebar1">
        <?php foreach($travelSpecialsObj->result() as $travelSpecial): ?>
        <li> <a href="listingdetail?ListingID=<?php echo $travelSpecial->ListingID; ?>" ><?php echo $travelSpecial->ListingTitle; ?></a><br />
         <a href="listingdetail?ListingID=<?php echo $travelSpecial->ListingID; ?>" > <img class="left" src="<?php echo LISTINGUPLOADEDDOCS ?>/<?php echo $travelSpecial->ELPTypeThumbnailImage  ?>" width="100"  alt="<?php echo $travelSpecial->ListingTitle; ?>" />
          </a></li>
        <?php endforeach; ?>
      </ul>
    </div>
    <?php endif; ?>
  <?php endif; ?>

  <?php if(isset($relatedEventsObj)): ?> 
    <?php if($relatedEventsObj->num_rows() > 0): ?> 
    <div id="box_left">
      <h4>Related Events<br />
        <img src="images/sitewide/blueline.gif" alt="" width="180" height="5" /></h4>
      <ul id="sidebar1" class="jcarousel-skin-tango-sidebar1">
        <?php foreach($relatedEventsObj->result() as $relatedEvent): ?>
        <li> <a href="listingdetail?ListingID=<?php echo $relatedEvent->ListingID; ?>" ><?php echo $relatedEvent->ListingTitle; ?></a><br />
         <a href="listingdetail?ListingID=<?php echo $relatedEvent->ListingID; ?>" > <img class="left" src="http://www.zoomtanzania.com/ListingImages/HomepageThumbnails/<?php echo $relatedEvent->ELPTypeThumbnailImage  ?>" width="100"  alt="<?php echo $relatedEvent->ListingTitle; ?>" />
          </a></li>
        <?php endforeach; ?>
      </ul>
    </div>
    <?php endif; ?>
  <?php endif; ?>



  <?php if(isset($carCategoriesObj)): ?> 
    <?php if($carCategoriesObj->num_rows() > 0): ?> 
    <br>
    <br>
    <div id="box_car">
        <h4 align="center">CHOOSE A TYPE<br />
      <img src="images/sitewide/blueline.gif" alt="" width="200" height="5" /></h4>
         <ul>
      <?php foreach($carCategoriesObj->result() as $catCategory): ?>
      <li> 
        <a href="<?php echo $catCategory->URLSafeTitleDashed ?>" ><?php echo $catCategory->Title ?></a><a href="<?php echo $catCategory->URLSafeTitleDashed ?>" ><img src="images/categories/<?php echo $catCategory->ImageFile ?>"  alt="<?php echo $catCategory->Title ?>" /></a>
      </li>
     <?php endforeach; ?>
    </ul>
  
  </div>
    <?php endif; ?>
  <?php endif; ?>

  <?php if(isset($youMayAlsoLikeObj)): ?> 
    <?php if($youMayAlsoLikeObj->num_rows() > 0): ?> 

    <div id="box_left">
      <h4><img src="images/sitewide/youmayalsolike.png" width="210" height="70" /></h4>
      <ul class="imageList">
        <li>
          <div class="zoomreccomend">
                <?php foreach($youMayAlsoLikeObj->result() as $youMayAlsoLike): ?>
             <p><?php echo $youMayAlsoLike->Descr; ?></p><br />
                <?php endforeach; ?>
          </div>
        </li>
      </ul>
    </div>
    <?php endif; ?>
  <?php endif; ?>
</div>
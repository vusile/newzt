<div id="columncontent">
<div id="container" style = "<?php echo $otherDisplay; ?>">
    <h1 align="center"><?php echo $listing->ListingTitle; ?>
    <?php if($listing->Location): ?>
     in <?php echo $listing->Location; ?>
    <?php endif; ?>
     <img src="images/sitewide/blubar.gif" alt="" width="540" height="5" /></h1>
    <div id="welcometext" align="left"> 
<p class="smallbreadcrumbs">
  <a href="">Home</a> &gt;

  <?php if($listing->ParentSection): ?>
    <a href="<?php echo url_title(str_replace("&", "And",$listing->ParentSection)); ?>"> <?php echo $listing->ParentSection; ?></a> &gt;
  <?php endif; ?>

  <?php if($listing->SubSection and $listing->ParentSectionID != 21 and $listing->ParentSectionID != 32)  : ?>
   <a href="<?php echo url_title(str_replace("&", "And",$listing->SubSection)); ?>"> <?php echo $listing->SubSection; ?></a> &gt; 
  <?php endif; ?>

  <?php if($listing->Category): ?>
   <a href="<?php echo url_title(str_replace("&", "And",$listing->Category)); ?>"><?php echo $listing->Category; ?></a> &gt; 
  <?php endif; ?>
  
  <?php if($listing->ListingTitle): ?>
    <?php echo $listing->ListingTitle; ?>
  <?php endif; ?> 
</p>
        <br />
    

        <!-- AddThis Button BEGIN -->
<div class="addthis_toolbox addthis_default_style addthis_32x32_style" style = "<?php echo $otherDisplay; ?>" >
<img src="images/categories/detailpage_shareit.jpg" align="top" class="pullleft"/>
<a class="addthis_button_email"></a>
<a class="addthis_button_print"></a>
<a class="addthis_button_facebook"></a>
<?php if($listing->CategoryID == 72): ?>
  <a class="addthis_button_delicious"></a>
<?php endif; ?>
<a class="addthis_button_twitter"></a>
<a class="addthis_button_google_plusone_share"></a>
<a class="addthis_button_stumbleupon"></a>
<a class="addthis_button_reddit"></a>
<a class="addthis_button_linkedin"></a>
<a class="addthis_button_blogger"></a>
<a class="addthis_button_compact"></a><!--<a class="addthis_counter addthis_bubble_style"></a>-->
</div>
<script type="text/javascript" src="//s7.addthis.com/js/300/addthis_widget.js#pubid=undefined"></script>
<!-- AddThis Button END -->
    </div>
</div>
    <?php $this->load->view('listing-enquiry-form'); ?>
 <!--BUSINESS DETAIL COMPLETE--><div class="listlogo" style = "<?php echo $otherDisplay; ?>"><h2>
    <br />
    <br />
    <?php if($listing->HasExpandedListing): ?>
     <a href = "<?php echo $featuredURL; ?>" <?php echo $target; ?>><?php echo $listing->ListingTitle; ?></a><br />
    <?php else: ?>
<?php echo $listing->ListingTitle; ?><br />
    <?php endif; ?>
<br />
          </h2>
          <div>
      
     <ul>
      <?php if($listing->HasExpandedListing and  $listing->ListingTypeID != 9): ?>
      <li>
      <a href = "<?php echo $featuredURL; ?>" <?php echo $target; ?>><img src="http://www.zoomtanzania.com/ListingUploadedDocs/<?php echo $listing->LogoImage  ?>"  align="left" /></a>
      </li>
      <?php endif; ?>

      <li>
        <?php if($listing->ListingTypeID == 9):?>
          <?php if($listing->PriceUS): ?>
            <h5>Minimum Price: US$ <?php echo number_format($listing->PriceUS); ?></h5>
          <?php else: ?>
            <h5>Minimum Price: TZS <?php echo number_format($listing->PriceTZ); ?></h5>
          <?php endif;?>
        <?php endif;?>
        <h5>Contacts:</h5>
          <b>
            <?php if($listing->Location): ?>
              Location:</b> <?php echo $listing->Location; ?> <br />
            <?php endif; ?>            


            <?php if($listing->PublicPhone): ?>
              <b>Tel:</b> <?php echo $listing->PublicPhone; ?><br />
            <?php endif; ?>            

            <?php if($listing->PublicPhone3): ?>
              <b>Tel:</b> <?php echo $listing->PublicPhone3; ?><br />
            <?php endif; ?>

            <?php if($listing->PublicPhone4): ?>
              <b>Tel:</b> <?php echo $listing->PublicPhone4; ?><br />
            <?php endif; ?>
            
            <?php if($listing->PublicPhone2): ?>
             <b>Fax:</b> <?php echo $listing->PublicPhone2; ?><br />
            <?php endif; ?>


            <?php if(isset($listing->FacebookPage)): ?>
             <b><a href="#">Facebook Page </a></b><br />
            <?php endif; ?>

            <?php if($listing->WebsiteURL): ?>
              <strong>Website: </strong><a target = "_blank" href="<?php echo prep_url($listing->WebsiteURL); ?>"><?php echo ($listing->WebsiteURL); ?></a><br />
            <?php endif; ?>

</li>

<?php if($listing->PublicEmail): ?>
  <li><a href = "javascript:void(0);" class = "ELLink"><img src="images/sitewide/button_send.png" width="127" height="36" /></a></li>  
<?php endif; ?>

</ul></div>
<?php if($listing->HasExpandedListing and $listing->ListingTypeID != 9): ?>
 
<div align="center">
<img src="http://placehold.it/120x120" width="120" height="120" />
<img src="http://placehold.it/120x120" width="120" height="120" />
<img src="http://placehold.it/120x120" width="120" height="120" />
<img src="http://placehold.it/120x120" width="120" height="120" />

</div>
 
<?php endif; ?>
<div align="left">
  <?php if($listing->HasExpandedListing): ?>

<a href = "<?php echo $featuredURL; ?>" <?php echo $target; ?>><img src="images/sitewide/icon_lens.png" alt="" width="20" height="19" />zoom our flyer</a><br />
       <br />
       <a href = "<?php echo $featuredURL; ?>" <?php echo $target; ?>><img src="http://www.zoomtanzania.com/ListingUploadedDocs/<?php echo $listing->ELPTypeThumbnailImage  ?>" alt="<?php echo $listing->ListingTitle; ?> type" title = "<?php echo $listing->ListingTitle; ?> type" /></a>
<?php endif; ?>
          <h5>          About <?php echo $listing->ListingTitle; ?>: </h5>
          <?php echo strip_tags($listing->ShortDescr,'<p><br>'); ?>
        
        <?php if($listing->LocationText): ?>
          <br><Br><h5>Location/Directions:</h5><br />
          <?php echo strip_tags($listing->LocationText,'<p><br>'); ?><br />
        <?php endif; ?>
        
        <br />
<h6 class="pullright"><a href="#"><img src="images/sitewide/button_report.gif" width="21" height="18" /> report abuse or incorrect content</a></h6></div>
           
  </div>

        <!-- AddThis Button START -->
        <div class="addthis_toolbox addthis_default_style addthis_16x16_style" align="left" style = "<?php echo $otherDisplay; ?>">
<a class="addthis_button_email"></a>
<a class="addthis_button_print"></a>
<a class="addthis_button_facebook"></a>
<a class="addthis_button_twitter"></a>
<a class="addthis_button_compact"></a><!--<a class="addthis_counter addthis_bubble_style"></a>-->
</div>
<script type="text/javascript" src="//s7.addthis.com/js/300/addthis_widget.js#pubid=undefined"></script>
<!-- AddThis Button END -->
<div style = "margin-top:10px"></div>

</div>
</div>
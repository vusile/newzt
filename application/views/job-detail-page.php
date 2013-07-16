


<div id="columncontent">
  <div id="container">
    <h1 align="center"><?php echo $listing->ShortDescr; ?><br><img src="images/sitewide/blubar.gif" alt="" width="540" height="5" /></h1>
    <div id="welcometext" align="left" > 
<p class="smallbreadcrumbs">
  <a href="">Home</a> &gt;

  <?php if($listing->ParentSection): ?>
    <a href="<?php echo url_title(str_replace("&", "And",$listing->ParentSection)); ?>"> <?php echo $listing->ParentSection; ?></a> &gt;
  <?php endif; ?>

  <?php if($listing->SubSection and $listing->ParentSectionID != 21 and $listing->ParentSectionID != 32 and $listing->ParentSectionID != 8)  : ?>
   <a href="<?php echo url_title(str_replace("&", "And",$listing->SubSection)); ?>"> <?php echo $listing->SubSection; ?></a> &gt; 
  <?php endif; ?>

  <?php if($listing->Category): ?>
   <a href="<?php echo url_title(str_replace("&", "And",$listing->Category)); ?>"><?php echo $listing->Category; ?></a> &gt; 
  <?php endif; ?>
  
  <?php if($listing->ShortDescr): ?>
    <?php echo $listing->ShortDescr; ?>
  <?php endif; ?> 
</p>


      <p>
        <br />
       
    </p>
    </div>
<!-- AddThis Button BEGIN -->
<div class="addthis_toolbox addthis_default_style addthis_32x32_style" style = "<?php echo $otherDisplay; ?>">
<img src="images/categories/detailpage_shareit.jpg" class="pullleft"/>
<a class="addthis_button_email"></a>
<a class="addthis_button_print"></a>
<a class="addthis_button_facebook"></a>
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
 <!--BUSINESS DETAIL COMPLETE-->

 <?php $this->load->view('listing-enquiry-form'); ?>

 <div class="list" style = "<?php echo $otherDisplay; ?>">
          
      
     <div><ul><li><b>Job Category:</b> <?php echo $listing->Category; ?><br />
<!--<b>position type:</b> NOT YET FUNCTIONAL <b><br />
organization type: </b>NOT YET FUNCTIONAL <b><br />-->
Location:</b> 
            <?php echo str_replace('Other', "", $listing->Location); ?>

            <?php if($listing->LocationOther): ?>
              <?php echo $listing->LocationOther ?>
            <?php endif; ?>

          <br />
           <br /> 
          <h5> Company:
           </h5><?php echo $listing->ListingTitle; ?><br />

     </li>
       <li><span id="EmailLister"><strong>Phone: </strong><?php if($listing->PublicPhone) echo $listing->PublicPhone; else "No Calls Please"; ?><br />
           <!-- <strong>Location:</strong> Dar Es Salaam<br /> -->
           <strong>Application Deadline: </strong><?php echo date('d-m-Y',strtotime($listing->Deadline)); ?></span> <br />
            <?php if($listing->WebsiteURL): ?>
            <strong>Website: </strong><a target = "_blank" href="<?php echo prep_url($listing->WebsiteURL); ?>"><?php echo ($listing->WebsiteURL); ?></a><br />
            <?php endif; ?>

</li><li></li>  
</ul></div>

        <div  align="left"><br />
        <h5>POSITION DESCRIPTION:</h5><br />
        <?php if($listing->UploadedDoc): ?>
         <a href="ListingUploadedDocs/<?php echo $listing->UploadedDoc;?>">Position Description Document (download)</a>
       <?php else: ?>
         <?php echo strip_tags($listing->LongDescr,'<p><br>'); ?>
       <?php endif; ?>
          <br />
            <br />
            <h5>APPLICATION INSTRUCTIONS:</h5><br />
            <?php echo strip_tags($listing->Instructions,'<p><br>'); ?>

         
         
          
</div>

<div><h5>if you are qualified for this position<br />
<?php if($listing->PublicEmail): ?>
<?php if($this->ion_auth->logged_in()):?>
  <a href = "javascript:void(0);" class = "ELLink"><img src="images/sitewide/button_apply.png" width="127" height="36" /></a>
<?php else: ?>
  <a href = "myaccount/login" ><img src="images/sitewide/button_apply.png" width="127" height="36" /></a>
<?php endif; ?>
<?php endif; ?>
   <h6 class="pullright padit"><a href="#"> report abuse or incorrect content<img src="images/sitewide/button_report.gif" width="21" height="18" /></a></h6></div>
 </div> 

       
<div class="addthis_toolbox addthis_default_style addthis_16x16_style padit">
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
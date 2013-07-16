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
  <!--title-->
    <h1 align="center">
    <?php if(isset($sectionMeta->CategoryH1Text)): ?>
      <?php echo $sectionMeta->CategoryH1Text ?> 
    <?php elseif(isset($sectionMeta->SectionH1Text)):?>
      <?php echo $sectionMeta->SectionH1Text ?> 
    <?php endif; ?>

      in <?php echo $PageLocation ?><img src="images/sitewide/blubar.gif" alt="" width="540" height="5" /></h1>
    <div class="welcometext" align="left">
    
     <!--breadcrumbs TO SET-->
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
      
   <div class="fb-like" data-href="http://www.facebook.com/pages/ZoomTanzaniacom/196820157025531" data-send="true" data-width="572" data-show-faces="true"></div>
				</div>
    <!--choose a location-->

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
  
  
 </div>
  
    
<!--container close / open pagination / title h2 and buttons-->
  

    
    
<!--pagination MINI STYLE-->
<?php $paginate= $this->pagination->create_links(); echo $paginate; ?>

<div class="welcometext">
       <div class="pullright" ><img src="images/sitewide/button_job.png" width="127" height="36" alt="classified" /></div>
     <div> 
<h2 style = "width:300px;"><?php echo $this->pagination->total_rows;  ?> Job vacancies in <?php echo $PageLocation; ?> </h2></div>
        
       </div> 
    
        
         
         
        
       


<!-- CONTENT-->
        <div class="list">
      
     <div><ul>

       <?php $i = 0; ?>
       <?php foreach($listings->result() as $listing): ?>
       <?php $i++; ?>
       <li >
        <a href = "listingdetail?ListingID=<?php echo $listing->ListingID; ?>" title = "<?php echo $listing->ShortDescr; ?>"><?php echo $listing->ShortDescr; ?></a><br />

        <span class="smallcategorynormal">
        <?php echo trim(str_replace("Other", $listing->LocationOther, $listing->Location)); ?>
          </span>
        
      <br>Deadline: <?php echo date('d-m-Y',strtotime($listing->Deadline)); ?>
      <?php if($i==2): ?>
      <?php $i=0; ?>
      <div style = "clear: both; border: none; padding:0; margin:0;"></div>
      <?php endif; ?>
      </li>   <?php endforeach;?>

    </ul>
     
  
		</div></div>
      
    <!--Welcome text and pagination MINI STYLE-->  
       <div class="welcometext">
    
   
          <?php if(isset($pageTextObj) and $pageTextObj->num_rows() > 0): ?>
          <?php echo $pageTextObj->row()->Descr; ?><br>
        <?php endif; ?> 
          
<?php echo $paginate; ?>
</div>


</div>
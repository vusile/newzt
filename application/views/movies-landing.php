<div id="leftwidecontent">
  <div id="container">
    <h1 align="center"> <?php echo  $listing->ListingTitle; ?> in <?php echo $listing->Location; ?><br />
      <img src="images/sitewide/blubar.gif" alt="" width="800" height="5" /></h1>
    <div id="welcometext" align="left"> 
      <p class="smallbreadcrumbs"><a href="#">Home</a> &gt;<a href="#"> Dining &amp; Entertainment</a> &gt; <a href="#">Movie Theatres</a> &gt; Century Cinemax Dar Es Salaam</p><p>
        <br />
       
    </p>
    </div>
<div class="addthis_toolbox addthis_default_style addthis_32x32_style" align="right">
 <img src="images/categories/detailpage_shareit.jpg" class="pullleft"/> <!-- AddThis Button BEGIN -->
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
</div>
 
 
 
 <!--here the text container for wide text and images-->
 
 <div class="widecontainer"> <br />

    <br /><h3>
   
     <!-- <a href="http://www.zoomtanzania.com/zoomedlisting?ListingID=51789" onclick="clickThroughExpanded(51789)"> -->
     	<?php echo  $listing->ListingTitle; ?> - <a href = "<?php echo current_url(); ?>#PriceInfo">See Price Information</a><br />
     <!-- </a> -->
     <img src="<?php echo LISTINGUPLOADEDDOCS . $listing->LogoImage; ?>" alt="" width="150"  align="left" /><br />
<br />
          </h3>
		  <!--here the box for images of movie playing now-->
		  <div class="cinema"> <div class="label"><h2>PLAYING NOW </h2></div>

			

				<?php foreach($movies->result() as $movie): ?>
					<?php if($movie->NowPlayingID==1): ?>
			  		<a href="<?php echo current_url(); ?>#movie<?php echo $movie->ListingMovieID ?>"><img src="<?php echo LISTINGIMAGES . $movie->MovieImage ?>" width="108" height="170" /></a>
			  		<?php endif; ?>
				<?php endforeach; ?>

			  
		  </div>
		 
   


				<!--start movie detail box-->	
				<?php foreach($movies->result() as $movie): ?>
				<?php if($movie->NowPlayingID==1): ?>
				<div class="cinema" align="left"><a name="movie<?php echo $movie->ListingMovieID ?>" id="movie<?php echo $movie->ListingMovieID ?>"></a>
				<div><a rel="lightbox[galleria]" href="<?php echo LISTINGIMAGES . $movie->MovieImage ?>" title="<?php echo $movie->MovieTitle ?>" border="0"><img src="images/sitewide/icon_lens.png" alt="" width="20" height="19" />zoom this flyer</a><br />
				       <br />
				       <a rel="lightbox[galleria]" href="<?php echo LISTINGIMAGES . $movie->MovieImage ?>" title="<?php echo $movie->MovieTitle ?>" border="0"><img src="<?php echo LISTINGIMAGES . $movie->MovieImage ?>" alt="<?php echo $movie->MovieTitle ?>" width="158" height="250" /></a></div><div>
		          <h3><?php echo $movie->MovieTitle ?></h3>
		          <p><strong>Directed by:</strong> <?php echo $movie->DirectedBy ?><br />
	              <strong>Starring:</strong> <?php echo $movie->Starring ?></p>
				        
				        <br><h2>Synopsis</h2 >
				        	<p>
							<?php echo $movie->Descr ?>	</p>
				       
				        <p><strong>Reviews and more about <?php echo $movie->MovieTitle ?></strong><br />

						<?php if($movie->OfficialURL): ?>
							<a href="<?php echo $movie->OfficialURL; ?>" target="_blank">Official Site</a> |  
				      	<?php endif; ?>
				      	<?php if($movie->YahooURL): ?>
				      		<a href="<?php echo $movie->YahooURL; ?>" target="_blank">Yahoo Movie Review</a> |
				        <?php endif; ?>
				        <?php if($movie->IMDBURL): ?><a href="<?php echo $movie->IMDBURL; ?>" target="_blank">IMDb Review</a>
				        <?php endif; ?> 
						</p>

				          <br /><br />
		                 <p> <strong>
		            SHOWTIMES<br />
		            <?php if($movie->DailyShowTimes): ?>
		            	Daily:</strong> <br />
	              		<?php echo $movie->DailyShowTimes; ?>	</p>
					<?php endif; ?>

					<?php if($movie->OtherShowTimes and ($movie->Saturdays or $movie->Sundays or $movie->Holidays)): ?>
	              <?php 

	              		$OtherShowTimesString = '';

	              		if($movie->Saturdays)
	              		{
	              			$OtherShowTimesString .= 'Saturdays';
	              			if($movie->Sundays or $movie->Holidays)
	              				$OtherShowTimesString .= ',';
	              		}
	              		if($movie->Sundays)
	              		{
	              			if($movie->Saturdays and !$movie->Holidays)
	              				$OtherShowTimesString .= " and";
	              		//	else $OtherShowTimesString .= ',';

	              			$OtherShowTimesString .= " Sundays";
	              		}

	              		if($movie->Holidays)
	              		{
	              			if($movie->Saturdays or $movie->Sundays)
	              				$OtherShowTimesString .= ' and';
	              			$OtherShowTimesString .= " Public Holidays";
	              		}

	              ?>
				        <p><strong><?php echo $OtherShowTimesString ?>: </strong><br />

				          <?php echo $movie->OtherShowTimes; ?>	</p>
				        <p>         
					<?php endif; ?>

							<!-- AddThis Button START --><div class="addthis_toolbox addthis_default_style addthis_16x16_style" align="left">
							<a class="addthis_button_email"></a>
							<a class="addthis_button_print"></a>
							<a class="addthis_button_facebook"></a>
							<a class="addthis_button_twitter"></a>
							<a class="addthis_button_compact"></a><!--<a class="addthis_counter addthis_bubble_style"></a>-->
							</div>
							<script type="text/javascript" src="//s7.addthis.com/js/300/addthis_widget.js#pubid=undefined"></script>
							<!-- AddThis Button END --></div>
				        </div>
    		  		<?php endif; ?>
			<?php endforeach; ?>
						<!--END movie detail module-->	

        
	
				
<!--COMING SOON BOX-->
<div class="cinema"> <div class="label"><h2>COMING SOON</h2></div>

			<?php foreach($movies->result() as $movie): ?>
				<?php if($movie->NowPlayingID==2): ?>
		  		<a href="<?php echo current_url(); ?>#movie<?php echo $movie->ListingMovieID ?>"><img src="<?php echo LISTINGIMAGES . $movie->MovieImage ?>" width="108" height="170" /></a>
		  		<?php endif; ?>
			<?php endforeach; ?>

</div>  
	
				<!--start movie detail module-->	
						<?php foreach($movies->result() as $movie): ?>
				<?php if($movie->NowPlayingID==2): ?>
				<div class="cinema" align="left"><a name="movie<?php echo $movie->ListingMovieID ?>" id="movie<?php echo $movie->ListingMovieID ?>"></a>
				<div><a rel="lightbox[galleria]" href="<?php echo LISTINGIMAGES . $movie->MovieImage ?>" title="<?php echo $movie->MovieTitle ?>" border="0"><img src="images/sitewide/icon_lens.png" alt="" width="20" height="19" />zoom this flyer</a><br />
				       <br />
				       <a rel="lightbox[galleria]" href="<?php echo LISTINGIMAGES . $movie->MovieImage ?>" title="<?php echo $movie->MovieTitle ?>" border="0"><img src="<?php echo LISTINGIMAGES . $movie->MovieImage ?>" alt="<?php echo $movie->MovieTitle ?>" width="158" height="250" /></a></div><div>
		          <h3><?php echo $movie->MovieTitle ?></h3>
		          <p><strong>Directed by:</strong> <?php echo $movie->DirectedBy ?><br />
	              <strong>Starring:</strong> <?php echo $movie->Starring ?></p>
				        
				        <br><h2>Synopsis</h2 >
				        	<p>
							<?php echo $movie->Descr ?>	</p>
				       
				        <p><strong>Reviews and more about <?php echo $movie->MovieTitle ?></strong><br />

						<?php if($movie->OfficialURL): ?>
							<a href="<?php echo $movie->OfficialURL; ?>" target="_blank">Official Site</a> |  
				      	<?php endif; ?>
				      	<?php if($movie->YahooURL): ?>
				      		<a href="<?php echo $movie->YahooURL; ?>" target="_blank">Yahoo Movie Review</a> |
				        <?php endif; ?>
				        <?php if($movie->IMDBURL): ?><a href="<?php echo $movie->IMDBURL; ?>" target="_blank">IMDb Review</a>
				        <?php endif; ?> 
						</p>

				          <br /><br />
		            
          
							<!-- AddThis Button START --><div class="addthis_toolbox addthis_default_style addthis_16x16_style" align="left">
							<a class="addthis_button_email"></a>
							<a class="addthis_button_print"></a>
							<a class="addthis_button_facebook"></a>
							<a class="addthis_button_twitter"></a>
							<a class="addthis_button_compact"></a><!--<a class="addthis_counter addthis_bubble_style"></a>-->
							</div>
							<script type="text/javascript" src="//s7.addthis.com/js/300/addthis_widget.js#pubid=undefined"></script>
							<!-- AddThis Button END --></div>
				        </div>
    		  		<?php endif; ?>
			<?php endforeach; ?>
	
				<!--start movie detail module-->	
				
	
						<!--hereby the business description for the cinema-->

		  <div class="cinema" id = "PriceInfo">
      
     <ul>
		 <li><img src="<?php echo LISTINGUPLOADEDDOCS . $listing->LogoImage; ?>" alt="" width="150"  align="left" />
			<p><b>About <?php echo $listing->ListingTitle; ?>: </strong></b><br />
			 		     </p>
			 		   <p><?php echo $listing->ShortDescr; ?></p>
			 		   <br />
			 		   <br /></li>
		 <li>
        <h2><?php echo $listing->LocationText ?></h2>
        <br />
            <h5>Contacts:</h5>

            <?php if($listing->PublicPhone): ?>
            	<b>Tel:</b><?php echo $listing->PublicPhone; ?><br />
        	<?php endif; ?>
           	<?php if($listing->PublicPhone3): ?>
            	<b>Tel:</b><?php echo $listing->PublicPhone3; ?><br />
        	<?php endif; ?>
           	<?php if($listing->PublicPhone4): ?>
            	<b>Tel:</b><?php echo $listing->PublicPhone4; ?><br />
        	<?php endif; ?>
            <?php if($listing->PublicPhone2): ?>
            	<b>Fax:</b><?php echo $listing->PublicPhone2; ?><br />
        	<?php endif; ?>
        	<?php if(isset($listing->FacebookURL)): ?>
            	<b><a href="<?php echo $listing->Facebook; ?>">Facebook Page </a></b><br />
        	<?php endif; ?>
         	<?php if($listing->WebsiteURL): ?>
            	<b><a href="<?php echo prep_url($listing->WebsiteURL); ?>"><?php echo $listing->WebsiteURL; ?></a></b><br />
        	<?php endif; ?> 
            <?php if($listing->PublicEmail): ?>
  				<img src="images/sitewide/button_send.png" width="127" height="36" /> 
			<?php endif; ?>            

            <!-- <img src="images/sitewide/button_post.png" width="127" height="36" /> -->

</li> 
		 <li>
  <h5>PRICES AND FEES:</h5>
  <?php echo $listing->MovieFees; ?>
 </li> 
</ul></div>
  </div>
  <div align="right">
        <h6><a href="#"><img src="images/sitewide/button_report.gif" width="21" height="18" /> report abuse or incorrect content</a></h6></div></div>

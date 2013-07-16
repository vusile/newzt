<div id="columncontent">
  <div id="container">


    <h1 align="center">My Account<br /><img src="images/sitewide/blubar.gif" alt="" width="540" height="5" /></h1>
    <div class="welcometext" align="left"> 
	


				</div>
				<div class="list">

  </div>
<?php 
$ListingStatuses = array('Active','Pending Review');
if($accountListingsObj->num_rows() > 0):
?>
	<table border='1'>
	<tr><td>Listing Title</td><td>Site Location</td><td>Status</td><td>Expires On</td><td>Payment History</td><td>Renew</td></tr>
	
	<?php
		foreach($accountListingsObj->result() as $Listing):
	?>
	
		<tr>
		<td> 
			<?php echo $Listing->ListingTitle ?> 
			<?php if($this->ion_auth->user()->row()->UserID == PHONE_ONLY_USER): ?>
				<br> (Phone Only Listing)
			<?php endif; ?>

		</td>
		<td><?php if($Listing->ParentSection) echo $Listing->ParentSection . " > "; ?><?php if($Listing->Section) echo $Listing->Section . " > "; ?><?php if($Listing->Category) echo $Listing->Category; ?></td>
		<td>
			<?php 
				if($Listing->Reviewed and in_array($Listing->PaymentStatusID, array(2,3))) 
					echo "Live"; 
				elseif($Listing->Reviewed) 
					echo "Approved"; 
				else
					echo "Pending Review";
			?>
		</td>
		<td> 
			<?php
				if($Listing->PaymentStatusID == 1) 
					echo $Listing->TermExpiration . " days after payment received";
				else echo date('d/m/Y',strtotime($Listing->ExpirationDate));
			?> 
		</td>
		<td>
		<?php
			foreach($listingOrders->result() as $order)
			{
				if($order->ListingID == $Listing->ListingID)
				{
					switch($order->OrderType)
					{
						case "Listing":
							echo "$" . number_format($order->TotalListingFee);

							if($order->TotalListingFee) echo " + VAT Listing";
							if(strlen($order->ExpandedListingFee) and $order->ExpandedListingFee) echo " with Featured Listing";
						break;


					}
				}
			}
		?>
		</td>
		<td><input type='checkbox' id='ListingID<?php echo $Listing->ListingID ?>' class='ListingID' name='ListingIDs' value="<?php echo $Listing->ListingID ?>"></td>
		</tr>
	<?php endforeach; ?>
	</table>
<?php
else: 
	echo "No listings";
endif;

?>
</div>
</div>
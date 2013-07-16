<!DOCTYPE html>
<html lang="en">
<head>
<base href = "<?php echo base_url(); ?>" />
<link href="assets/grocery_crud/themes/flexigrid/css/flexigrid.css" rel="stylesheet" type="text/css" />
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<style type="text/css">
	table {font-size: 14px; }	
	td{padding: 10px 0;}
	.flexigrid {overflow:visible }
</style>
<META NAME="country" CONTENT="Tanzania">
</head>
<body>
	<h1>Review Messages for Spam</h1>

	<?php if($this->input->get('message')) echo $this->input->get('message'); ?>
	<?php $yesNo = array("No","Yes"); ?>

	<?php echo validation_errors(); ?>
	<div class = "flexigrid">
	<form method="post" action = "backend/reviewmessages">
		<div align="right">
			<!-- <input  type = "submit" value = "Save Changes" /> -->
		</div>
		<table>
			<thead>
				<tr class = "hDiv">
					<th >ID</th>
					<th >Listing</th>
					<th >From Address</th>
					<th >To Address</th>
					<th >Subject</th>
					<th >Message</th>
					<th >Date Added</th>
					<th >Is Spam</th>
					<!-- <th >Reviewed</th> -->
					<th >Email Sent</th>
					<th ></th>
					<th ></th>
					<!-- <th ></th> -->
				</tr>
			</thead>
			<tbody>
				<?php $i=1; ?>
				<?php foreach($data->result() as $message): ?>
					
					<?php if($i%2 > 0): ?>
						<tr>
					<?php else: ?>
						<tr class = "erow">
					<?php endif; ?>
					
						<td><?php echo $message->MessageID ?></td>
						<td><?php echo $message->ListingID ?></td>
						<td><?php echo $message->FromAddress ?></td>
						<td><?php echo $message->ToAddress ?></td>
						<td><?php echo $message->Subject ?></td>
						<td><?php echo $message->Message ?></td>
						<td><?php echo $message->DateAdded ?></td>
						<td><?php echo $yesNo[$message->IsSpam] ?></td>
						<!-- <td><input type = "checkbox" name = "MessagesIDs[]" id = "MessagesIDs<?php echo $message->MessageID ?>" value = "<?php echo $message->MessageID; ?>" /></td> -->
						<td><?php echo $yesNo[$message->IsSent] ?></td>
						<td><a href="backend/edit_message/<?php echo $message->MessageID; ?>">Edit</a></td>
						<td><a href="backend/confirm_delete_message/<?php echo $message->MessageID; ?>">Delete</a></td>
						<!-- <td><a href="backend/send_message/<?php echo $message->MessageID; ?>">Send Message</a></td> -->
						
					
					</tr>
					
					<?php $i++; ?>
				<?php endforeach; ?>
			</tbody>
		</table>
	</form>
	</div>
</body>
</html>
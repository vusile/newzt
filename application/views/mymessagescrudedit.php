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
	
	<form method="post" action = "backend/update_message">
		<div>
			<a href="backend/messages/1">View All</a> - <a href="backend/delete_message/<?php echo $message->MessageID ?>">Delete Message</a> - <a href="backend/send_message/<?php echo $message->MessageID ?>">Send Message</a>
		</div>
		<table>
			<thead>
				<tr>
					<td >ID</td>
					<td><?php echo $message->MessageID ?></td>
				</tr>
				<tr>
					<td >Listing</td>
					<td><?php echo $message->ListingID ?></td>
				</tr>
				<tr>
					<td >From Address</td>
					<td><?php echo $message->FromAddress ?></td>
				</tr>
				<tr>
					<td >To Address</td>
					<td><?php echo $message->ToAddress ?></td>
				</tr>
				<tr>
					<td >Subject</td>
					<td><?php echo $message->Subject ?></td>
				</tr>
				<tr>
					<td >Message</td>
					<td><?php echo $message->Message ?></td>

				</tr>				
				<tr>
					<td >Attachments</td>
					<td><?php echo $message->Attachments ?></td>

				</tr>
				<tr>
					<td >Date Added</td>
					<td><?php echo $message->DateAdded ?></td>
				</tr>
				<tr>
					<td >Is Spam</td>
					<td><input type = "checkbox" name = "IsSpam" id = "IsSpam" value = "1" <?php if($message->IsSpam) echo "checked" ?> /></td> 
				</tr>
				<tr>
					<td >Defensio Pass</td>
					<td><?php echo $yesNo[$message->DefensioPass] ?></td>
				</tr>				
				<tr>
					<td >Defensio "Spaminess"</td>
					<td><?php echo $message->DefensioSpaminess ?></td>
				</tr>
				<tr>
					<td >Email Sent</td>
					<td><?php echo $yesNo[$message->IsSent] ?></td>
				</tr>
					<th ></th>
					<!-- <th ></th> -->
				</tr>
			</tbody>
			
		</table>
		<input type = "hidden" name = "signature" value = "<?php echo $message->DefensioSignature ?>">
		<input type = "hidden" name = "messageID" value = "<?php echo $message->MessageID ?>">
		<input type = "submit" value = "Submit">
	</form>
	
</body>
</html>
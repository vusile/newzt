<html>
<body>
	<h1>Activate account for <?php echo $identity;?></h1>
	<p>Please click this link to <?php echo anchor('myaccount/activate/'. $UserID .'/'. $activation, 'Activate Your Account');?>.</p>
</body>
</html>
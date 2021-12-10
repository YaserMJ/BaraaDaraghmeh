<?php include('server.php') ?>
<!DOCTYPE html>
<html>
<head>
  <title>Post charity case</title>
  <link rel="stylesheet" type="text/css" href="style.css">
</head>
<body>
  <div class="header">
  	<h2>Post charity case</h2>
  </div>
	
  <form method="post" action="charitypost.php">
  	<?php include('errors.php'); ?>
  	<div class="input-group">
	<!-- logged in user information -->
  	  <label>Case name</label>
  	  <input type="text" name="casename">
  	</div>
  	<div class="input-group">
  	  <label>Case location</label>
  	  <input type="text" name="caselocation">
  	</div>
      <div class="input-group">
  	  <label>Case description</label>
  	  <textarea type="text" name="casedescription"></textarea>
  	</div>
  	<div class="input-group">
  	  <label>Mobile number</label>
  	  <input type="number" name="casemobile">
  	</div>   
  	<div class="input-group">
  	  <button type="submit" class="btn" name="submitcase">Submit case</button>
  	</div>
  </form>
</body>
</html>
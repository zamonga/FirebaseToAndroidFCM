<!DOCTYPE html>
<html lang="en">
	<head>
		<title>Firebase Push Notification</title>
		<meta charset="utf-8">
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
		<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
		<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
	</head>
	<body>
 
		<div class="container">
			<div class="row">
				<div class="col-lg-6">
					<h2>Send Firebase Push Notification | AndroidDeft.Com</h2>
					<hr />
					<form action="" method="post">
						<div class="form-group">
							<label for="send_to">Send To:</label>
							<select name="send_to" id="send_to" class="form-control">
								<option value="sngle">Single Device</option>
								<option value="topic">Topic</option>
							</select>
						</div>
 
						<div class="form-group">
							<label for="firebase_api">Firebase Server API Key:</label>
							<input type="text"  class="form-control" id="firebase_api" placeholder="Enter Firebase Server API Key" name="firebase_api">
						</div>


						
						<div class="form-group" id="firebase_token_group">
							<label for="firebase_token">Firebase Token:</label>
							<input type="text"  class="form-control" id="firebase_token" placeholder="Enter Firebase Token" name="firebase_token">
						</div>
						<div class="form-group" style="display: none" id="topic_group">
							<label for="topic">Topic Name:</label>
							<input type="text" class="form-control" id="topic" placeholder="Enter Topic Name" name="topic">
						</div>



						<div class="form-group">
							<label for="title">Title:</label>
							<input type="text"  class="form-control" id="title" placeholder="Enter Notification Title" name="title">
						</div>
						<div class="form-group">
							<label for="message">Image URL:</label>
							<input type="url"  class="form-control" rows="5" id="imageUrl" placeholder="Enter Notification Image Url" name="imageUrl">
						</div>
					
 						<div class="form-group">
							<label for="message">Original URL:</label>
							<input type="url"  class="form-control" rows="5" id="originalURL" placeholder="Enter Notification Image Url" name="originalURL">
						</div>

						<div class="form-group">
							<label for="message">Post Id:</label>
							<input type="text"   class="form-control" rows="5" id="postID" placeholder="Enter Notification Image Url" name="postID">
						</div>

						<div class="form-group">
							<label for="message">Click Action:</label>
							<input type="text"  class="form-control" rows="5" id="click_action" placeholder="Enter Notification Image Url" name="click_action">
						</div>

						<button type="submit" class="btn btn-info">Submit</button>
					</form>
				
				</div>
				<div class="col-lg-6">
					<?php
					if(isset($_POST['title'])){
		
						
						// exit;
						require_once __DIR__ . '/Model.php';
						$notification = new Notification();
	
						$title = $_POST['title'];
						$imageUrl = isset($_POST['imageUrl']) ? $_POST['imageUrl'] : '' ;

						
						$originalURL = isset($_POST['originalURL'])?$_POST['originalURL']:'';
						$postID = isset($_POST['postID'])?$_POST['postID']:'';
						$actionDestination = isset($_POST['click_action'])?$_POST['click_action']:'';

						
						$newImage = urldecode($imageUrl);

						$notification->setTitle($title);
						$notification->setImage($newImage);
						$notification->setOriginal_url(urldecode($originalURL));
						$notification->setPost_id($postID);
						$notification->setClick_action($actionDestination);
						
						$firebase_token = $_POST['firebase_token'];
						$firebase_api = $_POST['firebase_api'];
						
						$topic = $_POST['topic'];
						
						$requestData = $notification->getNotificatin();
						
						if($_POST['send_to']=='topic'){

							$fields = array(
								'to' => '/topics/'.$topic,
								'data' => $requestData,
							);
							
						}else{
							
							$fields = array(
								'to' => $firebase_token,
								'data' => $requestData,
							);
						}
		
		
						// Set POST variables
						$url = 'https://fcm.googleapis.com/fcm/send';
 
						$headers = array(
							'Authorization: key='.$firebase_api,
							'Content-Type: application/json'
						);
						
						// Open connection
						$ch = curl_init();
 
						// Set the url, number of POST vars, POST data
						curl_setopt($ch, CURLOPT_URL, $url);
 
						curl_setopt($ch, CURLOPT_POST, true);
						curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
						curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
 
						// Disabling SSL Certificate support temporarily
						curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, true);
 

						curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($fields));
 
						// Execute post
						$result = curl_exec($ch);
						if($result === FALSE){
							die('Curl failed: ' . curl_error($ch));
						}
 
						// Close connection
						curl_close($ch);
						
						echo '<h2>Result</h2><hr/><h3>Request </h3><p><pre>';
						echo json_encode($fields,JSON_PRETTY_PRINT);
						echo '</pre></p><h3>Response </h3><p><pre>';
						echo $result;
						echo '</pre></p>';
					}
					?>
	
				</div>
			</div>
		</div>
		
		<script>
			$('#send_to').change(function(e){
					var selectedVal = $("#send_to option:selected").val();
					if(selectedVal=='topic'){
						$('#topic_group').show();
						$("#topic").prop('required',true);
						$('#firebase_token_group').hide();
						$("#firebase_token").prop('required',false);
					}else{
						$('#topic_group').hide();
						$("#topic").prop('required',false);
						$('#firebase_token_group').show();
						$("#firebase_token").prop('required',true);
					}
				});
		</script>
	</body>
</html>
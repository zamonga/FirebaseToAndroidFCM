<!DOCTYPE html>
<html lang="en">

<head>
    <!-- Required meta tags-->
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="Colorlib Templates">
    <meta name="author" content="Colorlib">
    <meta name="keywords" content="Colorlib Templates">

    <!-- Title Page-->
    <title>Firebase Notification For Science News</title>

    <!-- Icons font CSS-->
    <link href="vendor/mdi-font/css/material-design-iconic-font.min.css" rel="stylesheet" media="all">
    <link href="vendor/font-awesome-4.7/css/font-awesome.min.css" rel="stylesheet" media="all">
    <!-- Font special for pages-->
    <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,300i,400,400i,600,600i,700,700i,800,800i"
          rel="stylesheet">

    <!-- Vendor CSS-->
    <link href="vendor/select2/select2.min.css" rel="stylesheet" media="all">
    <link href="vendor/datepicker/daterangepicker.css" rel="stylesheet" media="all">

    <!-- Main CSS-->
    <link href="css/main.css" rel="stylesheet" media="all">
</head>

<body>
<div class="page-wrapper bg-gra-03 p-t-45 p-b-50">
    <div class="wrapper wrapper--w790">
        <div class="card card-5">
            <div class="card-heading">
                <h2 class="title">Firebase Notification For Science News</h2>
            </div>
            <div class="card-body">
                <form method="POST">

                    <div class="form-row">
                        <div class="name">Topic:</div>
                        <div class="value">
                            <div class="input-group">
                                <input class="input--style-5" type="text" id="topic" required="Required" name="topic"
                                       placeholder="Topic">
                            </div>
                        </div>
                    </div>

                    <div class="form-row">
                        <div class="name">Title:</div>
                        <div class="value">
                            <div class="input-group">
                                <input class="input--style-5" type="text" id="title" required="Required" name="title"
                                       placeholder="Title">
                            </div>
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="name">Image Url:</div>
                        <div class="value">
                            <div class="input-group">
                                <input class="input--style-5" type="text" id="imageUrl" required="Required"
                                       name="imageUrl" placeholder="Image Url">
                            </div>
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="name">Original Url:</div>
                        <div class="value">
                            <div class="input-group">
                                <input class="input--style-5" type="text" id="originalURL" required="Required"
                                       name="originalURL" placeholder="Original Url">
                            </div>
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="name">Post ID:</div>
                        <div class="value">
                            <div class="input-group">
                                <input class="input--style-5" type="text" id="postID" required="Required" name="postID"
                                       placeholder="Post ID">
                            </div>
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="name">Click Action:</div>
                        <div class="value">
                            <div class="input-group">
                                <input class="input--style-5" type="text" id="click_action" required="Required"
                                       name="click_action" placeholder="Click Action">
                            </div>
                        </div>
                    </div>
                    <div align="center">
                        <button class="btn btn--radius-2 btn--blue" type="submit">Send Now</button>
                    </div>
                </form>


                <?php

                if (isset($_POST['title'])) {

                    require_once __DIR__ . '/Notification.php';
                    $notification = new Notification();


                    $title = $_POST['title'];
                    $imageUrl = $_POST['imageUrl'];
                    $originalURL = $_POST['originalURL'];
                    $postID = $_POST['postID'];
                    $click_action = $_POST['click_action'];

                    $notification->setTitle($title);
                    $notification->setImage($imageUrl);
                    $notification->setOriginal_url($originalURL);
                    $notification->setPost_id($postID);
                    $notification->setClick_action($click_action);

                    $requestData = $notification->getNotification();

                    $topic = $_POST['topic'];

                    $fields = array(
                        'to' => '/topics/' . $topic,
                        'data' => $requestData,
                    );


                    $server_key = "AAAAC3qJOFY:APA91bHWw1zp_djGMZMmIHqNIyyrhASdLb3Z_91-ifR9_Se5ffOcGxPPH-yv8ZIbHyYOxhViuwP9XqPo3NTyAx2hhPrU536OoeI3aYYqtSkWmh3Ja7RzoC7qyOPY-uS7kXJDCORD2Hmp";

                    $headers = array(
                        'Authorization: key=' . $server_key,
                        'Content-Type: application/json'
                    );


                    $url = 'https://fcm.googleapis.com/fcm/send';

                    // Open connection
                    $ch = curl_init();

                    // Set the url, number of POST vars, POST data
                    curl_setopt($ch, CURLOPT_URL, $url);

                    curl_setopt($ch, CURLOPT_POST, true);
                    curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
                    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

                    // Disabling SSL Certificate support temporarily
                    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);

                    curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($fields));

                    // Execute post
                    $result = curl_exec($ch);
                    if ($result === FALSE) {
                        echo "Failed.";
                        die('Curl failed: ' . curl_error($ch));
                    } else {

                        echo "Sent.";
                    }

                    // Close connection
                    curl_close($ch);

                    echo '<h2>Result</h2><hr/><h3>Request </h3><p><pre style="white-space: pre-wrap;">';

                    ?>
                    <style>
                        td {
                            padding: 10px;
                        }
                    </style>
                    <!-- echo json_encode($fields,JSON_PRETTY_PRINT); -->
                    <table border="1" style="text-align: left;">
                        <tr>
                            <td>
                                Title
                            </td>
                            <td width="57%">
                                <?php echo $fields['data']['title']; ?>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                Image URL
                            </td>
                            <td>
                                <a href="<?php echo $fields['data']['imageUrl']; ?>"><?php echo $fields['data']['imageUrl']; ?></a>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                Original URL
                            </td>
                            <td>
                                <a href="<?php echo $fields['data']['originalURL']; ?>"><?php echo $fields['data']['originalURL']; ?></a>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                post ID
                            </td>
                            <td>
                                <?php echo $fields['data']['postID']; ?>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                click_action
                            </td>
                            <td>
                                <?php echo $fields['data']['click_action']; ?>
                            </td>
                        </tr>
                    </table>
                    <?
                    echo '</pre></p><h3>Response </h3><p><pre>';
                    echo $result;
                    echo '</pre></p>';

                }

                ?>
            </div>
        </div>
    </div>
    <!-- Jquery JS-->
    <script src="vendor/jquery/jquery.min.js"></script>
    <!-- Vendor JS-->
    <script src="vendor/select2/select2.min.js"></script>
    <script src="vendor/datepicker/moment.min.js"></script>
    <script src="vendor/datepicker/daterangepicker.js"></script>

    <!-- Main JS-->
    <script src="js/global.js"></script>

</body><!-- This templates was made by Colorlib (https://colorlib.com) -->

</html>
<!-- end document-->

 
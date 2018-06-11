<?php
session_start();

require('../_CONFIG.php');
require('db.php');
require('inc.general.php');
require('class.decisiontree.php');
header("Access-Control-Allow-Origin: *");

/*
    Log the user
*/

if ($_POST['action'] === 'log'){

    $errors = array();

    //If new user, log the user;
    if ($_POST['existing_user'] === ''){
        $user_add = $dbh->prepare("INSERT INTO `users` (`id`, `user_id`, `user_ip`, `created`)
        VALUES (NULL, :user_id, :user_ip, CURRENT_TIMESTAMP);");
        $user_id = uniqid();
        $user_ip = $_SERVER['REMOTE_ADDR'];

        //Query ipinfo for data
        //if (!function_exists('curl_init')){
        //    //We need curl to query ipinfo
        //    $resp = array('status' => 'ERROR');
        //    die(json_encode($resp)) ;
        //}
        //            
        //$ch = curl_init('http://ipinfo.io/' . $user_ip);
        //curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);  /* return the data */
        //$result = curl_exec($ch);
        //curl_close($ch);
        //$json = json_decode($result);

        $data = array('user_id' => $user_id, 'user_ip' => $user_ip);
        $user_add->execute($data);

        $error = $user_add->errorInfo();

        if ($error[1]){
            array_push($errors, $error[1]);
        }
    } else {
        $user_id = $_POST['existing_user'];
    }

    //Create new session
    if (isset($_POST['mobile'])){
        $mobile = 1;
    } else {
        $mobile = 0;

    }
    $add_session =$dbh->prepare("INSERT INTO `sessions` (`id`, `user_id`, `tree_id`, `time_started`, `mobile`)
    VALUES (NULL, :user_id, :tree_id, CURRENT_TIMESTAMP, :mobile);");
    $tree_id = $_POST['tree_id'];
    $data = array('user_id' => $user_id, 'tree_id' => $tree_id, 'mobile' => $mobile);
    $add_session->execute($data);
    $error = $add_session->errorInfo();
    if ($error[1]){
        array_push($errors, $error[1]);
    }
    $sess_id =$dbh->lastInsertId();

    if (empty($errors)){
        $resp = array('status' => 'OK', 'userid' => $user_id, 'sessid' => $sess_id);
        echo json_encode($resp);
    } else {
        $resp = array('status' => 'ERROR');
        echo json_encode($resp);
    }
}

/*
    Update User Location
*/

if ($_POST['action'] === 'update_location'){

    $loc = $_POST['lat'] . ',' . $_POST['long'];
    $update_location = $dbh->prepare("UPDATE  `users` SET  `loc` =  :loc WHERE  `user_id` = :user_id; ");
    $data = array('loc' => $loc, 'user_id' => $_POST['user_id']);
    $update_location->execute($data);
    $error = $update_location->errorInfo();
    if ($error[1]){
        $resp = array('status' => 'ERROR');
    } else {
        $resp = array('status' => 'OK');
    }
    echo json_encode($resp);
}

/*
    Record User Progress
*/

if ($_POST['action'] === 'progress'){

    $track_progress = $dbh->prepare("UPDATE  `sessions` SET  `last_link_clicked` =  :last_link WHERE  `id` = :sess_id; ");
    $data = array('last_link' => $_POST['last_link'], 'sess_id' => $_POST['session_id']);
    $track_progress->execute($data);
    $error = $track_progress->errorInfo();
    if ($error[1]){
        $resp = array('status' => 'ERROR');
    } else {
        $resp = array('status' => 'OK');
    }
    echo json_encode($resp);
}

/*
    Log in user to edit tree
*/

if ($_POST['action'] === 'login'){

    $user = $_POST['username'];
    $pass = sha1($_POST['password']);
    $login = $dbh->prepare('SELECT * from `admin` where username = :username AND password = :password');
    $data = array('username' => $user, 'password' => $pass);
    $login->execute($data);
    if ($login->rowCount() > 0){
        $_SESSION['isLoggedIn'] = '1';
        echo json_encode(array('status' => 'OK','message' => 'Logging you in...'));
    } else {
        echo json_encode(array('status' => 'ERROR','message' => 'Incorrect Username or Password'));
    }
}

/*
    Track user clicks on referrals
*/

if ($_POST['action'] === 'link_click'){
    $q = $dbh->prepare("INSERT INTO `referrals_clicks` (`id`, `user_id`, `referral_id`, `sess_id`, `time_clicked`)
    VALUES (NULL, :user_id, :referral_id, :sess_id, CURRENT_TIMESTAMP); ");
    $data = array('user_id' => $_COOKIE['idt-user'], 'referral_id' => $_POST['referral_id'], 'sess_id' => $_COOKIE['idt-sess-id']); 
    $q->execute($data);
}

/*
    Mobile App Track user clicks on referrals
*/

if ($_POST['action'] === 'link_click_mobile'){
    $q = $dbh->prepare("INSERT INTO `referrals_clicks` (`id`, `user_id`, `referral_id`, `sess_id`, `time_clicked`)
    VALUES (NULL, :user_id, :referral_id, :sess_id, CURRENT_TIMESTAMP); ");
    $data = array('user_id' => $_POST['user_id'], 'referral_id' => $_POST['referral_id'], 'sess_id' => $_POST['sess_id']); 
    $q->execute($data);
}

/*
    Get List of Trees and Their Titles
*/


if ($_GET['action'] === 'get_trees'){
    //Get all xml files by id, title
    if ($handle = opendir('../xml')) {
        $tree_data = array();

        while (false !== ($entry = readdir($handle))) {
            $file = explode('.', $entry);
            $tree_id = substr($file[0], 4);
            if ($file[1] === 'xml'){//exclude revisions
                $tree = new DecisionTree($entry);
                $tree_data[$tree_id] = $tree->title;
            }
        }

        closedir($handle);
    }

    echo json_encode($tree_data);
}

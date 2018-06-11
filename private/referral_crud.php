<?php
session_start();
if (!$_SESSION['isLoggedIn']){
    header('Location: login.php');
}

require('../_CONFIG.php');

if (!isset($_SERVER["HTTP_HOST"])) {
  parse_str($argv[1], $_GET);
  parse_str($argv[1], $_POST);
}
try {
        $dbh = new PDO("mysql:host=" . DBHOST . ";dbname=" . DATABASE_NAME , DBUSERNAME, DBPASSWD);
    }
catch(PDOException $e)
    {
        echo $e->getMessage();
    }

function bindPostVals($query_string) {
    $cols = '';
    $upd = '';
    $vals = '';
    $data = array();
    unset($query_string['action']);
    foreach ($query_string as $key => $value) {
        {
            $key_name = ":" . $key;
            $upd .= "`$key` = " . "$key_name,";
            $cols .= "`$key`,";
            $vals .= ":$key,";
            $data[$key] = trim($value);
        }
    }

    $update = rtrim($upd,',');
    $columns = rtrim($cols,',');
    $values = rtrim($vals, ',');
    return array('columns'=>$columns, 'values' => $values, 'data' => $data, 'update' => $update);
}

switch($_POST['action']){

    case 'create':
    //First, do geocode lookup
    $address_url = str_replace(' ', '+', trim($_POST['address'])) . ',+' . str_replace(' ', '+', trim($_POST['city'])) . 
    ',+' . str_replace(' ', '+', trim($_POST['state']));
    $ch = curl_init("http://maps.googleapis.com/maps/api/geocode/json?sensor=false&address=" . $address_url );
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);  /* return the data */
    $result = curl_exec($ch);
    curl_close($ch);
    $json = json_decode($result);
    $geo_result =  $json->results[0];
    $coordinates = $geo_result->geometry->location;

    if ($geo_result->types[0] == 'street_address'){ //successful query
        $d = bindPostVals($_POST);
        $q = $dbh->prepare("INSERT INTO referrals (" . $d['columns'] .") VALUES (" . $d['values'] . ")");
        $q->execute($d['data']);
        $e = $q->errorInfo();
        if(!$e[1]){
            $last_id = $dbh->lastInsertId();
            $update = $dbh->prepare('UPDATE referrals SET loc = ? where id = ?');
            $coord = $coordinates->lat . "," . $coordinates->lng;
            $update->bindParam(1, $coord);
            $update->bindParam(2, $last_id);
            $update->execute();
            echo json_encode(array('status'=>'OK', 'message'=>'Added successfully','last_id' => $last_id));
        } else {
            echo json_encode(array('status'=>'ERROR', 'message'=>'Error Adding: ' . $e[1]));
        }
    } else {
            echo json_encode(array('status'=>'ERROR', 'message'=>'Error: Make sure the address and zip are valid.'));
    }

    break;

    case 'read':
    $q = $dbh->prepare('SELECT * from referrals where id = ?');
    $q->bindParam(1, $_POST['id']);
    $q->execute();
    $result = $q->fetch(PDO::FETCH_ASSOC);
    echo json_encode($result);
    break;

    case 'update':
    //First, do geocode lookup
    $address_url = str_replace(' ', '+', trim($_POST['address'])) . ',+' . str_replace(' ', '+', trim($_POST['city'])) . 
    ',+' . str_replace(' ', '+', trim($_POST['state'])) ;
    $ch = curl_init("http://maps.googleapis.com/maps/api/geocode/json?sensor=false&address=" . $address_url );
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);  /* return the data */
    $result = curl_exec($ch);
    curl_close($ch);
    $json = json_decode($result);
    $geo_result =  $json->results[0];
    $coordinates = $geo_result->geometry->location;

    if ($geo_result->types[0] == 'street_address'){ //successful query
        $d = bindPostVals($_POST);
        $q = $dbh->prepare("UPDATE referrals SET" .  $d['update'] ." WHERE id = :id ");
        $q->execute($d['data']);
        if(!$e[1]){
            $last_id = $_POST['id'];
            $update = $dbh->prepare('UPDATE referrals SET loc = ? where id = ?');
            $coord = $coordinates->lat . "," . $coordinates->lng;
            $update->bindParam(1, $coord);
            $update->bindParam(2, $last_id);
            $update->execute();
            echo json_encode(array('status'=>'OK', 'message'=>'Edited successfully','last_id' => $_POST['id']));
        } else {
            echo json_encode(array('status'=>'ERROR', 'message'=>'Error Editing: ' . $e[1]));
        }
    } else {
            echo json_encode(array('status'=>'ERROR', 'message'=>'Error: Make sure the address and zip are valid.'));
    }
    break;

    case 'delete':
    $d = bindPostVals($_POST);
    $q = $dbh->prepare("DELETE FROM referrals  WHERE id = :id ");
    $q->execute($d['data']);
    if(!$e[1]){
        $remove = $dbh->prepare('DELETE from referrals_assoc_tree where referral_id = ?');
        $remove->bindParam(1,$_POST['id']);
        $remove->execute();
        echo json_encode(array('status'=>'OK', 'message'=>'Deleted successfully','last_id' => $_POST['id']));
    } else {
        echo json_encode(array('status'=>'ERROR', 'message'=>'Error Deleting: ' . $e[1]));
    }

    break;
}



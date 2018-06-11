<?php
session_start();
if (!$_SESSION['isLoggedIn']){
    header('Location: login.php');
}

include('../_CONFIG.php');
include('db.php');

if (isset($_POST['start'])){
    $start = date('Y-m-d', strtotime($_POST['start']))  . ' 00:00:00';
} else {
    $start = date( 'Y-m-d', strtotime('-30 days')) . ' 00:00:00';
}

if (isset($_POST['end'])){
    $end = date('Y-m-d', strtotime($_POST['end']))  . ' 23:59:59';
} else {
    $end = date( 'Y-m-d H:i:s', time());
}

if (isset($_POST['type'])){
    $type = $_POST['type'];
} else {
    $type = "by_referrals_totals";
}

if (isset($_POST['ref_id'])){
    $ref_id = $_POST['ref_id'];
}



switch ($type) {
    case 'by_referrals_totals':
        $q = $dbh->prepare('SELECT referrals.*, referrals_clicks.*, COUNT(referrals_clicks.id) as num_clicks
        from referrals, referrals_clicks where (referrals.id = referrals_clicks.referral_id)
        and (referrals_clicks.time_clicked > ?) and 
        (referrals_clicks.time_clicked < ?) group by referrals_clicks.referral_id ');
        $q->bindParam(1, $start);
        $q->bindParam(2, $end);
        $q->execute();
        $totals = $q->fetchAll();
        echo "<thead><th>Referral Name</th><th>Number of Clicks</th></thead><tbody>";
        foreach ($totals as $t) {
            echo "<tr><td>" .  $t['name'] . "</td><td>" . $t['num_clicks'] . "</td></tr>"; 
        }

        break;
    case 'by_referral':
        $q = $dbh->prepare('SELECT referrals.id, referrals.name, referrals_clicks.*, sessions.*
        from referrals, referrals_clicks, sessions where (referrals.id = ?) and (referrals.id = referrals_clicks.referral_id) and
        (time_clicked > ?) and (time_clicked < ?)
        '); 
        $q->bindParam(1, $ref_id);
        $q->bindParam(2, $start);
        $q->bindParam(3, $end);
        $q->execute();
        $refs = $q->fetchAll();
        echo "<thead><th>Referral</th><th>Tree Id</th><th>Time Clicked</td><td>Last Question Answered</td></thead><tbody>";
        foreach ($refs as $r) {
            echo "<tr><td>" .  $r['name'] . "</td><td>" . $r['time_clicked'] . "</td><td><a target='_new'  href='../index.php?" . $r['tree_id'] ."'>" .
            $r['tree_id'] . "</a></td><td>" . $r['last_link_clicked'] . "</td></tr>"; 
        }
        break;

    case 'by_tree':
        $q = $dbh->prepare('SELECT referrals_clicks.*, sessions.*, COUNT(sessions.tree_id) as t_count 
        from referrals_clicks, sessions where (sessions.id = referrals_clicks.sess_id) and
        (time_clicked > ?) and (time_clicked < ?) GROUP By sessions.tree_id'); 
        $q->bindParam(1, $start);
        $q->bindParam(2, $end);
        $q->execute();
        $totals = $q->fetchAll();
        echo "<thead><th>Tree Id</th><th>Number of Clicks</th></thead><tbody>";
        foreach ($totals as $t) {
            echo "<tr><td><a target='_new'  href='../index.php?" . $t['tree_id'] ."'>"  .  $t['tree_id'] . "</a></td><td>" . $t['t_count'] . "</td></tr>"; 
        }
        break;
    default:
        
        break;
}
echo "</tbody>";

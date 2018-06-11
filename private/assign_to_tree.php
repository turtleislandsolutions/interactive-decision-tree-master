<?php
session_start();

if (!$_SESSION['isLoggedIn']){
    header('Location: login.php');
}

require('../_CONFIG.php');
require('../_THEME.php');
require('inc.general.php');
require('db.php');


$id = $_POST['id'];

//Handle Updates
if (isset($_POST['action'])){

    //delete current assignments
    $q = $dbh->prepare('DELETE from referrals_assoc_tree where referral_id = ?');
    $q->bindParam(1, $id);
    $q-> execute();

    $req = $_POST['assign'];

    //Prepare insert query
    $q = $dbh->prepare('INSERT INTO referrals_assoc_tree (id, referral_id, assoc_tree) VALUES (null,:ref_id,:assoc_tree);'); 
    foreach ($req as $r) {
       $data = array('ref_id' => $id, 'assoc_tree' => $r['name']); 
       $q->execute($data);
    }
}

//Get ref's information
$q = $dbh->prepare('SELECT * from referrals where id = ?');
$q->bindParam(1, $id);
$q->execute();
$ref_data = $q->fetch();

//Generate an array of all trees this referral is assigned to
$q = $dbh->prepare('SELECT * from referrals_assoc_tree where referral_id = ?');
$q->bindParam(1, $id);
$q->execute();
$assignments = $q->fetchAll();
$assigned_trees = array();
foreach ($assignments as $a) {
   $assigned_trees[] = $a['assoc_tree']; 
}

//Generate a array of trees and their names;
$tree = new DecisionTree();
$available_trees = $tree->assignList();
?>

<h3> Tree Assignments for <?php echo $ref_data['name']; ?></h3>
<div>
    <a href="#" rel="popover" class="label label-info help-pop" data-toggle="popover" title="" 
    data-content="In order for <?php echo $ref_data['name']; ?> to appear in the list of referrals for a given tree,
    you must assign them to that tree." role="button" data-original-title="What's This?">?</a>
</div>
<br />
<button class="ref-assign-cancel" data-id="<?php echo $ref_data['id']; ?>">&#171; Back</button>
<form name = "assignTrees">

<?php
foreach ($available_trees as $key =>  $value) {
?>
    <div class="checkbox">
        <label>
            <input type="checkbox" name="<?php echo $key; ?>"
            <?php if (in_array($key, $assigned_trees)){
                echo " checked";
            }
            ?>
            >
            <?php echo  $value; ?>
        </label>
    </div> 
<?php
}
?>

<button class="ref-assign-do" data-id="<?php echo $ref_data['id']; ?>">Submit</button>
</form>

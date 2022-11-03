<?php
include 'functions.php';
$pdo = pdo_connect_mysql();
$msg = '';
// Check if the contact id exists, for example update.php?id=1 will get the contact with the id of 1
if (isset($_GET['id'])) {
    if (!empty($_POST)) {

        // This part is similar to the create.php, but instead we update a record and not insert
        $id = isset($_POST['id']) ? $_POST['id'] : NULL;
  	$firstname = isset($_POST['firstname']) ? $_POST['firstname'] : '';
  	$lastname = isset($_POST['lastname']) ? $_POST['lastname'] : '';
   	$course = isset($_POST['course']) ? $_POST['course'] : '';
 	$phone = isset($_POST['phone']) ? $_POST['phone'] : '';
   	$address = isset($_POST['address']) ? $_POST['address'] : '';
  	$birthdate = isset($_POST['birthdate']) ? $_POST['birthdate'] : '';
    	$guardian = isset($_POST['guardian']) ? $_POST['guardian'] : '';
	$guardianphone = isset($_POST['guardianphone']) ? $_POST['guardianphone'] : '';
	$created = isset($_POST['created']) ? $_POST['created'] : date('Y-m-d H:i:s');

        // Update the record
        $stmt = $pdo->prepare('UPDATE contacts SET id = ?, firstname = ?, lastname = ?, course = ?, phone = ?, address = ?, birthdate = ?, guardian = ?, guardianphone = ?, created = ? WHERE id = ?');
        $stmt->execute([$id, $firstname, $lastname, $course, $address, $birthdate, $guardian, $guardianphone, $created, $_GET['id']]);
        $msg = 'Updated Successfully!';
    }
    // Get the contact from the contacts table
    $stmt = $pdo->prepare('SELECT * FROM idregister WHERE id = ?');
    $stmt->execute([$_GET['id']]);
    $idregister = $stmt->fetch(PDO::FETCH_ASSOC);
    if (!$idregister) {
        exit('Contact doesn\'t exist with that ID!');
    }
} else {
    exit('No ID specified!');
}
?>

<?=template_header('Read')?>

<div class="content update">
	<h2>Update Contact #<?=$idregister['id']?></h2>
    <form action="update.php?id=<?=$idregister['id']?>" method="post">
        <label for="id">ID</label>
        <label for="firstname">First Name</label>
        <label for="lastname">Last Name</label>
        <input type="text" name="id" placeholder="26" value="auto" id="id">
        <input type="text" name="firstname" placeholder="John" id="firstname">
        <input type="text" name="lastname" placeholder="Doe" id="lastname">

        <label for="course">Course</label>
        <label for="phone">Phone</label>
        <input type="text" name="course" placeholder="BSIT" id="course">
        <input type="text" name="phone" placeholder="2025550143" id="phone">

        <label for="address">Address</label>
        <label for="birthdate">Birthdate</label>
        <input type="text" name="address" placeholder="123 john doe street" id="address">
        <input type="text" name="birthdate" placeholder="jan 1 2000" id="address">

        <label for="guardian">Guardian</label>
        <label for="guardianphone">Guardian Phone</label>
        <input type="text" name="guardian" placeholder="Mom Doe" id="guardian">
        <input type="text" name="guardianphone" placeholder="1235550143" id="guardianphone">


        <label for="created">Created</label>
        <input type="datetime-local" name="created" value="<?=date('Y-m-d\TH:i', strtotime($contact['created']))?>" id="created">
        <input type="submit" value="Update">
    </form>
    <?php if ($msg): ?>
    <p><?=$msg?></p>
    <?php endif; ?>
</div>

<?=template_footer()?>

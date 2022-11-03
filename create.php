<?php
include 'functions.php';
$pdo = pdo_connect_mysql();
$msg = '';

// Check if POST data is not empty
if (!empty($_POST)) {

    // Post data not empty insert a new record
    // Set-up the variables that are going to be inserted, we must check if the POST variables exist if not we can default them to blank
    $id = isset($_POST['id']) && !empty($_POST['id']) && $_POST['id'] != 'auto' ? $_POST['id'] : NULL;

    // Check if POST variable "name" exists, if not default the value to blank, basically the same for all variables
    $firstname = isset($_POST['firstname']) ? $_POST['firstname'] : '';
    $lastname = isset($_POST['lastname']) ? $_POST['lastname'] : '';
    $course = isset($_POST['course']) ? $_POST['course'] : '';
    $phone = isset($_POST['phone']) ? $_POST['phone'] : '';
    $address = isset($_POST['address']) ? $_POST['address'] : '';
    $birthdate = isset($_POST['birthdate']) ? $_POST['birthdate'] : '';
    $guardian = isset($_POST['guardian']) ? $_POST['guardian'] : '';
    $guardianphone = isset($_POST['guardianphone']) ? $_POST['guardianphone'] : '';
    $created = isset($_POST['created']) ? $_POST['created'] : date('Y-m-d H:i:s');

    // Insert new record into the contacts table
    $stmt = $pdo->prepare('INSERT INTO contacts VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)');
    $stmt->execute([$id, $firstname, $lastname, $course, $address, $birthdate, $guardian, $guardianphone, $created]);

    // Output message
    $msg = 'Created Successfully!';
}
?>

<?=template_header('Create')?>

<div class="content update">
	<h2>ID Registration</h2>
    <form action="create.php" method="post">
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
        <input type="datetime-local" name="created" value="<?=date('Y-m-d\TH:i')?>" id="created">
        <input type="submit" value="Create">
    </form>
    <?php if ($msg): ?>
    <p><?=$msg?></p>
    <?php endif; ?>
</div>

<?=template_footer()?>

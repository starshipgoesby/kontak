<?php
require_once 'database.php';
require_once 'logic.php';

$database = new Database();

$contactManager = new kontakLogic($database);

if (isset($_GET['id'])) {
    $contactId = $_GET['id'];

    $contactManager->deleteContact($contactId);
    
    header('Location: index.php'); 
    exit();
} else {
    echo "Invalid request.";
    exit();
}
?>

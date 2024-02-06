<?php
require_once 'kontak.php';
require_once 'contactManager.php';

// Membuat objek Database
$database = new Database();

// Membuat objek ContactManager dengan menggunakan objek Database
$contactManager = new ContactManager($database);

// Memastikan parameter ID ada dalam URL
if (isset($_GET['id'])) {
    $contactId = $_GET['id'];

    // Memproses form pengiriman data kontak
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $name = $_POST['name'];
        $email = $_POST['email'];
        $phoneNumber = $_POST['phone'];

        // Validasi input
        if (!empty($name) && filter_var($email, FILTER_VALIDATE_EMAIL) && !empty($phoneNumber)) {
            // Mengupdate kontak
            $updatedContact = new Contact($contactId, $name, $email, $phoneNumber);
            $contactManager->updateContact($updatedContact);
            header('Location: index.php'); // Redirect ke halaman utama setelah update
            exit();
        } else {
            echo "Invalid input. Please provide valid data.";
        }
    }

    // Mengambil data kontak berdasarkan ID
    $contact = $contactManager->getContactById($contactId);

    if (!$contact) {
        echo "Contact not found.";
        exit();
    }
} else {
    echo "Invalid request.";
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Contact</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <style>
        form {
            margin-top: 20px;
        }
    </style>
</head>

<body>
    <div class="container mt-5">
        <h2>Edit Contact</h2>

        <!-- Form untuk mengedit kontak -->
        <form method="POST" action="">
            <div class="mb-3">
                <label for="name" class="form-label">Name:</label>
                <input type="text" class="form-control" name="name" value="<?php echo $contact->getName(); ?>" required>
            </div>

            <div class="mb-3">
                <label for="email" class="form-label">Email:</label>
                <input type="email" class="form-control" name="email" value="<?php echo $contact->getEmail(); ?>" required>
            </div>

            <div class="mb-3">
                <label for="phone" class="form-label">Phone:</label>
                <input type="tel" class="form-control" name="phone" value="<?php echo $contact->getPhoneNumber(); ?>" required>
            </div>

            <button type="submit" class="btn btn-primary">Update Contact</button>
        </form>
    </div>

    <!-- Bootstrap JS and Popper.js (if needed) -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>
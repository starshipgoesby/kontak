<?php
require_once 'kontak.php';
require_once 'contactManager.php';

// Membuat objek Database
$database = new Database();

// Membuat objek ContactManager dengan menggunakan objek Database
$contactManager = new ContactManager($database);

// Memproses form pengiriman data kontak
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = $_POST['name'];
    $email = $_POST['email'];
    $phoneNumber = $_POST['phone'];

    // Validasi input
    if (!empty($name) && filter_var($email, FILTER_VALIDATE_EMAIL) && !empty($phoneNumber)) {
        // Menambahkan kontak baru
        $newContact = new Contact(null, $name, $email, $phoneNumber); // id dapat diabaikan karena akan di-generate otomatis
        $contactManager->addContact($newContact);
    } else {
        echo "Invalid input. Please provide valid data.";
    }
}

// Mengambil daftar kontak
$contacts = $contactManager->getContacts();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Contact Manager</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <style>
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }

        table,
        th,
        td {
            border: 1px solid #ddd;
        }

        th,
        td {
            padding: 10px;
            text-align: left;
        }

        form {
            margin-top: 20px;
        }

        .edit-btn,
        .delete-btn {
            display: inline-block;
            margin: 5px;
            border-radius: 4px;
            cursor: pointer;
        }
    </style>
</head>

<body>
    <div class="container mt-5">

        <h2 class="mb-4">Contact Manager</h2>
        <!-- Form untuk menambah kontak baru -->
        <form method="POST" action="">
            <div class="mb-3">
                <label for="name" class="form-label">Name:</label>
                <input type="text" class="form-control" name="name" required>
            </div>

            <div class="mb-3">
                <label for="email" class="form-label">Email:</label>
                <input type="email" class="form-control" name="email" required>
            </div>

            <div class="mb-3">
                <label for="phone" class="form-label">Phone:</label>
                <input type="tel" class="form-control" name="phone" required>
            </div>

            <button type="submit" class="btn btn-primary">Add Contact</button>
        </form>

        <!-- Daftar Kontak -->
        <table class="table mt-4">
            <thead>
                <tr>
                    <th>Name</th>
                    <th>Email</th>
                    <th>Phone</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($contacts as $contact) : ?>
                    <tr>
                        <td><?php echo $contact->getName(); ?></td>
                        <td><?php echo $contact->getEmail(); ?></td>
                        <td><?php echo $contact->getPhoneNumber(); ?></td>
                        <td>
                            <a class="btn btn-warning" href="edit.php?id=<?php echo $contact->getId(); ?>">Edit</a>
                            <a class="btn btn-danger" href="delete.php?id=<?php echo $contact->getId(); ?>">Delete</a>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>

    <!-- Bootstrap JS and Popper.js (if needed) -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>
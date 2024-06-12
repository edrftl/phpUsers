<?php
global $dbh;

include("connection_database.php");

$name = isset($_POST['name']) ? $_POST['name'] : '';
$email = isset($_POST['email']) ? $_POST['email'] : '';
$phone = isset($_POST['phone']) ? $_POST['phone'] : '';
$get_id = isset($_GET['id']) ? $_GET['id'] : '';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Create
    if (isset($_POST['create'])) {
        if (isset($_FILES['image']) && $_FILES['image']['error'] == UPLOAD_ERR_OK) {
            $uploadDir = $_SERVER["DOCUMENT_ROOT"] . '/uploads/';
            $uploadFile = $uploadDir . basename($_FILES['image']['name']);

            if (!is_dir($uploadDir)) {
                mkdir($uploadDir, 0777, true);
            }

            if (move_uploaded_file($_FILES['image']['tmp_name'], $uploadFile)) {
                $image = '/uploads/' . basename($_FILES['image']['name']);
            } else {
                $image = null;
            }
        } else {
            $image = null;
        }

        $stmt = $dbh->prepare("INSERT INTO users (name, email, image, phone) VALUES (:name, :email, :image, :phone)");
        $stmt->bindParam(':name', $name);
        $stmt->bindParam(':email', $email);
        $stmt->bindParam(':image', $image);
        $stmt->bindParam(':phone', $phone);

        $stmt->execute();

        header("Location: /");
        exit();
    }

    // Edit
    if (isset($_POST['edit'])) {
        $id = isset($_POST['id']) ? $_POST['id'] : '';
        $current_image = isset($_POST['current_image']) ? $_POST['current_image'] : '';

        $image = $current_image;
        if (isset($_FILES['image']) && $_FILES['image']['error'] == UPLOAD_ERR_OK) {
            $uploadDir = $_SERVER["DOCUMENT_ROOT"] . '/uploads/';
            $uploadFile = $uploadDir . basename($_FILES['image']['name']);

            if (!is_dir($uploadDir)) {
                mkdir($uploadDir, 0777, true);
            }

            if (move_uploaded_file($_FILES['image']['tmp_name'], $uploadFile)) {
                $image = '/uploads/' . basename($_FILES['image']['name']);
            }
        }

        $sql = "UPDATE users SET name = ?, email = ?, image = ?, phone = ? WHERE id = ?";
        $query = $dbh->prepare($sql);
        $query->execute([$name, $email, $image, $phone, $id]);

        header("Location: " . $_SERVER['HTTP_REFERER']);
        exit();
    }

    //Delete
    // Delete
    if (isset($_POST['delete'])) {
        $id = isset($_POST['id']) ? $_POST['id'] : '';

        $sql = "DELETE FROM users WHERE id = ?";
        $query = $dbh->prepare($sql);
        $query->execute([$id]);

        header("Location: " . $_SERVER['HTTP_REFERER']);
        exit();
    }

}
?>

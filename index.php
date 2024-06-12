<?php global $dbh; ?>
<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
    <link rel="stylesheet" href="/css/bootstrap.min.css">
    <link rel="stylesheet" href="/css/site.css">
</head>
<body>
<?php include("_header.php"); ?>
<?php include("connection_database.php"); ?>
<?php include("foo.php"); ?>

<table class="table">
    <thead>
    <tr>
        <th scope="col">Id</th>
        <th scope="col">ПІБ</th>
        <th scope="col">Фото</th>
        <th scope="col">Пошта</th>
        <th scope="col">Телефон</th>
        <th scope="col"></th>
    </tr>
    </thead>
    <tbody>
    <?php
    $sql = 'SELECT * FROM users';
    foreach ($dbh->query($sql) as $row) {
        $id = $row["id"];
        $name = $row["name"];
        $image = $row["image"];
        $email = $row["email"];
        $phone = $row["phone"];

        echo "
            <tr>
                <th scope='row'>$id</th>
                <td>$name</td>
                <td>
                    <img src='$image' alt='$name' width='150'>
                </td>
                <td>$email</td>
                <td>$phone</td>
                <td>
                    <button type='button' class='btn btn-warning' data-bs-toggle='modal' data-bs-target='#edit$id'>Edit</button>
                    <button type='button' class='btn btn-danger' data-bs-toggle='modal' data-bs-target='#delete$id'>Delete</button>
                </td>
            </tr>
            
            <!-- Modal edit -->
            <div class='modal fade' id='edit$id' tabindex='-1' aria-labelledby='exampleModalLabel' aria-hidden='true'>
                <div class='modal-dialog'>
                    <div class='modal-content'>
                        <div class='modal-header'>
                            <h1 class='modal-title fs-5' id='exampleModalLabel'>Edit</h1>
                            <button type='button' class='btn-close' data-bs-dismiss='modal' aria-label='Close'></button>
                        </div>
                        <div class='modal-body'>
                            <form action='?id=$id' method='post' enctype='multipart/form-data'>
                                <input type='hidden' name='id' value='$id'>
                                <input type='hidden' name='current_image' value='$image'>
                                <div class='mb-3'>
                                    <label for='name' class='form-label'>ПІБ</label>
                                    <input type='text' class='form-control' name='name' value='$name'>
                                </div>

                                <div class='mb-3'>
                                    <label for='formFile' class='form-label'>Фото</label>
                                    <input class='form-control' type='file' name='image'>
                                </div>

                                <div class='mb-3'>
                                    <label for='email' class='form-label'>Пошта</label>
                                    <input type='text' class='form-control' name='email' value='$email'>
                                </div>

                                <div class='mb-3'>
                                    <label for='phone' class='form-label'>Телефон</label>
                                    <input type='text' class='form-control' name='phone' value='$phone'>
                                </div>

                                <div class='modal-footer'>
                                    <button type='button' class='btn btn-secondary' data-bs-dismiss='modal'>Close</button>
                                    <button type='submit' class='btn btn-primary' name='edit'>Edit</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
            <!-- Modal edit -->
             <!-- Modal delete -->
            <div class='modal fade' id='delete$id' tabindex='-1' aria-labelledby='exampleModalLabel' aria-hidden='true'>
                <div class='modal-dialog'>
                    <div class='modal-content'>
                        <div class='modal-header'>
                            <h1 class='modal-title fs-5' id='exampleModalLabel'>Delete $name</h1>
                            <button type='button' class='btn-close' data-bs-dismiss='modal' aria-label='Close'></button>
                        </div>
                        <div class='modal-body'>
                            <p>Are you sure you want to delete this user?</p>
                        </div>
                        <div class='modal-footer'>
                            <form action='' method='post' enctype='multipart/form-data'>
                                <input type='hidden' name='id' value='$id'>
                                <button type='button' class='btn btn-secondary' data-bs-dismiss='modal'>Close</button>
                                <button type='submit' class='btn btn-danger' name='delete'>Delete</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
            <!-- Modal delete -->

            
            
            
            ";
    }
    ?>
    </tbody>
</table>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="/js/bootstrap.bundle.min.js"></script>
</body>
</html>
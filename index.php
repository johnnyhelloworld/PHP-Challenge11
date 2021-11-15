<?php

// Connexion via PDO
require_once 'connect.php';
$pdo = new \PDO(DSN, USER, PASS);

// select all friends from friend
$query = "SELECT * FROM friend";
$statement = $pdo->query($query);
$friends = $statement->fetchAll();

if (!empty($_POST)) {
    if ((!empty($_POST['firstname'])&&($_POST['lastname'])) && (strlen($_POST['firstname'])<=45)&&(strlen($_POST['lastname'])<=45)) {
        // get the data from a form
        $firstname = trim($_POST['firstname']);
        $lastname = trim($_POST['lastname']);

        $query = 'INSERT INTO friend (firstname, lastname) VALUES (:firstname, :lastname)';
        $statement = $pdo->prepare($query);

        $statement->bindValue(':firstname', $firstname, \PDO::PARAM_STR);
        $statement->bindValue(':lastname', $lastname, \PDO::PARAM_STR);

        $statement->execute();
        header("Location: index.php");
    }
    elseif (empty($_POST['firstname'])) {
        echo "First Name empty";
    }
    elseif (empty($_POST['lastname'])) {
        echo "Last Name empty";
    }elseif (strlen($_POST['firstname'])>45) {
        echo "First Name too long";
    }
    else {
        echo "Last Name too long";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>F.R.I.E.N.D.S</title>
</head>
<body>
    <h1>F.R.I.E.N.D.S</h1>
    <table>
        <thead>
            <tr>
                <th>Firstname</th>
                <th>Lastname</th>
            </tr>
        </thead>

        <tbody>
            <?php foreach($friends as $friend) { ?>
                <tr>
                    <td>
                        <?php echo $friend['firstname']; ?>
                    </td>
                    <td>
                        <?php echo $friend['lastname']; ?>
                    </td>
                </tr>
            <?php } ?>
        </tbody>
    </table>

    <h2>Add a friend: </h2>
    <form action="" method="POST">
        <label for="firstname">First Name:</label><br>
        <input type="text" name="firstname"><br>
        <label for="lastname">Last Name:</label><br>
        <input type="text" name="lastname"><br>
        <input type="submit" value="submit" name="submit"><br>
    </form>
</body>
</html>
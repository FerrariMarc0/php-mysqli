<?php
require_once __DIR__.'/config/config.inc.php';
require_once __DIR__.'/classes/ConnectionMyDB.php'; 
require_once __DIR__.'/classes/Department.php';

$error = null;
try {
    //open db connection
    $connection = new ConnectionMyDB(DB_SERVERNAME, DB_USERNAME, DB_PASSWORD, DB_NAME);
    //handle departments
    $department = new Department($connection);

    //get the id if exists or null
    $id = $_GET['id'] ?? null;

    if($id){
        $result = $department->get_department_by_id($id);
    } else {
        $result = $department->get_all_departments();
    }

} catch (Exception $e) {
    $error = $e->getMessage();
}

$page_title = 'Departments';

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>PHP mySQLi</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@picocss/pico@1/css/pico.min.css">
</head>

<body class="departments">
    <div class="container">
        <header>
            <h1><?php echo $page_title; ?></h1>
        </header>
        <main>
            <?php if (!$error) : ?>
                <?php if ($result && $result->num_rows > 0) : ?>
                    <table>
                        <thead>
                            <tr>
                                <th scope="col">#</th>
                                <th scope="col">Department</th>
                                <th scope="col">Address</th>
                                <th scope="col">Phone</th>
                                <th scope="col">Email</th>
                                <th scope="col">Website</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php while ($row = $result->fetch_assoc()) : ?>
                                <tr>
                                    <th scope="row"><?php echo $row['id']; ?></th>
                                    <td><?php echo $row['name']; ?></td>
                                    <td><?php echo $row['address']; ?></td>
                                    <td><?php echo $row['phone']; ?></td>
                                    <td><?php echo $row['email']; ?></td>
                                    <td><?php echo $row['website']; ?></td>
                                </tr>
                            <?php endwhile; ?>
                        </tbody>
                    </table>
                <?php else : ?>
                    <?php echo "0 results"; ?>
                <?php endif; ?>
                <?php $connection->conn->close(); ?>
            <?php else : ?>
                <p> <?php echo $error; ?></p>
            <?php endif; ?>
        </main>
        <footer></footer>
    </div>
</body>

</html>
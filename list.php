<?php 
    require_once __DIR__ . '/environment.php';

    $db_username = $database_config['username'];
    $db_password = $database_config['password'];
    $db_database = $database_config['database'];

    function calculateAge($dob) {
        $dobObj = new DateTime($dob);
        $now = new DateTime();
        $age = $dobObj->diff($now)->y;
        return $age;
    }
    $mysqli = new mysqli($database_config['host'], $database_config['username'], $database_config['password'], $database_config['database']);

    // Check connection
    if ($mysqli->connect_error) {
        die("Connection failed: " . $mysqli->connect_error);
    }

    $sql = "SELECT p.id, p.first_name, p.surname, p.dob, p.created_at, SUM(pq.score) AS total_score
            FROM patients p
            LEFT JOIN patient_questions pq ON p.id = pq.patient_id
            GROUP BY p.id
            ORDER BY p.created_at DESC"; // Query to fetch patient details and their total score

    $result = $mysqli->query($sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Patients Information</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <script src="https://code.jquery.com/jquery-3.7.1.slim.min.js" integrity="sha256-kmHvs0B+OpCW5GVHUNjv9rOmY0IvSIRcf7zGUDTDQM8=" crossorigin="anonymous"></script>
</head>
<body>
    <div class="container mt-4">
        <h2>Patients Information</h2>
        <table class="table table-striped">
            <thead>
                <tr>
                    <th>Date of Submission</th>
                    <th>First Name</th>
                    <th>Surname</th>
                    <th>Age</th>
                    <th>Date of Birth</th>
                    <th>Total Score</th>
                </tr>
            </thead>
            <tbody>
                <?php while ($row = $result->fetch_assoc()) { ?>
                <tr>
                    <td><?php echo date('Y-m-d', strtotime($row['created_at'])); ?></td>
                    <td><?php echo htmlspecialchars($row['first_name']); ?></td>
                    <td><?php echo htmlspecialchars($row['surname']); ?></td>
                    <td><?php echo calculateAge($row['dob']); ?></td>
                    <td><?php echo date('Y-m-d', strtotime($row['dob'])); ?></td>
                    <td><?php echo intval($row['total_score']); ?></td>
                </tr>
                <?php } ?>
            </tbody>
        </table>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>

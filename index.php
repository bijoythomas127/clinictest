<?php 
    require_once __DIR__ . '/environment.php';

    $db_host = $database_config['host'];
    $db_username = $database_config['username'];
    $db_password = $database_config['password'];
    $db_database = $database_config['database'];
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>Neuromodulation</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <script src="https://code.jquery.com/jquery-3.7.1.slim.min.js" integrity="sha256-kmHvs0B+OpCW5GVHUNjv9rOmY0IvSIRcf7zGUDTDQM8=" crossorigin="anonymous"></script>
</head>
<body>
<div class="container mt-4">
    
    <?php if(isset($_SESSION['message'])) :  ?>
        <div class="alert alert-success" role="alert">
            <?= $_SESSION['message'] ?>
        </div>
        <?php $_SESSION['message'] = ""; ?> 
    <?php endif; ?>
    <h2 class="mb-4">Neuromodulation</h2>
    <form id="neuroForm" method="post" action="store_patient_details.php">
        <div class="row">
            <div class="col-md-12">
                <div class="card mb-4">
                    <div class="card-body">
                        <h5 class="card-title">Patient Details</h5>
                        
                            <div class="form-group">
                                <label for="firstName">First Name</label>
                                <input type="text" class="form-control" id="firstName" name="firstName" required>
                            </div>
                            <div class="form-group">
                                <label for="surname">Surname</label>
                                <input type="text" class="form-control" id="surname" name="surname" required>
                            </div>
                            <div class="form-group">
                                <label for="dob">Date of Birth</label>
                                <input type="date" class="form-control" id="dob" name="dob" required>
                            </div>
                            <div class="form-group">
                                <label for="age">Age</label>
                                <input type="number" class="form-control" id="age" name="age" readonly>
                            </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12">
                <div class="card mb-4">
                    <div class="card-body">
                        <h5 class="card-title">Brief Pain Inventory (BPI)</h5>
                        <?php
                            $mysqli = new mysqli($db_host, $db_username, $db_password, $db_database);

                            if ($mysqli->connect_error) {
                                die("Connection failed: " . $mysqli->connect_error);
                            }

                            $query = "SELECT id, question, min_score, max_score, include_in_total_score FROM questions ORDER BY `order` ASC";
                            $result = $mysqli->query($query);

                            if ($result->num_rows > 0) {

                                while ($row = $result->fetch_assoc()) {
                                    $question_id = $row['id'];
                                    $question_text = $row['question'];
                                    $min_score = $row['min_score'];
                                    $max_score = $row['max_score'];
                                    $include_in_total_score = $row['include_in_total_score'];

                                    echo '<div class="form-group">
                                            <label>' . $question_text . ' (' . $min_score . ' - ' . $max_score . ')</label>
                                            <input type="number" class="form-control score-input"
                                                data-include_in_total_score="'.$include_in_total_score.'"
                                                 name="q' . $question_id . '" min="' . $min_score . '" max="' . $max_score . '" required>
                                        </div>';
                                }

                            } else {
                                echo "No questions found in the database.";
                            }

                            $mysqli->close();

                        ?>
                            
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-sm-12">
                <div class="card mt-4">
                    <div class="card-body">
                        <h5 class="card-title">Total Score</h5>
                        <div class="form-group">
                            <label>Total Score (Sum of Q2-Q12):</label>
                            <input type="number" class="form-control" id="totalScore" readonly>
                        </div>
                        <button type="submit" class="btn btn-primary">Submit</button>
                    </div>
                </div>
            </div>
        </div>
    </form>
</div>

<script>
    $('#dob').on('change', function() {
        var dob = new Date($(this).val());
        var today = new Date('<?= date('Y-m-d') ?>');
        var age = today.getFullYear() - dob.getFullYear();
        if (today.getMonth() < dob.getMonth() || (today.getMonth() === dob.getMonth() && today.getDate() < dob.getDate())) {
            age--;
        }
        $('#age').val(age);
    });
    $('input.score-input').on('change', function() {
        validateInput($(this));
        calculateTotalScore();
    });

    function calculateTotalScore() {
        var totalScore = 0;
        $('input.score-input').each(function(){
            if($(this).data("include_in_total_score") == 1) {
                totalScore += parseInt($(this).val()) || 0;
            }
        })
        $('#totalScore').val(totalScore);
    }

    function validateInput(input) {
        var max = parseInt(input.attr('max'));
        var min = parseInt(input.attr('min'));
        var val = parseInt(input.val());
        if (val > max) {
            input.val(max);
        }
        else if(val < min) {
            input.val(0);
        }
    }

    
</script>

</body>
</html>

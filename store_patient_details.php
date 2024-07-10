<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
require_once __DIR__ . '/store.php';


if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $firstName = $_POST['firstName'];
    $surname = $_POST['surname'];
    $dob = $_POST['dob'];


    $dobObj = new DateTime($dob);
    $now = new DateTime();
    $age = $dobObj->diff($now)->y;

    $questions = array();
    foreach ($_POST as $key => $value) {
        if (strpos($key, 'q') === 0 && is_numeric(substr($key, 1))) {
            $questionId = substr($key, 1);
            $score = intval($value);
            $questions[] = array(
                'question_id' => $questionId,
                'score' => $score
            );
        }
    }

    $success = createPatientWithQuestions($firstName, $surname, $dob, $questions);

    if ($success) {
        $_SESSION["message"] = "Registered Successfully";
        header("Location: index.php");
        exit;
    } else {
        echo "Error: Failed to create patient with questions.";
    }
} else {
    header("Location: index.php");
    exit;
}
?>

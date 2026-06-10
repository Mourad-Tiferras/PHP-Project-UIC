<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Client Page</title>
     <style>
        body {
            font-family: sans-serif;
            background-color: #f0f0f0;
            margin: 30px;
        }
        .main-box {
            background-color: white;
            padding: 20px;
            border: 2px solid #ccc;
        }
        .q-block {
            background-color: #fafafa;
            border: 1px solid #ddd;
            padding: 15px;
            margin-bottom: 15px;
        }
        .score-box {
            background-color: #d4edda;
            color: #155724;
            padding: 15px;
            border: 1px solid #c3e6cb;
            margin-bottom: 20px;
        }
        button {
            background-color: blue;
            color: white;
            padding: 10px 20px;
            font-size: 16px;
            cursor: pointer;
        }
    </style>
</head>
<body>

<div class="main-box">

<?php
$data = json_decode(file_get_contents("questions.json"), true);
$score = null;
$correctCount = 0;
$totalQuestions = count($data['questions']);

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['submit'])) {
    $idx = 0;
    while ($idx < $totalQuestions) {
        $answerKey = 'q' . $idx;
        if (isset($_POST[$answerKey])) {
            $userAnswer = $_POST[$answerKey];
                if ($userAnswer == $data['questions'][$idx]['answer']) {
                    $correctCount++;
            }
        }
            $idx++;
    }
     $score = ($correctCount / $totalQuestions) * 100;
}
?>

<div>
<h1> MCQs Quiz </h1>
</div>

<?php
if ($score !== null) {
    echo "<div class='score-box'>";
    echo "<h2>Your Score: " . round($score, 2) . "%</h2>";
    echo "<p>" . $correctCount . " out of " . $totalQuestions . " correct.</p>";
    echo "</div>";
    echo "<br><hr><br>";
}
?>

<form method="POST" action="">
<?php
    $idx = 0;
    
    while ($idx < count($data['questions'])) {
        echo "<div class='q-block'>";
        echo "<h3>Question N°" . ($idx + 1) . ":</h3>";
        echo "<p>" . $data['questions'][$idx]['question'] . "</p>";
        
        $optIdx = 0;
        while ($optIdx < count($data['questions'][$idx]['options'])) {
            $optionVal = $data['questions'][$idx]['options'][$optIdx];
            echo "<label style='display: block; margin-bottom: 5px; cursor: pointer;'>";
            echo "<input type='radio' name='q" . $idx . "' value='" . $optionVal . "' required> ";
            echo $optionVal;
            echo "</label>";
            $optIdx++;
        }
        echo "</div>";
        $idx++;
    }
    ?>
    
    <br>
    <button type="submit" name="submit">Submit Quiz</button>
</form>

<br>
<br>
<a href="client.php">Take the quiz again</a>

</div> 

</body>
</html>

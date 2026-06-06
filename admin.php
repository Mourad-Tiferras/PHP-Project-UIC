<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Page</title>
</head>
<body>
  <form action="admin.php" method="POST">
    <div>
      <label>Question Title:</label>
      <input type="text" name="question" required>
    </div>
  
  <br>
  <br>

  <div>
    <label>Option 1</label>
    <input type="text" id="opt1" name="option1" required oninput="updateRadioValues()">
  </div>
  
  <br>

  <div>
    <label>Option 2</label>
    <input type="text" id="opt2" name="option2" required oninput="updateRadioValues()">
  </div>

  <br>

  <div>
    <label>Option 3</label>
    <input type="text" id="opt3" name="option3" required oninput="updateRadioValues()">
  </div>

  <br>

  <hr>

  <div>
    <label><strong>Select the Correct Answer:</strong></label><br>
    
    <input type="radio" id="rad1" name="answer" value="" required>
    <label for="rad1" id="lbl1">Option 1 Text</label><br>

    <input type="radio" id="rad2" name="answer" value="" required>
    <label for="rad2" id="lbl2">Option 2 Text</label><br>

    <input type="radio" id="rad3" name="answer" value="" required>
    <label for="rad3" id="lbl3">Option 3 Text</label>
  </div>
  
  <br>
  <button type="submit">Add Question</button>

</form>


<?php
/**
 * new_question - A func that create an array the question and its options + answer
 * 
 * @question: The Qwiz question
 * @option_1: Answer num 1
 * @option_2: Answer num 2
 * @option_3: Answer num 3
 * 
 * Return:  The created array with its assosiative values
 */
function new_question($question, $option_1, $option_2, $option_3, $answer) {
    $new_question = [];
    $new_question["question"] = $question;
    $new_question["options"] = [$option_1, $option_2, $option_3];
    $new_question["answer"] = $answer;
    return $new_question;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['question'])) {
  $data = json_decode(file_get_contents("questions.json"), true);
  $data['questions'][] = new_question($_POST['question'], $_POST['option1'], $_POST['option2'], $_POST['option3'], $_POST['answer']);
  file_put_contents("questions.json", json_encode($data, JSON_PRETTY_PRINT));
}

?>

<br>

<h3>Choose a Question number to delete:  </h3>


<form action="admin.php" method="POST">
  <div>
    <label>Question number:  </label>
    <input type="number" name="question_to_delete">
  </div>
  <button type="submit">Delete Question</button>
</form>

<?php

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  if (isset($_POST['question_to_delete'])) {
    $idx_to_delete = (int) $_POST['question_to_delete'];
    $data = json_decode(file_get_contents("questions.json"), true);
    if ($idx_to_delete <= 0 || $idx_to_delete > count($data['questions'])) {
      echo "<br>Error: Question Number not exist!  <br>";
    }
    else {
      $idx_to_delete = $idx_to_delete - 1;
      unset($data['questions'][$idx_to_delete]);
      $data['questions'] = array_values($data['questions']);
      file_put_contents("questions.json", json_encode($data, JSON_PRETTY_PRINT));
    }
  }
}
?>

<br>




<h3> All questions displayed: </h3>

<?php
$data = json_decode(file_get_contents("questions.json"), true);
$idx = 0;

while ($idx < count($data['questions'])) {
  echo "<br>Question N°" . ($idx + 1) . ":<br><br>";
  echo $data['questions'][$idx]['question'] . "<br>";
  echo "&nbsp;&nbsp; Option 1:   " . $data['questions'][$idx]['options'][0] . "<br>";
  echo "&nbsp;&nbsp; Option 2:   " . $data['questions'][$idx]['options'][1] . "<br>";
  echo "&nbsp;&nbsp; Option 3:   " . $data['questions'][$idx]['options'][2] . "<br>";
  $idx++;
}

?>

<script>
function updateRadioValues() {

    const opt1Text = document.getElementById('opt1').value;
    const opt2Text = document.getElementById('opt2').value;
    const opt3Text = document.getElementById('opt3').value;

    document.getElementById('rad1').value = opt1Text;
    document.getElementById('rad2').value = opt2Text;
    document.getElementById('rad3').value = opt3Text;

    document.getElementById('lbl1').textContent = opt1Text || "Option 1";
    document.getElementById('lbl2').textContent = opt2Text || "Option 2";
    document.getElementById('lbl3').textContent = opt3Text || "Option 3";
}
</script>

</body>
</html>
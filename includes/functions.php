<?php
include 'connection.php';


function read_where($table, $condition){
  global $conn;
  $query = "Select * From $table where  $condition and is_deleted=0";
  $result = $conn->query($query)->fetchAll(PDO::FETCH_ASSOC);
  return $result;
}

// print_r(read_where('admin', "Admin_email='Admin@123' and Admin_pass='1234'"));


// function that counts all rows of a specific table
function countRows($table){
  global $conn;
  
  // Define the specific table for handling 'role_id = 2'
  $specificTable = 'users';

  // Check if the table is the specific one
  if ($table === $specificTable) {
      // Retrieve 1 if there are one or more records with role_id = 2, or 0 if none
      $sql = "SELECT COUNT(*) AS total_rows FROM $table WHERE role_id = 2 AND is_deleted = 0";
  } else {
      // Standard query to count rows for other tables
      $sql = "SELECT COUNT(*) as total_rows FROM $table WHERE is_deleted = 0";
  }
  
  $stmt = $conn->query($sql);
  
  if ($stmt) {
      $result = $stmt->fetch(PDO::FETCH_ASSOC);
      return $result['total_rows'];
  } else {
      return 0; // Return 0 if the query fails
  }
}



// function that retrieve all records from a specific table
function read($table , $order ='DESc')
{
    global $conn;
    $sql = "SELECT * FROM $table WHERE is_deleted = 0 order by id $order";
    $result = $conn->query($sql)->fetchAll(PDO::FETCH_ASSOC);
    return $result;
}

//  function that insert data to a specfic table

function insert($table, $data)
{
    global $conn;
    $keys = implode(",", array_keys($data));
    $keyWithColon = ":" . implode(",:", array_keys($data));

    $sql = $conn->prepare("INSERT into $table ($keys) values ($keyWithColon)");
    $sql->execute($data);
    return $sql ? $conn->lastInsertId() : false;
}

// function that update data from specific table

function update($table, $data){
    global $conn;
    $pairs =[];
    foreach(array_keys($data) as $key){
      $pairs[]= $key."=:".$key;
    }
    $keys = implode(",", $pairs);
    // $sql = "update tablename set key=:key , key1=:key1 .... "
    $sql =$conn->prepare( "UPDATE $table SET $keys where id=:id");
    $sql->execute($data);
    return $sql ? true :false;
  }

//   function that data from a specific table

function deleteRecord($table , $data, $id = 'id'){
    global $conn;
    $pairs =[];
    foreach(array_keys($data) as $key){
      $pairs[]= $key."=:".$key;
    }
    $keys = implode(",", $pairs);
    // $sql =$conn->prepare( "Delete from $table where id=:id");
    $sql =$conn->prepare( "update $table set $keys, is_deleted=1 where $id=:id");
    $sql->execute($data);
    return $sql ? true :false;
  }

//   function that retrieve single column from a specified table
function readcolumn($table, $column, $id)
{
    global $conn;
    $sql = "SELECT $column FROM $table WHERE id = :id AND is_deleted = 0";
    $stmt = $conn->prepare($sql);
    $stmt->bindParam(':id', $id, PDO::PARAM_INT);
    $stmt->execute();
    return $stmt->fetchColumn();
}

function getInstructor(){
  global $conn;
  $query = "Select * From users where role_id = 2  and is_deleted=0";
  $result = $conn->query($query)->fetchAll(PDO::FETCH_ASSOC);
  return $result;
}


function GetId($table, $condition) {
  global $conn;
  $query = "SELECT ID FROM $table WHERE $condition AND is_deleted=0";
  $stmt = $conn->prepare($query);
  $stmt->execute(); // No need for bindParam since there's no placeholder in the query
  return $stmt->fetchColumn(); // Fetch the first column (ID) from the result
}

function GetCourseId($table, $condition) {
    global $conn;
    $query = "SELECT ID FROM $table WHERE $condition AND is_deleted=0";
    $stmt = $conn->prepare($query);
    $stmt->execute(); // Execute the query

    // Fetch all results as an array of IDs
    return $stmt->fetchAll(PDO::FETCH_COLUMN, 0); 
}

function calculateScore($user_id, $quiz_id) {
  global $conn;
  // Query to count correct answers based on user's responses
  $stmt = $conn->prepare("
      SELECT COUNT(*) AS correct_answers
      FROM user_responses AS ur
      JOIN answers AS a ON ur.selected_answer_id = a.id
      WHERE ur.user_id = ? AND ur.quiz_id = ? AND a.is_correct = 1
  ");
  $stmt->execute([$user_id, $quiz_id]);
  $result = $stmt->fetch();
  
  // Calculate score
  $score = $result['correct_answers'];
  
  // Get the maximum score (number of questions in the quiz)
  $stmt = $conn->prepare("SELECT COUNT(*) AS total_questions FROM questions WHERE quiz_id = ?");
  $stmt->execute([$quiz_id]);
  $total = $stmt->fetch();
  $max_score = $total['total_questions'];

  // Store the result in quiz_results
  $stmt = $conn->prepare("
      INSERT INTO quiz_results (user_id, quiz_id, score, max_score) VALUES (?, ?, ?, ?)
      ON DUPLICATE KEY UPDATE score = VALUES(score), max_score = VALUES(max_score), completed_at = NOW()
  ");
  $stmt->execute([$user_id, $quiz_id, $score, $max_score]);

  return $score;
}

function getAverageRating($courseId) {
    global $conn;
    $query = "SELECT AVG(rating_number) as avg_rating FROM rating WHERE course_id = :course_id";
    $stmt = $conn->prepare($query);
    $stmt->bindValue(':course_id', $courseId, PDO::PARAM_INT);
    $stmt->execute();
    $result = $stmt->fetch(PDO::FETCH_ASSOC);
    return $result && $result['avg_rating'] ? round($result['avg_rating'], 2) : 'No rating';
}


?>

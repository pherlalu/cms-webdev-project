<?php

include 'db_connect.php';


function addReview($comment)
{
  global $conn;
  $event_id = isset($_GET['event_id']) ? (int) $_GET['event_id'] : 0;
  // Get the current user's name from the session
  $username = $_SESSION['user'];

  // Insert the comment into the database
  $query = "INSERT INTO comments (userID, name, comment, comment_date) VALUES (?, ?, ?, NOW())";
  $stmt = $conn->prepare($query);
  $stmt->execute(array(getCurrentUserID(), $username, $comment));

  // Display the new comment
  echo '
    <div class="media mt-5 mb-4">
      <img src="https://via.placeholder.com/50x50" alt="Reviewer Avatar" class="mr-3 rounded-circle">
      <div class="media-body">
        <h5 class="mt-0 mb-1">' . htmlspecialchars($username) . '</h5>
        <p>' . htmlspecialchars($comment) . '</p>
      </div>
    </div>
  ';

  // Redirect back to the event page
  header("Location: event.php?event_id=" . $event_id . "#comments");
  exit;
}

function getCurrentUserID()
{
  global $conn;
  // Assuming that the user ID is stored in a session variable called "user"
  if (isset($_SESSION['user'])) {
    $username = $_SESSION['user'];
    $stmt = $conn->prepare("SELECT id FROM users WHERE username = ? LIMIT 1");
    $stmt->execute(array($username));
    $user = $stmt->fetch();
    return $user['id'] ?? 0;
  }

  return 0;
}
function getUserNameById($userId)
{
  global $conn;
  if (!$conn) {
    // Handle the error, as the database connection is not available
    // You can throw an exception, return null, or handle the error as appropriate
    return null;
  }

  $query = "SELECT username FROM users WHERE id = :id LIMIT 1";
  $statement = $conn->prepare($query);
  $statement->bindValue(':id', $userId, PDO::PARAM_INT);
  $statement->execute();

  $user = $statement->fetch();

  if ($user) {
    return $user['username'];
  }

  return null;
}

function getCurrentUserName()
{
  $userID = getCurrentUserID();
  if ($userID) {
    // Assuming you have a function to get the username by user ID
    $username = getUserNameById($userID);
    return $username;
  }
  return '';
}

function getUserByID($userID)
{
  global $conn;

  $query = "SELECT * FROM users WHERE id = :userID";
  $statement = $conn->prepare($query);
  $statement->bindValue(':userID', $userID, PDO::PARAM_INT);
  $statement->execute();
  $user = $statement->fetch();

  return $user;
}

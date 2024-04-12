<?php

include 'db_connect.php';

function getCurrentUserID()
{
  global $conn;
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


function validateCaptcha($captchaInput)
{

  if (isset($_SESSION['captcha']) && !empty($_SESSION['captcha'])) {
    if ($_SESSION['captcha'] === $captchaInput) {
      // Captcha is valid
      return true;
    } else {
      // Captcha is not valid
      return false;
    }
  } else {
    // Session variable not set
    return false;
  }
}

function file_is_an_image($temporary_path, $new_path)
{
  $allowed_mime_types      = ['image/gif', 'image/jpeg', 'image/png'];
  $allowed_file_extensions = ['gif', 'jpg', 'jpeg', 'png'];

  $actual_file_extension   = pathinfo($new_path, PATHINFO_EXTENSION);
  $image_info = getimagesize($temporary_path);
  $actual_mime_type = null;
  if ($image_info !== false) {
    $actual_mime_type = $image_info['mime'];
  }

  $file_extension_is_valid = in_array($actual_file_extension, $allowed_file_extensions);
  $mime_type_is_valid      = in_array($actual_mime_type, $allowed_mime_types);

  return $file_extension_is_valid && $mime_type_is_valid;
}
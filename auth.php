<?php

define('PEPPER', 'mypepper');
define('SALTSIZE', 32);
define('HFACTOR', 10); // If changed, all existing hashes must be modified.

include 'user.php';

if (isset($_GET['op']) && $_GET['op'] == 'x') {
    logout();
}
if (isset($_POST['op'])) {
    if (is_logged()) {
        if ($_POST['op'] == 'sdid') {
            set_dep();
        } else {
            goHome();
        }
    }
    switch (strtolower($_POST['op'])[0]) {
    case 'r':
      newuser();
    break;
    case 'l':
      login(false);
    break;
  }
}
////////////////////////////////////////////////////////////////////////////////
function newuser()
{
    $errors = array();
    $return = array();
    $return['success'] = false;
    try {
        include 'db.php';
        
        $username = $_POST['username'];
        $email = $_POST['email'];
        $password = $_POST['password'];

        if (checkUsername($username, $pdo, $errors)) {
            $errors['uerror'] = 'Username already exists.';
        }
        if (checkEmail($email, $pdo, $errors)) {
            $errors['eerror'] = 'Email registered.';
        }
        checkPassword($password, $errors);

        if (empty($errors)) {
            // create the account
          $salt = bin2hex(random_bytes(SALTSIZE / 2)); // 1 byte = 2 hex decimals
          $phash = calcPhash($password, $salt);
          $st = $pdo->prepare('INSERT INTO `users`(`nickname`, `email`, `phash`, `salt`) VALUES (:nickname,:email,:phash,:salt)');
          $data = array(
          ':nickname' => $nickname,
          ':email' => $email,
          ':phash' => $phash,
          ':salt' => $salt,
          );
            if ($st->execute($data)) {
                $return['success'] = true;
            } else {
                throw new Exception(implode(',', $st->errorInfo()));
            }
        }
    } catch (Exception $ex) {
        $errors['serror'] = 'An internal server error has occured. Please try again later.';
          // TODO: log internal errors
    }
    if (!empty($errors)) {
        $return['errors'] = $errors;
    }
    if ($return['success']) {
        login(true);
    }
    echo json_encode($return);
}

function login($silent)
{
    $errors = array();
    $return = array();
    $return['success'] = false;
    try {
        include 'db.php';
        elseif (isset($_POST['email'])) {
            $user = checkEmail($_POST['email'], $pdo, $errors);
            if (!$user) {
                $errors['uerror'] = 'Email not found.';
            }
        } else {
            $errors['serror'] = 'Please provide a valid username or email.';
        }
        if (!isset($_POST['password'])) {
            $errors['perror'] = 'Cannot be empty.';
        }
        if (empty($errors)) {
            // check password
      $phash = $user['phash'];
            if ($phash == calcPhash($_POST['password'], $user['salt'])) {
                $_SESSION['user'] = $user;
                $return['success'] = true;
            } else {
                $errors['perror'] = 'Wrong password.';
            }
        }
    } catch (Exception $ex) {
        $errors['serror'] = 'An internal server error has occured. Please try again later.';
      // TODO: log internal errors
    }
    if (!empty($errors)) {
        $return['errors'] = $errors;
    }
    if (!$silent) {
        echo json_encode($return);
    }
}

function logout()
{
    $_SESSION['user'] = null;
    goHome();
}

function goHome()
{
    header('Location: index.php');
    exit;
}

function checkUsername($username, $pdo, &$errors)
{
    if (preg_match('/[^a-zA-Z0-9_-]/', $username)) {
        $errors['uerror'] = 'Must be alphanumeric and may only contain _ or -.';
    } elseif (strlen($username) < 4) {
        $errors['uerror'] = 'Must be at least 4 characters long.';
    } else {
        $st = $pdo->prepare('SELECT * FROM users WHERE BINARY username=:username');
        if (!$st->execute(array(':username' => $username))) {
            throw new Exception('DB connection failed.');
        } elseif ($st->rowCount() > 0) {
            return $st->fetch(PDO::FETCH_ASSOC);
        }
    }

    return null;
}

function checkEmail($email, $pdo, &$errors)
{
    if (!validateEmail($email)) {
        $errors['eerror'] = 'Invalid email address.';
    } else {
        $st = $pdo->prepare('SELECT * FROM users WHERE BINARY email=:email');
        if (!$st->execute(array(':email' => $email))) {
            throw new Exception('DB connection failed.');
        } elseif ($st->rowCount() > 0) {
            return $st->fetch(PDO::FETCH_ASSOC);
        }
    }

    return null;
}

function checkPassword($password, &$errors)
{
    if (preg_match('/[\s\t]/', $password)) {
        $errors['perror'] = 'Cannot contain empty spaces.';
    } elseif (strlen($password) < 4) {
        $errors['perror'] = 'Must be at least 4 characters long.';
    }
}

function validateEmail($email)
{
    $re = '/^(([^<>()\[\]\\.,;:\s@"]+(\.[^<>()\[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/';

    return preg_match($re, $email);
}

function calcPhash($password, $salt)
{
    $hash = $password;
    for ($i = 0; $i < HFACTOR; ++$i) {
        $hash = hash_hmac('sha256', $salt.$hash, PEPPER);
    }

    return $hash;
}

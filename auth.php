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

        $nickname = $_POST['nickname'];
        $email = $_POST['email'];
        $password = $_POST['password'];
        $fname = $_POST['fname'];
        $lname = $_POST['lname'];
        $gender = $_POST['gender'];
        $mstatus = $_POST['mstatus'];
        $bdate = $_POST['bdate'];
        $country = $_POST['country'];
        $city = $_POST['city'];
        $pcode = $_POST['pcode'];

        if (checkEmail($email, $pdo, $errors)) {
            $errors['eerror'] = 'Email registered.';
        }

        if ($nickname == '') {
            $nickname = $fname.' '.$lname;
        }

        validatePassword($password, $errors);
        validateNickname($nickname, $errors);
        validateName($fname, $lname, $errors);
        validateGender($gender, $errors);
        validateMStatus($mstatus, $errors);
        validateBDate($bdate, $errors);
        $locsup = validateLocation($country, $city, $pcode, $errors);
        if (empty($errors)) {
            if ($locsup) {
                $lid = checkLocation($country, $city, $pcode, $pdo);
            } else {
                $lid = null;
            }
          // create the account
            $salt = bin2hex(random_bytes(SALTSIZE / 2)); // 1 byte = 2 hex decimals
            $phash = calcPhash($password, $salt);
            $st =
            $pdo->prepare(
          'INSERT INTO `user`(`email`,`fname`,`lname`,`nickname`,`phash`,`salt`,`bdate`,`gender`,`mstatus`,`loc`)
           VALUES (:email,:fname,:lname,:nickname,:phash,:salt,:bdate,:gender,:mstatus,:lid)');
            $data = array(
          ':email' => $email,
          ':fname' => $fname,
          ':lname' => $lname,
          ':nickname' => $nickname,
          ':phash' => $phash,
          ':salt' => $salt,
          ':bdate' => $bdate,
          ':gender' => $gender,
          ':mstatus' => $mstatus,
          ':lid' => $lid,
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
        if (isset($_POST['email'])) {
            $user = checkEmail($_POST['email'], $pdo, $errors);
            if (!$user) {
                $errors['uerror'] = 'Email not found.';
            }
        } else {
            $errors['serror'] = 'Please provide a valid email.';
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

function checkEmail($email, $pdo, &$errors)
{
    if (!validateEmail($email)) {
        $errors['eerror'] = 'Invalid email address.';
    } else {
        $st = $pdo->prepare('SELECT * FROM user WHERE BINARY email=:email');
        if (!$st->execute(array(':email' => $email))) {
            throw new Exception('DB connection failed. (~cE)');
        } elseif ($st->rowCount() > 0) {
            return $st->fetch(PDO::FETCH_ASSOC);
        }
    }

    return null;
}

function checkLocation($country, $city, $pcode, $pdo)
{
    $st = $pdo->prepare('SELECT lid FROM location WHERE BINARY country=:country AND city=:city AND pcode=:pcode');
    if (!$st->execute(array(':country' => $country, ':city' => $city, ':pcode' => $pcode))) {
        throw new Exception('DB connection failed. (~cE)');
    } elseif ($st->rowCount() > 0) {
        return $st->fetch(PDO::FETCH_ASSOC)['lid'];
    }
    $st = $pdo->prepare('INSERT INTO `location` (`country`,`city`,`pcode`) VALUES(:country,:city,:pcode)');
    if (!$st->execute(array(':country' => $country, ':city' => $city, ':pcode' => $pcode))) {
        throw new Exception('DB connection failed. (~cE)');
    } else {
        return checkLocation($country, $city, $pcode, $pdo);
    }
}

function validatePassword($password, &$errors)
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

function validateNickname($nickname, &$errors)
{
}

function validateName($fname, $lname, &$errors)
{
    if (strlen($fname) < 4 || strlen($lname) < 4) {
        $errors['nerror'] = 'First and Last name must be at least 4 characters long.';
    }
}
function validateGender(&$gender, &$errors)
{
    if (!isset($gender) || $gender > 2 || $gender < 0) {
        $errors['gerror'] = 'Invalid gender selection.';
    } else {
        switch ($gender) {
        case 0:
          $gender = 'u';
        break;
        case 1:
          $gender = 'm';
        break;
        case 2:
          $gender = 'f';
        break;
      }
    }
}
function validateMStatus(&$mstatus, &$errors)
{
    if (!isset($mstatus) || $mstatus > 3 || $mstatus < 0) {
        $errors['mserror'] = 'Invalid status selection.';
    } else {
        switch ($mstatus) {
        case 0:
          $mstatus = 'u';
        break;
        case 1:
          $mstatus = 's';
        break;
        case 2:
          $mstatus = 'e';
        break;
        case 3:
          $mstatus = 'm';
        break;
      }
    }
}
function validateBDate($bdate, &$errors)
{
    if ($bdate) {
        if (!((bool) strtotime($bdate))) {
            $errors['bderror'] = 'Invalid date.';
        }
    } else {
        $errors['bderror'] = 'You must supply your birth date.';
    }
}

function validateLocation($country, $city, $pcode, &$errors)
{
    if ($country && $city && $pcode) {
        if (!is_numeric($pcode) || $pcode < 0) {
            $errors['lerror'] = 'Invalid location.';
        }

        return empty($errors['lerror']);
    }

    return false;
}

function calcPhash($password, $salt)
{
    $hash = $password;
    for ($i = 0; $i < HFACTOR; ++$i) {
        $hash = hash_hmac('sha256', $salt.$hash, PEPPER);
    }

    return $hash;
}

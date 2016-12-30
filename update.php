<?php
define('PEPPER', 'mypepper');
define('SALTSIZE', 32);
define('HFACTOR', 10); // If changed, all existing hashes must be modified.
include 'core.php';

include 'db.php';

$user = get_user();
$errors = array();
$return = array();
$return['success'] = false;
$nickname = $_POST['nickname'];
$email = $_POST['email'];
$password = $_POST['password'];
$gender = intval($_POST['gender']);
$mstatus = $_POST['mstatus'];
$about = $_POST['about'];
validatePassword($password, $errors);
validateNickname($nickname, $errors);
validateGender($gender, $errors);
validateMStatus($mstatus, $errors);
$salt = bin2hex(random_bytes(SALTSIZE / 2));
$phash = calcPhash($password, $salt);

if (empty($errors)) {
	$st = $pdo->prepare('UPDATE user SET email=:email,nickname=:nickname,phash=:phash,salt=:salt,gender=:gender,mstatus=:mstatus,about=:about WHERE uid=:uid');
	$data = array(
		':email' => $email,
		':nickname' => $nickname,
		':gender' => $gender,
		':phash' => $phash,
		':salt' => $salt,
		':mstatus' => $mstatus,
		':about' => $about,
		':uid' => $user['uid']
	);
	if ($st->execute($data)) {
		$_SESSION['user']['email'] = $email;
		$_SESSION['user']['nickname'] = $nickname;
		$_SESSION['user']['gender'] = $gender;
		$_SESSION['user']['phash'] = $phash;
		$_SESSION['user']['salt'] = $salt;
		$_SESSION['user']['mstatus'] = $mstatus;
		$_SESSION['user']['about'] = $about;
		$return['success'] = true;
	}
	else {
		throw new Exception(implode(',', $st->errorInfo()));
	}
}

echo json_encode($return);

function validatePassword($password, &$errors)
{
	if (preg_match('/[\s\t]/', $password)) {
		$errors['perror'] = 'Cannot contain empty spaces.';
	}
	elseif (strlen($password) < 4) {
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

function validateGender(&$gender, &$errors)
{
	if (!isset($gender) || $gender > 2 || $gender < 0) {
		$errors['gerror'] = 'Invalid gender selection.';
	}
	else {
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
	}
	else {
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

function calcPhash($password, $salt)
{
	$hash = $password;
	for ($i = 0; $i < HFACTOR; ++$i) {
		$hash = hash_hmac('sha256', $salt . $hash, PEPPER);
	}

	return $hash;
}

?>
<!-- display all requests if $_GET['r'] and display all friends if $_GET['l'] -->
<?php
include_once 'db.php';
include_once 'user.php';

if (is_logged()) {
    if (isset($_GET['r'])) {
        $uid = get_user()['uid'];
        // display all friend requests
		$requests = fetch_requests($_GET['r'], $uid, $pdo);
		if ($requests) {
			echo '<br/><br/><hr><h3 style="margin-bottom:-10px;">Friend requests</h3>';
			foreach ($requests as $request) {
				$requester = fetch_requester($request['uid1'], $pdo);
				if($requester['uid'] == $uid){ // if the current user made the request
					echo 'Pending.';
					$requester = fetch_requester($request['uid2'], $pdo);
					$requester_name = $requester['fname'].' '.$requester['lname'].' ('.$requester['nickname'].')';
					$requester_photo = $requester['photo'];
					$request_time = $request['_time'];
					echo '<br/><br/>'/*'<a href="link to user">*/'<img src="' $requester_photo '"> '/*</a> '*/.$requester_name.' at '.$request_time;
					echo '<button id="cancelReq" onclick="cancel()">Cancel</button>';
				}
				else{ // a request towards the active user
					$requester_name = $requester['fname'].' '.$requester['lname'].' ('.$requester['nickname'].')';
					$requester_photo = $requester['photo'];
					$request_time = $request['_time'];
					echo '<br/><br/>'/*'<a href="link to user">*/'<img src=\"' $requester_photo '\"height="50" width="50"> '/*</a> '*/.$requester_name.' at '.$request_time;
					echo '<button id="acceptReq" onclick="accept()">Accept</button> <button id="ignoreReq" onclick="ignore()">Ignore</button>';
					echo '<button id="blockUser" onclick="block()">Block</button>';
				}
			}
		else
			echo '<br/><br/><hr><h3 style="margin-bottom:-10px;">No one wants to befriend you. HA!</h3>';
		}
	}
	else
		echo 'Error retrieving requests.';
}

if (isset($_GET['l'])) {
    if (isset($_GET['uid'])) {
        $uid = $_GET['uid'];
    } elseif (is_logged()) {
        $uid = get_user()['uid'];
    } else {
        echo 'Invalid request.';
        die();
    }
    // display friend list of $uid
	$friends = fetch_friends($_GET['l'], $uid, $pdo);
		if ($friends) {
			echo '<br/><br/><hr><h3 style="margin-bottom:-10px;">Friends</h3>';
			foreach ($friends as $friend) {
				$fetched_friend = fetch_friend($friend['uid1'], $pdo); 
				if($fetched_friend['uid'] == $uid){ // if the current user is the fetched friend
					$fetched_friend = fetch_friend($friend['uid2'], $pdo);
				$friend_name = $fetched_friend['fname'].' '.$fetched_friend['lname'].' ('.$fetched_friend['nickname'].')';
				$friend_photo = $fetched_friend['photo'];
				$friend_time = $friend['_time'];
				echo '<br/><br/>''<img src=\"' $friend_photo '\"height="50" width="50"> '.$friend_name.' since '.$friend_time; // _time igets updated to time of acceptance ? 
			}
		}
}

// fetch requests uses accept = 0 
// fetch friends uses accept = 1

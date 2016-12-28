<!-- display all requests if $_GET['r'] and display all friends if $_GET['l'] -->
<?php
if (!isset($_GET['aj'])):
 ?>
 <script src="js/friends.js"></script>
 <container id='friends'>
<?php
endif;
include_once 'db.php';
include_once 'user.php';

if (is_logged()) {
    if (isset($_GET['r'])) {
        $uid = get_user()['uid'];
        // display all friend requests
        $requests = fetch_sent_requests($pdo);
        if ($requests) {
            echo '<br/><br/><hr><h3 style="margin-bottom:-10px;">Friend requests</h3>';
            echo '<br/><br/>Pending.';
            foreach ($requests as $request) {
                $name = $request['fname'].' '.$request['lname'].' ('.$request['nickname'].')';
                $pic = 'image/pic_'.$uid.'.png';
                if (!file_exists($pic)) {
                    $pic = "./image/def_{$request['gender']}.jpg";
                }
                $request_time = $request['_time'];
                echo "<br/><br/> <img src='{$pic}' height='50' width='50'>".$name.' at '.$request_time;
                echo '<button id="cancelReq" onclick="cancel()">Cancel</button>';
            }
        }
        $requests = fetch_friend_requests($pdo);
        if ($requests) {
            echo '<br/><br/>Those people want to be your friend!';
            foreach ($requests as $request) {
                $name = $request['fname'].' '.$request['lname'].' ('.$request['nickname'].')';
                $pic = 'image/pic_'.$uid.'.png';
                if (!file_exists($pic)) {
                    $pic = "./image/def_{$request['gender']}.jpg";
                }
                $request_time = $request['_time'];
                echo "<br/><br/> <img src='{$pic}' height='50' width='50'>".$name.' at '.$request_time;
                echo "<button id='rejReq' onclick='reject({$request['uid']})'>Reject</button>";
            }
        } else {
            echo '<br/><br/><hr><h3 style="margin-bottom:-10px;">No one wants to befriend you. HA!</h3>';
        }
    } else {
        echo 'Error retrieving requests.';
    }
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
    $friends = fetch_friends($uid, $pdo);
    if ($friends) {
        echo '<br/><br/><hr><h3 style="margin-bottom:-10px;">Friends</h3>';
        foreach ($friends as $friend) {
            $friend_name = $friend['fname'].' '.$friend['lname'].' ('.$friend['nickname'].')';
            $friend_time = $friend['_time'];
            $uid = $friend['uid'];
            $pic = 'image/pic_'.$uid.'.png';
            if (!file_exists($pic)) {
                $pic = "./image/def_{$friend['gender']}.jpg";
            }
            echo "<br/><br/><img src='{$pic}' height='50' width='50'>".$friend_name.' since '.$friend_time; // _time igets updated to time of acceptance ?
        }
    }
}

if (!isset($_GET['aj'])) {
    echo '</container>';
}

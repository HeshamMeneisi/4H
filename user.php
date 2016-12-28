<?php

session_start();

function is_logged()
{
    return isset($_SESSION['user']);
}

function get_user()
{
    return $_SESSION['user'];
}

// This function returns a post fetched via post id

function fetch_post($post_id, $puid, $pdo)
{
    $post_fetcher = $pdo->prepare('SELECT * FROM post WHERE puid=:puid AND pid=:pid');
    if (!$post_fetcher->execute(array(
        ':pid' => $post_id,
        ':puid' => $puid,
    ))) {
        throw new Exception('DB connection failed.');
    } elseif ($post_fetcher->rowCount() == 1) {
        return $post_fetcher->fetch(PDO::FETCH_ASSOC);
    }
}

// This function returns the name fields fetched via user id

function fetch_name($user_id, $pdo)
{
    $name_fetcher = $pdo->prepare('SELECT fname,lname,nickname FROM user WHERE uid=:uid');
    if (!$name_fetcher->execute(array(
        ':uid' => $user_id,
    ))) {
        throw new Exception('DB connection failed.');
    } elseif ($name_fetcher->rowCount() == 1) {
        return $name_fetcher->fetch(PDO::FETCH_ASSOC);
    }
}

// This function returns the likes of a post fetched via post id

function fetch_likes($post_id, $puid, $pdo)
{
    $fetched_likes_fetcher = $pdo->prepare('SELECT uid FROM likes_post WHERE puid=:puid AND pid=:pid');
    if (!$fetched_likes_fetcher->execute(array(
        ':pid' => $post_id,
        ':puid' => $puid,
    ))) {
        throw new Exception('DB connection failed.');
    } elseif ($fetched_likes_fetcher->rowCount() > 0) {
        return $fetched_likes_fetcher;
    }

    return null;
}

function fetch_commenter_name($user_id, $pdo)
{
    $name_fetcher = $pdo->prepare('SELECT fname,lname,nickname FROM user WHERE uid=:uid');
    if (!$name_fetcher->execute(array(
        ':uid' => $user_id,
    ))) {
        throw new Exception('DB connection failed.');
    } elseif ($name_fetcher->rowCount() == 1) {
        return $name_fetcher->fetch(PDO::FETCH_ASSOC);
    }
}

// This function returns the comments of a post fetched via post id

function fetch_comments($post_id, $puid, $pdo)
{
    $comments_fetcher = $pdo->prepare('SELECT * FROM comment WHERE puid=:puid AND pid=:pid');
    if (!$comments_fetcher->execute(array(
        ':pid' => $post_id,
        ':puid' => $puid,
    ))) {
        throw new Exception('DB connection failed.');
    } elseif ($comments_fetcher->rowCount() > 0) {
        return $comments_fetcher->fetchAll(PDO::FETCH_ASSOC);
    }

    return null;
}

// This function returns the likes of a comment fetched via post id

function fetch_comment_likes($puid, $pid, $comment_id, $pdo)
{
    $comment_likes_fetcher = $pdo->prepare('SELECT uid FROM likes_comment WHERE puid=:puid AND pid=:pid AND cid=:cid');
    if (!$comment_likes_fetcher->execute(array(
        ':cid' => $comment_id,
        ':pid' => $pid,
        ':puid' => $puid,
    ))) {
        throw new Exception('DB connection failed.');
    } elseif ($comment_likes_fetcher->rowCount() > 0) {
        return $comment_likes_fetcher;
    }

    return null;
}

function fetch_most_commented($pdo)
{
    $st = $pdo->query('SELECT *  FROM (SELECT COUNT(*) AS c ,puid,pid FROM `comment` GROUP BY puid,pid) y, post WHERE post.puid=y.puid AND post.pid=y.pid AND privacy=0 HAVING MAX(y.c)');
    if ($st->rowCount() == 1) {
        return $st->fetch(PDO::FETCH_ASSOC);
    }

    return null;
}

function fetch_most_liked($pdo)
{
    $st = $pdo->query('SELECT *  FROM (SELECT COUNT(*) AS c ,puid,pid FROM `likes_post` GROUP BY puid,pid) y, post WHERE post.puid=y.puid AND post.pid=y.pid AND privacy=0 HAVING MAX(y.c)');
    if ($st->rowCount() == 1) {
        return $st->fetch(PDO::FETCH_ASSOC);
    }

    return null;
}

function fetch_friends($uid, $pdo)
{
    $st = $pdo->prepare('SELECT `user`.*, _time FROM `friends` INNER JOIN `user` ON `user`.uid=`friends`.uid1 WHERE accepted=1 AND uid2=:uid UNION (SELECT `user`.*, _time FROM `friends` INNER JOIN `user` ON `user`.uid=`friends`.uid2  WHERE accepted=1 AND uid1=:uid)');
    if ($st->execute(array(':uid' => $uid))) {
        return $st->fetchAll(PDO::FETCH_ASSOC);
    }

    return null;
}

function is_friend($uid, $pdo)
{
    $ownuid = get_user()['uid'];
    if ($ownuid == $uid) {
        return true;
    }
    $st = $pdo->prepare('SELECT uid FROM `friends` WHERE accepted=1 AND (uid1=:uid1 AND uid2=:uid2) OR (uid1=:uid2 AND uid2=:uid1)');
    if ($st->execute(array(':uid1' => $ownuid, ':uid2' => $uid)) && $st->rowCount() > 0) {
        return true;
    }

    return false;
}

function fetch_sent_requests($pdo)
{
    $uid = get_user()['uid'];
    $st = $pdo->prepare('SELECT `user`.* ,_time FROM `friends` INNER JOIN `user` ON `user`.uid=`friends`.uid2 WHERE accepted=0 AND uid1=:uid');
    if ($st->execute(array(':uid' => $uid))) {
        return $st->fetchAll(PDO::FETCH_ASSOC);
    }

    return null;
}

function fetch_friend_requests($pdo)
{
    $uid = get_user()['uid'];
    $st = $pdo->prepare('SELECT `user`.* ,_time FROM `friends` INNER JOIN `user` ON `user`.uid=`friends`.uid1 WHERE accepted=0 AND uid2=:uid');
    if ($st->execute(array(':uid' => $uid))) {
        return $st->fetchAll(PDO::FETCH_ASSOC);
    }

    return null;
}

function fetch_recent_friend_posts($pdo)
{
    $uid = get_user()['uid'];
    $st = $pdo->prepare('SELECT * FROM post INNER JOIN (SELECT uid1 as puid FROM `friends` WHERE accepted=1 AND uid2 = :uid UNION (SELECT uid2 as puid FROM `friends` WHERE accepted=1 AND uid1 = :uid))y USING (puid) ORDER BY ptime DESC LIMIT 25');
    if ($st->execute(array(':uid' => $uid))) {
        return $st->fetchAll(PDO::FETCH_ASSOC);
    }

    return null;
}

function fetch_posts_matching($query, $pdo)
{
    $uid = get_user()['uid'];
    $query = '%'.$query.'%';
    $st = $pdo->prepare('SELECT * FROM (SELECT uid1 as puid FROM `friends` WHERE accepted=1 AND uid2 = :uid UNION (SELECT uid2 as puid FROM `friends` WHERE accepted=1 AND uid1 = :uid)) y, post WHERE (privacy=0 OR post.puid=y.puid) AND caption like :q GROUP BY post.puid,post.pid ORDER BY ptime DESC LIMIT 25');
    if ($st->execute(array(':uid' => $uid, ':q' => $query))) {
        return $st->fetchAll(PDO::FETCH_ASSOC);
    }

    return null;
}

function fetch_user_with_email($email, $pdo)
{
    $st = $pdo->prepare('SELECT * FROM user WHERE email=:email');
    if (!$st->execute(array(
      ':email' => $email,
  ))) {
        throw new Exception('DB connection failed.');
    } elseif ($st->rowCount() == 1) {
        return $st->fetch(PDO::FETCH_ASSOC);
    }

    return null;
}

function fetch_users_with_name($fname, $lname, $pdo)
{
    $sql = 'SELECT * FROM user WHERE fname=:fname';
    $parm = array(
    ':fname' => $fname, );
    if ($lname) {
        $sql .= ' AND lname=:lname';
        $parm[':lname'] = $lname;
    }
    $st = $pdo->prepare($sql);
    if (!$st->execute($parm)) {
        throw new Exception('DB connection failed.');
    } elseif ($st->rowCount() > 0) {
        return $st->fetchALL(PDO::FETCH_ASSOC);
    }

    return null;
}

function fetch_users_in($city, $country, $pdo)
{
    $sql = 'SELECT user.* FROM location INNER JOIN user ON lid=loc WHERE city=:city';
    $parm = array(
    ':city' => $city, );
    if ($country) {
        $sql .= ' AND country=:country';
        $parm[':country'] = $country;
    }
    $st = $pdo->prepare($sql);
    if (!$st->execute($parm)) {
        throw new Exception('DB connection failed.');
    } elseif ($st->rowCount() > 0) {
        return $st->fetchALL(PDO::FETCH_ASSOC);
    }

    return null;
}

function fetch_loc($uid, $pdo)
{
    $st = $pdo->prepare('SELECT location.* FROM user INNER JOIN location ON lid=loc WHERE uid=:uid');
    if (!$st->execute(array(
      ':uid' => $uid,
    ))) {
        throw new Exception('DB connection failed.');
    } elseif ($st->rowCount() == 1) {
        return $st->fetch(PDO::FETCH_ASSOC);
    }

    return null;
}

function fetch_phones($uid, $pdo)
{
    $st = $pdo->prepare('SELECT phone FROM user_phone WHERE uid=:uid');
    if (!$st->execute(array(
      ':uid' => $uid,
    ))) {
        throw new Exception('DB connection failed.');
    } elseif ($st->rowCount() > 0) {
        return $st->fetchAll(PDO::FETCH_ASSOC);
    }

    return null;
}

function create_notf_add($uid, $pdo)
{
    $pdo->prepare(
    'INSERT INTO `notification`(`uid`,`seen`,`iuid`,`type`,`_time`)
    VALUES (:uid, 0, :iuid, 0, NOW())');
    $data = array(
    ':uid' => $uid,
    ':iuid' => get_user()['uid'],
);
}
function create_notf_acc($uid, $pdo)
{
    $pdo->prepare(
  'INSERT INTO `notification`(`uid`,`seen`,`iuid`,`type`,`_time`)
  VALUES (:uid, 0, :iuid, 1, NOW())');
    $data = array(
  ':uid' => $uid,
  ':iuid' => get_user()['uid'],
);
}

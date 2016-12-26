DROP DATABASE 4h;
CREATE DATABASE 4h;
use 4h;
CREATE TABLE `location`
(
	lid bigint NOT null PRIMARY KEY AUTO_INCREMENT,
    city varchar(100) NOT null,
    country varchar(100) NOT null,
    pcode int NOT null
);

CREATE TABLE `user`
(
    uid bigint NOT null PRIMARY KEY AUTO_INCREMENT,
    fname varchar(50) NOT null,
    lname varchar(50) NOT null,
    nickname varchar(50) NOT null,
    bdate date NOT null,
    email varchar(255) NOT null,    
    gender bit(2) NOT null,
    phash varchar(64) NOT null,
    salt varchar(32) NOT null,
	mstatus bit(2),
    loc bigint,
    photo bigint,
    about varchar(300),
    UNIQUE KEY (email),
    FOREIGN KEY (loc) REFERENCES location (lid) ON DELETE CASCADE ON UPDATE CASCADE
);

CREATE TABLE `user_phone`
(
	uid bigint NOT null,
    phone bigint NOT null,
    PRIMARY KEY (uid, phone),
    FOREIGN KEY (uid) REFERENCES user (uid) ON DELETE CASCADE ON UPDATE CASCADE
);

CREATE TABLE `post`
(
	puid bigint NOT null,
    pid bigint NOT null AUTO_INCREMENT,
    caption varchar(1000) NOT null,
    privacy bit(1) NOT null,
    ptime DateTime NOT null,
    img bigint,
    PRIMARY KEY (pid, puid),
    FOREIGN KEY (puid) REFERENCES user (uid) ON DELETE CASCADE ON UPDATE CASCADE
);

CREATE TABLE `comment`
(
    cuid bigint NOT null,
    puid bigint NOT null,
    pid bigint NOT null,
    cid bigint NOT null AUTO_INCREMENT,
    caption varchar(1000) NOT null,
    ctime DateTime NOT null,
    PRIMARY KEY (cid, pid, puid),
    FOREIGN KEY (cuid) REFERENCES user (uid) ON DELETE CASCADE ON UPDATE CASCADE,
    FOREIGN KEY (pid, puid) REFERENCES post (pid, puid) ON DELETE CASCADE ON UPDATE CASCADE
);

CREATE TABLE `friends`
(
    uid1 bigint NOT null,
    uid2 bigint NOT null,
    accepted bit(1) NOT null,
    _time DateTime NOT null,
    PRIMARY KEY (uid1, uid2),
    FOREIGN KEY (uid1) REFERENCES user (uid) ON DELETE CASCADE ON UPDATE CASCADE,
    FOREIGN KEY (uid2) REFERENCES user (uid) ON DELETE CASCADE ON UPDATE CASCADE
);

CREATE TABLE `likes_post`
(
    uid bigint NOT null,
    puid bigint NOT null,
    pid bigint NOT null,
    PRIMARY KEY (uid, pid, puid),
    FOREIGN KEY (uid) REFERENCES user (uid) ON DELETE CASCADE ON UPDATE CASCADE,
    FOREIGN KEY (pid, puid) REFERENCES post (pid, puid) ON DELETE CASCADE ON UPDATE CASCADE
);

CREATE TABLE `likes_comment`
(
    uid bigint NOT null,
    puid bigint NOT null,
    pid bigint NOT null,
    cid bigint NOT null,
    PRIMARY KEY (uid, pid, puid, cid),
    FOREIGN KEY (uid) REFERENCES user (uid) ON DELETE CASCADE ON UPDATE CASCADE,
    FOREIGN KEY (pid, puid) REFERENCES post (pid, puid) ON DELETE CASCADE ON UPDATE CASCADE,
    FOREIGN KEY (pid, puid, cid) REFERENCES comment (pid, puid, cid) ON DELETE CASCADE ON UPDATE CASCADE
);

CREATE TABLE `notification`
(
	nid bigint NOT null AUTO_INCREMENT,
    uid bigint NOT null,
    _time DateTime NOT null,
    seen BIT(1) NOT null,
    iuid bigint NOT null,
    type bit(3) NOT null,
    pid bigint,
    cid bigint,
    PRIMARY KEY (nid, uid),
    FOREIGN KEY (uid) REFERENCES user (uid) ON DELETE CASCADE ON UPDATE CASCADE,
    FOREIGN KEY (iuid) REFERENCES user (uid) ON DELETE CASCADE ON UPDATE CASCADE,
    FOREIGN KEY (iuid, pid) REFERENCES post (pid, puid) ON DELETE CASCADE ON UPDATE CASCADE
);
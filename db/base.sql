DROP DATABASE 4h;
CREATE DATABASE 4h;
use 4h;
CREATE TABLE `location`
(
	lid bigint NOT null PRIMARY KEY,
    city varchar(100) NOT null,
    country varchar(100) NOT null,
    pcode int NOT null
);

CREATE TABLE `user`
(
    uid bigint NOT null PRIMARY KEY,
    fname varchar(50) NOT null,
    lname varchar(50) NOT null,
    nickname varchar(50) NOT null,
    bdate date NOT null,
    email varchar(255) NOT null,    
    gender bit(1) NOT null,
    phash varchar(64) NOT null,
    salt varchar(32) NOT null,
    loc bigint,
    photo bigint,
    about varchar(300),
    mstatus bit(2),
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
    pid bigint NOT null,
    caption varchar(1000) NOT null,
    privacy bit(1) NOT null,
    ptime DateTime NOT null,
    img bigint,
    PRIMARY KEY (puid, pid),
    FOREIGN KEY (puid) REFERENCES user (uid) ON DELETE CASCADE ON UPDATE CASCADE
);

CREATE TABLE `comment`
(
    cuid bigint NOT null,
    puid bigint NOT null,
    pid bigint NOT null,
    cid bigint NOT null,
    caption varchar(1000) NOT null,
    PRIMARY KEY (puid, pid, cid),
    FOREIGN KEY (cuid) REFERENCES user (uid) ON DELETE CASCADE ON UPDATE CASCADE,
    FOREIGN KEY (puid, pid) REFERENCES post (puid, pid) ON DELETE CASCADE ON UPDATE CASCADE
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
    PRIMARY KEY (uid, puid, pid),
    FOREIGN KEY (uid) REFERENCES user (uid) ON DELETE CASCADE ON UPDATE CASCADE,
    FOREIGN KEY (puid, pid) REFERENCES post (puid, pid) ON DELETE CASCADE ON UPDATE CASCADE
);

CREATE TABLE `likes_comment`
(
    uid bigint NOT null,
    puid bigint NOT null,
    pid bigint NOT null,
    cid bigint NOT null,
    PRIMARY KEY (uid, puid, pid, cid),
    FOREIGN KEY (uid) REFERENCES user (uid) ON DELETE CASCADE ON UPDATE CASCADE,
    FOREIGN KEY (puid, pid) REFERENCES post (puid, pid) ON DELETE CASCADE ON UPDATE CASCADE,
    FOREIGN KEY (puid, pid, cid) REFERENCES comment (puid, pid, cid) ON DELETE CASCADE ON UPDATE CASCADE
);

CREATE TABLE `notification`
(
	nid bigint NOT null,
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
    FOREIGN KEY (iuid, pid) REFERENCES post (puid, pid) ON DELETE CASCADE ON UPDATE CASCADE
);
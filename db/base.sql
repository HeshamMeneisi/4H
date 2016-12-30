SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";
CREATE DATABASE `hallo`;
USE `hallo`;
CREATE TABLE `comment` (
  `cuid` bigint(20) NOT NULL,
  `puid` bigint(20) NOT NULL,
  `pid` bigint(20) NOT NULL,
  `cid` bigint(20) NOT NULL,
  `caption` varchar(1000) NOT NULL,
  `ctime` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

CREATE TABLE `friends` (
  `uid1` bigint(20) NOT NULL,
  `uid2` bigint(20) NOT NULL,
  `accepted` bit(1) NOT NULL,
  `_time` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

CREATE TABLE `likes_comment` (
  `uid` bigint(20) NOT NULL,
  `puid` bigint(20) NOT NULL,
  `pid` bigint(20) NOT NULL,
  `cid` bigint(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

CREATE TABLE `likes_post` (
  `uid` bigint(20) NOT NULL,
  `puid` bigint(20) NOT NULL,
  `pid` bigint(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

CREATE TABLE `location` (
  `lid` bigint(20) NOT NULL,
  `city` varchar(100) NOT NULL,
  `country` varchar(100) NOT NULL,
  `pcode` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

CREATE TABLE `notification` (
  `nid` bigint(20) NOT NULL,
  `uid` bigint(20) NOT NULL,
  `_time` datetime NOT NULL,
  `seen` bit(1) NOT NULL,
  `iuid` bigint(20) NOT NULL,
  `type` bit(3) NOT NULL,
  `pid` bigint(20) DEFAULT NULL,
  `cid` bigint(20) DEFAULT NULL,
  `cpuid` bigint(20) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

CREATE TABLE `post` (
  `puid` bigint(20) NOT NULL,
  `pid` bigint(20) NOT NULL,
  `caption` varchar(1000) NOT NULL,
  `privacy` bit(1) NOT NULL,
  `ptime` datetime NOT NULL,
  `img` bigint(20) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

CREATE TABLE `user` (
  `uid` bigint(20) NOT NULL,
  `fname` varchar(50) NOT NULL,
  `lname` varchar(50) NOT NULL,
  `nickname` varchar(50) NOT NULL,
  `bdate` date NOT NULL,
  `email` varchar(255) NOT NULL,
  `gender` enum('m','f','u') NOT NULL,
  `phash` varchar(64) NOT NULL,
  `salt` varchar(32) NOT NULL,
  `mstatus` enum('s','e','m','u') DEFAULT NULL,
  `loc` bigint(20) DEFAULT NULL,
  `photo` tinyint(1) DEFAULT NULL,
  `about` varchar(300) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

CREATE TABLE `user_phone` (
  `uid` bigint(20) NOT NULL,
  `phone` bigint(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;


ALTER TABLE `comment`
  ADD PRIMARY KEY (`cid`,`pid`,`puid`),
  ADD KEY `cuid` (`cuid`),
  ADD KEY `pid` (`pid`,`puid`);

ALTER TABLE `friends`
  ADD PRIMARY KEY (`uid1`,`uid2`),
  ADD KEY `uid2` (`uid2`);

ALTER TABLE `likes_comment`
  ADD PRIMARY KEY (`uid`,`pid`,`puid`,`cid`),
  ADD KEY `pid` (`pid`,`puid`,`cid`);

ALTER TABLE `likes_post`
  ADD PRIMARY KEY (`uid`,`pid`,`puid`),
  ADD KEY `pid` (`pid`,`puid`);

ALTER TABLE `location`
  ADD PRIMARY KEY (`lid`);

ALTER TABLE `notification`
  ADD PRIMARY KEY (`nid`,`uid`),
  ADD KEY `uid` (`uid`),
  ADD KEY `iuid` (`iuid`,`pid`);

ALTER TABLE `post`
  ADD PRIMARY KEY (`pid`,`puid`),
  ADD KEY `puid` (`puid`);

ALTER TABLE `user`
  ADD PRIMARY KEY (`uid`),
  ADD UNIQUE KEY `email` (`email`),
  ADD KEY `loc` (`loc`);

ALTER TABLE `user_phone`
  ADD PRIMARY KEY (`uid`,`phone`);


ALTER TABLE `comment`
  MODIFY `cid` bigint(20) NOT NULL AUTO_INCREMENT;
ALTER TABLE `location`
  MODIFY `lid` bigint(20) NOT NULL AUTO_INCREMENT;
ALTER TABLE `notification`
  MODIFY `nid` bigint(20) NOT NULL AUTO_INCREMENT;
ALTER TABLE `post`
  MODIFY `pid` bigint(20) NOT NULL AUTO_INCREMENT;
ALTER TABLE `user`
  MODIFY `uid` bigint(20) NOT NULL AUTO_INCREMENT;

ALTER TABLE `comment`
  ADD CONSTRAINT `comment_ibfk_1` FOREIGN KEY (`cuid`) REFERENCES `user` (`uid`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `comment_ibfk_2` FOREIGN KEY (`pid`, `puid`) REFERENCES `post` (`pid`, `puid`) ON DELETE CASCADE ON UPDATE CASCADE;

ALTER TABLE `friends`
  ADD CONSTRAINT `friends_ibfk_1` FOREIGN KEY (`uid1`) REFERENCES `user` (`uid`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `friends_ibfk_2` FOREIGN KEY (`uid2`) REFERENCES `user` (`uid`) ON DELETE CASCADE ON UPDATE CASCADE;

ALTER TABLE `likes_comment`
  ADD CONSTRAINT `likes_comment_ibfk_1` FOREIGN KEY (`uid`) REFERENCES `user` (`uid`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `likes_comment_ibfk_2` FOREIGN KEY (`pid`, `puid`) REFERENCES `post` (`pid`, `puid`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `likes_comment_ibfk_3` FOREIGN KEY (`pid`, `puid`, `cid`) REFERENCES `comment` (`pid`, `puid`, `cid`) ON DELETE CASCADE ON UPDATE CASCADE;

ALTER TABLE `likes_post`
  ADD CONSTRAINT `likes_post_ibfk_1` FOREIGN KEY (`uid`) REFERENCES `user` (`uid`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `likes_post_ibfk_2` FOREIGN KEY (`pid`, `puid`) REFERENCES `post` (`pid`, `puid`) ON DELETE CASCADE ON UPDATE CASCADE;

ALTER TABLE `notification`
  ADD CONSTRAINT `notification_ibfk_1` FOREIGN KEY (`uid`) REFERENCES `user` (`uid`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `notification_ibfk_2` FOREIGN KEY (`iuid`) REFERENCES `user` (`uid`) ON DELETE CASCADE ON UPDATE CASCADE;

ALTER TABLE `post`
  ADD CONSTRAINT `post_ibfk_1` FOREIGN KEY (`puid`) REFERENCES `user` (`uid`) ON DELETE CASCADE ON UPDATE CASCADE;

ALTER TABLE `user`
  ADD CONSTRAINT `user_ibfk_1` FOREIGN KEY (`loc`) REFERENCES `location` (`lid`) ON DELETE CASCADE ON UPDATE CASCADE;

ALTER TABLE `user_phone`
  ADD CONSTRAINT `user_phone_ibfk_1` FOREIGN KEY (`uid`) REFERENCES `user` (`uid`) ON DELETE CASCADE ON UPDATE CASCADE;

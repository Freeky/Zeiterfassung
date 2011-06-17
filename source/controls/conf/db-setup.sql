-- SQL-Script for Database Setup

-- ToDo: create database
-- ToDo: Database-User creation

-- user Table

CREATE  TABLE `timetraveler`.`user` (
  `uid` INT NOT NULL ,
  `user` VARCHAR(20) NOT NULL ,
  `password` VARCHAR(200) NOT NULL ,
  `pw_len` INT NOT NULL ,
  `admin` TINYINT(1)  NULL ,
  PRIMARY KEY (`uid`) ,
  UNIQUE INDEX `name_UNIQUE` (`name` ASC) );

-- assignment Table

CREATE  TABLE `timetraveler`.`assignment` (
  `id` INT NOT NULL AUTO_INCREMENT ,
  `name` VARCHAR(200) NOT NULL ,
  `description` TEXT NULL ,
  `employer` VARCHAR(100) NOT NULL ,
  `creationdate` DATE NOT NULL ,
  `deadline` DATE NULL ,
  `status` VARCHAR(20) NOT NULL ,
  PRIMARY KEY (`id`) );

-- task Table

CREATE  TABLE `timetraveler`.`task` (
  `id` INT NOT NULL AUTO_INCREMENT ,
  `assignmentref` INT NOT NULL ,
  `userref` INT NOT NULL ,
  `starttime` DATETIME NOT NULL ,
  `endtime` DATETIME NOT NULL ,
  `name` VARCHAR(200) NOT NULL ,
  `description` TEXT NULL ,
  `status` VARCHAR(20) NOT NULL ,
  PRIMARY KEY (`id`) );

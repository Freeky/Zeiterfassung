-- Create statements for Databse Setup

-- ToDo: create database
-- ToDo: Database-User creation

-- user Table

CREATE  TABLE `timetraveler`.`user` (
  `uid` INT NOT NULL ,
  `name` VARCHAR(20) NOT NULL ,
  `password` VARCHAR(200) NOT NULL ,
  `pw_len` INT NOT NULL ,
  `admin` TINYINT(1)  NULL ,
  PRIMARY KEY (`uid`) ,
  UNIQUE INDEX `name_UNIQUE` (`name` ASC) );


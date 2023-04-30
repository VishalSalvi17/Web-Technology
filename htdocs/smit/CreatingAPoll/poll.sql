-- phpMyAdmin SQL Dump
-- version 2.7.0-pl2
-- http://www.phpmyadmin.net
-- 
-- Host: 10.0.11.68
-- Generation Time: May 14, 2008 at 08:35 AM
-- Server version: 4.0.27
-- PHP Version: 4.4.4
-- 
-- Database: `input`
-- 

-- --------------------------------------------------------

-- 
-- Table structure for table `poll`
-- 

CREATE TABLE `poll` (
  `id` int(3) NOT NULL auto_increment,
  `question` varchar(200) default NULL,
  PRIMARY KEY  (`id`)
) TYPE=MyISAM AUTO_INCREMENT=43 ;

-- 
-- Dumping fake data for table `poll`
-- 

INSERT INTO `poll` VALUES (42, 'jquery');
INSERT INTO `poll` VALUES (41, 'mootools');
INSERT INTO `poll` VALUES (40, 'other');
INSERT INTO `poll` VALUES (39, 'mootools');
INSERT INTO `poll` VALUES (38, 'jquery');
INSERT INTO `poll` VALUES (37, 'mootools');
INSERT INTO `poll` VALUES (36, 'spry');
INSERT INTO `poll` VALUES (35, 'jquery');
INSERT INTO `poll` VALUES (21, 'mootools');
INSERT INTO `poll` VALUES (22, 'other');
INSERT INTO `poll` VALUES (23, 'mootools');
INSERT INTO `poll` VALUES (24, 'mootools');
INSERT INTO `poll` VALUES (25, 'prototype');
INSERT INTO `poll` VALUES (26, 'other');
INSERT INTO `poll` VALUES (27, 'mootools');
INSERT INTO `poll` VALUES (28, 'spry');
INSERT INTO `poll` VALUES (29, 'jquery');
INSERT INTO `poll` VALUES (30, 'mootools');
INSERT INTO `poll` VALUES (31, 'prototype');
INSERT INTO `poll` VALUES (32, 'mootools');
INSERT INTO `poll` VALUES (33, 'mootools');
INSERT INTO `poll` VALUES (34, 'mootools');

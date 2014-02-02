-- phpMyAdmin SQL Dump
-- version 3.3.3
-- http://www.phpmyadmin.net
--
-- Servidor: localhost
-- Xerado en: 06 de Xan de 2011 ás 21:59
-- Versión do servidor: 5.1.49
-- Versión do PHP: 5.3.3-1ubuntu9.1

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Base de datos: `chuza`
--

-- --------------------------------------------------------

--
-- Estrutura da táboa `chuzamail`
--

CREATE TABLE IF NOT EXISTS `chuzamail` (
  `chm_id` int(11) NOT NULL AUTO_INCREMENT,
  `chm_comment_id` int(11) NOT NULL,
  `chm_user_id` int(11) NOT NULL,
  `chm_link_id` int(11) NOT NULL,
  `chm_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `chm_viewed` tinyint(4) NOT NULL DEFAULT '0',
  PRIMARY KEY (`chm_id`),
  UNIQUE KEY `chm_user_id_2` (`chm_user_id`,`chm_link_id`),
  KEY `chm_comment_id` (`chm_comment_id`),
  KEY `chm_date` (`chm_date`),
  KEY `chm_user_id` (`chm_user_id`),
  KEY `chm_link_id` (`chm_link_id`)
) ENGINE=MEMORY DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=1 ;

--
-- A extraer datos da táboa `chuzamail`
--


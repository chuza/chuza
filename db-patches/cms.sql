
--
-- Table structure for table `cms`
--

CREATE TABLE IF NOT EXISTS `cms` (
	  `cms_id` int(11) NOT NULL auto_increment,
	  `cms_author` varchar(255) character set utf8 collate utf8_unicode_ci NOT NULL COMMENT 'Sem valor real',
	  `cms_section` enum('ALL','FRONT','POSTS','PENDING','STORY','POPULAR') NOT NULL,
	  `cms_subsection` enum('ALL','SIDEBAR') NOT NULL,
	  `cms_title` varchar(255) character set utf8 collate utf8_unicode_ci NOT NULL,
	  `cms_content` text character set utf8 collate utf8_unicode_ci NOT NULL,
	  `cms_order` tinyint(4) NOT NULL default '0',
	  `cms_date_updated` timestamp NOT NULL default CURRENT_TIMESTAMP on update CURRENT_TIMESTAMP,
	  `cms_valid_until` datetime default NULL,
	  PRIMARY KEY  (`cms_id`)
	) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=2 ;


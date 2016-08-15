CREATE TABLE IF NOT EXISTS `#__vrijwilligersvacaturebank_nl` (
  `id` int(11) unsigned NOT NULL auto_increment,
  `key` varchar(255) NOT NULL,
  `secert` varchar(255) NOT NULL,
  `route` varchar(255) default NULL,
  `access` int(11) unsigned NOT NULL default '0',
  `checked_out` int(11) NOT NULL default '0',
  `published` int(11) NOT NULL default '1',
  PRIMARY KEY  (`id`),
  UNIQUE KEY `id` (`id`)
) ENGINE=MyISAM CHARACTER SET = `utf8`;
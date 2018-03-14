CREATE TABLE `commentsystem`(
  `id` int(11) NOT NULL auto_increment,
  `parent_id` int(11),
  `url_id` varchar(300) NOT NULL,
  `id_material` varchar(11),
  `name` varchar(60) NOT NULL,
  `url` varchar(60),
  `mail` varchar(60) NOT NULL,
  `text` varchar(500) NOT NULL,
  `date_add` varchar(18) NOT NULL,
  `public` int(1) NOT NULL,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=0 DEFAULT CHARSET=cp1251 AUTO_INCREMENT=0;

CREATE TABLE `commentsetings`(
  `id` int(1) NOT NULL auto_increment,
  `url_type` int(1) NOT NULL,
  `rules` text,
  `comment_max` int(3) NOT NULL,
  `send` int(1) NOT NULL,
  `mail` varchar(60) NOT NULL,
  `pass` varchar(15) NOT NULL,
  `theme` varchar(60) NOT NULL,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=0 DEFAULT CHARSET=cp1251 AUTO_INCREMENT=0;
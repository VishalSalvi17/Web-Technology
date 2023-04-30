CREATE TABLE `poll_votes` (
 `id` int(11) NOT NULL AUTO_INCREMENT,
 `poll_id` int(11) NOT NULL,
 `poll_option_id` int(11) NOT NULL,
 `vote_count` bigint(10) NOT NULL,
 PRIMARY KEY (`id`),
 KEY `poll_id` (`poll_id`),
 KEY `poll_option_id` (`poll_option_id`),
 CONSTRAINT `poll_votes_ibfk_1` FOREIGN KEY (`poll_id`) REFERENCES `polls` (`id`) ON DELETE CASCADE ON UPDATE NO ACTION,
 CONSTRAINT `poll_votes_ibfk_2` FOREIGN KEY (`poll_option_id`) REFERENCES `poll_options` (`id`) ON DELETE CASCADE ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
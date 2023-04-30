-- POLL MAIN
CREATE TABLE `poll_main` (
  `poll_id` int(11) NOT NULL,
  `poll_question` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

INSERT INTO `poll_main` (`poll_id`, `poll_question`) VALUES
(1, 'How much wood would a woodchuck chuck if a woodchuck could chuck wood?');

ALTER TABLE `poll_main`
  ADD PRIMARY KEY (`poll_id`);

ALTER TABLE `poll_main`
  MODIFY `poll_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;


-- POLL OPTIONS
CREATE TABLE `poll_options` (
  `poll_id` int(11) NOT NULL,
  `option_id` int(11) NOT NULL,
  `option_text` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

INSERT INTO `poll_options` (`poll_id`, `option_id`, `option_text`) VALUES
(1, 1, '300 pounds'),
(1, 2, '500 pounds'),
(1, 3, '700 pounds');

ALTER TABLE `poll_options`
  ADD PRIMARY KEY (`poll_id`,`option_id`);


-- POLL VOTES
CREATE TABLE `poll_votes` (
  `poll_id` int(11) NOT NULL,
  `option_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

INSERT INTO `poll_votes` (`poll_id`, `option_id`, `user_id`) VALUES
(1, 1, 1),
(1, 2, 2),
(1, 3, 3),
(1, 2, 4),
(1, 1, 5),
(1, 3, 6),
(1, 3, 7),
(1, 2, 8),
(1, 1, 9),
(1, 3, 10);

ALTER TABLE `poll_votes`
  ADD KEY `poll_id` (`poll_id`),
  ADD KEY `option_id` (`option_id`),
  ADD KEY `user_id` (`user_id`);
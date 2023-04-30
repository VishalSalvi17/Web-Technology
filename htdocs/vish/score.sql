CREATE TABLE `score` (
  `score_time` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `score_home` int(3) NOT NULL,
  `score_away` int(3) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

ALTER TABLE `score`
  ADD PRIMARY KEY (`score_time`);

INSERT INTO `score` (`score_home`, `score_away`) VALUES
(2, 99);
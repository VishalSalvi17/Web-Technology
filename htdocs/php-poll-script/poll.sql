--
-- Database: `poll`
--

-- --------------------------------------------------------

--
-- Table structure for table `tbl_answer`
--

CREATE TABLE `tbl_answer` (
  `id` int(11) NOT NULL,
  `question_id` int(11) NOT NULL,
  `answer` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tbl_answer`
--

INSERT INTO `tbl_answer` (`id`, `question_id`, `answer`) VALUES
(1, 1, 'Facebook'),
(2, 1, 'Twitter'),
(3, 1, 'LinkedIn'),
(4, 1, 'Instagram'),
(5, 2, 'Skiing'),
(6, 2, 'Biking'),
(7, 2, 'Snowboarding'),
(8, 2, 'Surfing'),
(11, 3, 'Bose'),
(12, 3, 'JBL'),
(13, 3, 'Sony'),
(14, 3, 'Samsung');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_poll`
--

CREATE TABLE `tbl_poll` (
  `id` int(11) NOT NULL,
  `question_id` int(11) NOT NULL,
  `answer_id` int(11) NOT NULL,
  `member_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tbl_poll`
--

INSERT INTO `tbl_poll` (`id`, `question_id`, `answer_id`, `member_id`) VALUES
(41, 1, 4, 1),
(42, 2, 8, 1),
(43, 3, 11, 1),
(44, 1, 4, 2),
(45, 2, 6, 2),
(46, 3, 13, 2),
(47, 1, 1, 3),
(48, 2, 5, 3),
(49, 3, 12, 3),
(50, 1, 2, 4),
(51, 2, 8, 4),
(52, 3, 12, 4),
(53, 1, 3, 5),
(54, 2, 5, 5),
(55, 3, 14, 5),
(56, 1, 3, 7);

-- --------------------------------------------------------

--
-- Table structure for table `tbl_question`
--

CREATE TABLE `tbl_question` (
  `id` int(11) NOT NULL,
  `question` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tbl_question`
--

INSERT INTO `tbl_question` (`id`, `question`) VALUES
(1, 'What is your favourite social network? '),
(2, 'Choose your favourite holiday ride:'),
(3, 'What is the best brand for headphones?');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `tbl_answer`
--
ALTER TABLE `tbl_answer`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tbl_poll`
--
ALTER TABLE `tbl_poll`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tbl_question`
--
ALTER TABLE `tbl_question`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `tbl_answer`
--
ALTER TABLE `tbl_answer`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=0;

--
-- AUTO_INCREMENT for table `tbl_poll`
--
ALTER TABLE `tbl_poll`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=0;

--
-- AUTO_INCREMENT for table `tbl_question`
--
ALTER TABLE `tbl_question`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=0;
COMMIT;


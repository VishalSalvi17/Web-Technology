
--
-- Database: `testing`
--

-- --------------------------------------------------------

--
-- Table structure for table `tbl_poll`
--

CREATE TABLE `tbl_poll` (
  `poll_id` int(11) NOT NULL,
  `php_framework` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `tbl_poll`
--
ALTER TABLE `tbl_poll`
  ADD PRIMARY KEY (`poll_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `tbl_poll`
--
ALTER TABLE `tbl_poll`
  MODIFY `poll_id` int(11) NOT NULL AUTO_INCREMENT;

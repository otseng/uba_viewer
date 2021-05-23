CREATE TABLE `uba_html_content` (
  `html_content_id` varchar(50) NOT NULL,
  `code` varchar(100) DEFAULT NULL,
  `content` longtext,
  `add_user_id` varchar(50) DEFAULT NULL,
  `add_datetime` datetime DEFAULT NULL,
  `inst_id` varchar(25) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

ALTER TABLE `uba_html_content`
  ADD PRIMARY KEY (`html_content_id`);
COMMIT;


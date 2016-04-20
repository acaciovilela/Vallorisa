CREATE TABLE IF NOT EXISTS `employee_status` (
  `employee_status_id` bigint(20) NOT NULL AUTO_INCREMENT,
  `employee_status_name` varchar(100) NOT NULL,
  PRIMARY KEY (`employee_status_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=6 ;

INSERT INTO `employee_status` (`employee_status_id`, `employee_status_name`) VALUES
(1, 'ATIVO'),
(2, 'DESLIGADO'),
(3, 'EM FÉRIAS'),
(4, 'AFASTADO'),
(5, 'EM ATESTADO MÉDICO');

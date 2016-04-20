START TRANSACTION;

CREATE TABLE IF NOT EXISTS `vehicle_brand` (
  `vehicle_brand_id` bigint(20) NOT NULL AUTO_INCREMENT,
  `vehicle_brand_name` varchar(255) NOT NULL,
  PRIMARY KEY (`vehicle_brand_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=172 ;

--
-- Extraindo dados da tabela `vehicle_brand`
--

INSERT INTO `vehicle_brand` (`vehicle_brand_id`, `vehicle_brand_name`) VALUES
(1, 'AGRALE'),
(2, 'ASIA'),
(3, 'BABYBUGGY'),
(4, 'BMW'),
(5, 'BRAMONT'),
(6, 'BRM'),
(7, 'BUGGY'),
(8, 'CADILLAC'),
(9, 'CBT'),
(10, 'CHANA'),
(11, 'CHRYSLER'),
(12, 'CITROEN'),
(13, 'CROSS LANDER'),
(14, 'DAIHATSU'),
(15, 'DODGE'),
(16, 'EFFA'),
(17, 'FIBRAVAN'),
(18, 'GMC'),
(19, 'GREAT WALL'),
(20, 'GURGEL'),
(21, 'HAFEI'),
(22, 'HONDA'),
(23, 'HYUNDAI'),
(24, 'ISUZU'),
(25, 'IVECO-FIAT'),
(26, 'JEEP'),
(27, 'JINBEI'),
(28, 'JPX'),
(29, 'KIA'),
(30, 'LADA'),
(31, 'LAND ROVER'),
(32, 'LEXUS'),
(33, 'LINCOLN'),
(34, 'MAHINDRA-BRAMONT'),
(35, 'MATRA'),
(36, 'MAZDA'),
(37, 'MERCEDES-BENZ'),
(38, 'MITSUBISHI'),
(39, 'MIURA'),
(40, 'NISSAN'),
(41, 'PEUGEOT'),
(42, 'PORSCHE'),
(43, 'RENAULT'),
(44, 'SEAT'),
(45, 'SELVAGEM'),
(46, 'SSANGYONG'),
(47, 'SUBARU'),
(48, 'SUZUKI'),
(49, 'TOYOTA'),
(50, 'TROLLER'),
(51, 'VOLVO'),
(52, 'WALK'),
(53, 'MINI'),
(54, 'PONTIAC'),
(55, 'SATURN'),
(56, 'SMART'),
(57, 'BRASCYCLE'),
(58, 'CHEVROLET'),
(59, 'FORD'),
(60, 'INTERNATIONAL'),
(61, 'NAVISTAR'),
(62, 'PUMA-ALFA METAIS'),
(63, 'SAAB-SCANIA'),
(64, 'SCANIA'),
(65, 'SCANIA-VABIS'),
(66, 'VOLKSWAGEN'),
(67, 'DAFRA'),
(68, 'MVK'),
(69, 'FIAT'),
(70, 'MASERATI'),
(71, 'BITREM'),
(72, 'REBOQUE'),
(73, 'RODOTREM'),
(74, 'SEMI-REBOQUE'),
(75, 'KAWASAKI'),
(76, 'BRAVAX'),
(77, 'AMAZONAS'),
(78, 'APRILIA'),
(79, 'ATALA'),
(80, 'BASHAN'),
(81, 'BENELLI'),
(82, 'BIMOTA'),
(83, 'BIRELLI'),
(84, 'BOGUSSI'),
(85, 'BRANDY'),
(86, 'BRAVA'),
(87, 'BRP-BOMBARDIER'),
(88, 'BUELL'),
(89, 'BUENO'),
(90, 'BY CRISTO'),
(91, 'CAGIVA'),
(92, 'CALOI'),
(93, 'CHITUMA'),
(94, 'DAELIM'),
(95, 'DAYANG'),
(96, 'DAYUN'),
(97, 'DUCATI'),
(98, 'EAGLE'),
(99, 'EMME'),
(100, 'FASPIDER'),
(101, 'FOX'),
(102, 'FYM'),
(103, 'GARINI'),
(104, 'GARINNI'),
(105, 'GAS GAS'),
(106, 'GREEN MOTOS'),
(107, 'GUOWEI'),
(108, 'HAOBAO'),
(109, 'HARLEY-DAVIDSON'),
(110, 'HOT SNAKE'),
(111, 'HUSABERG'),
(112, 'HUSQVARNA'),
(113, 'HYOSUNG'),
(114, 'IROS'),
(115, 'JIALING'),
(116, 'JONNY'),
(117, 'JONWAY'),
(118, 'KAHENA'),
(119, 'KASINSKI'),
(120, 'KIN'),
(121, 'KTM'),
(122, 'KZUKI'),
(123, 'L''AQUILA'),
(124, 'LEOPARD'),
(125, 'LIFAN'),
(126, 'LON-V'),
(127, 'MALAGUTI'),
(128, 'MIZA'),
(129, 'MOTO GUZZI'),
(130, 'MOTOR-Z'),
(131, 'MOTOSTAR'),
(132, 'MOTTUS'),
(133, 'MRX'),
(134, 'MUNDIAL'),
(135, 'MV AGUSTA'),
(136, 'OMOTO'),
(137, 'ORCA'),
(138, 'PIAGGIO'),
(139, 'SANYANG'),
(140, 'SAZAKI'),
(141, 'SHANDONG LANDUN'),
(142, 'SHINERAY'),
(143, 'TRIUMPH'),
(144, 'US-1'),
(145, 'VENTO'),
(146, 'VOLCANO'),
(147, 'WINNER'),
(148, 'WUYANG'),
(149, 'XARA'),
(150, 'XINLING'),
(151, 'YIYING'),
(152, 'ZHEJIANG'),
(153, 'ZHONGYU'),
(154, 'MAFERSA'),
(155, 'MARCOPOLO'),
(156, 'SUNDOWN'),
(157, 'TRAXX'),
(158, 'ACURA'),
(159, 'ALFA ROMEO'),
(160, 'ASTON MARTIN'),
(161, 'AUDI'),
(162, 'BENTLEY'),
(163, 'CHAMONIX'),
(164, 'DAEWOO'),
(165, 'FERRARI'),
(166, 'JAGUAR'),
(167, 'LAMBORGHINI'),
(168, 'YAMAHA'),
(169, 'CASA'),
(170, 'TERRENO'),
(171, 'FAZENDA');

-- --------------------------------------------------------


--
-- Estrutura da tabela `vehicle_type`
--

CREATE TABLE IF NOT EXISTS `vehicle_type` (
  `vehicle_type_id` bigint(20) NOT NULL AUTO_INCREMENT,
  `vehicle_type_name` varchar(255) DEFAULT NULL,
  `vehicle_brand_id` bigint(20) DEFAULT NULL,
  PRIMARY KEY (`vehicle_type_id`),
  KEY `Ref_23` (`vehicle_brand_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=229 ;

--
-- Extraindo dados da tabela `vehicle_type`
--

INSERT INTO `vehicle_type` (`vehicle_type_id`, `vehicle_type_name`, `vehicle_brand_id`) VALUES
(1, 'UTILITÁRIOS', 1),
(2, 'UTILITÁRIOS', 2),
(3, 'UTILITÁRIOS', 3),
(4, 'UTILITÁRIOS', 4),
(5, 'UTILITÁRIOS', 5),
(6, 'UTILITÁRIOS', 6),
(7, 'UTILITÁRIOS', 7),
(8, 'UTILITÁRIOS', 8),
(9, 'UTILITÁRIOS', 9),
(10, 'UTILITÁRIOS', 10),
(11, 'UTILITÁRIOS', 11),
(12, 'UTILITÁRIOS', 12),
(13, 'UTILITÁRIOS', 13),
(14, 'UTILITÁRIOS', 14),
(15, 'UTILITÁRIOS', 15),
(16, 'UTILITÁRIOS', 16),
(17, 'UTILITÁRIOS', 17),
(18, 'UTILITÁRIOS', 18),
(19, 'UTILITÁRIOS', 19),
(20, 'UTILITÁRIOS', 20),
(21, 'UTILITÁRIOS', 21),
(22, 'UTILITÁRIOS', 22),
(23, 'UTILITÁRIOS', 23),
(24, 'UTILITÁRIOS', 24),
(25, 'UTILITÁRIOS', 25),
(26, 'UTILITÁRIOS', 26),
(27, 'UTILITÁRIOS', 27),
(28, 'UTILITÁRIOS', 28),
(29, 'UTILITÁRIOS', 29),
(30, 'UTILITÁRIOS', 30),
(31, 'UTILITÁRIOS', 31),
(32, 'UTILITÁRIOS', 32),
(33, 'UTILITÁRIOS', 33),
(34, 'UTILITÁRIOS', 34),
(35, 'UTILITÁRIOS', 35),
(36, 'UTILITÁRIOS', 36),
(37, 'UTILITÁRIOS', 37),
(38, 'UTILITÁRIOS', 38),
(39, 'UTILITÁRIOS', 39),
(40, 'UTILITÁRIOS', 40),
(41, 'UTILITÁRIOS', 41),
(42, 'UTILITÁRIOS', 42),
(43, 'UTILITÁRIOS', 43),
(44, 'UTILITÁRIOS', 44),
(45, 'UTILITÁRIOS', 45),
(46, 'UTILITÁRIOS', 46),
(47, 'UTILITÁRIOS', 47),
(48, 'UTILITÁRIOS', 48),
(49, 'UTILITÁRIOS', 49),
(50, 'UTILITÁRIOS', 50),
(51, 'UTILITÁRIOS', 51),
(52, 'UTILITÁRIOS', 52),
(53, 'AUTOMÓVEIS', 37),
(54, 'AUTOMÓVEIS', 53),
(55, 'AUTOMÓVEIS', 38),
(56, 'AUTOMÓVEIS', 40),
(57, 'AUTOMÓVEIS', 41),
(58, 'AUTOMÓVEIS', 54),
(59, 'AUTOMÓVEIS', 42),
(60, 'AUTOMÓVEIS', 43),
(61, 'AUTOMÓVEIS', 55),
(62, 'AUTOMÓVEIS', 44),
(63, 'AUTOMÓVEIS', 56),
(64, 'AUTOMÓVEIS', 46),
(65, 'AUTOMÓVEIS', 47),
(66, 'AUTOMÓVEIS', 48),
(67, 'AUTOMÓVEIS', 49),
(68, 'AUTOMÓVEIS', 51),
(69, 'MOTOS', 22),
(70, 'MOTOS', 57),
(71, 'CAMINHÕES E REBOCADORES', 1),
(72, 'CAMINHÕES E REBOCADORES', 58),
(73, 'CAMINHÕES E REBOCADORES', 59),
(74, 'CAMINHÕES E REBOCADORES', 18),
(75, 'CAMINHÕES E REBOCADORES', 23),
(76, 'CAMINHÕES E REBOCADORES', 60),
(77, 'CAMINHÕES E REBOCADORES', 25),
(78, 'CAMINHÕES E REBOCADORES', 37),
(79, 'CAMINHÕES E REBOCADORES', 61),
(80, 'CAMINHÕES E REBOCADORES', 62),
(81, 'CAMINHÕES E REBOCADORES', 63),
(82, 'CAMINHÕES E REBOCADORES', 64),
(83, 'CAMINHÕES E REBOCADORES', 65),
(84, 'CAMINHÕES E REBOCADORES', 66),
(85, 'CAMINHÕES E REBOCADORES', 51),
(86, 'AUTOMÓVEIS', 58),
(87, 'UTILITÁRIOS', 58),
(88, 'MOTOS', 67),
(89, 'MOTOS', 68),
(90, 'AUTOMÓVEIS', 69),
(91, 'AUTOMÓVEIS', 70),
(92, 'UTILITÁRIOS', 69),
(93, 'AUTOMÓVEIS', 59),
(94, 'UTILITÁRIOS', 59),
(95, 'IMPLEMENTOS RODOVIÁRIOS', 71),
(96, 'IMPLEMENTOS RODOVIÁRIOS', 72),
(97, 'IMPLEMENTOS RODOVIÁRIOS', 73),
(98, 'IMPLEMENTOS RODOVIÁRIOS', 74),
(99, 'MOTOS', 75),
(100, 'MOTOS', 1),
(101, 'MOTOS', 76),
(102, 'MOTOS', 77),
(103, 'MOTOS', 78),
(104, 'MOTOS', 2),
(105, 'MOTOS', 79),
(106, 'MOTOS', 80),
(107, 'MOTOS', 81),
(108, 'MOTOS', 82),
(109, 'MOTOS', 83),
(110, 'MOTOS', 4),
(111, 'MOTOS', 84),
(112, 'MOTOS', 85),
(113, 'MOTOS', 86),
(114, 'MOTOS', 87),
(115, 'MOTOS', 88),
(116, 'MOTOS', 89),
(117, 'MOTOS', 90),
(118, 'MOTOS', 91),
(119, 'MOTOS', 92),
(120, 'MOTOS', 93),
(121, 'MOTOS', 94),
(122, 'MOTOS', 95),
(123, 'MOTOS', 96),
(124, 'MOTOS', 97),
(125, 'MOTOS', 98),
(126, 'MOTOS', 99),
(127, 'MOTOS', 100),
(128, 'MOTOS', 101),
(129, 'MOTOS', 102),
(130, 'MOTOS', 103),
(131, 'MOTOS', 104),
(132, 'MOTOS', 105),
(133, 'MOTOS', 106),
(134, 'MOTOS', 107),
(135, 'MOTOS', 20),
(136, 'MOTOS', 108),
(137, 'MOTOS', 109),
(138, 'MOTOS', 110),
(139, 'MOTOS', 111),
(140, 'MOTOS', 112),
(141, 'MOTOS', 113),
(142, 'MOTOS', 114),
(143, 'MOTOS', 115),
(144, 'MOTOS', 116),
(145, 'MOTOS', 117),
(146, 'MOTOS', 118),
(147, 'MOTOS', 119),
(148, 'MOTOS', 120),
(149, 'MOTOS', 121),
(150, 'MOTOS', 122),
(151, 'MOTOS', 123),
(152, 'MOTOS', 124),
(153, 'MOTOS', 125),
(154, 'MOTOS', 126),
(155, 'MOTOS', 127),
(156, 'MOTOS', 128),
(157, 'MOTOS', 129),
(158, 'MOTOS', 130),
(159, 'MOTOS', 131),
(160, 'MOTOS', 132),
(161, 'MOTOS', 133),
(162, 'MOTOS', 134),
(163, 'MOTOS', 135),
(164, 'MOTOS', 136),
(165, 'MOTOS', 137),
(166, 'MOTOS', 41),
(167, 'MOTOS', 138),
(168, 'MOTOS', 139),
(169, 'MOTOS', 140),
(170, 'MOTOS', 141),
(171, 'MOTOS', 142),
(172, 'MOTOS', 143),
(173, 'MOTOS', 144),
(174, 'MOTOS', 145),
(175, 'MOTOS', 146),
(176, 'MOTOS', 147),
(177, 'MOTOS', 148),
(178, 'MOTOS', 149),
(179, 'MOTOS', 150),
(180, 'MOTOS', 151),
(181, 'MOTOS', 152),
(182, 'MOTOS', 153),
(183, 'ÔNIBUS E MICROÔNIBUS', 2),
(184, 'ÔNIBUS E MICROÔNIBUS', 59),
(185, 'ÔNIBUS E MICROÔNIBUS', 25),
(186, 'ÔNIBUS E MICROÔNIBUS', 154),
(187, 'ÔNIBUS E MICROÔNIBUS', 155),
(188, 'ÔNIBUS E MICROÔNIBUS', 37),
(189, 'ÔNIBUS E MICROÔNIBUS', 64),
(190, 'ÔNIBUS E MICROÔNIBUS', 66),
(191, 'ÔNIBUS E MICROÔNIBUS', 51),
(192, 'ÔNIBUS E MICROÔNIBUS', 1),
(193, 'MOTOS', 156),
(194, 'MOTOS', 48),
(195, 'MOTOS', 157),
(196, 'AUTOMÓVEIS', 158),
(197, 'AUTOMÓVEIS', 159),
(198, 'AUTOMÓVEIS', 160),
(199, 'AUTOMÓVEIS', 161),
(200, 'AUTOMÓVEIS', 162),
(201, 'AUTOMÓVEIS', 4),
(202, 'AUTOMÓVEIS', 8),
(203, 'AUTOMÓVEIS', 163),
(204, 'AUTOMÓVEIS', 11),
(205, 'AUTOMÓVEIS', 12),
(206, 'AUTOMÓVEIS', 164),
(207, 'AUTOMÓVEIS', 14),
(208, 'AUTOMÓVEIS', 15),
(209, 'AUTOMÓVEIS', 16),
(210, 'AUTOMÓVEIS', 165),
(211, 'AUTOMÓVEIS', 22),
(212, 'AUTOMÓVEIS', 23),
(213, 'AUTOMÓVEIS', 166),
(214, 'AUTOMÓVEIS', 29),
(215, 'AUTOMÓVEIS', 30),
(216, 'AUTOMÓVEIS', 167),
(217, 'UTILITÁRIOS', 167),
(218, 'AUTOMÓVEIS', 32),
(219, 'AUTOMÓVEIS', 36),
(220, 'AUTOMÓVEIS', 66),
(221, 'UTILITÁRIOS', 66),
(222, 'MOTOS', 168),
(223, 'CAMINHÕES E REBOCADORES', 69),
(226, 'UTILITÁRIOS', 169),
(227, 'UTILITÁRIOS', 170),
(228, 'UTILITÁRIOS', 171);

-- -----------------------------------------
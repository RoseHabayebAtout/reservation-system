CREATE TABLE `extra_parking` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `rawabi_code` varchar(255) NOT NULL,
  `neighporhood` varchar(255) NOT NULL,
  `building` varchar(255) NOT NULL,
  `floor` varchar(255) NOT NULL,
  `parking_number` varchar(255) NOT NULL,
  `description` varchar(1000) NOT NULL,
  `price` varchar(255) NOT NULL,
  `available` int(10) NOT NULL DEFAULT 0,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- modify unit
ALTER TABLE `uf_unit`
ADD COLUMN `extra_parking_number` varchar(255) DEFAULT NULL;

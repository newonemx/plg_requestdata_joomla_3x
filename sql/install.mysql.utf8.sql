SET FOREIGN_KEY_CHECKS=0;

CREATE TABLE IF NOT EXISTS `#__core_trackingip` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(10) unsigned DEFAULT NULL,
  `remote_addr` varchar(255) COLLATE utf8mb4_spanish2_ci DEFAULT NULL,
  `http_user_agent` text COLLATE utf8mb4_spanish2_ci DEFAULT NULL,
  `platform` varchar(255) COLLATE utf8mb4_spanish2_ci DEFAULT NULL,
  `payload` text COLLATE utf8mb4_spanish2_ci DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_spanish2_ci;

SET FOREIGN_KEY_CHECKS=1;
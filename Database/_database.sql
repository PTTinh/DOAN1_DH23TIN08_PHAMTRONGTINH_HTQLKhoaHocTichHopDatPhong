-- --------------------------------------------------------
-- Host:                         127.0.0.1
-- Server version:               10.4.32-MariaDB - mariadb.org binary distribution
-- Server OS:                    Win64
-- HeidiSQL Version:             12.7.0.6850
-- --------------------------------------------------------

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET NAMES utf8 */;
/*!50503 SET NAMES utf8mb4 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;


-- Dumping database structure for doan1
CREATE DATABASE IF NOT EXISTS `doan1` /*!40100 DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci */;
USE `doan1`;

-- Dumping structure for table doan1.cache
CREATE TABLE IF NOT EXISTS `cache` (
  `key` varchar(255) NOT NULL,
  `value` mediumtext NOT NULL,
  `expiration` int(11) NOT NULL,
  PRIMARY KEY (`key`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table doan1.cache: ~24 rows (approximately)
INSERT INTO `cache` (`key`, `value`, `expiration`) VALUES
	('laravel-cache-all_settings', 'a:13:{s:11:"center_name";s:55:"Trung Tâm Đào Tạo Ngôn Ngữ Trung Hoa Cần Thơ";s:5:"phone";s:11:"+1234567890";s:5:"email";s:30:"lienhe@tiengtrungcantho.edu.vn";s:7:"address";s:83:"Số 123, Đường 3/2, Phường Xuân Khánh, Quận Ninh Kiều, TP. Cần Thơ";s:4:"logo";s:37:"logos/01KKQZ5ZFF2FZT868VANSA9VEE.avif";s:11:"description";s:188:"<p>Trung tâm đào tạo tiếng Trung hàng đầu tại Đồng bằng sông Cửu Long với lộ trình cá nhân hóa, cam kết đầu ra HSK và TOCFL chỉ sau 3 tháng học.</p>";s:13:"youtube_embed";N;s:11:"course_unit";s:5:"khóa";s:16:"room_rental_unit";s:6:"buổi";s:17:"room_unit_to_hour";s:1:"1";s:10:"google_map";s:305:"https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3928.8473396395116!2d105.768426615233!3d10.029933792830635!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x31a0883d2192b0ef%3A0x80506371510443d3!2zS2h1IEjhu41jIExp4buHdSAtIMSQ4bqhaSBo4buNYyBD4bqnbiBUaMah!5e0!3m2!1svi!2s!4v1647000000000!5m2!1svi!2s";s:16:"facebook_fanpage";N;s:10:"zalo_embed";N;}', 1773663983),
	('laravel-cache-email_change_code_user_1', 'a:3:{s:9:"new_email";s:22:"phamtinh9099@gmail.com";s:4:"code";s:6:"556126";s:10:"expires_at";s:19:"2026-03-15 22:01:35";}', 1773586895),
	('laravel-cache-email_change_code_user_6', 'a:3:{s:9:"new_email";s:25:"phamtrongtinh12@gmail.com";s:4:"code";s:6:"297400";s:10:"expires_at";s:19:"2026-03-15 22:05:09";}', 1773587109),
	('laravel-cache-livewire-rate-limiter:056fc329aaaa757d31db450f525da23fde4d1b36', 'i:1;', 1773705671),
	('laravel-cache-livewire-rate-limiter:056fc329aaaa757d31db450f525da23fde4d1b36:timer', 'i:1773705671;', 1773705671),
	('laravel-cache-setting_address', 's:83:"Số 123, Đường 3/2, Phường Xuân Khánh, Quận Ninh Kiều, TP. Cần Thơ";', 1773706440),
	('laravel-cache-setting_center_address', 's:0:"";', 1773656550),
	('laravel-cache-setting_center_email', 's:0:"";', 1773656550),
	('laravel-cache-setting_center_name', 's:55:"Trung Tâm Đào Tạo Ngôn Ngữ Trung Hoa Cần Thơ";', 1773706440),
	('laravel-cache-setting_center_phone', 's:0:"";', 1773656550),
	('laravel-cache-setting_course_rental_unit', 's:5:"khóa";', 1773709225),
	('laravel-cache-setting_course_unit', 's:5:"khóa";', 1773706440),
	('laravel-cache-setting_custom_js', 'N;', 1773709624),
	('laravel-cache-setting_description', 's:188:"<p>Trung tâm đào tạo tiếng Trung hàng đầu tại Đồng bằng sông Cửu Long với lộ trình cá nhân hóa, cam kết đầu ra HSK và TOCFL chỉ sau 3 tháng học.</p>";', 1773706440),
	('laravel-cache-setting_email', 's:30:"lienhe@tiengtrungcantho.edu.vn";', 1773706440),
	('laravel-cache-setting_facebook_fanpage', 'N;', 1773709624),
	('laravel-cache-setting_ga_body', 'N;', 1773709624),
	('laravel-cache-setting_google_map', 's:305:"https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3928.8473396395116!2d105.768426615233!3d10.029933792830635!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x31a0883d2192b0ef%3A0x80506371510443d3!2zS2h1IEjhu41jIExp4buHdSAtIMSQ4bqhaSBo4buNYyBD4bqnbiBUaMah!5e0!3m2!1svi!2s!4v1647000000000!5m2!1svi!2s";', 1773706440),
	('laravel-cache-setting_logo', 's:37:"logos/01KKQZ5ZFF2FZT868VANSA9VEE.avif";', 1773706440),
	('laravel-cache-setting_phone', 's:11:"+1234567890";', 1773706440),
	('laravel-cache-setting_room_rental_unit', 's:6:"buổi";', 1773706440),
	('laravel-cache-setting_room_unit_to_hour', 's:1:"1";', 1773706440),
	('laravel-cache-setting_welcome_message', 's:137:"Chào mừng bạn đến với Trung Tâm Đào Tạo Ngôn Ngữ Trung Hoa Cần Thơ - Nơi học tập và phát triển bản thân!";', 1773706479),
	('laravel-cache-setting_youtube_embed', 'N;', 1773709624),
	('laravel-cache-setting_zalo', 's:0:"";', 1773706481);

-- Dumping structure for table doan1.cache_locks
CREATE TABLE IF NOT EXISTS `cache_locks` (
  `key` varchar(255) NOT NULL,
  `owner` varchar(255) NOT NULL,
  `expiration` int(11) NOT NULL,
  PRIMARY KEY (`key`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table doan1.cache_locks: ~0 rows (approximately)

-- Dumping structure for table doan1.categories
CREATE TABLE IF NOT EXISTS `categories` (
  `category_id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `slug` varchar(255) NOT NULL,
  `description` text DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`category_id`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table doan1.categories: ~5 rows (approximately)
INSERT INTO `categories` (`category_id`, `name`, `slug`, `description`, `created_at`, `updated_at`) VALUES
	(1, 'Tiếng Trung Giao Tiếp', 'tieng-trung-giao-tiep', 'Các khóa học tập trung vào kỹ năng nghe và nói thực tế.', '2026-03-15 05:06:14', '2026-03-15 05:06:14'),
	(2, 'Luyện Thi HSK', 'luyen-thi-hsk', 'Lộ trình bài bản để chinh phục chứng chỉ HSK từ 1 đến 6.', '2026-03-15 05:06:14', '2026-03-15 05:06:14'),
	(3, 'Tiếng Trung Trẻ Em', 'tieng-trung-tre-em', 'Chương trình sinh động dành cho lứa tuổi từ 6-12.', '2026-03-15 05:06:14', '2026-03-15 05:06:14'),
	(4, 'Tiếng Trung Doanh Nghiệp', 'tieng-trung-doanh-nghiep', 'Đào tạo cấp tốc cho người đi làm và kinh doanh.', '2026-03-15 05:06:14', '2026-03-15 05:06:14'),
	(5, 'Luyện Thi TOCFL', 'luyen-thi-tocfl', 'Chứng chỉ năng lực Hán ngữ của Đài Loan.', '2026-03-15 05:06:14', '2026-03-15 05:06:14');

-- Dumping structure for table doan1.chat_messages
CREATE TABLE IF NOT EXISTS `chat_messages` (
  `chat_message_id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` bigint(20) unsigned DEFAULT NULL,
  `session_id` varchar(120) DEFAULT NULL,
  `role` varchar(20) NOT NULL,
  `message` text NOT NULL,
  `ip_address` varchar(45) DEFAULT NULL,
  `user_agent` varchar(512) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`chat_message_id`) USING BTREE,
  KEY `chat_messages_user_id_created_at_index` (`user_id`,`created_at`),
  KEY `chat_messages_session_id_created_at_index` (`session_id`,`created_at`),
  KEY `chat_messages_session_id_index` (`session_id`),
  CONSTRAINT `chat_messages_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE SET NULL
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table doan1.chat_messages: ~8 rows (approximately)
INSERT INTO `chat_messages` (`chat_message_id`, `user_id`, `session_id`, `role`, `message`, `ip_address`, `user_agent`, `created_at`, `updated_at`) VALUES
	(1, 1, NULL, 'user', 'Khóa học', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/145.0.0.0 Safari/537.36 Edg/145.0.0.0', '2026-03-15 15:25:30', '2026-03-15 15:25:30'),
	(2, 1, NULL, 'assistant', 'Danh sách khóa học nổi bật tại Trung Tâm Đào Tạo Ngôn Ngữ Trung Hoa Cần Thơ\n\n- Tiếng Trung Sơ Cấp A1 | Học phí: 2,500,000đ | Khai giảng: 01/04/2026\n- Luyện Thi HSK 3 Cấp Tốc | Học phí: 4,200,000đ | Khai giảng: 10/04/2026\n- Tiếng Trung Thương Mại | Học phí: 5,500,000đ | Khai giảng: 15/04/2026\n- Hoa Ngữ Nhí - Level 1 | Học phí: 1,800,000đ | Khai giảng: 01/05/2026\n- Giao Tiếp Thực Chiến 1-1 | Học phí: 8,000,000đ | Khai giảng: 20/04/2026\n\nBạn có thể tiếp tục:\n- Xem đầy đủ tại /khoa-hoc\n- Liên hệ tư vấn nhanh: +1234567890', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/145.0.0.0 Safari/537.36 Edg/145.0.0.0', '2026-03-15 15:25:33', '2026-03-15 15:25:33'),
	(3, 1, NULL, 'user', 'Đặt phòng', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/145.0.0.0 Safari/537.36 Edg/145.0.0.0', '2026-03-15 15:25:44', '2026-03-15 15:25:44'),
	(4, 1, NULL, 'assistant', 'Cảm ơn bạn đã liên hệ Trung Tâm Đào Tạo Ngôn Ngữ Trung Hoa Cần Thơ\n\n- Mình có thể hỗ trợ: tư vấn khóa học, học phí, lịch khai giảng, đặt phòng học\n\nBạn có thể tiếp tục:\n- Nhắn nội dung bạn đang quan tâm để mình tư vấn chi tiết\n- Hoặc gọi hotline: +1234567890', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/145.0.0.0 Safari/537.36 Edg/145.0.0.0', '2026-03-15 15:25:45', '2026-03-15 15:25:45'),
	(5, 1, NULL, 'user', 'Lịch học', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/145.0.0.0 Safari/537.36 Edg/145.0.0.0', '2026-03-15 15:26:00', '2026-03-15 15:26:00'),
	(6, 1, NULL, 'assistant', 'Lịch khai giảng sắp tới\n\n- Tiếng Trung Sơ Cấp A1: 01/04/2026\n- Luyện Thi HSK 3 Cấp Tốc: 10/04/2026\n- Tiếng Trung Thương Mại: 15/04/2026\n\nBạn có thể tiếp tục:\n- Đăng ký ngay qua hotline: +1234567890', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/145.0.0.0 Safari/537.36 Edg/145.0.0.0', '2026-03-15 15:26:02', '2026-03-15 15:26:02'),
	(7, 1, NULL, 'user', 'Học phí', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/145.0.0.0 Safari/537.36 Edg/145.0.0.0', '2026-03-15 15:26:13', '2026-03-15 15:26:13'),
	(8, 1, NULL, 'assistant', 'Danh sách khóa học nổi bật tại Trung Tâm Đào Tạo Ngôn Ngữ Trung Hoa Cần Thơ\n\n- Tiếng Trung Sơ Cấp A1 | Học phí: 2,500,000đ | Khai giảng: 01/04/2026\n- Luyện Thi HSK 3 Cấp Tốc | Học phí: 4,200,000đ | Khai giảng: 10/04/2026\n- Tiếng Trung Thương Mại | Học phí: 5,500,000đ | Khai giảng: 15/04/2026\n- Hoa Ngữ Nhí - Level 1 | Học phí: 1,800,000đ | Khai giảng: 01/05/2026\n- Giao Tiếp Thực Chiến 1-1 | Học phí: 8,000,000đ | Khai giảng: 20/04/2026\n\nBạn có thể tiếp tục:\n- Xem đầy đủ tại /khoa-hoc\n- Liên hệ tư vấn nhanh: +1234567890', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/145.0.0.0 Safari/537.36 Edg/145.0.0.0', '2026-03-15 15:26:15', '2026-03-15 15:26:15');

-- Dumping structure for table doan1.courses
CREATE TABLE IF NOT EXISTS `courses` (
  `course_id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `category_id` bigint(20) unsigned NOT NULL,
  `title` varchar(255) NOT NULL,
  `slug` varchar(255) NOT NULL,
  `description` text DEFAULT NULL,
  `content` longtext DEFAULT NULL,
  `featured_image` varchar(255) DEFAULT NULL,
  `price` decimal(19,0) NOT NULL DEFAULT 0,
  `is_price_visible` tinyint(1) NOT NULL DEFAULT 1,
  `max_students` int(11) DEFAULT NULL,
  `end_registration_date` date DEFAULT NULL,
  `start_date` date DEFAULT NULL,
  `status` enum('draft','published','archived') NOT NULL DEFAULT 'draft',
  `allow_overflow` tinyint(1) NOT NULL DEFAULT 0 COMMENT 'Cho phép nhận thêm học viên khi đã đủ số lượng',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`course_id`),
  KEY `fk_courses_category_id` (`category_id`),
  CONSTRAINT `fk_courses_category_id` FOREIGN KEY (`category_id`) REFERENCES `categories` (`category_id`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table doan1.courses: ~3 rows (approximately)
INSERT INTO `courses` (`course_id`, `category_id`, `title`, `slug`, `description`, `content`, `featured_image`, `price`, `is_price_visible`, `max_students`, `end_registration_date`, `start_date`, `status`, `allow_overflow`, `created_at`, `updated_at`) VALUES
	(1, 1, 'Tiếng Trung Sơ Cấp A1', 'tieng-trung-so-cap-a1', 'Dành cho người mới bắt đầu.', 'Nội dung bao gồm phát âm Pinyin, các nét cơ bản...', 'course-images/01KKQYA5EB2YP00ZVFS54S9Y0B.jpg', 2500000, 1, 15, NULL, '2026-04-01', 'published', 0, '2026-03-15 05:06:14', '2026-03-15 05:06:14'),
	(2, 2, 'Luyện Thi HSK 3 Cấp Tốc', 'luyen-thi-hsk-3-cap-toc', 'Đảm bảo đầu ra HSK 3 trong 3 tháng.', 'Học mẹo làm bài, ôn tập 600 từ vựng cốt lõi.', 'course-images/01KKQYA5EB2YP00ZVFS54S9Y0B.jpg', 4200000, 1, 10, NULL, '2026-04-10', 'published', 0, '2026-03-15 05:06:14', '2026-03-15 05:06:14'),
	(3, 4, 'Tiếng Trung Thương Mại', 'tieng-trung-thuong-mai', 'Kỹ năng đàm phán và soạn thảo hợp đồng.', 'Học cách giao tiếp với đối tác Trung Quốc, từ vựng chuyên ngành.', 'course-images/01KKQYA5EB2YP00ZVFS54S9Y0B.jpg', 5500000, 1, 12, NULL, '2026-04-15', 'published', 0, '2026-03-15 05:06:14', '2026-03-15 05:06:14');

-- Dumping structure for table doan1.course_registrations
CREATE TABLE IF NOT EXISTS `course_registrations` (
  `registration_id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `course_id` bigint(20) unsigned NOT NULL,
  `created_by` bigint(20) unsigned DEFAULT NULL,
  `registration_date` timestamp NOT NULL DEFAULT current_timestamp(),
  `student_name` varchar(255) NOT NULL,
  `student_email` varchar(255) DEFAULT NULL,
  `student_phone` varchar(255) NOT NULL,
  `student_address` varchar(255) DEFAULT NULL,
  `student_birth_date` date DEFAULT NULL,
  `student_gender` varchar(255) DEFAULT NULL,
  `payment_status` enum('unpaid','paid','refunded') NOT NULL DEFAULT 'unpaid',
  `actual_price` decimal(15,0) DEFAULT NULL COMMENT 'Số tiền đã thu của học viên',
  `status` enum('pending','confirmed','cancelled','completed') NOT NULL DEFAULT 'pending',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`registration_id`),
  KEY `fk_course_registrations_course_id` (`course_id`),
  KEY `fk_course_registrations_created_by` (`created_by`),
  KEY `course_registrations_student_phone_index` (`student_phone`),
  CONSTRAINT `fk_course_registrations_course_id` FOREIGN KEY (`course_id`) REFERENCES `courses` (`course_id`) ON DELETE CASCADE,
  CONSTRAINT `fk_course_registrations_created_by` FOREIGN KEY (`created_by`) REFERENCES `users` (`id`) ON DELETE SET NULL
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table doan1.course_registrations: ~5 rows (approximately)
INSERT INTO `course_registrations` (`registration_id`, `course_id`, `created_by`, `registration_date`, `student_name`, `student_email`, `student_phone`, `student_address`, `student_birth_date`, `student_gender`, `payment_status`, `actual_price`, `status`, `created_at`, `updated_at`) VALUES
	(1, 1, NULL, '2026-03-15 05:06:14', 'Nguyễn Văn A', 'vana@gmail.com', '0907123456', NULL, NULL, NULL, 'paid', 2500000, 'confirmed', '2026-03-15 05:06:14', '2026-03-15 05:06:14'),
	(2, 2, NULL, '2026-03-15 05:06:14', 'Lê Thị B', 'thib@gmail.com', '0918777888', NULL, NULL, NULL, 'unpaid', 4200000, 'pending', '2026-03-15 05:06:14', '2026-03-15 05:06:14'),
	(3, 1, NULL, '2026-03-15 05:06:14', 'Phạm Thành C', 'thanhc@gmail.com', '0939111222', NULL, NULL, NULL, 'paid', 2500000, 'confirmed', '2026-03-15 05:06:14', '2026-03-15 05:06:14'),
	(4, 3, NULL, '2026-03-15 05:06:14', 'Hoàng Văn D', 'vand@gmail.com', '0949333444', NULL, NULL, NULL, 'refunded', 5500000, 'cancelled', '2026-03-15 05:06:14', '2026-03-15 05:06:14'),
	(6, 2, 1, '2026-03-15 14:23:51', 'Phạm Trọng Tính', 'test@gmail.com', '0399277101', NULL, NULL, NULL, 'unpaid', NULL, 'cancelled', '2026-03-15 14:23:51', '2026-03-15 14:36:55');

-- Dumping structure for table doan1.equipments
CREATE TABLE IF NOT EXISTS `equipments` (
  `equipment_id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(100) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`equipment_id`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table doan1.equipments: ~5 rows (approximately)
INSERT INTO `equipments` (`equipment_id`, `name`, `created_at`, `updated_at`) VALUES
	(1, 'Máy chiếu Full HD', '2026-03-15 05:06:14', '2026-03-15 05:06:14'),
	(2, 'Loa Bluetooth Marshall', '2026-03-15 05:06:14', '2026-03-15 05:06:14'),
	(3, 'Bảng tương tác thông minh', '2026-03-15 05:06:14', '2026-03-15 05:06:14'),
	(4, 'Máy điều hòa Inverter', '2026-03-15 05:06:14', '2026-03-15 05:06:14'),
	(5, 'Micro không dây', '2026-03-15 05:06:14', '2026-03-15 05:06:14');

-- Dumping structure for table doan1.failed_jobs
CREATE TABLE IF NOT EXISTS `failed_jobs` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `uuid` varchar(255) NOT NULL,
  `connection` text NOT NULL,
  `queue` text NOT NULL,
  `payload` longtext NOT NULL,
  `exception` longtext NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`id`),
  UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table doan1.failed_jobs: ~0 rows (approximately)

-- Dumping structure for table doan1.jobs
CREATE TABLE IF NOT EXISTS `jobs` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `queue` varchar(255) NOT NULL,
  `payload` longtext NOT NULL,
  `attempts` tinyint(3) unsigned NOT NULL,
  `reserved_at` int(10) unsigned DEFAULT NULL,
  `available_at` int(10) unsigned NOT NULL,
  `created_at` int(10) unsigned NOT NULL,
  PRIMARY KEY (`id`),
  KEY `jobs_queue_index` (`queue`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table doan1.jobs: ~0 rows (approximately)

-- Dumping structure for table doan1.job_batches
CREATE TABLE IF NOT EXISTS `job_batches` (
  `id` varchar(255) NOT NULL,
  `name` varchar(255) NOT NULL,
  `total_jobs` int(11) NOT NULL,
  `pending_jobs` int(11) NOT NULL,
  `failed_jobs` int(11) NOT NULL,
  `failed_job_ids` longtext NOT NULL,
  `options` mediumtext DEFAULT NULL,
  `cancelled_at` int(11) DEFAULT NULL,
  `created_at` int(11) NOT NULL,
  `finished_at` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table doan1.job_batches: ~0 rows (approximately)

-- Dumping structure for table doan1.migrations
CREATE TABLE IF NOT EXISTS `migrations` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `migration` varchar(255) NOT NULL,
  `batch` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=18 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table doan1.migrations: ~17 rows (approximately)
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
	(1, '0001_01_01_000000_create_users_table', 1),
	(2, '0001_01_01_000001_create_cache_table', 1),
	(3, '0001_01_01_000002_create_jobs_table', 1),
	(4, '2026_02_28_184723_create_settings_table', 1),
	(5, '2026_02_28_184724_create_categories_table', 1),
	(6, '2026_02_28_184724_create_courses_table', 1),
	(7, '2026_02_28_184725_create_course_registrations_table', 1),
	(8, '2026_02_28_184725_create_rooms_table', 1),
	(9, '2026_02_28_184726_create_room_bookings_table', 1),
	(10, '2026_02_28_184727_create_equipments_table', 1),
	(11, '2026_02_28_184727_create_room_equipments_table', 1),
	(12, '2026_02_28_184728_create_news_categories_table', 1),
	(13, '2026_02_28_184728_create_sliders_table', 1),
	(14, '2026_02_28_184729_create_news_table', 1),
	(15, '2026_02_28_184730_update_users_table', 1),
	(16, '2026_02_28_184731_create_room_booking_details_table', 1),
	(17, '2026_03_14_100000_create_chat_messages_table', 1);

-- Dumping structure for table doan1.news
CREATE TABLE IF NOT EXISTS `news` (
  `news_id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `title` varchar(500) DEFAULT NULL,
  `slug` varchar(500) DEFAULT NULL,
  `summary` text DEFAULT NULL,
  `content` longtext NOT NULL,
  `featured_image` varchar(255) DEFAULT NULL,
  `author_id` bigint(20) unsigned DEFAULT NULL,
  `is_featured` tinyint(1) NOT NULL DEFAULT 0,
  `is_published` tinyint(1) NOT NULL DEFAULT 0,
  `published_at` datetime DEFAULT NULL,
  `view_count` int(11) NOT NULL DEFAULT 0,
  `news_category_id` bigint(20) unsigned DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`news_id`),
  KEY `fk_news_author_id` (`author_id`),
  KEY `fk_news_category_id` (`news_category_id`),
  KEY `idx_news_published_featured` (`is_published`,`published_at`,`is_featured`),
  CONSTRAINT `fk_news_author_id` FOREIGN KEY (`author_id`) REFERENCES `users` (`id`) ON DELETE SET NULL,
  CONSTRAINT `fk_news_category_id` FOREIGN KEY (`news_category_id`) REFERENCES `news_categories` (`news_category_id`) ON DELETE SET NULL
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table doan1.news: ~5 rows (approximately)
INSERT INTO `news` (`news_id`, `title`, `slug`, `summary`, `content`, `featured_image`, `author_id`, `is_featured`, `is_published`, `published_at`, `view_count`, `news_category_id`, `created_at`, `updated_at`) VALUES
	(1, '5 Bí quyết nhớ chữ Hán siêu nhanh', '5-bi-quyet-nho-chu-han', 'Làm sao để không quên mặt chữ?', 'Nội dung chi tiết về phương pháp chiết tự...', 'news/01KKQYWMKDRH40ZW6EMTJ5HNMS.jpg', 1, 0, 1, '2026-03-16 16:47:03', 0, 1, '2026-03-15 05:06:14', '2026-03-15 05:18:19'),
	(2, 'Lễ hội Bánh Trôi nước tại Trung tâm', 'le-hoi-banh-troi-nuoc', 'Hoạt động ngoại khóa cuối tuần.', 'Học viên cùng nhau làm bánh và học từ vựng...', 'news/01KKQYWMKDRH40ZW6EMTJ5HNMS.jpg', 2, 0, 1, '2026-03-16 16:47:04', 0, 2, '2026-03-15 05:06:14', '2026-03-15 05:06:14'),
	(3, 'Du lịch Cần Thơ - Trung Quốc: Những điều cần biết', 'du-lich-can-tho-trung-quoc', 'Hướng dẫn xin visa du học và du lịch.', 'Các thủ tục cần thiết khi bay từ Cần Thơ...', 'news/01KKQYWMKDRH40ZW6EMTJ5HNMS.jpg', 4, 0, 1, '2026-03-16 16:47:05', 0, 3, '2026-03-15 05:06:14', '2026-03-15 05:06:14'),
	(4, 'Ưu đãi học phí hè 2026', 'uu-dai-hoc-phi-he-2026', 'Giảm ngay 20% cho nhóm 3 người.', 'Chương trình áp dụng từ tháng 5 đến tháng 8...', 'news/01KKQYWMKDRH40ZW6EMTJ5HNMS.jpg', 1, 0, 1, '2026-03-16 16:47:05', 0, 2, '2026-03-15 05:06:14', '2026-03-15 05:06:14'),
	(5, 'Phân biệt HSK và TOCFL', 'phan-biet-hsk-va-tocfl', 'Bạn nên thi chứng chỉ nào?', 'So sánh chi tiết về cấu trúc bài thi và giá trị...', 'news/01KKQYWMKDRH40ZW6EMTJ5HNMS.jpg', 1, 0, 1, '2026-03-16 16:47:05', 0, 1, '2026-03-15 05:06:14', '2026-03-15 05:06:14');

-- Dumping structure for table doan1.news_categories
CREATE TABLE IF NOT EXISTS `news_categories` (
  `news_category_id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) DEFAULT NULL,
  `slug` varchar(255) DEFAULT NULL,
  `description` text DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`news_category_id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table doan1.news_categories: ~3 rows (approximately)
INSERT INTO `news_categories` (`news_category_id`, `name`, `slug`, `description`, `created_at`, `updated_at`) VALUES
	(1, 'Kinh nghiệm học tập', 'kinh-nghiem-hoc-tap', NULL, '2026-03-15 05:06:14', '2026-03-15 05:06:14'),
	(2, 'Sự kiện trung tâm', 'su-kien-trung-tam', NULL, '2026-03-15 05:06:14', '2026-03-15 05:06:14'),
	(3, 'Văn hóa Trung Hoa', 'van-hoa-trung-hoa', NULL, '2026-03-15 05:06:14', '2026-03-15 05:06:14');

-- Dumping structure for table doan1.password_reset_tokens
CREATE TABLE IF NOT EXISTS `password_reset_tokens` (
  `email` varchar(255) NOT NULL,
  `token` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`email`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table doan1.password_reset_tokens: ~0 rows (approximately)

-- Dumping structure for table doan1.rooms
CREATE TABLE IF NOT EXISTS `rooms` (
  `room_id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(100) NOT NULL,
  `capacity` int(11) NOT NULL,
  `location` varchar(255) DEFAULT NULL,
  `description` text DEFAULT NULL,
  `price` decimal(19,0) NOT NULL DEFAULT 0,
  `status` enum('available','maintenance','unavailable') NOT NULL DEFAULT 'available',
  `image` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`room_id`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table doan1.rooms: ~5 rows (approximately)
INSERT INTO `rooms` (`room_id`, `name`, `capacity`, `location`, `description`, `price`, `status`, `image`, `created_at`, `updated_at`) VALUES
	(1, 'Phòng A', 20, 'Tầng 1 - Khu A', NULL, 200000, 'available', 'room-images/01KKQY7KV25R3MEXANR43NYPNY.jpg', '2026-03-15 05:06:14', '2026-03-15 05:06:50'),
	(2, 'Phòng B', 15, 'Tầng 1 - Khu B', NULL, 150000, 'available', 'room-images/01KKQY7KV25R3MEXANR43NYPNY.jpg', '2026-03-15 05:06:14', '2026-03-15 05:06:14'),
	(3, 'Phòng C', 40, 'Tầng 2', NULL, 500000, 'available', 'room-images/01KKQY7KV25R3MEXANR43NYPNY.jpg', '2026-03-15 05:06:14', '2026-03-15 05:06:14'),
	(4, 'Phòng D', 12, 'Tầng 3', NULL, 300000, 'maintenance', 'room-images/01KKQY7KV25R3MEXANR43NYPNY.jpg', '2026-03-15 05:06:14', '2026-03-15 05:06:14'),
	(5, 'Phòng E', 6, 'Lầu 4', NULL, 400000, 'available', 'room-images/01KKQY7KV25R3MEXANR43NYPNY.jpg', '2026-03-15 05:06:14', '2026-03-15 05:06:14');

-- Dumping structure for table doan1.room_bookings
CREATE TABLE IF NOT EXISTS `room_bookings` (
  `booking_id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `room_id` bigint(20) unsigned DEFAULT NULL,
  `approved_by` bigint(20) unsigned DEFAULT NULL,
  `rejected_by` bigint(20) unsigned DEFAULT NULL,
  `cancelled_by` bigint(20) unsigned DEFAULT NULL,
  `created_by` bigint(20) unsigned DEFAULT NULL,
  `customer_name` varchar(255) DEFAULT NULL,
  `customer_email` varchar(255) DEFAULT NULL,
  `customer_phone` varchar(255) DEFAULT NULL,
  `reason` varchar(255) DEFAULT NULL,
  `payment_status` enum('unpaid','paid','refunded') NOT NULL DEFAULT 'unpaid',
  `total_amount` decimal(19,2) DEFAULT 0.00,
  `start_date` date NOT NULL,
  `end_date` date DEFAULT NULL,
  `start_time` time DEFAULT NULL,
  `end_time` time DEFAULT NULL,
  `status` enum('pending','approved','rejected','cancelled_by_customer','cancelled_by_admin') NOT NULL DEFAULT 'pending',
  `participants_count` int(10) unsigned DEFAULT 0,
  `notes` varchar(500) DEFAULT NULL,
  `booking_code` varchar(50) DEFAULT NULL,
  `repeat_days` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL COMMENT 'Các ngày trong tuần sẽ lặp lại (monday, tuesday, ...)' CHECK (json_valid(`repeat_days`)),
  `is_duplicate` tinyint(1) NOT NULL DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`booking_id`),
  UNIQUE KEY `room_bookings_booking_code_unique` (`booking_code`),
  KEY `fk_room_bookings_rejected_by` (`rejected_by`),
  KEY `fk_room_bookings_cancelled_by` (`cancelled_by`),
  KEY `room_bookings_room_id_start_date_end_date_index` (`room_id`,`start_date`,`end_date`),
  KEY `room_bookings_status_start_date_end_date_index` (`status`,`start_date`,`end_date`),
  KEY `idx_room_bookings_approvals` (`approved_by`,`rejected_by`,`cancelled_by`),
  KEY `idx_room_bookings_created` (`created_by`,`start_date`,`end_date`),
  CONSTRAINT `fk_room_bookings_approved_by` FOREIGN KEY (`approved_by`) REFERENCES `users` (`id`) ON DELETE SET NULL,
  CONSTRAINT `fk_room_bookings_cancelled_by` FOREIGN KEY (`cancelled_by`) REFERENCES `users` (`id`) ON DELETE SET NULL,
  CONSTRAINT `fk_room_bookings_created_by` FOREIGN KEY (`created_by`) REFERENCES `users` (`id`) ON DELETE SET NULL,
  CONSTRAINT `fk_room_bookings_rejected_by` FOREIGN KEY (`rejected_by`) REFERENCES `users` (`id`) ON DELETE SET NULL,
  CONSTRAINT `fk_room_bookings_room_id` FOREIGN KEY (`room_id`) REFERENCES `rooms` (`room_id`) ON DELETE SET NULL
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table doan1.room_bookings: ~6 rows (approximately)
INSERT INTO `room_bookings` (`booking_id`, `room_id`, `approved_by`, `rejected_by`, `cancelled_by`, `created_by`, `customer_name`, `customer_email`, `customer_phone`, `reason`, `payment_status`, `total_amount`, `start_date`, `end_date`, `start_time`, `end_time`, `status`, `participants_count`, `notes`, `booking_code`, `repeat_days`, `is_duplicate`, `created_at`, `updated_at`) VALUES
	(1, 1, 1, NULL, 1, 1, 'Phạm Trọng Tính', 'phamtinh999@gmail.com', '0399277101', 'hff 1222', 'unpaid', 0.00, '2026-03-17', '2026-03-17', '08:00:00', '09:00:00', 'cancelled_by_admin', 0, NULL, 'BKC9B997', '["thursday"]', 0, '2026-03-15 17:03:55', '2026-03-15 17:04:53'),
	(2, 1, 1, NULL, NULL, 1, 'Phạm Trọng Tính', 'phamtinh999@gmail.com', '0399277101', 'hợp nhóm', 'paid', 200000.00, '2026-03-18', '2026-03-18', '08:00:00', '09:00:00', 'approved', 0, NULL, 'BKE9CEE5', '[]', 0, '2026-03-16 09:20:17', '2026-03-16 09:29:38'),
	(3, 1, 1, NULL, 1, 1, 'Trần Minh Dững', 'dung@gmail.com', '0908071231', 'hợp nhóm', 'refunded', 200000.00, '2026-03-18', '2026-03-18', '08:00:00', '09:00:00', 'cancelled_by_admin', 0, NULL, 'BKB4F952', '[]', 0, '2026-03-16 09:20:55', '2026-03-16 09:27:44'),
	(4, 2, 1, NULL, NULL, 1, 'ADMIN', 'admin@localhost', '02399277101', 'hợp nhóm', 'paid', 150000.00, '2026-03-18', '2026-03-18', '08:00:00', '09:00:00', 'approved', 0, NULL, 'BKE2AF4A', '[]', 0, '2026-03-16 09:21:29', '2026-03-16 09:22:58'),
	(5, 3, 1, NULL, NULL, 1, 'Phạm Trọng Tính', 'p@gmail.com', '0399277101', 'hợp nhóm', 'unpaid', 7500000.00, '2026-03-17', '2026-03-31', '08:00:00', '09:00:00', 'approved', 0, NULL, 'BK16C76E', '["monday","wednesday","friday","sunday","tuesday","thursday","saturday"]', 0, '2026-03-16 09:21:59', '2026-03-16 09:23:32'),
	(6, 1, NULL, NULL, NULL, 1, 'Thien123', 't@123gmail.com', '0987654321', 'hợp nhóm', 'unpaid', 200000.00, '2026-03-18', '2026-03-18', '08:00:00', '09:00:00', 'pending', 0, NULL, 'BK6B3D3B', '[]', 1, '2026-03-16 09:29:06', '2026-03-16 09:29:23');

-- Dumping structure for table doan1.room_booking_details
CREATE TABLE IF NOT EXISTS `room_booking_details` (
  `booking_detail_id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `booking_id` bigint(20) unsigned NOT NULL,
  `approved_by` bigint(20) unsigned DEFAULT NULL,
  `rejected_by` bigint(20) unsigned DEFAULT NULL,
  `cancelled_by` bigint(20) unsigned DEFAULT NULL,
  `cancelled_by_customer` tinyint(1) NOT NULL DEFAULT 0,
  `booking_date` date NOT NULL,
  `start_time` time NOT NULL,
  `end_time` time NOT NULL,
  `status` enum('pending','approved','rejected','cancelled') NOT NULL DEFAULT 'pending',
  `is_duplicate` tinyint(1) NOT NULL DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`booking_detail_id`),
  KEY `fk_room_booking_details_approved_by` (`approved_by`),
  KEY `fk_room_booking_details_rejected_by` (`rejected_by`),
  KEY `fk_room_booking_details_cancelled_by` (`cancelled_by`),
  KEY `idx_room_booking_details_booking_date` (`booking_id`,`booking_date`),
  CONSTRAINT `fk_room_booking_details_approved_by` FOREIGN KEY (`approved_by`) REFERENCES `users` (`id`) ON DELETE SET NULL,
  CONSTRAINT `fk_room_booking_details_booking_id` FOREIGN KEY (`booking_id`) REFERENCES `room_bookings` (`booking_id`) ON DELETE CASCADE,
  CONSTRAINT `fk_room_booking_details_cancelled_by` FOREIGN KEY (`cancelled_by`) REFERENCES `users` (`id`) ON DELETE SET NULL,
  CONSTRAINT `fk_room_booking_details_rejected_by` FOREIGN KEY (`rejected_by`) REFERENCES `users` (`id`) ON DELETE SET NULL
) ENGINE=InnoDB AUTO_INCREMENT=20 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table doan1.room_booking_details: ~18 rows (approximately)
INSERT INTO `room_booking_details` (`booking_detail_id`, `booking_id`, `approved_by`, `rejected_by`, `cancelled_by`, `cancelled_by_customer`, `booking_date`, `start_time`, `end_time`, `status`, `is_duplicate`, `created_at`, `updated_at`) VALUES
	(1, 2, 1, NULL, NULL, 0, '2026-03-18', '08:00:00', '09:00:00', 'approved', 0, '2026-03-16 09:20:17', '2026-03-16 09:29:23'),
	(2, 3, 1, NULL, 1, 0, '2026-03-18', '08:00:00', '09:00:00', 'cancelled', 0, '2026-03-16 09:20:55', '2026-03-16 09:27:44'),
	(3, 4, 1, NULL, NULL, 0, '2026-03-18', '08:00:00', '09:00:00', 'approved', 0, '2026-03-16 09:21:29', '2026-03-16 09:22:29'),
	(4, 5, 1, NULL, NULL, 0, '2026-03-17', '08:00:00', '09:00:00', 'approved', 0, '2026-03-16 09:21:59', '2026-03-16 09:23:32'),
	(5, 5, 1, NULL, NULL, 0, '2026-03-18', '08:00:00', '09:00:00', 'approved', 0, '2026-03-16 09:21:59', '2026-03-16 09:23:32'),
	(6, 5, 1, NULL, NULL, 0, '2026-03-19', '08:00:00', '09:00:00', 'approved', 0, '2026-03-16 09:21:59', '2026-03-16 09:23:32'),
	(7, 5, 1, NULL, NULL, 0, '2026-03-20', '08:00:00', '09:00:00', 'approved', 0, '2026-03-16 09:21:59', '2026-03-16 09:23:32'),
	(8, 5, 1, NULL, NULL, 0, '2026-03-21', '08:00:00', '09:00:00', 'approved', 0, '2026-03-16 09:21:59', '2026-03-16 09:23:32'),
	(9, 5, 1, NULL, NULL, 0, '2026-03-22', '08:00:00', '09:00:00', 'approved', 0, '2026-03-16 09:21:59', '2026-03-16 09:23:32'),
	(10, 5, 1, NULL, NULL, 0, '2026-03-23', '08:00:00', '09:00:00', 'approved', 0, '2026-03-16 09:21:59', '2026-03-16 09:23:32'),
	(11, 5, 1, NULL, NULL, 0, '2026-03-24', '08:00:00', '09:00:00', 'approved', 0, '2026-03-16 09:21:59', '2026-03-16 09:23:32'),
	(12, 5, 1, NULL, NULL, 0, '2026-03-25', '08:00:00', '09:00:00', 'approved', 0, '2026-03-16 09:21:59', '2026-03-16 09:23:32'),
	(13, 5, 1, NULL, NULL, 0, '2026-03-26', '08:00:00', '09:00:00', 'approved', 0, '2026-03-16 09:21:59', '2026-03-16 09:23:32'),
	(14, 5, 1, NULL, NULL, 0, '2026-03-27', '08:00:00', '09:00:00', 'approved', 0, '2026-03-16 09:21:59', '2026-03-16 09:23:32'),
	(15, 5, 1, NULL, NULL, 0, '2026-03-28', '08:00:00', '09:00:00', 'approved', 0, '2026-03-16 09:21:59', '2026-03-16 09:23:32'),
	(16, 5, 1, NULL, NULL, 0, '2026-03-29', '08:00:00', '09:00:00', 'approved', 0, '2026-03-16 09:21:59', '2026-03-16 09:23:32'),
	(17, 5, 1, NULL, NULL, 0, '2026-03-30', '08:00:00', '09:00:00', 'approved', 0, '2026-03-16 09:21:59', '2026-03-16 09:23:32'),
	(18, 5, 1, NULL, NULL, 0, '2026-03-31', '08:00:00', '09:00:00', 'approved', 0, '2026-03-16 09:21:59', '2026-03-16 09:23:32'),
	(19, 6, NULL, NULL, NULL, 0, '2026-03-18', '08:00:00', '09:00:00', 'pending', 1, '2026-03-16 09:29:06', '2026-03-16 09:29:23');

-- Dumping structure for table doan1.room_equipments
CREATE TABLE IF NOT EXISTS `room_equipments` (
  `room_id` bigint(20) unsigned NOT NULL,
  `equipment_id` bigint(20) unsigned NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`room_id`,`equipment_id`),
  KEY `fk_room_equipments_equipment_id` (`equipment_id`),
  CONSTRAINT `fk_room_equipments_equipment_id` FOREIGN KEY (`equipment_id`) REFERENCES `equipments` (`equipment_id`) ON DELETE CASCADE,
  CONSTRAINT `fk_room_equipments_room_id` FOREIGN KEY (`room_id`) REFERENCES `rooms` (`room_id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table doan1.room_equipments: ~5 rows (approximately)
INSERT INTO `room_equipments` (`room_id`, `equipment_id`, `created_at`, `updated_at`) VALUES
	(1, 1, '2026-03-15 05:06:14', '2026-03-15 05:06:14'),
	(1, 4, '2026-03-15 05:06:14', '2026-03-15 05:06:14'),
	(3, 1, '2026-03-15 05:06:14', '2026-03-15 05:06:14'),
	(3, 3, '2026-03-15 05:06:14', '2026-03-15 05:06:14'),
	(3, 5, '2026-03-15 05:06:14', '2026-03-15 05:06:14');

-- Dumping structure for table doan1.sessions
CREATE TABLE IF NOT EXISTS `sessions` (
  `id` varchar(255) NOT NULL,
  `user_id` bigint(20) unsigned DEFAULT NULL,
  `ip_address` varchar(45) DEFAULT NULL,
  `user_agent` text DEFAULT NULL,
  `payload` longtext NOT NULL,
  `last_activity` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `sessions_user_id_index` (`user_id`),
  KEY `sessions_last_activity_index` (`last_activity`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table doan1.sessions: ~3 rows (approximately)
INSERT INTO `sessions` (`id`, `user_id`, `ip_address`, `user_agent`, `payload`, `last_activity`) VALUES
	('BYisngOEqf3Mf8adIs56E1XIjo1U8y0WZdyWYDCz', 1, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/146.0.0.0 Safari/537.36 Edg/146.0.0.0', 'YTo3OntzOjY6Il90b2tlbiI7czo0MDoiT3AzM0c0MGNoSU93dEFPYTBDcDBmM1ZEeDdvNTdUR29sOTJQN1dqaSI7czo2OiJfZmxhc2giO2E6Mjp7czozOiJuZXciO2E6MDp7fXM6Mzoib2xkIjthOjA6e319czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6NDg6Imh0dHA6Ly8xMjcuMC4wLjE6ODAwMC9hZG1pbi9jb3Vyc2UtcmVnaXN0cmF0aW9ucyI7fXM6MzoidXJsIjthOjA6e31zOjUwOiJsb2dpbl93ZWJfNTliYTM2YWRkYzJiMmY5NDAxNTgwZjAxNGM3ZjU4ZWE0ZTMwOTg5ZCI7aToxO3M6MTc6InBhc3N3b3JkX2hhc2hfd2ViIjtzOjYwOiIkMnkkMTIkWFVvdFlkYkV6cGZhNS8yRTAvejZ3ZXpKM0VBM0IyZDhDemVlM0NtZGZzbkJoR3FDbHgzdnEiO3M6ODoiZmlsYW1lbnQiO2E6MDp7fX0=', 1773666817),
	('CnMRH7rQtuLX4LZrPr9pDUB3blH5JbfZpUpA2QtW', 1, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/146.0.0.0 Safari/537.36 Edg/146.0.0.0', 'YTo1OntzOjY6Il90b2tlbiI7czo0MDoiUjZ5cmNOWDdXdzdtUmd5T1pVQnhZcVJjaU14Ymp2c0RENEFZdGpwYiI7czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6MjE6Imh0dHA6Ly8xMjcuMC4wLjE6ODAwMCI7fXM6NTA6ImxvZ2luX3dlYl81OWJhMzZhZGRjMmIyZjk0MDE1ODBmMDE0YzdmNThlYTRlMzA5ODlkIjtpOjE7czoxNzoicGFzc3dvcmRfaGFzaF93ZWIiO3M6NjA6IiQyeSQxMiRYVW90WWRiRXpwZmE1LzJFMC96NndlekozRUEzQjJkOEN6ZWUzQ21kZnNuQmhHcUNseDN2cSI7fQ==', 1773706024),
	('l01wXG3nM43rZSSarHbMIIgyCiaioeypq1CRoAGo', NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/146.0.0.0 Safari/537.36 Edg/146.0.0.0', 'YToyOntzOjY6Il90b2tlbiI7czo0MDoiSjA0TXZEVkNOeTlwN3RzaEVaY0hQRTB2OE9MYUphRzNBZ2RKUlRacCI7czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319fQ==', 1773655717);

-- Dumping structure for table doan1.settings
CREATE TABLE IF NOT EXISTS `settings` (
  `setting_id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `setting_key` varchar(50) NOT NULL,
  `setting_value` text DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`setting_id`),
  UNIQUE KEY `settings_setting_key_unique` (`setting_key`)
) ENGINE=InnoDB AUTO_INCREMENT=14 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table doan1.settings: ~13 rows (approximately)
INSERT INTO `settings` (`setting_id`, `setting_key`, `setting_value`, `created_at`, `updated_at`) VALUES
	(1, 'center_name', 'Trung Tâm Đào Tạo Ngôn Ngữ Trung Hoa Cần Thơ', '2026-03-15 05:23:25', '2026-03-15 05:23:25'),
	(2, 'phone', '+1234567890', '2026-03-15 05:23:25', '2026-03-15 05:23:25'),
	(3, 'email', 'lienhe@tiengtrungcantho.edu.vn', '2026-03-15 05:23:25', '2026-03-15 05:23:25'),
	(4, 'address', 'Số 123, Đường 3/2, Phường Xuân Khánh, Quận Ninh Kiều, TP. Cần Thơ', '2026-03-15 05:23:25', '2026-03-15 05:23:25'),
	(5, 'logo', 'logos/01KKQZ5ZFF2FZT868VANSA9VEE.avif', '2026-03-15 05:23:25', '2026-03-15 05:23:25'),
	(6, 'description', '<p>Trung tâm đào tạo tiếng Trung hàng đầu tại Đồng bằng sông Cửu Long với lộ trình cá nhân hóa, cam kết đầu ra HSK và TOCFL chỉ sau 3 tháng học.</p>', '2026-03-15 05:23:25', '2026-03-15 05:23:25'),
	(7, 'youtube_embed', NULL, '2026-03-15 05:23:25', '2026-03-15 05:23:25'),
	(8, 'course_unit', 'khóa', '2026-03-15 05:23:25', '2026-03-15 05:23:25'),
	(9, 'room_rental_unit', 'buổi', '2026-03-15 05:23:25', '2026-03-15 05:23:25'),
	(10, 'room_unit_to_hour', '1', '2026-03-15 05:23:25', '2026-03-15 05:23:25'),
	(11, 'google_map', 'https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3928.8473396395116!2d105.768426615233!3d10.029933792830635!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x31a0883d2192b0ef%3A0x80506371510443d3!2zS2h1IEjhu41jIExp4buHdSAtIMSQ4bqhaSBo4buNYyBD4bqnbiBUaMah!5e0!3m2!1svi!2s!4v1647000000000!5m2!1svi!2s', '2026-03-15 05:23:25', '2026-03-15 05:23:56'),
	(12, 'facebook_fanpage', NULL, '2026-03-15 05:23:25', '2026-03-15 05:23:25'),
	(13, 'zalo_embed', NULL, '2026-03-15 05:23:25', '2026-03-15 05:23:25');

-- Dumping structure for table doan1.sliders
CREATE TABLE IF NOT EXISTS `sliders` (
  `slider_id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `title` varchar(255) NOT NULL,
  `description` varchar(1000) DEFAULT NULL,
  `image_url` varchar(255) NOT NULL,
  `link_url` varchar(255) DEFAULT NULL,
  `position` int(11) NOT NULL DEFAULT 0,
  `is_active` tinyint(1) NOT NULL DEFAULT 1,
  `start_date` datetime DEFAULT NULL,
  `end_date` datetime DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`slider_id`),
  KEY `idx_sliders_position` (`position`),
  KEY `idx_sliders_active_dates` (`is_active`,`start_date`,`end_date`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table doan1.sliders: ~5 rows (approximately)
INSERT INTO `sliders` (`slider_id`, `title`, `description`, `image_url`, `link_url`, `position`, `is_active`, `start_date`, `end_date`, `created_at`, `updated_at`) VALUES
	(1, 'Chào mừng đến với Tiếng Trung Cần Thơ', 'Nơi chắp cánh ước mơ chinh phục Hán ngữ.', 'sliders/01KKQYDN0X22TESF2FQ66STRNE.jpg', 'http://127.0.0.1:8000/khoa-hoc', 1, 1, '2026-03-16 00:00:00', '2026-03-31 00:00:00', '2026-03-15 05:06:14', '2026-03-15 05:10:08'),
	(2, 'Khóa học HSK 3 cấp tốc - Cam kết đầu ra', 'Giảm 10% khi đăng ký trước ngày 20/03.', 'sliders/01KKQYDN0X22TESF2FQ66STRNE.jpg', 'http://127.0.0.1:8000/khoa-hoc', 2, 1, '2026-03-16 16:50:52', '2026-03-26 16:50:54', '2026-03-15 05:06:14', '2026-03-15 05:06:14'),
	(3, 'Học tiếng Trung qua bài hát', 'Câu lạc bộ sinh hoạt vào mỗi tối Thứ 7.', 'sliders/01KKQYDN0X22TESF2FQ66STRNE.jpg', 'http://127.0.0.1:8000/khoa-hoc', 3, 1, '2026-03-16 16:50:52', '2026-03-27 16:50:54', '2026-03-15 05:06:14', '2026-03-15 05:06:14'),
	(4, 'Không gian học tập hiện đại', 'Cơ sở vật chất đạt chuẩn quốc tế.', 'sliders/01KKQYDN0X22TESF2FQ66STRNE.jpg', 'http://127.0.0.1:8000/khoa-hoc', 4, 1, '2026-03-16 16:50:53', '2026-03-28 16:50:55', '2026-03-15 05:06:14', '2026-03-15 05:06:14'),
	(5, 'Đội ngũ giáo viên tâm huyết', 'Giáo viên bản xứ và thạc sĩ chuyên ngành.', 'sliders/01KKQYDN0X22TESF2FQ66STRNE.jpg', 'http://127.0.0.1:8000/khoa-hoc', 5, 1, '2026-03-16 16:50:53', '2026-04-01 16:50:55', '2026-03-15 05:06:14', '2026-03-15 05:06:14');

-- Dumping structure for table doan1.users
CREATE TABLE IF NOT EXISTS `users` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) NOT NULL,
  `remember_token` varchar(100) DEFAULT NULL,
  `role` enum('admin','subadmin','user') NOT NULL DEFAULT 'user',
  `status` enum('active','suspended','inactive') NOT NULL DEFAULT 'active',
  `suspended_at` timestamp NULL DEFAULT NULL,
  `suspended_by` bigint(20) unsigned DEFAULT NULL,
  `suspension_reason` text DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `users_email_unique` (`email`),
  KEY `fk_users_suspended_by` (`suspended_by`),
  CONSTRAINT `fk_users_suspended_by` FOREIGN KEY (`suspended_by`) REFERENCES `users` (`id`) ON DELETE SET NULL
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table doan1.users: ~6 rows (approximately)
INSERT INTO `users` (`id`, `name`, `email`, `email_verified_at`, `password`, `remember_token`, `role`, `status`, `suspended_at`, `suspended_by`, `suspension_reason`, `created_at`, `updated_at`) VALUES
	(1, 'Phạm Trọng Tính', 'test@gmail.com', NULL, '$2y$12$XUotYdbEzpfa5/2E0/z6wezJ3EA3B2d8Czee3CmdfsnBhGqClx3vq', 'kvLilfOPbVru45CVZVkIn3MKAu7Nb5DJUMrt2BZtTRG7QEcdgx1492MNLvoc', 'admin', 'active', NULL, NULL, NULL, '2025-12-01 03:00:00', '2026-03-16 11:25:53'),
	(2, 'Lý Tiểu Long', 'longlt@tiengtrungct.vn', NULL, '$2y$12$XUotYdbEzpfa5/2E0/z6wezJ3EA3B2d8Czee3CmdfsnBhGqClx3vq', NULL, 'subadmin', 'active', NULL, NULL, NULL, '2026-03-15 05:06:14', '2026-03-15 05:06:14'),
	(3, 'Nguyễn Thị Hoa', 'hoant@gmail.com', NULL, '$2y$12$XUotYdbEzpfa5/2E0/z6wezJ3EA3B2d8Czee3CmdfsnBhGqClx3vq', NULL, 'user', 'active', NULL, NULL, NULL, '2026-03-15 05:06:14', '2026-03-15 05:06:14'),
	(4, 'Vương Lực Hồng', 'hongvl@tiengtrungct.vn', NULL, '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', NULL, 'subadmin', 'active', NULL, NULL, NULL, '2026-03-15 05:06:14', '2026-03-15 05:06:14'),
	(5, 'Lê Văn Luyện', 'luyenlv@gmail.com', NULL, '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', NULL, 'user', 'active', NULL, NULL, NULL, '2026-03-15 05:06:14', '2026-03-15 05:06:14'),
	(6, 'Phạm Trọng Tính', 'phamtinh9099@gmail.com', NULL, '$2y$12$MrEhnoKeG13w5sTCFW.U5uoS9HSZ6EvI5Ipu596pFayYJH5vT8Mpy', 'vd8ejzUTTJ89LlNvBPiyUOQWATPfzBePHYZL3UXAdZBNbF7KU5fjRQ2LIqeQ', 'user', 'suspended', '2026-03-16 10:34:08', 1, 'đình chỉ', '2026-03-15 14:54:53', '2026-03-16 10:34:08');

/*!40103 SET TIME_ZONE=IFNULL(@OLD_TIME_ZONE, 'system') */;
/*!40101 SET SQL_MODE=IFNULL(@OLD_SQL_MODE, '') */;
/*!40014 SET FOREIGN_KEY_CHECKS=IFNULL(@OLD_FOREIGN_KEY_CHECKS, 1) */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40111 SET SQL_NOTES=IFNULL(@OLD_SQL_NOTES, 1) */;

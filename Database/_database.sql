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


-- Dumping database structure for lms_simple
CREATE DATABASE IF NOT EXISTS `lms_simple` /*!40100 DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci */;
USE `lms_simple`;

-- Dumping structure for table lms_simple.categories
CREATE TABLE IF NOT EXISTS `categories` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(100) NOT NULL,
  `slug` varchar(100) NOT NULL UNIQUE,
  `description` text DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Data exporting was unselected.

-- Dumping structure for table lms_simple.courses
CREATE TABLE IF NOT EXISTS `courses` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `created_by` bigint(20) unsigned DEFAULT NULL,
  `title` varchar(255) NOT NULL,
  `slug` varchar(255) NOT NULL UNIQUE,
  `description` text DEFAULT NULL,
  `content` longtext DEFAULT NULL,
  `featured_image` varchar(255) DEFAULT NULL,
  `price` decimal(19,0) NOT NULL DEFAULT 0,
  `is_price_visible` tinyint(1) NOT NULL DEFAULT 1,
  `end_registration_date` date DEFAULT NULL,
  `start_date` date DEFAULT NULL,
  `status` enum('draft','published','archived') NOT NULL DEFAULT 'draft',
  `max_students` int(11) DEFAULT NULL,
  `allow_overflow` tinyint(1) NOT NULL DEFAULT 0 COMMENT 'Cho phép nhận thêm học viên khi đã đủ số lượng',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `seo_description` varchar(2000) DEFAULT NULL,
  `seo_title` varchar(500) DEFAULT NULL,
  `seo_image` varchar(1000) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `courses_category_id_foreign` (`category_id`),
  KEY `courses_created_by_foreign` (`created_by`),
  CONSTRAINT `courses_category_id_foreign` FOREIGN KEY (`category_id`) REFERENCES `categories` (`id`),
  CONSTRAINT `courses_created_by_foreign` FOREIGN KEY (`created_by`) REFERENCES `users` (`id`) ON DELETE SET NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Data exporting was unselected.

-- Dumping structure for table lms_simple.course_registrations
CREATE TABLE IF NOT EXISTS `course_registrations` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `created_by` bigint(20) unsigned DEFAULT NULL,
  `course_id` bigint(20) unsigned NOT NULL,
  `registration_date` timestamp NOT NULL DEFAULT current_timestamp(),
  `status` enum('pending','confirmed','cancelled','completed') NOT NULL DEFAULT 'pending',
  `payment_status` enum('unpaid','paid','refunded') NOT NULL DEFAULT 'unpaid',
  `actual_price` decimal(15,0) DEFAULT NULL COMMENT 'Số tiền đã thu của học viên',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `student_name` varchar(255) NOT NULL,
  `student_email` varchar(255) DEFAULT NULL,
  `student_phone` varchar(255) NOT NULL,
  `student_address` varchar(255) DEFAULT NULL,
  `student_birth_date` date DEFAULT NULL,
  `student_gender` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `course_registrations_course_id_foreign` (`course_id`),
  KEY `course_registrations_created_by_foreign` (`created_by`),
  KEY `course_registrations_student_phone_index` (`student_phone`),
  CONSTRAINT `course_registrations_course_id_foreign` FOREIGN KEY (`course_id`) REFERENCES `courses` (`id`) ON DELETE CASCADE,
  CONSTRAINT `course_registrations_created_by_foreign` FOREIGN KEY (`created_by`) REFERENCES `users` (`id`) ON DELETE SET NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Data exporting was unselected.

-- Dumping structure for table lms_simple.equipments
CREATE TABLE IF NOT EXISTS `equipments` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `created_by` bigint(20) unsigned DEFAULT NULL,
  `name` varchar(100) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `equipments_created_by_foreign` (`created_by`),
  CONSTRAINT `equipments_created_by_foreign` FOREIGN KEY (`created_by`) REFERENCES `users` (`id`) ON DELETE SET NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Data exporting was unselected.

-- Dumping structure for table lms_simple.news
CREATE TABLE IF NOT EXISTS `news` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `title` varchar(500) DEFAULT NULL,
  `slug` varchar(500) DEFAULT NULL UNIQUE,
  `summary` text DEFAULT NULL,
  `content` longtext NOT NULL,
  `featured_image` varchar(255) DEFAULT NULL,
  `author_id` bigint(20) unsigned DEFAULT NULL,
  `is_featured` tinyint(1) NOT NULL DEFAULT 0,
  `is_published` tinyint(1) NOT NULL DEFAULT 0,
  `published_at` datetime DEFAULT NULL,
  `view_count` int(11) NOT NULL DEFAULT 0,
  `category_id` bigint(20) unsigned DEFAULT NULL,
  `seo_title` varchar(500) DEFAULT NULL,
  `seo_image` varchar(1000) DEFAULT NULL,
  `seo_description` varchar(2000) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `news_author_id_foreign` (`author_id`),
  KEY `news_category_id_foreign` (`category_id`),
  KEY `news_is_published_published_at_is_featured_index` (`is_published`,`published_at`,`is_featured`),
  CONSTRAINT `news_author_id_foreign` FOREIGN KEY (`author_id`) REFERENCES `users` (`id`) ON DELETE SET NULL,
  CONSTRAINT `news_category_id_foreign` FOREIGN KEY (`category_id`) REFERENCES `news_categories` (`id`) ON DELETE SET NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Data exporting was unselected.

-- Dumping structure for table lms_simple.news_categories
CREATE TABLE IF NOT EXISTS `news_categories` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) DEFAULT NULL,
  `slug` varchar(255) DEFAULT NULL UNIQUE,
  `description` text DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Data exporting was unselected.

-- Dumping structure for table lms_simple.rooms
CREATE TABLE IF NOT EXISTS `rooms` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(100) NOT NULL,
  `capacity` int(11) NOT NULL,
  `location` varchar(255) DEFAULT NULL,
  `description` text DEFAULT NULL,
  `status` enum('available','maintenance','unavailable') NOT NULL DEFAULT 'available',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `image` varchar(255) DEFAULT NULL,
  `price` decimal(19,0) NOT NULL DEFAULT 0,
  `seo_description` varchar(2000) DEFAULT NULL,
  `seo_title` varchar(500) DEFAULT NULL,
  `seo_image` varchar(1000) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Data exporting was unselected.

-- Dumping structure for table lms_simple.room_bookings
CREATE TABLE IF NOT EXISTS `room_bookings` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `room_id` bigint(20) unsigned DEFAULT NULL,
  `reason` varchar(255) DEFAULT NULL,
  `start_date` date NOT NULL,
  `end_date` date DEFAULT NULL,
  `start_time` time DEFAULT NULL,
  `end_time` time DEFAULT NULL,
  `status` enum('pending','approved','rejected','cancelled_by_customer','cancelled_by_admin') NOT NULL DEFAULT 'pending',
  `approved_by` bigint(20) unsigned DEFAULT NULL,
  `rejected_by` bigint(20) unsigned DEFAULT NULL,
  `cancelled_by` bigint(20) unsigned DEFAULT NULL,
  `created_by` bigint(20) unsigned DEFAULT NULL,
  `customer_name` varchar(255) DEFAULT NULL,
  `customer_email` varchar(255) DEFAULT NULL,
  `customer_phone` varchar(255) DEFAULT NULL,
  `participants_count` int(10) unsigned DEFAULT 0,
  `notes` varchar(500) DEFAULT NULL,
  `booking_code` varchar(50) DEFAULT NULL,
  `repeat_days` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL COMMENT 'Các ngày trong tuần sẽ lặp lại (monday, tuesday, ...)' CHECK (json_valid(`repeat_days`)),
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `is_duplicate` tinyint(1) NOT NULL DEFAULT 0,
  PRIMARY KEY (`id`),
  UNIQUE KEY `room_bookings_booking_code_unique` (`booking_code`),
  KEY `room_bookings_rejected_by_foreign` (`rejected_by`),
  KEY `room_bookings_cancelled_by_foreign` (`cancelled_by`),
  KEY `room_bookings_room_id_start_date_end_date_index` (`room_id`,`start_date`,`end_date`),
  KEY `room_bookings_status_start_date_end_date_index` (`status`,`start_date`,`end_date`),
  KEY `room_bookings_approved_by_rejected_by_cancelled_by_index` (`approved_by`,`rejected_by`,`cancelled_by`),
  KEY `room_bookings_created_by_start_date_end_date_index` (`created_by`,`start_date`,`end_date`),
  CONSTRAINT `room_bookings_approved_by_foreign` FOREIGN KEY (`approved_by`) REFERENCES `users` (`id`) ON DELETE SET NULL,
  CONSTRAINT `room_bookings_cancelled_by_foreign` FOREIGN KEY (`cancelled_by`) REFERENCES `users` (`id`) ON DELETE SET NULL,
  CONSTRAINT `room_bookings_created_by_foreign` FOREIGN KEY (`created_by`) REFERENCES `users` (`id`) ON DELETE SET NULL,
  CONSTRAINT `room_bookings_rejected_by_foreign` FOREIGN KEY (`rejected_by`) REFERENCES `users` (`id`) ON DELETE SET NULL,
  CONSTRAINT `room_bookings_room_id_foreign_20250713` FOREIGN KEY (`room_id`) REFERENCES `rooms` (`id`) ON DELETE SET NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;


-- Data exporting was unselected.

-- Dumping structure for table lms_simple.room_booking_details
CREATE TABLE IF NOT EXISTS `room_booking_details` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `room_booking_id` bigint(20) unsigned NOT NULL,
  `booking_date` date NOT NULL,
  `start_time` time NOT NULL,
  `end_time` time NOT NULL,
  `status` enum('pending','approved','rejected','cancelled') NOT NULL DEFAULT 'pending',
  `approved_by` bigint(20) unsigned DEFAULT NULL,
  `rejected_by` bigint(20) unsigned DEFAULT NULL,
  `cancelled_by` bigint(20) unsigned DEFAULT NULL,
  `cancelled_by_customer` tinyint(1) NOT NULL DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `is_duplicate` tinyint(1) NOT NULL DEFAULT 0,
  PRIMARY KEY (`id`),
  KEY `room_booking_details_approved_by_foreign` (`approved_by`),
  KEY `room_booking_details_rejected_by_foreign` (`rejected_by`),
  KEY `room_booking_details_cancelled_by_foreign` (`cancelled_by`),
  KEY `room_booking_details_room_booking_id_booking_date_index` (`room_booking_id`,`booking_date`),
  CONSTRAINT `room_booking_details_approved_by_foreign` FOREIGN KEY (`approved_by`) REFERENCES `users` (`id`) ON DELETE SET NULL,
  CONSTRAINT `room_booking_details_cancelled_by_foreign` FOREIGN KEY (`cancelled_by`) REFERENCES `users` (`id`) ON DELETE SET NULL,
  CONSTRAINT `room_booking_details_rejected_by_foreign` FOREIGN KEY (`rejected_by`) REFERENCES `users` (`id`) ON DELETE SET NULL,
  CONSTRAINT `room_booking_details_room_booking_id_foreign` FOREIGN KEY (`room_booking_id`) REFERENCES `room_bookings` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Data exporting was unselected.



-- Data exporting was unselected.

-- Dumping structure for table lms_simple.room_equipments
CREATE TABLE IF NOT EXISTS `room_equipments` (
  `room_id` bigint(20) unsigned NOT NULL,
  `equipment_id` bigint(20) unsigned NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`room_id`,`equipment_id`),
  KEY `room_equipments_equipment_id_foreign` (`equipment_id`),
  CONSTRAINT `room_equipments_equipment_id_foreign` FOREIGN KEY (`equipment_id`) REFERENCES `equipments` (`id`) ON DELETE CASCADE,
  CONSTRAINT `room_equipments_room_id_foreign` FOREIGN KEY (`room_id`) REFERENCES `rooms` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Data exporting was unselected.

-- Dumping structure for table lms_simple.settings
CREATE TABLE IF NOT EXISTS `settings` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `setting_key` varchar(50) NOT NULL,
  `setting_value` text DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `settings_setting_key_unique` (`setting_key`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Data exporting was unselected.

-- Dumping structure for table lms_simple.sliders
CREATE TABLE IF NOT EXISTS `sliders` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `title` varchar(255) NOT NULL,
  `description` varchar(1000) DEFAULT NULL,
  `image_url` varchar(255) NOT NULL,
  `link_url` varchar(255) DEFAULT NULL,
  `position` int(11) NOT NULL DEFAULT 0,
  `is_active` tinyint(1) NOT NULL DEFAULT 1,
  `start_date` datetime DEFAULT NULL,
  `end_date` datetime DEFAULT NULL,
  `created_by` bigint(20) unsigned DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `sliders_created_by_foreign` (`created_by`),
  KEY `sliders_is_active_start_date_end_date_index` (`is_active`,`start_date`,`end_date`),
  KEY `sliders_position_index` (`position`),
  CONSTRAINT `sliders_created_by_foreign` FOREIGN KEY (`created_by`) REFERENCES `users` (`id`) ON DELETE SET NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Data exporting was unselected.

-- Dumping structure for table lms_simple.users
CREATE TABLE IF NOT EXISTS `users` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) NOT NULL,
  `remember_token` varchar(100) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `role` enum('admin','subadmin','user') NOT NULL DEFAULT 'user',
  `status` enum('active','suspended','inactive') NOT NULL DEFAULT 'active',
  `suspended_at` timestamp NULL DEFAULT NULL,
  `suspended_by` bigint(20) unsigned DEFAULT NULL,
  `suspension_reason` text DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `users_email_unique` (`email`),
  KEY `users_suspended_by_foreign` (`suspended_by`),
  CONSTRAINT `users_suspended_by_foreign` FOREIGN KEY (`suspended_by`) REFERENCES `users` (`id`) ON DELETE SET NULL
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Data exporting was unselected.

/*!40103 SET TIME_ZONE=IFNULL(@OLD_TIME_ZONE, 'system') */;
/*!40101 SET SQL_MODE=IFNULL(@OLD_SQL_MODE, '') */;
/*!40014 SET FOREIGN_KEY_CHECKS=IFNULL(@OLD_FOREIGN_KEY_CHECKS, 1) */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40111 SET SQL_NOTES=IFNULL(@OLD_SQL_NOTES, 1) */;


-- Tạo tài khoản admin
INSERT INTO `users` (`id`, `name`, `email`, `email_verified_at`, `password`, `remember_token`, `created_at`, `updated_at`, `role`, `status`) VALUES
(1, 'Admin Quản Trị', 'admin@lms.edu.vn', NOW(), '$2y$12$ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz123456', NULL, NOW(), NOW(), 'admin', 'active'),
(2, 'Giảng Viên Nguyễn Văn A', 'giangvien@lms.edu.vn', NOW(), '$2y$12$ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz123456', NULL, NOW(), NOW(), 'subadmin', 'active'),
(3, 'Nhân Viên Lễ Tân', 'nhanvien@lms.edu.vn', NOW(), '$2y$12$ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz123456', NULL, NOW(), NOW(), 'subadmin', 'active'),
(4, 'Học Viên Trần Văn B', 'hocvien1@lms.edu.vn', NOW(), '$2y$12$ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz123456', NULL, NOW(), NOW(), 'user', 'active'),
(5, 'Học Viên Lê Thị C', 'hocvien2@lms.edu.vn', NOW(), '$2y$12$ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz123456', NULL, NOW(), NOW(), 'user', 'active');

-- Note: Password mặc định cho tất cả tài khoản là "password123"

INSERT INTO `categories` (`id`, `name`, `slug`, `description`, `created_at`, `updated_at`) VALUES
(1, 'Lập trình Web', 'lap-trinh-web', 'Các khóa học lập trình web từ cơ bản đến nâng cao', NOW(), NOW()),
(2, 'Thiết kế đồ họa', 'thiet-ke-do-hoa', 'Khóa học về thiết kế đồ họa, UI/UX', NOW(), NOW()),
(3, 'Tiếng Anh', 'tieng-anh', 'Khóa học tiếng Anh giao tiếp và chuyên ngành', NOW(), NOW()),
(4, 'Kinh doanh & Marketing', 'kinh-doanh-marketing', 'Đào tạo kỹ năng kinh doanh và marketing', NOW(), NOW()),
(5, 'Kỹ năng mềm', 'ky-nang-mem', 'Phát triển kỹ năng mềm cho công việc', NOW(), NOW());

INSERT INTO `courses` (`id`, `created_by`, `title`, `slug`, `description`, `content`, `featured_image`, `price`, `is_price_visible`, `category_id`, `end_registration_date`, `start_date`, `status`, `max_students`, `allow_overflow`, `created_at`, `updated_at`, `seo_description`, `seo_title`, `seo_image`) VALUES
(1, 2, 'Lập trình Web Fullstack với Laravel', 'lap-trinh-web-fullstack-laravel', 'Khóa học toàn diện về phát triển web với Laravel', '<p>Khóa học cung cấp kiến thức toàn diện về phát triển web với Laravel framework.</p>', 'https://images.unsplash.com/photo-1555066931-4365d14bab8c', 5000000, 1, 1, '2024-12-31', '2024-11-01', 'published', 30, 1, NOW(), NOW(), 'Học Laravel từ cơ bản đến nâng cao, xây dựng ứng dụng web hoàn chỉnh', 'Khóa học Laravel Fullstack', 'https://images.unsplash.com/photo-1555066931-4365d14bab8c'),
(2, 2, 'Thiết kế UI/UX chuyên nghiệp', 'thiet-ke-ui-ux-chuyen-nghiep', 'Học thiết kế giao diện và trải nghiệm người dùng', '<p>Khóa học thiết kế UI/UX cho các ứng dụng web và mobile.</p>', 'https://images.unsplash.com/photo-1561070791-2526d30994b5', 4000000, 1, 2, '2024-12-15', '2024-11-10', 'published', 25, 0, NOW(), NOW(), 'Khóa học thiết kế UI/UX từ cơ bản đến nâng cao', 'Thiết kế UI/UX chuyên nghiệp', 'https://images.unsplash.com/photo-1561070791-2526d30994b5'),
(3, 2, 'Tiếng Anh giao tiếp cho Developer', 'tieng-anh-giao-tiep-cho-developer', 'Cải thiện kỹ năng tiếng Anh chuyên ngành IT', '<p>Khóa học tiếng Anh chuyên ngành công nghệ thông tin.</p>', 'https://images.unsplash.com/photo-1503676260728-1c00da094a0b', 3000000, 1, 3, '2024-11-30', '2024-11-05', 'published', 40, 1, NOW(), NOW(), 'Học tiếng Anh chuyên ngành IT hiệu quả', 'Tiếng Anh cho Developer', 'https://images.unsplash.com/photo-1503676260728-1c00da094a0b'),
(4, 2, 'Digital Marketing cơ bản', 'digital-marketing-co-ban', 'Nhập môn Digital Marketing cho người mới bắt đầu', '<p>Khóa học marketing online cơ bản.</p>', 'https://images.unsplash.com/photo-1460925895917-afdab827c52f', 2500000, 1, 4, '2024-12-20', '2024-11-15', 'published', 35, 1, NOW(), NOW(), 'Khóa học digital marketing cho người mới bắt đầu', 'Digital Marketing cơ bản', 'https://images.unsplash.com/photo-1460925895917-afdab827c52f'),
(5, 2, 'Kỹ năng thuyết trình chuyên nghiệp', 'ky-nang-thuyet-trinh-chuyen-nghiep', 'Nâng cao kỹ năng thuyết trình và giao tiếp', '<p>Phát triển kỹ năng thuyết trình hiệu quả.</p>', 'https://images.unsplash.com/photo-1580894894513-541e068a3e2b', 2000000, 0, 5, NULL, '2024-11-20', 'published', 50, 1, NOW(), NOW(), 'Rèn luyện kỹ năng thuyết trình chuyên nghiệp', 'Kỹ năng thuyết trình', 'https://images.unsplash.com/photo-1580894894513-541e068a3e2b'),
(6, 2, 'ReactJS Nâng cao', 'reactjs-nang-cao', 'Khóa học ReactJS cho developer có kinh nghiệm', '<p>Chuyên sâu về React và hệ sinh thái.</p>', 'https://images.unsplash.com/photo-1633356122544-f134324a6cee', 4500000, 1, 1, '2024-12-10', '2024-11-25', 'draft', 20, 0, NOW(), NOW(), 'Khóa học ReactJS nâng cao cho developer', 'ReactJS Nâng cao', 'https://images.unsplash.com/photo-1633356122544-f134324a6cee');

INSERT INTO `course_registrations` (`id`, `created_by`, `course_id`, `registration_date`, `status`, `payment_status`, `actual_price`, `created_at`, `updated_at`, `student_name`, `student_email`, `student_phone`, `student_address`, `student_birth_date`, `student_gender`) VALUES
(1, 4, 1, NOW(), 'confirmed', 'paid', 5000000, NOW(), NOW(), 'Trần Văn B', 'hocvien1@lms.edu.vn', '0987654321', '123 Nguyễn Trãi, Q.1, TP.HCM', '2000-05-15', 'male'),
(2, 5, 1, NOW(), 'confirmed', 'paid', 5000000, NOW(), NOW(), 'Lê Thị C', 'hocvien2@lms.edu.vn', '0976543210', '456 Lê Lợi, Q.3, TP.HCM', '1999-08-20', 'female'),
(3, NULL, 1, NOW(), 'pending', 'unpaid', NULL, NOW(), NOW(), 'Phạm Văn D', 'phamvand@gmail.com', '0965432109', '789 Cách Mạng Tháng 8, Q.10, TP.HCM', '2001-03-10', 'male'),
(4, NULL, 2, NOW(), 'confirmed', 'paid', 4000000, NOW(), NOW(), 'Nguyễn Thị E', 'nguyentie@gmail.com', '0954321098', '321 Võ Văn Tần, Q.3, TP.HCM', '1998-11-25', 'female'),
(5, NULL, 3, NOW(), 'confirmed', 'unpaid', NULL, NOW(), NOW(), 'Hoàng Văn F', 'hoangvanf@gmail.com', '0943210987', '654 Điện Biên Phủ, Bình Thạnh, TP.HCM', '2002-07-05', 'male');

INSERT INTO `rooms` (`id`, `name`, `capacity`, `location`, `description`, `status`, `created_at`, `updated_at`, `image`, `price`, `seo_description`, `seo_title`, `seo_image`) VALUES
(1, 'Phòng học 101', 30, 'Tầng 1, Tòa nhà A', 'Phòng học tiêu chuẩn với máy chiếu và điều hòa', 'available', NOW(), NOW(), 'https://images.unsplash.com/photo-1497366216548-37526070297c', 500000, 'Phòng học 30 chỗ ngồi, trang bị đầy đủ thiết bị giảng dạy', 'Phòng học 101 - 30 chỗ', 'https://images.unsplash.com/photo-1497366216548-37526070297c'),
(2, 'Phòng học 201', 50, 'Tầng 2, Tòa nhà A', 'Phòng học lớn với hệ thống âm thanh chuyên nghiệp', 'available', NOW(), NOW(), 'https://images.unsplash.com/photo-1523050854058-8df90110c9f1', 800000, 'Phòng học 50 chỗ, phù hợp cho hội thảo và lớp học lớn', 'Phòng học 201 - 50 chỗ', 'https://images.unsplash.com/photo-1523050854058-8df90110c9f1'),
(3, 'Phòng thực hành IT', 20, 'Tầng 3, Tòa nhà B', 'Phòng máy tính với 20 máy cấu hình cao', 'available', NOW(), NOW(), 'https://images.unsplash.com/photo-1517077304055-6e89abbf09b0', 600000, 'Phòng thực hành IT với 20 máy tính cấu hình cao', 'Phòng thực hành IT', 'https://images.unsplash.com/photo-1517077304055-6e89abbf09b0'),
(4, 'Phòng họp nhỏ', 10, 'Tầng 1, Tòa nhà B', 'Phòng họp nhỏ cho nhóm làm việc', 'available', NOW(), NOW(), 'https://images.unsplash.com/photo-1560066984-138dadb4c035', 300000, 'Phòng họp nhỏ 10 người, tiện nghi', 'Phòng họp nhỏ 10 chỗ', 'https://images.unsplash.com/photo-1560066984-138dadb4c035'),
(5, 'Phòng học 301', 40, 'Tầng 3, Tòa nhà A', 'Phòng học đa năng với thiết bị hiện đại', 'maintenance', NOW(), NOW(), 'https://images.unsplash.com/photo-1542744095-fcf48d80b0fd', 700000, 'Phòng học 40 chỗ với thiết bị giảng dạy hiện đại', 'Phòng học 301 - 40 chỗ', 'https://images.unsplash.com/photo-1542744095-fcf48d80b0fd');

INSERT INTO `equipments` (`id`, `created_by`, `name`, `price`, `is_free`, `created_at`, `updated_at`) VALUES
(1, 1, 'Máy chiếu Pro', 50000, 0, NOW(), NOW()),
(2, 1, 'Loa Bluetooth', 30000, 0, NOW(), NOW()),
(3, 1, 'Micro không dây', 20000, 0, NOW(), NOW()),
(4, 1, 'Bảng trắng', 10000, 1, NOW(), NOW()),
(5, 1, 'Máy tính để bàn', 50000, 0, NOW(), NOW()),
(6, 1, 'Webcam HD', 15000, 0, NOW(), NOW());

INSERT INTO `room_equipments` (`room_id`, `equipment_id`, `created_at`, `updated_at`) VALUES
(1, 1, NOW(), NOW()),
(1, 4, NOW(), NOW()),
(2, 1, NOW(), NOW()),
(2, 2, NOW(), NOW()),
(2, 3, NOW(), NOW()),
(2, 4, NOW(), NOW()),
(3, 5, NOW(), NOW()),
(3, 1, NOW(), NOW()),
(4, 4, NOW(), NOW()),
(5, 1, NOW(), NOW()),
(5, 2, NOW(), NOW()),
(5, 3, NOW(), NOW());

INSERT INTO `room_bookings` (`id`, `room_id`, `reason`, `start_date`, `end_date`, `start_time`, `end_time`, `status`, `approved_by`, `rejected_by`, `cancelled_by`, `created_by`, `customer_name`, `customer_email`, `customer_phone`, `participants_count`, `notes`, `booking_code`, `repeat_days`, `created_at`, `updated_at`, `is_duplicate`) VALUES
(1, 1, 'Lớp học Laravel', '2024-11-05', '2024-11-05', '08:00:00', '12:00:00', 'approved', 1, NULL, NULL, 2, 'Giảng Viên Nguyễn Văn A', 'giangvien@lms.edu.vn', '0912345678', 25, 'Cần máy chiếu và bảng trắng', 'BOOK001', NULL, NOW(), NOW(), 0),
(2, 2, 'Hội thảo Digital Marketing', '2024-11-10', '2024-11-10', '13:00:00', '17:00:00', 'approved', 1, NULL, NULL, 3, 'Công ty ABC', 'contact@abc.com', '0987654321', 45, 'Cần setup sân khấu', 'BOOK002', NULL, NOW(), NOW(), 0),
(3, 3, 'Thực hành lập trình', '2024-11-12', '2024-11-12', '08:00:00', '16:00:00', 'pending', NULL, NULL, NULL, 2, 'Giảng Viên Nguyễn Văn A', 'giangvien@lms.edu.vn', '0912345678', 18, 'Cần 20 máy tính', 'BOOK003', NULL, NOW(), NOW(), 0),
(4, 1, 'Lớp học thường kỳ', '2024-11-01', '2024-12-31', '13:00:00', '17:00:00', 'approved', 1, NULL, NULL, 2, 'Trung tâm đào tạo', 'training@lms.edu.vn', '0911111111', 30, 'Lớp học thứ 2-4-6 hàng tuần', 'BOOK004', '["monday", "wednesday", "friday"]', NOW(), NOW(), 0),
(5, 4, 'Họp nhóm dự án', '2024-11-08', '2024-11-08', '09:00:00', '11:00:00', 'cancelled_by_customer', NULL, NULL, NULL, 4, 'Trần Văn B', 'hocvien1@lms.edu.vn', '0987654321', 8, 'Đã hủy do lịch trùng', 'BOOK005', NULL, NOW(), NOW(), 0);

-- Tạo chi tiết booking cho booking có repeat_days
INSERT INTO `room_booking_details` (`id`, `room_booking_id`, `booking_date`, `start_time`, `end_time`, `status`, `approved_by`, `rejected_by`, `cancelled_by`, `cancelled_by_customer`, `created_at`, `updated_at`, `is_duplicate`) VALUES
(1, 4, '2024-11-04', '13:00:00', '17:00:00', 'approved', 1, NULL, NULL, 0, NOW(), NOW(), 0),
(2, 4, '2024-11-06', '13:00:00', '17:00:00', 'approved', 1, NULL, NULL, 0, NOW(), NOW(), 0),
(3, 4, '2024-11-08', '13:00:00', '17:00:00', 'approved', 1, NULL, NULL, 0, NOW(), NOW(), 0),
(4, 4, '2024-11-11', '13:00:00', '17:00:00', 'approved', 1, NULL, NULL, 0, NOW(), NOW(), 0),
(5, 4, '2024-11-13', '13:00:00', '17:00:00', 'approved', 1, NULL, NULL, 0, NOW(), NOW(), 0);

INSERT INTO `news_categories` (`id`, `name`, `slug`, `description`, `created_at`, `updated_at`) VALUES
(1, 'Tin tức', 'tin-tuc', 'Các tin tức chung về giáo dục và đào tạo', NOW(), NOW()),
(2, 'Sự kiện', 'su-kien', 'Các sự kiện, hội thảo sắp diễn ra', NOW(), NOW()),
(3, 'Khuyến học', 'khuyen-hoc', 'Thông tin học bổng, ưu đãi học phí', NOW(), NOW()),
(4, 'Tuyển dụng', 'tuyen-dung', 'Thông tin tuyển dụng và cơ hội việc làm', NOW(), NOW()),
(5, 'Thông báo', 'thong-bao', 'Thông báo quan trọng từ trung tâm', NOW(), NOW());

INSERT INTO `news` (`id`, `title`, `slug`, `summary`, `content`, `featured_image`, `author_id`, `is_featured`, `is_published`, `published_at`, `view_count`, `category_id`, `seo_title`, `seo_image`, `seo_description`, `created_at`, `updated_at`) VALUES
(1, 'Khai giảng khóa học Laravel Fullstack tháng 11/2024', 'khai-giang-khoa-hoc-laravel-fullstack-thang-11-2024', 'Trung tâm thông báo khai giảng khóa học Laravel Fullstack với nhiều ưu đãi hấp dẫn', '<p>Chúng tôi xin thông báo khai giảng khóa học Laravel Fullstack vào ngày 01/11/2024.</p>', 'https://images.unsplash.com/photo-1551650975-87deedd944c3', 1, 1, 1, '2024-10-15 09:00:00', 150, 1, 'Khai giảng Laravel Fullstack tháng 11', 'https://images.unsplash.com/photo-1551650975-87deedd944c3', 'Thông tin khai giảng khóa học Laravel Fullstack', NOW(), NOW()),
(2, 'Hội thảo Digital Marketing miễn phí', 'hoi-thao-digital-marketing-mien-phi', 'Tham gia hội thảo Digital Marketing với diễn giả hàng đầu', '<p>Hội thảo sẽ diễn ra vào ngày 10/11/2024 tại phòng 201.</p>', 'https://images.unsplash.com/photo-1460925895917-afdab827c52f', 1, 1, 1, '2024-10-10 10:00:00', 200, 2, 'Hội thảo Digital Marketing miễn phí', 'https://images.unsplash.com/photo-1460925895917-afdab827c52f', 'Đăng ký tham gia hội thảo Digital Marketing miễn phí', NOW(), NOW()),
(3, 'Ưu đãi 20% học phí cho sinh viên', 'uu-dai-20-hoc-phi-cho-sinh-vien', 'Chương trình ưu đãi đặc biệt dành cho sinh viên các trường đại học', '<p>Áp dụng cho tất cả các khóa học từ nay đến hết năm 2024.</p>', 'https://images.unsplash.com/photo-1523050854058-8df90110c9f1', 1, 0, 1, '2024-10-01 08:00:00', 300, 3, 'Ưu đãi 20% học phí sinh viên', 'https://images.unsplash.com/photo-1523050854058-8df90110c9f1', 'Ưu đãi học phí đặc biệt cho sinh viên', NOW(), NOW()),
(4, 'Tuyển dụng giảng viên lập trình', 'tuyen-dung-giang-vien-lap-trinh', 'Trung tâm cần tuyển giảng viên lập trình full-time và part-time', '<p>Yêu cầu: 2+ năm kinh nghiệm, nhiệt tình, có khả năng giảng dạy.</p>', 'https://images.unsplash.com/photo-1521791055366-0d553872125f', 1, 0, 1, '2024-10-05 14:00:00', 120, 4, 'Tuyển dụng giảng viên lập trình', 'https://images.unsplash.com/photo-1521791055366-0d553872125f', 'Thông tin tuyển dụng giảng viên lập trình', NOW(), NOW()),
(5, 'Thông báo nghỉ lễ 20/11', 'thong-bao-nghi-le-20-11', 'Trung tâm sẽ nghỉ lễ Ngày Nhà giáo Việt Nam 20/11', '<p>Tất cả các lớp học sẽ được nghỉ vào ngày 20/11/2024.</p>', 'https://images.unsplash.com/photo-1571260899304-425eee4c7efc', 1, 0, 1, '2024-10-20 15:00:00', 80, 5, 'Thông báo nghỉ lễ 20/11', 'https://images.unsplash.com/photo-1571260899304-425eee4c7efc', 'Lịch nghỉ lễ Ngày Nhà giáo Việt Nam', NOW(), NOW());

INSERT INTO `sliders` (`id`, `title`, `description`, `image_url`, `link_url`, `position`, `is_active`, `start_date`, `end_date`, `created_by`, `created_at`, `updated_at`) VALUES
(1, 'Ưu đãi học phí mùa thu 2024', 'Giảm đến 30% học phí các khóa học công nghệ thông tin', 'https://images.unsplash.com/photo-1522202176988-66273c2fd55f', '/courses', 1, 1, '2024-10-01 00:00:00', '2024-12-31 23:59:59', 1, NOW(), NOW()),
(2, 'Hội thảo Digital Marketing miễn phí', 'Tham gia hội thảo với chuyên gia hàng đầu', 'https://images.unsplash.com/photo-1551434678-e076c223a692', '/news/hoi-thao-digital-marketing-mien-phi', 2, 1, '2024-10-10 00:00:00', '2024-11-10 23:59:59', 1, NOW(), NOW()),
(3, 'Khai giảng khóa học mới', 'Lập trình Fullstack với Laravel và React', 'https://images.unsplash.com/photo-1516321318423-f06f85e504b3', '/courses/lap-trinh-web-fullstack-laravel', 3, 1, '2024-10-15 00:00:00', '2024-11-15 23:59:59', 1, NOW(), NOW()),
(4, 'Trung tâm đào tạo chất lượng cao', 'Cam kết việc làm sau khi tốt nghiệp', 'https://images.unsplash.com/photo-1523050854058-8df90110c9f1', '/about', 4, 1, '2024-01-01 00:00:00', '2024-12-31 23:59:59', 1, NOW(), NOW());

-- Xóa dữ liệu cũ trong bảng settings nếu có
DELETE FROM `settings`;

-- Thêm dữ liệu mới với chỉ các setting key được yêu cầu
INSERT INTO `settings` (`id`, `setting_key`, `setting_value`, `created_at`, `updated_at`) VALUES
(1, 'center_name', 'Trung Tâm Đào Tạo Công Nghệ LMS', NOW(), NOW()),
(2, 'address', 'Số 123 Đường Nguyễn Văn Linh, Phường Tân Phong, Quận 7, TP. Hồ Chí Minh', NOW(), NOW()),
(3, 'phone', '0287 1234 567 - Hotline: 0909 888 777', NOW(), NOW()),
(4, 'email', 'info@lms.edu.vn | tuvan@lms.edu.vn | daotao@lms.edu.vn', NOW(), NOW()),
(5, 'logo', 'https://images.unsplash.com/photo-1599302590091-152b5c5b9c15?w=200&h=200&fit=crop&crop=center', NOW(), NOW()),
(6, 'description', 'Trung tâm đào tạo công nghệ thông tin hàng đầu tại TP.HCM với hơn 10 năm kinh nghiệm. Chúng tôi cung cấp các khóa học chất lượng cao về lập trình, thiết kế, marketing và kỹ năng mềm cho doanh nghiệp và cá nhân.', NOW(), NOW()),
(7, 'google_map', '<iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3919.39531480275!2d106.7058261758951!3d10.78283788935621!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x31752f38b0b1c5a5%3A0xd201d719c52c8c31!2sVincom%20Center%20Landmark%2081!5e0!3m2!1svi!2s!4v1699861234567!5m2!1svi!2s" width="100%" height="450" style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>', NOW(), NOW()),
(8, 'facebook_fanpage', 'https://www.facebook.com/trungtamdaotaolms', NOW(), NOW()),
(9, 'zalo_embed', '<div class="zalo-chat-widget" data-oaid="579745863508884884" data-welcome-message="Chào bạn! Trung tâm LMS có thể giúp gì cho bạn?" data-autopopup="1" data-autopopuptime="15" data-width="350" data-height="420"></div><script src="https://sp.zalo.me/plugins/sdk.js"></script>', NOW(), NOW()),
(10, 'youtube_embed', '<iframe width="100%" height="315" src="https://www.youtube.com/embed/XIMLoLxmTDw" title="Giới thiệu Trung Tâm Đào Tạo LMS" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>', NOW(), NOW()),
(11, 'custom_css', '', NOW(), NOW()),
(12, 'custom_js', ' ', NOW(), NOW()),
(13, 'course_unit', 'khóa học', NOW(), NOW()),
(14, 'room_rental_unit', 'buổi', NOW(), NOW()),
(15, 'room_unit_to_hour', '2', NOW(), NOW()),
(16, 'seo_title', 'Trung Tâm Đào Tạo Công Nghệ LMS | Đào Tạo CNTT Chuyên Nghiệp', NOW(), NOW()),
(17, 'seo_description', 'Trung tâm đào tạo công nghệ thông tin uy tín tại TP.HCM. Các khóa học lập trình, thiết kế đồ họa, digital marketing, kỹ năng mềm. Cam kết chất lượng, hỗ trợ việc làm.', NOW(), NOW()),
(18, 'seo_image', 'https://images.unsplash.com/photo-1522202176988-66273c2fd55f?w=1200&h=630&fit=crop&crop=center', NOW(), NOW()),
(19, 'seo_keywords', 'đào tạo công nghệ thông tin, học lập trình web, khóa học thiết kế đồ họa, đào tạo digital marketing, học tiếng anh IT, đào tạo kỹ năng mềm, trung tâm tin học uy tín', NOW(), NOW()),
(22, 'ga_head', '', NOW(), NOW()),
(23, 'ga_body', '', NOW(), NOW());


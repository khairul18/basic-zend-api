<?php

declare(strict_types=1);

namespace DoctrineORMModule\Migrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220124051349 extends AbstractMigration
{
    public function up(Schema $schema): void
    {
        $createTable = <<<SQL
        SET FOREIGN_KEY_CHECKS = 0 ;
        START TRANSACTION;
        COMMIT;
SQL;
        $this->addSql($createTable);

        $createTable = <<<SQL
            SET FOREIGN_KEY_CHECKS = 0 ;
            START TRANSACTION;
            CREATE TABLE `account` (
            `uuid` varchar(36) COLLATE utf8_unicode_ci NOT NULL,
            `name` varchar(128) COLLATE utf8_unicode_ci NOT NULL,
            `note` text COLLATE utf8_unicode_ci,
            `email` varchar(64) COLLATE utf8_unicode_ci DEFAULT NULL,
            `address` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
            `city` varchar(64) COLLATE utf8_unicode_ci DEFAULT NULL,
            `state` varchar(64) COLLATE utf8_unicode_ci DEFAULT NULL,
            `phone` varchar(128) COLLATE utf8_unicode_ci DEFAULT NULL,
            `currency` varchar(5) COLLATE utf8_unicode_ci DEFAULT NULL,
            `country_id` varchar(2) COLLATE utf8_unicode_ci DEFAULT NULL,
            `fcm_broadcast_topic` varchar(256) COLLATE utf8_unicode_ci DEFAULT NULL,
            `timezone` varchar(64) COLLATE utf8_unicode_ci DEFAULT NULL,
            `locale` varchar(45) COLLATE utf8_unicode_ci DEFAULT NULL,
            `created_at` datetime DEFAULT NULL,
            `updated_at` datetime DEFAULT NULL,
            `deleted_at` datetime DEFAULT NULL
            ) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
            COMMIT;
SQL;
        $this->addSql($createTable);

        $createTable = <<<SQL
            SET FOREIGN_KEY_CHECKS = 0 ;
            START TRANSACTION;
            CREATE TABLE `branch` (
            `uuid` varchar(36) COLLATE utf8_unicode_ci NOT NULL,
            `code` int(11) NOT NULL,
            `name` varchar(128) DEFAULT NULL,
            `company_uuid` varchar(45) DEFAULT NULL,
            `account_uuid` varchar(36) COLLATE utf8_unicode_ci DEFAULT NULL,
            `exchange_id` varchar(36) COLLATE utf8_unicode_ci DEFAULT NULL,
            `address` varchar(255) DEFAULT NULL,
            `phone` varchar(30) DEFAULT NULL,
            `ext_phone` varchar(3) DEFAULT NULL,
            `fax` varchar(30) DEFAULT NULL,
            `email` varchar(128) DEFAULT NULL,
            `is_active` int(1) DEFAULT '1',
            `note` text,
            `geofence` tinyint(1) DEFAULT '0',
            `latitude` double(12,8) DEFAULT NULL,
            `longitude` double(12,8) DEFAULT NULL,
            `geofence_radius` double(5,2) DEFAULT '60.00',
            `updated_at` datetime DEFAULT NULL,
            `deleted_at` datetime DEFAULT NULL,
            `created_at` datetime DEFAULT NULL
            ) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
            COMMIT;
SQL;
        $this->addSql($createTable);

        $createTable = <<<SQL
            SET FOREIGN_KEY_CHECKS = 0 ;
            START TRANSACTION;
            CREATE TABLE `business_sector` (
            `uuid` varchar(36) COLLATE utf8_unicode_ci NOT NULL,
            `name` varchar(128) COLLATE utf8_unicode_ci DEFAULT NULL,
            `note` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
            `created_at` datetime NOT NULL,
            `updated_at` datetime DEFAULT NULL,
            `deleted_at` datetime DEFAULT NULL
            ) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
                        COMMIT;
            SQL;
        $this->addSql($createTable);

        $createTable = <<<SQL
            SET FOREIGN_KEY_CHECKS = 0 ;
            START TRANSACTION;
            CREATE TABLE `company` (
            `uuid` varchar(36) COLLATE utf8_unicode_ci NOT NULL,
            `account_uuid` varchar(36) COLLATE utf8_unicode_ci DEFAULT NULL,
            `business_sector_uuid` varchar(36) COLLATE utf8_unicode_ci DEFAULT NULL,
            `code` int(11) NOT NULL,
            `name` varchar(128) COLLATE utf8_unicode_ci DEFAULT NULL,
            `address` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
            `phone` varchar(30) COLLATE utf8_unicode_ci DEFAULT NULL,
            `ext_phone` varchar(3) COLLATE utf8_unicode_ci DEFAULT NULL,
            `fax` varchar(30) COLLATE utf8_unicode_ci DEFAULT NULL,
            `registration_id` varchar(20) COLLATE utf8_unicode_ci DEFAULT NULL,
            `tax_id` varchar(28) COLLATE utf8_unicode_ci DEFAULT NULL,
            `about` text COLLATE utf8_unicode_ci,
            `email` varchar(128) COLLATE utf8_unicode_ci DEFAULT NULL,
            `path` varchar(128) COLLATE utf8_unicode_ci DEFAULT NULL,
            `is_active` int(1) DEFAULT '1',
            `is_hq` int(1) DEFAULT '1',
            `created_at` datetime DEFAULT NULL,
            `updated_at` datetime DEFAULT NULL,
            `deleted_at` datetime DEFAULT NULL
            ) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
            COMMIT;
SQL;
        $this->addSql($createTable);

        $createTable = <<<SQL
            SET FOREIGN_KEY_CHECKS = 0 ;
            START TRANSACTION;
            CREATE TABLE `department` (
            `uuid` varchar(36) COLLATE utf8_unicode_ci NOT NULL,
            `code` int(11) NOT NULL,
            `name` varchar(64) COLLATE utf8_unicode_ci NOT NULL,
            `company_uuid` varchar(36) COLLATE utf8_unicode_ci DEFAULT NULL,
            `branch_uuid` varchar(36) COLLATE utf8_unicode_ci DEFAULT NULL,
            `account_uuid` varchar(36) COLLATE utf8_unicode_ci DEFAULT NULL,
            `phone` varchar(30) COLLATE utf8_unicode_ci DEFAULT NULL,
            `ext_phone` varchar(45) COLLATE utf8_unicode_ci DEFAULT NULL,
            `fax` varchar(30) COLLATE utf8_unicode_ci DEFAULT NULL,
            `email` varchar(128) COLLATE utf8_unicode_ci DEFAULT NULL,
            `is_active` int(1) DEFAULT '1',
            `note` tinytext COLLATE utf8_unicode_ci,
            `created_at` datetime NOT NULL,
            `updated_at` datetime DEFAULT NULL,
            `deleted_at` datetime DEFAULT NULL
            ) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
            COMMIT;
SQL;
        $this->addSql($createTable);

        $createTable = <<<SQL
            SET FOREIGN_KEY_CHECKS = 0 ;
            START TRANSACTION;
            CREATE TABLE `education` (
            `uuid` varchar(36) COLLATE utf8_unicode_ci NOT NULL,
            `user_uuid` varchar(36) COLLATE utf8_unicode_ci DEFAULT NULL,
            `level_education` varchar(64) COLLATE utf8_unicode_ci DEFAULT NULL,
            `school_name` varchar(128) COLLATE utf8_unicode_ci DEFAULT NULL,
            `graduated_year` varchar(4) COLLATE utf8_unicode_ci DEFAULT NULL,
            `created_at` datetime NOT NULL,
            `updated_at` datetime DEFAULT NULL,
            `deleted_at` datetime DEFAULT NULL
            ) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
            COMMIT;
SQL;
        $this->addSql($createTable);

        $createTable = <<<SQL
            SET FOREIGN_KEY_CHECKS = 0 ;
            START TRANSACTION;
            CREATE TABLE `employment_type` (
            `uuid` varchar(36) COLLATE utf8_unicode_ci NOT NULL,
            `name` varchar(128) COLLATE utf8_unicode_ci DEFAULT NULL,
            `note` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
            `created_at` datetime NOT NULL,
            `updated_at` datetime DEFAULT NULL,
            `deleted_at` datetime DEFAULT NULL
            ) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
            COMMIT;
SQL;
        $this->addSql($createTable);

        $createTable = <<<SQL
            SET FOREIGN_KEY_CHECKS = 0 ;
            START TRANSACTION;
            CREATE TABLE `notification` (
            `uuid` varchar(36) COLLATE utf8_unicode_ci NOT NULL,
            `account_uuid` varchar(36) COLLATE utf8_unicode_ci DEFAULT NULL,
            `user_profile_uuid` varchar(36) COLLATE utf8_unicode_ci DEFAULT NULL,
            `panic_alert_uuid` varchar(36) COLLATE utf8_unicode_ci DEFAULT NULL,
            `type` varchar(50) DEFAULT NULL,
            `subtype` varchar(45) DEFAULT NULL,
            `title` text,
            `unread` tinyint(1) NOT NULL DEFAULT '1',
            `is_admin` tinyint(1) NOT NULL DEFAULT '0',
            `created_at` datetime DEFAULT NULL,
            `updated_at` datetime DEFAULT NULL,
            `deleted_at` datetime DEFAULT NULL
            ) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
            COMMIT;
SQL;
        $this->addSql($createTable);

        $createTable = <<<SQL
            SET FOREIGN_KEY_CHECKS = 0 ;
            START TRANSACTION;
            CREATE TABLE `notification_log` (
            `uuid` varchar(36) COLLATE utf8_unicode_ci NOT NULL,
            `panic_alert_uuid` varchar(36) COLLATE utf8_unicode_ci DEFAULT NULL,
            `panic_alert_status_uuid` varchar(36) COLLATE utf8_unicode_ci DEFAULT NULL,
            `user_profile_uuid` varchar(36) COLLATE utf8_unicode_ci DEFAULT NULL,
            `title` text,
            `created_at` datetime DEFAULT NULL,
            `updated_at` datetime DEFAULT NULL,
            `deleted_at` datetime DEFAULT NULL
            ) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
            COMMIT;
SQL;
        $this->addSql($createTable);

        $createTable = <<<SQL
            SET FOREIGN_KEY_CHECKS = 0 ;
            START TRANSACTION;
            CREATE TABLE `oauth_access_tokens` (
            `access_token` varchar(40) COLLATE utf8_unicode_ci NOT NULL,
            `client_id` varchar(80) COLLATE utf8_unicode_ci NOT NULL,
            `user_id` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
            `expires` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
            `scope` varchar(2000) COLLATE utf8_unicode_ci DEFAULT NULL
            ) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
            COMMIT;
SQL;
        $this->addSql($createTable);

        $createTable = <<<SQL
            SET FOREIGN_KEY_CHECKS = 0 ;
            START TRANSACTION;
            CREATE TABLE `oauth_authorization_codes` (
            `authorization_code` varchar(40) COLLATE utf8_unicode_ci NOT NULL,
            `client_id` varchar(80) COLLATE utf8_unicode_ci NOT NULL,
            `user_id` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
            `redirect_uri` varchar(2000) COLLATE utf8_unicode_ci DEFAULT NULL,
            `expires` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
            `scope` varchar(2000) COLLATE utf8_unicode_ci DEFAULT NULL,
            `id_token` varchar(2000) COLLATE utf8_unicode_ci DEFAULT NULL
            ) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
            COMMIT;
SQL;
        $this->addSql($createTable);

        $createTable = <<<SQL
            SET FOREIGN_KEY_CHECKS = 0 ;
            START TRANSACTION;
            CREATE TABLE `oauth_clients` (
            `client_id` varchar(80) COLLATE utf8_unicode_ci NOT NULL,
            `client_secret` varchar(80) COLLATE utf8_unicode_ci NOT NULL,
            `redirect_uri` varchar(2000) COLLATE utf8_unicode_ci NOT NULL,
            `grant_types` varchar(80) COLLATE utf8_unicode_ci DEFAULT NULL,
            `scope` varchar(2000) COLLATE utf8_unicode_ci DEFAULT NULL,
            `user_id` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL
            ) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
            COMMIT;
SQL;
        $this->addSql($createTable);

        $createTable = <<<SQL
            SET FOREIGN_KEY_CHECKS = 0 ;
            START TRANSACTION;
            CREATE TABLE `oauth_jwt` (
            `client_id` varchar(80) COLLATE utf8_unicode_ci NOT NULL,
            `subject` varchar(80) COLLATE utf8_unicode_ci DEFAULT NULL,
            `public_key` varchar(2000) COLLATE utf8_unicode_ci DEFAULT NULL
            ) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
            COMMIT;
SQL;
        $this->addSql($createTable);

        $createTable = <<<SQL
            SET FOREIGN_KEY_CHECKS = 0 ;
            START TRANSACTION;
            CREATE TABLE `oauth_refresh_tokens` (
            `refresh_token` varchar(40) COLLATE utf8_unicode_ci NOT NULL,
            `client_id` varchar(80) COLLATE utf8_unicode_ci NOT NULL,
            `user_id` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
            `expires` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
            `scope` varchar(2000) COLLATE utf8_unicode_ci DEFAULT NULL
            ) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
            COMMIT;
SQL;
        $this->addSql($createTable);

        $createTable = <<<SQL
            SET FOREIGN_KEY_CHECKS = 0 ;
            START TRANSACTION;
            CREATE TABLE `oauth_scopes` (
            `id` int(11) NOT NULL,
            `type` varchar(255) COLLATE utf8_unicode_ci NOT NULL DEFAULT 'supported',
            `scope` varchar(2000) COLLATE utf8_unicode_ci DEFAULT NULL,
            `client_id` varchar(80) COLLATE utf8_unicode_ci DEFAULT NULL,
            `is_default` smallint(6) DEFAULT NULL
            ) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
            COMMIT;
SQL;
        $this->addSql($createTable);

        $createTable = <<<SQL
            SET FOREIGN_KEY_CHECKS = 0 ;
            START TRANSACTION;
            CREATE TABLE `oauth_users` (
            `username` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
            `password` varchar(2000) COLLATE utf8_unicode_ci DEFAULT NULL,
            `first_name` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
            `last_name` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
            `account_uuid` varchar(36) COLLATE utf8_unicode_ci DEFAULT NULL
            ) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
            COMMIT;
SQL;
        $this->addSql($createTable);

        $createTable = <<<SQL
            SET FOREIGN_KEY_CHECKS = 0 ;
            START TRANSACTION;
            CREATE TABLE `position` (
            `uuid` varchar(36) COLLATE utf8_unicode_ci NOT NULL,
            `name` varchar(128) COLLATE utf8_unicode_ci DEFAULT NULL,
            `note` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
            `created_at` datetime NOT NULL,
            `updated_at` datetime DEFAULT NULL,
            `deleted_at` datetime DEFAULT NULL
            ) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
            COMMIT;
SQL;
        $this->addSql($createTable);

        $createTable = <<<SQL
            SET FOREIGN_KEY_CHECKS = 0 ;
            START TRANSACTION;
            CREATE TABLE `qr_code` (
            `uuid` varchar(36) COLLATE utf8_unicode_ci NOT NULL,
            `user_profile_uuid` varchar(36) COLLATE utf8_unicode_ci DEFAULT NULL,
            `appointment_uuid` varchar(36) COLLATE utf8_unicode_ci DEFAULT NULL,
            `value` text COLLATE utf8_unicode_ci,
            `path` varchar(128) COLLATE utf8_unicode_ci DEFAULT NULL,
            `type` text COLLATE utf8_unicode_ci,
            `expired_at` datetime DEFAULT NULL,
            `is_available` int(11) DEFAULT '1',
            `created_at` datetime DEFAULT NULL,
            `updated_at` datetime DEFAULT NULL,
            `deleted_at` datetime DEFAULT NULL
            ) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
            COMMIT;
SQL;
        $this->addSql($createTable);

        $createTable = <<<SQL
            SET FOREIGN_KEY_CHECKS = 0 ;
            START TRANSACTION;
            CREATE TABLE `qr_code_log` (
            `uuid` varchar(36) COLLATE utf8_unicode_ci NOT NULL,
            `qr_code_uuid` varchar(36) COLLATE utf8_unicode_ci DEFAULT NULL,
            `type` text COLLATE utf8_unicode_ci,
            `created_at` datetime DEFAULT NULL,
            `updated_at` datetime DEFAULT NULL,
            `deleted_at` datetime DEFAULT NULL
            ) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
            COMMIT;
SQL;
        $this->addSql($createTable);

        $createTable = <<<SQL
            SET FOREIGN_KEY_CHECKS = 0 ;
            START TRANSACTION;
            CREATE TABLE `qr_code_owner` (
            `uuid` varchar(36) COLLATE utf8_unicode_ci NOT NULL,
            `qr_code_uuid` varchar(36) COLLATE utf8_unicode_ci DEFAULT NULL,
            `user_profile_uuid` varchar(36) COLLATE utf8_unicode_ci DEFAULT NULL,
            `qr_code_owner_type_uuid` varchar(36) COLLATE utf8_unicode_ci DEFAULT NULL,
            `expired_at` datetime DEFAULT NULL,
            `created_at` datetime DEFAULT NULL,
            `updated_at` datetime DEFAULT NULL,
            `deleted_at` datetime DEFAULT NULL
            ) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
            COMMIT;
SQL;
        $this->addSql($createTable);

        $createTable = <<<SQL
            SET FOREIGN_KEY_CHECKS = 0 ;
            START TRANSACTION;
            CREATE TABLE `qr_code_owner_type` (
            `uuid` varchar(36) COLLATE utf8_unicode_ci NOT NULL,
            `account_uuid` varchar(36) COLLATE utf8_unicode_ci DEFAULT NULL,
            `type` text COLLATE utf8_unicode_ci,
            `created_at` datetime DEFAULT NULL,
            `updated_at` datetime DEFAULT NULL,
            `deleted_at` datetime DEFAULT NULL
            ) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
            COMMIT;
SQL;
        $this->addSql($createTable);

        $createTable = <<<SQL
            SET FOREIGN_KEY_CHECKS = 0 ;
            START TRANSACTION;
            CREATE TABLE `reset_password` (
            `uuid` varchar(36) COLLATE utf8_unicode_ci NOT NULL,
            `email` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
            `expiration` datetime NOT NULL,
            `reseted` datetime DEFAULT NULL,
            `password` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
            `created_at` datetime DEFAULT NULL,
            `updated_at` datetime DEFAULT NULL,
            `deleted_at` datetime DEFAULT NULL
            ) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
            COMMIT;
SQL;
        $this->addSql($createTable);

        $createTable = <<<SQL
            SET FOREIGN_KEY_CHECKS = 0 ;
            START TRANSACTION;
            CREATE TABLE `user_access` (
            `uuid` varchar(36) COLLATE utf8_unicode_ci NOT NULL,
            `user_profile_uuid` varchar(36) COLLATE utf8_unicode_ci DEFAULT NULL,
            `user_role_uuid` varchar(36) COLLATE utf8_unicode_ci DEFAULT NULL,
            `is_active` tinyint(1) NOT NULL DEFAULT '1',
            `created_at` datetime DEFAULT NULL,
            `updated_at` datetime DEFAULT NULL,
            `deleted_at` datetime DEFAULT NULL
            ) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
            COMMIT;
SQL;
        $this->addSql($createTable);

        $createTable = <<<SQL
            SET FOREIGN_KEY_CHECKS = 0 ;
            START TRANSACTION;
            CREATE TABLE `user_acl` (
            `uuid` varchar(36) COLLATE utf8_unicode_ci NOT NULL,
            `user_module_uuid` varchar(36) COLLATE utf8_unicode_ci DEFAULT NULL,
            `user_role_uuid` varchar(36) COLLATE utf8_unicode_ci DEFAULT NULL,
            `created_at` datetime DEFAULT NULL,
            `updated_at` datetime DEFAULT NULL,
            `deleted_at` datetime DEFAULT NULL
            ) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
            COMMIT;
SQL;
        $this->addSql($createTable);

        $createTable = <<<SQL
            SET FOREIGN_KEY_CHECKS = 0 ;
            START TRANSACTION;
            CREATE TABLE `user_activation` (
            `uuid` varchar(36) COLLATE utf8_unicode_ci NOT NULL,
            `email` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
            `expiration` datetime NOT NULL,
            `activated` datetime DEFAULT NULL,
            `created_at` datetime DEFAULT NULL,
            `updated_at` datetime DEFAULT NULL,
            `deleted_at` datetime DEFAULT NULL
            ) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
            COMMIT;
SQL;
        $this->addSql($createTable);

        $createTable = <<<SQL
            SET FOREIGN_KEY_CHECKS = 0 ;
            START TRANSACTION;
            CREATE TABLE `user_activation_log` (
            `uuid` varchar(36) COLLATE utf8_unicode_ci NOT NULL,
            `account_uuid` varchar(36) COLLATE utf8_unicode_ci DEFAULT NULL,
            `user_profile_uuid` varchar(36) COLLATE utf8_unicode_ci DEFAULT NULL,
            `created_by` varchar(36) COLLATE utf8_unicode_ci DEFAULT NULL,
            `status` varchar(45) COLLATE utf8_unicode_ci DEFAULT NULL,
            `note` text COLLATE utf8_unicode_ci,
            `created_at` datetime DEFAULT NULL,
            `updated_at` datetime DEFAULT NULL,
            `deleted_at` datetime DEFAULT NULL
            ) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
            COMMIT;
SQL;
        $this->addSql($createTable);

        $createTable = <<<SQL
            SET FOREIGN_KEY_CHECKS = 0 ;
            START TRANSACTION;
            CREATE TABLE `user_document` (
            `uuid` varchar(36) COLLATE utf8_unicode_ci NOT NULL,
            `user_uuid` varchar(36) COLLATE utf8_unicode_ci DEFAULT NULL,
            `path` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
            `type` varchar(50) COLLATE utf8_unicode_ci DEFAULT NULL,
            `note` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
            `created_at` datetime NOT NULL,
            `updated_at` datetime DEFAULT NULL,
            `deleted_at` datetime DEFAULT NULL
            ) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
            COMMIT;
SQL;
        $this->addSql($createTable);

        $createTable = <<<SQL
            SET FOREIGN_KEY_CHECKS = 0 ;
            START TRANSACTION;
            CREATE TABLE `user_module` (
            `uuid` varchar(36) COLLATE utf8_unicode_ci NOT NULL,
            `name` text COLLATE utf8_unicode_ci,
            `status` int(1) DEFAULT '1',
            `path` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
            `parent_uuid` varchar(36) COLLATE utf8_unicode_ci DEFAULT NULL,
            `created_at` datetime DEFAULT NULL,
            `updated_at` datetime DEFAULT NULL,
            `deleted_at` datetime DEFAULT NULL
            ) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
            COMMIT;
SQL;
        $this->addSql($createTable);

        $createTable = <<<SQL
            SET FOREIGN_KEY_CHECKS = 0 ;
            START TRANSACTION;
            CREATE TABLE `user_profile` (
            `uuid` varchar(36) COLLATE utf8_unicode_ci NOT NULL,
            `branch_uuid` varchar(36) COLLATE utf8_unicode_ci DEFAULT NULL,
            `department_uuid` varchar(36) COLLATE utf8_unicode_ci DEFAULT NULL,
            `company_uuid` varchar(36) COLLATE utf8_unicode_ci DEFAULT NULL,
            `account_uuid` varchar(36) COLLATE utf8_unicode_ci DEFAULT NULL,
            `facetemp_token` varchar(64) COLLATE utf8_unicode_ci DEFAULT NULL,
            `atac_token` varchar(64) COLLATE utf8_unicode_ci DEFAULT NULL,
            `staff_id` varchar(64) COLLATE utf8_unicode_ci DEFAULT NULL,
            `hospital_uuid` varchar(36) COLLATE utf8_unicode_ci DEFAULT NULL,
            `position_uuid` varchar(36) COLLATE utf8_unicode_ci DEFAULT NULL,
            `employment_type_uuid` varchar(36) COLLATE utf8_unicode_ci DEFAULT NULL,
            `job_activity` varchar(36) COLLATE utf8_unicode_ci DEFAULT NULL,
            `driving_activity` varchar(36) COLLATE utf8_unicode_ci DEFAULT NULL,
            `username` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
            `email` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
            `workemail` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
            `fic_number` char(16) COLLATE utf8_unicode_ci DEFAULT NULL,
            `ic_number` char(16) COLLATE utf8_unicode_ci DEFAULT NULL,
            `driving_licence` varchar(32) COLLATE utf8_unicode_ci DEFAULT NULL,
            `secret` varchar(32) COLLATE utf8_unicode_ci DEFAULT NULL,
            `first_name` varchar(64) COLLATE utf8_unicode_ci DEFAULT NULL,
            `last_name` varchar(64) COLLATE utf8_unicode_ci DEFAULT NULL,
            `nick_name` varchar(64) COLLATE utf8_unicode_ci DEFAULT NULL,
            `first_date` date DEFAULT NULL,
            `current_address` varchar(128) COLLATE utf8_unicode_ci DEFAULT NULL,
            `role` varchar(32) COLLATE utf8_unicode_ci DEFAULT NULL,
            `phone` varchar(64) COLLATE utf8_unicode_ci DEFAULT NULL,
            `workphone` varchar(64) COLLATE utf8_unicode_ci DEFAULT NULL,
            `mobile` varchar(64) COLLATE utf8_unicode_ci DEFAULT NULL,
            `parent_uuid` varchar(36) COLLATE utf8_unicode_ci DEFAULT NULL,
            `pob` varchar(64) COLLATE utf8_unicode_ci DEFAULT NULL,
            `dob` date DEFAULT NULL,
            `gender` varchar(10) COLLATE utf8_unicode_ci DEFAULT NULL,
            `marital_status` varchar(32) COLLATE utf8_unicode_ci DEFAULT NULL,
            `address` varchar(128) COLLATE utf8_unicode_ci DEFAULT NULL,
            `address_current` varchar(128) COLLATE utf8_unicode_ci DEFAULT NULL,
            `city` varchar(64) COLLATE utf8_unicode_ci DEFAULT NULL,
            `state_uuid` varchar(36) COLLATE utf8_unicode_ci DEFAULT NULL,
            `district_uuid` varchar(36) COLLATE utf8_unicode_ci DEFAULT NULL,
            `postal_code` varchar(5) COLLATE utf8_unicode_ci DEFAULT NULL,
            `country` varchar(2) COLLATE utf8_unicode_ci DEFAULT NULL,
            `identity_type` varchar(50) COLLATE utf8_unicode_ci DEFAULT NULL,
            `nationality` varchar(50) COLLATE utf8_unicode_ci DEFAULT NULL,
            `blood_type` varchar(50) COLLATE utf8_unicode_ci DEFAULT NULL,
            `relation_primary_name` varchar(64) COLLATE utf8_unicode_ci DEFAULT NULL,
            `relation_primary_phone` varchar(64) COLLATE utf8_unicode_ci DEFAULT NULL,
            `relationship_primary` varchar(32) COLLATE utf8_unicode_ci DEFAULT NULL,
            `relation_secondary_name` varchar(64) COLLATE utf8_unicode_ci DEFAULT NULL,
            `relation_secondary_phone` varchar(64) COLLATE utf8_unicode_ci DEFAULT NULL,
            `relationship_secondary` varchar(32) COLLATE utf8_unicode_ci DEFAULT NULL,
            `job_desk` varchar(45) COLLATE utf8_unicode_ci DEFAULT NULL,
            `timezone` varchar(64) COLLATE utf8_unicode_ci DEFAULT NULL,
            `photo` varchar(128) COLLATE utf8_unicode_ci DEFAULT NULL,
            `is_active` tinyint(1) NOT NULL DEFAULT '0',
            `firebase_id` text COLLATE utf8_unicode_ci,
            `android_device_id` text COLLATE utf8_unicode_ci,
            `ios_device_token` text COLLATE utf8_unicode_ci,
            `android_last_state` text COLLATE utf8_unicode_ci,
            `latitude` decimal(10,8) DEFAULT NULL,
            `longitude` decimal(11,8) DEFAULT NULL,
            `questionnaire_counter` int(11) DEFAULT '0',
            `last_questionnaire_at` datetime DEFAULT NULL,
            `last_score` int(5) DEFAULT NULL,
            `leave_quota` int(11) DEFAULT NULL,
            `signature` mediumtext COLLATE utf8_unicode_ci,
            `created_at` datetime DEFAULT NULL,
            `updated_at` datetime DEFAULT NULL,
            `deleted_at` datetime DEFAULT NULL
            ) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
            COMMIT;
SQL;
        $this->addSql($createTable);

        $createTable = <<<SQL
            SET FOREIGN_KEY_CHECKS = 0 ;
            START TRANSACTION;
            CREATE TABLE `user_role` (
            `uuid` varchar(36) COLLATE utf8_unicode_ci NOT NULL,
            `account_uuid` varchar(36) COLLATE utf8_unicode_ci DEFAULT NULL,
            `company_uuid` varchar(36) COLLATE utf8_unicode_ci DEFAULT NULL,
            `branch_uuid` varchar(36) COLLATE utf8_unicode_ci DEFAULT NULL,
            `name` text COLLATE utf8_unicode_ci,
            `parent_uuid` varchar(36) COLLATE utf8_unicode_ci DEFAULT NULL,
            `created_at` datetime DEFAULT NULL,
            `updated_at` datetime DEFAULT NULL,
            `deleted_at` datetime DEFAULT NULL
            ) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
            COMMIT;
SQL;
        $this->addSql($createTable);

        $alterTable = <<<SQL
            SET FOREIGN_KEY_CHECKS = 0 ;
            START TRANSACTION;
            ALTER TABLE `account`
            ADD PRIMARY KEY (`uuid`);
            COMMIT;
SQL;
        $this->addSql($alterTable);

        $alterTable = <<<SQL
            SET FOREIGN_KEY_CHECKS = 0 ;
            START TRANSACTION;
            ALTER TABLE `branch`
            ADD PRIMARY KEY (`uuid`),
            ADD UNIQUE KEY `code_UNIQUE` (`code`),
            ADD KEY `fk_branch_company_idx_idx` (`company_uuid`);
            COMMIT;
SQL;
        $this->addSql($alterTable);

        $alterTable = <<<SQL
            SET FOREIGN_KEY_CHECKS = 0 ;
            START TRANSACTION;
            ALTER TABLE `business_sector`
            ADD PRIMARY KEY (`uuid`);
            COMMIT;
SQL;
        $this->addSql($alterTable);

        $alterTable = <<<SQL
            SET FOREIGN_KEY_CHECKS = 0 ;
            START TRANSACTION;
            ALTER TABLE `company`
            ADD PRIMARY KEY (`uuid`),
            ADD UNIQUE KEY `code_UNIQUE` (`code`),
            ADD KEY `fk_company_account_idx_idx` (`account_uuid`),
            ADD KEY `fk_company_business_sector_idx_idx` (`business_sector_uuid`);
            COMMIT;
SQL;
        $this->addSql($alterTable);

        $alterTable = <<<SQL
            SET FOREIGN_KEY_CHECKS = 0 ;
            START TRANSACTION;
            ALTER TABLE `department`
            ADD PRIMARY KEY (`uuid`),
            ADD UNIQUE KEY `code_UNIQUE` (`code`),
            ADD KEY `fk_department_account_idx_idx` (`account_uuid`),
            ADD KEY `fk_department_company_idx_idx` (`company_uuid`),
            ADD KEY `fk_department_branch_idx_idx` (`branch_uuid`);
            COMMIT;
SQL;
        $this->addSql($alterTable);

        $alterTable = <<<SQL
            SET FOREIGN_KEY_CHECKS = 0 ;
            START TRANSACTION;
            ALTER TABLE `education`
            ADD PRIMARY KEY (`uuid`),
            ADD KEY `fk_education_user_idx_idx` (`user_uuid`);
            COMMIT;
SQL;
        $this->addSql($alterTable);

        $alterTable = <<<SQL
            SET FOREIGN_KEY_CHECKS = 0 ;
            START TRANSACTION;
            ALTER TABLE `employment_type`
            ADD PRIMARY KEY (`uuid`);
            COMMIT;
SQL;
        $this->addSql($alterTable);

        $alterTable = <<<SQL
            SET FOREIGN_KEY_CHECKS = 0 ;
            START TRANSACTION;
            ALTER TABLE `notification`
            ADD PRIMARY KEY (`uuid`),
            ADD KEY `fk_notification_account_idxB04RD` (`account_uuid`),
            ADD KEY `fk_notification_panicalert_idxB04RD` (`panic_alert_uuid`),
            ADD KEY `fk_notification_userprofile_idxB04RD` (`user_profile_uuid`);
            COMMIT;
SQL;
        $this->addSql($alterTable);

        $alterTable = <<<SQL
            SET FOREIGN_KEY_CHECKS = 0 ;
            START TRANSACTION;
            ALTER TABLE `notification_log`
            ADD PRIMARY KEY (`uuid`),
            ADD KEY `fk_notificationlog_panicalert_idxB04RD` (`panic_alert_uuid`),
            ADD KEY `fk_notificationlog_panicalertstatus_idxB04RD` (`panic_alert_status_uuid`),
            ADD KEY `fk_notificationlog_userprofile_idxB04RD` (`user_profile_uuid`);
            COMMIT;
SQL;
        $this->addSql($alterTable);

        $alterTable = <<<SQL
            SET FOREIGN_KEY_CHECKS = 0 ;
            START TRANSACTION;
            ALTER TABLE `oauth_access_tokens`
            ADD PRIMARY KEY (`access_token`);
            COMMIT;
SQL;
        $this->addSql($alterTable);

        $alterTable = <<<SQL
            SET FOREIGN_KEY_CHECKS = 0 ;
            START TRANSACTION;
            ALTER TABLE `oauth_authorization_codes`
            ADD PRIMARY KEY (`authorization_code`);
            COMMIT;
SQL;
        $this->addSql($alterTable);

        $alterTable = <<<SQL
            SET FOREIGN_KEY_CHECKS = 0 ;
            START TRANSACTION;
            ALTER TABLE `oauth_clients`
            ADD PRIMARY KEY (`client_id`);
            COMMIT;
SQL;
        $this->addSql($alterTable);

        $alterTable = <<<SQL
            SET FOREIGN_KEY_CHECKS = 0 ;
            START TRANSACTION;
            ALTER TABLE `oauth_jwt`
            ADD PRIMARY KEY (`client_id`);
            COMMIT;
SQL;
        $this->addSql($alterTable);


        $alterTable = <<<SQL
            SET FOREIGN_KEY_CHECKS = 0 ;
            START TRANSACTION;
            ALTER TABLE `oauth_refresh_tokens`
            ADD PRIMARY KEY (`refresh_token`);
            COMMIT;
SQL;
        $this->addSql($alterTable);


        $alterTable = <<<SQL
            SET FOREIGN_KEY_CHECKS = 0 ;
            START TRANSACTION;
            ALTER TABLE `oauth_scopes`
            ADD PRIMARY KEY (`id`);
            COMMIT;
SQL;
        $this->addSql($alterTable);


        $alterTable = <<<SQL
            SET FOREIGN_KEY_CHECKS = 0 ;
            START TRANSACTION;
            ALTER TABLE `oauth_users`
            ADD PRIMARY KEY (`username`),
            ADD UNIQUE KEY `UQ_username_account` (`username`),
            ADD KEY `fk_oauth_users_account_idx` (`account_uuid`);
            COMMIT;
SQL;
        $this->addSql($alterTable);


        $alterTable = <<<SQL
            SET FOREIGN_KEY_CHECKS = 0 ;
            START TRANSACTION;
            ALTER TABLE `position`
            ADD PRIMARY KEY (`uuid`);
            COMMIT;
SQL;
        $this->addSql($alterTable);


        $alterTable = <<<SQL
            SET FOREIGN_KEY_CHECKS = 0 ;
            START TRANSACTION;
            ALTER TABLE `qr_code`
            ADD PRIMARY KEY (`uuid`) USING BTREE,
            ADD KEY `fk_qrcode_userprofile_idx` (`user_profile_uuid`) USING BTREE,
            ADD KEY `fk_qrcode_appointment_idx` (`appointment_uuid`) USING BTREE;
            COMMIT;
SQL;
        $this->addSql($alterTable);


        $alterTable = <<<SQL
            SET FOREIGN_KEY_CHECKS = 0 ;
            START TRANSACTION;
            ALTER TABLE `qr_code_log`
            ADD PRIMARY KEY (`uuid`),
            ADD KEY `fk_qr_code` (`qr_code_uuid`);
            COMMIT;
SQL;
        $this->addSql($alterTable);


        $alterTable = <<<SQL
            SET FOREIGN_KEY_CHECKS = 0 ;
            START TRANSACTION;
            ALTER TABLE `qr_code_owner`
            ADD PRIMARY KEY (`uuid`),
            ADD KEY `index2` (`qr_code_uuid`),
            ADD KEY `index3` (`user_profile_uuid`),
            ADD KEY `fk_qrcodeownertype_index6` (`qr_code_owner_type_uuid`);
            COMMIT;
SQL;
        $this->addSql($alterTable);


        $alterTable = <<<SQL
            SET FOREIGN_KEY_CHECKS = 0 ;
            START TRANSACTION;
            ALTER TABLE `qr_code_owner_type`
            ADD PRIMARY KEY (`uuid`),
            ADD KEY `fk_account_inqrcodeowner_idx` (`account_uuid`);
            COMMIT;
SQL;
        $this->addSql($alterTable);


        $alterTable = <<<SQL
            SET FOREIGN_KEY_CHECKS = 0 ;
            START TRANSACTION;
            ALTER TABLE `reset_password`
            ADD PRIMARY KEY (`uuid`),
            ADD KEY `IDX_B9983CE5E7927C74` (`email`);
            COMMIT;
SQL;
        $this->addSql($alterTable);


        $alterTable = <<<SQL
            SET FOREIGN_KEY_CHECKS = 0 ;
            START TRANSACTION;
            ALTER TABLE `user_access`
            ADD PRIMARY KEY (`uuid`),
            ADD KEY `user_profile_idx` (`user_profile_uuid`),
            ADD KEY `user_role_idx` (`user_role_uuid`);
            COMMIT;
SQL;
        $this->addSql($alterTable);


        $alterTable = <<<SQL
            SET FOREIGN_KEY_CHECKS = 0 ;
            START TRANSACTION;
            ALTER TABLE `user_acl`
            ADD PRIMARY KEY (`uuid`),
            ADD KEY `fk_user_module_acl_idx` (`user_module_uuid`),
            ADD KEY `fk_user_role_acl_idx` (`user_role_uuid`);
            COMMIT;
SQL;
        $this->addSql($alterTable);


        $alterTable = <<<SQL
            SET FOREIGN_KEY_CHECKS = 0 ;
            START TRANSACTION;
            ALTER TABLE `user_activation`
            ADD PRIMARY KEY (`uuid`),
            ADD KEY `IDX_BB0FA69BE7927C74` (`email`);
            COMMIT;
SQL;
        $this->addSql($alterTable);


        $alterTable = <<<SQL
            SET FOREIGN_KEY_CHECKS = 0 ;
            START TRANSACTION;
            ALTER TABLE `user_activation_log`
            ADD PRIMARY KEY (`uuid`),
            ADD KEY `user_activation_log_idx` (`user_profile_uuid`),
            ADD KEY `user_created_log_idx` (`user_profile_uuid`),
            ADD KEY `user_activation_log_account_idx` (`account_uuid`),
            ADD KEY `fk_user_created_log` (`created_by`);
            COMMIT;
SQL;
        $this->addSql($alterTable);


        $alterTable = <<<SQL
            SET FOREIGN_KEY_CHECKS = 0 ;
            START TRANSACTION;
            ALTER TABLE `user_document`
            ADD PRIMARY KEY (`uuid`),
            ADD KEY `fk_document_user_idx_idx` (`user_uuid`);
            COMMIT;
SQL;
        $this->addSql($alterTable);


        $alterTable = <<<SQL
            SET FOREIGN_KEY_CHECKS = 0 ;
            START TRANSACTION;
            ALTER TABLE `user_module`
            ADD PRIMARY KEY (`uuid`),
            ADD KEY `fk_user_module_parent_idx` (`parent_uuid`);
            COMMIT;
SQL;
        $this->addSql($alterTable);


        $alterTable = <<<SQL
            SET FOREIGN_KEY_CHECKS = 0 ;
            START TRANSACTION;
            ALTER TABLE `user_profile`
            ADD PRIMARY KEY (`uuid`),
            ADD UNIQUE KEY `IDX_D95AB405AA45BB37` (`username`),
            ADD UNIQUE KEY `IDX_user_ic` (`ic_number`) USING BTREE,
            ADD KEY `FK_D95AB405E89AB43C_idx` (`account_uuid`),
            ADD KEY `IDX_user_parent` (`parent_uuid`),
            ADD KEY `review_hospital_uuid_idx` (`hospital_uuid`),
            ADD KEY `department_idx` (`department_uuid`),
            ADD KEY `branch_idx` (`branch_uuid`),
            ADD KEY `company_idx` (`company_uuid`),
            ADD KEY `position_idx` (`position_uuid`),
            ADD KEY `employment_type_idx` (`employment_type_uuid`),
            ADD KEY `job_activity_idx` (`job_activity`),
            ADD KEY `driving_activity_idx` (`driving_activity`);
            COMMIT;
SQL;
        $this->addSql($alterTable);


        $alterTable = <<<SQL
            SET FOREIGN_KEY_CHECKS = 0 ;
            START TRANSACTION;
            ALTER TABLE `user_role`
            ADD PRIMARY KEY (`uuid`),
            ADD KEY `fk_user_role_account_idx` (`account_uuid`),
            ADD KEY `fk_user_role_company_idx` (`company_uuid`),
            ADD KEY `fk_user_role_branch_idx` (`branch_uuid`),
            ADD KEY `fk_user_role_parent_idx` (`parent_uuid`);
            COMMIT;
SQL;
        $this->addSql($alterTable);


        $alterTable = <<<SQL
            SET FOREIGN_KEY_CHECKS = 0 ;
            START TRANSACTION;
            ALTER TABLE `branch`
            MODIFY `code` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
            COMMIT;
SQL;
        $this->addSql($alterTable);


        $alterTable = <<<SQL
            SET FOREIGN_KEY_CHECKS = 0 ;
            START TRANSACTION;
            ALTER TABLE `company`
            MODIFY `code` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;
            COMMIT;
SQL;
        $this->addSql($alterTable);


        $alterTable = <<<SQL
            SET FOREIGN_KEY_CHECKS = 0 ;
            START TRANSACTION;
            ALTER TABLE `department`
            MODIFY `code` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
            COMMIT;
SQL;
        $this->addSql($alterTable);


        $alterTable = <<<SQL
            SET FOREIGN_KEY_CHECKS = 0 ;
            START TRANSACTION;
            ALTER TABLE `oauth_scopes`
            MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
            COMMIT;
SQL;
        $this->addSql($alterTable);


        $alterTable = <<<SQL
            SET FOREIGN_KEY_CHECKS = 0 ;
            START TRANSACTION;
            ALTER TABLE `company`
            ADD CONSTRAINT `fk_company_account_idx` FOREIGN KEY (`account_uuid`) REFERENCES `account` (`uuid`) ON DELETE NO ACTION ON UPDATE NO ACTION,
            ADD CONSTRAINT `fk_company_business_sector_idx` FOREIGN KEY (`business_sector_uuid`) REFERENCES `business_sector` (`uuid`) ON DELETE NO ACTION ON UPDATE NO ACTION;
            COMMIT;
SQL;
        $this->addSql($alterTable);


        $alterTable = <<<SQL
            SET FOREIGN_KEY_CHECKS = 0 ;
            START TRANSACTION;
            ALTER TABLE `department`
            ADD CONSTRAINT `fk_department_account_idx` FOREIGN KEY (`account_uuid`) REFERENCES `account` (`uuid`) ON DELETE NO ACTION ON UPDATE NO ACTION,
            ADD CONSTRAINT `fk_department_branch_idx` FOREIGN KEY (`branch_uuid`) REFERENCES `branch` (`uuid`) ON UPDATE CASCADE,
            ADD CONSTRAINT `fk_department_company_idx` FOREIGN KEY (`company_uuid`) REFERENCES `company` (`uuid`) ON UPDATE CASCADE;
            COMMIT;
SQL;
        $this->addSql($alterTable);


        $alterTable = <<<SQL
            SET FOREIGN_KEY_CHECKS = 0 ;
            START TRANSACTION;
            ALTER TABLE `education`
            ADD CONSTRAINT `fk_education_user_idx` FOREIGN KEY (`user_uuid`) REFERENCES `user_profile` (`uuid`) ON DELETE NO ACTION ON UPDATE NO ACTION;
            COMMIT;
SQL;
        $this->addSql($alterTable);


        $alterTable = <<<SQL
            SET FOREIGN_KEY_CHECKS = 0 ;
            START TRANSACTION;
            ALTER TABLE `notification`
            ADD CONSTRAINT `fk_notificatioin_userprofile_B04RD` FOREIGN KEY (`user_profile_uuid`) REFERENCES `user_profile` (`uuid`),
            ADD CONSTRAINT `fk_notification_account_B04RD` FOREIGN KEY (`account_uuid`) REFERENCES `account` (`uuid`) ON DELETE NO ACTION ON UPDATE NO ACTION,
            ADD CONSTRAINT `fk_notification_panicalert_B04RD` FOREIGN KEY (`panic_alert_uuid`) REFERENCES `panic_alert` (`uuid`) ON DELETE NO ACTION ON UPDATE NO ACTION;
            COMMIT;
SQL;
        $this->addSql($alterTable);


        $alterTable = <<<SQL
            SET FOREIGN_KEY_CHECKS = 0 ;
            START TRANSACTION;
            ALTER TABLE `notification_log`
            ADD CONSTRAINT `fk_notificationlog_panicalert_B04RD` FOREIGN KEY (`panic_alert_uuid`) REFERENCES `panic_alert` (`uuid`) ON DELETE CASCADE ON UPDATE CASCADE,
            ADD CONSTRAINT `fk_notificationlog_panicalertstatus_B04RD` FOREIGN KEY (`panic_alert_status_uuid`) REFERENCES `panic_alert_status` (`uuid`) ON DELETE CASCADE ON UPDATE CASCADE,
            ADD CONSTRAINT `fk_notificationlog_userprofile_B04RD` FOREIGN KEY (`user_profile_uuid`) REFERENCES `user_profile` (`uuid`) ON DELETE CASCADE ON UPDATE CASCADE;
            COMMIT;
SQL;
        $this->addSql($alterTable);


        $alterTable = <<<SQL
            SET FOREIGN_KEY_CHECKS = 0 ;
            START TRANSACTION;
            ALTER TABLE `oauth_users`
            ADD CONSTRAINT `fk_oauth_users_account` FOREIGN KEY (`account_uuid`) REFERENCES `account` (`uuid`) ON DELETE NO ACTION ON UPDATE NO ACTION;
            COMMIT;
SQL;
        $this->addSql($alterTable);


        $alterTable = <<<SQL
            SET FOREIGN_KEY_CHECKS = 0 ;
            START TRANSACTION;
            ALTER TABLE `qr_code`
            ADD CONSTRAINT `fk_qrcode_appointment` FOREIGN KEY (`appointment_uuid`) REFERENCES `appointment` (`uuid`) ON DELETE NO ACTION ON UPDATE NO ACTION,
            ADD CONSTRAINT `fk_qrcode_user` FOREIGN KEY (`user_profile_uuid`) REFERENCES `user_profile` (`uuid`) ON DELETE NO ACTION ON UPDATE NO ACTION;
            COMMIT;
SQL;
        $this->addSql($alterTable);


        $alterTable = <<<SQL
            SET FOREIGN_KEY_CHECKS = 0 ;
            START TRANSACTION;
            ALTER TABLE `qr_code_log`
            ADD CONSTRAINT `FK_94167DB2BF613CA` FOREIGN KEY (`qr_code_uuid`) REFERENCES `qr_code` (`uuid`);
            COMMIT;
SQL;
        $this->addSql($alterTable);


        $alterTable = <<<SQL
            SET FOREIGN_KEY_CHECKS = 0 ;
            START TRANSACTION;
            ALTER TABLE `qr_code_owner`
            ADD CONSTRAINT `fk_qr_code_owner_1` FOREIGN KEY (`qr_code_uuid`) REFERENCES `qr_code` (`uuid`) ON DELETE NO ACTION ON UPDATE NO ACTION,
            ADD CONSTRAINT `fk_qr_code_owner_2` FOREIGN KEY (`user_profile_uuid`) REFERENCES `user_profile` (`uuid`) ON DELETE NO ACTION ON UPDATE NO ACTION,
            ADD CONSTRAINT `fk_qr_code_owner_5` FOREIGN KEY (`qr_code_owner_type_uuid`) REFERENCES `qr_code_owner_type` (`uuid`) ON DELETE NO ACTION ON UPDATE NO ACTION;
            COMMIT;
SQL;
        $this->addSql($alterTable);


        $alterTable = <<<SQL
            SET FOREIGN_KEY_CHECKS = 0 ;
            START TRANSACTION;
            ALTER TABLE `qr_code_owner_type`
            ADD CONSTRAINT `fk_account_inqrcodeowner` FOREIGN KEY (`account_uuid`) REFERENCES `account` (`uuid`);
            COMMIT;
SQL;
        $this->addSql($alterTable);


        $alterTable = <<<SQL
            SET FOREIGN_KEY_CHECKS = 0 ;
            START TRANSACTION;
            ALTER TABLE `reset_password`
            ADD CONSTRAINT `FK_B9983CE5E7927C74` FOREIGN KEY (`email`) REFERENCES `oauth_users` (`username`);
                        COMMIT;
            SQL;
        $this->addSql($alterTable);


        $alterTable = <<<SQL
            SET FOREIGN_KEY_CHECKS = 0 ;
            START TRANSACTION;
            ALTER TABLE `user_access`
            ADD CONSTRAINT `user_access_user_profile_fk` FOREIGN KEY (`user_profile_uuid`) REFERENCES `user_profile` (`uuid`) ON DELETE NO ACTION ON UPDATE NO ACTION,
            ADD CONSTRAINT `user_access_user_role_fk` FOREIGN KEY (`user_role_uuid`) REFERENCES `user_role` (`uuid`) ON DELETE NO ACTION ON UPDATE NO ACTION;
                        COMMIT;
            SQL;
        $this->addSql($alterTable);


        $alterTable = <<<SQL
            SET FOREIGN_KEY_CHECKS = 0 ;
            START TRANSACTION;
            ALTER TABLE `user_acl`
            ADD CONSTRAINT `user_module_acl_fk` FOREIGN KEY (`user_module_uuid`) REFERENCES `user_module` (`uuid`) ON DELETE NO ACTION ON UPDATE NO ACTION,
            ADD CONSTRAINT `user_role_acl_fk` FOREIGN KEY (`user_role_uuid`) REFERENCES `user_role` (`uuid`) ON DELETE NO ACTION ON UPDATE NO ACTION;
                        COMMIT;
            SQL;
        $this->addSql($alterTable);


        $alterTable = <<<SQL
            SET FOREIGN_KEY_CHECKS = 0 ;
            START TRANSACTION;
            ALTER TABLE `user_activation`
            ADD CONSTRAINT `FK_BB0FA69BE7927C74` FOREIGN KEY (`email`) REFERENCES `oauth_users` (`username`);
                        COMMIT;
            SQL;
        $this->addSql($alterTable);


        $alterTable = <<<SQL
            SET FOREIGN_KEY_CHECKS = 0 ;
            START TRANSACTION;
            ALTER TABLE `user_activation_log`
            ADD CONSTRAINT `fk_user_activation_log` FOREIGN KEY (`user_profile_uuid`) REFERENCES `user_profile` (`uuid`) ON DELETE NO ACTION ON UPDATE CASCADE,
            ADD CONSTRAINT `fk_user_activation_log_account` FOREIGN KEY (`account_uuid`) REFERENCES `account` (`uuid`) ON DELETE NO ACTION ON UPDATE CASCADE,
            ADD CONSTRAINT `fk_user_created_log` FOREIGN KEY (`created_by`) REFERENCES `user_profile` (`uuid`) ON DELETE NO ACTION ON UPDATE CASCADE;
                        COMMIT;
            SQL;
        $this->addSql($alterTable);


        $alterTable = <<<SQL
            SET FOREIGN_KEY_CHECKS = 0 ;
            START TRANSACTION;
            ALTER TABLE `user_document`
            ADD CONSTRAINT `fk_document_user_idx` FOREIGN KEY (`user_uuid`) REFERENCES `user_profile` (`uuid`) ON DELETE NO ACTION ON UPDATE NO ACTION;
                        COMMIT;
            SQL;
        $this->addSql($alterTable);


        $alterTable = <<<SQL
            SET FOREIGN_KEY_CHECKS = 0 ;
            START TRANSACTION;
            ALTER TABLE `user_module`
            ADD CONSTRAINT `user_module_parent_fk` FOREIGN KEY (`parent_uuid`) REFERENCES `user_module` (`uuid`) ON DELETE NO ACTION ON UPDATE NO ACTION;
                        COMMIT;
            SQL;
        $this->addSql($alterTable);


        $alterTable = <<<SQL
            SET FOREIGN_KEY_CHECKS = 0 ;
            START TRANSACTION;
            ALTER TABLE `user_profile`
            ADD CONSTRAINT `fk_one_user_profile_parent` FOREIGN KEY (`parent_uuid`) REFERENCES `user_profile` (`uuid`) ON DELETE CASCADE ON UPDATE NO ACTION,
            ADD CONSTRAINT `fk_one_user_profile_username` FOREIGN KEY (`username`) REFERENCES `oauth_users` (`username`) ON DELETE SET NULL ON UPDATE CASCADE,
            ADD CONSTRAINT `company_fk` FOREIGN KEY (`company_uuid`) REFERENCES `company` (`uuid`) ON DELETE NO ACTION ON UPDATE NO ACTION,
            ADD CONSTRAINT `department_fk` FOREIGN KEY (`department_uuid`) REFERENCES `department` (`uuid`) ON DELETE NO ACTION ON UPDATE NO ACTION,
            ADD CONSTRAINT `driving_activity_fk` FOREIGN KEY (`driving_activity`) REFERENCES `vehicle_request` (`uuid`) ON DELETE NO ACTION ON UPDATE NO ACTION,
            ADD CONSTRAINT `employment_type_fk` FOREIGN KEY (`employment_type_uuid`) REFERENCES `employment_type` (`uuid`) ON DELETE NO ACTION ON UPDATE NO ACTION,
            ADD CONSTRAINT `job_activity_fk` FOREIGN KEY (`job_activity`) REFERENCES `job` (`uuid`) ON DELETE NO ACTION ON UPDATE NO ACTION,
            ADD CONSTRAINT `position_fk` FOREIGN KEY (`position_uuid`) REFERENCES `position` (`uuid`) ON DELETE NO ACTION ON UPDATE NO ACTION,
            ADD CONSTRAINT `review_fk_hospital` FOREIGN KEY (`hospital_uuid`) REFERENCES `hospital` (`uuid`) ON DELETE NO ACTION ON UPDATE CASCADE;
            COMMIT;
SQL;
        $this->addSql($alterTable);

        $alterTable = <<<SQL
            SET FOREIGN_KEY_CHECKS = 0 ;
            START TRANSACTION;
            ALTER TABLE `user_role`
            ADD CONSTRAINT `user_role_accounts_ffsk` FOREIGN KEY (`account_uuid`) REFERENCES `account` (`uuid`) ON DELETE NO ACTION ON UPDATE NO ACTION,
            ADD CONSTRAINT `user_role_branch_fk` FOREIGN KEY (`branch_uuid`) REFERENCES `branch` (`uuid`) ON DELETE NO ACTION ON UPDATE NO ACTION,
            ADD CONSTRAINT `user_role_company_fk` FOREIGN KEY (`company_uuid`) REFERENCES `company` (`uuid`) ON DELETE NO ACTION ON UPDATE NO ACTION,
            ADD CONSTRAINT `user_role_parent_fk` FOREIGN KEY (`parent_uuid`) REFERENCES `user_profile` (`uuid`) ON DELETE NO ACTION ON UPDATE NO ACTION;
            COMMIT;
SQL;
        $this->addSql($alterTable);

        $insertTable = <<<SQL
START TRANSACTION;
INSERT INTO `account` (`uuid`, `name`, `note`, `email`, `address`, `city`, `state`, `phone`, `currency`, `country_id`, `fcm_broadcast_topic`, `timezone`, `locale`, `created_at`, `updated_at`, `deleted_at`) VALUES
('a2a461a1-a742-11e7-b7ab-000c297bb294', 'Xtend Indonesia', 'Xtend Indonesia', NULL, NULL, NULL, NULL, NULL, 'IDR', 'ID', NULL, 'Asia/Jakarta', 'ID_id', '2020-04-22 11:57:57', NULL, NULL);
            COMMIT;
SQL;
        $this->addSql($insertTable);

        $insertTable = <<<SQL
START TRANSACTION;
INSERT INTO `branch` (`uuid`, `code`, `name`, `company_uuid`, `account_uuid`, `exchange_id`, `address`, `phone`, `ext_phone`, `fax`, `email`, `is_active`, `note`, `geofence`, `latitude`, `longitude`, `geofence_radius`, `updated_at`, `deleted_at`, `created_at`) VALUES
('e3618241-45be-11ec-974d-0225c907dcd6', 1, 'Medan Office', 'd63cefe4-45be-11ec-974d-0225c907dcd6', 'a2a461a1-a742-11e7-b7ab-000c297bb294', '1', 'Jalan Casia Raya Komp Tasbih 1 Blok OO No. 2A ', '08116300792', NULL, '123456789', 'info@xtendindonesia.co.id', 1, NULL, 0, NULL, NULL, 60.00, '2021-11-15 09:51:10', NULL, '2021-11-15 09:51:10');
            COMMIT;
SQL;
        $this->addSql($insertTable);

        $insertTable = <<<SQL
START TRANSACTION;
INSERT INTO `business_sector` (`uuid`, `name`, `note`, `created_at`, `updated_at`, `deleted_at`) VALUES
('afc72dc8-45be-11ec-974d-0225c907dcd6', 'Business', NULL, '2021-11-15 09:49:43', '2021-11-15 09:49:43', NULL);
            COMMIT;
SQL;
        $this->addSql($insertTable);

        $insertTable = <<<SQL
START TRANSACTION;
INSERT INTO `company` (`uuid`, `account_uuid`, `business_sector_uuid`, `code`, `name`, `address`, `phone`, `ext_phone`, `fax`, `registration_id`, `tax_id`, `about`, `email`, `path`, `is_active`, `is_hq`, `created_at`, `updated_at`, `deleted_at`) VALUES
('d63cefe4-45be-11ec-974d-0225c907dcd6', 'a2a461a1-a742-11e7-b7ab-000c297bb294', 'afc72dc8-45be-11ec-974d-0225c907dcd6', 1, 'PT. Xtend Integrasi Indonesia', 'Jalan Casia Raya Komplek Taman Setia Budi\nBlok OO No. 2 A', '061 888 138 11', NULL, '123456789', '1', '1', '', 'info@xtendindonesia.co.id', 'photo/company_6191cb08250018_01997785.png', 1, 1, '2021-11-15 09:50:48', '2021-11-15 09:50:48', NULL);
            COMMIT;
SQL;
        $this->addSql($insertTable);

        $insertTable = <<<SQL
START TRANSACTION;
INSERT INTO `department` (`uuid`, `code`, `name`, `company_uuid`, `branch_uuid`, `account_uuid`, `phone`, `ext_phone`, `fax`, `email`, `is_active`, `note`, `created_at`, `updated_at`, `deleted_at`) VALUES
('ee31c93f-45be-11ec-974d-0225c907dcd6', 1, 'Admin', 'd63cefe4-45be-11ec-974d-0225c907dcd6', 'e3618241-45be-11ec-974d-0225c907dcd6', 'a2a461a1-a742-11e7-b7ab-000c297bb294', '061 888 138 11', '', '123456789', 'info@xtendindonesia.co.id\n\n', 1, NULL, '2021-11-15 09:51:28', '2021-11-15 09:51:28', NULL);
            COMMIT;
SQL;
        $this->addSql($insertTable);

        $insertTable = <<<SQL
START TRANSACTION;
INSERT INTO `employment_type` (`uuid`, `name`, `note`, `created_at`, `updated_at`, `deleted_at`) VALUES
('9c2b62e3-45be-11ec-974d-0225c907dcd6', 'Full Time', NULL, '2021-11-15 09:49:10', '2021-11-15 09:49:10', NULL);
            COMMIT;
SQL;
        $this->addSql($insertTable);

        $insertTable = <<<SQL
START TRANSACTION;
INSERT INTO `oauth_clients` (`client_id`, `client_secret`, `redirect_uri`, `grant_types`, `scope`, `user_id`) VALUES
('iqs-mobile-app', '$2y$10\$bedwEwm.kIFCjcENn1Xxz.KB32EclKVrons6qlLgMbNzzmQwl0vI6', '/oauth/receivecode', NULL, NULL, NULL),
('iqs-web-admin', '$2y$12\$pmKBYqH85tk2OGa3rH6psexBZP2/W9OQeet8YqjXRSJGc218DZXlO', '/oauth/receivecode', NULL, NULL, NULL);
            COMMIT;
SQL;
        $this->addSql($insertTable);

        $insertTable = <<<SQL
START TRANSACTION;
INSERT INTO `oauth_users` (`username`, `password`, `first_name`, `last_name`, `account_uuid`) VALUES
('admin', '$2a$12\$PCFb7ks2smIBVKb.tTYoNuxUY3WWUZkj1ib1j.mQw8/uXEhp/9LBm', 'Admin', 'Xtend IDN', NULL);
            COMMIT;
SQL;
        $this->addSql($insertTable);

        $insertTable = <<<SQL
START TRANSACTION;
INSERT INTO `position` (`uuid`, `name`, `note`, `created_at`, `updated_at`, `deleted_at`) VALUES
('1dcb7b9f-45bf-11ec-974d-0225c907dcd6', 'Admin', NULL, '2021-11-15 09:52:48', '2021-11-15 09:52:48', NULL);
            COMMIT;
SQL;
        $this->addSql($insertTable);

        $insertTable = <<<SQL
START TRANSACTION;
INSERT INTO `qr_code` (`uuid`, `user_profile_uuid`, `customer_uuid`, `appointment_uuid`, `value`, `path`, `type`, `expired_at`, `is_available`, `created_at`, `updated_at`, `deleted_at`) VALUES
('4a951076-78cc-11ec-a377-0242ac110002', NULL, NULL, NULL, '35a5d36df574e004da33', 'qrcode/4a951076-78cc-11ec-a377-0242ac110002.png', NULL, NULL, 1, '2022-01-19 09:05:36', '2022-01-19 09:05:36', NULL);
            COMMIT;
SQL;
        $this->addSql($insertTable);

        $insertTable = <<<SQL
START TRANSACTION;
INSERT INTO `user_access` (`uuid`, `user_profile_uuid`, `user_role_uuid`, `is_active`, `created_at`, `updated_at`, `deleted_at`) VALUES
('7d9a0202-8b2c-4863-bbfb-e6722f33b2ee', '495e5901-c01c-4af7-ba6a-1d12236dc167', 'bb9be068-d3ce-42c6-90c7-566d0d829e13', 1, '2020-08-26 11:23:48', '2020-08-26 11:23:48', NULL);
            COMMIT;
SQL;
        $this->addSql($insertTable);

        $insertTable = <<<SQL
START TRANSACTION;
INSERT INTO `user_acl` (`uuid`, `user_module_uuid`, `user_role_uuid`, `created_at`, `updated_at`, `deleted_at`) VALUES
('010d2429-abf2-46c6-9cd3-258a594e0dd1', 'cdef7758-94fa-4c15-ad33-9ba71e15ec23', 'bb9be068-d3ce-42c6-90c7-566d0d829e13', NULL, NULL, NULL),
('466fc948-8125-4f94-b6df-1f968e9e053d', 'cdef7758-94fa-4c15-ad33-9ba71e15ec23', 'bb9be068-d3ce-42c6-90c7-566d0d829e13', NULL, NULL, NULL),
('5bee0a1b-0d77-47a6-be61-9480654a6162', 'e77558f6-b47c-49b6-8a71-79215d42cd4a', 'd9fb9f73-f1d9-4c01-a5bd-a25f5527af10', NULL, NULL, NULL),
('a8d72b13-65fb-4903-9ebf-f7045a081294', 'cdef7758-94fa-4c15-ad33-9ba71e15ec23', 'cfafea40-b275-417c-a224-7bb41ce893df', NULL, NULL, NULL),
('d17b297c-b37f-462e-b0f9-25ae1de39ead', 'cdef7758-94fa-4c15-ad33-9ba71e15ec23', '16897db3-be09-419f-b2a6-38087aea2ab4', NULL, NULL, NULL),
('f8ed8230-48fd-4492-b5fa-30bbfac7c871', 'e77558f6-b47c-49b6-8a71-79215d42cd4a', '5eaf5ce5-ceae-46fc-b3d8-713d2128398d', NULL, NULL, NULL);
            COMMIT;
SQL;
        $this->addSql($insertTable);

        $insertTable = <<<SQL
START TRANSACTION;
INSERT INTO `user_module` (`uuid`, `name`, `status`, `path`, `parent_uuid`, `created_at`, `updated_at`, `deleted_at`) VALUES
('0b17e1a8-aeee-4f23-8074-9e275037a7a5', 'Customer', 1, NULL, NULL, NULL, NULL, NULL),
('13a0c7df-15e5-4721-afe4-3e005b108fba', 'SalesOrder', 1, NULL, NULL, NULL, NULL, NULL),
('26bb66c3-d0d4-461b-86ee-90db63d78766', 'Quotation', 1, NULL, NULL, NULL, NULL, NULL),
('2ceaf906-e4c0-449c-8fbd-22143c7f9886', 'Branch', 1, NULL, NULL, NULL, NULL, NULL),
('30bc459e-2316-479b-8c3e-6422d007864b', 'Leave', 1, NULL, NULL, NULL, NULL, NULL),
('4712966e-58bd-46bb-99ee-9410041f077c', 'Department', 1, NULL, NULL, NULL, NULL, NULL),
('500598d0-2507-4260-a947-31ec53ee7166', 'Dashboard', 1, NULL, NULL, NULL, NULL, NULL),
('6d2ab027-1072-4bf7-9edc-fbbcbb45910a', 'QRCode', 1, NULL, NULL, NULL, NULL, NULL),
('7ef0570b-3b75-4737-a767-994212097f69', 'Employee', 1, NULL, NULL, NULL, NULL, NULL),
('8038f790-ffe2-11ea-87dc-02752207ca62', 'AbzModule', 1, 'data/photo/icon-module_5f6f16eea2a4d7_56775777.png', NULL, '2020-09-26 17:24:46', '2020-09-26 17:24:46', NULL),
('850c73c8-c981-4435-8600-bc63ff5471af', 'Item', 1, NULL, NULL, NULL, NULL, NULL),
('8a505cc4-d022-42b8-bb30-bf145bf82dc6', 'Reimbursement', 1, NULL, NULL, NULL, NULL, NULL),
('a25f8f48-bdf4-11eb-87dc-02752207ca62', 'AbzModule', 1, NULL, NULL, '2021-05-26 14:33:15', '2021-05-26 14:33:15', NULL),
('cb8f6524-6acc-432f-810a-5e0499d27cf2', 'Timesheet', 1, NULL, NULL, NULL, NULL, NULL),
('cd347fa0-6b23-4c28-b4c5-eebc9a1030c4', 'Company', 1, NULL, NULL, NULL, NULL, NULL),
('cdef7758-94fa-4c15-ad33-9ba71e15ec23', 'All', 1, NULL, NULL, NULL, NULL, NULL),
('e756230e-5e06-497c-8b66-7d5d827dddcf', 'Overtime', 1, NULL, NULL, NULL, NULL, NULL),
('e77558f6-b47c-49b6-8a71-79215d42cd4a', 'Vehicle', 1, NULL, NULL, NULL, NULL, NULL),
('f89929bc-c34e-4521-a707-410adcc63a25', 'WeeklyTimesheet', 1, NULL, NULL, NULL, NULL, NULL);
            COMMIT;
SQL;
        $this->addSql($insertTable);

        $insertTable = <<<SQL
START TRANSACTION;
INSERT INTO `user_profile` (`uuid`, `branch_uuid`, `department_uuid`, `company_uuid`, `account_uuid`, `facetemp_token`, `atac_token`, `staff_id`, `hospital_uuid`, `position_uuid`, `employment_type_uuid`, `job_activity`, `driving_activity`, `username`, `email`, `workemail`, `fic_number`, `ic_number`, `driving_licence`, `secret`, `first_name`, `last_name`, `nick_name`, `first_date`, `current_address`, `role`, `phone`, `workphone`, `mobile`, `parent_uuid`, `pob`, `dob`, `gender`, `marital_status`, `address`, `address_current`, `city`, `state_uuid`, `district_uuid`, `postal_code`, `country`, `identity_type`, `nationality`, `blood_type`, `relation_primary_name`, `relation_primary_phone`, `relationship_primary`, `relation_secondary_name`, `relation_secondary_phone`, `relationship_secondary`, `job_desk`, `timezone`, `photo`, `is_active`, `firebase_id`, `android_device_id`, `ios_device_token`, `android_last_state`, `latitude`, `longitude`, `questionnaire_counter`, `last_questionnaire_at`, `last_score`, `leave_quota`, `signature`, `created_at`, `updated_at`, `deleted_at`) VALUES
('495e5901-c01c-4af7-ba6a-1d12236dc167', 'e3618241-45be-11ec-974d-0225c907dcd6', 'ee31c93f-45be-11ec-974d-0225c907dcd6', 'd63cefe4-45be-11ec-974d-0225c907dcd6', 'a2a461a1-a742-11e7-b7ab-000c297bb294', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'admin', 'info@xtendindonesia.co.id', 'info@xtendindonesia.co.id', NULL, '1', NULL, NULL, 'Admin', 'XTEND IDN', 'null', '2020-09-06', NULL, 'Admin', '', '', NULL, NULL, 'null', '2020-09-06', 'null', 'null', 'Jalan Casia Raya Komplek Taman Setia Budi\nBlok OO No. 2 A', 'Jalan Casia Raya Komplek Taman Setia Budi\nBlok OO No. 2 A', 'Medan', NULL, NULL, NULL, 'ID', NULL, NULL, 'null', 'null', '', 'null', 'null', '', 'null', '', 'Asia/Jakarta', NULL, 1, NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, 100, NULL, NULL, '2022-01-19 14:53:38', NULL);
            COMMIT;
SQL;
        $this->addSql($insertTable);

        $insertTable = <<<SQL
START TRANSACTION;
INSERT INTO `user_role` (`uuid`, `account_uuid`, `company_uuid`, `branch_uuid`, `name`, `parent_uuid`, `created_at`, `updated_at`, `deleted_at`) VALUES
('6b24e192-2f2a-48ff-8325-00707ae5ce1f', 'a2a461a1-a742-11e7-b7ab-000c297bb294', NULL, NULL, 'USER', 'd9fb9f73-f1d9-4c01-a5bd-a25f5527af10', NULL, NULL, NULL),
('bb9be068-d3ce-42c6-90c7-566d0d829e13', 'a2a461a1-a742-11e7-b7ab-000c297bb294', NULL, NULL, 'ADMIN', NULL, NULL, NULL, NULL),
('cfafea40-b275-417c-a224-7bb41ce893df', 'a2a461a1-a742-11e7-b7ab-000c297bb294', NULL, NULL, 'MANAGER', 'bb9be068-d3ce-42c6-90c7-566d0d829e13', NULL, NULL, NULL),
('d9fb9f73-f1d9-4c01-a5bd-a25f5527af10', 'a2a461a1-a742-11e7-b7ab-000c297bb294', NULL, NULL, 'TRANSPORTATION', 'cfafea40-b275-417c-a224-7bb41ce893df', NULL, NULL, NULL);
            COMMIT;
SQL;
        $this->addSql($insertTable);

        $createTable = <<<SQL
        SET FOREIGN_KEY_CHECKS = 1 ;
            COMMIT;
SQL;
        $this->addSql($createTable);
    }

    public function down(Schema $schema): void
    {
        $dropTable = <<<SQL
        SET FOREIGN_KEY_CHECKS = 0 ;
        DROP TABLE `account`,
         `branch`,
         `business_sector`,
         `company`,
         `department`,
         `education`,
         `employment_type`,
         `notification`,
         `notification_log`,
         `oauth_access_tokens`,
         `oauth_authorization_codes`,
         `oauth_clients`,
         `oauth_jwt`,
         `oauth_refresh_tokens`,
         `oauth_scopes`,
         `oauth_users`,
         `position`,
         `qr_code`,
         `qr_code_log`,
         `qr_code_owner`,
         `qr_code_owner_type`,
         `reset_password`,
         `user_access`,
         `user_acl`,
         `user_activation`,
         `user_activation_log`,
         `user_document`,
         `user_module`,
         `user_profile`,
         `user_role`;
         SET FOREIGN_KEY_CHECKS = 1 ;
SQL;
        $this->addSql($dropTable);
    }
}

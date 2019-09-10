
-- phpMyAdmin SQL Dump
-- version 4.8.3
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Sep 2, 2019 at 10:25 AM
-- Server version: 10.1.16-MariaDB
-- PHP Version: 7.2.9

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: rpfp
--

DELIMITER $$
--
-- Procedures and FUNCTIONs
--

/* USER MANAGEMENT */
CREATE DEFINER=root@localhost FUNCTION select_role( role_num INT(11) )
    RETURNS VARCHAR(25) CONTAINS SQL
BEGIN
    DECLARE default_role VARCHAR(25);
    IF role_num IS NOT NULL THEN
        CASE role_num
            WHEN 100 THEN
                SET default_role = "itdmu";

            WHEN 90 THEN
                SET default_role = "pmed";

            WHEN 80 THEN
                SET default_role = "regional_data_manager";

            WHEN 70 THEN
                SET default_role = "focal_person";

            WHEN 60 THEN
                SET default_role = "encoder";
            ELSE 
                SET default_role = "rpfp_login";
        END CASE;
    END IF;
    RETURN default_role;
END$$

CREATE DEFINER=root@localhost FUNCTION select_scope( scope_num INT(11) )
    RETURNS VARCHAR(25) CONTAINS SQL
BEGIN
    DECLARE default_scope VARCHAR(25) DEFAULT "no_scope";
    IF scope_num IS NOT NULL THEN
        CASE scope_num
            WHEN 50 THEN
                SET default_scope = "national";

            WHEN 40 THEN
                SET default_scope = "regional";

            WHEN 30 THEN
                SET default_scope = "provincial";

            WHEN 20 THEN
                SET default_scope = "citiwide";
            ELSE
                SET default_scope = "no_scope";
        END CASE;
    END IF;
    RETURN default_scope;
END$$

CREATE DEFINER=root@localhost PROCEDURE itdmu_create_rpfp_user(
    IN lastname VARCHAR(50) CHARSET utf8 COLLATE utf8_unicode_ci,
    IN firstname VARCHAR(50) CHARSET utf8 COLLATE utf8_unicode_ci,
    IN db_user VARCHAR(50) CHARSET utf8 COLLATE utf8_unicode_ci,
    IN passwd VARCHAR(50) CHARSET utf8 COLLATE utf8_unicode_ci,
    IN reg INT UNSIGNED,
    IN prov INT UNSIGNED,
    IN muni INT UNSIGNED,
    IN my_role INT UNSIGNED,
    IN scope_reg_prov_or_muni INT UNSIGNED
    )  MODIFIES SQL DATA
BEGIN
    DECLARE record_id_no INT UNSIGNED;

    SET @sql_stmt1 = CONCAT("CREATE USER IF NOT EXISTS ", QUOTE(db_user), "@localhost");
    PREPARE stmt1 FROM @sql_stmt1;
    
    SET @sql_stmt2 = CONCAT("GRANT rpfp_login TO ", QUOTE(db_user), "@localhost");
    PREPARE stmt2 FROM @sql_stmt2;

    SET @sql_stmt3 = CONCAT("SELECT 1 FROM DUAL");
    SET @sql_stmt4 = CONCAT("SET DEFAULT ROLE rpfp_login FOR ", QUOTE(db_user), "@localhost");
    IF my_role IS NOT NULL THEN
        SET @default_role := select_role(my_role);
        SET @sql_stmt3 = CONCAT("GRANT ", @default_role, " TO ", QUOTE(db_user), "@localhost");
        SET @sql_stmt4 = CONCAT("SET DEFAULT ROLE ", @default_role, " FOR ", QUOTE(db_user), "@localhost");
    END IF;
    PREPARE stmt3 FROM @sql_stmt3;
    PREPARE stmt4 FROM @sql_stmt4;

    SET @sql_stmt5 = CONCAT("SET PASSWORD FOR  ", QUOTE(db_user), "@localhost = PASSWORD(", QUOTE(passwd), ")");
    PREPARE stmt5 FROM @sql_stmt;

    SET @sql_stmt6 = CONCAT("SELECT 1 FROM DUAL");
    IF scope_reg_prov_or_muni IS NOT NULL THEN
        @scope_role := select_scope( scope_reg_prov_or_muni );
        SET @sql_stmt6 = CONCAT("GRANT ", @scope_role, " TO ", QUOTE(db_user), "@localhost");

    END IF;
    PREPARE stmt6 FROM @sql_stmt;

    EXECUTE stmt1;
    EXECUTE stmt2;
    EXECUTE stmt3;
    EXECUTE stmt4;
    EXECUTE stmt5;
    EXECUTE stmt6;

     SELECT up.PROFILE_ID INTO record_id_no
       FROM rpfp.user_profile up
      WHERE up.DB_USER_ID = db_user
    ;
    IF record_id_no IS NULL THEN
        INSERT INTO rpfp.user_profile (
                    LAST_NAME, 
                    FIRST_NAME,
                    REGION,
                    PROVINCE,
                    MUNICIPALITY,
                    IS_ACTIVE
        )
            VALUES (
                    lastname,
                    firstname,
                    reg,
                    prov,
                    muni,
                    1
        );
    END IF;
END$$

CREATE DEFINER=root@localhost PROCEDURE itdmu_update_first_login(IN db_user VARCHAR(50))  MODIFIES SQL DATA
BEGIN
     UPDATE rpfp.user_profile up
        SET up.INITIAL_PASS_COLUMN = 0
      WHERE CONCAT(up.DB_USER_ID, "@localhost") = db_user
    ;
END$$

CREATE DEFINER=root@localhost PROCEDURE itdmu_change_user_password (
    IN db_user VARCHAR(50),
    IN new_passwd VARCHAR(50) CHARSET utf8 COLLATE utf8_unicode_ci
    ) CONTAINS SQL
BEGIN
    SET @sql_stmt = CONCAT("SET PASSWORD FOR ", db_user, " = PASSWORD(", QUOTE(new_passwd), ")");

    PREPARE stmt1 FROM @sql_stmt;
    EXECUTE stmt1;
    CALL rpfp.itdmu_update_first_login(db_user);
END$$
/* END OF USER MANAGEMENT */


/* LOGIN PROCS */

CREATE DEFINER=root@localhost FUNCTION login_check_own_password(
    old_passwd VARCHAR(50) CHARSET utf8 COLLATE utf8_unicode_ci
    ) RETURNS INT(1) READS SQL DATA
BEGIN
     SELECT TRUE INTO @ret
       FROM mysql.user u
      WHERE CONCAT(u.user, "@localhost") = USER()
        AND u.password = PASSWORD(IFNULL(old_passwd, ''))
    ;
    return @ret;
END$$

CREATE DEFINER=root@localhost FUNCTION login_check_first_login() RETURNS INT(1) READS SQL DATA
BEGIN
     SELECT TRUE INTO @ret
       FROM rpfp.user_profile up
      WHERE CONCAT(up.DB_USER_ID, "@localhost") = USER()
        AND up.INITIAL_PASS_COLUMN = 1
    ;
    RETURN @ret;
END$$

CREATE DEFINER=root@localhost PROCEDURE login_change_initial_password(
    IN new_passwd VARCHAR(50)
    )  CONTAINS SQL
BEGIN
    IF EXISTS (
         SELECT rpfp.login_check_first_login()
    ) THEN
        BEGIN
           CALL rpfp.itdmu_change_user_password(USER(), new_passwd);
        END;
    ELSE
         SELECT "NOT FIRST LOGIN" AS MESSAGE;
    END IF;
END$$

CREATE DEFINER=root@localhost PROCEDURE login_change_own_password(
    IN old_passwd VARCHAR(50) CHARSET utf8 COLLATE utf8_unicode_ci,
    IN new_passwd VARCHAR(50) CHARSET utf8 COLLATE utf8_unicode_ci
    ) CONTAINS SQL
proc_exit_point :
BEGIN
    IF old_passwd = new_passwd THEN
         SELECT "INVALID PASSWORD" AS MESSAGE;
        LEAVE proc_exit_point;
    END IF;

    IF EXISTS (
         SELECT rpfp.login_check_own_password(old_passwd)
    ) THEN
           CALL rpfp.itdmu_login_change_user_password(USER(), new_passwd);
    ELSE
         SELECT "INVALID PASSWORD!" AS MESSAGE;
    END IF;
END$$

CREATE DEFINER=root@localhost PROCEDURE login_update_first_login() CONTAINS SQL
BEGIN
    CALL rpfp.itdmu_update_first_login(USER());
END$$
/* END OF LOGIN PROCS */


/* PROFILE PROCS */
CREATE DEFINER=root@localhost FUNCTION get_scope() RETURNS INT(11)
    READS SQL DATA
    SQL SECURITY INVOKER
BEGIN    
    IF EXISTS check_role(50) THEN
        RETURN 50;
    END IF;
    
    IF EXISTS check_role(40) THEN
        RETURN 40;
    END IF;

    IF EXISTS check_role(30) THEN
        RETURN 30;
    END IF;

    IF EXISTS check_role(20) THEN
        RETURN 20;
    END IF;

    RETURN 0;
END$$

CREATE DEFINER=root@localhost FUNCTION check_role(role_num INT(11)) RETURNS INT(1)
    READS SQL DATA
    SQL SECURITY INVOKER
BEGIN
    SELECT TRUE INTO @ret
      FROM information_schema.APPLICABLE_ROLES
     where ROLE_NAME = select_role( role_num )
       AND GRANTEE = USER();
    
    RETURN @ret;
END$$

CREATE DEFINER=root@localhost FUNCTION check_if_encoder() RETURNS INT(1)
    READS SQL DATA
BEGIN
    DECLARE ret_val INT(1) DEFAULT NULL;
    SET ret_val := check_role(60);
    RETURN ret_val;
END$$

CREATE DEFINER=root@localhost FUNCTION check_if_focal() RETURNS INT(1)
    READS SQL DATA
BEGIN
    DECLARE ret_val INT(1) DEFAULT NULL;
    SET ret_val := check_role(70);
    RETURN ret_val;
END$$

CREATE DEFINER=root@localhost FUNCTION check_if_data_manager() RETURNS INT(1)
    READS SQL DATA
BEGIN
    DECLARE ret_val INT(1) DEFAULT NULL;
    SET ret_val := check_role(80);
    RETURN ret_val;
END$$

CREATE DEFINER=root@localhost FUNCTION check_if_pmed() RETURNS INT(1)
    READS SQL DATA
BEGIN
    DECLARE ret_val INT(1) DEFAULT NULL;
    SET ret_val := check_role(90);
    RETURN ret_val;
END$$

CREATE DEFINER=root@localhost FUNCTION check_if_itdmu() RETURNS INT(1)
    READS SQL DATA
BEGIN
    DECLARE ret_val INT(1) DEFAULT NULL;
    SET ret_val := check_role(100);
    RETURN ret_val;
END$$
/* END OF PROFILE PROCS */

DELIMITER ;

--
-- Table structure for table user_profile
--

CREATE TABLE user_profile (
          PROFILE_ID int(11) UNSIGNED NOT NULL,
          DB_USER_ID varchar(100) NOT NULL,
               EMAIL varchar(100) NOT NULL,
           LAST_NAME date NOT NULL,
          FIRST_NAME date NOT NULL,
              REGION int(11) UNSIGNED NOT NULL,
            PROVINCE int(11) UNSIGNED NOT NULL,
        MUNICIPALITY int(11) UNSIGNED NOT NULL,
 INITIAL_PASS_COLUMN int(11) UNSIGNED NOT NULL,
           IS_ACTIVE int(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------


/* RPFP ROLES */
/*
        ROLES
            100 = itdmu
             90 = pmed
             80 = regional_data_manager
             70 = focal_person
             60 = encoder

        SCOPE
             50 = national
             40 = regional
             30 = provincial
             20 = citiwide

*/

CREATE OR REPLACE ROLE no_scope;

CREATE OR REPLACE ROLE rpfp_login;
 GRANT EXECUTE ON FUNCTION rpfp.login_check_own_password TO 'rpfp_login';
 GRANT EXECUTE ON FUNCTION rpfp.login_check_first_login TO 'rpfp_login';
GRANT EXECUTE ON PROCEDURE rpfp.login_change_initial_password TO 'rpfp_login';
GRANT EXECUTE ON PROCEDURE rpfp.login_change_own_password TO 'rpfp_login';
GRANT EXECUTE ON PROCEDURE rpfp.login_update_first_login TO 'rpfp_login';

 GRANT EXECUTE ON FUNCTION rpfp.check_if_encoder TO 'rpfp_login';
 GRANT EXECUTE ON FUNCTION rpfp.check_if_focal TO 'rpfp_login';
 GRANT EXECUTE ON FUNCTION rpfp.check_if_data_manager TO 'rpfp_login';
 GRANT EXECUTE ON FUNCTION rpfp.check_if_pmed TO 'rpfp_login';
 GRANT EXECUTE ON FUNCTION rpfp.check_if_itdmu TO 'rpfp_login';


CREATE OR REPLACE ROLE itdmu;
   GRANT rpfp_login to itdmu;
GRANT EXECUTE ON PROCEDURE rpfp.itdmu_create_rpfp_user TO 'itdmu';
GRANT EXECUTE ON PROCEDURE rpfp.itdmu_update_first_login TO 'itdmu';
GRANT EXECUTE ON PROCEDURE rpfp.itdmu_change_user_password TO 'itdmu';


CREATE OR REPLACE ROLE pmed;
   GRANT rpfp_login to pmed;


CREATE OR REPLACE ROLE regional_data_manager;
   GRANT rpfp_login to regional_data_manager;


CREATE OR REPLACE ROLE focal_person;
   GRANT rpfp_login to focal_person;


CREATE OR REPLACE ROLE encoder;
   GRANT rpfp_login to encoder;




CREATE OR REPLACE ROLE citiwide;


CREATE OR REPLACE ROLE provincial;
     GRANT citiwide to provincial;


CREATE OR REPLACE ROLE regional;
   GRANT provincial to regional;


CREATE OR REPLACE ROLE national;
     GRANT regional to national;

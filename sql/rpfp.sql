/** 
    THIS UTILIZES OTHER FILES TO FILL-IN DATA
        1. psgc.sql

    To properly import the files
        1. Use command prompt:
            Start->Type "cmd" and select "Command Prompt"

        2. Go to the folder where the files are located
            cd D:\xampp\htdocs\rpfp\sql\

        3. Run mysql inside this folder
            D:\xampp\htdocs\rpfp\sql> d:\xampp\mysql\bin\mysql -u root test < rpfp.sql
*/


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

CREATE DATABASE RPFP;
USE RPFP;
--
-- Database: rpfp
--

--
-- Database Roles
--
    CREATE OR REPLACE ROLE no_scope;
    CREATE OR REPLACE ROLE rpfp_login;
    CREATE OR REPLACE ROLE itdmu;
    CREATE OR REPLACE ROLE pmed;
    CREATE OR REPLACE ROLE regional_data_manager;
    CREATE OR REPLACE ROLE focal_person;
    CREATE OR REPLACE ROLE encoder;
    CREATE OR REPLACE ROLE citiwide;
    CREATE OR REPLACE ROLE provincial;
    CREATE OR REPLACE ROLE regional;
    CREATE OR REPLACE ROLE national;


--
-- STORED ROUTINES
--

DELIMITER $$

/** USER MANAGEMENT */
CREATE DEFINER=root@localhost PROCEDURE itdmu_create_rpfp_user(
    IN surname VARCHAR(50) CHARSET utf8 COLLATE utf8_unicode_ci,
    IN firstname VARCHAR(50) CHARSET utf8 COLLATE utf8_unicode_ci,
    IN db_user VARCHAR(50) CHARSET utf8 COLLATE utf8_unicode_ci,
    IN passwd VARCHAR(50) CHARSET utf8 COLLATE utf8_unicode_ci,
    IN region_id INT UNSIGNED,
    IN location_code INT UNSIGNED,
    IN my_role INT UNSIGNED,
    IN scope_reg_prov_or_muni INT UNSIGNED
    )   MODIFIES SQL DATA
BEGIN
    DECLARE record_id_no INT UNSIGNED;

    /** TODO: CHECK IF USER HAS PREVIOUS ACCOUNT OR WAS DEACTIVATED */

    SET @sql_stmt1 := CONCAT("CREATE USER IF NOT EXISTS ", QUOTE(db_user), "@localhost");
    PREPARE stmt1 FROM @sql_stmt1;
    EXECUTE stmt1;
    
    SET @sql_stmt2 := CONCAT("GRANT rpfp_login TO ", QUOTE(db_user), "@localhost");
    PREPARE stmt2 FROM @sql_stmt2;
    EXECUTE stmt2;

    CALL rpfp.itdmu_change_user_password(db_user, passwd);

    CALL rpfp.profile_set_role(db_user, my_role);

    CALL rpfp.profile_set_scope(db_user, scope_reg_prov_or_muni);

     SELECT prof.PROFILE_ID INTO record_id_no
       FROM rpfp.user_profile prof
      WHERE prof.DB_USER_ID = db_user
    ;
    IF record_id_no IS NULL THEN
        INSERT INTO rpfp.user_profile (
                    DB_USER_ID,
                    LAST_NAME, 
                    FIRST_NAME,
                    REGION,
                    PSGC_CODE
        )
            VALUES (
                    db_user,
                    surname,
                    firstname,
                    region_id,
                    location_code
        );
    ELSE
         UPDATE rpfp.user_profile up
            SET up.REGION = region_id,
                up.PSGC_CODE = location_code,
                up.IS_ACTIVE = TRUE,
                up.INITIAL_PASS_COLUMN = TRUE
        ;
    END IF;
END$$

CREATE DEFINER=root@localhost PROCEDURE itdmu_update_first_login(
    IN db_user VARCHAR(50)
    )   MODIFIES SQL DATA
BEGIN
     UPDATE rpfp.user_profile prof
        SET prof.INITIAL_PASS_COLUMN = 0
      WHERE CONCAT(prof.DB_USER_ID, "@localhost") = db_user
    ;
END$$

CREATE DEFINER=root@localhost PROCEDURE itdmu_change_user_password (
    IN db_user VARCHAR(50),
    IN new_passwd VARCHAR(50) CHARSET utf8 COLLATE utf8_unicode_ci
    )   CONTAINS SQL
BEGIN
    SET @sql_stmt1 := CONCAT("SET PASSWORD FOR ", QUOTE(db_user), "@localhost = PASSWORD(", QUOTE(new_passwd), ")");
    PREPARE stmt1 FROM @sql_stmt1;
    EXECUTE stmt1;
END$$

CREATE DEFINER=root@localhost PROCEDURE itdmu_deactivate_user (
    IN db_user VARCHAR(50)
    )   
BEGIN
    SET @sql_stmt1 := CONCAT("REVOKE ALL PRIVILEGES, GRANT OPTION FROM ", QUOTE(db_user), "@localhost");
    PREPARE stmt1 FROM @sql_stmt1;
    EXECUTE stmt1;

    SET @sql_stmt2 := CONCAT("DROP USER ", QUOTE(db_user), "@localhost");
    PREPARE stmt2 FROM @sql_stmt2;
    EXECUTE stmt2;
END$$
/** END OF USER MANAGEMENT */


/** LOGIN PROCS */
CREATE DEFINER=root@localhost FUNCTION login_check_own_password(
    old_passwd VARCHAR(50) CHARSET utf8 COLLATE utf8_unicode_ci
    )   RETURNS INT(1) READS SQL DATA
BEGIN
    DECLARE ret_val INT(1) DEFAULT NULL;
     SELECT TRUE INTO ret_val
       FROM mysql.user u
      WHERE CONCAT(u.user, "@localhost") = USER()
        AND u.PASSWORD = PASSWORD(IFNULL(old_passwd, ''))
    ;
    RETURN ret_val;
END$$

CREATE DEFINER=root@localhost FUNCTION login_check_first_login()
        RETURNS INT(1)
        READS SQL DATA
BEGIN
    DECLARE ret_val INT(1) DEFAULT NULL;
     SELECT TRUE INTO ret_val
       FROM rpfp.user_profile prof
      WHERE CONCAT(prof.DB_USER_ID, "@localhost") = USER()
        AND prof.INITIAL_PASS_COLUMN = 1
    ;
    RETURN ret_val;
END$$

CREATE DEFINER=root@localhost PROCEDURE login_change_initial_password(
    IN new_passwd VARCHAR(50)
    )   CONTAINS SQL
BEGIN
    IF EXISTS (
         SELECT rpfp.login_check_first_login()
    ) THEN
        BEGIN
            CALL rpfp.itdmu_change_user_password(USER(), new_passwd);
            CALL rpfp.itdmu_update_first_login(USER());

        END;
    ELSE
         SELECT "NOT FIRST LOGIN" AS MESSAGE;
    END IF;
END$$

CREATE DEFINER=root@localhost PROCEDURE login_change_own_password(
    IN old_passwd VARCHAR(50) CHARSET utf8 COLLATE utf8_unicode_ci,
    IN new_passwd VARCHAR(50) CHARSET utf8 COLLATE utf8_unicode_ci
    )   CONTAINS SQL
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

CREATE DEFINER=root@localhost PROCEDURE login_update_first_login()
        CONTAINS SQL
BEGIN
    CALL rpfp.itdmu_update_first_login(USER());
END$$

CREATE DEFINER=root@localhost FUNCTION login_check_if_active()
        RETURNS INT(1)
        READS SQL DATA
BEGIN
    DECLARE ret_val INT(1) DEFAULT NULL;
     SELECT TRUE INTO ret_val
       FROM rpfp.user_profile up
      WHERE up.DB_USER_ID = USER()
        AND up.IS_ACTIVE = TRUE
    ;
    RETURN ret_val;
END$$
/** END OF LOGIN PROCS */


/** PROFILE PROCS */
CREATE DEFINER=root@localhost FUNCTION profile_select_role(
    role_num INT(11)
    )   RETURNS VARCHAR(25)
        CONTAINS SQL
BEGIN
    DECLARE default_role VARCHAR(25);
    IF role_num IS NOT NULL THEN
        CASE role_num
            WHEN 100 THEN
                SET default_role := "itdmu";

            WHEN 90 THEN
                SET default_role := "pmed";

            WHEN 80 THEN
                SET default_role := "regional_data_manager";

            WHEN 70 THEN
                SET default_role := "focal_person";

            WHEN 60 THEN
                SET default_role := "encoder";
            ELSE 
                SET default_role := "rpfp_login";
        END CASE;
    END IF;
    RETURN default_role;
END$$

CREATE DEFINER=root@localhost FUNCTION profile_select_scope(
    scope_num INT(11)
    )   RETURNS VARCHAR(25) CONTAINS SQL
BEGIN
    DECLARE default_scope VARCHAR(25) DEFAULT "no_scope";
    IF scope_num IS NOT NULL THEN
        CASE scope_num
            WHEN 50 THEN
                SET default_scope := "national";

            WHEN 40 THEN
                SET default_scope := "regional";

            WHEN 30 THEN
                SET default_scope := "provincial";

            WHEN 20 THEN
                SET default_scope := "citiwide";
            ELSE
                SET default_scope := "no_scope";
        END CASE;
    END IF;
    RETURN default_scope;
END$$

CREATE DEFINER=root@localhost FUNCTION profile_num_scope(
    scope_word VARCHAR(25)
    )   RETURNS INT(11) CONTAINS SQL
BEGIN
    DECLARE default_num INT(11) DEFAULT 0;
    IF scope_word IS NOT NULL AND scope_word != "" THEN
        CASE scope_word
            WHEN "national" THEN
                SET default_num := 50;

            WHEN "regional" THEN
                SET default_num := 40;

            WHEN "provincial" THEN
                SET default_num := 30;

            WHEN "citiwide" THEN
                SET default_num := 20;
            ELSE
                SET default_num := "0";
        END CASE;
    END IF;
    RETURN default_num;
END$$

CREATE DEFINER=root@localhost FUNCTION profile_num_role(
    role_word VARCHAR(25)
    )   RETURNS INT(11) CONTAINS SQL
BEGIN
    DECLARE default_num INT(11) DEFAULT 0;
    IF role_word IS NOT NULL THEN
        CASE role_word
            WHEN "itdmu" THEN
                SET default_num := 100;

            WHEN "pmed" THEN
                SET default_num := 90;

            WHEN "regional_data_manager" THEN
                SET default_num := 80;

            WHEN "focal_person" THEN
                SET default_num := 70;

            WHEN "encoder" THEN
                SET default_num := 60;
            ELSE 
                SET default_num := 0;
        END CASE;
    END IF;
    RETURN default_num;
END$$

CREATE DEFINER=root@localhost FUNCTION profile_get_role(
    db_user VARCHAR(50)
    )   RETURNS INT(11)
        CONTAINS SQL
BEGIN
    DECLARE ret_val INT(11);
    DECLARE role_word VARCHAR(50);

     SELECT rm.ROLE INTO role_word
       FROM mysql.ROLES_MAPPING rm
      WHERE CONCAT(rm.USER, '@', rm.HOST) = db_user
        AND rm.ROLE IN ('itdmu', 'pmed', 'regional_data_manager', 'focal_person', 'encoder')
      LIMIT 1
    ;

    IF role_word IS NOT NULL THEN
        RETURN rpfp.profile_num_role(role_word);
    END IF;

    RETURN 0;
END$$

CREATE DEFINER=root@localhost FUNCTION profile_get_scope(
    db_user VARCHAR(50)
    )   RETURNS INT(11)
        CONTAINS SQL
BEGIN
    DECLARE ret_val INT(11);
    DECLARE scope_word VARCHAR(50);

     SELECT rm.ROLE INTO scope_word
       FROM mysql.ROLES_MAPPING rm
      WHERE CONCAT(rm.USER, '@', rm.HOST) = db_user
        AND rm.ROLE IN ('national', 'regional', 'provincial', 'citiwide')
      LIMIT 1
    ;

    IF scope_word IS NOT NULL THEN
        RETURN rpfp.profile_num_scope(scope_word);
    END IF;

    RETURN 0;
END$$

CREATE DEFINER=root@localhost PROCEDURE profile_set_role(
    db_user VARCHAR(50),
    role_num INT(11)
    )   CONTAINS SQL
proc_exit_point :
BEGIN
    DECLARE default_role VARCHAR(50);
    IF role_num IS NULL THEN
        SELECT "ROLE IS EMPTY" AS MESSAGE;
        LEAVE proc_exit_point;
    END IF;

    IF role_num NOT IN (60, 70, 80, 90, 100) THEN
        SELECT concat("INVALID ROLE: ", role_num) AS MESSAGE;
        LEAVE proc_exit_point;
    END IF;

    SET default_role := rpfp.profile_select_role(role_num);
    SET @sql_stmt4 := CONCAT("GRANT ", default_role, " TO ", QUOTE(db_user), "@localhost");
    PREPARE stmt4 FROM @sql_stmt4;
    EXECUTE stmt4;

    SET @sql_stmt5 := CONCAT("SET DEFAULT ROLE ", default_role, " FOR ", QUOTE(db_user), "@localhost");
    PREPARE stmt5 FROM @sql_stmt5;
    EXECUTE stmt5;
END$$

CREATE DEFINER=root@localhost PROCEDURE profile_set_scope(
    db_user VARCHAR(50),
    scope_reg_prov_or_muni INT(11)
    )   CONTAINS SQL
proc_exit_point :    
BEGIN
    DECLARE scope_role VARCHAR(50) DEFAULT NULL;

    IF scope_reg_prov_or_muni IS NULL THEN
        SELECT "SCOPE IS EMPTY" AS MESSAGE;
        LEAVE proc_exit_point;
    END IF;

    IF scope_reg_prov_or_muni NOT IN (10, 20, 30, 40, 50) THEN
        SELECT "INVALID SCOPE" AS MESSAGE;
        LEAVE proc_exit_point;
    END IF;

    SET scope_role := rpfp.profile_select_scope( scope_reg_prov_or_muni );
    SET @sql_stmt6 := CONCAT("GRANT ", scope_role, " TO ", QUOTE(db_user), "@localhost");
    PREPARE stmt6 FROM @sql_stmt6;
    EXECUTE stmt6;
END$$

CREATE DEFINER=root@localhost FUNCTION profile_check_role(
    db_user VARCHAR(50),
    role_num INT(11)
    )   RETURNS INT(1)
        READS SQL DATA
BEGIN
    DECLARE ret_val INT(1) DEFAULT NULL;

    SELECT TRUE INTO ret_val
      FROM mysql.ROLES_MAPPING rm
     WHERE rm.ROLE = rpfp.profile_select_role( role_num )
       AND CONCAT(rm.USER, '@', rm.HOST) = db_user
     LIMIT 1  
    ;
    
    RETURN ret_val;
END$$

CREATE DEFINER=root@localhost FUNCTION profile_check_if_encoder() RETURNS INT(1)
    READS SQL DATA
BEGIN
    DECLARE ret_val INT(1) DEFAULT NULL;

    SET ret_val := rpfp.profile_check_role(USER(), 60);
    RETURN ret_val;
END$$

CREATE DEFINER=root@localhost FUNCTION profile_check_if_focal() RETURNS INT(1)
    READS SQL DATA
BEGIN
    DECLARE ret_val INT(1) DEFAULT NULL;

    SET ret_val := rpfp.profile_check_role(USER(), 70);
    RETURN ret_val;
END$$

CREATE DEFINER=root@localhost FUNCTION profile_check_if_data_manager() RETURNS INT(1)
    READS SQL DATA
BEGIN
    DECLARE ret_val INT(1) DEFAULT NULL;

    SET ret_val := rpfp.profile_check_role(USER(), 80);
    RETURN ret_val;
END$$

CREATE DEFINER=root@localhost FUNCTION profile_check_if_pmed() RETURNS INT(1)
    READS SQL DATA
BEGIN
    DECLARE ret_val INT(1) DEFAULT NULL;

    SET ret_val := rpfp.profile_check_role(USER(), 90);
    RETURN ret_val;
END$$

CREATE DEFINER=root@localhost FUNCTION profile_check_if_itdmu() RETURNS INT(1)
    READS SQL DATA
BEGIN
    DECLARE ret_val INT(1) DEFAULT NULL;

    SET ret_val := rpfp.profile_check_role(USER(), 100);
    RETURN ret_val;
END$$

CREATE DEFINER=root@localhost PROCEDURE profile_get_profile(
    db_user VARCHAR(50)
    )   READS SQL DATA
BEGIN
    DECLARE name_len INT(11);
    DECLARE name_user VARCHAR(50);

    SET name_user := db_user;
    SET name_len := LOCATE('@', db_user, 1);
    IF name_len > 0 THEN
        SET name_user := SUBSTRING(db_user, 1, name_len - 1);
    ELSE
        SET db_user := CONCAT(db_user, '@localhost');
    END IF;

     SELECT prof.PROFILE_ID id,
            prof.DB_USER_ID username,
            prof.E_MAIL email,
            prof.LAST_NAME surname,
            prof.FIRST_NAME firstname,
            prof.REGION region_id,
            reg.LOCATION_DESCRIPTION region_name,
            prof.PSGC_CODE location_code,
            loc.LOCATION_DESCRIPTION location_name,
            rpfp.profile_get_role(db_user) my_role,
            rpfp.profile_get_scope(db_user) my_scope
       FROM rpfp.user_profile prof
  LEFT JOIN rpfp.psgc_locations loc
         ON prof.PSGC_CODE = loc.PSGC_CODE
        AND prof.REGION = loc.REGION_CODE
  LEFT JOIN rpfp.psgc_locations reg
         ON reg.PSGC_CODE = (prof.REGION * POWER(10, 7))
      WHERE prof.DB_USER_ID = name_user
    ;
END$$

CREATE DEFINER=root@localhost PROCEDURE profile_get_own_profile()
        CONTAINS SQL
BEGIN
    CALL rpfp.profile_get_profile(USER());
END$$
/** END OF PROFILE PROCS */

/** LIBRARIES */
CREATE DEFINER=root@localhost PROCEDURE lib_list_regions()
        READS SQL DATA
BEGIN
     SELECT reg.REGION_CODE region_id,
            reg.PSGC_CODE location_code,
            reg.LOCATION_DESCRIPTION location_name
       FROM rpfp.psgc_locations reg
      WHERE reg.INTER_LEVEL = 'REG'
   ORDER BY reg.LOCATION_ID
      ;
END$$

CREATE DEFINER=root@localhost PROCEDURE lib_list_provinces(
    region_id INT(11) UNSIGNED
    )    READS SQL DATA
BEGIN
     SELECT reg.REGION_CODE region_id,
            reg.LOCATION_DESCRIPTION region_name,
            prov.PROVINCE_CODE location_code,
            prov.LOCATION_DESCRIPTION location_name
       FROM rpfp.psgc_locations prov
  LEFT JOIN rpfp.psgc_locations reg
         ON reg.PSGC_CODE = (prov.REGION_CODE * POWER(10, 7))
      WHERE prov.INTER_LEVEL IN ('PROV', 'DIST')
        AND prov.REGION_CODE = region_id
   ORDER BY prov.LOCATION_DESCRIPTION
      ;
END$$

CREATE DEFINER=root@localhost PROCEDURE lib_list_cities(
    province_id INT(11) UNSIGNED
    )    READS SQL DATA
BEGIN
     SELECT reg.REGION_CODE region_id,
            reg.LOCATION_DESCRIPTION region_name,
            prov.PROVINCE_CODE province_id,
            prov.LOCATION_DESCRIPTION province_name,
            city.MUNICIPALITY_CODE location_code,
            city.LOCATION_DESCRIPTION location_name
       FROM rpfp.psgc_locations city
  LEFT JOIN rpfp.psgc_locations reg
         ON reg.PSGC_CODE = (city.REGION_CODE * POWER(10, 7))
  LEFT JOIN rpfp.psgc_locations prov
         ON prov.PSGC_CODE = (city.PROVINCE_CODE * POWER(10, 5))
      WHERE city.INTER_LEVEL IN ('CITY', 'MUN', 'SUBMUN')
        AND city.PROVINCE_CODE = province_id
   ORDER BY city.LOCATION_DESCRIPTION
      ;
END$$

CREATE DEFINER=root@localhost PROCEDURE lib_list_brgy(
    municipality_id INT(11) UNSIGNED
    )    READS SQL DATA
BEGIN
     SELECT reg.REGION_CODE region_id,
            reg.LOCATION_DESCRIPTION region_name,
            prov.PROVINCE_CODE province_id,
            prov.LOCATION_DESCRIPTION province_name,
            city.MUNICIPALITY_CODE municipality_id,
            city.LOCATION_DESCRIPTION municipality_name,
            brgy.PSGC_CODE location_code,
            brgy.LOCATION_DESCRIPTION location_name
       FROM rpfp.psgc_locations brgy
  LEFT JOIN rpfp.psgc_locations reg
         ON reg.PSGC_CODE = (brgy.REGION_CODE * POWER(10, 7))
  LEFT JOIN rpfp.psgc_locations prov
         ON prov.PSGC_CODE = (brgy.PROVINCE_CODE * POWER(10, 5))
  LEFT JOIN rpfp.psgc_locations city
         ON city.PSGC_CODE = (brgy.MUNICIPALITY_CODE * POWER(10, 3))
      WHERE brgy.INTER_LEVEL IN ('BGY')
        AND brgy.MUNICIPALITY_CODE = municipality_id
   ORDER BY brgy.LOCATION_DESCRIPTION
      ;
END$$

/** LIBRARIES */

DELIMITER ;
--
-- END OF STORED ROUTINES
--


--
-- Table structure for table user_profile
--

CREATE TABLE user_profile (
          PROFILE_ID INT(11) UNSIGNED NOT NULL AUTO_INCREMENT,
          DB_USER_ID VARCHAR(50) NOT NULL,
              E_MAIL VARCHAR(100),
           LAST_NAME VARCHAR(50) NOT NULL,
          FIRST_NAME VARCHAR(50) NOT NULL,
              REGION INT(11) UNSIGNED,
           PSGC_CODE INT(11) UNSIGNED,
 INITIAL_PASS_COLUMN INT(1) UNSIGNED NOT NULL DEFAULT TRUE,
           IS_ACTIVE INT(1) NOT NULL DEFAULT TRUE,
         PRIMARY KEY (PROFILE_ID)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;


CREATE TABLE psgc_locations (
            LOCATION_ID INT(11) UNSIGNED NOT NULL AUTO_INCREMENT,
            REGION_CODE INT(11) UNSIGNED NOT NULL,
          PROVINCE_CODE INT(11) UNSIGNED NOT NULL,
      MUNICIPALITY_CODE INT(11) UNSIGNED NOT NULL,
              PSGC_CODE INT(11) UNSIGNED NOT NULL,
            INTER_LEVEL VARCHAR(10),
   LOCATION_DESCRIPTION VARCHAR(100),
            PRIMARY KEY (LOCATION_ID)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

/** DEFAULT VALUES / LIBRARY*/
/** PSGC LOCATIONS  */
SOURCE ./psgc.sql;
-- --------------------------------------------------------

/** RPFP ROLES */
/**
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

       GRANT rpfp_login to itdmu;
       GRANT rpfp_login to pmed;
       GRANT rpfp_login to regional_data_manager;
       GRANT rpfp_login to focal_person;
       GRANT rpfp_login to encoder;

         GRANT citiwide to provincial;
       GRANT provincial to regional;

 GRANT EXECUTE ON FUNCTION rpfp.login_check_own_password TO 'rpfp_login';
 GRANT EXECUTE ON FUNCTION rpfp.login_check_first_login TO 'rpfp_login';
GRANT EXECUTE ON PROCEDURE rpfp.login_change_initial_password TO 'rpfp_login';
GRANT EXECUTE ON PROCEDURE rpfp.login_change_own_password TO 'rpfp_login';
GRANT EXECUTE ON PROCEDURE rpfp.login_update_first_login TO 'rpfp_login';

 GRANT EXECUTE ON FUNCTION rpfp.profile_check_if_encoder TO 'rpfp_login';
 GRANT EXECUTE ON FUNCTION rpfp.profile_check_if_focal TO 'rpfp_login';
 GRANT EXECUTE ON FUNCTION rpfp.profile_check_if_data_manager TO 'rpfp_login';
 GRANT EXECUTE ON FUNCTION rpfp.profile_check_if_pmed TO 'rpfp_login';
 GRANT EXECUTE ON FUNCTION rpfp.profile_check_if_itdmu TO 'rpfp_login';

GRANT EXECUTE ON PROCEDURE rpfp.profile_get_own_profile TO 'rpfp_login';
GRANT EXECUTE ON PROCEDURE rpfp.lib_list_regions TO 'rpfp_login';
GRANT EXECUTE ON PROCEDURE rpfp.lib_list_provinces TO 'rpfp_login';
GRANT EXECUTE ON PROCEDURE rpfp.lib_list_cities TO 'rpfp_login';
GRANT EXECUTE ON PROCEDURE rpfp.lib_list_brgy TO 'rpfp_login';


GRANT EXECUTE ON PROCEDURE rpfp.itdmu_create_rpfp_user TO 'itdmu';
GRANT EXECUTE ON PROCEDURE rpfp.itdmu_update_first_login TO 'itdmu';
GRANT EXECUTE ON PROCEDURE rpfp.itdmu_change_user_password TO 'itdmu';
GRANT EXECUTE ON PROCEDURE rpfp.profile_get_profile TO 'itdmu';

/** END OF RPFP.SQL */

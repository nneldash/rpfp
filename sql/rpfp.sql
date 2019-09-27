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
	CREATE OR REPLACE ROLE partners;
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
    IN db_user VARCHAR(50) CHARSET utf8 COLLATE utf8_unicode_ci,
    IN passwd VARCHAR(50) CHARSET utf8 COLLATE utf8_unicode_ci,
    IN surname VARCHAR(50) CHARSET utf8 COLLATE utf8_unicode_ci,
    IN firstname VARCHAR(50) CHARSET utf8 COLLATE utf8_unicode_ci,
    IN email VARCHAR(50) CHARSET utf8 COLLATE utf8_unicode_ci,
    IN region_id INT UNSIGNED,
    IN location_code INT UNSIGNED,
    IN my_role INT UNSIGNED,
    IN scope_reg_prov_or_muni INT UNSIGNED
    )   MODIFIES SQL DATA
BEGIN
    DECLARE record_id_no INT UNSIGNED;
    DECLARE name_user VARCHAR(50);
    DECLARE db_user_name VARCHAR(50);

    CALL rpfp.lib_extract_user_name(db_user, name_user, db_user_name);

    SET @sql_stmt1 := CONCAT("CREATE USER IF NOT EXISTS ", db_user_name);
    PREPARE stmt1 FROM @sql_stmt1;
    EXECUTE stmt1;

    SET @sql_stmt2 := CONCAT("GRANT rpfp_login TO ", db_user_name);
    PREPARE stmt2 FROM @sql_stmt2;
    EXECUTE stmt2;

    CALL rpfp.itdmu_change_user_password(name_user, passwd);

    CALL rpfp.profile_set_role(name_user, my_role);

    CALL rpfp.profile_set_scope(name_user, scope_reg_prov_or_muni);

     SELECT prof.PROFILE_ID INTO record_id_no
       FROM rpfp.user_profile prof
      WHERE prof.DB_USER_ID = name_user
    ;
    IF record_id_no IS NULL THEN
        INSERT INTO rpfp.user_profile (
                    DB_USER_ID,
                    LAST_NAME, 
                    FIRST_NAME,
                    E_MAIL,
                    REGION,
                    PSGC_CODE
        )
            VALUES (
                    name_user,
                    surname,
                    firstname,
                    email,
                    region_id,
                    location_code
        );
    ELSE
         UPDATE rpfp.user_profile prof
            SET prof.REGION = region_id,
                prof.PSGC_CODE = location_code,
                prof.IS_ACTIVE = TRUE,
                prof.INITIAL_PASS_COLUMN = TRUE
          WHERE prof.DB_USER_ID = name_user
        ;
    END IF;
END$$

CREATE DEFINER=root@localhost PROCEDURE itdmu_update_first_login(
    IN db_user VARCHAR(50) CHARSET utf8 COLLATE utf8_unicode_ci
    )   MODIFIES SQL DATA
BEGIN
    DECLARE name_user VARCHAR(50);
    DECLARE db_user_name VARCHAR(50);

    CALL rpfp.lib_extract_user_name(db_user, name_user, db_user_name);

     UPDATE rpfp.user_profile prof
        SET prof.INITIAL_PASS_COLUMN = 0
      WHERE prof.DB_USER_ID = name_user
    ;
END$$

CREATE DEFINER=root@localhost PROCEDURE itdmu_change_user_password (
    IN db_user VARCHAR(50) CHARSET utf8 COLLATE utf8_unicode_ci,
    IN new_passwd VARCHAR(50) CHARSET utf8 COLLATE utf8_unicode_ci
    )   CONTAINS SQL
BEGIN
    DECLARE name_user VARCHAR(50);
    DECLARE db_user_name VARCHAR(50);

    CALL rpfp.lib_extract_user_name(db_user, name_user, db_user_name);

    SET @sql_stmt1 := CONCAT("SET PASSWORD FOR ", db_user_name, " = PASSWORD(", QUOTE(new_passwd), ")");
    PREPARE stmt1 FROM @sql_stmt1;
    EXECUTE stmt1;
END$$

CREATE DEFINER=root@localhost PROCEDURE itdmu_deactivate_user (
    IN db_user VARCHAR(50) CHARSET utf8 COLLATE utf8_unicode_ci
    )   
BEGIN
    DECLARE name_user VARCHAR(50);
    DECLARE db_user_name VARCHAR(50);

    CALL rpfp.lib_extract_user_name(db_user, name_user, db_user_name);

    SET @sql_stmt1 := CONCAT("REVOKE ALL PRIVILEGES, GRANT OPTION FROM ", db_user_name);
    PREPARE stmt1 FROM @sql_stmt1;
    EXECUTE stmt1;

     UPDATE rpfp.user_profile prof
        SET prof.IS_ACTIVE = FALSE
      WHERE prof.DB_USER_ID = name_user
    ;
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
    IN new_passwd VARCHAR(50) CHARSET utf8 COLLATE utf8_unicode_ci
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
         SELECT "NOT FIRST LOGIN" MESSAGE;
    END IF;
END$$

CREATE DEFINER=root@localhost PROCEDURE login_change_own_password(
    IN old_passwd VARCHAR(50) CHARSET utf8 COLLATE utf8_unicode_ci,
    IN new_passwd VARCHAR(50) CHARSET utf8 COLLATE utf8_unicode_ci
    )   CONTAINS SQL
proc_exit_point :
BEGIN
    IF old_passwd = new_passwd THEN
         SELECT "INVALID NEW PASSWORD" MESSAGE;
        LEAVE proc_exit_point;
    END IF;

    IF EXISTS (
         SELECT rpfp.login_check_own_password(old_passwd)
    ) THEN
           CALL rpfp.itdmu_login_change_user_password(USER(), new_passwd);
    ELSE
         SELECT "INVALID PASSWORD!" MESSAGE;
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
       FROM rpfp.user_profile prof
      WHERE prof.DB_USER_ID = USER()
        AND prof.IS_ACTIVE = TRUE
    ;
    RETURN ret_val;
END$$
/** END OF LOGIN PROCS */


/** PROFILE PROCS */
CREATE DEFINER=root@localhost FUNCTION profile_get_role(
    db_user VARCHAR(50) CHARSET utf8 COLLATE utf8_unicode_ci
    )   RETURNS INT(11)
        CONTAINS SQL
BEGIN
    DECLARE ret_val INT(11);
    DECLARE role_word VARCHAR(50);
    DECLARE name_user VARCHAR(50);
    DECLARE db_user_name VARCHAR(50);

    CALL rpfp.lib_extract_user_name(db_user, name_user, db_user_name);

     SELECT rm.ROLE INTO role_word
       FROM mysql.ROLES_MAPPING rm
      WHERE QUOTE(rm.USER) = QUOTE(name_user)
        AND rm.ROLE IN ('itdmu', 'pmed', 'regional_data_manager', 'focal_person', 'encoder')
      LIMIT 1
    ;

    IF role_word IS NOT NULL THEN
        RETURN rpfp.profile_num_role(role_word);
    END IF;

    RETURN 0;
END$$

CREATE DEFINER=root@localhost FUNCTION profile_get_scope(
    db_user VARCHAR(50) CHARSET utf8 COLLATE utf8_unicode_ci
    )   RETURNS INT(11)
        CONTAINS SQL
BEGIN
    DECLARE ret_val INT(11);
    DECLARE scope_word VARCHAR(50);
    DECLARE name_user VARCHAR(50);
    DECLARE db_user_name VARCHAR(50);

    CALL rpfp.lib_extract_user_name(db_user, name_user, db_user_name);

     SELECT rm.ROLE INTO scope_word
       FROM mysql.ROLES_MAPPING rm
      WHERE QUOTE(rm.USER) = QUOTE(name_user)
        AND rm.ROLE IN ('national', 'regional', 'provincial', 'citiwide')
      LIMIT 1
    ;

    IF scope_word IS NOT NULL THEN
        RETURN rpfp.profile_num_scope(scope_word);
    END IF;

    RETURN 0;
END$$

CREATE DEFINER=root@localhost PROCEDURE profile_set_role(
    IN db_user VARCHAR(50) CHARSET utf8 COLLATE utf8_unicode_ci,
    IN role_num INT(11)
    )   CONTAINS SQL
proc_exit_point :
BEGIN
    DECLARE default_role VARCHAR(50);
    DECLARE name_user VARCHAR(50);
    DECLARE db_user_name VARCHAR(50);

    CALL rpfp.lib_extract_user_name(db_user, name_user, db_user_name);

    IF role_num IS NULL THEN
        SELECT "ROLE IS EMPTY" MESSAGE;
        LEAVE proc_exit_point;
    END IF;

    IF role_num NOT IN (60, 70, 80, 90, 100) THEN
        SELECT concat("INVALID ROLE: ", role_num) MESSAGE;
        LEAVE proc_exit_point;
    END IF;

    SET default_role := rpfp.profile_select_role(role_num);

    SET @sql_stmt4 := CONCAT("GRANT ", default_role, " TO ", db_user_name);
    PREPARE stmt4 FROM @sql_stmt4;
    EXECUTE stmt4;

    SET @sql_stmt5 := CONCAT("SET DEFAULT ROLE ", default_role, " FOR ", db_user_name);
    PREPARE stmt5 FROM @sql_stmt5;
    EXECUTE stmt5;
END$$

CREATE DEFINER=root@localhost PROCEDURE profile_set_scope(
    IN db_user VARCHAR(50) CHARSET utf8 COLLATE utf8_unicode_ci,
    IN scope_reg_prov_or_muni INT(11)
    )   CONTAINS SQL
proc_exit_point :    
BEGIN
    DECLARE scope_role VARCHAR(50) DEFAULT NULL;
    DECLARE name_user VARCHAR(50);
    DECLARE db_user_name VARCHAR(50);

    CALL rpfp.lib_extract_user_name(db_user, name_user, db_user_name);

    IF scope_reg_prov_or_muni IS NULL THEN
        SELECT "SCOPE IS EMPTY" MESSAGE;
        LEAVE proc_exit_point;
    END IF;

    IF scope_reg_prov_or_muni NOT IN (10, 20, 30, 40, 50) THEN
        SELECT "INVALID SCOPE" MESSAGE;
        LEAVE proc_exit_point;
    END IF;

    SET scope_role := rpfp.profile_select_scope( scope_reg_prov_or_muni );
    SET @sql_stmt6 := CONCAT("GRANT ", scope_role, " TO ", db_user_name);
    PREPARE stmt6 FROM @sql_stmt6;
    EXECUTE stmt6;
END$$

CREATE DEFINER=root@localhost FUNCTION profile_check_role(
    db_user VARCHAR(50) CHARSET utf8 COLLATE utf8_unicode_ci,
    role_num INT(11)
    )   RETURNS INT(1)
        READS SQL DATA
BEGIN
    DECLARE ret_val INT(1) DEFAULT NULL;
    DECLARE name_user VARCHAR(50);
    DECLARE db_user_name VARCHAR(50);

    CALL rpfp.lib_extract_user_name(db_user, name_user, db_user_name);

    SELECT TRUE INTO ret_val
      FROM mysql.ROLES_MAPPING rm
     WHERE rm.ROLE = rpfp.profile_select_role(role_num)
       AND rm.USER = name_user
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
    IN db_user VARCHAR(50) CHARSET utf8 COLLATE utf8_unicode_ci
    )   READS SQL DATA
BEGIN
    DECLARE name_user VARCHAR(50);
    DECLARE db_user_name VARCHAR(50);

    CALL rpfp.lib_extract_user_name(db_user, name_user, db_user_name);

     SELECT prof.PROFILE_ID id,
            prof.DB_USER_ID username,
            prof.E_MAIL email,
            prof.LAST_NAME surname,
            prof.FIRST_NAME firstname,
            prof.REGION region_id,
            reg.LOCATION_DESCRIPTION region_name,
            prof.PSGC_CODE location_code,
            loc.LOCATION_DESCRIPTION location_name,
            rpfp.profile_get_role(db_user_name) my_role,
            rpfp.profile_get_scope(db_user_name) my_scope
       FROM rpfp.user_profile prof
  LEFT JOIN rpfp.psgc_locations loc
         ON prof.PSGC_CODE = loc.PSGC_CODE
        AND prof.REGION = loc.REGION_CODE
  LEFT JOIN rpfp.psgc_locations reg
         ON reg.PSGC_CODE = (prof.REGION * POWER(10, 7))
      WHERE prof.DB_USER_ID = name_user
    ;
END$$

CREATE DEFINER=root@localhost PROCEDURE profile_save_profile(
    IN db_user VARCHAR(50) CHARSET utf8 COLLATE utf8_unicode_ci,
    IN surname VARCHAR(50) CHARSET utf8 COLLATE utf8_unicode_ci,
    IN firstname VARCHAR(50) CHARSET utf8 COLLATE utf8_unicode_ci,
    IN email VARCHAR(100) CHARSET utf8 COLLATE utf8_unicode_ci,
    IN region_id INT UNSIGNED,
    IN location_code INT UNSIGNED
)
BEGIN
    DECLARE name_user VARCHAR(50);
    DECLARE db_user_name VARCHAR(50);

    CALL rpfp.lib_extract_user_name(db_user, name_user, db_user_name);

     UPDATE rpfp.user_profile prof
        SET prof.E_MAIL = IFNULL(email, prof.E_MAIL),
            prof.LAST_NAME = IFNULL(surname, prof.LAST_NAME),
            prof.FIRST_NAME = IFNULL(firstname, prof.FIRST_NAME),
            prof.PSGC_CODE = IFNULL(location_code, prof.PSGC_CODE),
            prof.REGION = IFNULL(region_id, prof.REGION)
    ;
END$$


CREATE DEFINER=root@localhost PROCEDURE profile_save_own_profile(
    IN surname VARCHAR(50) CHARSET utf8 COLLATE utf8_unicode_ci,
    IN firstname VARCHAR(50) CHARSET utf8 COLLATE utf8_unicode_ci,
    IN email VARCHAR(100) CHARSET utf8 COLLATE utf8_unicode_ci
)
BEGIN
    CALL rpfp.profile_save_profile(
        USER(),
        surname,
        firstname,
        email,
        NULL,
        NULL
    );
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
    IN region_id INT(11) UNSIGNED
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
    IN province_id INT(11) UNSIGNED
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
    IN municipality_id INT(11) UNSIGNED
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

CREATE DEFINER=root@localhost PROCEDURE lib_extract_user_name(
    IN db_user VARCHAR(50) CHARSET utf8 COLLATE utf8_unicode_ci,
    OUT name_user VARCHAR(50) CHARSET utf8 COLLATE utf8_unicode_ci,
    OUT db_user_name VARCHAR(50) CHARSET utf8 COLLATE utf8_unicode_ci
    )   CONTAINS SQL
BEGIN
    DECLARE name_len INT(11);
    SET db_user_name := TRIM("\'" FROM db_user);
    SET name_user := db_user;
    SET name_len := LOCATE('@', name_user, 1);

    IF name_len > 0 THEN
        SET name_user := SUBSTRING(db_user_name, 1, name_len - 1);
    ELSE
        SET db_user_name := CONCAT(name_user, '@localhost');
    END IF;
END$$

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
    scope_word VARCHAR(25) CHARSET utf8 COLLATE utf8_unicode_ci
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
                SET default_num := 0;
        END CASE;
    END IF;
    RETURN default_num;
END$$

CREATE DEFINER=root@localhost FUNCTION profile_num_role(
    role_word VARCHAR(25) CHARSET utf8 COLLATE utf8_unicode_ci
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
/** END OF LIBRARIES */

/** GET PENDING CLASS LIST */
CREATE DEFINER=root@localhost PROCEDURE user_get_pending_class_list ()  READS SQL DATA
BEGIN
    IF NOT EXISTS (
         SELECT rc.RPFP_CLASS_ID
           FROM rpfp.RPFP_CLASS rc
      LEFT JOIN rpfp.PENDING_COUPLES pc
             ON (pc.RPFP_CLASS_ID = rc.RPFP_CLASS_ID)
          WHERE (pc.IS_ACTIVE = 2)
    
       ORDER BY rc.DATE_CONDUCTED DESC
    ) THEN
        BEGIN
             SELECT NULL AS RPFPCLASS,
                    NULL AS TYPECLASS,
                    NULL AS OTHERS_SPECIFY,
                    NULL AS CITY,
                    NULL AS BARANGAY,
                    NULL AS CLASS_NO,
                    NULL AS DATE_CONDUCT,
                    NULL AS PROFILEID
            ;
        END;
    ELSE
        BEGIN
             SELECT rc.RPFP_CLASS_ID AS RPFPCLASS,
                    rc.TYPE_CLASS_ID AS TYPECLASS,
                    rc.OTHERS_SPECIFY AS OTHERS_SPECIFY,
                    rc.CITY_ID AS CITY,
                    rc.BARANGAY_ID AS BARANGAY,
                    rc.CLASS_NUMBER AS CLASS_NO,
                    rc.DATE_CONDUCTED AS DATE_CONDUCT
               FROM rpfp.rpfp_class rc
                    LEFT JOIN rpfp.pending_couples pc
                    ON (pc.RPFP_CLASS_ID = rc.RPFP_CLASS_ID)
           ORDER BY rc.DATE_CONDUCTED DESC
            ;
        END;
    END IF;
END$$
/** END GET PENDING CLASS LIST */

/** GET APPROVED CLASS LIST */
CREATE DEFINER=root@localhost PROCEDURE user_get_approved_class_list ()  READS SQL DATA
BEGIN
    IF NOT EXISTS (
         SELECT rc.RPFP_CLASS_ID
           FROM rpfp.RPFP_CLASS rc
      LEFT JOIN rpfp.PENDING_COUPLES pc
             ON (pc.RPFP_CLASS_ID = rc.RPFP_CLASS_ID)
          WHERE (pc.IS_ACTIVE = 0)
    
       ORDER BY rc.DATE_CONDUCTED DESC
    ) THEN
        BEGIN
             SELECT NULL AS RPFPCLASS,
                    NULL AS TYPECLASS,
                    NULL AS OTHERS_SPECIFY,
                    NULL AS CITY,
                    NULL AS BARANGAY,
                    NULL AS CLASS_NO,
                    NULL AS DATE_CONDUCT,
                    NULL AS PROFILEID
            ;
        END;
    ELSE
        BEGIN
             SELECT pc.RPFP_CLASS_ID AS RPFPCLASS,
                    rc.TYPE_CLASS_ID AS TYPECLASS,
                    rc.OTHERS_SPECIFY AS OTHERS_SPECIFY,
                    rc.CITY_ID AS CITY,
                    rc.BARANGAY_ID AS BARANGAY,
                    rc.CLASS_NUMBER AS CLASS_NO,
                    rc.DATE_CONDUCTED AS DATE_CONDUCT
               FROM rpfp.rpfp_class rc
                    LEFT JOIN rpfp.pending_couples pc
                    ON (pc.RPFP_CLASS_ID = rc.RPFP_CLASS_ID)
           ORDER BY rc.DATE_CONDUCTED DESC
            ;
        END;
    END IF;
END$$
/** END GET APPROVED CLASS LIST */

/** GET PENDING COUPLES LIST */
CREATE DEFINER=root@localhost PROCEDURE user_get_pending_couples_list ()  READS SQL DATA
BEGIN
    IF NOT EXISTS (
         SELECT pc.RPFP_CLASS_ID
           FROM rpfp.PENDING_COUPLES pc
      LEFT JOIN rpfp.RPFP_CLASS rc
             ON (rc.RPFP_CLASS_ID = pc.RPFP_CLASS_ID
    )
       ORDER BY pc.COUPLES_ID ASC
    ) THEN
        BEGIN
             SELECT NULL AS COUPLESID,
                    NULL AS RPFPCLASS,
                    NULL AS TYPEPARTICIPANT,
                    NULL AS ISACTIVE,
                    NULL AS DATE_ENCODE
            ;
        END;
    ELSE
        BEGIN
             SELECT rc.RPFP_CLASS_ID AS RPFPCLASS,
                    pc.COUPLES_ID AS COUPLESID,
                    pc.TYPE_PARTICIPANT AS TYPEPARTICIPANT,
                    pc.IS_ACTIVE AS ISACTIVE,
                    pc.DATE_ENCODED AS DATE_ENCODE
               FROM rpfp.pending_couples pc
                    LEFT JOIN rpfp.rpfp_class rc
                    ON (rc.RPFP_CLASS_ID = pc.RPFP_CLASS_ID)
           ORDER BY pc.COUPLES_ID ASC
            ;
        END;
    END IF;
END$$
/** END PENDING COUPLES LIST */

/** GET APPROVED COUPLES LIST */
CREATE DEFINER=root@localhost PROCEDURE user_get_approved_couples_list ()  READS SQL DATA
BEGIN
    IF NOT EXISTS (
         SELECT ac.RPFP_CLASS_ID
           FROM rpfp.APPROVED_COUPLES ac
      LEFT JOIN rpfp.RPFP_CLASS rc
             ON (rc.RPFP_CLASS_ID = ac.RPFP_CLASS_ID
    )
       ORDER BY ac.COUPLES_ID ASC
    ) THEN
        BEGIN
             SELECT NULL AS COUPLESID,
                    NULL AS RPFPCLASS,
                    NULL AS TYPEPARTICIPANT,
                    NULL AS ISACTIVE,
                    NULL AS DATE_ENCODE
            ;
        END;
    ELSE
        BEGIN
             SELECT rc.RPFP_CLASS_ID AS RPFPCLASS,
                    ac.COUPLES_ID AS COUPLESID,
                    ac.TYPE_PARTICIPANT AS TYPEPARTICIPANT,
                    ac.IS_ACTIVE AS ISACTIVE,
                    ac.DATE_ENCODED AS DATE_ENCODE
               FROM rpfp.approved_couples ac
                    LEFT JOIN rpfp.rpfp_class rc
                    ON (rc.RPFP_CLASS_ID = ac.RPFP_CLASS_ID)
           ORDER BY ac.COUPLES_ID ASC
            ;
        END;
    END IF;
END$$
/** END APPROVED COUPLES LIST */

/** GET PENDING COUPLES DETAILS */
CREATE DEFINER=root@localhost PROCEDURE user_get_pending_couples_details ()  READS SQL DATA
BEGIN
    IF NOT EXISTS (
         SELECT pc.COUPLES_ID
           FROM rpfp.PENDING_COUPLES pc
      LEFT JOIN rpfp.INDIVIDUAL ic
             ON (ic.COUPLES_ID = pc.COUPLES_ID
    )
       ORDER BY ic.INDV_ID ASC
    ) THEN
        BEGIN
             SELECT NULL AS INDVID,
                    NULL AS COUPLESID,
                    NULL AS LASTNAME,
                    NULL AS FIRSTNAME,
                    NULL AS MIDDLE,
                    NULL AS EXT,
                    NULL AS AGE,
                    NULL AS SEX,
                    NULL AS BIRTHDATE,
                    NULL AS CIVIL,
                    NULL AS ADDRESS_NO_ST,
                    NULL AS ADDRESS_BRGY,
                    NULL AS ADDRESS_CITY,
                    NULL AS HOUSEHOLD_NO,
                    NULL AS EDUC_BCKGRND,
                    NULL AS ETNIC,
                    NULL AS NUMBER_CHILD,
                    NULL AS IS_ATTENDEE
            ;
        END;
    ELSE
        BEGIN
             SELECT pc.COUPLES_ID AS COUPLESID,
                    ic.INDV_ID AS INDVID,
                    ic.LNAME AS LASTNAME,
                    ic.FNAME AS FIRSTNAME,
                    ic.MNAME AS MIDDLE,
                    ic.EXT_NAME AS EXT,
                    ic.AGE AS AGE,
                    ic.SEX AS SEX,
                    ic.BDATE AS BIRTHDATE,
                    ic.CIVIL_ID AS CIVIL,
                    ic.ADDRESS_NO_ST AS ADDRESS_NO_ST,
                    ic.ADDRESS_BRGY AS ADDRESS_BRGY,
                    ic.ADDRESS_CITY AS ADDRESS_CITY,
                    ic.HH_ID_NO AS HOUSEHOLD_NO,
                    ic.EDUC_BCKGRND_ID AS EDUC_BCKGRND,
                    ic.ETNICITY AS ETNIC,
                    ic.NO_CHILDREN AS NUMBER_CHILD,
                    ic.ATTENDEE AS IS_ATTENDEE
               FROM rpfp.individual ic
                    LEFT JOIN rpfp.pending_couples pc
                    ON (ic.RPFP_CLASS_ID = pc.RPFP_CLASS_ID)
           ORDER BY ic.INDV_ID ASC
            ;
        END;
    END IF;
END$$
/** END PENDING COUPLES DETAILS */

/** GET PENDING COUPLES FP DETAILS */
CREATE DEFINER=root@localhost PROCEDURE user_get_pending_couples_fp_details (IN couplesid INT UNSIGNED)  READS SQL DATA
BEGIN
    IF NOT EXISTS (
         SELECT pc.COUPLES_ID
           FROM rpfp.PENDING_COUPLES pc
      LEFT JOIN rpfp.FP_DETAILS fd
             ON (fd.COUPLES_ID = pc.COUPLES_ID)

   WHERE (IFNULL(fd.COUPLES_ID, 0) = couplesid)
    
       ORDER BY fd.FP_DETAILS_ID ASC
    ) THEN
        BEGIN
             SELECT NULL AS FPDETAILSID,
                    NULL AS COUPLESID,
                    NULL AS MFP_USED,
                    NULL AS MFP_SHIFT,
                    NULL AS TFP_TYPE,
                    NULL AS TFP_STATUS,
                    NULL AS REASON_USE,
                    NULL AS FPSTATUS,
                    NULL AS CURRENT_FP
            ;
        END;
    ELSE
        BEGIN
             SELECT pc.COUPLES_ID AS COUPLESID,
                    fd.FP_DETAILS_ID AS FPDETAILSID,
                    fd.MFP_METHOD_USED_ID AS MFP_USED,
                    fd.MFP_INTENTION_SHIFT_ID AS MFP_SHIFT,
                    fd.TFP_TYPE_ID AS TFP_STATUS,
                    fd.REASON_INTENDING_USE_ID AS REASON_USE,
                    fd.FP_STATUS AS FPSTATUS,
                    fd.CURRENT_FP_METHOD_ID AS CURRENT_FP
               FROM rpfp.fp_details fd
                    LEFT JOIN rpfp.pending_couples pc
                    ON (fd.RPFP_CLASS_ID = pc.RPFP_CLASS_ID)
           ORDER BY fd.FP_DETAILS_ID ASC
            ;
        END;
    END IF;
END$$
/** END PENDING COUPLES FP DETAILS */

/** GET PENDING COUPLES FP SERVICE */
CREATE DEFINER=root@localhost PROCEDURE user_get_pending_couples_fp_service (IN couplesid INT UNSIGNED)  READS SQL DATA
BEGIN
    IF NOT EXISTS (
         SELECT pc.COUPLES_ID
           FROM rpfp.PENDING_COUPLES pc
      LEFT JOIN rpfp.FP_SERVICE fs
             ON (fs.COUPLES_ID = pc.COUPLES_ID)

   WHERE (IFNULL(fs.COUPLES_ID, 0) = couplesid)
    
       ORDER BY fs.FP_SERVICE_ID ASC
    ) THEN
        BEGIN
             SELECT NULL AS FPSERVICEID,
                    NULL AS COUPLESID,
                    NULL AS DATEVISIT,
                    NULL AS FP_SERVED,
                    NULL AS PROVIDER_TYPE,
                    NULL AS IS_COUNSELLING,
                    NULL AS OTHER_CONCERN,
                    NULL AS IS_PROVIDED_SERVICE,
                    NULL AS DATESERVED,
                    NULL AS CLIENT_ADVISE,
                    NULL AS REFERRALNAME,
                    NULL AS PROVIDERNAME,
                    NULL AS DATE_ENCODE
            ;
        END;
    ELSE
        BEGIN
             SELECT pc.COUPLES_ID AS COUPLESID,
                    fd.FP_SERVICE_ID AS FPSERVICEID,
                    fd.DATE_VISIT AS DATEVISIT,
                    fd.FP_SERVED_ID AS FP_SERVED,
                    fd.PROVIDER_TYPE_ID AS PROVIDER_TYPE,
                    fd.IS_COUNSELLING AS IS_COUNSELLING,
                    fd.OTHER_CONCERN AS OTHER_CONCERN,
                    fd.IS_PROVIDED_SERVICE AS IS_PROVIDED_SERVICE,
                    fs.DATE_SERVED AS DATESERVED,
                    fs.CLIENT_ADVISE AS CLIENT_ADVISE,
                    fs.REFERRAL_NAME AS REFERRALNAME,
                    fs.PROVIDER_NAME AS PROVIDERNAME,
                    fs.DATE_ENCODED AS DATE_ENCODE
               FROM rpfp.fp_service fs
                    LEFT JOIN rpfp.pending_couples pc
                    ON (fs.RPFP_CLASS_ID = pc.RPFP_CLASS_ID)
           ORDER BY fs.FP_SERVICE_ID ASC
            ;
        END;
    END IF;
END$$
/** END PENDING COUPLES FP SERVICE */

/** GET APPROVED COUPLES DETAILS */
CREATE DEFINER=root@localhost PROCEDURE user_get_approved_couples_details ()  READS SQL DATA
BEGIN
    IF NOT EXISTS (
         SELECT ac.COUPLES_ID
           FROM rpfp.APPROVED_COUPLES ac
      LEFT JOIN rpfp.INDIVIDUAL ic
             ON (ic.COUPLES_ID = ac.COUPLES_ID
    )
       ORDER BY ic.INDV_ID ASC
    ) THEN
        BEGIN
             SELECT NULL AS INDVID,
                    NULL AS COUPLESID,
                    NULL AS LASTNAME,
                    NULL AS FIRSTNAME,
                    NULL AS MIDDLE,
                    NULL AS EXT,
                    NULL AS AGE,
                    NULL AS SEX,
                    NULL AS BIRTHDATE,
                    NULL AS CIVIL,
                    NULL AS ADDRESS_NO_ST,
                    NULL AS ADDRESS_BRGY,
                    NULL AS ADDRESS_CITY,
                    NULL AS HOUSEHOLD_NO,
                    NULL AS EDUC_BCKGRND,
                    NULL AS ETNIC,
                    NULL AS NUMBER_CHILD,
                    NULL AS IS_ATTENDEE
            ;
        END;
    ELSE
        BEGIN
             SELECT ac.COUPLES_ID AS COUPLESID,
                    ic.INDV_ID AS INDVID,
                    ic.LNAME AS LASTNAME,
                    ic.FNAME AS FIRSTNAME,
                    ic.MNAME AS MIDDLE,
                    ic.EXT_NAME AS EXT,
                    ic.AGE AS AGE,
                    ic.SEX AS SEX,
                    ic.BDATE AS BIRTHDATE,
                    ic.CIVIL_ID AS CIVIL,
                    ic.ADDRESS_NO_ST AS ADDRESS_NO_ST,
                    ic.ADDRESS_BRGY AS ADDRESS_BRGY,
                    ic.ADDRESS_CITY AS ADDRESS_CITY,
                    ic.HH_ID_NO AS HOUSEHOLD_NO,
                    ic.EDUC_BCKGRND_ID AS EDUC_BCKGRND,
                    ic.ETNICITY AS ETNIC,
                    ic.NO_CHILDREN AS NUMBER_CHILD,
                    ic.ATTENDEE AS IS_ATTENDEE
               FROM rpfp.individual ic
                    LEFT JOIN rpfp.approved_couples ac
                    ON (ic.RPFP_CLASS_ID = ac.RPFP_CLASS_ID)
           ORDER BY ic.INDV_ID ASC
            ;
        END;
    END IF;
END$$
/** END APPROVED COUPLES DETAILS */

/** GET APPROVED COUPLES FP DETAILS */
CREATE DEFINER=root@localhost PROCEDURE user_get_approved_couples_fp_details (IN couplesid INT UNSIGNED)  READS SQL DATA
BEGIN
    IF NOT EXISTS (
         SELECT ac.COUPLES_ID
           FROM rpfp.APPROVED_COUPLES ac
      LEFT JOIN rpfp.FP_DETAILS fd
             ON (fd.COUPLES_ID = ac.COUPLES_ID)

   WHERE (IFNULL(fd.COUPLES_ID, 0) = couplesid)
    
       ORDER BY fd.FP_DETAILS_ID ASC
    ) THEN
        BEGIN
             SELECT NULL AS FPDETAILSID,
                    NULL AS COUPLESID,
                    NULL AS MFP_USED,
                    NULL AS MFP_SHIFT,
                    NULL AS TFP_TYPE,
                    NULL AS TFP_STATUS,
                    NULL AS REASON_USE,
                    NULL AS FPSTATUS,
                    NULL AS CURRENT_FP
            ;
        END;
    ELSE
        BEGIN
             SELECT ac.COUPLES_ID AS COUPLESID,
                    fd.FP_DETAILS_ID AS FPDETAILSID,
                    fd.MFP_METHOD_USED_ID AS MFP_USED,
                    fd.MFP_INTENTION_SHIFT_ID AS MFP_SHIFT,
                    fd.TFP_TYPE_ID AS TFP_STATUS,
                    fd.REASON_INTENDING_USE_ID AS REASON_USE,
                    fd.FP_STATUS AS FPSTATUS,
                    fd.CURRENT_FP_METHOD_ID AS CURRENT_FP
               FROM rpfp.fp_details fd
                    LEFT JOIN rpfp.approved_couples ac
                    ON (fd.RPFP_CLASS_ID = ac.RPFP_CLASS_ID)
           ORDER BY fd.FP_DETAILS_ID ASC
            ;
        END;
    END IF;
END$$
/** END APPROVED COUPLES FP DETAILS */

/** GET APPROVED COUPLES FP SERVICE */
CREATE DEFINER=root@localhost PROCEDURE user_get_approved_couples_fp_service (IN couplesid INT UNSIGNED)  READS SQL DATA
BEGIN
    IF NOT EXISTS (
         SELECT ac.COUPLES_ID
           FROM rpfp.APPROVED_COUPLES ac
      LEFT JOIN rpfp.FP_SERVICE fs
             ON (fs.COUPLES_ID = ac.COUPLES_ID)

   WHERE (IFNULL(fs.COUPLES_ID, 0) = couplesid)
    
       ORDER BY fs.FP_SERVICE_ID ASC
    ) THEN
        BEGIN
             SELECT NULL AS FPSERVICEID,
                    NULL AS COUPLESID,
                    NULL AS DATEVISIT,
                    NULL AS FP_SERVED,
                    NULL AS PROVIDER_TYPE,
                    NULL AS IS_COUNSELLING,
                    NULL AS OTHER_CONCERN,
                    NULL AS IS_PROVIDED_SERVICE,
                    NULL AS DATESERVED,
                    NULL AS CLIENT_ADVISE,
                    NULL AS REFERRALNAME,
                    NULL AS PROVIDERNAME,
                    NULL AS DATE_ENCODE
            ;
        END;
    ELSE
        BEGIN
             SELECT ac.COUPLES_ID AS COUPLESID,
                    fd.FP_SERVICE_ID AS FPSERVICEID,
                    fd.DATE_VISIT AS DATEVISIT,
                    fd.FP_SERVED_ID AS FP_SERVED,
                    fd.PROVIDER_TYPE_ID AS PROVIDER_TYPE,
                    fd.IS_COUNSELLING AS IS_COUNSELLING,
                    fd.OTHER_CONCERN AS OTHER_CONCERN,
                    fd.IS_PROVIDED_SERVICE AS IS_PROVIDED_SERVICE,
                    fs.DATE_SERVED AS DATESERVED,
                    fs.CLIENT_ADVISE AS CLIENT_ADVISE,
                    fs.REFERRAL_NAME AS REFERRALNAME,
                    fs.PROVIDER_NAME AS PROVIDERNAME,
                    fs.DATE_ENCODED AS DATE_ENCODE
               FROM rpfp.fp_service fs
                    LEFT JOIN rpfp.approved_couples ac
                    ON (fs.RPFP_CLASS_ID = ac.RPFP_CLASS_ID)
           ORDER BY fs.FP_SERVICE_ID ASC
            ;
        END;
    END IF;
END$$
/** END APPROVED COUPLES FP DETAILS */

/**  SAVE CLASS DETAILS  */
CREATE DEFINER=root@localhost FUNCTION get_class_id (classid INT UNSIGNED)  RETURNS INT UNSIGNED READS SQL DATA
BEGIN
    DECLARE find_class_id INT UNSIGNED;

     SELECT rc.RPFP_CLASS_ID INTO find_class_id
       FROM rpfp.RPFP_CLASS rc
      WHERE rc.RPFP_CLASS_ID = classid
    ;
    RETURN find_class_id;
END$$

CREATE DEFINER=root@localhost PROCEDURE user_save_class (
    IN classid INT UNSIGNED,
    IN TYPE_CLASS_ID INT,
    IN OTHERS_SPECIFY VARCHAR(100),
    IN CITY_ID INT,
    IN BARANGAY_ID INT,
    IN CLASS_NUMBER VARCHAR(50),
    IN DATE_CONDUCTED DATE,
    IN PROFILE_ID INT
    )  MODIFIES SQL DATA
proc_exit_point :
BEGIN
    DECLARE rpfp_class_no INT UNSIGNED;

    IF classid IS NULL THEN
        SELECT "CANNOT SAVE RECORD WITH GIVEN PARAMETERS" AS MESSAGE;
        LEAVE proc_exit_point;
    END IF;

    SET rpfp_class_no = rpfp.get_class_id(classid);
    IF rpfp_class_no IS NULL THEN
        SELECT "UNABLE TO GET RECORD WITH GIVEN PARAMETERS" AS MESSAGE;
        LEAVE proc_exit_point;
    END IF;

     UPDATE rpfp.rpfp_class rc
        SET rc.TYPE_CLASS_ID = IF(IFNULL(TYPE_CLASS_ID, '') = '', rc.TYPE_CLASS_ID, TYPE_CLASS_ID),
            rc.OTHERS_SPECIFY = IF(IFNULL(OTHERS_SPECIFY, '') = '', rc.OTHERS_SPECIFY, OTHERS_SPECIFY),
            rc.CITY_ID = IF(IFNULL(CITY_ID, '') = '', rc.CITY_ID, CITY_ID),
            rc.BARANGAY_ID = IF(IFNULL(BARANGAY_ID, '') = '', rc.BARANGAY_ID, BARANGAY_ID),
            rc.CLASS_NUMBER = IF(IFNULL(CLASS_NUMBER, '') = '', rc.CLASS_NUMBER, CLASS_NUMBER),
            rc.DATE_CONDUCTED = IF(IFNULL(DATE_CONDUCTED, '') = '', rc.DATE_CONDUCTED, DATE_CONDUCTED),
            rc.PROFILE_ID = IF(IFNULL(PROFILE_ID, '') = '', rc.PROFILE_ID, PROFILE_ID)            
      WHERE rc.RPFP_CLASS_ID = rpfp_class_no
    ;

    SELECT "SUCCESS!" AS MESSAGE;
END$$
/** END SAVE CLASS DETAILS */

/**  SAVE COUPLES DETAILS  */
CREATE DEFINER=root@localhost FUNCTION get_save_couples_id (couplesid INT UNSIGNED)  RETURNS INT UNSIGNED READS SQL DATA
BEGIN
    DECLARE find_couples_id INT UNSIGNED;

     SELECT pc.COUPLES_ID INTO find_couples_id
       FROM rpfp.PENDING_COUPLES pc
      WHERE pc.COUPLES_ID = couplesid
    ;
    RETURN find_couples_id;
END$$

CREATE DEFINER=root@localhost PROCEDURE user_save_couples (
    IN couples_id INT UNSIGNED,
    IN RPFP_CLASS_ID INT,
    IN TYPE_PARTICIPANT INT,
    IN IS_ACTIVE INT,
    IN DATE_ENCODED DATE
    )  MODIFIES SQL DATA
proc_exit_point :
BEGIN
    DECLARE couples_id INT UNSIGNED;

    IF rpfp_class_id IS NULL THEN
        SELECT "CANNOT SAVE RECORD WITH GIVEN PARAMETERS" AS MESSAGE;
        LEAVE proc_exit_point;
    END IF;

    SET couples_id = rpfp.user_get_pending_couples_list(couples_id);
    IF couples_id IS NULL THEN
        SELECT "UNABLE TO GET RECORD WITH GIVEN PARAMETERS" AS MESSAGE;
        LEAVE proc_exit_point;
    END IF;

     UPDATE rpfp.pending_couples pc
        SET pc.RPFP_CLASS_ID = IF(IFNULL(RPFP_CLASS, '') = '', pc.RPFP_CLASS_ID, RPFP_CLASS),
            pc.TYPE_PARTICIPANT = IF(IFNULL(TYPEPARTICIPANT, '') = '', pc.TYPE_PARTICIPANT, TYPEPARTICIPANT),
            pc.IS_ACTIVE = 2,
            pc.DATE_ENCODED = IF(IFNULL(DATE_ENCODE, '') = '', pc.DATE_ENCODED, DATE_ENCODE)
      WHERE pc.COUPLES_ID = couples_id
    ;

     UPDATE rpfp.individual ic
        SET ic.LNAME = IF(IFNULL(LASTNAME, '') = '', ic.LNAME, LASTNAME),
            ic.FNAME = IF(IFNULL(FIRSTNAME, '') = '', ic.FNAME, FIRSTNAME),
            ic.MNAME = IF(IFNULL(MIDDLE, '') = '', ic.MNAME, MIDDLE),                            
            ic.EXT_NAME = IF(IFNULL(EXT_NAME, '') = '', ic.EXT_NAME, EXT_NAME),
            ic.AGE = IF(IFNULL(AGE, '') = '', ic.AGE, AGE),
            ic.SEX = IF(IFNULL(SEX, '') = '', ic.SEX, SEX),
            ic.BDATE = IF(IFNULL(BIRTHDATE, '') = '', ic.BDATE, BIRTHDATE),
            ic.CIVIL_ID = IF(IFNULL(CIVIL, '') = '', ic.CIVIL_ID, CIVIL),
            ic.ADDRESS_NO_ST = IF(IFNULL(ADDRESS_NO_ST, '') = '', ic.ADDRESS_NO_ST, ADDRESS_NO_ST),
            ic.ADDRESS_BRGY = IF(IFNULL(ADDRESS_BRGY, '') = '', ic.ADDRESS_BRGY, ADDRESS_BRGY),
            ic.ADDRESS_CITY = IF(IFNULL(ADDRESS_CITY, '') = '', ic.ADDRESS_CITY, ADDRESS_CITY),
            ic.HH_ID_NO = IF(IFNULL(HOUSEHOLD_NO, '') = '', ic.HH_ID_NO, HOUSEHOLD_NO),
            ic.EDUC_BCKGRND_ID = IF(IFNULL(EDUC_BCKGRND, '') = '', ic.EDUC_BCKGRND_ID, EDUC_BCKGRND),
            ic.ETNICITY = IF(IFNULL(ETNICITY, '') = '', ic.ETNICITY, ETNICITY),
            ic.NO_CHILDREN = IF(IFNULL(NUMBER_CHILD, '') = '', ic.NO_CHILDREN, NUMBER_CHILD),
            ic.IS_ATTENDEE = IF(IFNULL(ATTENDEE, '') = '', ic.IS_ATTENDEE, ATTENDEE)
      WHERE ic.COUPLES_ID = couples_id
    ;

     UPDATE rpfp.fp_details fd
        SET fd.MFP_METHOD_USED_ID = IF(IFNULL(MFP_USED, '') = '', fd.MFP_METHOD_USED_ID, MFP_USED),
            fd.MFP_INTENTION_SHIFT_ID = IF(IFNULL(MFP_SHIFT, '') = '', fd.MFP_INTENTION_SHIFT_ID, MFP_SHIFT),
            fd.TFP_TYPE_ID = IF(IFNULL(TFP_TYPE, '') = '', fd.TFP_TYPE_ID, TFP_TYPE),                            
            fd.TFP_STATUS_ID = IF(IFNULL(TFP_STATUS, '') = '', fd.TFP_STATUS_ID, TFP_STATUS),
            fd.REASON_INTENDING_USE_ID = IF(IFNULL(REASON_USE, '') = '', fd.REASON_INTENDING_USE_ID, REASON_USE),
            fd.FP_STATUS = IF(IFNULL(FPSTATUS, '') = '', fd.FP_STATUS, FPSTATUS)
      WHERE fd.COUPLES_ID = couples_id
    ;

    SELECT "SUCCESS!" AS MESSAGE;
END$$

/** END SAVE COUPLES DETAILS */

/**  SAVE FP SERVICE  */
CREATE DEFINER=root@localhost FUNCTION get_save_fp_service_couples_id (couplesid INT UNSIGNED)  RETURNS INT UNSIGNED READS SQL DATA
BEGIN
    DECLARE find_couples_id INT UNSIGNED;

     SELECT pc.COUPLES_ID INTO find_couples_id
       FROM rpfp.PENDING_COUPLES pc
      WHERE pc.COUPLES_ID = couplesid
    ;
    RETURN find_couples_id;
END$$

CREATE DEFINER=root@localhost PROCEDURE user_save_fp_service (
    IN fp_service_id INT UNSIGNED,
    IN COUPLES_ID INT,
    IN DATE_VISIT DATE,
    IN FP_SERVED_ID INT,
    IN PROVIDER_TYPE_ID INT,
    IN IS_COUNSELLING INT,
    IN OTHER_CONCERN VARCHAR(100),
    IN IS_PROVIDED_SERVICE INT,
    IN DATE_SERVED DATE,
    IN CLIENT_ADVISE VARCHAR(100),
    IN REFERRAL_NAME VARCHAR(50),
    IN PROVIDER_NAME VARCHAR(50),
    IN DATE_ENCODED DATE
    )  MODIFIES SQL DATA
proc_exit_point :
BEGIN
    DECLARE fp_service_id INT UNSIGNED;

    SET couples_id = rpfp.user_get_pending_couples_list(couples_id);
    IF couples_id IS NULL THEN
        SELECT "UNABLE TO GET RECORD WITH GIVEN PARAMETERS" AS MESSAGE;
        LEAVE proc_exit_point;
    END IF;

     UPDATE rpfp.fp_service fs
        SET fs.DATE_VISIT = IF(IFNULL(DATEVISIT, '') = '', fs.DATE_VISIT, DATEVISIT),
            fs.FP_SERVED_ID = IF(IFNULL(FP_SERVED, '') = '', fs.FP_SERVED_ID, FP_SERVED),
            fs.PROVIDER_TYPE_ID = IF(IFNULL(PROVIDER_TYPE, '') = '', fs.PROVIDER_TYPE_ID, PROVIDER_TYPE),
            fs.IS_COUNSELLING = IF(IFNULL(IS_COUNSELING, '') = '', fs.IS_COUNSELLING, IS_COUNSELING),
            fs.OTHER_CONCERN = IF(IFNULL(OTHERS, '') = '', fs.OTHER_CONCERN, OTHERS),
            fs.IS_PROVIDED_SERVICE = IF(IFNULL(IS_PROVIDED_SERVICE, '') = '', fs.IS_PROVIDED_SERVICE, IS_PROVIDED_SERVICE),
            fs.DATE_SERVED = IF(IFNULL(DATESERVED, '') = '', fs.DATE_SERVED, DATESERVED),
            fs.CLIENT_ADVISE = IF(IFNULL(CLIENT_ADVISE, '') = '', fs.CLIENT_ADVISE, CLIENT_ADVISE),
            fs.REFERRAL_NAME = IF(IFNULL(REFERRALNAME, '') = '', fs.REFERRAL_NAME, REFERRALNAME),
            fs.PROVIDER_NAME = IF(IFNULL(PROVIDERNAME, '') = '', fs.PROVIDER_NAME, PROVIDERNAME),
            fs.DATE_ENCODED = IF(IFNULL(DATE_ENCODE, '') = '', fs.DATE_ENCODED, DATE_ENCODE)
      WHERE fs.COUPLES_ID = couples_id
    ;

     UPDATE rpfp.fp_details fd
        SET fd.CURRENT_FP_METHOD_ID = IF(IFNULL(CURRENT_FP, '') = '', fd.CURRENT_FP_METHOD_ID, CURRENT_FP)
      WHERE fd.COUPLES_ID = couples_id
    ;

    SELECT "SUCCESS!" AS MESSAGE;
END$$
/** END SAVE FP SERVICE */


/**  APPROVE COUPLES DETAILS  */
CREATE DEFINER=root@localhost FUNCTION get_approve_couples_id (couplesid INT UNSIGNED)  RETURNS INT UNSIGNED READS SQL DATA
BEGIN
    DECLARE find_couples_id INT UNSIGNED;

     SELECT ac.COUPLES_ID INTO find_couples_id
       FROM rpfp.APPROVED_COUPLES ac
      WHERE ac.COUPLES_ID = couplesid
    ;
    RETURN find_couples_id;
END$$

CREATE DEFINER=root@localhost PROCEDURE rdm_approve_couples (
    IN couples_id INT UNSIGNED,
    IN RPFP_CLASS_ID INT,
    IN TYPE_PARTICIPANT INT,
    IN IS_ACTIVE INT,
    IN DATE_ENCODED DATE
    )  MODIFIES SQL DATA
proc_exit_point :
BEGIN
    DECLARE couples_id INT UNSIGNED;

    IF rpfp_class_id IS NULL THEN
        SELECT "CANNOT SAVE RECORD WITH GIVEN PARAMETERS" AS MESSAGE;
        LEAVE proc_exit_point;
    END IF;

    SET couples_id = rpfp.user_get_approved_couples_list(couples_id);
    IF couples_id IS NULL THEN
        SELECT "UNABLE TO GET RECORD WITH GIVEN PARAMETERS" AS MESSAGE;
        LEAVE proc_exit_point;
    END IF;

     UPDATE rpfp.approved_couples ac
        SET ac.RPFP_CLASS_ID = IF(IFNULL(RPFP_CLASS, '') = '', ac.RPFP_CLASS_ID, RPFP_CLASS),
            ac.TYPE_PARTICIPANT = IF(IFNULL(TYPEPARTICIPANT, '') = '', ac.TYPE_PARTICIPANT, TYPEPARTICIPANT),
            ac.IS_ACTIVE = 2,
            ac.DATE_ENCODED = IF(IFNULL(DATE_ENCODE, '') = '', ac.DATE_ENCODED, DATE_ENCODE)
      WHERE ac.COUPLES_ID = couples_id
    ;

    SELECT "SUCCESS!" AS MESSAGE;
END$$
/** END APPROVE COUPLES DETAILS */

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

-- --------------------------------------------------------

--
-- Table structure for table psgc_locations
--

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

--
-- Table structure for table type_class
--

CREATE TABLE type_class (
          TYPE_CLASS_ID INT(11) UNSIGNED NOT NULL AUTO_INCREMENT,
        TYPE_CLASS_DESC VARCHAR(50) NOT NULL,
            PRIMARY KEY (TYPE_CLASS_ID)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `type_class`
--

INSERT INTO `type_class` (`TYPE_CLASS_ID`, `TYPE_CLASS_DESC`) VALUES
(1, '4Ps'),
(2, 'Faith-Based Organization'),
(3, 'PMC'),
(4, 'Usapan'),
(5, 'House-to-House'),
(6, 'Profile only'),
(7, 'Others');

-- --------------------------------------------------------

--
-- Table structure for table rpfp_class
--

CREATE TABLE rpfp_class (
          RPFP_CLASS_ID INT(11) UNSIGNED NOT NULL AUTO_INCREMENT,
          TYPE_CLASS_ID INT(11) NOT NULL,
         OTHERS_SPECIFY VARCHAR(100),
                CITY_ID INT(11) NOT NULL,
            BARANGAY_ID INT(11) NOT NULL,
           CLASS_NUMBER VARCHAR(50) NOT NULL,
         DATE_CONDUCTED DATE NOT NULL,
             PROFILE_ID INT(11) NOT NULL,
            PRIMARY KEY (RPFP_CLASS_ID)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `rpfp_class`
--

INSERT INTO `rpfp_class` (`RPFP_CLASS_ID`, `TYPE_CLASS_ID`,`OTHERS_SPECIFY`,`CITY_ID`,`BARANGAY_ID`,`CLASS_NUMBER`,`DATE_CONDUCTED`,`PROFILE_ID`) VALUES
(1, 1, NULL, 083747, 083747125, 'RPFP-TAC-2019-00001','02-11-2019', 1);

-- --------------------------------------------------------

--
-- Table structure for table pending_couples
--

CREATE TABLE pending_couples (
             COUPLES_ID INT(11) UNSIGNED NOT NULL AUTO_INCREMENT,
          RPFP_CLASS_ID INT(11) NOT NULL,
           DATE_ENCODED DATE,
              IS_ACTIVE INT(1),
            PRIMARY KEY (COUPLES_ID)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `pending_couples`
--

INSERT INTO `pending_couples` (`COUPLES_ID`,`RPFP_CLASS_ID`,`DATE_ENCODED`,`IS_ACTIVE`) VALUES
(1, 1, '03-01-2019', 2),
(2, 1, '03-01-2019', 2),
(3, 1, '03-01-2019', 2),
(4, 1, '03-01-2019', 2),
(5, 1, '03-01-2019', 2),
(6, 1, '03-01-2019', 2),
(7, 1, '03-01-2019', 2),
(8, 1, '03-01-2019', 2),
(9, 1, '03-01-2019', 2),
(10, 1, '03-01-2019', 2),
(11, 1, '03-01-2019', 2),
(12, 1, '03-01-2019', 2),
(13, 1, '03-01-2019', 2),
(14, 1, '03-01-2019', 2);

-- --------------------------------------------------------

--
-- Table structure for table approved_couples
--

CREATE TABLE approved_couples (
             COUPLES_ID INT(11) UNSIGNED NOT NULL AUTO_INCREMENT,
          RPFP_CLASS_ID INT(11) NOT NULL,
       TYPE_PARTICIPANT VARCHAR(100),
           DATE_ENCODED DATE,
              IS_ACTIVE INT(1),
            PRIMARY KEY (COUPLES_ID)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table civil_status
--

CREATE TABLE civil_status (
               CIVIL_ID INT(11) UNSIGNED NOT NULL AUTO_INCREMENT,
             CIVIL_DESC VARCHAR(100),
            PRIMARY KEY (CIVIL_ID)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `civil_status`
--

INSERT INTO `civil_status` (`CIVIL_ID`, `CIVIL_DESC`) VALUES
(1, 'Married'),
(2, 'Single'),
(3, 'Widow/Widower'),
(4, 'Separated'),
(5, 'Live-in');

-- --------------------------------------------------------

--
-- Table structure for table educ_bckgrnd
--

CREATE TABLE educ_bckgrnd (
        EDUC_BCKGRND_ID INT(11) UNSIGNED NOT NULL AUTO_INCREMENT,
      EDUC_BCKGRND_DESC VARCHAR(100),
            PRIMARY KEY (EDUC_BCKGRND_ID)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `educ_bckgrnd`
--

INSERT INTO `educ_bckgrnd` (`EDUC_BCKGRND_ID`, `EDUC_BCKGRND_DESC`) VALUES
(1, 'No Education'),
(2, 'Elementary Level'),
(3, 'Elementary Graduate'),
(4, 'High School Level'),
(5, 'High School Graduate'),
(6, 'Vocational'),
(7, 'College Level'),
(8, 'College Graduate'),
(9, 'Post Graduate');

-- --------------------------------------------------------

--
-- Table structure for table modern_fp_method
--

CREATE TABLE modern_fp_method (
           MODERN_FP_ID INT(11) UNSIGNED NOT NULL AUTO_INCREMENT,
         MODERN_FP_DESC VARCHAR(100),
            PRIMARY KEY (MODERN_FP_ID)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `modern_fp_method`
--

INSERT INTO `modern_fp_method` (`MODERN_FP_ID`, `MODERN_FP_DESC`) VALUES
(1, 'Condom'),
(2, 'IUD'),
(3, 'Pills'),
(4, 'Injectable'),
(5, 'Vasectomy'),
(6, 'Tubal Ligation'),
(7, 'Implant'),
(8, 'CMM/Billings'),
(9, 'BBT'),
(10, 'Sympto-Thermal'),
(11, 'SDM'),
(12, 'LAM');

-- --------------------------------------------------------

--
-- Table structure for table traditional_fp_method
--

CREATE TABLE traditional_fp_method (
      TRADITIONAL_FP_ID INT(11) UNSIGNED NOT NULL AUTO_INCREMENT,
    TRADITIONAL_FP_DESC VARCHAR(100),
            PRIMARY KEY (TRADITIONAL_FP_ID)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `traditional_fp_method`
--

INSERT INTO `traditional_fp_method` (`TRADITIONAL_FP_ID`, `TRADITIONAL_FP_DESC`) VALUES
(1, 'Withdrawal'),
(2, 'Rhythm'),
(3, 'Calendar'),
(4, 'Abstinence'),
(5, 'Herbal'),
(6, 'No Method');

-- --------------------------------------------------------

--
-- Table structure for table traditional_fp_status
--

CREATE TABLE traditional_fp_status (
          TFP_STATUS_ID INT(1) UNSIGNED NOT NULL AUTO_INCREMENT,
        TFP_STATUS_DESC VARCHAR(100),
            PRIMARY KEY (TFP_STATUS_ID)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table traditional_fp_status
--

INSERT INTO traditional_fp_status 
    (TFP_STATUS_ID,
    TFP_STATUS_DESC)
VALUES
    (1, 'Expressing Intention to Use Modern FP Method'),
    (2, 'Undecided'),
	(3, 'Currently Pregnant'),
	(4, 'No Intention to Use')
;

-- --------------------------------------------------------

--
-- Table structure for table reason_intending_use
--

CREATE TABLE reason_intending_use (
  REASON_INTENDING_USE_ID INT(11) UNSIGNED NOT NULL AUTO_INCREMENT,
REASON_INTENDING_USE_DESC VARCHAR(100),
              PRIMARY KEY (REASON_INTENDING_USE_ID)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `reason_intending_use`
--

INSERT INTO `reason_intending_use` (`REASON_INTENDING_USE_ID`, `REASON_INTENDING_USE_DESC`) VALUES
(1, 'Spacing'),
(2, 'Limiting'),
(3, 'Achieving');

-- --------------------------------------------------------

--
-- Table structure for table provider_type
--

CREATE TABLE provider_type (
         PROVIDER_TYPE_ID INT(11) UNSIGNED NOT NULL AUTO_INCREMENT,
       PROVIDER_TYPE_DESC VARCHAR(100),
              PRIMARY KEY (PROVIDER_TYPE_ID)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table individual
--

CREATE TABLE individual (
                  INDV_ID INT(11) UNSIGNED NOT NULL AUTO_INCREMENT,
               COUPLES_ID INT(11) NOT NULL,
                    LNAME VARCHAR(50),
                    FNAME VARCHAR(50),
                    MNAME VARCHAR(10),
                 EXT_NAME VARCHAR(10),
                      AGE INT(11),
                      SEX INT(1),
                    BDATE DATE,
                 CIVIL_ID INT(1),
            ADDRESS_NO_ST VARCHAR(50),
             ADDRESS_BRGY VARCHAR(50),
             ADDRESS_CITY VARCHAR(50),
                 HH_ID_NO INT(50),
          EDUC_BCKGRND_ID INT(11),
                 ETNICITY VARCHAR(50),
              NO_CHILDREN INT(11),
                 ATTENDEE INT(1),
              PRIMARY KEY (INDV_ID)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `individual`
--

INSERT INTO `individual` (`INDV_ID`, `COUPLES_ID`, `LNAME`, `FNAME`, `MNAME`, `EXT_NAME`, `AGE`, `SEX`, `BDATE`, `CIVIL_ID`, `ADDRESS_NO_ST`, `ADDRESS_BRGY`, `ADDRESS_CITY`, `HH_ID_NO`, `EDUC_BCKGRND_ID`, `ETNICITY`, `NO_CHILDREN`, `ATTENDEE`) VALUES
(1, 1, 'Simon', 'Anna Margarette', '', NULL, 35, 2, '1984-02-07', 1, NULL, 'Apitong', 'Tacloban', NULL, 8, NULL, 3, 1),
(2, 1, 'Simon', 'Carl Edward', '', NULL, 38, 1, '1981-09-09', 1, NULL, 'Apitong', 'Tacloban', NULL, 8, NULL, 3, 1),
(3, 2, 'Alcantara', 'Gusion', '', NULL, 30, 1, '1989-01-07', 1, NULL, 'Apitong', 'Tacloban', NULL, 7, NULL, 4, 1),
(4, 2, 'Alcantara', 'Gueneverre', '', NULL, 30, 2, '1989-12-09', 1, NULL, 'Apitong', 'Tacloban', NULL, 6, NULL, 4, 1),
(5, 3, 'Moral', 'Claude Vincent', '', NULL, 28, 1, '1991-05-07', 1, NULL, 'Apitong', 'Tacloban', NULL, 5, NULL, 2, 1),
(6, 3, 'Moral', 'Esmeralda', '', NULL, 30, 2, '1989-06-09', 1, NULL, 'Apitong', 'Tacloban', NULL, 6, NULL, 2, 1),
(7, 4, 'Broquez', 'Lancelot', '', NULL, 34, 1, '1985-04-07', 1, NULL, 'Apitong', 'Tacloban', NULL, 6, NULL, 3, 1),
(8, 4, 'Broquez', 'Odette', '', NULL, 31, 2, '1988-10-09', 1, NULL, 'Apitong', 'Tacloban', NULL, 6, NULL, 3, 1),
(9, 5, 'Cervantes', 'Alucard', '', NULL, 27, 1, '1992-11-07', 1, NULL, 'Apitong', 'Tacloban', NULL, 7, NULL, 2, 1),
(10, 5, 'Cervantes', 'Layla', '', NULL, 25, 2, '1994-12-09', 1, NULL, 'Apitong', 'Tacloban', NULL, 8, NULL, 2, 1),
(11, 6, 'Montana', 'Hanabi', '', NULL, 28, 2, '1991-07-07', 1, NULL, 'Apitong', 'Tacloban', NULL, 9, NULL, 2, 1),
(12, 6, 'Montana', 'Leo', '', NULL, 28, 1, '1991-08-09', 1, NULL, 'Apitong', 'Tacloban', NULL, 8, NULL, 2, 1),
(13, 7, 'Rodriguez', 'Ruby', '', NULL, 49, 2, '1970-03-07', 1, NULL, 'Apitong', 'Tacloban', NULL, 7, NULL, 5, 1),
(14, 7, 'Rodriguez', 'Clint', '', NULL, 47, 1, '1972-03-09', 1, NULL, 'Apitong', 'Tacloban', NULL, 7, NULL, 5, 1),
(15, 8, 'Fargas', 'Bruno', '', NULL, 50, 1, '1970-03-07', 1, NULL, 'Apitong', 'Tacloban', NULL, 4, NULL, 4, 1),
(16, 8, 'Fargas', 'Lesley', '', NULL, 50, 2, '1972-03-09', 1, NULL, 'Apitong', 'Tacloban', NULL, 5, NULL, 4, 0),
(17, 9, 'Gonzaga', 'Alice', '', NULL, 25, 2, '1994-06-07', 5, NULL, 'Apitong', 'Tacloban', NULL, 5, NULL, 3, 1),
(18, 9, 'Vargas', 'Alexander', '', NULL, NULL, NULL, NULL, NULL, NULL, 'Apitong', 'Tacloban', NULL, NULL, NULL, 3, 0),
(19, 10, 'Halili', 'Miya', '', NULL, 30, 2, '1989-04-07', 5, NULL, 'Apitong', 'Tacloban', NULL, 5, NULL, 3, 1),
(20, 10, 'Reyes', 'Miguel', '', NULL, NULL, NULL, NULL, 5, NULL, 'Apitong', 'Tacloban', NULL, NULL, NULL, 3, 0);

-- --------------------------------------------------------

--
-- Table structure for table fp_details
--

CREATE TABLE fp_details (
          FP_DETAILS_ID INT(11) UNSIGNED NOT NULL AUTO_INCREMENT,
             COUPLES_ID INT(11) NOT NULL,
     MFP_METHOD_USED_ID INT(11),
 MFP_INTENTION_SHIFT_ID INT(11),
            TFP_TYPE_ID INT(11),
          TFP_STATUS_ID INT(11),
REASON_INTENDING_USE_ID INT(11),
            PRIMARY KEY (FP_DETAILS_ID)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `fp_details`
--

INSERT INTO `fp_details` (`FP_DETAILS_ID`, `COUPLES_ID`, `MFP_METHOD_USED_ID`, `MFP_INTENTION_SHIFT_ID`, `TFP_TYPE_ID`, `TFP_STATUS_ID`, `REASON_INTENDING_USE_ID`) VALUES
(1, 1, 3, NULL, NULL, NULL, NULL),
(2, 2, NULL, NULL, 1, 4, NULL),
(3, 3, 3, 2, NULL, NULL, NULL),
(4, 4, NULL, NULL, 6, 4, NULL),
(5, 5, NULL, NULL, 6, 3, NULL),
(6, 6, 4, NULL, 6, 1, 1),
(7, 7, NULL, NULL, 1, 2, NULL),
(8, 8, 12, NULL, NULL, NULL, NULL),
(9, 9, 5, NULL, 2, 1, 2),
(10, 10, 5, NULL, 6, 1, 2),
(11, 11, NULL, NULL, 6, 4, NULL),
(12, 12, NULL, NULL, 6, 4, NULL),
(13, 13, NULL, NULL, 6, 4, NULL),
(14, 14, NULL, NULL, 6, 4, NULL),
(15, 15, NULL, NULL, 6, 4, NULL);

-- --------------------------------------------------------

--
-- Table structure for table fp_service
--

CREATE TABLE fp_service (
          FP_SERVICE_ID INT(11) UNSIGNED NOT NULL AUTO_INCREMENT,
             COUPLES_ID INT(11) NOT NULL,
             DATE_VISIT DATE,
           FP_SERVED_ID INT(11),
       PROVIDER_TYPE_ID INT(11),
          IS_COUNSELING INT(1),
          OTHER_CONCERN VARCHAR(100),
    IS_PROVIDED_SERVICE INT(1),
            DATE_SERVED DATE,
          CLIENT_ADVISE VARCHAR(100),
          REFERRAL_NAME VARCHAR(100),
          PROVIDER_NAME VARCHAR(100),
           DATE_ENCODED DATE,
            PRIMARY KEY (FP_SERVICE_ID)
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
             60 = partners
             50 = encoder

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
       GRANT rpfp_login to partners;
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
GRANT EXECUTE ON PROCEDURE rpfp.profile_save_own_profile TO 'rpfp_login';

GRANT EXECUTE ON PROCEDURE rpfp.lib_list_regions TO 'rpfp_login';
GRANT EXECUTE ON PROCEDURE rpfp.lib_list_provinces TO 'rpfp_login';
GRANT EXECUTE ON PROCEDURE rpfp.lib_list_cities TO 'rpfp_login';
GRANT EXECUTE ON PROCEDURE rpfp.lib_list_brgy TO 'rpfp_login';


GRANT EXECUTE ON PROCEDURE rpfp.itdmu_create_rpfp_user TO 'itdmu';
GRANT EXECUTE ON PROCEDURE rpfp.itdmu_update_first_login TO 'itdmu';
GRANT EXECUTE ON PROCEDURE rpfp.itdmu_change_user_password TO 'itdmu';
GRANT EXECUTE ON PROCEDURE rpfp.profile_get_profile TO 'itdmu';
GRANT EXECUTE ON PROCEDURE rpfp.profile_set_role TO 'itdmu';
GRANT EXECUTE ON PROCEDURE rpfp.profile_set_scope TO 'itdmu';
GRANT EXECUTE ON PROCEDURE rpfp.profile_save_profile TO 'itdmu';


/** END OF RPFP.SQL */
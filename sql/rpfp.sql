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

    CALL rpfp.lib_extract_user_name( db_user, name_user, db_user_name );

    SET @sql_stmt1 := CONCAT( "CREATE USER IF NOT EXISTS ", db_user_name );
    PREPARE stmt1 FROM @sql_stmt1;
    EXECUTE stmt1;

    SET @sql_stmt2 := CONCAT( "GRANT rpfp_login TO ", db_user_name );
    PREPARE stmt2 FROM @sql_stmt2;
    EXECUTE stmt2;

    CALL rpfp.itdmu_change_user_password( name_user, passwd );

    CALL rpfp.profile_set_role( name_user, my_role );

    CALL rpfp.profile_set_scope( name_user, scope_reg_prov_or_muni );

     SELECT prof.PROFILE_ID INTO record_id_no
       FROM rpfp.user_profile prof
      WHERE prof.DB_USER_ID = name_user
    ;
    IF record_id_no IS NULL THEN
        INSERT INTO rpfp.user_profile(
                    DB_USER_ID,
                    LAST_NAME, 
                    FIRST_NAME,
                    E_MAIL,
                    REGION_CODE,
                    PSGC_CODE
        )
            VALUES(
                    name_user,
                    surname,
                    firstname,
                    email,
                    region_id,
                    location_code
        );
    ELSE
         UPDATE rpfp.user_profile prof
            SET prof.REGION_CODE = region_id,
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

    CALL rpfp.lib_extract_user_name( db_user, name_user, db_user_name );

     UPDATE rpfp.user_profile prof
        SET prof.INITIAL_PASS_COLUMN = 0
      WHERE prof.DB_USER_ID = name_user
    ;
END$$

CREATE DEFINER=root@localhost PROCEDURE itdmu_change_user_password(
    IN db_user VARCHAR(50) CHARSET utf8 COLLATE utf8_unicode_ci,
    IN new_passwd VARCHAR(50) CHARSET utf8 COLLATE utf8_unicode_ci
    )   CONTAINS SQL
BEGIN
    DECLARE name_user VARCHAR(50);
    DECLARE db_user_name VARCHAR(50);

    CALL rpfp.lib_extract_user_name( db_user, name_user, db_user_name );

    SET @sql_stmt1 := CONCAT( "SET PASSWORD FOR ", db_user_name, " = PASSWORD(", QUOTE(new_passwd ), ")" );
    PREPARE stmt1 FROM @sql_stmt1;
    EXECUTE stmt1;
END$$

CREATE DEFINER=root@localhost PROCEDURE itdmu_deactivate_user(
    IN db_user VARCHAR(50) CHARSET utf8 COLLATE utf8_unicode_ci
    )   CONTAINS SQL
BEGIN
    DECLARE name_user VARCHAR(50);
    DECLARE db_user_name VARCHAR(50);

    CALL rpfp.lib_extract_user_name( db_user, name_user, db_user_name );

    IF NOT (name_user = 'root') THEN
        BEGIN
            DECLARE CONTINUE HANDLER FOR SQLSTATE 'HY000' BEGIN END;

            SET @sql_stmt1 := CONCAT( "REVOKE rpfp_login FROM ", db_user_name );
            SET @sql_stmt2 := CONCAT( "REVOKE pmed FROM ", db_user_name );
            SET @sql_stmt3 := CONCAT( "REVOKE regional_data_manager FROM ", db_user_name );
            SET @sql_stmt4 := CONCAT( "REVOKE itdmu FROM ", db_user_name );
            SET @sql_stmt5 := CONCAT( "REVOKE focal_person FROM ", db_user_name );
            SET @sql_stmt6 := CONCAT( "REVOKE partners FROM ", db_user_name );
            SET @sql_stmt7 := CONCAT( "REVOKE encoder FROM ", db_user_name );
            SET @sql_stmt8 := CONCAT( "REVOKE citiwide FROM ", db_user_name );
            SET @sql_stmt9 := CONCAT( "REVOKE provincial FROM ", db_user_name );
            SET @sql_stmt10 := CONCAT( "REVOKE regional FROM ", db_user_name );
            SET @sql_stmt11 := CONCAT( "REVOKE national FROM ", db_user_name );
            SET @sql_stmt12 := CONCAT( "REVOKE no_scope FROM ", db_user_name );

            PREPARE stmt1 FROM @sql_stmt1;
            PREPARE stmt2 FROM @sql_stmt2;
            PREPARE stmt3 FROM @sql_stmt3;
            PREPARE stmt4 FROM @sql_stmt4;
            PREPARE stmt5 FROM @sql_stmt5;
            PREPARE stmt6 FROM @sql_stmt6;
            PREPARE stmt7 FROM @sql_stmt7;
            PREPARE stmt8 FROM @sql_stmt8;
            PREPARE stmt9 FROM @sql_stmt9;
            PREPARE stmt10 FROM @sql_stmt10;
            PREPARE stmt11 FROM @sql_stmt11;
            PREPARE stmt12 FROM @sql_stmt12;

            EXECUTE stmt1;
            EXECUTE stmt2;
            EXECUTE stmt3;
            EXECUTE stmt4;
            EXECUTE stmt5;
            EXECUTE stmt6;
            EXECUTE stmt7;
            EXECUTE stmt8;
            EXECUTE stmt9;
            EXECUTE stmt10;
            EXECUTE stmt11;
            EXECUTE stmt12;
        END;
    END IF;

     UPDATE rpfp.user_profile prof
        SET prof.IS_ACTIVE = FALSE
      WHERE prof.DB_USER_ID = name_user
    ;
END$$
/** END OF USER MANAGEMENT */

/** LOGIN PROCS */
CREATE DEFINER=root@localhost FUNCTION login_check_own_password(
    old_passwd VARCHAR(50) CHARSET utf8 COLLATE utf8_unicode_ci
    )   RETURNS INT(1)
        READS SQL DATA
BEGIN
    DECLARE ret_val INT(1) DEFAULT NULL;
     SELECT TRUE INTO ret_val
       FROM mysql.user u
      WHERE CONCAT( u.user, "@localhost" ) = USER()
        AND u.PASSWORD = PASSWORD( IFNULL( old_passwd, '' ))
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
      WHERE CONCAT( prof.DB_USER_ID, "@localhost" ) = USER()
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
            CALL rpfp.itdmu_change_user_password( USER(), new_passwd );
            CALL rpfp.itdmu_update_first_login( USER() );
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
         SELECT "INVALID NEW PASSWORD" AS MESSAGE;
        LEAVE proc_exit_point;
    END IF;

    IF EXISTS (
         SELECT rpfp.login_check_own_password( old_passwd )
    ) THEN
           CALL rpfp.itdmu_login_change_user_password( USER(), new_passwd );
    ELSE
         SELECT "INVALID PASSWORD!" AS MESSAGE;
    END IF;
END$$

CREATE DEFINER=root@localhost PROCEDURE login_update_first_login()
        CONTAINS SQL
BEGIN
    CALL rpfp.itdmu_update_first_login( USER() );
END$$

CREATE DEFINER=root@localhost FUNCTION login_check_if_active()
        RETURNS INT(1)
        READS SQL DATA
BEGIN
    DECLARE ret_val INT(1) DEFAULT NULL;
     SELECT TRUE INTO ret_val
       FROM rpfp.user_profile prof
      WHERE CONCAT( prof.DB_USER_ID, "@localhost" ) = USER()
        AND prof.IS_ACTIVE = TRUE
    ;
    RETURN ret_val;
END$$
/** END OF LOGIN PROCS */

/** PROFILE PROCS */
CREATE DEFINER=root@localhost FUNCTION profile_get_role(
    db_user VARCHAR(50) CHARSET utf8 COLLATE utf8_unicode_ci
    )   RETURNS INT
        CONTAINS SQL
BEGIN
    DECLARE ret_val INT;
    DECLARE role_word VARCHAR(50);
    DECLARE name_user VARCHAR(50);
    DECLARE db_user_name VARCHAR(50);

    CALL rpfp.lib_extract_user_name( db_user, name_user, db_user_name );

     SELECT rm.ROLE INTO role_word
       FROM mysql.ROLES_MAPPING rm
      WHERE QUOTE( rm.USER ) = QUOTE ( name_user )
        AND rm.ROLE IN ( 'itdmu', 'pmed', 'regional_data_manager', 'focal_person', 'partners', 'encoder' )
      LIMIT 1
    ;

    IF role_word IS NOT NULL THEN
        RETURN rpfp.lib_num_role( role_word );
    END IF;

    RETURN 0;
END$$

CREATE DEFINER=root@localhost FUNCTION profile_get_scope(
    db_user VARCHAR(50) CHARSET utf8 COLLATE utf8_unicode_ci
    )   RETURNS INT
        CONTAINS SQL
BEGIN
    DECLARE ret_val INT;
    DECLARE scope_word VARCHAR(50);
    DECLARE name_user VARCHAR(50);
    DECLARE db_user_name VARCHAR(50);

    CALL rpfp.lib_extract_user_name( db_user, name_user, db_user_name );

     SELECT rm.ROLE INTO scope_word
       FROM mysql.ROLES_MAPPING rm
      WHERE QUOTE( rm.USER ) = QUOTE( name_user )
        AND rm.ROLE IN ('national', 'regional', 'provincial', 'citiwide')
      LIMIT 1
    ;

    IF scope_word IS NOT NULL THEN
        RETURN rpfp.lib_num_scope( scope_word );
    END IF;

    RETURN 0;
END$$

CREATE DEFINER=root@localhost PROCEDURE profile_set_role(
    IN db_user VARCHAR(50) CHARSET utf8 COLLATE utf8_unicode_ci,
    IN role_num INT
    )   CONTAINS SQL
proc_exit_point :
BEGIN
    DECLARE default_role VARCHAR(50);
    DECLARE name_user VARCHAR(50);
    DECLARE db_user_name VARCHAR(50);

    CALL rpfp.lib_extract_user_name( db_user, name_user, db_user_name );

    IF role_num IS NULL THEN
        SELECT "ROLE IS EMPTY" AS MESSAGE;
        LEAVE proc_exit_point;
    END IF;

    IF role_num NOT IN (50, 60, 70, 80, 90, 100) THEN
        SELECT CONCAT( "INVALID ROLE: ", role_num ) AS MESSAGE;
        LEAVE proc_exit_point;
    END IF;

    IF NOT (name_user = 'root') THEN
        BEGIN
            DECLARE CONTINUE HANDLER FOR SQLSTATE 'HY000' BEGIN END;

            SET @sql_stmt01 := CONCAT( "REVOKE itdmu FROM ", db_user_name );
            SET @sql_stmt02 := CONCAT( "REVOKE pmed FROM ", db_user_name );
            SET @sql_stmt03 := CONCAT( "REVOKE regional_data_manager FROM ", db_user_name );
            SET @sql_stmt04 := CONCAT( "REVOKE focal_person FROM ", db_user_name );
            SET @sql_stmt05 := CONCAT( "REVOKE partners FROM ", db_user_name );
            SET @sql_stmt06 := CONCAT( "REVOKE encoder FROM ", db_user_name );

            PREPARE stmt01 FROM @sql_stmt01;
            PREPARE stmt02 FROM @sql_stmt02;
            PREPARE stmt03 FROM @sql_stmt03;
            PREPARE stmt04 FROM @sql_stmt04;
            PREPARE stmt05 FROM @sql_stmt05;
            PREPARE stmt06 FROM @sql_stmt06;

            EXECUTE stmt01;
            EXECUTE stmt02;
            EXECUTE stmt03;
            EXECUTE stmt04;
            EXECUTE stmt05;
            EXECUTE stmt06;
        END;
    END IF;

    SET default_role := rpfp.lib_select_role( role_num );

    SET @sql_stmt4 := CONCAT( "GRANT ", default_role, " TO ", db_user_name );
    PREPARE stmt4 FROM @sql_stmt4;
    EXECUTE stmt4;

    SET @sql_stmt5 := CONCAT( "SET DEFAULT ROLE ", default_role, " FOR ", db_user_name );
    PREPARE stmt5 FROM @sql_stmt5;
    EXECUTE stmt5;
END$$

CREATE DEFINER=root@localhost PROCEDURE profile_set_scope(
    IN db_user VARCHAR(50) CHARSET utf8 COLLATE utf8_unicode_ci,
    IN scope_reg_prov_or_muni INT
    )   CONTAINS SQL
proc_exit_point :    
BEGIN
    DECLARE scope_role VARCHAR(50) DEFAULT NULL;
    DECLARE name_user VARCHAR(50);
    DECLARE db_user_name VARCHAR(50);

    CALL rpfp.lib_extract_user_name( db_user, name_user, db_user_name );

    IF scope_reg_prov_or_muni IS NULL THEN
        SELECT "SCOPE IS EMPTY" AS MESSAGE;
        LEAVE proc_exit_point;
    END IF;

    IF scope_reg_prov_or_muni NOT IN (10, 20, 30, 40, 50) THEN
        SELECT "INVALID SCOPE" AS MESSAGE;
        LEAVE proc_exit_point;
    END IF;

    IF NOT (name_user = 'root') THEN
        BEGIN
            DECLARE CONTINUE HANDLER FOR SQLSTATE 'HY000' BEGIN END;

            SET @sql_stmt8 := CONCAT( "REVOKE citiwide FROM ", db_user_name );
            SET @sql_stmt9 := CONCAT( "REVOKE provincial FROM ", db_user_name );
            SET @sql_stmt10 := CONCAT( "REVOKE regional FROM ", db_user_name );
            SET @sql_stmt11 := CONCAT( "REVOKE national FROM ", db_user_name );
            SET @sql_stmt12 := CONCAT( "REVOKE no_scope FROM ", db_user_name );

            PREPARE stmt08 FROM @sql_stmt8;
            PREPARE stmt09 FROM @sql_stmt8;
            PREPARE stmt10 FROM @sql_stmt8;
            PREPARE stmt11 FROM @sql_stmt8;
            PREPARE stmt12 FROM @sql_stmt8;

            EXECUTE stmt08;
            EXECUTE stmt09;
            EXECUTE stmt10;
            EXECUTE stmt11;
            EXECUTE stmt12;
        END;
    END IF;

    SET scope_role := rpfp.lib_select_scope( scope_reg_prov_or_muni );
    SET @sql_stmt6 := CONCAT( "GRANT ", scope_role, " TO ", db_user_name );
    PREPARE stmt6 FROM @sql_stmt6;
    EXECUTE stmt6;
END$$

CREATE DEFINER=root@localhost FUNCTION profile_check_role(
    db_user VARCHAR(50) CHARSET utf8 COLLATE utf8_unicode_ci,
    role_num INT
    )   RETURNS INT(1)
        READS SQL DATA
BEGIN
    DECLARE ret_val INT(1) DEFAULT NULL;
    DECLARE name_user VARCHAR(50);
    DECLARE db_user_name VARCHAR(50);

    CALL rpfp.lib_extract_user_name( db_user, name_user, db_user_name );

    SELECT TRUE INTO ret_val
      FROM mysql.ROLES_MAPPING rm
     WHERE rm.ROLE = rpfp.lib_select_role( role_num )
       AND rm.USER = name_user
     LIMIT 1  
    ;

    SET ret_val := IFNULL(ret_val, 0);
    RETURN ret_val;
END$$

CREATE DEFINER=root@localhost FUNCTION profile_check_if_encoder()
    RETURNS INT(1)
    READS SQL DATA
BEGIN
    DECLARE ret_val INT(1) DEFAULT NULL;

    SET ret_val := rpfp.profile_check_role( USER(), 50 );
    RETURN ret_val;
END$$

CREATE DEFINER=root@localhost FUNCTION profile_check_if_partners()
    RETURNS INT(1)
    READS SQL DATA
BEGIN
    DECLARE ret_val INT(1) DEFAULT NULL;

    SET ret_val := rpfp.profile_check_role( USER(), 60 );
    RETURN ret_val;
END$$

CREATE DEFINER=root@localhost FUNCTION profile_check_if_focal()
    RETURNS INT(1)
    READS SQL DATA
BEGIN
    DECLARE ret_val INT(1) DEFAULT NULL;

    SET ret_val := rpfp.profile_check_role( USER(), 70 );
    RETURN ret_val;
END$$

CREATE DEFINER=root@localhost FUNCTION profile_check_if_data_manager()
    RETURNS INT(1)
    READS SQL DATA
BEGIN
    DECLARE ret_val INT(1) DEFAULT NULL;

    SET ret_val := rpfp.profile_check_role( USER(), 80 );
    RETURN ret_val;
END$$

CREATE DEFINER=root@localhost FUNCTION profile_check_if_pmed()
    RETURNS INT(1)
    READS SQL DATA
BEGIN
    DECLARE ret_val INT(1) DEFAULT NULL;

    SET ret_val := rpfp.profile_check_role( USER(), 90 );
    RETURN ret_val;
END$$

CREATE DEFINER=root@localhost FUNCTION profile_check_if_itdmu()
    RETURNS INT(1)
    READS SQL DATA
BEGIN
    DECLARE ret_val INT(1) DEFAULT NULL;

    SET ret_val := rpfp.profile_check_role( USER(), 100 );
    RETURN ret_val;
END$$

CREATE DEFINER=root@localhost PROCEDURE profile_get_profile(
    IN db_user VARCHAR(50) CHARSET utf8 COLLATE utf8_unicode_ci
    )   READS SQL DATA
BEGIN
    DECLARE name_user VARCHAR(50);
    DECLARE db_user_name VARCHAR(50);

    CALL rpfp.lib_extract_user_name( db_user, name_user, db_user_name );

     SELECT prof.PROFILE_ID AS id,
            prof.DB_USER_ID AS username,
            prof.E_MAIL AS email,
            prof.LAST_NAME AS surname,
            prof.FIRST_NAME AS firstname,
            reg.REGION_CODE AS region_id,
            reg.LOCATION_DESCRIPTION AS region_name,
            prof.PSGC_CODE AS location_code,
            loc.LOCATION_DESCRIPTION AS location_name,
            rpfp.profile_get_role( db_user_name ) AS my_role,
            rpfp.profile_get_scope( db_user_name ) AS my_scope
       FROM rpfp.user_profile prof
  LEFT JOIN rpfp.lib_psgc_locations loc
         ON prof.PSGC_CODE = loc.PSGC_CODE
         OR loc.PSGC_CODE IS NULL
  LEFT JOIN rpfp.lib_psgc_locations reg
         ON reg.PSGC_CODE = (prof.PSGC_CODE DIV POWER(10, 7) * POWER(10, 7))
      WHERE prof.DB_USER_ID = name_user
        AND prof.REGION_CODE = loc.REGION_CODE
         OR reg.REGION_CODE IS NULL
      LIMIT 1
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

    CALL rpfp.lib_extract_user_name( db_user, name_user, db_user_name );

     UPDATE rpfp.user_profile prof
        SET prof.E_MAIL = IF( IFNULL( email, '' ) = '', prof.E_MAIL, email ),
            prof.LAST_NAME = IF( IFNULL( surname, '' ) = '', prof.LAST_NAME, surname ),
            prof.FIRST_NAME = IF( IFNULL( firstname, '' ) = '', prof.FIRST_NAME, firstname ),
            prof.PSGC_CODE = IF( IFNULL( location_code, '' ) = '', prof.PSGC_CODE, location_code ),
            prof.REGION_CODE = IF( IFNULL( region_id, '' ) = '', prof.REGION_CODE, region_id )
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
    CALL rpfp.profile_get_profile( USER() );
END$$

CREATE DEFINER=root@localhost FUNCTION profile_get_region(
    db_user VARCHAR(50) CHARSET utf8 COLLATE utf8_unicode_ci
    )   RETURNS INT
        READS SQL DATA
BEGIN
    DECLARE ret_val INT;
    DECLARE name_user VARCHAR(50);
    DECLARE db_user_name VARCHAR(50);

    CALL rpfp.lib_extract_user_name( db_user, name_user, db_user_name );

     SELECT prof.REGION_CODE INTO ret_val
       FROM rpfp.user_profile prof
      WHERE prof.DB_USER_ID = name_user
    ;

    return ret_val;
END$$

CREATE DEFINER=root@localhost FUNCTION profile_get_own_region()
        RETURNS INT
        READS SQL DATA
BEGIN
    RETURN profile_get_region( USER() );
END$$

CREATE DEFINER=root@localhost FUNCTION profile_get_own_role()
        RETURNS INT
        READS SQL DATA
BEGIN
    RETURN profile_get_role( USER() );
END$$

CREATE DEFINER=root@localhost FUNCTION profile_get_location(
    db_user VARCHAR(50) CHARSET utf8 COLLATE utf8_unicode_ci,
    scope_num INT
    )   RETURNS INT
        READS SQL DATA
BEGIN
    DECLARE ret_val INT;
    DECLARE multiplier INT;
    DECLARE name_user VARCHAR(50);
    DECLARE db_user_name VARCHAR(50);

    CALL rpfp.lib_extract_user_name( db_user, name_user, db_user_name );
    SET multiplier := rpfp.lib_get_multiplier( scope_num );

     SELECT prof.PSGC_CODE DIV POWER( 10, multiplier ) INTO ret_val
       FROM rpfp.user_profile prof
      WHERE prof.DB_USER_ID = name_user
    ;

    return ret_val;
END$$

CREATE DEFINER=root@localhost FUNCTION profile_check_if_allowed_location(
    username VARCHAR(50),
    location_id INT UNSIGNED
    )   RETURNS INT(1)
        READS SQL DATA
BEGIN
    DECLARE name_user VARCHAR(50);
    DECLARE db_user_name VARCHAR(50);
    DECLARE user_scope INT;
    DECLARE user_location INT;
    DECLARE multiplier INT;
    DECLARE ret_val INT(1);
    
    CALL rpfp.lib_extract_user_name( username, name_user, db_user_name );
    SET user_scope := rpfp.profile_get_scope( username );
    SET multiplier := rpfp.lib_get_multiplier( user_scope );
    SET user_location := rpfp.profile_get_location( username, user_scope );

    SET ret_val := FALSE;
    IF user_location = (location_id DIV POWER( 10, multiplier )) THEN
	    SET ret_val := TRUE;
    END IF;

    RETURN ret_val;
END$$

CREATE DEFINER=root@localhost PROCEDURE profile_get_own_pic()   READS SQL DATA
BEGIN
    CALL rpfp.profile_get_pic(USER());
END$$

CREATE DEFINER=root@localhost PROCEDURE profile_get_pic(
    db_user VARCHAR(50) CHARSET utf8 COLLATE utf8_unicode_ci
    )   READS SQL DATA
BEGIN
    DECLARE name_user VARCHAR(50);
    DECLARE db_user_name VARCHAR(50);

    CALL rpfp.lib_extract_user_name( db_user, name_user, db_user_name );

     SELECT prof.PROFILE_PIC pic_file
       FROM rpfp.user_profile prof
      WHERE prof.DB_USER_ID = name_user
    ;

END$$

CREATE DEFINER=root@localhost PROCEDURE profile_save_own_pic_filename(
    pic_filename VARCHAR(50) CHARSET utf8 COLLATE utf8_unicode_ci
    )   READS SQL DATA
BEGIN

    CALL rpfp.profile_save_pic_filename( USER(), pic_filename );

END$$

CREATE DEFINER=root@localhost PROCEDURE profile_save_pic_filename(
    db_user VARCHAR(50) CHARSET utf8 COLLATE utf8_unicode_ci,
    pic_filename VARCHAR(50) CHARSET utf8 COLLATE utf8_unicode_ci
    )   READS SQL DATA
BEGIN
    DECLARE name_user VARCHAR(50);
    DECLARE db_user_name VARCHAR(50);

    CALL rpfp.lib_extract_user_name( db_user, name_user, db_user_name );

     UPDATE rpfp.user_profile prof
        SET prof.PROFILE_PIC = pic_filename
      WHERE prof.DB_USER_ID = name_user
    ;
    
END$$

/** END OF PROFILE PROCS */


/** LIBRARIES */
CREATE DEFINER=root@localhost PROCEDURE lib_get_full_location(
    IN  LOCATION_ID INT
    )   READS SQL DATA
BEGIN
     SELECT reg.REGION_CODE AS region_id,
            reg.LOCATION_DESCRIPTION AS region_name,
            prov.PROVINCE_CODE AS province_id,
            prov.LOCATION_DESCRIPTION AS province_name,
            city.MUNICIPALITY_CODE AS municipality_id,
            city.LOCATION_DESCRIPTION AS municipality_name,
            brgy.PSGC_CODE AS location_code,
            brgy.LOCATION_DESCRIPTION AS location_name
       FROM rpfp.lib_psgc_locations reg
  LEFT JOIN rpfp.lib_psgc_locations brgy
         ON reg.PSGC_CODE = (brgy.REGION_CODE * POWER( 10, 7 ))
  LEFT JOIN rpfp.lib_psgc_locations prov
         ON prov.PSGC_CODE = (brgy.PROVINCE_CODE * POWER( 10, 5 ))
  LEFT JOIN rpfp.lib_psgc_locations city
         ON city.PSGC_CODE = (brgy.MUNICIPALITY_CODE * POWER( 10, 3 ))
      WHERE brgy.PSGC_CODE = LOCATION_ID
      LIMIT 1
    ;
END$$

CREATE DEFINER=root@localhost FUNCTION lib_get_region_from_location(
    LOCATION_ID INT
    )   RETURNS INT
        READS SQL DATA
BEGIN
    RETURN LOCATION_ID DIV POWER( 10, 7 );
END$$

CREATE DEFINER=root@localhost PROCEDURE lib_list_regions()
        READS SQL DATA
BEGIN
     SELECT reg.REGION_CODE AS region_id,
            reg.PSGC_CODE AS location_code,
            reg.LOCATION_DESCRIPTION AS location_name
       FROM rpfp.lib_psgc_locations reg
      WHERE reg.INTER_LEVEL = 'REG'
   ORDER BY reg.LOCATION_ID
    ;
END$$

CREATE DEFINER=root@localhost PROCEDURE lib_list_provinces(
    IN region_id INT UNSIGNED
    )    READS SQL DATA
BEGIN
     SELECT reg.REGION_CODE AS region_id,
            reg.LOCATION_DESCRIPTION AS region_name,
            prov.PROVINCE_CODE AS location_code,
            prov.LOCATION_DESCRIPTION AS location_name
       FROM rpfp.lib_psgc_locations prov
  LEFT JOIN rpfp.lib_psgc_locations reg
         ON reg.PSGC_CODE = (prov.REGION_CODE * POWER( 10, 7 ))
      WHERE prov.INTER_LEVEL IN ('PROV', 'DIST')
        AND prov.REGION_CODE = region_id
   ORDER BY prov.LOCATION_DESCRIPTION
    ;
END$$

CREATE DEFINER=root@localhost PROCEDURE lib_list_cities(
    IN province_id INT UNSIGNED
    )    READS SQL DATA
BEGIN
     SELECT reg.REGION_CODE AS region_id,
            reg.LOCATION_DESCRIPTION AS region_name,
            prov.PROVINCE_CODE AS province_id,
            prov.LOCATION_DESCRIPTION AS province_name,
            city.MUNICIPALITY_CODE AS location_code,
            city.LOCATION_DESCRIPTION AS location_name
       FROM rpfp.lib_psgc_locations city
  LEFT JOIN rpfp.lib_psgc_locations reg
         ON reg.PSGC_CODE = (city.REGION_CODE * POWER( 10, 7 ))
  LEFT JOIN rpfp.lib_psgc_locations prov
         ON prov.PSGC_CODE = (city.PROVINCE_CODE * POWER( 10, 5 ))
      WHERE city.INTER_LEVEL IN ('CITY', 'MUN', 'SUBMUN')
        AND city.PROVINCE_CODE = province_id
   ORDER BY city.LOCATION_DESCRIPTION
    ;
END$$

CREATE DEFINER=root@localhost PROCEDURE lib_list_regional_cities(
    IN region INT UNSIGNED
    )    READS SQL DATA
BEGIN
     SELECT reg.REGION_CODE AS region_id,
            reg.LOCATION_DESCRIPTION AS region_name,
            prov.PROVINCE_CODE AS province_id,
            prov.LOCATION_DESCRIPTION AS province_name,
            city.MUNICIPALITY_CODE AS location_code,
            city.LOCATION_DESCRIPTION AS location_name
       FROM rpfp.lib_psgc_locations city
  LEFT JOIN rpfp.lib_psgc_locations reg
         ON reg.PSGC_CODE = (city.REGION_CODE * POWER( 10, 7 ))
  LEFT JOIN rpfp.lib_psgc_locations prov
         ON prov.PSGC_CODE = (city.PROVINCE_CODE * POWER( 10, 5 ))
      WHERE city.INTER_LEVEL IN ('CITY', 'MUN', 'SUBMUN')
        AND city.REGION_CODE = region
   ORDER BY prov.PROVINCE_CODE, city.LOCATION_DESCRIPTION
    ;
END$$

CREATE DEFINER=root@localhost PROCEDURE lib_list_brgy(
    IN municipality_id INT UNSIGNED
    )    READS SQL DATA
BEGIN
     SELECT reg.REGION_CODE AS region_id,
            reg.LOCATION_DESCRIPTION AS region_name,
            prov.PROVINCE_CODE AS province_id,
            prov.LOCATION_DESCRIPTION AS province_name,
            city.MUNICIPALITY_CODE AS municipality_id,
            city.LOCATION_DESCRIPTION AS municipality_name,
            brgy.PSGC_CODE AS location_code,
            brgy.LOCATION_DESCRIPTION AS location_name
       FROM rpfp.lib_psgc_locations brgy
  LEFT JOIN rpfp.lib_psgc_locations reg
         ON reg.PSGC_CODE = (brgy.REGION_CODE * POWER( 10, 7 ))
  LEFT JOIN rpfp.lib_psgc_locations prov
         ON prov.PSGC_CODE = (brgy.PROVINCE_CODE * POWER( 10, 5 ))
  LEFT JOIN rpfp.lib_psgc_locations city
         ON city.PSGC_CODE = (brgy.MUNICIPALITY_CODE * POWER( 10, 3 ))
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
    DECLARE name_len INT;
    SET db_user_name := REPLACE(db_user,  "\'", "");
    SET name_user := db_user;
    SET name_len := LOCATE( '@', name_user, 1 );

    IF name_len > 0 THEN
        SET name_user := SUBSTRING( db_user_name, 1, name_len - 1 );
    ELSE
        SET db_user_name := CONCAT( name_user, '@localhost' );
    END IF;
END$$

CREATE DEFINER=root@localhost FUNCTION lib_select_role(
    role_num INT
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
                SET default_role := "partners";

            WHEN 50 THEN
                SET default_role := "encoder";
            ELSE 
                SET default_role := "rpfp_login";
        END CASE;
    END IF;
    RETURN default_role;
END$$

CREATE DEFINER=root@localhost FUNCTION lib_select_scope(
    scope_num INT
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

CREATE DEFINER=root@localhost FUNCTION lib_num_scope(
    scope_word VARCHAR(25) CHARSET utf8 COLLATE utf8_unicode_ci
    )   RETURNS INT CONTAINS SQL
BEGIN
    DECLARE default_num INT DEFAULT 0;
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

CREATE DEFINER=root@localhost FUNCTION lib_num_role(
    role_word VARCHAR(25) CHARSET utf8 COLLATE utf8_unicode_ci
    )   RETURNS INT CONTAINS SQL
BEGIN
    DECLARE default_num INT DEFAULT 0;
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

            WHEN "partners" THEN
                SET default_num := 60;

            WHEN "encoder" THEN
                SET default_num := 50;
            ELSE 
                SET default_num := 0;
        END CASE;
    END IF;
    RETURN default_num;
END$$

CREATE DEFINER=root@localhost FUNCTION lib_get_multiplier(
    scope_num INT
    )   RETURNS INT CONTAINS SQL
BEGIN
    DECLARE multiplier INT;

    CASE scope_num
        WHEN 40 THEN
            SET multiplier := 7;
        WHEN 30 THEN
            SET multiplier := 5;
        WHEN 20 THEN
            SET multiplier := 3;
        ELSE 
            SET multiplier := 0;
    END CASE;

    RETURN multiplier;
END$$
/** END OF LIBRARIES */

/** CLASSES */
CREATE DEFINER=root@localhost PROCEDURE get_class_list(
    IN status_active INT,
    IN page_no INT,
    IN items_per_page INT
    )   READS SQL DATA
BEGIN
    DECLARE name_user VARCHAR(50);
    DECLARE db_user_name VARCHAR(50);
    DECLARE read_offset INT;
    DECLARE user_scope INT;
    DECLARE user_location INT;
    DECLARE multiplier INT;
    DECLARE is_not_encoder INT(1);
    DECLARE barangay_id_no INT;
    DECLARE record_id INT;
    
    CALL rpfp.lib_extract_user_name( USER(), name_user, db_user_name );
    SET user_scope := rpfp.profile_get_scope( name_user );
    SET multiplier := rpfp.lib_get_multiplier( user_scope );
    SET user_location := rpfp.profile_get_location( name_user, user_scope );
    SET is_not_encoder := NOT IFNULL(rpfp.profile_check_if_encoder(), FALSE);

    IF ( NOT EXISTS (
         SELECT rc.RPFP_CLASS_ID
           FROM rpfp.rpfp_class rc
      LEFT JOIN rpfp.couples apc
             ON apc.RPFP_CLASS_ID = rc.RPFP_CLASS_ID
          WHERE apc.IS_ACTIVE = status_active
            AND user_location = (rc.BARANGAY_ID DIV POWER( 10, multiplier ))
        )
    ) THEN
         SELECT NULL AS rpfpclass,
                NULL AS typeclass,
                NULL AS others_specify,
                NULL AS region_id,
                NULL AS region_name,
                NULL AS province_id,
                NULL AS province_name,
                NULL AS municipality_id,
                NULL AS municipality_name,
                NULL AS psgc_code,
                NULL AS barangay,
                NULL AS class_no,
                NULL AS couples_encoded,
                NULL AS served_count,
                NULL AS date_conduct,
                NULL AS lastname,
                NULL AS firstname
        ;
    ELSE BEGIN
            IF (IFNULL( page_no, 0) = 0) THEN
                /** DEFAULT PAGE NO. */
                SET page_no := 1;
            END IF;
            IF (IFNULL( items_per_page, 0) = 0) THEN
                /** DEFAULT COUNT PER PAGE*/
                SET items_per_page := 10;
            END IF;

            SET read_offset := (page_no - 1) * items_per_page;
            --  SELECT rc.BARANGAY_ID INTO barangay_id_no FROM rpfp.rpfp_class rc WHERE rc.RPFP_CLASS_ID = record_id;

             SELECT rc.RPFP_CLASS_ID AS rpfpclass,
                    tc.TYPE_CLASS_DESC AS typeclass,
                    rc.OTHERS_SPECIFY AS others_specify,
                    prov.LOCATION_DESCRIPTION AS province_name,
                    city.LOCATION_DESCRIPTION AS municipality_name,
                    brgy.LOCATION_DESCRIPTION AS barangay,
                    COUNT(apc.COUPLES_ID) AS couples_encoded,
                    COUNT(fs.COUPLES_ID) AS served_count,
                    rc.CLASS_NUMBER AS class_no,
                    rc.DATE_CONDUCTED AS date_conduct,
                    up.LAST_NAME AS lastname,
                    up.FIRST_NAME AS firstname
               FROM rpfp.rpfp_class rc
          LEFT JOIN rpfp.couples apc ON apc.RPFP_CLASS_ID = rc.RPFP_CLASS_ID
          LEFT JOIN rpfp.lib_type_class tc ON tc.TYPE_CLASS_ID = rc.TYPE_CLASS_ID
                      LEFT JOIN rpfp.lib_psgc_locations brgy
                             ON brgy.PSGC_CODE = rc.BARANGAY_ID
                      LEFT JOIN rpfp.lib_psgc_locations city
                             ON city.PSGC_CODE = (brgy.MUNICIPALITY_CODE * POWER( 10, 3 ))
                      LEFT JOIN rpfp.lib_psgc_locations prov
                             ON prov.PSGC_CODE = (brgy.PROVINCE_CODE * POWER( 10, 5 ))
          LEFT JOIN rpfp.user_profile up ON up.DB_USER_ID = rc.DB_USER_ID
          LEFT JOIN rpfp.fp_service fs ON fs.COUPLES_ID = apc.COUPLES_ID
              WHERE apc.IS_ACTIVE = status_active
                AND user_location = (rc.BARANGAY_ID DIV POWER( 10, multiplier ))
           GROUP BY rc.CLASS_NUMBER
           ORDER BY rc.DATE_CONDUCTED DESC
              LIMIT read_offset, items_per_page
            ;
        END;
    END IF;
END$$

CREATE DEFINER=root@localhost PROCEDURE get_class_details(
    IN record_id INT
    )   READS SQL DATA
BEGIN
    DECLARE barangay_id_no INT;
    IF ( NOT EXISTS (
         SELECT rc.CLASS_NUMBER
           FROM rpfp.rpfp_class rc
          WHERE rc.RPFP_CLASS_ID = record_id
        )
    ) THEN
         SELECT NULL AS rpfpclass,
                NULL AS typeclass,
                NULL AS others_specify,
                NULL AS region_id,
                NULL AS region_name,
                NULL AS province_id,
                NULL AS province_name,
                NULL AS municipality_id,
                NULL AS municipality_name,
                NULL AS psgc_code,
                NULL AS barangay,
                NULL AS class_no,
                NULL AS date_conduct
        ;
    ELSE BEGIN
             SELECT rc.BARANGAY_ID INTO barangay_id_no FROM rpfp.rpfp_class rc WHERE rc.RPFP_CLASS_ID = record_id;

             SELECT rc.RPFP_CLASS_ID AS rpfpclass,
                    tc.TYPE_CLASS_DESC AS typeclass,
                    rc.OTHERS_SPECIFY AS others_specify,
                    full_location.region_id AS region_id,
                    full_location.region_name AS region_name,
                    full_location.province_id AS province_id,
                    full_location.province_name AS province_name,
                    full_location.municipality_id AS municipality_id,
                    full_location.municipality_name AS municipality_name,
                    full_location.location_code AS psgc_code,
                    full_location.location_name AS barangay,
                    rc.CLASS_NUMBER AS class_no,
                    rc.DATE_CONDUCTED AS date_conduct
               FROM rpfp.rpfp_class rc
          LEFT JOIN rpfp.lib_type_class tc
                 ON tc.TYPE_CLASS_ID = rc.TYPE_CLASS_ID
          LEFT JOIN (
                         SELECT reg.REGION_CODE AS region_id,
                                reg.LOCATION_DESCRIPTION AS region_name,
                                prov.PROVINCE_CODE AS province_id,
                                prov.LOCATION_DESCRIPTION AS province_name,
                                city.MUNICIPALITY_CODE AS municipality_id,
                                city.LOCATION_DESCRIPTION AS municipality_name,
                                brgy.PSGC_CODE AS location_code,
                                brgy.LOCATION_DESCRIPTION AS location_name
                           FROM rpfp.lib_psgc_locations reg
                      LEFT JOIN rpfp.lib_psgc_locations brgy
                             ON reg.PSGC_CODE = (brgy.REGION_CODE * POWER( 10, 7 ))
                      LEFT JOIN rpfp.lib_psgc_locations prov
                             ON prov.PSGC_CODE = (brgy.PROVINCE_CODE * POWER( 10, 5 ))
                      LEFT JOIN rpfp.lib_psgc_locations city
                             ON city.PSGC_CODE = (brgy.MUNICIPALITY_CODE * POWER( 10, 3 ))
                          WHERE brgy.PSGC_CODE = barangay_id_no
                          LIMIT 1
                    ) full_location
                 ON full_location.location_code = rc.BARANGAY_ID
              WHERE rc.RPFP_CLASS_ID = record_id
           GROUP BY rc.CLASS_NUMBER
            ;
        END;
    END IF;
END$$

CREATE DEFINER=root@localhost PROCEDURE get_forms_list(
    IN class_no VARCHAR(100),
    IN status_active INT,
    IN page_no INT,
    IN items_per_page INT
    )   READS SQL DATA
BEGIN
    DECLARE name_user VARCHAR(50);
    DECLARE db_user_name VARCHAR(50);
    DECLARE read_offset INT;
    DECLARE user_scope INT;
    DECLARE user_location INT;
    DECLARE multiplier INT;
    DECLARE is_not_encoder INT(1);
    
    CALL rpfp.lib_extract_user_name( USER(), name_user, db_user_name );
    SET user_scope := rpfp.profile_get_scope( name_user );
    SET multiplier := rpfp.lib_get_multiplier( user_scope );
    SET user_location := rpfp.profile_get_location( name_user, user_scope );
    SET is_not_encoder := NOT IFNULL(rpfp.profile_check_if_encoder(), FALSE);

    IF ( NOT EXISTS (
         SELECT rc.RPFP_CLASS_ID
           FROM rpfp.rpfp_class rc
      LEFT JOIN rpfp.couples apc
             ON apc.RPFP_CLASS_ID = rc.RPFP_CLASS_ID
          WHERE apc.IS_ACTIVE = status_active
            AND (   rc.DB_USER_ID = name_user
                 OR (   is_not_encoder
                    AND user_location = (rc.BARANGAY_ID DIV POWER( 10, multiplier ))
                    )
                )
        )
    ) THEN
         SELECT NULL AS rpfpclass,
                NULL AS typeclass,
                NULL AS others_specify,
                NULL AS barangay,
                NULL AS class_no,
                NULL AS date_conduct,
                NULL AS lastname,
                NULL AS firstname
        ;
    ELSE BEGIN
            IF (IFNULL( page_no, 0) = 0) THEN
                /** DEFAULT PAGE NO. */
                SET page_no := 1;
            END IF;
            IF (IFNULL( items_per_page, 0) = 0) THEN
                /** DEFAULT COUNT PER PAGE*/
                SET items_per_page := 10;
            END IF;

            SET read_offset := (page_no - 1) * items_per_page;

             SELECT rc.RPFP_CLASS_ID AS rpfpclass,
                    tc.TYPE_CLASS_DESC AS typeclass,
                    rc.OTHERS_SPECIFY AS others_specify,
                    lp.LOCATION_DESCRIPTION AS barangay,
                    rc.CLASS_NUMBER AS class_no,
                    rc.DATE_CONDUCTED AS date_conduct,
                    ic.LNAME AS lastname,
                    ic.FNAME AS firstname
               FROM rpfp.rpfp_class rc
          LEFT JOIN rpfp.couples apc 
		         ON apc.RPFP_CLASS_ID = rc.RPFP_CLASS_ID
          LEFT JOIN rpfp.lib_type_class tc ON tc.TYPE_CLASS_ID = rc.TYPE_CLASS_ID
          LEFT JOIN rpfp.lib_psgc_locations lp ON lp.PSGC_CODE = rc.BARANGAY_ID
          LEFT JOIN rpfp.individual ic ON ic.COUPLES_ID = apc.COUPLES_ID
              WHERE rc.CLASS_NUMBER = class_no
                AND apc.IS_ACTIVE = status_active
                AND (   rc.DB_USER_ID = name_user
                    OR (   is_not_encoder
                        AND user_location = (rc.BARANGAY_ID DIV POWER( 10, multiplier ))
                        )
                    )
           GROUP BY rc.RPFP_CLASS_ID
           ORDER BY rc.RPFP_CLASS_ID DESC
              LIMIT read_offset, items_per_page
            ;
        END;
    END IF;
END$$

CREATE DEFINER=root@localhost PROCEDURE encoder_get_class_list_pending (
    IN page_no INT,
    IN items_per_page INT
    )   READS SQL DATA
BEGIN
    DECLARE status_pending INT DEFAULT 2;
    
    DECLARE name_user VARCHAR(50);
    DECLARE db_user_name VARCHAR(50);
    DECLARE read_offset INT;
    DECLARE user_scope INT;
    DECLARE user_location INT;
    DECLARE multiplier INT;
    DECLARE is_not_encoder INT(1);
    DECLARE barangay_id_no INT;
    DECLARE record_id INT;
    
    CALL rpfp.lib_extract_user_name( USER(), name_user, db_user_name );
    SET user_scope := rpfp.profile_get_scope( name_user );
    SET multiplier := rpfp.lib_get_multiplier( user_scope );
    SET user_location := rpfp.profile_get_location( name_user, user_scope );
    SET is_not_encoder := NOT IFNULL(rpfp.profile_check_if_encoder(), FALSE);

    IF ( NOT EXISTS (
         SELECT rc.RPFP_CLASS_ID
           FROM rpfp.rpfp_class rc
      LEFT JOIN rpfp.couples apc
             ON apc.RPFP_CLASS_ID = rc.RPFP_CLASS_ID
          WHERE apc.IS_ACTIVE = status_pending
            AND user_location = (rc.BARANGAY_ID DIV POWER( 10, multiplier ))
        )
    ) THEN
         SELECT NULL AS rpfpclass,
                NULL AS typeclass,
                NULL AS others_specify,
                NULL AS region_id,
                NULL AS region_name,
                NULL AS province_id,
                NULL AS province_name,
                NULL AS municipality_id,
                NULL AS municipality_name,
                NULL AS psgc_code,
                NULL AS barangay,
                NULL AS class_no,
                NULL AS couples_encoded,
                NULL AS served_count,
                NULL AS date_conduct,
                NULL AS lastname,
                NULL AS firstname
        ;
    ELSE BEGIN
            IF (IFNULL( page_no, 0) = 0) THEN
                /** DEFAULT PAGE NO. */
                SET page_no := 1;
            END IF;
            IF (IFNULL( items_per_page, 0) = 0) THEN
                /** DEFAULT COUNT PER PAGE*/
                SET items_per_page := 10;
            END IF;

            SET read_offset := (page_no - 1) * items_per_page;
            --  SELECT rc.BARANGAY_ID INTO barangay_id_no FROM rpfp.rpfp_class rc WHERE rc.RPFP_CLASS_ID = record_id;

             SELECT rc.RPFP_CLASS_ID AS rpfpclass,
                    tc.TYPE_CLASS_DESC AS typeclass,
                    rc.OTHERS_SPECIFY AS others_specify,
                    prov.LOCATION_DESCRIPTION AS province_name,
                    city.LOCATION_DESCRIPTION AS municipality_name,
                    brgy.LOCATION_DESCRIPTION AS barangay,
                    COUNT(apc.COUPLES_ID) AS couples_encoded,
                    COUNT(fs.COUPLES_ID) AS served_count,
                    rc.CLASS_NUMBER AS class_no,
                    rc.DATE_CONDUCTED AS date_conduct,
                    up.LAST_NAME AS lastname,
                    up.FIRST_NAME AS firstname
               FROM rpfp.rpfp_class rc
          LEFT JOIN rpfp.couples apc ON apc.RPFP_CLASS_ID = rc.RPFP_CLASS_ID
          LEFT JOIN rpfp.lib_type_class tc ON tc.TYPE_CLASS_ID = rc.TYPE_CLASS_ID
                      LEFT JOIN rpfp.lib_psgc_locations brgy
                             ON brgy.PSGC_CODE = rc.BARANGAY_ID
                      LEFT JOIN rpfp.lib_psgc_locations city
                             ON city.PSGC_CODE = (brgy.MUNICIPALITY_CODE * POWER( 10, 3 ))
                      LEFT JOIN rpfp.lib_psgc_locations prov
                             ON prov.PSGC_CODE = (brgy.PROVINCE_CODE * POWER( 10, 5 ))
          LEFT JOIN rpfp.user_profile up ON up.DB_USER_ID = rc.DB_USER_ID
          LEFT JOIN rpfp.fp_service fs ON fs.COUPLES_ID = apc.COUPLES_ID
              WHERE apc.IS_ACTIVE = status_pending
                AND (   rc.DB_USER_ID = name_user
                    OR (   is_not_encoder
                        AND user_location = (rc.BARANGAY_ID DIV POWER( 10, multiplier ))
                        )
                    )
           GROUP BY rc.CLASS_NUMBER
           ORDER BY rc.DATE_CONDUCTED DESC
              LIMIT read_offset, items_per_page
            ;
        END;
    END IF;
END$$

CREATE DEFINER=root@localhost PROCEDURE encoder_get_class_list_approved (
    IN page_no INT,
    IN items_per_page INT
    )   READS SQL DATA
BEGIN
    DECLARE active_status INT DEFAULT 0;
    CALL rpfp.get_class_list(
            active_status,
            page_no,
            items_per_page
    );

END$$

CREATE DEFINER=root@localhost PROCEDURE encoder_get_couples_list(
    IN class_num VARCHAR(50),
    IN couples_name VARCHAR(100),
    IN search_age_from INT,
    IN search_age_to INT,
    IN no_child INT,
    IN mfp_used INT,
    IN tfp_used INT,
    IN intention_status VARCHAR(10),
    IN intention_use INT,
    IN status_active INT,
    IN search_status INT
    )   READS SQL DATA
proc_exit_point :
BEGIN
    DECLARE type_class_range INT;
    DECLARE search_child_from INT;
    DECLARE search_child_to INT;
    DECLARE search_mfp_from INT;
    DECLARE search_mfp_to INT;
    DECLARE search_tfp_from INT;
    DECLARE search_tfp_to INT;
    DECLARE search_intention_from INT;
    DECLARE search_intention_to INT;
    DECLARE search_intentionfp_from INT;
    DECLARE search_intentionfp_to INT;

    DECLARE location_code_from INT;
    DECLARE location_code_to INT;

    DECLARE name_user VARCHAR(50);
    DECLARE db_user_name VARCHAR(50);
    DECLARE user_scope INT;
    DECLARE user_location INT;
    DECLARE multiplier INT;
    DECLARE is_not_encoder INT(1);
    
    CALL rpfp.lib_extract_user_name( USER(), name_user, db_user_name );
    SET user_scope := rpfp.profile_get_scope( name_user );
    SET multiplier := rpfp.lib_get_multiplier( user_scope );
    SET user_location := rpfp.profile_get_location( name_user, user_scope );
    SET is_not_encoder := NOT IFNULL(rpfp.profile_check_if_encoder(), FALSE);

    IF (IFNULL( status_active, 0 ) = 0 ) THEN
        SET status_active = 0;
    END IF;

    IF (IFNULL( search_age_from, 0 ) = 0) THEN
        SET search_age_from = 0;
    END IF;

    IF (IFNULL( search_age_to, 0 ) = 0) THEN
        SET search_age_to = 200;
    END IF;

    IF (IFNULL( no_child, 0 ) = 0) THEN
        SET search_child_from = 0;
        SET search_child_to = 200;
    END IF;
   
    IF ( IFNULL(search_status, 0 ) = 0 ) THEN
        IF NOT EXISTS (
             SELECT apc.RPFP_CLASS_ID
               FROM rpfp.couples apc
          LEFT JOIN rpfp.rpfp_class rc
                 ON rc.RPFP_CLASS_ID = apc.RPFP_CLASS_ID
              WHERE rc.CLASS_NUMBER = class_num
                AND (   rc.DB_USER_ID = name_user
                    OR (   is_not_encoder
                        AND user_location = (rc.BARANGAY_ID DIV POWER( 10, multiplier ))
                        )
                    )
        ) THEN
             SELECT NULL AS class_no,
                    NULL AS couplesid,
                    NULL AS isactive,
                    NULL AS date_encode,
                    NULL AS lastname,
                    NULL AS firstname,
                    NULL AS middle,
                    NULL AS ext_name
            ;
        ELSE
             SELECT rc.CLASS_NUMBER AS class_no,
                    apc.COUPLES_ID AS couplesid,
                    apc.IS_ACTIVE AS isactive,
                    apc.DATE_ENCODED AS date_encode,
                    ic.LNAME AS lastname,
                    ic.FNAME AS firstname,
                    ic.MNAME AS middle,
                    ic.EXT_NAME AS ext_name
               FROM rpfp.couples apc
          LEFT JOIN rpfp.rpfp_class rc
                 ON rc.RPFP_CLASS_ID = apc.RPFP_CLASS_ID
          LEFT JOIN rpfp.individual ic
                 ON ic.COUPLES_ID = apc.COUPLES_ID
              WHERE rc.CLASS_NUMBER = class_num
                AND (   rc.DB_USER_ID = name_user
                    OR (   is_not_encoder
                        AND user_location = (rc.BARANGAY_ID DIV POWER( 10, multiplier ))
                        )
                    )
                AND (
                        ic.FNAME LIKE CONCAT('%',couples_name,'%')
                     OR ic.LNAME LIKE CONCAT('%',couples_name,'%')
                )
                AND ic.AGE >= search_age_from
                AND ic.AGE <= search_age_to
                AND apc.NO_CHILDREN >= search_child_from
                AND apc.NO_CHILDREN <= search_child_to
           ORDER BY apc.COUPLES_ID ASC
            ;
        END IF;
    END IF;
    
    IF search_status = 1 THEN
         IF tfp_used > 0 THEN
            CALL rpfp.get_couples_list_all(
            class_num,
            couples_name,
            search_age_from,
            search_age_to,
            no_child,
            mfp_used,
            tfp_used,
            intention_status,
            intention_use,
            status_active,
            search_status
            );
            LEAVE proc_exit_point;
        END IF;
        
        IF mfp_used > 0 THEN
            CALL rpfp.get_couples_list_all(
            class_num,
            couples_name,
            search_age_from,
            search_age_to,
            no_child,
            mfp_used,
            tfp_used,
            intention_status,
            intention_use,
            status_active,
            search_status
            );
            LEAVE proc_exit_point;
        END IF;
    
        IF NOT EXISTS (
             SELECT apc.RPFP_CLASS_ID
               FROM rpfp.couples apc
          LEFT JOIN rpfp.rpfp_class rc
                 ON rc.RPFP_CLASS_ID = apc.RPFP_CLASS_ID
              WHERE rc.CLASS_NUMBER = class_num
                AND (   
                            rc.DB_USER_ID = name_user
                         OR (   is_not_encoder
                        AND user_location = (rc.BARANGAY_ID DIV POWER( 10, multiplier ))
                        )
                    )
        ) THEN
             SELECT NULL AS class_no,
                    NULL AS couplesid,
                    NULL AS isactive,
                    NULL AS date_encode,
                    NULL AS lastname,
                    NULL AS firstname,
                    NULL AS middle,
                    NULL AS ext_name
            ;
        ELSE
             SELECT rc.CLASS_NUMBER AS class_no,
                    apc.COUPLES_ID AS couplesid,
                    apc.IS_ACTIVE AS isactive,
                    apc.DATE_ENCODED AS date_encode,
                    ic.LNAME AS lastname,
                    ic.FNAME AS firstname,
                    ic.MNAME AS middle,
                    ic.EXT_NAME AS ext_name
               FROM rpfp.couples apc
          LEFT JOIN rpfp.rpfp_class rc
                 ON rc.RPFP_CLASS_ID = apc.RPFP_CLASS_ID
          LEFT JOIN rpfp.individual ic
                 ON ic.COUPLES_ID = apc.COUPLES_ID
              WHERE rc.CLASS_NUMBER = class_num
                AND (   
                            rc.DB_USER_ID = name_user
                         OR (   is_not_encoder
                        AND user_location = (rc.BARANGAY_ID DIV POWER( 10, multiplier ))
                        )
                    )
                AND (
                            ic.FNAME LIKE CONCAT('%',couples_name,'%')
                         OR ic.LNAME LIKE CONCAT('%',couples_name,'%')
                )
                AND ic.AGE >= search_age_from
                AND ic.AGE <= search_age_to
                AND apc.NO_CHILDREN >= search_child_from
                AND apc.NO_CHILDREN <= search_child_to
           ORDER BY apc.COUPLES_ID ASC
            ;
        END IF;
    END IF;

    IF search_status = 2 THEN    
        IF tfp_used > 0 THEN
            CALL rpfp.get_couples_list_unmet(
            class_num,
            couples_name,
            search_age_from,
            search_age_to,
            no_child,
            mfp_used,
            tfp_used,
            intention_status,
            intention_use,
            status_active,
            search_status
            );
            LEAVE proc_exit_point;
        END IF;
        
        IF mfp_used > 0 THEN
            CALL rpfp.get_couples_list_unmet(
            class_num,
            couples_name,
            search_age_from,
            search_age_to,
            no_child,
            mfp_used,
            tfp_used,
            intention_status,
            intention_use,
            status_active,
            search_status
            );
            LEAVE proc_exit_point;
        END IF;
        
        IF NOT EXISTS (
             SELECT rc.RPFP_CLASS_ID
               FROM rpfp.RPFP_CLASS rc
          LEFT JOIN rpfp.couples apc
                 ON apc.RPFP_CLASS_ID = rc.RPFP_CLASS_ID
              WHERE apc.IS_ACTIVE = status_active
                AND (   
                            rc.DB_USER_ID = name_user
                         OR (   is_not_encoder
                        AND user_location = (rc.BARANGAY_ID DIV POWER( 10, multiplier ))
                    )
                )
        ) THEN
         SELECT NULL AS class_no,
                NULL AS couplesid,
                NULL AS isactive,
                NULL AS date_encode,
                NULL AS lastname,
                NULL AS firstname,
                NULL AS middle,
                NULL AS ext_name
        ;
    ELSE
         SELECT rc.CLASS_NUMBER AS class_no,
                apc.COUPLES_ID AS couplesid,
                apc.IS_ACTIVE AS isactive,
                apc.DATE_ENCODED AS date_encode,
                ic.LNAME AS lastname,
                ic.FNAME AS firstname,
                ic.MNAME AS middle,
                ic.EXT_NAME AS ext_name
              FROM rpfp.rpfp_class rc 
         LEFT JOIN rpfp.couples apc ON apc.RPFP_CLASS_ID = rc.RPFP_CLASS_ID
         LEFT JOIN rpfp.individual ic ON ic.COUPLES_ID = apc.COUPLES_ID
         LEFT JOIN rpfp.fp_details fd ON fd.COUPLES_ID = ic.COUPLES_ID
         LEFT JOIN rpfp.lib_psgc_locations lp ON lp.PSGC_CODE = rc.BARANGAY_ID
         LEFT JOIN rpfp.lib_psgc_locations city ON city.PSGC_CODE = (lp.MUNICIPALITY_CODE * POWER( 10, 3 ))
         LEFT JOIN rpfp.lib_psgc_locations prov ON prov.PSGC_CODE = (lp.PROVINCE_CODE * POWER( 10, 5 ))
         LEFT JOIN rpfp.user_profile up ON up.DB_USER_ID = rc.DB_USER_ID
             WHERE rc.CLASS_NUMBER = class_num
               AND apc.IS_ACTIVE = status_active
               AND (   rc.DB_USER_ID = name_user
                   OR (   is_not_encoder
                      AND user_location = (rc.BARANGAY_ID DIV POWER( 10, multiplier ))
                    )
                )
               AND (
                        ic.FNAME LIKE CONCAT('%',couples_name,'%')
                     OR ic.LNAME LIKE CONCAT('%',couples_name,'%')
                )
               AND ic.AGE >= search_age_from
               AND ic.AGE <= search_age_to
               AND apc.NO_CHILDREN >= search_child_from
               AND apc.NO_CHILDREN <= search_child_to
               AND (   
                       fd.TFP_TYPE_ID <= 5
                    OR fd.TFP_STATUS_ID = 'A'
                )
       ORDER BY apc.COUPLES_ID ASC
            ; 
        END IF;
        LEAVE proc_exit_point;
    END IF;

    IF search_status = 3 THEN
         IF tfp_used > 0 THEN
            CALL rpfp.get_couples_list_served_unmet(
            class_num,
            couples_name,
            search_age_from,
            search_age_to,
            no_child,
            mfp_used,
            tfp_used,
            intention_status,
            intention_use,
            status_active,
            search_status
            );
            LEAVE proc_exit_point;
        END IF;
        
        IF mfp_used > 0 THEN
            CALL rpfp.get_couples_list_served_unmet(
            class_num,
            couples_name,
            search_age_from,
            search_age_to,
            no_child,
            mfp_used,
            tfp_used,
            intention_status,
            intention_use,
            status_active,
            search_status
            );
            LEAVE proc_exit_point;
        END IF;
        
        IF NOT EXISTS (
              SELECT rc.RPFP_CLASS_ID
                FROM rpfp.RPFP_CLASS rc
           LEFT JOIN rpfp.couples apc
                  ON apc.RPFP_CLASS_ID = rc.RPFP_CLASS_ID
               WHERE apc.IS_ACTIVE = status_active
                 AND (  
                            rc.DB_USER_ID = name_user
                         OR (   is_not_encoder
                        AND user_location = (rc.BARANGAY_ID DIV POWER( 10, multiplier ))
                    )
                )
        ) THEN
         SELECT NULL AS class_no,
                NULL AS couplesid,
                NULL AS isactive,
                NULL AS date_encode,
                NULL AS lastname,
                NULL AS firstname,
                NULL AS middle,
                NULL AS ext_name
        ;
    ELSE
         SELECT rc.CLASS_NUMBER AS class_no,
                apc.COUPLES_ID AS couplesid,
                apc.IS_ACTIVE AS isactive,
                apc.DATE_ENCODED AS date_encode,
                ic.LNAME AS lastname,
                ic.FNAME AS firstname,
                ic.MNAME AS middle,
                ic.EXT_NAME AS ext_name
              FROM rpfp.rpfp_class rc 
         LEFT JOIN rpfp.couples apc ON apc.RPFP_CLASS_ID = rc.RPFP_CLASS_ID
         LEFT JOIN rpfp.individual ic ON ic.COUPLES_ID = apc.COUPLES_ID
         LEFT JOIN rpfp.fp_details fd ON fd.COUPLES_ID = ic.COUPLES_ID
         LEFT JOIN rpfp.fp_service fs ON fs.COUPLES_ID = apc.COUPLES_ID
         LEFT JOIN rpfp.lib_psgc_locations lp ON lp.PSGC_CODE = rc.BARANGAY_ID
         LEFT JOIN rpfp.lib_psgc_locations city ON city.PSGC_CODE = (lp.MUNICIPALITY_CODE * POWER( 10, 3 ))
         LEFT JOIN rpfp.lib_psgc_locations prov ON prov.PSGC_CODE = (lp.PROVINCE_CODE * POWER( 10, 5 ))
         LEFT JOIN rpfp.user_profile up ON up.DB_USER_ID = rc.DB_USER_ID
             WHERE rc.CLASS_NUMBER = class_num
               AND apc.IS_ACTIVE = status_active
               AND (   rc.DB_USER_ID = name_user
                   OR (   is_not_encoder
                      AND user_location = (rc.BARANGAY_ID DIV POWER( 10, multiplier ))
                    )
                )
               AND (
                        ic.FNAME LIKE CONCAT('%',couples_name,'%')
                     OR ic.LNAME LIKE CONCAT('%',couples_name,'%')
                )
               AND ic.AGE >= search_age_from
               AND ic.AGE <= search_age_to
               AND apc.NO_CHILDREN >= search_child_from
               AND apc.NO_CHILDREN <= search_child_to
               AND fs.IS_PROVIDED_SERVICE = 1
               AND (   
                        fd.TFP_TYPE_ID <= 5
                     OR fd.TFP_STATUS_ID = 'A'
                )
       ORDER BY apc.COUPLES_ID ASC
            ; 
        END IF;
        LEAVE proc_exit_point;
    END IF;
        
    IF search_status = 4 THEN
        IF tfp_used > 0 THEN
            CALL rpfp.get_couples_list_shifters(
            class_num,
            couples_name,
            search_age_from,
            search_age_to,
            no_child,
            mfp_used,
            tfp_used,
            intention_status,
            intention_use,
            status_active,
            search_status
            );
            LEAVE proc_exit_point;
        END IF;
        
        IF mfp_used > 0 THEN
            CALL rpfp.get_couples_list_shifters(
            class_num,
            couples_name,
            search_age_from,
            search_age_to,
            no_child,
            mfp_used,
            tfp_used,
            intention_status,
            intention_use,
            status_active,
            search_status
            );
            LEAVE proc_exit_point;
        END IF;
        
        IF NOT EXISTS (
              SELECT rc.RPFP_CLASS_ID
                FROM rpfp.RPFP_CLASS rc
           LEFT JOIN rpfp.couples apc
                  ON apc.RPFP_CLASS_ID = rc.RPFP_CLASS_ID
               WHERE apc.IS_ACTIVE = status_active
                 AND (   
                            rc.DB_USER_ID = name_user
                         OR (   is_not_encoder
                        AND user_location = (rc.BARANGAY_ID DIV POWER( 10, multiplier ))
                    )
                )
        ) THEN
         SELECT NULL AS class_no,
                NULL AS couplesid,
                NULL AS isactive,
                NULL AS date_encode,
                NULL AS lastname,
                NULL AS firstname,
                NULL AS middle,
                NULL AS ext_name
        ;
    ELSE
         SELECT rc.CLASS_NUMBER AS class_no,
                apc.COUPLES_ID AS couplesid,
                apc.IS_ACTIVE AS isactive,
                apc.DATE_ENCODED AS date_encode,
                ic.LNAME AS lastname,
                ic.FNAME AS firstname,
                ic.MNAME AS middle,
                ic.EXT_NAME AS ext_name
              FROM rpfp.rpfp_class rc 
         LEFT JOIN rpfp.couples apc ON apc.RPFP_CLASS_ID = rc.RPFP_CLASS_ID
         LEFT JOIN rpfp.individual ic ON ic.COUPLES_ID = apc.COUPLES_ID
         LEFT JOIN rpfp.fp_details fd ON fd.COUPLES_ID = ic.COUPLES_ID
         LEFT JOIN rpfp.lib_psgc_locations lp ON lp.PSGC_CODE = rc.BARANGAY_ID
         LEFT JOIN rpfp.lib_psgc_locations city ON city.PSGC_CODE = (lp.MUNICIPALITY_CODE * POWER( 10, 3 ))
         LEFT JOIN rpfp.lib_psgc_locations prov ON prov.PSGC_CODE = (lp.PROVINCE_CODE * POWER( 10, 5 ))
         LEFT JOIN rpfp.user_profile up ON up.DB_USER_ID = rc.DB_USER_ID
             WHERE rc.CLASS_NUMBER = class_num
               AND apc.IS_ACTIVE = status_active
               AND (   
                            rc.DB_USER_ID = name_user
                         OR (   is_not_encoder
                        AND user_location = (rc.BARANGAY_ID DIV POWER( 10, multiplier ))
                    )
                )
               AND (
                        ic.FNAME LIKE CONCAT('%',couples_name,'%')
                     OR ic.LNAME LIKE CONCAT('%',couples_name,'%')
                )
               AND ic.AGE >= search_age_from
               AND ic.AGE <= search_age_to
               AND apc.NO_CHILDREN >= search_child_from
               AND apc.NO_CHILDREN <= search_child_to
               AND fd.MFP_INTENTION_SHIFT_ID >= 1
       ORDER BY apc.COUPLES_ID ASC
            ; 
        END IF;
        LEAVE proc_exit_point;
    END IF;
        
    IF search_status = 5 THEN
        IF tfp_used > 0 THEN
            CALL rpfp.get_couples_list_served_shifters(
            class_num,
            couples_name,
            search_age_from,
            search_age_to,
            no_child,
            mfp_used,
            tfp_used,
            intention_status,
            intention_use,
            status_active,
            search_status
            );
            LEAVE proc_exit_point;
        END IF;
        
        IF mfp_used > 0 THEN
            CALL rpfp.get_couples_list_served_shifters(
            class_num,
            couples_name,
            search_age_from,
            search_age_to,
            no_child,
            mfp_used,
            tfp_used,
            intention_status,
            intention_use,
            status_active,
            search_status
            );
            LEAVE proc_exit_point;
        END IF;
        
        IF NOT EXISTS (
             SELECT rc.RPFP_CLASS_ID
               FROM rpfp.RPFP_CLASS rc
          LEFT JOIN rpfp.couples apc
                 ON apc.RPFP_CLASS_ID = rc.RPFP_CLASS_ID
              WHERE apc.IS_ACTIVE = status_active
                AND (   
                            rc.DB_USER_ID = name_user
                         OR (   is_not_encoder
                        AND user_location = (rc.BARANGAY_ID DIV POWER( 10, multiplier ))
                    )
                )
        ) THEN
         SELECT NULL AS class_no,
                NULL AS couplesid,
                NULL AS isactive,
                NULL AS date_encode,
                NULL AS lastname,
                NULL AS firstname,
                NULL AS middle,
                NULL AS ext_name
        ;
    ELSE
         SELECT rc.CLASS_NUMBER AS class_no,
                apc.COUPLES_ID AS couplesid,
                apc.IS_ACTIVE AS isactive,
                apc.DATE_ENCODED AS date_encode,
                ic.LNAME AS lastname,
                ic.FNAME AS firstname,
                ic.MNAME AS middle,
                ic.EXT_NAME AS ext_name
              FROM rpfp.rpfp_class rc 
         LEFT JOIN rpfp.couples apc ON apc.RPFP_CLASS_ID = rc.RPFP_CLASS_ID
         LEFT JOIN rpfp.individual ic ON ic.COUPLES_ID = apc.COUPLES_ID
         LEFT JOIN rpfp.fp_details fd ON fd.COUPLES_ID = ic.COUPLES_ID
         LEFT JOIN rpfp.fp_service fs ON fs.COUPLES_ID = apc.COUPLES_ID
             WHERE rc.CLASS_NUMBER = class_num
               AND apc.IS_ACTIVE = status_active
               AND (   rc.DB_USER_ID = name_user
                   OR (   is_not_encoder
                      AND user_location = (rc.BARANGAY_ID DIV POWER( 10, multiplier ))
                    )
                )
               AND (
                        ic.FNAME LIKE CONCAT('%',couples_name,'%')
                     OR ic.LNAME LIKE CONCAT('%',couples_name,'%')
                )
               AND ic.AGE >= search_age_from
               AND ic.AGE <= search_age_to
               AND apc.NO_CHILDREN >= search_child_from
               AND apc.NO_CHILDREN <= search_child_to
               AND fs.IS_PROVIDED_SERVICE = 1
               AND fd.MFP_INTENTION_SHIFT_ID >= 1
       ORDER BY apc.COUPLES_ID ASC
            ; 
        END IF;
        LEAVE proc_exit_point;
    END IF;
END$$

CREATE DEFINER=root@localhost PROCEDURE get_couples_list_all (
    IN class_num VARCHAR(50),
    IN couples_name VARCHAR(100),
    IN search_age_from INT,
    IN search_age_to INT,
    IN no_child INT,
    IN mfp_used INT,
    IN tfp_used INT,
    IN intention_status VARCHAR(10),
    IN intention_use INT,
    IN status_active INT,
    IN search_status INT
    )   READS SQL DATA
proc_exit_point :
BEGIN
    DECLARE type_class_range INT;
    DECLARE search_child_from INT;
    DECLARE search_child_to INT;
    DECLARE search_mfp_from INT;
    DECLARE search_mfp_to INT;
    DECLARE search_tfp_from INT;
    DECLARE search_tfp_to INT;
    DECLARE search_intention_from INT;
    DECLARE search_intention_to INT;
    DECLARE search_intentionfp_from INT;
    DECLARE search_intentionfp_to INT;
    /** 
    SEARCH STATUS
        1 - unmet need
        2 - served unmet need
        3 - shifters
        4 - served shifters
    */
    DECLARE name_user VARCHAR(50);
    DECLARE db_user_name VARCHAR(50);
    DECLARE read_offset INT;
    DECLARE user_scope INT;
    DECLARE user_location INT;
    DECLARE multiplier INT;
    DECLARE is_not_encoder INT(1);
    
    CALL rpfp.lib_extract_user_name( USER(), name_user, db_user_name );
    SET user_scope := rpfp.profile_get_scope( name_user );
    SET multiplier := rpfp.lib_get_multiplier( user_scope );
    SET user_location := rpfp.profile_get_location( name_user, user_scope );
    SET is_not_encoder := NOT IFNULL(rpfp.profile_check_if_encoder(), FALSE);

    IF (IFNULL( no_child, 0 ) = 0) THEN
        SET search_child_from = 0;
        SET search_child_to = 200;
    END IF;

IF ( IFNULL( tfp_used, 0 ) = 0 ) THEN
    IF NOT EXISTS (
         SELECT rc.RPFP_CLASS_ID
           FROM rpfp.RPFP_CLASS rc
      LEFT JOIN rpfp.couples apc
             ON apc.RPFP_CLASS_ID = rc.RPFP_CLASS_ID
          WHERE apc.IS_ACTIVE = status_active
            AND (   rc.DB_USER_ID = name_user
                OR (   is_not_encoder
                    AND user_location = (rc.BARANGAY_ID DIV POWER( 10, multiplier ))
                )
            )
    ) THEN
         SELECT NULL AS class_no,
                NULL AS couplesid,
                NULL AS isactive,
                NULL AS date_encode,
                NULL AS lastname,
                NULL AS firstname,
                NULL AS middle,
                NULL AS ext_name
        ;
    ELSE
         SELECT rc.CLASS_NUMBER AS class_no,
                apc.COUPLES_ID AS couplesid,
                apc.IS_ACTIVE AS isactive,
                apc.DATE_ENCODED AS date_encode,
                ic.LNAME AS lastname,
                ic.FNAME AS firstname,
                ic.MNAME AS middle,
                ic.EXT_NAME AS ext_name
           FROM rpfp.couples apc
      LEFT JOIN rpfp.rpfp_class rc
             ON rc.RPFP_CLASS_ID = apc.RPFP_CLASS_ID
         LEFT JOIN rpfp.individual ic ON ic.COUPLES_ID = apc.COUPLES_ID
         LEFT JOIN rpfp.fp_details fd ON fd.COUPLES_ID = apc.COUPLES_ID
             WHERE rc.CLASS_NUMBER = class_num
               AND apc.IS_ACTIVE = status_active
               AND (   rc.DB_USER_ID = name_user
                   OR (   is_not_encoder
                      AND user_location = (rc.BARANGAY_ID DIV POWER( 10, multiplier ))
                    )
                )
               AND (
                        ic.FNAME LIKE CONCAT('%',couples_name,'%')
                     OR ic.LNAME LIKE CONCAT('%',couples_name,'%')
                )
               AND ic.AGE >= search_age_from
               AND ic.AGE <= search_age_to
               AND apc.NO_CHILDREN >= search_child_from
               AND apc.NO_CHILDREN <= search_child_to
               AND fd.MFP_METHOD_USED_ID = mfp_used
       ORDER BY apc.COUPLES_ID ASC
        ; 
    END IF;
    LEAVE proc_exit_point;
END IF;

IF intention_status = 'A' THEN
    IF NOT EXISTS (
         SELECT rc.RPFP_CLASS_ID
           FROM rpfp.RPFP_CLASS rc
      LEFT JOIN rpfp.couples apc
             ON apc.RPFP_CLASS_ID = rc.RPFP_CLASS_ID
          WHERE apc.IS_ACTIVE = status_active
            AND rc.DB_USER_ID = name_user
    ) THEN
         SELECT NULL AS class_no,
                NULL AS couplesid,
                NULL AS isactive,
                NULL AS date_encode,
                NULL AS lastname,
                NULL AS firstname,
                NULL AS middle,
                NULL AS ext_name
        ;
    ELSE
        IF (IFNULL( intention_use, 0 ) = 0) THEN
            SET search_intention_from = intention_use;
            SET search_intention_to = intention_use;
        ELSE
            SET search_intention_from = '1';
            SET search_intention_to = '12';
        END IF;

         SELECT rc.CLASS_NUMBER AS class_no,
                apc.COUPLES_ID AS couplesid,
                apc.IS_ACTIVE AS isactive,
                apc.DATE_ENCODED AS date_encode,
                ic.LNAME AS lastname,
                ic.FNAME AS firstname,
                ic.MNAME AS middle,
                ic.EXT_NAME AS ext_name
           FROM rpfp.couples apc
      LEFT JOIN rpfp.rpfp_class rc
             ON rc.RPFP_CLASS_ID = apc.RPFP_CLASS_ID
         LEFT JOIN rpfp.individual ic ON ic.COUPLES_ID = apc.COUPLES_ID
         LEFT JOIN rpfp.fp_details fd ON fd.COUPLES_ID = ic.COUPLES_ID
             WHERE rc.CLASS_NUMBER = class_num
               AND apc.IS_ACTIVE = status_active
               AND (   rc.DB_USER_ID = name_user
                    OR (   is_not_encoder
                        AND user_location = (rc.BARANGAY_ID DIV POWER( 10, multiplier ))
                    )
                )
               AND (
                        ic.FNAME LIKE CONCAT('%',couples_name,'%')
                    OR ic.LNAME LIKE CONCAT('%',couples_name,'%')
                )
               AND ic.AGE >= search_age_from
               AND ic.AGE <= search_age_to
               AND apc.NO_CHILDREN >= search_child_from
               AND apc.NO_CHILDREN <= search_child_to
               AND fd.TFP_TYPE_ID = tfp_used
               AND fd.TFP_STATUS_ID = 'A'
               AND fd.MFP_INTENTION_USE_ID >= search_intentionfp_from
               AND fd.MFP_INTENTION_USE_ID <= search_intentionfp_to
       ORDER BY apc.COUPLES_ID ASC
        ; 
    END IF;
ELSE
    IF NOT EXISTS (
         SELECT rc.RPFP_CLASS_ID
           FROM rpfp.RPFP_CLASS rc
      LEFT JOIN rpfp.couples apc
             ON apc.RPFP_CLASS_ID = rc.RPFP_CLASS_ID
          WHERE apc.IS_ACTIVE = status_active
            AND (   rc.DB_USER_ID = name_user
                OR (   is_not_encoder
                    AND user_location = (rc.BARANGAY_ID DIV POWER( 10, multiplier ))
                )
            )
    ) THEN
         SELECT NULL AS class_no,
                NULL AS couplesid,
                NULL AS isactive,
                NULL AS date_encode,
                NULL AS lastname,
                NULL AS firstname,
                NULL AS middle,
                NULL AS ext_name
        ;
    ELSE
         SELECT rc.CLASS_NUMBER AS class_no,
                apc.COUPLES_ID AS couplesid,
                apc.IS_ACTIVE AS isactive,
                apc.DATE_ENCODED AS date_encode,
                ic.LNAME AS lastname,
                ic.FNAME AS firstname,
                ic.MNAME AS middle,
                ic.EXT_NAME AS ext_name
           FROM rpfp.couples apc
      LEFT JOIN rpfp.rpfp_class rc
             ON rc.RPFP_CLASS_ID = apc.RPFP_CLASS_ID
         LEFT JOIN rpfp.individual ic ON ic.COUPLES_ID = apc.COUPLES_ID
         LEFT JOIN rpfp.fp_details fd ON fd.COUPLES_ID = ic.COUPLES_ID
             WHERE rc.CLASS_NUMBER = class_num
               AND apc.IS_ACTIVE = status_active
               AND (   rc.DB_USER_ID = name_user
                    OR (   is_not_encoder
                        AND user_location = (rc.BARANGAY_ID DIV POWER( 10, multiplier ))
                        )
                    )
               AND (
                        ic.FNAME LIKE CONCAT('%',couples_name,'%')
                    OR ic.LNAME LIKE CONCAT('%',couples_name,'%')
                )
               AND ic.AGE >= search_age_from
               AND ic.AGE <= search_age_to
               AND apc.NO_CHILDREN >= search_child_from
               AND apc.NO_CHILDREN <= search_child_to
               AND fd.TFP_TYPE_ID = tfp_used
               AND fd.TFP_STATUS_ID LIKE CONCAT('%',intention_status,'%')
       ORDER BY apc.COUPLES_ID ASC
        ; 
    END IF;
END IF;
END$$

CREATE DEFINER=root@localhost PROCEDURE get_couples_list_unmet (
    IN class_num VARCHAR(50),
    IN couples_name VARCHAR(100),
    IN search_age_from INT,
    IN search_age_to INT,
    IN no_child INT,
    IN mfp_used INT,
    IN tfp_used INT,
    IN intention_status VARCHAR(10),
    IN intention_use INT,
    IN status_active INT,
    IN search_status INT
    )   READS SQL DATA
    proc_exit_point :
BEGIN
    DECLARE type_class_range INT;
    DECLARE search_child_from INT;
    DECLARE search_child_to INT;
    DECLARE search_mfp_from INT;
    DECLARE search_mfp_to INT;
    DECLARE search_tfp_from INT;
    DECLARE search_tfp_to INT;
    DECLARE search_intention_from INT;
    DECLARE search_intention_to INT;
    DECLARE search_intentionfp_from INT;
    DECLARE search_intentionfp_to INT;
    /** 
    SEARCH STATUS
        1 - unmet need
        2 - served unmet need
        3 - shifters
        4 - served shifters
    */
    DECLARE name_user VARCHAR(50);
    DECLARE db_user_name VARCHAR(50);
    DECLARE read_offset INT;
    DECLARE user_scope INT;
    DECLARE user_location INT;
    DECLARE multiplier INT;
    DECLARE is_not_encoder INT(1);
    
    CALL rpfp.lib_extract_user_name( USER(), name_user, db_user_name );
    SET user_scope := rpfp.profile_get_scope( name_user );
    SET multiplier := rpfp.lib_get_multiplier( user_scope );
    SET user_location := rpfp.profile_get_location( name_user, user_scope );
    SET is_not_encoder := NOT IFNULL(rpfp.profile_check_if_encoder(), FALSE);

    IF (IFNULL( no_child, 0 ) = 0) THEN
        SET search_child_from = 0;
        SET search_child_to = 200;
    END IF;
    
    IF search_age_from < 15 THEN
        SET search_age_from = 15;
    END IF;

    IF search_age_to > 49 THEN
        SET search_age_to = 49;
    END IF;
        
IF ( IFNULL( tfp_used, 0 ) = 0 ) THEN
    IF NOT EXISTS (
         SELECT rc.RPFP_CLASS_ID
           FROM rpfp.RPFP_CLASS rc
      LEFT JOIN rpfp.couples apc
             ON apc.RPFP_CLASS_ID = rc.RPFP_CLASS_ID
          WHERE apc.IS_ACTIVE = status_active
            AND (   rc.DB_USER_ID = name_user
                OR (   is_not_encoder
                    AND user_location = (rc.BARANGAY_ID DIV POWER( 10, multiplier ))
                )
            )
    ) THEN
         SELECT NULL AS class_no,
                NULL AS couplesid,
                NULL AS isactive,
                NULL AS date_encode,
                NULL AS lastname,
                NULL AS firstname,
                NULL AS middle,
                NULL AS ext_name
        ;
    ELSE
         SELECT rc.CLASS_NUMBER AS class_no,
                apc.COUPLES_ID AS couplesid,
                apc.IS_ACTIVE AS isactive,
                apc.DATE_ENCODED AS date_encode,
                ic.LNAME AS lastname,
                ic.FNAME AS firstname,
                ic.MNAME AS middle,
                ic.EXT_NAME AS ext_name
           FROM rpfp.couples apc
      LEFT JOIN rpfp.rpfp_class rc
             ON rc.RPFP_CLASS_ID = apc.RPFP_CLASS_ID
         LEFT JOIN rpfp.individual ic ON ic.COUPLES_ID = apc.COUPLES_ID
         LEFT JOIN rpfp.fp_details fd ON fd.COUPLES_ID = ic.COUPLES_ID
             WHERE rc.CLASS_NUMBER = class_num
               AND apc.IS_ACTIVE = status_active
               AND (   rc.DB_USER_ID = name_user
                   OR (   is_not_encoder
                      AND user_location = (rc.BARANGAY_ID DIV POWER( 10, multiplier ))
                    )
                )
               AND (
                        ic.FNAME LIKE CONCAT('%',couples_name,'%')
                     OR ic.LNAME LIKE CONCAT('%',couples_name,'%')
                )
               AND ic.AGE >= search_age_from
               AND ic.AGE <= search_age_to
               AND apc.NO_CHILDREN >= search_child_from
               AND apc.NO_CHILDREN <= search_child_to
            AND (   
                   fd.TFP_TYPE_ID <= 5
                OR fd.TFP_STATUS_ID = 'A'
                )
               AND fd.MFP_METHOD_USED_ID = mfp_used
       ORDER BY apc.COUPLES_ID ASC
        ; 
    END IF;
    LEAVE proc_exit_point;
END IF;

IF intention_status = 'A' THEN
    IF NOT EXISTS (
         SELECT rc.RPFP_CLASS_ID
           FROM rpfp.RPFP_CLASS rc
      LEFT JOIN rpfp.couples apc
             ON apc.RPFP_CLASS_ID = rc.RPFP_CLASS_ID
          WHERE apc.IS_ACTIVE = status_active
            AND rc.DB_USER_ID = name_user
    ) THEN
         SELECT NULL AS class_no,
                NULL AS couplesid,
                NULL AS isactive,
                NULL AS date_encode,
                NULL AS lastname,
                NULL AS firstname,
                NULL AS middle,
                NULL AS ext_name
        ;
    ELSE
        IF (IFNULL( intention_use, 0 ) = 0) THEN
            SET search_intention_from = intention_use;
            SET search_intention_to = intention_use;
        ELSE
            SET search_intention_from = '1';
            SET search_intention_to = '12';
        END IF;

         SELECT rc.CLASS_NUMBER AS class_no,
                apc.COUPLES_ID AS couplesid,
                apc.IS_ACTIVE AS isactive,
                apc.DATE_ENCODED AS date_encode,
                ic.LNAME AS lastname,
                ic.FNAME AS firstname,
                ic.MNAME AS middle,
                ic.EXT_NAME AS ext_name
           FROM rpfp.couples apc
      LEFT JOIN rpfp.rpfp_class rc
             ON rc.RPFP_CLASS_ID = apc.RPFP_CLASS_ID
         LEFT JOIN rpfp.individual ic ON ic.COUPLES_ID = apc.COUPLES_ID
         LEFT JOIN rpfp.fp_details fd ON fd.COUPLES_ID = ic.COUPLES_ID
             WHERE rc.CLASS_NUMBER = class_num
               AND apc.IS_ACTIVE = status_active
               AND (   rc.DB_USER_ID = name_user
                    OR (   is_not_encoder
                        AND user_location = (rc.BARANGAY_ID DIV POWER( 10, multiplier ))
                    )
                )
               AND (
                        ic.FNAME LIKE CONCAT('%',couples_name,'%')
                    OR ic.LNAME LIKE CONCAT('%',couples_name,'%')
                )
               AND ic.AGE >= search_age_from
               AND ic.AGE <= search_age_to
               AND apc.NO_CHILDREN >= search_child_from
               AND apc.NO_CHILDREN <= search_child_to
               AND (   
                       fd.TFP_TYPE_ID <= 5
                    OR fd.TFP_STATUS_ID = 'A'
                )
               AND fd.TFP_TYPE_ID = tfp_used
               AND fd.TFP_STATUS_ID = 'A'
               AND fd.MFP_INTENTION_USE_ID >= search_intentionfp_from
               AND fd.MFP_INTENTION_USE_ID <= search_intentionfp_to
       ORDER BY apc.COUPLES_ID ASC
        ; 
    END IF;
ELSE
    IF NOT EXISTS (
         SELECT rc.RPFP_CLASS_ID
           FROM rpfp.RPFP_CLASS rc
      LEFT JOIN rpfp.couples apc
             ON apc.RPFP_CLASS_ID = rc.RPFP_CLASS_ID
          WHERE apc.IS_ACTIVE = status_active
            AND (   rc.DB_USER_ID = name_user
                OR (   is_not_encoder
                    AND user_location = (rc.BARANGAY_ID DIV POWER( 10, multiplier ))
                )
            )
    ) THEN
         SELECT NULL AS class_no,
                NULL AS couplesid,
                NULL AS isactive,
                NULL AS date_encode,
                NULL AS lastname,
                NULL AS firstname,
                NULL AS middle,
                NULL AS ext_name
        ;
    ELSE
         SELECT rc.CLASS_NUMBER AS class_no,
                apc.COUPLES_ID AS couplesid,
                apc.IS_ACTIVE AS isactive,
                apc.DATE_ENCODED AS date_encode,
                ic.LNAME AS lastname,
                ic.FNAME AS firstname,
                ic.MNAME AS middle,
                ic.EXT_NAME AS ext_name
           FROM rpfp.couples apc
      LEFT JOIN rpfp.rpfp_class rc
             ON rc.RPFP_CLASS_ID = apc.RPFP_CLASS_ID
         LEFT JOIN rpfp.individual ic ON ic.COUPLES_ID = apc.COUPLES_ID
         LEFT JOIN rpfp.fp_details fd ON fd.COUPLES_ID = ic.COUPLES_ID
             WHERE rc.CLASS_NUMBER = class_num
               AND apc.IS_ACTIVE = status_active
               AND (   rc.DB_USER_ID = name_user
                    OR (   is_not_encoder
                        AND user_location = (rc.BARANGAY_ID DIV POWER( 10, multiplier ))
                        )
                    )
               AND (
                       ic.FNAME LIKE CONCAT('%',couples_name,'%')
                    OR ic.LNAME LIKE CONCAT('%',couples_name,'%')
                )
               AND ic.AGE >= search_age_from
               AND ic.AGE <= search_age_to
               AND apc.NO_CHILDREN >= search_child_from
               AND apc.NO_CHILDREN <= search_child_to
               AND (   
                       fd.TFP_TYPE_ID <= 5
                    OR fd.TFP_STATUS_ID = 'A'
                )
               AND fd.TFP_TYPE_ID = tfp_used
               AND fd.TFP_STATUS_ID LIKE CONCAT('%',intention_status,'%')
       ORDER BY apc.COUPLES_ID ASC
        ; 
    END IF;
END IF;
END$$

CREATE DEFINER=root@localhost PROCEDURE get_couples_list_served_unmet (
    IN class_num VARCHAR(50),
    IN couples_name VARCHAR(100),
    IN search_age_from INT,
    IN search_age_to INT,
    IN no_child INT,
    IN mfp_used INT,
    IN tfp_used INT,
    IN intention_status VARCHAR(10),
    IN intention_use INT,
    IN status_active INT,
    IN search_status INT
    )   READS SQL DATA
    proc_exit_point :
BEGIN
    DECLARE type_class_range INT;
    DECLARE search_child_from INT;
    DECLARE search_child_to INT;
    DECLARE search_mfp_from INT;
    DECLARE search_mfp_to INT;
    DECLARE search_tfp_from INT;
    DECLARE search_tfp_to INT;
    DECLARE search_intention_from INT;
    DECLARE search_intention_to INT;
    DECLARE search_intentionfp_from INT;
    DECLARE search_intentionfp_to INT;
    /** 
    SEARCH STATUS
        1 - unmet need
        2 - served unmet need
        3 - shifters
        4 - served shifters
    */
    DECLARE name_user VARCHAR(50);
    DECLARE db_user_name VARCHAR(50);
    DECLARE read_offset INT;
    DECLARE user_scope INT;
    DECLARE user_location INT;
    DECLARE multiplier INT;
    DECLARE is_not_encoder INT(1);
    
    CALL rpfp.lib_extract_user_name( USER(), name_user, db_user_name );
    SET user_scope := rpfp.profile_get_scope( name_user );
    SET multiplier := rpfp.lib_get_multiplier( user_scope );
    SET user_location := rpfp.profile_get_location( name_user, user_scope );
    SET is_not_encoder := NOT IFNULL(rpfp.profile_check_if_encoder(), FALSE);

    IF (IFNULL( no_child, 0 ) = 0) THEN
        SET search_child_from = 0;
        SET search_child_to = 200;
    END IF;

    IF search_age_from < 15 THEN
        SET search_age_from = 15;
    END IF;

    IF search_age_to > 49 THEN
        SET search_age_to = 49;
    END IF;
    
IF ( IFNULL( tfp_used, 0 ) = 0 ) THEN
    IF NOT EXISTS (
         SELECT rc.RPFP_CLASS_ID
           FROM rpfp.RPFP_CLASS rc
      LEFT JOIN rpfp.couples apc
             ON apc.RPFP_CLASS_ID = rc.RPFP_CLASS_ID
          WHERE apc.IS_ACTIVE = status_active
            AND (   rc.DB_USER_ID = name_user
                OR (   is_not_encoder
                    AND user_location = (rc.BARANGAY_ID DIV POWER( 10, multiplier ))
                )
            )
    ) THEN
         SELECT NULL AS class_no,
                NULL AS couplesid,
                NULL AS isactive,
                NULL AS date_encode,
                NULL AS lastname,
                NULL AS firstname,
                NULL AS middle,
                NULL AS ext_name
        ;
    ELSE
         SELECT rc.CLASS_NUMBER AS class_no,
                apc.COUPLES_ID AS couplesid,
                apc.IS_ACTIVE AS isactive,
                apc.DATE_ENCODED AS date_encode,
                ic.LNAME AS lastname,
                ic.FNAME AS firstname,
                ic.MNAME AS middle,
                ic.EXT_NAME AS ext_name
           FROM rpfp.couples apc
      LEFT JOIN rpfp.rpfp_class rc
             ON rc.RPFP_CLASS_ID = apc.RPFP_CLASS_ID
         LEFT JOIN rpfp.individual ic ON ic.COUPLES_ID = apc.COUPLES_ID
         LEFT JOIN rpfp.fp_details fd ON fd.COUPLES_ID = ic.COUPLES_ID
         LEFT JOIN rpfp.fp_service fs ON fs.COUPLES_ID = apc.COUPLES_ID
             WHERE rc.CLASS_NUMBER = class_num
               AND apc.IS_ACTIVE = status_active
               AND (   rc.DB_USER_ID = name_user
                   OR (   is_not_encoder
                      AND user_location = (rc.BARANGAY_ID DIV POWER( 10, multiplier ))
                    )
                )
               AND (
                        ic.FNAME LIKE CONCAT('%',couples_name,'%')
                     OR ic.LNAME LIKE CONCAT('%',couples_name,'%')
                )
               AND ic.AGE >= search_age_from
               AND ic.AGE <= search_age_to
               AND apc.NO_CHILDREN >= search_child_from
               AND apc.NO_CHILDREN <= search_child_to
               AND fs.IS_PROVIDED_SERVICE = 1
               AND (   
                        fd.TFP_TYPE_ID <= 5
                     OR fd.TFP_STATUS_ID = 'A'
                )
               AND fd.MFP_METHOD_USED_ID = mfp_used
       ORDER BY apc.COUPLES_ID ASC
        ; 
    END IF;
    LEAVE proc_exit_point;
END IF;

IF intention_status = 'A' THEN
    IF NOT EXISTS (
         SELECT rc.RPFP_CLASS_ID
           FROM rpfp.RPFP_CLASS rc
      LEFT JOIN rpfp.couples apc
             ON apc.RPFP_CLASS_ID = rc.RPFP_CLASS_ID
          WHERE apc.IS_ACTIVE = status_active
            AND rc.DB_USER_ID = name_user
    ) THEN
         SELECT NULL AS class_no,
                NULL AS couplesid,
                NULL AS isactive,
                NULL AS date_encode,
                NULL AS lastname,
                NULL AS firstname,
                NULL AS middle,
                NULL AS ext_name
        ;
    ELSE
        IF (IFNULL( intention_use, 0 ) = 0) THEN
            SET search_intention_from = intention_use;
            SET search_intention_to = intention_use;
        ELSE
            SET search_intention_from = '1';
            SET search_intention_to = '12';
        END IF;

         SELECT rc.CLASS_NUMBER AS class_no,
                apc.COUPLES_ID AS couplesid,
                apc.IS_ACTIVE AS isactive,
                apc.DATE_ENCODED AS date_encode,
                ic.LNAME AS lastname,
                ic.FNAME AS firstname,
                ic.MNAME AS middle,
                ic.EXT_NAME AS ext_name
           FROM rpfp.couples apc
      LEFT JOIN rpfp.rpfp_class rc
             ON rc.RPFP_CLASS_ID = apc.RPFP_CLASS_ID
         LEFT JOIN rpfp.individual ic ON ic.COUPLES_ID = apc.COUPLES_ID
         LEFT JOIN rpfp.fp_details fd ON fd.COUPLES_ID = ic.COUPLES_ID
          LEFT JOIN rpfp.fp_service fs ON fs.COUPLES_ID = apc.COUPLES_ID
             WHERE rc.CLASS_NUMBER = class_num
               AND apc.IS_ACTIVE = status_active
               AND (   rc.DB_USER_ID = name_user
                    OR (   is_not_encoder
                        AND user_location = (rc.BARANGAY_ID DIV POWER( 10, multiplier ))
                    )
                )
               AND (
                        ic.FNAME LIKE CONCAT('%',couples_name,'%')
                    OR ic.LNAME LIKE CONCAT('%',couples_name,'%')
                )
               AND ic.AGE >= search_age_from
               AND ic.AGE <= search_age_to
               AND apc.NO_CHILDREN >= search_child_from
               AND apc.NO_CHILDREN <= search_child_to
               AND fs.IS_PROVIDED_SERVICE = 1
               AND (   
                        fd.TFP_TYPE_ID <= 5
                     OR fd.TFP_STATUS_ID = 'A'
                )
               AND fd.TFP_TYPE_ID = tfp_used
               AND fd.TFP_STATUS_ID = 'A'
               AND fd.MFP_INTENTION_USE_ID >= search_intentionfp_from
               AND fd.MFP_INTENTION_USE_ID <= search_intentionfp_to
       ORDER BY apc.COUPLES_ID ASC
        ; 
    END IF;
ELSE
    IF NOT EXISTS (
         SELECT rc.RPFP_CLASS_ID
           FROM rpfp.RPFP_CLASS rc
      LEFT JOIN rpfp.couples apc
             ON apc.RPFP_CLASS_ID = rc.RPFP_CLASS_ID
          WHERE apc.IS_ACTIVE = status_active
            AND (   rc.DB_USER_ID = name_user
                OR (   is_not_encoder
                    AND user_location = (rc.BARANGAY_ID DIV POWER( 10, multiplier ))
                )
            )
    ) THEN
         SELECT NULL AS class_no,
                NULL AS couplesid,
                NULL AS isactive,
                NULL AS date_encode,
                NULL AS lastname,
                NULL AS firstname,
                NULL AS middle,
                NULL AS ext_name
        ;
    ELSE
         SELECT rc.CLASS_NUMBER AS class_no,
                apc.COUPLES_ID AS couplesid,
                apc.IS_ACTIVE AS isactive,
                apc.DATE_ENCODED AS date_encode,
                ic.LNAME AS lastname,
                ic.FNAME AS firstname,
                ic.MNAME AS middle,
                ic.EXT_NAME AS ext_name
           FROM rpfp.couples apc
      LEFT JOIN rpfp.rpfp_class rc
             ON rc.RPFP_CLASS_ID = apc.RPFP_CLASS_ID
         LEFT JOIN rpfp.individual ic ON ic.COUPLES_ID = apc.COUPLES_ID
         LEFT JOIN rpfp.fp_details fd ON fd.COUPLES_ID = ic.COUPLES_ID
          LEFT JOIN rpfp.fp_service fs ON fs.COUPLES_ID = apc.COUPLES_ID
             WHERE rc.CLASS_NUMBER = class_num
               AND apc.IS_ACTIVE = status_active
               AND (   rc.DB_USER_ID = name_user
                    OR (   is_not_encoder
                        AND user_location = (rc.BARANGAY_ID DIV POWER( 10, multiplier ))
                        )
                    )
               AND (
                        ic.FNAME LIKE CONCAT('%',couples_name,'%')
                    OR ic.LNAME LIKE CONCAT('%',couples_name,'%')
                )
               AND ic.AGE >= search_age_from
               AND ic.AGE <= search_age_to
               AND apc.NO_CHILDREN >= search_child_from
               AND apc.NO_CHILDREN <= search_child_to
               AND fs.IS_PROVIDED_SERVICE = 1
               AND (   
                        fd.TFP_TYPE_ID <= 5
                     OR fd.TFP_STATUS_ID = 'A'
                )
               AND fd.TFP_TYPE_ID = tfp_used
               AND fd.TFP_STATUS_ID LIKE CONCAT('%',intention_status,'%')
       ORDER BY apc.COUPLES_ID ASC
        ; 
    END IF;
END IF;
END$$

CREATE DEFINER=root@localhost PROCEDURE get_couples_list_shifters (
    IN class_num VARCHAR(50),
    IN couples_name VARCHAR(100),
    IN search_age_from INT,
    IN search_age_to INT,
    IN no_child INT,
    IN mfp_used INT,
    IN tfp_used INT,
    IN intention_status VARCHAR(10),
    IN intention_use INT,
    IN status_active INT,
    IN search_status INT
    )   READS SQL DATA
    proc_exit_point :
BEGIN
    DECLARE type_class_range INT;
    DECLARE search_child_from INT;
    DECLARE search_child_to INT;
    DECLARE search_mfp_from INT;
    DECLARE search_mfp_to INT;
    DECLARE search_tfp_from INT;
    DECLARE search_tfp_to INT;
    DECLARE search_intention_from INT;
    DECLARE search_intention_to INT;
    DECLARE search_intentionfp_from INT;
    DECLARE search_intentionfp_to INT;
    /** 
    SEARCH STATUS
        1 - unmet need
        2 - served unmet need
        3 - shifters
        4 - served shifters
    */
    DECLARE name_user VARCHAR(50);
    DECLARE db_user_name VARCHAR(50);
    DECLARE read_offset INT;
    DECLARE user_scope INT;
    DECLARE user_location INT;
    DECLARE multiplier INT;
    DECLARE is_not_encoder INT(1);
    
    CALL rpfp.lib_extract_user_name( USER(), name_user, db_user_name );
    SET user_scope := rpfp.profile_get_scope( name_user );
    SET multiplier := rpfp.lib_get_multiplier( user_scope );
    SET user_location := rpfp.profile_get_location( name_user, user_scope );
    SET is_not_encoder := NOT IFNULL(rpfp.profile_check_if_encoder(), FALSE);

    IF (IFNULL( no_child, 0 ) = 0) THEN
        SET search_child_from = 0;
        SET search_child_to = 200;
    END IF;

IF ( IFNULL( tfp_used, 0 ) = 0 ) THEN
    IF NOT EXISTS (
         SELECT rc.RPFP_CLASS_ID
           FROM rpfp.RPFP_CLASS rc
      LEFT JOIN rpfp.couples apc
             ON apc.RPFP_CLASS_ID = rc.RPFP_CLASS_ID
          WHERE apc.IS_ACTIVE = status_active
            AND (   rc.DB_USER_ID = name_user
                OR (   is_not_encoder
                    AND user_location = (rc.BARANGAY_ID DIV POWER( 10, multiplier ))
                )
            )
    ) THEN
         SELECT NULL AS class_no,
                NULL AS couplesid,
                NULL AS isactive,
                NULL AS date_encode,
                NULL AS lastname,
                NULL AS firstname,
                NULL AS middle,
                NULL AS ext_name
        ;
    ELSE
         SELECT rc.CLASS_NUMBER AS class_no,
                apc.COUPLES_ID AS couplesid,
                apc.IS_ACTIVE AS isactive,
                apc.DATE_ENCODED AS date_encode,
                ic.LNAME AS lastname,
                ic.FNAME AS firstname,
                ic.MNAME AS middle,
                ic.EXT_NAME AS ext_name
           FROM rpfp.couples apc
      LEFT JOIN rpfp.rpfp_class rc
             ON rc.RPFP_CLASS_ID = apc.RPFP_CLASS_ID
         LEFT JOIN rpfp.individual ic ON ic.COUPLES_ID = apc.COUPLES_ID
         LEFT JOIN rpfp.fp_details fd ON fd.COUPLES_ID = ic.COUPLES_ID
             WHERE rc.CLASS_NUMBER = class_num
               AND apc.IS_ACTIVE = status_active
               AND (   rc.DB_USER_ID = name_user
                   OR (   is_not_encoder
                      AND user_location = (rc.BARANGAY_ID DIV POWER( 10, multiplier ))
                    )
                )
               AND (
                        ic.FNAME LIKE CONCAT('%',couples_name,'%')
                     OR ic.LNAME LIKE CONCAT('%',couples_name,'%')
                )
               AND ic.AGE >= search_age_from
               AND ic.AGE <= search_age_to
               AND apc.NO_CHILDREN >= search_child_from
               AND apc.NO_CHILDREN <= search_child_to
               AND fd.MFP_INTENTION_SHIFT_ID >= 1
               AND fd.MFP_METHOD_USED_ID = mfp_used
       ORDER BY apc.COUPLES_ID ASC
        ; 
    END IF;
    LEAVE proc_exit_point;
END IF;

IF intention_status = 'A' THEN
    IF NOT EXISTS (
         SELECT rc.RPFP_CLASS_ID
           FROM rpfp.RPFP_CLASS rc
      LEFT JOIN rpfp.couples apc
             ON apc.RPFP_CLASS_ID = rc.RPFP_CLASS_ID
          WHERE apc.IS_ACTIVE = status_active
            AND rc.DB_USER_ID = name_user
    ) THEN
         SELECT NULL AS class_no,
                NULL AS couplesid,
                NULL AS isactive,
                NULL AS date_encode,
                NULL AS lastname,
                NULL AS firstname,
                NULL AS middle,
                NULL AS ext_name
        ;
    ELSE
        IF (IFNULL( intention_use, 0 ) = 0) THEN
            SET search_intention_from = intention_use;
            SET search_intention_to = intention_use;
        ELSE
            SET search_intention_from = '1';
            SET search_intention_to = '12';
        END IF;

         SELECT rc.CLASS_NUMBER AS class_no,
                apc.COUPLES_ID AS couplesid,
                apc.IS_ACTIVE AS isactive,
                apc.DATE_ENCODED AS date_encode,
                ic.LNAME AS lastname,
                ic.FNAME AS firstname,
                ic.MNAME AS middle,
                ic.EXT_NAME AS ext_name
           FROM rpfp.couples apc
      LEFT JOIN rpfp.rpfp_class rc
             ON rc.RPFP_CLASS_ID = apc.RPFP_CLASS_ID
         LEFT JOIN rpfp.individual ic ON ic.COUPLES_ID = apc.COUPLES_ID
         LEFT JOIN rpfp.fp_details fd ON fd.COUPLES_ID = ic.COUPLES_ID
             WHERE rc.CLASS_NUMBER = class_num
               AND apc.IS_ACTIVE = status_active
               AND (   rc.DB_USER_ID = name_user
                    OR (   is_not_encoder
                        AND user_location = (rc.BARANGAY_ID DIV POWER( 10, multiplier ))
                    )
                )
               AND (
                        ic.FNAME LIKE CONCAT('%',couples_name,'%')
                    OR ic.LNAME LIKE CONCAT('%',couples_name,'%')
                )
               AND ic.AGE >= search_age_from
               AND ic.AGE <= search_age_to
               AND apc.NO_CHILDREN >= search_child_from
               AND apc.NO_CHILDREN <= search_child_to
               AND fd.MFP_INTENTION_SHIFT_ID >= 1
               AND fd.TFP_TYPE_ID = tfp_used
               AND fd.TFP_STATUS_ID = 'A'
               AND fd.MFP_INTENTION_USE_ID >= search_intentionfp_from
               AND fd.MFP_INTENTION_USE_ID <= search_intentionfp_to
       ORDER BY apc.COUPLES_ID ASC
        ; 
    END IF;
ELSE
    IF NOT EXISTS (
         SELECT rc.RPFP_CLASS_ID
           FROM rpfp.RPFP_CLASS rc
      LEFT JOIN rpfp.couples apc
             ON apc.RPFP_CLASS_ID = rc.RPFP_CLASS_ID
          WHERE apc.IS_ACTIVE = status_active
            AND (   rc.DB_USER_ID = name_user
                OR (   is_not_encoder
                    AND user_location = (rc.BARANGAY_ID DIV POWER( 10, multiplier ))
                )
            )
    ) THEN
         SELECT NULL AS class_no,
                NULL AS couplesid,
                NULL AS isactive,
                NULL AS date_encode,
                NULL AS lastname,
                NULL AS firstname,
                NULL AS middle,
                NULL AS ext_name
        ;
    ELSE
         SELECT rc.CLASS_NUMBER AS class_no,
                apc.COUPLES_ID AS couplesid,
                apc.IS_ACTIVE AS isactive,
                apc.DATE_ENCODED AS date_encode,
                ic.LNAME AS lastname,
                ic.FNAME AS firstname,
                ic.MNAME AS middle,
                ic.EXT_NAME AS ext_name
           FROM rpfp.couples apc
      LEFT JOIN rpfp.rpfp_class rc
             ON rc.RPFP_CLASS_ID = apc.RPFP_CLASS_ID
         LEFT JOIN rpfp.individual ic ON ic.COUPLES_ID = apc.COUPLES_ID
         LEFT JOIN rpfp.fp_details fd ON fd.COUPLES_ID = ic.COUPLES_ID
             WHERE rc.CLASS_NUMBER = class_num
               AND apc.IS_ACTIVE = status_active
               AND (   rc.DB_USER_ID = name_user
                    OR (   is_not_encoder
                        AND user_location = (rc.BARANGAY_ID DIV POWER( 10, multiplier ))
                        )
                    )
               AND (
                        ic.FNAME LIKE CONCAT('%',couples_name,'%')
                    OR ic.LNAME LIKE CONCAT('%',couples_name,'%')
                )
               AND ic.AGE >= search_age_from
               AND ic.AGE <= search_age_to
               AND apc.NO_CHILDREN >= search_child_from
               AND apc.NO_CHILDREN <= search_child_to
               AND fd.MFP_INTENTION_SHIFT_ID >= 1
               AND fd.TFP_TYPE_ID = tfp_used
               AND fd.TFP_STATUS_ID LIKE CONCAT('%',intention_status,'%')
       ORDER BY apc.COUPLES_ID ASC
        ; 
    END IF;
END IF;
END$$

CREATE DEFINER=root@localhost PROCEDURE get_couples_list_served_shifters (
    IN class_num VARCHAR(50),
    IN couples_name VARCHAR(100),
    IN search_age_from INT,
    IN search_age_to INT,
    IN no_child INT,
    IN mfp_used INT,
    IN tfp_used INT,
    IN intention_status VARCHAR(10),
    IN intention_use INT,
    IN status_active INT,
    IN search_status INT
    )   READS SQL DATA
    proc_exit_point :
BEGIN
    DECLARE type_class_range INT;
    DECLARE search_child_from INT;
    DECLARE search_child_to INT;
    DECLARE search_mfp_from INT;
    DECLARE search_mfp_to INT;
    DECLARE search_tfp_from INT;
    DECLARE search_tfp_to INT;
    DECLARE search_intention_from INT;
    DECLARE search_intention_to INT;
    DECLARE search_intentionfp_from INT;
    DECLARE search_intentionfp_to INT;
    /** 
    SEARCH STATUS
        1 - unmet need
        2 - served unmet need
        3 - shifters
        4 - served shifters
    */
    DECLARE name_user VARCHAR(50);
    DECLARE db_user_name VARCHAR(50);
    DECLARE read_offset INT;
    DECLARE user_scope INT;
    DECLARE user_location INT;
    DECLARE multiplier INT;
    DECLARE is_not_encoder INT(1);
    
    CALL rpfp.lib_extract_user_name( USER(), name_user, db_user_name );
    SET user_scope := rpfp.profile_get_scope( name_user );
    SET multiplier := rpfp.lib_get_multiplier( user_scope );
    SET user_location := rpfp.profile_get_location( name_user, user_scope );
    SET is_not_encoder := NOT IFNULL(rpfp.profile_check_if_encoder(), FALSE);

    IF (IFNULL( no_child, 0 ) = 0) THEN
        SET search_child_from = 0;
        SET search_child_to = 200;
    END IF;

IF ( IFNULL( tfp_used, 0 ) = 0 ) THEN
    IF NOT EXISTS (
         SELECT rc.RPFP_CLASS_ID
           FROM rpfp.RPFP_CLASS rc
      LEFT JOIN rpfp.couples apc
             ON apc.RPFP_CLASS_ID = rc.RPFP_CLASS_ID
          WHERE apc.IS_ACTIVE = status_active
            AND (   rc.DB_USER_ID = name_user
                OR (   is_not_encoder
                    AND user_location = (rc.BARANGAY_ID DIV POWER( 10, multiplier ))
                )
            )
    ) THEN
         SELECT NULL AS class_no,
                NULL AS couplesid,
                NULL AS isactive,
                NULL AS date_encode,
                NULL AS lastname,
                NULL AS firstname,
                NULL AS middle,
                NULL AS ext_name
        ;
    ELSE
         SELECT rc.CLASS_NUMBER AS class_no,
                apc.COUPLES_ID AS couplesid,
                apc.IS_ACTIVE AS isactive,
                apc.DATE_ENCODED AS date_encode,
                ic.LNAME AS lastname,
                ic.FNAME AS firstname,
                ic.MNAME AS middle,
                ic.EXT_NAME AS ext_name
           FROM rpfp.couples apc
      LEFT JOIN rpfp.rpfp_class rc
             ON rc.RPFP_CLASS_ID = apc.RPFP_CLASS_ID
         LEFT JOIN rpfp.individual ic ON ic.COUPLES_ID = apc.COUPLES_ID
         LEFT JOIN rpfp.fp_details fd ON fd.COUPLES_ID = ic.COUPLES_ID
         LEFT JOIN rpfp.fp_service fs ON fs.COUPLES_ID = apc.COUPLES_ID
             WHERE rc.CLASS_NUMBER = class_num
               AND apc.IS_ACTIVE = status_active
               AND (   rc.DB_USER_ID = name_user
                   OR (   is_not_encoder
                      AND user_location = (rc.BARANGAY_ID DIV POWER( 10, multiplier ))
                    )
                )
               AND (
                        ic.FNAME LIKE CONCAT('%',couples_name,'%')
                     OR ic.LNAME LIKE CONCAT('%',couples_name,'%')
                )
               AND ic.AGE >= search_age_from
               AND ic.AGE <= search_age_to
               AND apc.NO_CHILDREN >= search_child_from
               AND apc.NO_CHILDREN <= search_child_to
               AND fd.MFP_INTENTION_SHIFT_ID >= 1
               AND fd.MFP_METHOD_USED_ID = mfp_used
       ORDER BY apc.COUPLES_ID ASC
        ; 
    END IF;
    LEAVE proc_exit_point;
END IF;

IF intention_status = 'A' THEN
    IF NOT EXISTS (
         SELECT rc.RPFP_CLASS_ID
           FROM rpfp.RPFP_CLASS rc
      LEFT JOIN rpfp.couples apc
             ON apc.RPFP_CLASS_ID = rc.RPFP_CLASS_ID
          WHERE apc.IS_ACTIVE = status_active
            AND rc.DB_USER_ID = name_user
    ) THEN
         SELECT NULL AS class_no,
                NULL AS couplesid,
                NULL AS isactive,
                NULL AS date_encode,
                NULL AS lastname,
                NULL AS firstname,
                NULL AS middle,
                NULL AS ext_name
        ;
    ELSE
        IF (IFNULL( intention_use, 0 ) = 0) THEN
            SET search_intention_from = intention_use;
            SET search_intention_to = intention_use;
        ELSE
            SET search_intention_from = '1';
            SET search_intention_to = '12';
        END IF;

         SELECT rc.CLASS_NUMBER AS class_no,
                apc.COUPLES_ID AS couplesid,
                apc.IS_ACTIVE AS isactive,
                apc.DATE_ENCODED AS date_encode,
                ic.LNAME AS lastname,
                ic.FNAME AS firstname,
                ic.MNAME AS middle,
                ic.EXT_NAME AS ext_name
           FROM rpfp.couples apc
      LEFT JOIN rpfp.rpfp_class rc
             ON rc.RPFP_CLASS_ID = apc.RPFP_CLASS_ID
         LEFT JOIN rpfp.individual ic ON ic.COUPLES_ID = apc.COUPLES_ID
         LEFT JOIN rpfp.fp_details fd ON fd.COUPLES_ID = ic.COUPLES_ID
         LEFT JOIN rpfp.fp_service fs ON fs.COUPLES_ID = apc.COUPLES_ID
             WHERE rc.CLASS_NUMBER = class_num
               AND apc.IS_ACTIVE = status_active
               AND (   rc.DB_USER_ID = name_user
                    OR (   is_not_encoder
                        AND user_location = (rc.BARANGAY_ID DIV POWER( 10, multiplier ))
                    )
                )
               AND (
                        ic.FNAME LIKE CONCAT('%',couples_name,'%')
                    OR ic.LNAME LIKE CONCAT('%',couples_name,'%')
                )
               AND ic.AGE >= search_age_from
               AND ic.AGE <= search_age_to
               AND apc.NO_CHILDREN >= search_child_from
               AND apc.NO_CHILDREN <= search_child_to
               AND fd.MFP_INTENTION_SHIFT_ID >= 1
               AND fd.TFP_TYPE_ID = tfp_used
               AND fd.TFP_STATUS_ID = 'A'
               AND fd.MFP_INTENTION_USE_ID >= search_intentionfp_from
               AND fd.MFP_INTENTION_USE_ID <= search_intentionfp_to
       ORDER BY apc.COUPLES_ID ASC
        ; 
    END IF;
ELSE
    IF NOT EXISTS (
         SELECT rc.RPFP_CLASS_ID
           FROM rpfp.RPFP_CLASS rc
      LEFT JOIN rpfp.couples apc
             ON apc.RPFP_CLASS_ID = rc.RPFP_CLASS_ID
          WHERE apc.IS_ACTIVE = status_active
            AND (   rc.DB_USER_ID = name_user
                OR (   is_not_encoder
                    AND user_location = (rc.BARANGAY_ID DIV POWER( 10, multiplier ))
                )
            )
    ) THEN
         SELECT NULL AS class_no,
                NULL AS couplesid,
                NULL AS isactive,
                NULL AS date_encode,
                NULL AS lastname,
                NULL AS firstname,
                NULL AS middle,
                NULL AS ext_name
        ;
    ELSE
         SELECT rc.CLASS_NUMBER AS class_no,
                apc.COUPLES_ID AS couplesid,
                apc.IS_ACTIVE AS isactive,
                apc.DATE_ENCODED AS date_encode,
                ic.LNAME AS lastname,
                ic.FNAME AS firstname,
                ic.MNAME AS middle,
                ic.EXT_NAME AS ext_name
           FROM rpfp.couples apc
      LEFT JOIN rpfp.rpfp_class rc
             ON rc.RPFP_CLASS_ID = apc.RPFP_CLASS_ID
         LEFT JOIN rpfp.individual ic ON ic.COUPLES_ID = apc.COUPLES_ID
         LEFT JOIN rpfp.fp_details fd ON fd.COUPLES_ID = ic.COUPLES_ID
          LEFT JOIN rpfp.fp_service fs ON fs.COUPLES_ID = apc.COUPLES_ID
         LEFT JOIN rpfp.lib_psgc_locations lp ON lp.PSGC_CODE = rc.BARANGAY_ID
             WHERE rc.CLASS_NUMBER = class_num
               AND apc.IS_ACTIVE = status_active
               AND (   rc.DB_USER_ID = name_user
                    OR (   is_not_encoder
                        AND user_location = (rc.BARANGAY_ID DIV POWER( 10, multiplier ))
                        )
                    )
               AND (
                        ic.FNAME LIKE CONCAT('%',couples_name,'%')
                    OR ic.LNAME LIKE CONCAT('%',couples_name,'%')
                )
               AND ic.AGE >= search_age_from
               AND ic.AGE <= search_age_to
               AND apc.NO_CHILDREN >= search_child_from
               AND apc.NO_CHILDREN <= search_child_to
               AND fd.MFP_INTENTION_SHIFT_ID >= 1
               AND fd.TFP_TYPE_ID = tfp_used
               AND fd.TFP_STATUS_ID LIKE CONCAT('%',intention_status,'%')
       ORDER BY apc.COUPLES_ID ASC
        ; 
    END IF;
END IF;
END$$

CREATE DEFINER=root@localhost PROCEDURE encoder_get_couples_details(
    IN class_num VARCHAR(50)
    )   READS SQL DATA
BEGIN
    DECLARE name_user VARCHAR(50);
    DECLARE db_user_name VARCHAR(50);
    DECLARE user_scope INT;
    DECLARE user_location INT;
    DECLARE multiplier INT;
    DECLARE is_not_encoder INT(1);
    
    CALL rpfp.lib_extract_user_name( USER(), name_user, db_user_name );
    SET user_scope := rpfp.profile_get_scope( name_user );
    SET multiplier := rpfp.lib_get_multiplier( user_scope );
    SET user_location := rpfp.profile_get_location( name_user, user_scope );
    SET is_not_encoder := NOT IFNULL(rpfp.profile_check_if_encoder(), FALSE);

    IF NOT EXISTS (
         SELECT apc.COUPLES_ID
           FROM rpfp.couples apc
      LEFT JOIN rpfp.rpfp_class rc
             ON rc.RPFP_CLASS_ID = apc.RPFP_CLASS_ID
          WHERE rc.CLASS_NUMBER = class_num
            AND (   rc.DB_USER_ID = name_user
                OR (   is_not_encoder
                    AND user_location = (rc.BARANGAY_ID DIV POWER( 10, multiplier ))
                    )
                )
    ) THEN
         SELECT NULL AS indvid,
                NULL AS couplesid,
                NULL AS lastname,
                NULL AS firstname,
                NULL AS middle,
                NULL AS ext,
                NULL AS age,
                NULL AS sex,
                NULL AS birth_year,
                NULL AS birth_month,
                NULL AS civil,
                NULL AS address_no_st,
                NULL AS address_brgy,
                NULL AS address_city,
                NULL AS household_no,
                NULL AS educ_bckgrnd,
                NULL AS etnic,
                NULL AS number_child,
                NULL AS attendee
        ;
    ELSE
         SELECT ic.INDV_ID AS indvid,
                apc.COUPLES_ID AS couplesid,
                ic.LNAME AS lastname,
                ic.FNAME AS firstname,
                ic.MNAME AS middle,
                ic.EXT_NAME AS ext,
                ic.AGE AS age,
                ic.SEX AS sex,
                ic.YEAR(BDATE) AS birth_year,
                ic.MONTH(BDATE) AS birth_month,
                ic.CIVIL_ID AS civil,
                ic.ADDRESS_NO_ST AS address_no_st,
                ic.ADDRESS_BRGY AS address_brgy,
                ic.ADDRESS_CITY AS address_city,
                ic.HH_ID_NO AS household_no,
                ic.EDUC_BCKGRND_ID AS educ_bckgrnd,
                ic.ETNICITY AS etnic,
                ic.NO_CHILDREN AS number_child,
                ic.IS_ATTENDEE AS attendee
           FROM rpfp.rpfp_class rc
      LEFT JOIN rpfp.couples apc
             ON rc.RPFP_CLASS_ID = apc.RPFP_CLASS_ID
      LEFT JOIN rpfp.individual ic
             ON ic.COUPLES_ID = apc.COUPLES_ID
          WHERE rc.CLASS_NUMBER = class_num
            AND (   rc.DB_USER_ID = name_user
                OR (   is_not_encoder
                    AND user_location = (rc.BARANGAY_ID DIV POWER( 10, multiplier ))
                    )
                )
       ORDER BY ic.INDV_ID ASC
        ;
    END IF;
END$$

CREATE DEFINER=root@localhost PROCEDURE encoder_get_footer_details(
    IN rpfp_classid VARCHAR(50)
    )   READS SQL DATA
BEGIN
    IF NOT EXISTS (
         SELECT rf.RPFP_FOOTER_ID
           FROM rpfp.rpfp_footer rf
      LEFT JOIN rpfp.rpfp_class rc
             ON rf.RPFP_CLASS_ID = rc.RPFP_CLASS_ID
          WHERE rf.RPFP_CLASS_ID = rpfp_classid
    ) THEN
         SELECT NULL AS prepared_by,
                NULL AS reviewed_by,
                NULL AS approved_by
        ;
    ELSE
         SELECT rf.PREPARED_BY AS prepared_by,
                rf.REVIEWED_BY AS reviewed_by,
                rf.APPROVED_BY AS approved_by
           FROM rpfp.rpfp_footer rf
      LEFT JOIN rpfp.rpfp_class rc
             ON rf.RPFP_CLASS_ID = rc.RPFP_CLASS_ID
          WHERE rf.RPFP_CLASS_ID = rpfp_classid
        ;
    END IF;
END$$

CREATE DEFINER=root@localhost PROCEDURE encoder_get_couples_with_fp_details(
    IN class_num VARCHAR(50),
    IN active_status INT
    )   READS SQL DATA
BEGIN
    DECLARE name_user VARCHAR(50);
    DECLARE db_user_name VARCHAR(50);
    DECLARE user_scope INT;
    DECLARE user_location INT;
    DECLARE multiplier INT;
    DECLARE is_not_encoder INT(1);
    
    CALL rpfp.lib_extract_user_name( USER(), name_user, db_user_name );
    SET user_scope := rpfp.profile_get_scope( name_user );
    SET multiplier := rpfp.lib_get_multiplier( user_scope );
    SET user_location := rpfp.profile_get_location( name_user, user_scope );
    SET is_not_encoder := NOT IFNULL(rpfp.profile_check_if_encoder(), FALSE);

    IF NOT EXISTS (
         SELECT apc.COUPLES_ID
           FROM rpfp.couples apc
      LEFT JOIN rpfp.rpfp_class rc
             ON rc.RPFP_CLASS_ID = apc.RPFP_CLASS_ID
          WHERE rc.CLASS_NUMBER = class_num
            AND user_location = (rc.BARANGAY_ID DIV POWER( 10, multiplier ))
    ) THEN
         SELECT NULL AS couplesid,
                NULL AS indvid_female,
                NULL AS lastname_female,
                NULL AS firstname_female,
                NULL AS middle_female,
                NULL AS ext_female,
                NULL AS age_female,
                NULL AS sex_female,
                NULL AS birth_month_female,
                NULL AS civil_female,
                NULL AS educ_bckgrnd_female,
                NULL AS attendee_female,
                NULL AS indvid_male,
                NULL AS lastname_male,
                NULL AS firstname_male,
                NULL AS middle_male,
                NULL AS ext_male,
                NULL AS age_male,
                NULL AS sex_male,
                NULL AS birth_month_male,
                NULL AS civil_male,
                NULL AS educ_bckgrnd_male,
                NULL AS attendee_male,
                NULL AS address_no_st,
                NULL AS address_brgy,
                NULL AS address_city,
                NULL AS household_no,
                NULL AS number_child,
                NULL AS fp_id,
                NULL AS mfp_method,
                NULL AS mfp_intention_shift,
                NULL AS tfp_type,
                NULL AS tfp_status,
                NULL AS mfp_intention_use,
                NULL AS tfp_reason,
                NULL AS fp_served,
                NULL AS is_active,
                NULL AS is_approved,
                NULL AS is_verified
        ;
    ELSE
         SELECT apc.COUPLES_ID AS couplesid,
         		ic_female.INDV_ID AS indvid_female,
                ic_female.LNAME AS lastname_female,
                ic_female.FNAME AS firstname_female,
                ic_female.MNAME AS middle_female,
                ic_female.EXT_NAME AS ext_female,
                ic_female.AGE AS age_female,
                ic_female.SEX AS sex_female,
                ic_female.BDATE AS birth_month_female,
                ic_female.CIVIL_ID AS civil_female,
                ic_female.EDUC_BCKGRND_ID AS educ_bckgrnd_female,
                ic_female.IS_ATTENDEE AS attendee_female,
         		ic_male.INDV_ID AS indvid_male,
                ic_male.LNAME AS lastname_male,
                ic_male.FNAME AS firstname_male,
                ic_male.MNAME AS middle_male,
                ic_male.EXT_NAME AS ext_male,
                ic_male.AGE AS age_male,
                ic_male.SEX AS sex_male,
                ic_male.BDATE AS birth_month_male,
                ic_male.CIVIL_ID AS civil_male,
                ic_male.EDUC_BCKGRND_ID AS educ_bckgrnd_male,
                ic_male.IS_ATTENDEE AS attendee_male,                
                apc.ADDRESS_NO_ST AS address_no_st,
                apc.ADDRESS_BRGY AS address_brgy,
                apc.ADDRESS_CITY AS address_city,
                apc.HH_ID_NO AS household_no,
                apc.NO_CHILDREN AS number_child,
                fp.FP_DETAILS_ID AS fp_id,
                fp.MFP_METHOD_USED_ID AS mfp_method,
                fp.MFP_INTENTION_SHIFT_ID AS mfp_intention_shift,
                fp.TFP_TYPE_ID AS tfp_type,
                fp.TFP_STATUS_ID AS tfp_status,
                fp.MFP_INTENTION_USE_ID AS mfp_intention_use,
                fp.REASON_INTENDING_USE_ID AS tfp_reason,
                (CASE WHEN fs.COUPLES_ID IS NULL THEN 0 ELSE 1 END) AS fp_served,
                cv.VERIFIED_ID AS is_verified,
                ta.TRACK_ID AS is_approved,
                apc.is_active AS is_active
           FROM rpfp.rpfp_class rc
      LEFT JOIN rpfp.couples apc
             ON rc.RPFP_CLASS_ID = apc.RPFP_CLASS_ID
      LEFT JOIN rpfp.individual ic_male
             ON ic_male.COUPLES_ID = apc.COUPLES_ID
            AND ic_male.SEX = 1
      LEFT JOIN rpfp.individual ic_female
             ON ic_female.COUPLES_ID = apc.COUPLES_ID
            AND ic_female.SEX = 2
      LEFT JOIN rpfp.fp_details fp
             ON fp.COUPLES_ID = apc.COUPLES_ID
      LEFT JOIN rpfp.fp_service fs
             ON fs.COUPLES_ID = apc.COUPLES_ID
      LEFT JOIN rpfp.couples_verified cv 
             ON cv.COUPLES_ID = apc.COUPLES_ID
      LEFT JOIN rpfp.track_approved ta 
             ON ta.COUPLES_ID = apc.COUPLES_ID
          WHERE rc.CLASS_NUMBER = class_num
            AND apc.IS_ACTIVE = active_status
            AND user_location = (rc.BARANGAY_ID DIV POWER( 10, multiplier ))
       ORDER BY apc.COUPLES_ID ASC
        ;
    END IF;
END$$

CREATE DEFINER=root@localhost PROCEDURE get_duplicates_list (
    )   READS SQL DATA
BEGIN
    DECLARE check_details INT;  
    DECLARE name_user VARCHAR(50);
    DECLARE db_user_name VARCHAR(50);
    DECLARE user_scope INT;
    DECLARE user_location INT;
    DECLARE multiplier INT;
    DECLARE is_not_encoder INT(1);

    CALL rpfp.lib_extract_user_name( USER(), name_user, db_user_name );
    SET user_scope := rpfp.profile_get_scope( name_user );
    SET multiplier := rpfp.lib_get_multiplier( user_scope );
    SET user_location := rpfp.profile_get_location( name_user, user_scope );
    SET is_not_encoder := NOT IFNULL(rpfp.profile_check_if_encoder(), FALSE);

      SELECT 	couples.COUPLES_ID AS couplesid,
                couples.IS_ACTIVE AS active_status,
      			husband.LNAME AS h_last,
      			husband.FNAME AS h_first,
      			husband.EXT_NAME AS h_ext,
      			husband.BDATE AS h_bday,
      			husband.SEX AS h_sex,
                full_data.w_couplesid AS w_couplesid,
      			full_data.w_last AS w_last,
      			full_data.w_first AS w_first,
      			full_data.w_bday AS w_bday,
      			full_data.w_sex AS sex_w
        FROM rpfp.couples couples
   LEFT JOIN rpfp.rpfp_class rc ON rc.RPFP_CLASS_ID = couples.RPFP_CLASS_ID 
   LEFT JOIN rpfp.lib_psgc_locations lp ON lp.REGION_CODE = user_location
   LEFT JOIN rpfp.individual husband ON husband.COUPLES_ID = couples.COUPLES_ID AND husband.SEX = 1
   LEFT JOIN (
       SELECT wic.COUPLES_ID AS w_couplesid,
      		  wife.LNAME AS w_last,
      		  wife.FNAME AS w_first,
      		  wife.BDATE AS w_bday,
      		  wife.SEX AS w_sex
         FROM rpfp.couples wic
    LEFT JOIN rpfp.individual wife ON wife.COUPLES_ID = wic.COUPLES_ID AND wife.SEX = 2
              ) full_data
           ON full_data.w_couplesid = couples.COUPLES_ID
     GROUP BY h_last, h_first, h_ext, h_bday, h_sex, w_last, w_first, w_bday, w_sex
       HAVING COUNT(*) > 1
    ;

END$$

CREATE DEFINER=root@localhost PROCEDURE get_duplicates_details (
    IN firstname_h VARCHAR(50),
    IN lastname_h VARCHAR(50),
    IN extname_h VARCHAR(50),
    IN birthdate_h DATE,
    IN firstname_w VARCHAR(50),
    IN lastname_w VARCHAR(50),
    IN birthdate_w DATE
    )   READS SQL DATA
BEGIN
    DECLARE check_details INT;  
    DECLARE name_user VARCHAR(50);
    DECLARE db_user_name VARCHAR(50);
    DECLARE user_scope INT;
    DECLARE user_location INT;
    DECLARE multiplier INT;
    DECLARE is_not_encoder INT(1);
    
    CALL rpfp.lib_extract_user_name( USER(), name_user, db_user_name );
    SET user_scope := rpfp.profile_get_scope( name_user );
    SET multiplier := rpfp.lib_get_multiplier( user_scope );
    SET user_location := rpfp.profile_get_location( name_user, user_scope );
    SET is_not_encoder := NOT IFNULL(rpfp.profile_check_if_encoder(), FALSE);

      SELECT 	
                couples.COUPLES_ID AS couplesid,
                couples.IS_ACTIVE AS active_status,
      			husband.LNAME AS h_last,
      			husband.FNAME AS h_first,
      			husband.EXT_NAME AS h_ext,
      			husband.BDATE AS h_bday,
      			husband.SEX AS h_sex,
                full_data.w_couplesid AS w_couplesid,
      			full_data.w_last AS w_last,
      			full_data.w_first AS w_first,
      			full_data.w_bday AS w_bday,
      			full_data.w_sex AS w_sex,
                rc.CLASS_NUMBER AS class_no,
                rc.DATE_CONDUCTED AS date_class,
                couples.DATE_ENCODED AS date_encoded
        FROM rpfp.couples couples
   LEFT JOIN rpfp.rpfp_class rc ON rc.RPFP_CLASS_ID = couples.RPFP_CLASS_ID 
   LEFT JOIN rpfp.lib_psgc_locations lp ON lp.REGION_CODE = user_location
   LEFT JOIN rpfp.individual husband ON husband.COUPLES_ID = couples.COUPLES_ID AND husband.SEX = 1
   LEFT JOIN (
       SELECT wic.COUPLES_ID AS w_couplesid,
      		  wife.LNAME AS w_last,
      		  wife.FNAME AS w_first,
      		  wife.BDATE AS w_bday,
      		  wife.SEX AS w_sex
         FROM rpfp.couples wic
    LEFT JOIN rpfp.individual wife ON wife.COUPLES_ID = wic.COUPLES_ID AND wife.SEX = 2
              ) full_data
           ON full_data.w_couplesid = couples.COUPLES_ID
       WHERE husband.LNAME = lastname_h
         AND husband.FNAME = firstname_h
         AND husband.EXT_NAME = extname_h
         AND husband.BDATE = birthdate_h
         AND full_data.w_last = lastname_w
         AND full_data.w_first = firstname_w
         AND full_data.w_bday = birthdate_w
    ;
END$$

CREATE DEFINER=root@localhost PROCEDURE encoder_save_class(
    IN classid INT UNSIGNED,
    IN type_class INT,
    IN others_spec VARCHAR(100),
    IN barangayid INT,
    IN class_no VARCHAR(50),
    IN dateconducted DATE
    )  MODIFIES SQL DATA
proc_exit_point :
BEGIN
    DECLARE name_user VARCHAR(50);
    DECLARE db_user_name VARCHAR(50);
    DECLARE is_not_encoder INT(1);
    DECLARE good_location INT(1);

    SET is_not_encoder := NOT IFNULL(rpfp.profile_check_if_encoder(), FALSE);
    IF is_not_encoder  THEN
        SELECT "INVALID ROLE" AS MESSAGE;
        LEAVE proc_exit_point;
    END IF;

    SET good_location :=  rpfp.profile_check_if_allowed_location(
        USER(),
        barangayid
    );

    IF NOT good_location THEN
        SELECT "INVALID LOCATION" AS MESSAGE;
        LEAVE proc_exit_point;
    END IF;

    CALL rpfp.lib_extract_user_name( USER(), name_user, db_user_name );

    IF ( IFNULL( classid, 0 ) = 0 )  THEN
        INSERT INTO rpfp.rpfp_class
            (
                TYPE_CLASS_ID,
                OTHERS_SPECIFY,
                BARANGAY_ID,
                CLASS_NUMBER,
                DATE_CONDUCTED,
                DB_USER_ID
            )
             VALUES (
                 type_class,
                 others_spec,
                 barangayid,
                 class_no,
                 dateconducted,
                 name_user
             )
        ;

        SELECT CONCAT( "NEW ENTRY: ", LAST_INSERT_ID() ) AS MESSAGE;
        LEAVE proc_exit_point;
    END IF;

     UPDATE rpfp.rpfp_class rc
        SET rc.TYPE_CLASS_ID = IF( IFNULL( type_class, '' ) = '', rc.TYPE_CLASS_ID, type_class ),
            rc.OTHERS_SPECIFY = IF( IFNULL( others_spec, '' ) = '', rc.OTHERS_SPECIFY, others_spec ),
            rc.BARANGAY_ID =  IF( IFNULL( barangayid, '' ) = '', rc.BARANGAY_ID, barangayid ),
            rc.CLASS_NUMBER =  IF( IFNULL( class_no, '' ) = '', rc.CLASS_NUMBER, class_no ),
            rc.DATE_CONDUCTED =  IF( IFNULL( dateconducted, '' ) = '', rc.DATE_CONDUCTED, dateconducted )
      WHERE rc.RPFP_CLASS_ID = classid
        AND rc.DB_USER_ID = name_user
    ;

    SELECT "SAVE SUCCESSFUL" AS MESSAGE;
END$$

CREATE DEFINER=root@localhost PROCEDURE encoder_save_footer(
    IN footer_id INT UNSIGNED,
    IN rpfp_classid INT,
    IN prepared_by VARCHAR(100),
    IN reviewed_by VARCHAR(100),
    IN approved_by VARCHAR(100)
    )  MODIFIES SQL DATA
proc_exit_point :
BEGIN
    IF ( IFNULL( rpfp_classid, 0 ) = 0 ) THEN
        SELECT "CANNOT SAVE RECORD WITH GIVEN PARAMETERS" AS MESSAGE;
        LEAVE proc_exit_point;
    END IF;

    IF ( IFNULL( footer_id, 0 ) = 0 ) THEN
        /**
            INSERT FOR NEW DATA
            
        */
        INSERT INTO rpfp.rpfp_footer (
                    RPFP_CLASS_ID,
                    PREPARED_BY,
                    REVIEWED_BY,
                    APPROVED_BY
            )
             VALUES (
                    rpfp_classid,
                    prepared_by,
                    reviewed_by,
                    approved_by
            )
    ;

        SELECT CONCAT( "NEW ENTRY: ", LAST_INSERT_ID() ) AS MESSAGE;
        LEAVE proc_exit_point;
    END IF;

             UPDATE rpfp.rpfp_footer rf
                SET rf.RPFP_CLASS_ID = IF( IFNULL( rpfp_classid, '') = '', rf.RPFP_CLASS_ID, rpfp_classid ),
                    rf.PREPARED_BY = IF( IFNULL( prepared_by, '') = '', rf.PREPARED_BY, prepared_by ),
                    rf.REVIEWED_BY = IF( IFNULL( reviewed_by, '') = '', rf.REVIEWED_BY, reviewed_by ),
                    rf.APPROVED_BY = IF( IFNULL( approved_by, '') = '', rf.APPROVED_BY, approved_by )
              WHERE rf.RPFP_FOOTER_ID = footer_id
    ;
    SELECT "UPDATE SUCCESS!" AS MESSAGE;
END$$
/** END OF CLASSES */

/** COUPLES DETAILS */
CREATE DEFINER=root@localhost PROCEDURE encoder_get_duplicate_details (
    IN couplesid INT UNSIGNED
    )  READS SQL DATA
BEGIN
    DECLARE name_user VARCHAR(50);
    DECLARE db_user_name VARCHAR(50);
    DECLARE user_scope INT;
    DECLARE user_location INT;
    DECLARE multiplier INT;
    DECLARE is_not_encoder INT(1);
    
    CALL rpfp.lib_extract_user_name( USER(), name_user, db_user_name );
    SET user_scope := rpfp.profile_get_scope( name_user );
    SET multiplier := rpfp.lib_get_multiplier( user_scope );
    SET user_location := rpfp.profile_get_location( name_user, user_scope );
    SET is_not_encoder := NOT IFNULL(rpfp.profile_check_if_encoder(), FALSE);

    IF NOT EXISTS (
         SELECT apc.COUPLES_ID
           FROM rpfp.couples apc
      LEFT JOIN rpfp.individual ic
             ON ic.COUPLES_ID = apc.COUPLES_ID
      LEFT JOIN rpfp.rpfp_class rc
             ON rc.RPFP_CLASS_ID = apc.RPFP_CLASS_ID
          WHERE ic.COUPLES_ID = couplesid
    ) THEN
        BEGIN
             SELECT NULL AS couplesid,
                    NULL AS address_no_st,
                    NULL AS address_barangay,
                    NULL AS address_city,
                    NULL AS household_no,
                    NULL AS number_child,
                    NULL AS status_active,
                    NULL AS fpdetailsid,
                    NULL AS mfp_used,
                    NULL AS mfp_shift,
                    NULL AS tfp_type,
                    NULL AS tfp_status,
                    NULL AS mfp_intention_use,
                    NULL AS reason_use
            ;
        END;
    ELSE
        BEGIN
             SELECT apc.COUPLES_ID AS couplesid,
                    apc.ADDRESS_NO_ST AS address_no_st,
                    apc.ADDRESS_BRGY AS address_barangay,
                    apc.ADDRESS_CITY AS address_city,
                    apc.HH_ID_NO AS household_no,
                    apc.NO_CHILDREN AS number_child,
                    apc.IS_ACTIVE AS status_active,
                    fd.FP_DETAILS_ID AS fpdetailsid,
                    fd.MFP_METHOD_USED_ID AS mfp_used,
                    fd.MFP_INTENTION_SHIFT_ID AS mfp_shift,
                    fd.TFP_TYPE_ID AS tfp_type,
                    fd.TFP_STATUS_ID AS tfp_status,
                    fd.MFP_INTENTION_USE_ID AS mfp_intention_use, 
                    fd.REASON_INTENDING_USE_ID AS reason_use
               FROM rpfp.couples apc
          LEFT JOIN rpfp.individual ic
                 ON ic.COUPLES_ID = apc.COUPLES_ID
          LEFT JOIN rpfp.rpfp_class rc
                 ON rc.RPFP_CLASS_ID = apc.RPFP_CLASS_ID
          LEFT JOIN rpfp.fp_details fd
                 ON fd.COUPLES_ID = apc.COUPLES_ID
              WHERE ic.COUPLES_ID = couplesid
           GROUP BY apc.COUPLES_ID
            ;
        END;
    END IF;
END$$

CREATE DEFINER=root@localhost PROCEDURE encoder_get_couple_fp_details (IN couplesid INT UNSIGNED)  READS SQL DATA
BEGIN
    DECLARE name_user VARCHAR(50);
    DECLARE db_user_name VARCHAR(50);
    DECLARE user_scope INT;
    DECLARE user_location INT;
    DECLARE multiplier INT;
    DECLARE is_not_encoder INT(1);
    
    CALL rpfp.lib_extract_user_name( USER(), name_user, db_user_name );
    SET user_scope := rpfp.profile_get_scope( name_user );
    SET multiplier := rpfp.lib_get_multiplier( user_scope );
    SET user_location := rpfp.profile_get_location( name_user, user_scope );
    SET is_not_encoder := NOT IFNULL(rpfp.profile_check_if_encoder(), FALSE);

    IF NOT EXISTS (
         SELECT apc.COUPLES_ID
           FROM rpfp.rpfp_class rc
      LEFT JOIN rpfp.couples apc
             ON rc.RPFP_CLASS_ID = apc.RPFP_CLASS_ID
      LEFT JOIN rpfp.fp_details fd
             ON fd.COUPLES_ID = apc.COUPLES_ID
          WHERE IFNULL( fd.COUPLES_ID, 0) = couplesid
            AND (   rc.DB_USER_ID = name_user
                OR (   is_not_encoder
                    AND user_location = (rc.BARANGAY_ID DIV POWER( 10, multiplier ))
                    )
                )
    ) THEN
        BEGIN
             SELECT NULL AS fpdetailsid,
                    NULL AS couplesid,
                    NULL AS mfp_used,
                    NULL AS mfp_shift,
                    NULL AS tfp_type,
                    NULL AS tfp_status,
                    NULL AS mfp_intention_use,
                    NULL AS reason_use
            ;
        END;
    ELSE
        BEGIN
             SELECT fd.FP_DETAILS_ID AS fpdetailsid,
                    apc.COUPLES_ID AS couplesid,
                    fd.MFP_METHOD_USED_ID AS mfp_used,
                    fd.MFP_INTENTION_SHIFT_ID AS mfp_shift,
                    fd.TFP_TYPE_ID AS tfp_type,
                    fd.TFP_STATUS_ID AS tfp_status,
                    fd.MFP_INTENTION_USE_ID AS mfp_intention_use, 
                    fd.REASON_INTENDING_USE_ID AS reason_use
               FROM rpfp.rpfp_class rc
          LEFT JOIN rpfp.couples apc
                 ON rc.RPFP_CLASS_ID = apc.RPFP_CLASS_ID
          LEFT JOIN rpfp.fp_details fd
                 ON fd.COUPLES_ID = apc.COUPLES_ID
              WHERE IFNULL( fd.COUPLES_ID, 0) = couplesid
                AND (   rc.DB_USER_ID = name_user
                    OR (   is_not_encoder
                        AND user_location = (rc.BARANGAY_ID DIV POWER( 10, multiplier ))
                        )
                    )
           ORDER BY fd.FP_DETAILS_ID ASC
            ;
        END;
    END IF;
END$$

CREATE DEFINER=root@localhost PROCEDURE encoder_get_fp_service (IN couplesid INT UNSIGNED)  READS SQL DATA
BEGIN
    DECLARE name_user VARCHAR(50);
    DECLARE db_user_name VARCHAR(50);
    DECLARE user_scope INT;
    DECLARE user_location INT;
    DECLARE multiplier INT;
    DECLARE is_not_encoder INT(1);
    
    CALL rpfp.lib_extract_user_name( USER(), name_user, db_user_name );
    SET user_scope := rpfp.profile_get_scope( name_user );
    SET multiplier := rpfp.lib_get_multiplier( user_scope );
    SET user_location := rpfp.profile_get_location( name_user, user_scope );
    SET is_not_encoder := NOT IFNULL(rpfp.profile_check_if_encoder(), FALSE);

    IF NOT EXISTS (
         SELECT apc.COUPLES_ID
           FROM rpfp.rpfp_class rc
      LEFT JOIN rpfp.couples apc
             ON rc.RPFP_CLASS_ID = apc.RPFP_CLASS_ID
      LEFT JOIN rpfp.FP_SERVICE fs
             ON fs.COUPLES_ID = apc.COUPLES_ID
          WHERE IFNULL( fs.COUPLES_ID, 0) = couplesid
            AND (   rc.DB_USER_ID = name_user
                OR (   is_not_encoder
                    AND user_location = (rc.BARANGAY_ID DIV POWER( 10, multiplier ))
                    )
                )
    ) THEN
         SELECT NULL AS fpserviceid,
                NULL AS datevisit,
                NULL AS fp_served,
                NULL AS provider_type,
                NULL AS is_counselling,
                NULL AS other_concern,
                NULL AS counseled_fp,
                NULL AS other_specify,
                NULL AS is_provided_service,
                NULL AS dateserved,
                NULL AS client_advise,
                NULL AS referralname,
                NULL AS providername,
                NULL AS date_encode
        ;
ELSE
         SELECT fs.FP_SERVICE_ID AS fpserviceid,
                fs.DATE_VISIT AS datevisit,
                fs.FP_SERVED_ID AS fp_served,
                fs.PROVIDER_TYPE_ID AS provider_type,
                fs.IS_COUNSELING AS is_counselling,
                fs.OTHER_CONCERN AS other_concern,
                fs.COUNSELED_TO_USE AS counseled_fp,
                fs.OTHER_REASONS_SPECIFY AS other_specify,
                fs.IS_PROVIDED_SERVICE AS is_provided_service,
                fs.DATE_SERVED AS dateserved,
                fs.CLIENT_ADVISE AS client_advise,
                fs.REFERRAL_NAME AS referralname,
                fs.PROVIDER_NAME AS providername,
                fs.DATE_ENCODED AS date_encode
           FROM rpfp.rpfp_class rc
      LEFT JOIN rpfp.couples apc
             ON rc.RPFP_CLASS_ID = apc.RPFP_CLASS_ID
      LEFT JOIN rpfp.FP_SERVICE fs
             ON fs.COUPLES_ID = apc.COUPLES_ID
          WHERE IFNULL( fs.COUPLES_ID, 0) = couplesid
            AND (   rc.DB_USER_ID = name_user
                OR (   is_not_encoder
                    AND user_location = (rc.BARANGAY_ID DIV POWER( 10, multiplier ))
                    )
                )
        ;
    END IF;
END$$

CREATE DEFINER=root@localhost PROCEDURE encoder_check_couples_details (
    IN firstname VARCHAR(50),
    IN lastname VARCHAR(50),
    IN extname VARCHAR(50),
    IN birthdate DATE,
    IN sex INT
    )   READS SQL DATA
proc_exit_point :
BEGIN
DECLARE check_details INT;

    IF ( IFNULL( sex, 0 ) = 0 )  THEN
        SELECT "CANNOT SEARCH RECORD WITH GIVEN PARAMETERS" AS check_details;
        LEAVE proc_exit_point;
    END IF;

    IF sex = 1 THEN
      SELECT COUNT(*) 
        INTO check_details
        FROM rpfp.individual ic 
       WHERE ic.FNAME = firstname
         AND ic.LNAME = lastname
         AND ic.EXT_NAME = extname
         AND ic.BDATE = birthdate
         AND ic.SEX = 1
    ;
    ELSE
      SELECT COUNT(*) 
        INTO check_details
        FROM rpfp.individual ic 
       WHERE ic.FNAME = firstname
         AND ic.LNAME = lastname
         AND ic.BDATE = birthdate
         AND ic.SEX = 2
    ;
    END IF;

    SELECT check_details;
END$$

CREATE DEFINER=root@localhost PROCEDURE check_for_duplications (
    IN firstname_h VARCHAR(50),
    IN lastname_h VARCHAR(50),
    IN extname_h VARCHAR(50),
    IN birthdate_h DATE,
    IN firstname_w VARCHAR(50),
    IN lastname_w VARCHAR(50),
    IN birthdate_w DATE
    )   READS SQL DATA
proc_exit_point :
BEGIN
DECLARE check_details INT;

    DECLARE name_user VARCHAR(50);
    DECLARE db_user_name VARCHAR(50);
    DECLARE read_offset INT;
    DECLARE user_scope INT;
    DECLARE user_location INT;
    DECLARE multiplier INT;
    DECLARE is_not_encoder INT(1);
    
    CALL rpfp.lib_extract_user_name( USER(), name_user, db_user_name );
    SET user_scope := rpfp.profile_get_scope( name_user );
    SET multiplier := rpfp.lib_get_multiplier( user_scope );
    SET user_location := rpfp.profile_get_location( name_user, user_scope );
    SET is_not_encoder := NOT IFNULL(rpfp.profile_check_if_encoder(), FALSE);
    
    IF firstname_h = 0 THEN
      SELECT 	COUNT(couples.COUPLES_ID) AS check_details,
                couples.COUPLES_ID AS couplesid,
                couples.IS_ACTIVE AS active_status,
                wife_data.w_couplesid AS w_couplesid,
      			wife_data.w_last AS w_last,
      			wife_data.w_first AS w_first,
      			wife_data.w_bday AS w_bday,
      			wife_data.w_sex AS w_sex
        FROM rpfp.couples couples
   LEFT JOIN rpfp.rpfp_class rc ON rc.RPFP_CLASS_ID = couples.RPFP_CLASS_ID 
   LEFT JOIN rpfp.lib_psgc_locations lp ON lp.REGION_CODE = user_location
   LEFT JOIN (
       SELECT wic.COUPLES_ID AS w_couplesid,
      		  wife.LNAME AS w_last,
      		  wife.FNAME AS w_first,
      		  wife.BDATE AS w_bday,
      		  wife.SEX AS w_sex
         FROM rpfp.couples wic
    LEFT JOIN rpfp.individual wife ON wife.COUPLES_ID = wic.COUPLES_ID AND wife.SEX = 2
              ) wife_data
           ON wife_data.w_couplesid = couples.COUPLES_ID
       WHERE wife_data.w_last = lastname_w
         AND wife_data.w_first = firstname_w
         AND wife_data.w_bday = birthdate_w
    ;
    LEAVE proc_exit_point;

    ELSE 
        IF firstname_w = 0 THEN
        SELECT 	COUNT(couples.COUPLES_ID) AS check_details,
                    couples.COUPLES_ID AS couplesid,
                    couples.IS_ACTIVE AS active_status,
                    husband_data.h_couplesid AS h_couplesid,
                    husband_data.h_last AS h_last,
                    husband_data.h_first AS h_first,
                    husband_data.h_ext AS h_ext,
                    husband_data.h_bday AS h_bday,
                    husband_data.h_sex AS h_sex
            FROM rpfp.couples couples
    LEFT JOIN rpfp.rpfp_class rc ON rc.RPFP_CLASS_ID = couples.RPFP_CLASS_ID 
    LEFT JOIN rpfp.lib_psgc_locations lp ON lp.REGION_CODE = user_location
    LEFT JOIN (
        SELECT hic.COUPLES_ID AS h_couplesid,
                husband.LNAME AS h_last,
                husband.FNAME AS h_first,
                husband.EXT_NAME AS h_ext,
                husband.BDATE AS h_bday,
                husband.SEX AS h_sex
            FROM rpfp.couples hic
        LEFT JOIN rpfp.individual husband ON husband.COUPLES_ID = hic.COUPLES_ID AND husband.SEX = 1
                ) husband_data
            ON husband_data.h_couplesid = couples.COUPLES_ID
        WHERE husband_data.h_last = lastname_h
            AND husband_data.h_first = firstname_h
            AND husband_data.h_ext = extname_h
            AND husband_data.h_bday = birthdate_h
        ;
        LEAVE proc_exit_point;

        ELSE
        SELECT 	COUNT(couples.COUPLES_ID) AS check_details,
                    couples.COUPLES_ID AS couplesid,
                    couples.IS_ACTIVE AS active_status,
                    husband_data.h_couplesid AS h_couplesid,
                    husband_data.h_last AS h_last,
                    husband_data.h_first AS h_first,
                    husband_data.h_ext AS h_ext,
                    husband_data.h_bday AS h_bday,
                    husband_data.h_sex AS h_sex,
                    wife_data.w_couplesid AS w_couplesid,
                    wife_data.w_last AS w_last,
                    wife_data.w_first AS w_first,
                    wife_data.w_bday AS w_bday,
                    wife_data.w_sex AS w_sex
            FROM rpfp.couples couples
    LEFT JOIN rpfp.rpfp_class rc ON rc.RPFP_CLASS_ID = couples.RPFP_CLASS_ID 
    LEFT JOIN rpfp.lib_psgc_locations lp ON lp.REGION_CODE = user_location
    LEFT JOIN (
        SELECT hic.COUPLES_ID AS h_couplesid,
                husband.LNAME AS h_last,
                husband.FNAME AS h_first,
                husband.EXT_NAME AS h_ext,
                husband.BDATE AS h_bday,
                husband.SEX AS h_sex
            FROM rpfp.couples hic
        LEFT JOIN rpfp.individual husband ON husband.COUPLES_ID = hic.COUPLES_ID AND husband.SEX = 1
                ) husband_data
            ON husband_data.h_couplesid = couples.COUPLES_ID
    LEFT JOIN (
        SELECT wic.COUPLES_ID AS w_couplesid,
                wife.LNAME AS w_last,
                wife.FNAME AS w_first,
                wife.BDATE AS w_bday,
                wife.SEX AS w_sex
            FROM rpfp.couples wic
        LEFT JOIN rpfp.individual wife ON wife.COUPLES_ID = wic.COUPLES_ID AND wife.SEX = 2
                ) wife_data
            ON wife_data.w_couplesid = couples.COUPLES_ID
        WHERE husband_data.h_last = lastname_h
            AND husband_data.h_first = firstname_h
            AND husband_data.h_ext = extname_h
            AND husband_data.h_bday = birthdate_h
            AND wife_data.w_last = lastname_w
            AND wife_data.w_first = firstname_w
            AND wife_data.w_bday = birthdate_w
        ;
        END IF;
    END IF;
END$$

CREATE DEFINER=root@localhost PROCEDURE check_couples_details (
    IN firstname_h VARCHAR(50),
    IN lastname_h VARCHAR(50),
    IN extname_h VARCHAR(50),
    IN birthdate_h DATE,
    IN firstname_w VARCHAR(50),
    IN lastname_w VARCHAR(50),
    IN birthdate_w DATE
    )   READS SQL DATA
proc_exit_point :
BEGIN
DECLARE check_details INT;

    DECLARE name_user VARCHAR(50);
    DECLARE db_user_name VARCHAR(50);
    DECLARE read_offset INT;
    DECLARE user_scope INT;
    DECLARE user_location INT;
    DECLARE multiplier INT;
    DECLARE is_not_encoder INT(1);
    
    CALL rpfp.lib_extract_user_name( USER(), name_user, db_user_name );
    SET user_scope := rpfp.profile_get_scope( name_user );
    SET multiplier := rpfp.lib_get_multiplier( user_scope );
    SET user_location := rpfp.profile_get_location( name_user, user_scope );
    SET is_not_encoder := NOT IFNULL(rpfp.profile_check_if_encoder(), FALSE);
    
      SELECT 	COUNT(couples.COUPLES_ID) AS check_details,
                couples.COUPLES_ID AS couplesid,
                couples.IS_ACTIVE AS active_status,
      			husband.LNAME AS h_last,
      			husband.FNAME AS h_first,
      			husband.EXT_NAME AS h_ext,
      			husband.BDATE AS h_bday,
      			husband.SEX AS h_sex,
                full_data.w_couplesid AS w_couplesid,
      			full_data.w_last AS w_last,
      			full_data.w_first AS w_first,
      			full_data.w_bday AS w_bday,
      			full_data.w_sex AS w_sex
        FROM rpfp.couples couples
   LEFT JOIN rpfp.rpfp_class rc ON rc.RPFP_CLASS_ID = couples.RPFP_CLASS_ID 
   LEFT JOIN rpfp.lib_psgc_locations lp ON lp.REGION_CODE = user_location
   LEFT JOIN rpfp.individual husband ON husband.COUPLES_ID = couples.COUPLES_ID AND husband.SEX = 1
   LEFT JOIN (
       SELECT wic.COUPLES_ID AS w_couplesid,
      		  wife.LNAME AS w_last,
      		  wife.FNAME AS w_first,
      		  wife.BDATE AS w_bday,
      		  wife.SEX AS w_sex
         FROM rpfp.couples wic
    LEFT JOIN rpfp.individual wife ON wife.COUPLES_ID = wic.COUPLES_ID AND wife.SEX = 2
              ) full_data
           ON full_data.w_couplesid = couples.COUPLES_ID
       WHERE husband.LNAME = lastname_h
         AND husband.FNAME = firstname_h
         AND husband.EXT_NAME = extname_h
         AND husband.BDATE = birthdate_h
         AND full_data.w_last = lastname_w
         AND full_data.w_first = firstname_w
         AND full_data.w_bday = birthdate_w
    ;
END$$

CREATE DEFINER=root@localhost PROCEDURE encoder_save_couple (
    IN couplesid INT UNSIGNED,
    IN rpfp_classid INT,
    IN address_st_no VARCHAR(50),
    IN address_barangay VARCHAR(50),
    IN address_municipality VARCHAR(50),
    IN household_no VARCHAR(50),
    IN number_child INT
    )  MODIFIES SQL DATA
proc_exit_point :
BEGIN

    IF ( IFNULL( rpfp_classid, 0 ) = 0 ) THEN
        SELECT "CANNOT SAVE RECORD WITH GIVEN PARAMETERS" AS MESSAGE;
        LEAVE proc_exit_point;
    END IF;

    IF ( IFNULL( couplesid, 0 ) = 0 ) THEN
        /**
            INSERT FOR NEW DATA
            
        */
        INSERT INTO rpfp.couples (
                    RPFP_CLASS_ID,
                    DATE_ENCODED,
                    DATE_MODIFIED,
                    ADDRESS_NO_ST,
                    ADDRESS_BRGY,
                    ADDRESS_CITY,
                    HH_ID_NO,
                    NO_CHILDREN,
                    IS_ACTIVE
            )
             VALUES (
                    rpfp_classid,
                    CURRENT_DATE(),
                    CURRENT_DATE(),
                    address_st_no,
                    address_barangay,
                    address_municipality,
                    household_no,
                    number_child,
                    2
            )
    ;

        SELECT CONCAT( "NEW ENTRY: ", LAST_INSERT_ID() ) AS MESSAGE;
        LEAVE proc_exit_point;
    END IF;

             UPDATE rpfp.couples apc
                SET apc.RPFP_CLASS_ID = IF( IFNULL( rpfp_classid, '') = '', apc.RPFP_CLASS_ID, rpfp_classid ),
                    apc.DATE_MODIFIED = CURRENT_DATE(),
                    apc.ADDRESS_NO_ST = IF( IFNULL( address_st_no, '') = '', apc.ADDRESS_NO_ST, address_st_no ),
                    apc.ADDRESS_BRGY = IF( IFNULL( address_barangay, '') = '', apc.ADDRESS_BRGY, address_barangay ),
                    apc.ADDRESS_CITY = IF( IFNULL( address_municipality, '') = '', apc.ADDRESS_CITY, address_municipality ),
                    apc.HH_ID_NO = IF( IFNULL( household_no, '') = '', apc.HH_ID_NO, household_no ),
                    apc.NO_CHILDREN = IF( IFNULL( number_child, '') = '', apc.NO_CHILDREN, number_child ),
                    apc.IS_ACTIVE = 2
              WHERE apc.couples_id = couplesid
    ;
    SELECT "UPDATE SUCCESS!" AS MESSAGE;
END$$

    /** CHANGE TO COUPLES  
     UPDATE rpfp.couples apc
        SET apc.DATE_MODIFIED = CURRENT_DATE(),
            apc.IS_ACTIVE = 2
      WHERE apc.COUPLES_ID = couples_id
        AND apc.RPFP_CLASS_ID = rpfp_classid
    ;
    */

    /** 
        SEARCH INDIVIDUALS FOR COUPLES ID
        IF NOT EXISTS, INSERT THE INDIVIDUALS
        ELSE UPDATE THE INDIVIDUALS
    */
CREATE DEFINER=root@localhost PROCEDURE encoder_save_individual (
    IN couplesid INT,
    IN indv_id_m INT UNSIGNED,
    IN lastname_m VARCHAR(100),
    IN firstname_m VARCHAR(100),
    IN middle_m VARCHAR(100),
    IN extname_m VARCHAR(100),
    IN age_years_m INT,
    IN birthdate_m DATE,
    IN civil_status_m INT,
    IN educ_bckgrnd_m INT,
    IN attendee_m INT,

    IN indv_id_f INT UNSIGNED,
    IN lastname_f VARCHAR(100),
    IN firstname_f VARCHAR(100),
    IN middle_f VARCHAR(100),
    IN age_years_f INT,
    IN birthdate_f DATE,
    IN civil_status_f INT,
    IN educ_bckgrnd_f INT,
    IN attendee_f INT
    )  MODIFIES SQL DATA
proc_exit_point :
BEGIN
    DECLARE TEXT_MESSAGE VARCHAR(100);

    IF ( IFNULL( couplesid, 0 ) = 0 ) THEN
        SELECT "CANNOT SAVE RECORD WITH GIVEN PARAMETERS" AS MESSAGE;
        LEAVE proc_exit_point;
    END IF;

    IF (TRIM(IFNULL(lastname_m, '')) <> '' AND TRIM(IFNULL(firstname_m, '')) <> '') THEN
        BEGIN
            IF (IFNULL( indv_id_m, 0 ) = 0 ) THEN
                INSERT INTO rpfp.individual (
                            COUPLES_ID,
                            LNAME,
                            FNAME,
                            MNAME,
                            EXT_NAME,
                            AGE,
                            SEX,
                            BDATE,
                            CIVIL_ID,
                            EDUC_BCKGRND_ID,
                            IS_ATTENDEE
                        )
                    VALUES (
                            couplesid,
                            lastname_m,
                            firstname_m,
                            middle_m,
                            extname_m,
                            age_years_m,
                            1,
                            birthdate_m,
                            civil_status_m,
                            educ_bckgrnd_m,
                            attendee_m
                        )
                ;
                SELECT "NEW INSERT MALE: " INTO TEXT_MESSAGE;
            ELSE
                UPDATE rpfp.individual ic
                    SET ic.LNAME = IF( IFNULL( lastname_m, '') = '', ic.LNAME, lastname_m ),
                        ic.FNAME = IF( IFNULL( firstname_m, '') = '', ic.FNAME, firstname_m ),
                        ic.MNAME = IF( IFNULL( middle_m, '') = '', ic.MNAME, middle_m ),
                        ic.EXT_NAME = IF( IFNULL( extname_m, '') = '', ic.EXT_NAME, extname_m ),
                        ic.AGE = IF( IFNULL( age_years_m, '') = '', ic.AGE, age_years_m ),
                        ic.BDATE = IF( IFNULL( birthdate_m, '') = '', ic.BDATE, birthdate_m ),
                        ic.CIVIL_ID = IF( IFNULL( civil_status_m, '') = '', ic.CIVIL_ID, civil_status_m ),
                        ic.EDUC_BCKGRND_ID = IF( IFNULL( educ_bckgrnd_m, '') = '', ic.EDUC_BCKGRND_ID, educ_bckgrnd_m ),
                        ic.IS_ATTENDEE = IF( IFNULL( attendee_m, '0') = '0', 0, 1 )
                WHERE ic.COUPLES_ID = couplesid
                    AND ic.SEX = 1
                ;
                SELECT "UPDATE MALE: " INTO TEXT_MESSAGE;
            END IF;
        END;
    END IF;
    IF (TRIM(IFNULL(lastname_f, '')) <> '' AND TRIM(IFNULL(firstname_f, '')) <> '') THEN
        BEGIN
            IF ( IFNULL( indv_id_f, 0 ) = 0 ) THEN
                INSERT INTO rpfp.individual (
                            COUPLES_ID,
                            LNAME,
                            FNAME,
                            MNAME,
                            AGE,
                            SEX,
                            BDATE,
                            CIVIL_ID,
                            EDUC_BCKGRND_ID,
                            IS_ATTENDEE
                        )
                    VALUES (
                            couplesid,
                            lastname_f,
                            firstname_f,
                            middle_f,
                            age_years_f,
                            2,
                            birthdate_f,
                            civil_status_f,
                            educ_bckgrnd_f,
                            attendee_f
                        )
                ;
                SELECT CONCAT(TEXT_MESSAGE, '; ',  "NEW INSERT FEMALE: ") INTO TEXT_MESSAGE;
            ELSE
                UPDATE rpfp.individual ic
                    SET ic.LNAME = IF( IFNULL( lastname_f, '') = '', ic.LNAME, lastname_f ),
                        ic.FNAME = IF( IFNULL( firstname_f, '') = '', ic.FNAME, firstname_f ),
                        ic.MNAME = IF( IFNULL( middle_f, '') = '', ic.MNAME, middle_f ),
                        ic.AGE = IF( IFNULL( age_years_f, '') = '', ic.AGE, age_years_f ),
                        ic.BDATE = IF( IFNULL( birthdate_f, '') = '', ic.BDATE, birthdate_f ),
                        ic.CIVIL_ID = IF( IFNULL( civil_status_f, '') = '', ic.CIVIL_ID, civil_status_f ),
                        ic.EDUC_BCKGRND_ID = IF( IFNULL( educ_bckgrnd_f, '') = '', ic.EDUC_BCKGRND_ID, educ_bckgrnd_f ),
                        ic.IS_ATTENDEE = IF( IFNULL( attendee_f, '0') = '0', 0, 1 )
                WHERE ic.COUPLES_ID = couplesid
                    AND ic.SEX = 2
                ;
                SELECT CONCAT(TEXT_MESSAGE, '; ', "UPDATE FEMALE: ") INTO TEXT_MESSAGE;
            END IF;
        END;
    END IF;
    SELECT TEXT_MESSAGE AS MESSAGE;
END$$

CREATE DEFINER=root@localhost PROCEDURE encoder_save_fp_details (
    IN fp_details_id INT,
    IN couplesid INT,
    IN mfp_used INT,
    IN mfp_shift INT,
    IN tfp_type INT,
    IN tfp_status INT,
    IN mfp_intention_use INT,
    IN reason_use INT
    )  MODIFIES SQL DATA
proc_exit_point :
BEGIN
    IF ( IFNULL( couplesid, 0 ) = 0 ) THEN
        SELECT "CANNOT SAVE RECORD WITH GIVEN PARAMETERS" AS MESSAGE;
        LEAVE proc_exit_point;
    END IF;

    IF ( IFNULL( fp_details_id, 0 ) = 0 ) THEN
        INSERT INTO rpfp.fp_details (
                COUPLES_ID,
                MFP_METHOD_USED_ID,
                MFP_INTENTION_SHIFT_ID,
                TFP_TYPE_ID,
                TFP_STATUS_ID,
                MFP_INTENTION_USE_ID,
                REASON_INTENDING_USE_ID
            )
        VALUES (
                couplesid,
                mfp_used,
                mfp_shift,
                tfp_type,
                tfp_status,
                mfp_intention_use,
                reason_use
            )
        ;

        SELECT CONCAT( "NEW ENTRY: ", LAST_INSERT_ID() ) AS MESSAGE;
        LEAVE proc_exit_point;
    END IF;

     UPDATE rpfp.fp_details fd
        SET fd.MFP_METHOD_USED_ID = IF( IFNULL( mfp_used, '') = '', fd.MFP_METHOD_USED_ID, mfp_used ),
            fd.MFP_INTENTION_SHIFT_ID = IF( IFNULL( mfp_shift, '') = '', fd.MFP_INTENTION_SHIFT_ID, mfp_shift ),
            fd.TFP_TYPE_ID = IF( IFNULL( tfp_type, '') = '', fd.TFP_TYPE_ID, tfp_type ),                            
            fd.TFP_STATUS_ID = IF( IFNULL( tfp_status, '') = '', fd.TFP_STATUS_ID, tfp_status ),                       
            fd.MFP_INTENTION_USE_ID = IF( IFNULL( mfp_intention_use, '') = '', fd.MFP_INTENTION_USE_ID, mfp_intention_use ),
            fd.REASON_INTENDING_USE_ID = IF( IFNULL( reason_use, '') = '', fd.REASON_INTENDING_USE_ID, reason_use)
      WHERE fd.COUPLES_ID = couplesid
    ;

    SELECT "SUCCESS!" AS MESSAGE;
    
END$$

CREATE DEFINER=root@localhost PROCEDURE encoder_save_fp_service (
    IN fp_service_id INT UNSIGNED,
    IN couplesid INT,
    IN date_visit DATE,
    IN fp_served_id INT,
    IN provider_type_id INT,
    IN is_counseling INT,
    IN other_concern INT,
    IN counseled_fp INT,
    IN other_specify VARCHAR(100),
    IN is_provided_service INT,
    IN date_served DATE,
    IN client_advise VARCHAR(100),
    IN referral_name VARCHAR(50),
    IN provider_name VARCHAR(50)
    )  MODIFIES SQL DATA
proc_exit_point :
BEGIN
    DECLARE count_served INT UNSIGNED;

    IF ( IFNULL( couplesid, 0 ) = 0 ) THEN
        SELECT "UNABLE TO GET RECORD WITH GIVEN PARAMETERS" AS MESSAGE;
        LEAVE proc_exit_point;
    END IF;

    SELECT COUNT(*) INTO count_served FROM rpfp.fp_service WHERE COUPLES_ID = couplesid;
    
    IF ( count_served > 0 ) THEN
        -- UPDATE rpfp.fp_service fs
        --     SET fs.DATE_VISIT = IF( IFNULL( date_visit, '') = '', fs.DATE_VISIT, date_visit ),
        --         fs.FP_SERVED_ID = IF( IFNULL( fp_served_id, '') = '', fs.FP_SERVED_ID, fp_served_id ),
        --         fs.PROVIDER_TYPE_ID = IF( IFNULL( provider_type_id, '') = '', fs.PROVIDER_TYPE_ID, provider_type_id ),
        --         fs.IS_COUNSELING = IF( IFNULL( is_counseling, '') = '', fs.IS_COUNSELING, is_counseling ),
        --         fs.OTHER_CONCERN = IF( IFNULL( other_concern, '') = '', fs.OTHER_CONCERN, other_concern ),
        --         fs.COUNSELED_TO_USE = IF( IFNULL( counseled_fp, '') = '', fs.COUNSELED_TO_USE, counseled_fp ),
        --         fs.OTHER_REASONS_SPECIFY = IF( IFNULL( other_specify, '') = '', fs.OTHER_REASONS_SPECIFY, other_specify ),
        --         fs.IS_PROVIDED_SERVICE = IF( IFNULL( is_provided_service, '') = '', fs.IS_PROVIDED_SERVICE, is_provided_service ),
        --         fs.DATE_SERVED = IF( IFNULL( date_served, '') = '', fs.DATE_SERVED, date_served ),
        --         fs.CLIENT_ADVISE = IF( IFNULL( client_advise, '') = '', fs.CLIENT_ADVISE, client_advise ),
        --         fs.REFERRAL_NAME = IF( IFNULL( referral_name, '') = '', fs.REFERRAL_NAME, referral_name ),
        --         fs.PROVIDER_NAME = IF( IFNULL( provider_name, '') = '', fs.PROVIDER_NAME, provider_name )
        --   WHERE fs.COUPLES_ID = couples_id
        -- ;
        SELECT "DATA ALREADY EXIST" AS MESSAGE;
    ELSE
        INSERT INTO rpfp.fp_service (
                    COUPLES_ID,
                    DATE_VISIT,
                    FP_SERVED_ID,
                    PROVIDER_TYPE_ID,
                    IS_COUNSELING,
                    OTHER_CONCERN,
                    COUNSELED_TO_USE,
                    OTHER_REASONS_SPECIFY,
                    IS_PROVIDED_SERVICE,
                    DATE_SERVED,
                    CLIENT_ADVISE,
                    REFERRAL_NAME,
                    PROVIDER_NAME,
                    DATE_ENCODED
            )
            VALUES (
                    couplesid,
                    date_visit,
                    fp_served_id,
                    provider_type_id,
                    is_counseling,
                    other_concern,
                    counseled_fp,
                    other_specify,
                    is_provided_service,
                    date_served,
                    client_advise,
                    referral_name,
                    provider_name,
                    CURRENT_DATE()
            )
        ;
        SELECT "FP SERVICE ADDED" AS MESSAGE;         
    END IF;
    
END$$
/** END COUPLES DETAILS */

/**  VERIFY COUPLES DETAILS  */
CREATE DEFINER=root@localhost PROCEDURE focal_verify_couples (
    IN couplesid INT UNSIGNED
    )  MODIFIES SQL DATA
proc_exit_point :
BEGIN
    
    IF ( IFNULL(couplesid, 0 ) = 0 ) THEN
        SELECT "CANNOT SAVE RECORD WITH GIVEN PARAMETERS" AS MESSAGE;
        LEAVE proc_exit_point;
    END IF;

     INSERT INTO rpfp.couples_verified (
                    COUPLES_ID, 
                    DATE_VERIFIED
                ) VALUES (
                    couplesid, 
                    CURRENT_DATE()
                )
    ;

    SELECT "COUPLES VERIFIED!" AS MESSAGE;
END$$
/** END VERIFY COUPLES DETAILS */

/**  APPROVE COUPLES DETAILS  */
CREATE DEFINER=root@localhost PROCEDURE rdm_approve_couples (
    IN couplesid INT UNSIGNED
    )  MODIFIES SQL DATA
proc_exit_point :
BEGIN
    
    IF ( IFNULL(couplesid, 0 ) = 0 ) THEN
        SELECT "CANNOT SAVE RECORD WITH GIVEN PARAMETERS" AS MESSAGE;
        LEAVE proc_exit_point;
    END IF;

     UPDATE rpfp.couples apc
        SET apc.IS_ACTIVE = 0
      WHERE apc.COUPLES_ID = couplesid
    ;

     INSERT INTO rpfp.track_approved (
                    COUPLES_ID, 
                    DATE_APPROVED
                ) VALUES (
                    couplesid, 
                    CURRENT_DATE()
                )
    ;

    SELECT "COUPLES APPROVED!" AS MESSAGE;
END$$
/** END APPROVE COUPLES DETAILS */

/**  DELETE REPORT  */
CREATE DEFINER=root@localhost PROCEDURE delete_report_demandgen (
    IN report_no VARCHAR(100)
    )  MODIFIES SQL DATA
proc_exit_point :
BEGIN
    
    IF report_no IS NULL THEN
        SELECT "NO RECORD FOUND" AS MESSAGE;
        LEAVE proc_exit_point;
    END IF;

     UPDATE rpfp.report_demandgen
        SET IS_ACTIVE = 1
      WHERE DEMANDGEN_ID = report_no
    ;

    SELECT "REPORT DELETED!" AS MESSAGE;
END$$

CREATE DEFINER=root@localhost PROCEDURE delete_report_unmet_need (
    IN report_no VARCHAR(100)
    )  MODIFIES SQL DATA
proc_exit_point :
BEGIN
    
    IF report_no IS NULL THEN
        SELECT "NO RECORD FOUND" AS MESSAGE;
        LEAVE proc_exit_point;
    END IF;

     UPDATE rpfp.report_unmet_need
        SET IS_ACTIVE = 1
      WHERE UNMET_ID = report_no
    ;

    SELECT "REPORT DELETED!" AS MESSAGE;
END$$

CREATE DEFINER=root@localhost PROCEDURE delete_report_served_method_mix (
    IN report_no VARCHAR(100)
    )  MODIFIES SQL DATA
proc_exit_point :
BEGIN
    
    IF report_no IS NULL THEN
        SELECT "NO RECORD FOUND" AS MESSAGE;
        LEAVE proc_exit_point;
    END IF;

     UPDATE rpfp.report_served_method_mix
        SET IS_ACTIVE = 1
      WHERE SERVED_ID = report_no
    ;

    SELECT "REPORT DELETED!" AS MESSAGE;
END$$

CREATE DEFINER=root@localhost PROCEDURE delete_report_accomplishment (
    IN report_no VARCHAR(100)
    )  MODIFIES SQL DATA
proc_exit_point :
BEGIN
    
    IF report_no IS NULL THEN
        SELECT "NO RECORD FOUND" AS MESSAGE;
        LEAVE proc_exit_point;
    END IF;

     UPDATE rpfp.report_couples_encoded
        SET IS_ACTIVE = 1
      WHERE ACCOM_ID = report_no
    ;

     UPDATE rpfp.report_duplicate_encoded   
        SET IS_ACTIVE = 1
      WHERE ACCOM_ID = report_no
    ;

    SELECT "REPORT DELETED!" AS MESSAGE;
END$$
/** END DELETE REPORT */

/** SAVE TARGET COUPLES */
CREATE DEFINER=root@localhost PROCEDURE rdm_save_target (
    IN target_id INT,
    IN target_year INT,
    IN target_month INT,
    IN psgc_id INT,
    IN target_count INT
    )  MODIFIES SQL DATA
proc_exit_point :
BEGIN
    IF ( IFNULL( target_id, 0 ) = 0 ) THEN
        INSERT INTO rpfp.target_couples (
                TARGET_YEAR,
                TARGET_MONTH,
                PSGC_ID,
                TARGET_COUNT
            )
        VALUES (
                target_year,
                target_month,
                psgc_id,
                target_count
            )
        ;

        SELECT CONCAT( "NEW ENTRY: ", LAST_INSERT_ID() ) AS MESSAGE;
        LEAVE proc_exit_point;
    END IF;

     UPDATE rpfp.target_couples tc
        SET tc.TARGET_YEAR = IF( IFNULL( target_year, '') = '', tc.TARGET_YEAR, target_year ),                           
            tc.TARGET_MONTH = IF( IFNULL( target_month, '') = '', tc.TARGET_MONTH, target_month ),
            tc.PSGC_ID = IF( IFNULL( psgc_id, '') = '', tc.PSGC_ID, psgc_id ), 
            tc.TARGET_COUNT = IF( IFNULL( target_count, '') = '', tc.TARGET_COUNT, target_count)
      WHERE tc.TARGET_ID = target_id
    ;

    SELECT "SUCCESS!" AS MESSAGE;
    
END$$
/** END SAVE TARGET COUPLES */


/** SEARCH PENDING COUPLES */
CREATE DEFINER=root@localhost PROCEDURE search_pending_data (
    IN loc_province INT,
    IN loc_municipality INT,
    IN loc_barangay INT,
    IN class_number VARCHAR(100),
    IN search_date_from DATE,
    IN search_date_to DATE,
    IN type_class INT,
    IN couples_name VARCHAR(100),
    IN search_age_from INT,
    IN search_age_to INT,
    IN no_child INT,
    IN mfp_used INT,
    IN tfp_used INT,
    IN intention_status VARCHAR(50),
    IN intention_use INT,
    IN search_status INT,
    IN status_active INT,
    IN page_no INT,
    IN items_per_page INT
    )   READS SQL DATA
proc_exit_point :
BEGIN
    DECLARE type_class_range INT;
    DECLARE search_child_from INT;
    DECLARE search_child_to INT;
    DECLARE search_mfp_from INT;
    DECLARE search_mfp_to INT;
    DECLARE search_tfp_from INT;
    DECLARE search_tfp_to INT;
    DECLARE search_intention_from INT;
    DECLARE search_intention_to INT;
    DECLARE search_intentionfp_from INT;
    DECLARE search_intentionfp_to INT;

    DECLARE location_code_from INT;
    DECLARE location_code_to INT;
    
    DECLARE barangay_id_no INT;
    DECLARE record_id INT;
    /** 
    SEARCH_STATUS
        1 - all data in approved
        2 - unmet need
        3 - served unmet need
        4 - shifters
        5 - served shifters
    */
    DECLARE name_user VARCHAR(50);
    DECLARE db_user_name VARCHAR(50);
    DECLARE user_scope INT;
    DECLARE user_location INT;
    DECLARE multiplier INT;
    DECLARE is_not_encoder INT(1);
    DECLARE read_offset INT;
    
    CALL rpfp.lib_extract_user_name( USER(), name_user, db_user_name );
    SET user_scope := rpfp.profile_get_scope( name_user );
    SET multiplier := rpfp.lib_get_multiplier( user_scope );
    SET user_location := rpfp.profile_get_location( name_user, user_scope );
    SET is_not_encoder := NOT IFNULL(rpfp.profile_check_if_encoder(), FALSE);

    IF (IFNULL( search_status, 0 ) = 0 ) THEN
        SET search_status = 1;
    END IF;

    /** set default location of user */
    SET location_code_from = user_location * POWER(10, multiplier);
    SET location_code_to = (user_location + 1) * POWER(10, multiplier) - 1;

    /** set location being searched for */
    IF (IFNULL( loc_barangay, 0 ) <> 0 ) THEN
        SET location_code_from = loc_barangay;
        SET location_code_to = loc_barangay;
    ELSE
        IF (IFNULL( loc_municipality, 0 ) <> 0 ) THEN
            SET location_code_from = loc_municipality * POWER(10, 3);
            SET location_code_to = (loc_municipality + 1) * POWER(10, 3) - 1;
        ELSE
            IF (IFNULL( loc_province, 0 ) <> 0 ) THEN
                SET location_code_from = loc_province * POWER(10, 5);
                SET location_code_to = (loc_province + 1) * POWER(10, 5) - 1;
            END IF;
        END IF;
    END IF;

    /** set other default values */
    IF (IFNULL( search_age_from, 0 ) = 0) THEN
        SET search_age_from = 0;
    END IF;

    IF (IFNULL( search_age_to, 0 ) = 0) THEN
        SET search_age_to = 200;
    END IF;

    IF (IFNULL( no_child, 0 ) = 0) THEN
        SET search_child_from = 0;
        SET search_child_to = 200;
    END IF;

    IF (IFNULL( status_active, 0 ) = 0 ) THEN
        SET status_active = 0;
    END IF;

    IF (IFNULL( search_date_from, 0 ) = 0 ) THEN
        SET search_date_from = DATE(CONCAT(YEAR(NOW()),'-01-01'));
    END IF;

    IF (IFNULL( search_date_to, 0 ) = 0 ) THEN
        SET search_date_to = DATE(CONCAT(YEAR(NOW()),'-12-31'));
    END IF;

    IF (IFNULL( no_child, 0 ) = 0) THEN
        SET search_child_from = 0;
        SET search_child_to = 200;
    END IF;
   
    /** 
    SEARCH_STATUS
        1 - all data in pending
    */
                
        IF (IFNULL( type_class, 0 ) = 0 ) THEN
            SET type_class = 1;
            SET type_class_range = 7;
        ELSE
            SET type_class_range = type_class;
        END IF;

        IF NOT EXISTS (
            SELECT rc.RPFP_CLASS_ID
            FROM rpfp.RPFP_CLASS rc
        LEFT JOIN rpfp.couples apc
                ON apc.RPFP_CLASS_ID = rc.RPFP_CLASS_ID
            WHERE apc.IS_ACTIVE = status_active
              AND (   rc.DB_USER_ID = name_user
                   OR (   is_not_encoder
                      AND user_location = (rc.BARANGAY_ID DIV POWER( 10, multiplier ))
                    )
                )
        ) THEN
                SELECT NULL AS rpfpclass,
                        NULL AS typeclass,
                        NULL AS others_specify,
                        NULL AS province_name,
                        NULL AS municipality_name,
                        NULL AS barangay,
                        NULL AS class_no,
                        NULL AS couples_encoded,
                        NULL AS served_count,
                        NULL AS date_conduct,
                        NULL AS lastname,
                        NULL AS firstname
                ;
        ELSE
            IF (IFNULL( page_no, 0) = 0) THEN
                /** DEFAULT PAGE NO. */
            SET page_no := 1;
            END IF;
            IF (IFNULL( items_per_page, 0) = 0) THEN
                /** DEFAULT COUNT PER PAGE*/
            SET items_per_page := 10;
            END IF;

            SELECT rc.RPFP_CLASS_ID AS rpfpclass,
                   rc.TYPE_CLASS_ID AS typeclass,
                   rc.OTHERS_SPECIFY AS others_specify,
                   prov.LOCATION_DESCRIPTION AS province_name,
                   city.LOCATION_DESCRIPTION AS municipality_name,
                   lp.LOCATION_DESCRIPTION AS barangay,
                   rc.CLASS_NUMBER AS class_no,
                   COUNT(apc.COUPLES_ID) AS couples_encoded,
                   COUNT(fs.COUPLES_ID) AS served_count,
                   rc.DATE_CONDUCTED AS date_conduct,
                   up.LAST_NAME AS lastname,
                   up.FIRST_NAME AS firstname
              FROM rpfp.rpfp_class rc 
         LEFT JOIN rpfp.couples apc ON apc.RPFP_CLASS_ID = rc.RPFP_CLASS_ID
         LEFT JOIN rpfp.fp_details fd ON fd.COUPLES_ID = apc.COUPLES_ID
         LEFT JOIN rpfp.lib_psgc_locations lp ON lp.PSGC_CODE = rc.BARANGAY_ID
         LEFT JOIN rpfp.lib_psgc_locations city ON city.PSGC_CODE = (lp.MUNICIPALITY_CODE * POWER( 10, 3 ))
         LEFT JOIN rpfp.lib_psgc_locations prov ON prov.PSGC_CODE = (lp.PROVINCE_CODE * POWER( 10, 5 ))
         LEFT JOIN rpfp.user_profile up ON up.DB_USER_ID = rc.DB_USER_ID
         LEFT JOIN rpfp.fp_service fs ON fs.COUPLES_ID = apc.COUPLES_ID
             WHERE rc.CLASS_NUMBER LIKE CONCAT('%',class_number,'%')
               AND lp.PSGC_CODE >= location_code_from
               AND lp.PSGC_CODE <= location_code_to
               AND (
                        rc.TYPE_CLASS_ID >= type_class
                    AND rc.TYPE_CLASS_ID <= type_class_range
                )
               AND (
                        rc.DATE_CONDUCTED >= search_date_from
                    AND rc.DATE_CONDUCTED <= search_date_to
                )
               AND apc.IS_ACTIVE = 2
               AND (   rc.DB_USER_ID = name_user
                   OR (   is_not_encoder
                      AND user_location = (rc.BARANGAY_ID DIV POWER( 10, multiplier ))
                    )
                )
        --   GROUP BY rc.RPFP_CLASS_ID
          ORDER BY rc.DATE_CONDUCTED DESC
             LIMIT read_offset, items_per_page
            ; 
        END IF;    
END$$
/** END SEARCH PENDING COUPLES */

/** SEARCH COUPLES */
CREATE DEFINER=root@localhost PROCEDURE search_data (
    IN loc_province INT,
    IN loc_municipality INT,
    IN loc_barangay INT,
    IN class_number VARCHAR(100),
    IN search_date_from DATE,
    IN search_date_to DATE,
    IN type_class INT,
    IN couples_name VARCHAR(100),
    IN search_age_from INT,
    IN search_age_to INT,
    IN no_child INT,
    IN mfp_used INT,
    IN tfp_used INT,
    IN intention_status VARCHAR(50),
    IN intention_use INT,
    IN search_status INT,
    IN status_active INT,
    IN page_no INT,
    IN items_per_page INT
    )   READS SQL DATA
proc_exit_point :
BEGIN
    DECLARE type_class_range INT;
    DECLARE search_child_from INT;
    DECLARE search_child_to INT;
    DECLARE search_mfp_from INT;
    DECLARE search_mfp_to INT;
    DECLARE search_tfp_from INT;
    DECLARE search_tfp_to INT;
    DECLARE search_intention_from INT;
    DECLARE search_intention_to INT;
    DECLARE search_intentionfp_from INT;
    DECLARE search_intentionfp_to INT;

    DECLARE location_code_from INT;
    DECLARE location_code_to INT;
    
    DECLARE barangay_id_no INT;
    DECLARE record_id INT;
    /** 
    SEARCH_STATUS
        1 - all data in approved
        2 - unmet need
        3 - served unmet need
        4 - shifters
        5 - served shifters
    */
    DECLARE name_user VARCHAR(50);
    DECLARE db_user_name VARCHAR(50);
    DECLARE user_scope INT;
    DECLARE user_location INT;
    DECLARE multiplier INT;
    DECLARE is_not_encoder INT(1);
    DECLARE read_offset INT;
    
    CALL rpfp.lib_extract_user_name( USER(), name_user, db_user_name );
    SET user_scope := rpfp.profile_get_scope( name_user );
    SET multiplier := rpfp.lib_get_multiplier( user_scope );
    SET user_location := rpfp.profile_get_location( name_user, user_scope );
    SET is_not_encoder := NOT IFNULL(rpfp.profile_check_if_encoder(), FALSE);

    IF (IFNULL( search_status, 0 ) = 0 ) THEN
        SET search_status = 1;
    END IF;

    /** set default location of user */
    SET location_code_from = user_location * POWER(10, multiplier);
    SET location_code_to = (user_location + 1) * POWER(10, multiplier) - 1;

    /** set location being searched for */
    IF (IFNULL( loc_barangay, 0 ) <> 0 ) THEN
        SET location_code_from = loc_barangay;
        SET location_code_to = loc_barangay;
    ELSE
        IF (IFNULL( loc_municipality, 0 ) <> 0 ) THEN
            SET location_code_from = loc_municipality * POWER(10, 3);
            SET location_code_to = (loc_municipality + 1) * POWER(10, 3) - 1;
        ELSE
            IF (IFNULL( loc_province, 0 ) <> 0 ) THEN
                SET location_code_from = loc_province * POWER(10, 5);
                SET location_code_to = (loc_province + 1) * POWER(10, 5) - 1;
            END IF;
        END IF;
    END IF;

    /** set other default values */
    IF (IFNULL( search_age_from, 0 ) = 0) THEN
        SET search_age_from = 0;
    END IF;

    IF (IFNULL( search_age_to, 0 ) = 0) THEN
        SET search_age_to = 200;
    END IF;

    IF (IFNULL( no_child, 0 ) = 0) THEN
        SET search_child_from = 0;
        SET search_child_to = 200;
    END IF;

    IF (IFNULL( status_active, 0 ) = 0 ) THEN
        SET status_active = 0;
    END IF;

    IF (IFNULL( search_date_from, 0 ) = 0 ) THEN
        SET search_date_from = DATE(CONCAT(YEAR(NOW()),'-01-01'));
    END IF;

    IF (IFNULL( search_date_to, 0 ) = 0 ) THEN
        SET search_date_to = DATE(CONCAT(YEAR(NOW()),'-12-31'));
    END IF;

    IF (IFNULL( no_child, 0 ) = 0) THEN
        SET search_child_from = 0;
        SET search_child_to = 200;
    END IF;
   
    /** 
    SEARCH_STATUS
        1 - all data in approved
    */
    IF search_status = 1 THEN
        IF (tfp_used > 0) or (mfp_used > 0) THEN
            CALL rpfp.get_class_list_all(
            location_code_from,
            location_code_to,
            class_number,
            search_date_from,
            search_date_to,
            type_class,
            couples_name,
            search_age_from,
            search_age_to,
            no_child,
            mfp_used,
            tfp_used,
            intention_status,
            intention_use,
            search_status,
            status_active,
            name_user,
            page_no,
            items_per_page
            );
            LEAVE proc_exit_point;
        END IF;
                
        IF (IFNULL( type_class, 0 ) = 0 ) THEN
            SET type_class = 1;
            SET type_class_range = 7;
        ELSE
            SET type_class_range = type_class;
        END IF;

        IF NOT EXISTS (
            SELECT rc.RPFP_CLASS_ID
            FROM rpfp.RPFP_CLASS rc
        LEFT JOIN rpfp.couples apc
                ON apc.RPFP_CLASS_ID = rc.RPFP_CLASS_ID
            WHERE apc.IS_ACTIVE = status_active
              AND (   rc.DB_USER_ID = name_user
                   OR (   is_not_encoder
                      AND user_location = (rc.BARANGAY_ID DIV POWER( 10, multiplier ))
                    )
                )
        ) THEN
                SELECT NULL AS rpfpclass,
                        NULL AS typeclass,
                        NULL AS others_specify,
                        NULL AS province_name,
                        NULL AS municipality_name,
                        NULL AS barangay,
                        NULL AS class_no,
                        NULL AS couples_encoded,
                        NULL AS served_count,
                        NULL AS date_conduct,
                        NULL AS lastname,
                        NULL AS firstname
                ;
        ELSE
            IF (IFNULL( page_no, 0) = 0) THEN
                /** DEFAULT PAGE NO. */
            SET page_no := 1;
            END IF;
            IF (IFNULL( items_per_page, 0) = 0) THEN
                /** DEFAULT COUNT PER PAGE*/
            SET items_per_page := 10;
            END IF;

            SELECT rc.RPFP_CLASS_ID AS rpfpclass,
                   rc.TYPE_CLASS_ID AS typeclass,
                   rc.OTHERS_SPECIFY AS others_specify,
                   prov.LOCATION_DESCRIPTION AS province_name,
                   city.LOCATION_DESCRIPTION AS municipality_name,
                   lp.LOCATION_DESCRIPTION AS barangay,
                   rc.CLASS_NUMBER AS class_no,
                   COUNT(apc.COUPLES_ID) AS couples_encoded,
                   COUNT(fs.COUPLES_ID) AS served_count,
                   rc.DATE_CONDUCTED AS date_conduct,
                   up.LAST_NAME AS lastname,
                   up.FIRST_NAME AS firstname
              FROM rpfp.rpfp_class rc 
         LEFT JOIN rpfp.couples apc ON apc.RPFP_CLASS_ID = rc.RPFP_CLASS_ID
         LEFT JOIN rpfp.individual ic ON ic.COUPLES_ID = apc.COUPLES_ID
         LEFT JOIN rpfp.fp_details fd ON fd.COUPLES_ID = ic.COUPLES_ID
         LEFT JOIN rpfp.lib_psgc_locations lp ON lp.PSGC_CODE = rc.BARANGAY_ID
         LEFT JOIN rpfp.lib_psgc_locations city ON city.PSGC_CODE = (lp.MUNICIPALITY_CODE * POWER( 10, 3 ))
         LEFT JOIN rpfp.lib_psgc_locations prov ON prov.PSGC_CODE = (lp.PROVINCE_CODE * POWER( 10, 5 ))
         LEFT JOIN rpfp.user_profile up ON up.DB_USER_ID = rc.DB_USER_ID
         LEFT JOIN rpfp.fp_service fs ON fs.COUPLES_ID = apc.COUPLES_ID
             WHERE rc.CLASS_NUMBER LIKE CONCAT('%',class_number,'%')
               AND lp.PSGC_CODE >= location_code_from
               AND lp.PSGC_CODE <= location_code_to
               AND (
                        rc.TYPE_CLASS_ID >= type_class
                    AND rc.TYPE_CLASS_ID <= type_class_range
                )
               AND (
                        rc.DATE_CONDUCTED >= search_date_from
                    AND rc.DATE_CONDUCTED <= search_date_to
                )
               AND apc.IS_ACTIVE = status_active
               AND (   rc.DB_USER_ID = name_user
                   OR (   is_not_encoder
                      AND user_location = (rc.BARANGAY_ID DIV POWER( 10, multiplier ))
                    )
                )
               AND (
                        ic.FNAME LIKE CONCAT('%',couples_name,'%')
                     OR ic.LNAME LIKE CONCAT('%',couples_name,'%')
                )
               AND ic.AGE >= search_age_from
               AND ic.AGE <= search_age_to
               AND apc.NO_CHILDREN >= search_child_from
               AND apc.NO_CHILDREN <= search_child_to
        --   GROUP BY rc.RPFP_CLASS_ID
          ORDER BY rc.DATE_CONDUCTED DESC
             LIMIT read_offset, items_per_page
            ; 
        END IF;
        LEAVE proc_exit_point;
    END IF;
    

    /** 
    SEARCH_STATUS
        2 - unmet need
    */
    IF search_status = 2 THEN    
        IF tfp_used > 0 THEN
            CALL rpfp.get_class_list_unmet(
            location_code_from,
            location_code_to,
            class_number,
            search_date_from,
            search_date_to,
            type_class,
            couples_name,
            search_age_from,
            search_age_to,
            no_child,
            mfp_used,
            tfp_used,
            intention_status,
            intention_use,
            search_status,
            status_active,
            name_user,
            page_no,
            items_per_page
            );
            LEAVE proc_exit_point;
        END IF;
        
        IF mfp_used > 0 THEN
            CALL rpfp.get_class_list_unmet(
            location_code_from,
            location_code_to,
            class_number,
            search_date_from,
            search_date_to,
            type_class,
            couples_name,
            search_age_from,
            search_age_to,
            no_child,
            mfp_used,
            tfp_used,
            intention_status,
            intention_use,
            search_status,
            status_active,
            name_user,
            page_no,
            items_per_page
            );
            LEAVE proc_exit_point;
        END IF;
        
        IF (IFNULL( type_class, 0 ) = 0 ) THEN
            SET type_class = 1;
            SET type_class_range = 7;
        ELSE
            SET type_class_range = type_class;
        END IF;

        IF NOT EXISTS (
            SELECT rc.RPFP_CLASS_ID
            FROM rpfp.RPFP_CLASS rc
        LEFT JOIN rpfp.couples apc
                ON apc.RPFP_CLASS_ID = rc.RPFP_CLASS_ID
            WHERE apc.IS_ACTIVE = status_active
              AND (   rc.DB_USER_ID = name_user
                   OR (   is_not_encoder
                      AND user_location = (rc.BARANGAY_ID DIV POWER( 10, multiplier ))
                    )
                )
        ) THEN
                SELECT NULL AS rpfpclass,
                        NULL AS typeclass,
                        NULL AS others_specify,
                        NULL AS province_name,
                        NULL AS municipality_name,
                        NULL AS barangay,
                        NULL AS class_no,
                        NULL AS couples_encoded,
                        NULL AS served_count,
                        NULL AS date_conduct,
                        NULL AS lastname,
                        NULL AS firstname
                ;
        ELSE
            IF (IFNULL( page_no, 0) = 0) THEN
                /** DEFAULT PAGE NO. */
            SET page_no := 1;
            END IF;
            IF (IFNULL( items_per_page, 0) = 0) THEN
                /** DEFAULT COUNT PER PAGE*/
            SET items_per_page := 10;
            END IF;

            SET read_offset := (page_no - 1) * items_per_page;
            SELECT rc.RPFP_CLASS_ID AS rpfpclass,
                   rc.TYPE_CLASS_ID AS typeclass,
                   rc.OTHERS_SPECIFY AS others_specify,
                   prov.LOCATION_DESCRIPTION AS province_name,
                   city.LOCATION_DESCRIPTION AS municipality_name,
                   lp.LOCATION_DESCRIPTION AS barangay,
                   rc.CLASS_NUMBER AS class_no,
                   COUNT(apc.COUPLES_ID) AS couples_encoded,
                   COUNT(fs.COUPLES_ID) AS served_count,
                   rc.DATE_CONDUCTED AS date_conduct,
                   up.LAST_NAME AS lastname,
                   up.FIRST_NAME AS firstname
              FROM rpfp.rpfp_class rc 
         LEFT JOIN rpfp.couples apc ON apc.RPFP_CLASS_ID = rc.RPFP_CLASS_ID
         LEFT JOIN rpfp.individual ic ON ic.COUPLES_ID = apc.COUPLES_ID
         LEFT JOIN rpfp.fp_details fd ON fd.COUPLES_ID = ic.COUPLES_ID
         LEFT JOIN rpfp.lib_psgc_locations lp ON lp.PSGC_CODE = rc.BARANGAY_ID
         LEFT JOIN rpfp.lib_psgc_locations city ON city.PSGC_CODE = (lp.MUNICIPALITY_CODE * POWER( 10, 3 ))
         LEFT JOIN rpfp.lib_psgc_locations prov ON prov.PSGC_CODE = (lp.PROVINCE_CODE * POWER( 10, 5 ))
         LEFT JOIN rpfp.user_profile up ON up.DB_USER_ID = rc.DB_USER_ID
         LEFT JOIN rpfp.fp_service fs ON fs.COUPLES_ID = apc.COUPLES_ID
             WHERE rc.CLASS_NUMBER LIKE CONCAT('%',class_number,'%')
               AND lp.PSGC_CODE >= location_code_from
               AND lp.PSGC_CODE <= location_code_to
               AND (
                        rc.TYPE_CLASS_ID >= type_class
                    AND rc.TYPE_CLASS_ID <= type_class_range
                )
               AND (
                        rc.DATE_CONDUCTED >= search_date_from
                    AND rc.DATE_CONDUCTED <= search_date_to
                )
               AND apc.IS_ACTIVE = status_active
               AND (   rc.DB_USER_ID = name_user
                   OR (   is_not_encoder
                      AND user_location = (rc.BARANGAY_ID DIV POWER( 10, multiplier ))
                    )
                )
               AND (
                        ic.FNAME LIKE CONCAT('%',couples_name,'%')
                     OR ic.LNAME LIKE CONCAT('%',couples_name,'%')
                )
               AND ic.AGE >= search_age_from
               AND ic.AGE <= search_age_to
               AND apc.NO_CHILDREN >= search_child_from
               AND apc.NO_CHILDREN <= search_child_to
               AND (   
                       fd.TFP_TYPE_ID <= 5
                    OR fd.TFP_STATUS_ID = 'A'
                )
          GROUP BY rc.RPFP_CLASS_ID
          ORDER BY rc.DATE_CONDUCTED DESC
             LIMIT read_offset, items_per_page
            ; 
        END IF;
        LEAVE proc_exit_point;
    END IF;

    /** 
    SEARCH_STATUS
        3 - served unmet need
    */
    IF search_status = 3 THEN
        IF tfp_used > 0 THEN
            CALL rpfp.get_class_list_served_unmet(
            location_code_from,
            location_code_to,
            class_number,
            search_date_from,
            search_date_to,
            type_class,
            couples_name,
            search_age_from,
            search_age_to,
            no_child,
            mfp_used,
            tfp_used,
            intention_status,
            intention_use,
            search_status,
            status_active,
            name_user,
            page_no,
            items_per_page
            );
            LEAVE proc_exit_point;
        END IF;
        
        IF mfp_used > 0 THEN
            CALL rpfp.get_class_list_served_unmet(
            location_code_from,
            location_code_to,
            class_number,
            search_date_from,
            search_date_to,
            type_class,
            couples_name,
            search_age_from,
            search_age_to,
            no_child,
            mfp_used,
            tfp_used,
            intention_status,
            intention_use,
            search_status,
            status_active,
            name_user,
            page_no,
            items_per_page
            );
            LEAVE proc_exit_point;
        END IF;
        
        IF (IFNULL( type_class, 0 ) = 0 ) THEN
            SET type_class = 1;
            SET type_class_range = 7;
        ELSE
            SET type_class_range = type_class;
        END IF;

        IF NOT EXISTS (
            SELECT rc.RPFP_CLASS_ID
            FROM rpfp.RPFP_CLASS rc
        LEFT JOIN rpfp.couples apc
                ON apc.RPFP_CLASS_ID = rc.RPFP_CLASS_ID
            WHERE apc.IS_ACTIVE = status_active
              AND (   rc.DB_USER_ID = name_user
                   OR (   is_not_encoder
                      AND user_location = (rc.BARANGAY_ID DIV POWER( 10, multiplier ))
                    )
                )
        ) THEN
                 SELECT NULL AS rpfpclass,
                        NULL AS typeclass,
                        NULL AS others_specify,
                        NULL AS province_name,
                        NULL AS municipality_name,
                        NULL AS barangay,
                        NULL AS class_no,
                        NULL AS couples_encoded,
                        NULL AS served_count,
                        NULL AS date_conduct,
                        NULL AS lastname,
                        NULL AS firstname
                ;
        ELSE
            IF (IFNULL( page_no, 0) = 0) THEN
                /** DEFAULT PAGE NO. */
            SET page_no := 1;
            END IF;
            IF (IFNULL( items_per_page, 0) = 0) THEN
                /** DEFAULT COUNT PER PAGE*/
            SET items_per_page := 10;
            END IF;

            SET read_offset := (page_no - 1) * items_per_page;
            SELECT rc.RPFP_CLASS_ID AS rpfpclass,
                   rc.TYPE_CLASS_ID AS typeclass,
                   rc.OTHERS_SPECIFY AS others_specify,
                   prov.LOCATION_DESCRIPTION AS province_name,
                   city.LOCATION_DESCRIPTION AS municipality_name,
                   lp.LOCATION_DESCRIPTION AS barangay,
                   rc.CLASS_NUMBER AS class_no,
                   COUNT(apc.COUPLES_ID) AS couples_encoded,
                   COUNT(fs.COUPLES_ID) AS served_count,
                   rc.DATE_CONDUCTED AS date_conduct,
                   up.LAST_NAME AS lastname,
                   up.FIRST_NAME AS firstname
              FROM rpfp.rpfp_class rc 
         LEFT JOIN rpfp.couples apc ON apc.RPFP_CLASS_ID = rc.RPFP_CLASS_ID
         LEFT JOIN rpfp.individual ic ON ic.COUPLES_ID = apc.COUPLES_ID
         LEFT JOIN rpfp.fp_details fd ON fd.COUPLES_ID = ic.COUPLES_ID
         LEFT JOIN rpfp.fp_service fs ON fs.COUPLES_ID = apc.COUPLES_ID
         LEFT JOIN rpfp.lib_psgc_locations lp ON lp.PSGC_CODE = rc.BARANGAY_ID
         LEFT JOIN rpfp.lib_psgc_locations city ON city.PSGC_CODE = (lp.MUNICIPALITY_CODE * POWER( 10, 3 ))
         LEFT JOIN rpfp.lib_psgc_locations prov ON prov.PSGC_CODE = (lp.PROVINCE_CODE * POWER( 10, 5 ))
         LEFT JOIN rpfp.user_profile up ON up.DB_USER_ID = rc.DB_USER_ID
             WHERE rc.CLASS_NUMBER LIKE CONCAT('%',class_number,'%')
               AND lp.PSGC_CODE >= location_code_from
               AND lp.PSGC_CODE <= location_code_to
               AND (
                        rc.TYPE_CLASS_ID >= type_class
                    AND rc.TYPE_CLASS_ID <= type_class_range
                )
               AND (
                        rc.DATE_CONDUCTED >= search_date_from
                    AND rc.DATE_CONDUCTED <= search_date_to
                )
               AND apc.IS_ACTIVE = status_active
               AND (   rc.DB_USER_ID = name_user
                   OR (   is_not_encoder
                      AND user_location = (rc.BARANGAY_ID DIV POWER( 10, multiplier ))
                    )
                )
               AND (
                        ic.FNAME LIKE CONCAT('%',couples_name,'%')
                     OR ic.LNAME LIKE CONCAT('%',couples_name,'%')
                )
               AND ic.AGE >= search_age_from
               AND ic.AGE <= search_age_to
               AND apc.NO_CHILDREN >= search_child_from
               AND apc.NO_CHILDREN <= search_child_to
               AND fs.IS_PROVIDED_SERVICE = 1
               AND (   
                        fd.TFP_TYPE_ID <= 5
                     OR fd.TFP_STATUS_ID = 'A'
                )
          GROUP BY rc.RPFP_CLASS_ID
          ORDER BY rc.DATE_CONDUCTED DESC
             LIMIT read_offset, items_per_page
            ; 
        END IF;
        LEAVE proc_exit_point;
    END IF;
        
    /** 
    SEARCH_STATUS
        4 - shifters
    */
    IF search_status = 4 THEN
        IF tfp_used > 0 THEN
            CALL rpfp.get_class_list_shifters(
            location_code_from,
            location_code_to,
            class_number,
            search_date_from,
            search_date_to,
            type_class,
            couples_name,
            search_age_from,
            search_age_to,
            no_child,
            mfp_used,
            tfp_used,
            intention_status,
            intention_use,
            search_status,
            status_active,
            name_user,
            page_no,
            items_per_page
            );
            LEAVE proc_exit_point;
        END IF;
        
        IF mfp_used > 0 THEN
            CALL rpfp.get_class_list_shifters(
            location_code_from,
            location_code_to,
            class_number,
            search_date_from,
            search_date_to,
            type_class,
            couples_name,
            search_age_from,
            search_age_to,
            no_child,
            mfp_used,
            tfp_used,
            intention_status,
            intention_use,
            search_status,
            status_active,
            name_user,
            page_no,
            items_per_page
            );
            LEAVE proc_exit_point;
        END IF;
        
        IF (IFNULL( type_class, 0 ) = 0 ) THEN
            SET type_class = 1;
            SET type_class_range = 7;
        ELSE
            SET type_class_range = type_class;
        END IF;

        IF NOT EXISTS (
            SELECT rc.RPFP_CLASS_ID
            FROM rpfp.RPFP_CLASS rc
        LEFT JOIN rpfp.couples apc
                ON apc.RPFP_CLASS_ID = rc.RPFP_CLASS_ID
            WHERE apc.IS_ACTIVE = status_active
              AND (   rc.DB_USER_ID = name_user
                   OR (   is_not_encoder
                      AND user_location = (rc.BARANGAY_ID DIV POWER( 10, multiplier ))
                    )
                )
        ) THEN
                SELECT NULL AS rpfpclass,
                        NULL AS typeclass,
                        NULL AS others_specify,
                        NULL AS province_name,
                        NULL AS municipality_name,
                        NULL AS barangay,
                        NULL AS class_no,
                        NULL AS couples_encoded,
                        NULL AS served_count,
                        NULL AS date_conduct,
                        NULL AS lastname,
                        NULL AS firstname
                ;
        ELSE
            IF (IFNULL( page_no, 0) = 0) THEN
                /** DEFAULT PAGE NO. */
            SET page_no := 1;
            END IF;
            IF (IFNULL( items_per_page, 0) = 0) THEN
                /** DEFAULT COUNT PER PAGE*/
            SET items_per_page := 10;
            END IF;

            SET read_offset := (page_no - 1) * items_per_page;
            SELECT rc.RPFP_CLASS_ID AS rpfpclass,
                   rc.TYPE_CLASS_ID AS typeclass,
                   rc.OTHERS_SPECIFY AS others_specify,
                   prov.LOCATION_DESCRIPTION AS province_name,
                   city.LOCATION_DESCRIPTION AS municipality_name,
                   lp.LOCATION_DESCRIPTION AS barangay,
                   rc.CLASS_NUMBER AS class_no,
                   COUNT(apc.COUPLES_ID) AS couples_encoded,
                   COUNT(fs.COUPLES_ID) AS served_count,
                   rc.DATE_CONDUCTED AS date_conduct,
                   up.LAST_NAME AS lastname,
                   up.FIRST_NAME AS firstname
              FROM rpfp.rpfp_class rc 
         LEFT JOIN rpfp.couples apc ON apc.RPFP_CLASS_ID = rc.RPFP_CLASS_ID
         LEFT JOIN rpfp.individual ic ON ic.COUPLES_ID = apc.COUPLES_ID
         LEFT JOIN rpfp.fp_details fd ON fd.COUPLES_ID = ic.COUPLES_ID
         LEFT JOIN rpfp.lib_psgc_locations lp ON lp.PSGC_CODE = rc.BARANGAY_ID
         LEFT JOIN rpfp.lib_psgc_locations city ON city.PSGC_CODE = (lp.MUNICIPALITY_CODE * POWER( 10, 3 ))
         LEFT JOIN rpfp.lib_psgc_locations prov ON prov.PSGC_CODE = (lp.PROVINCE_CODE * POWER( 10, 5 ))
         LEFT JOIN rpfp.fp_service fs ON fs.COUPLES_ID = apc.COUPLES_ID
         LEFT JOIN rpfp.user_profile up ON up.DB_USER_ID = rc.DB_USER_ID
             WHERE rc.CLASS_NUMBER LIKE CONCAT('%',class_number,'%')
               AND lp.PSGC_CODE >= location_code_from
               AND lp.PSGC_CODE <= location_code_to
               AND (
                        rc.TYPE_CLASS_ID >= type_class
                    AND rc.TYPE_CLASS_ID <= type_class_range
                )
               AND (
                        rc.DATE_CONDUCTED >= search_date_from
                    AND rc.DATE_CONDUCTED <= search_date_to
                )
               AND apc.IS_ACTIVE = status_active
               AND (   rc.DB_USER_ID = name_user
                   OR (   is_not_encoder
                      AND user_location = (rc.BARANGAY_ID DIV POWER( 10, multiplier ))
                    )
                )
               AND (
                        ic.FNAME LIKE CONCAT('%',couples_name,'%')
                     OR ic.LNAME LIKE CONCAT('%',couples_name,'%')
                )
               AND ic.AGE >= search_age_from
               AND ic.AGE <= search_age_to
               AND apc.NO_CHILDREN >= search_child_from
               AND apc.NO_CHILDREN <= search_child_to
               AND fd.MFP_INTENTION_SHIFT_ID >= 1
          GROUP BY rc.RPFP_CLASS_ID
          ORDER BY rc.DATE_CONDUCTED DESC
             LIMIT read_offset, items_per_page
            ; 
        END IF;
        LEAVE proc_exit_point;
    END IF;
        
    /** 
    SEARCH_STATUS
        5 - served shifters
    */
    IF search_status = 5 THEN
        IF tfp_used > 0 THEN
            CALL rpfp.get_class_list_served_shifters(
            location_code_from,
            location_code_to,
            class_number,
            search_date_from,
            search_date_to,
            type_class,
            couples_name,
            search_age_from,
            search_age_to,
            no_child,
            mfp_used,
            tfp_used,
            intention_status,
            intention_use,
            search_status,
            status_active,
            name_user,
            page_no,
            items_per_page
            );
            LEAVE proc_exit_point;
        END IF;
        
        IF mfp_used > 0 THEN
            CALL rpfp.get_class_list_served_shifters(
            location_code_from,
            location_code_to,
            class_number,
            search_date_from,
            search_date_to,
            type_class,
            couples_name,
            search_age_from,
            search_age_to,
            no_child,
            mfp_used,
            tfp_used,
            intention_status,
            intention_use,
            search_status,
            status_active,
            name_user,
            page_no,
            items_per_page
            );
            LEAVE proc_exit_point;
        END IF;
        
        IF (IFNULL( type_class, 0 ) = 0 ) THEN
            SET type_class = 1;
            SET type_class_range = 7;
        ELSE
            SET type_class_range = type_class;
        END IF;

        IF NOT EXISTS (
            SELECT rc.RPFP_CLASS_ID
            FROM rpfp.RPFP_CLASS rc
        LEFT JOIN rpfp.couples apc
                ON apc.RPFP_CLASS_ID = rc.RPFP_CLASS_ID
            WHERE apc.IS_ACTIVE = status_active
              AND (   rc.DB_USER_ID = name_user
                   OR (   is_not_encoder
                      AND user_location = (rc.BARANGAY_ID DIV POWER( 10, multiplier ))
                    )
                )
        ) THEN
                SELECT NULL AS rpfpclass,
                        NULL AS typeclass,
                        NULL AS others_specify,
                        NULL AS province_name,
                        NULL AS municipality_name,
                        NULL AS barangay,
                        NULL AS class_no,
                        NULL AS couples_encoded,
                        NULL AS served_count,
                        NULL AS date_conduct,
                        NULL AS lastname,
                        NULL AS firstname
                ;
        ELSE
            IF (IFNULL( page_no, 0) = 0) THEN
                /** DEFAULT PAGE NO. */
            SET page_no := 1;
            END IF;
            IF (IFNULL( items_per_page, 0) = 0) THEN
                /** DEFAULT COUNT PER PAGE*/
            SET items_per_page := 10;
            END IF;

            SET read_offset := (page_no - 1) * items_per_page;
            SELECT rc.RPFP_CLASS_ID AS rpfpclass,
                   rc.TYPE_CLASS_ID AS typeclass,
                   rc.OTHERS_SPECIFY AS others_specify,
                   prov.LOCATION_DESCRIPTION AS province_name,
                   city.LOCATION_DESCRIPTION AS municipality_name,
                   lp.LOCATION_DESCRIPTION AS barangay,
                   rc.CLASS_NUMBER AS class_no,
                   COUNT(apc.COUPLES_ID) AS couples_encoded,
                   COUNT(fs.COUPLES_ID) AS served_count,
                   rc.DATE_CONDUCTED AS date_conduct,
                   up.LAST_NAME AS lastname,
                   up.FIRST_NAME AS firstname
              FROM rpfp.rpfp_class rc 
         LEFT JOIN rpfp.couples apc ON apc.RPFP_CLASS_ID = rc.RPFP_CLASS_ID
         LEFT JOIN rpfp.individual ic ON ic.COUPLES_ID = apc.COUPLES_ID
         LEFT JOIN rpfp.fp_details fd ON fd.COUPLES_ID = ic.COUPLES_ID
         LEFT JOIN rpfp.fp_service fs ON fs.COUPLES_ID = apc.COUPLES_ID
         LEFT JOIN rpfp.lib_psgc_locations lp ON lp.PSGC_CODE = rc.BARANGAY_ID
         LEFT JOIN rpfp.lib_psgc_locations city ON city.PSGC_CODE = (lp.MUNICIPALITY_CODE * POWER( 10, 3 ))
         LEFT JOIN rpfp.lib_psgc_locations prov ON prov.PSGC_CODE = (lp.PROVINCE_CODE * POWER( 10, 5 ))
         LEFT JOIN rpfp.user_profile up ON up.DB_USER_ID = rc.DB_USER_ID
             WHERE rc.CLASS_NUMBER LIKE CONCAT('%',class_number,'%')
               AND lp.PSGC_CODE >= location_code_from
               AND lp.PSGC_CODE <= location_code_to
               AND (
                        rc.TYPE_CLASS_ID >= type_class
                    AND rc.TYPE_CLASS_ID <= type_class_range
                )
               AND (
                        rc.DATE_CONDUCTED >= search_date_from
                    AND rc.DATE_CONDUCTED <= search_date_to
                )
               AND apc.IS_ACTIVE = status_active
               AND (   rc.DB_USER_ID = name_user
                   OR (   is_not_encoder
                      AND user_location = (rc.BARANGAY_ID DIV POWER( 10, multiplier ))
                    )
                )
               AND (
                        ic.FNAME LIKE CONCAT('%',couples_name,'%')
                     OR ic.LNAME LIKE CONCAT('%',couples_name,'%')
                )
               AND ic.AGE >= search_age_from
               AND ic.AGE <= search_age_to
               AND apc.NO_CHILDREN >= search_child_from
               AND apc.NO_CHILDREN <= search_child_to
               AND fs.IS_PROVIDED_SERVICE = 1
               AND fd.MFP_INTENTION_SHIFT_ID >= 1
          GROUP BY rc.RPFP_CLASS_ID
          ORDER BY rc.DATE_CONDUCTED DESC
             LIMIT read_offset, items_per_page
            ; 
        END IF;
        LEAVE proc_exit_point;
    END IF;
END$$

CREATE DEFINER=root@localhost PROCEDURE search_advance_approved (
    IN class_number VARCHAR(100),
    IN search_date_from DATE,
    IN search_date_to DATE,
    IN couples_name VARCHAR(100),
    IN search_age_from INT,
    IN search_age_to INT,
    IN search_status INT,
    IN page_no INT,
    IN items_per_page INT
    )   READS SQL DATA
proc_exit_point :
BEGIN
    /** 
    SEARCH_STATUS
        0 - all data
        1 - unmet need
        2 - served unmet need
        3 - shifters
        4 - served shifters
    */
    DECLARE status_approved INT DEFAULT 0;

    IF( IFNULL( couples_name, 0 ) = 0 ) THEN
        CALL rpfp.search_class(
            class_number,
            search_date_from,
            search_date_to,
            search_age_from,
            search_age_to,
            search_status,
            status_approved,
            USER(),
            page_no,
            items_per_page
        );
    ELSE
        CALL rpfp.search_couples(
             couples_name,
             status_approved,
             USER(),
             page_no,
             items_per_page
        );
    END IF;
END$$

CREATE DEFINER=root@localhost PROCEDURE search_couples_pending (
    IN search_couples VARCHAR(100),
    IN page_no INT,
    IN items_per_page INT
    )   READS SQL DATA
BEGIN
    DECLARE status_pending INT DEFAULT 2;
    CALL rpfp.search_couples(
            search_couples,
            status_pending,
            USER(),
            page_no,
            items_per_page
    );

END$$

CREATE DEFINER=root@localhost PROCEDURE search_couples_approved (
    IN search_couples VARCHAR(100),
    IN page_no INT,
    IN items_per_page INT
    )   READS SQL DATA
BEGIN
    DECLARE status_approved INT DEFAULT 0;
    CALL rpfp.search_couples(
            search_couples,
            status_approved,
            USER(),
            page_no,
            items_per_page
    );

END$$

CREATE DEFINER=root@localhost PROCEDURE search_couples(
    IN search_couples VARCHAR(100),
    IN status_active INT,
    IN username VARCHAR(50),
    IN page_no INT,
    IN items_per_page INT
    )   READS SQL DATA
BEGIN
    DECLARE name_user VARCHAR(50);
    DECLARE db_user_name VARCHAR(50);
    DECLARE read_offset INT;

    CALL rpfp.lib_extract_user_name( username, name_user, db_user_name );

    IF NOT EXISTS (
         SELECT rc.RPFP_CLASS_ID
           FROM rpfp.RPFP_CLASS rc
      LEFT JOIN rpfp.couples apc
             ON apc.RPFP_CLASS_ID = rc.RPFP_CLASS_ID
          WHERE apc.IS_ACTIVE = status_active
            AND rc.DB_USER_ID = name_user
    ) THEN
         SELECT NULL AS rpfpclass,
                NULL AS typeclass,
                NULL AS others_specify,
                NULL AS city,
                NULL AS barangay,
                NULL AS class_no,
                NULL AS date_conduct
        ;
    ELSE
        IF (IFNULL( page_no, 0) = 0) THEN
            /** DEFAULT PAGE NO. */
            SET page_no := 1;
        END IF;
        IF (IFNULL( items_per_page, 0) = 0) THEN
            /** DEFAULT COUNT PER PAGE*/
            SET items_per_page := 10;
        END IF;

        SET read_offset := (page_no - 1) * items_per_page;
        SELECT rc.RPFP_CLASS_ID AS rpfpclass,
               rc.TYPE_CLASS_ID AS typeclass,
               rc.OTHERS_SPECIFY AS others_specify,
               lp.LOCATION_DESCRIPTION AS barangay,
               rc.CLASS_NUMBER AS class_no,
               rc.DATE_CONDUCTED AS date_conduct
          FROM rpfp.rpfp_class rc 
     LEFT JOIN rpfp.couples apc ON apc.RPFP_CLASS_ID = rc.RPFP_CLASS_ID
     LEFT JOIN rpfp.individual ic ON ic.COUPLES_ID = apc.COUPLES_ID
     LEFT JOIN rpfp.lib_psgc_locations lp ON lp.PSGC_CODE = rc.BARANGAY_ID 
         WHERE apc.IS_ACTIVE = status_active
           AND rc.DB_USER_ID = name_user
           AND (
               ic.FNAME LIKE CONCAT('%',search_couples,'%')
            OR ic.LNAME LIKE CONCAT('%',search_couples,'%')
           )
      GROUP BY rc.CLASS_NUMBER
      ORDER BY rc.DATE_CONDUCTED DESC
         LIMIT read_offset, items_per_page
    ; 
    END IF;
END$$

CREATE DEFINER=root@localhost PROCEDURE search_class_pending (
    IN search_class VARCHAR(100),
    IN search_date_from DATE,
    IN search_date_to DATE,
    IN search_status INT,
    IN page_no INT,
    IN items_per_page INT
    )   READS SQL DATA
BEGIN
    DECLARE status_pending INT DEFAULT 2;
    CALL rpfp.search_class(
            search_class,
            search_date_from,
            search_date_to,
            status_pending,
            USER(),
            page_no,
            items_per_page
    );

END$$

CREATE DEFINER=root@localhost PROCEDURE search_class_approved (
    IN search_class VARCHAR(100),
    IN search_date_from DATE,
    IN search_date_to DATE,
    IN search_status INT,
    IN page_no INT,
    IN items_per_page INT
    )   READS SQL DATA
BEGIN
    DECLARE status_approved INT DEFAULT 0;
    CALL rpfp.search_class(
            search_class,
            search_date_from,
            search_date_to,
            status_approved,
            USER(),
            page_no,
            items_per_page
    );

END$$

CREATE DEFINER=root@localhost PROCEDURE search_class(
    IN search_class VARCHAR(100),
    IN search_date_from DATE,
    IN search_date_to DATE,
    IN search_age_from INT,
    IN search_age_to INT,
    IN search_status INT,
    IN status_active INT,
    IN username VARCHAR(50),
    IN page_no INT,
    IN items_per_page INT
    )   READS SQL DATA
BEGIN
    DECLARE name_user VARCHAR(50);
    DECLARE db_user_name VARCHAR(50);
    DECLARE read_offset INT;

    CALL rpfp.lib_extract_user_name( username, name_user, db_user_name );

    IF (IFNULL( search_status, NULL ) = NULL ) THEN
        SET search_status = 0;
    END IF;

    IF (IFNULL( search_date_from, 0 ) = 0 ) THEN
        SET search_date_from = YEAR(NOW()) & '-01-01';
    END IF;

    IF (IFNULL( search_date_to, 0 ) = 0 ) THEN
        SET search_date_to = YEAR(NOW()) & '-12-31';
    END IF;

    IF search_status = 0 THEN
        IF NOT EXISTS (
            SELECT rc.RPFP_CLASS_ID
            FROM rpfp.RPFP_CLASS rc
        LEFT JOIN rpfp.couples apc
                ON apc.RPFP_CLASS_ID = rc.RPFP_CLASS_ID
            WHERE apc.IS_ACTIVE = status_active
                AND rc.DB_USER_ID = name_user
        ) THEN
            SELECT NULL AS rpfpclass,
                    NULL AS typeclass,
                    NULL AS others_specify,
                    NULL AS city,
                    NULL AS barangay,
                    NULL AS class_no,
                    NULL AS date_conduct
            ;
        ELSE
            IF (IFNULL( page_no, 0) = 0) THEN
                /** DEFAULT PAGE NO. */
                SET page_no := 1;
            END IF;
            IF (IFNULL( items_per_page, 0) = 0) THEN
                /** DEFAULT COUNT PER PAGE*/
                SET items_per_page := 10;
            END IF;

            SET read_offset := (page_no - 1) * items_per_page;
            SELECT rc.RPFP_CLASS_ID AS rpfpclass,
                rc.TYPE_CLASS_ID AS typeclass,
                rc.OTHERS_SPECIFY AS others_specify,
                lp.LOCATION_DESCRIPTION AS barangay,
                rc.CLASS_NUMBER AS class_no,
                rc.DATE_CONDUCTED AS date_conduct
            FROM rpfp.rpfp_class rc 
        LEFT JOIN rpfp.couples apc ON apc.RPFP_CLASS_ID = rc.RPFP_CLASS_ID
        LEFT JOIN rpfp.individual ic ON ic.COUPLES_ID = apc.COUPLES_ID
        LEFT JOIN rpfp.lib_psgc_locations lp ON lp.PSGC_CODE = rc.BARANGAY_ID 
            WHERE rc.CLASS_NUMBER LIKE CONCAT('%',search_class,'%')
            AND apc.IS_ACTIVE = status_active
            AND rc.DB_USER_ID = name_user
            AND (
                rc.DATE_CONDUCTED >= search_date_from
            AND rc.DATE_CONDUCTED <= search_date_to
            )
        GROUP BY rc.CLASS_NUMBER
        ORDER BY rc.DATE_CONDUCTED DESC
            LIMIT read_offset, items_per_page
        ; 
        END IF;
    ELSE
        IF search_status = 1 THEN
        CALL rpfp.get_class_list_unmet(
            search_class,
            search_date_from,
            search_date_to,
            search_age_from,
            search_age_to,
            status_active,
            USER(),
            page_no,
            items_per_page
        );
        END IF;

        IF search_status = 2 THEN
        CALL rpfp.get_class_list_served_unmet(
            search_class,
            search_date_from,
            search_date_to,
            search_age_from,
            search_age_to,
            status_active,
            USER(),
            page_no,
            items_per_page
        );
        END IF;
        
        IF search_status = 3 THEN
        CALL rpfp.get_class_list_shifters(
            search_class,
            search_date_from,
            search_date_to,
            search_age_from,
            search_age_to,
            status_active,
            USER(),
            page_no,
            items_per_page
        );
        END IF;
        
        IF search_status = 4 THEN
        CALL rpfp.get_class_list_served_shifters(
            search_class,
            search_date_from,
            search_date_to,
            search_age_from,
            search_age_to,
            status_active,
            USER(),
            page_no,
            items_per_page
        );
        END IF;
    END IF;
END$$

CREATE DEFINER=root@localhost PROCEDURE get_class_list_all (
    IN location_code_from INT,
    IN location_code_to INT,
    IN class_number VARCHAR(100),
    IN search_date_from DATE,
    IN search_date_to DATE,
    IN type_class INT,
    IN couples_name VARCHAR(100),
    IN search_age_from INT,
    IN search_age_to INT,
    IN no_child INT,
    IN mfp_used INT,
    IN tfp_used INT,
    IN intention_status VARCHAR(50),
    IN intention_use INT,
    IN search_status INT,
    IN status_active INT,
    IN username VARCHAR(50),
    IN page_no INT,
    IN items_per_page INT
    )   READS SQL DATA
proc_exit_point :
BEGIN
    DECLARE type_class_range INT;
    DECLARE search_child_from INT;
    DECLARE search_child_to INT;
    DECLARE search_mfp_from INT;
    DECLARE search_mfp_to INT;
    DECLARE search_tfp_from INT;
    DECLARE search_tfp_to INT;
    DECLARE search_intention_from INT;
    DECLARE search_intention_to INT;
    DECLARE search_intentionfp_from INT;
    DECLARE search_intentionfp_to INT;
    /** 
    SEARCH STATUS
        1 - unmet need
        2 - served unmet need
        3 - shifters
        4 - served shifters
    */
    DECLARE name_user VARCHAR(50);
    DECLARE db_user_name VARCHAR(50);
    DECLARE read_offset INT;
    DECLARE user_scope INT;
    DECLARE user_location INT;
    DECLARE multiplier INT;
    DECLARE is_not_encoder INT(1);
    
    SET user_scope := rpfp.profile_get_scope( username );
    SET multiplier := rpfp.lib_get_multiplier( user_scope );
    SET user_location := rpfp.profile_get_location( username, user_scope );
    SET is_not_encoder := NOT IFNULL(rpfp.profile_check_if_encoder(), FALSE);

    IF (IFNULL( type_class, 0 ) = 0 ) THEN
        SET type_class = 1;
        SET type_class_range = 7;
    ELSE
        SET type_class_range = type_class;
    END IF;

    IF (IFNULL( no_child, 0 ) = 0) THEN
        SET search_child_from = 0;
        SET search_child_to = 200;
    END IF;

IF ( IFNULL( tfp_used, 0 ) = 0 ) THEN
    IF NOT EXISTS (
         SELECT rc.RPFP_CLASS_ID
           FROM rpfp.RPFP_CLASS rc
      LEFT JOIN rpfp.couples apc
             ON apc.RPFP_CLASS_ID = rc.RPFP_CLASS_ID
          WHERE apc.IS_ACTIVE = status_active
            AND (   rc.DB_USER_ID = name_user
                OR (   is_not_encoder
                    AND user_location = (rc.BARANGAY_ID DIV POWER( 10, multiplier ))
                )
            )
    ) THEN
                 SELECT NULL AS rpfpclass,
                        NULL AS typeclass,
                        NULL AS others_specify,
                        NULL AS province_name,
                        NULL AS municipality_name,
                        NULL AS barangay,
                        NULL AS class_no,
                        NULL AS couples_encoded,
                        NULL AS served_count,
                        NULL AS date_conduct,
                        NULL AS lastname,
                        NULL AS firstname
            ;
    ELSE
        IF (IFNULL( page_no, 0) = 0) THEN
            /** DEFAULT PAGE NO. */
        SET page_no := 1;
        END IF;
        IF (IFNULL( items_per_page, 0) = 0) THEN
            /** DEFAULT COUNT PER PAGE*/
        SET items_per_page := 10;
        END IF;

        SET read_offset := (page_no - 1) * items_per_page;
            SELECT rc.RPFP_CLASS_ID AS rpfpclass,
                   rc.TYPE_CLASS_ID AS typeclass,
                   rc.OTHERS_SPECIFY AS others_specify,
                   prov.LOCATION_DESCRIPTION AS province_name,
                   city.LOCATION_DESCRIPTION AS municipality_name,
                   lp.LOCATION_DESCRIPTION AS barangay,
                   rc.CLASS_NUMBER AS class_no,
                   COUNT(apc.COUPLES_ID) AS couples_encoded,
                   COUNT(fs.COUPLES_ID) AS served_count,
                   rc.DATE_CONDUCTED AS date_conduct,
                   up.LAST_NAME AS lastname,
                   up.FIRST_NAME AS firstname
              FROM rpfp.rpfp_class rc 
         LEFT JOIN rpfp.couples apc ON apc.RPFP_CLASS_ID = rc.RPFP_CLASS_ID
         LEFT JOIN rpfp.individual ic ON ic.COUPLES_ID = apc.COUPLES_ID
         LEFT JOIN rpfp.fp_details fd ON fd.COUPLES_ID = ic.COUPLES_ID
         LEFT JOIN rpfp.lib_psgc_locations lp ON lp.PSGC_CODE = rc.BARANGAY_ID
         LEFT JOIN rpfp.lib_psgc_locations city ON city.PSGC_CODE = (lp.MUNICIPALITY_CODE * POWER( 10, 3 ))
         LEFT JOIN rpfp.lib_psgc_locations prov ON prov.PSGC_CODE = (lp.PROVINCE_CODE * POWER( 10, 5 ))
         LEFT JOIN rpfp.fp_service fs ON fs.COUPLES_ID = apc.COUPLES_ID
         LEFT JOIN rpfp.user_profile up ON up.DB_USER_ID = rc.DB_USER_ID
             WHERE rc.CLASS_NUMBER LIKE CONCAT('%',class_number,'%')
               AND lp.PSGC_CODE >= location_code_from
               AND lp.PSGC_CODE <= location_code_to
               AND (
                        rc.TYPE_CLASS_ID >= type_class
                    AND rc.TYPE_CLASS_ID <= type_class_range
                )
               AND (
                        rc.DATE_CONDUCTED >= search_date_from
                    AND rc.DATE_CONDUCTED <= search_date_to
                )
               AND apc.IS_ACTIVE = status_active
               AND (   rc.DB_USER_ID = username
                   OR (   is_not_encoder
                      AND user_location = (rc.BARANGAY_ID DIV POWER( 10, multiplier ))
                    )
                )
               AND (
                        ic.FNAME LIKE CONCAT('%',couples_name,'%')
                     OR ic.LNAME LIKE CONCAT('%',couples_name,'%')
                )
               AND ic.AGE >= search_age_from
               AND ic.AGE <= search_age_to
               AND apc.NO_CHILDREN >= search_child_from
               AND apc.NO_CHILDREN <= search_child_to
               AND fd.MFP_METHOD_USED_ID = mfp_used
          GROUP BY rc.RPFP_CLASS_ID
          ORDER BY rc.DATE_CONDUCTED DESC
             LIMIT read_offset, items_per_page
        ; 
    END IF;
    LEAVE proc_exit_point;
END IF;

IF intention_status = 'A' THEN
    IF NOT EXISTS (
         SELECT rc.RPFP_CLASS_ID
           FROM rpfp.RPFP_CLASS rc
      LEFT JOIN rpfp.couples apc
             ON apc.RPFP_CLASS_ID = rc.RPFP_CLASS_ID
          WHERE apc.IS_ACTIVE = status_active
            AND rc.DB_USER_ID = name_user
    ) THEN
                 SELECT NULL AS rpfpclass,
                        NULL AS typeclass,
                        NULL AS others_specify,
                        NULL AS province_name,
                        NULL AS municipality_name,
                        NULL AS barangay,
                        NULL AS class_no,
                        NULL AS couples_encoded,
                        NULL AS served_count,
                        NULL AS date_conduct,
                        NULL AS lastname,
                        NULL AS firstname
            ;
    ELSE
        IF (IFNULL( intention_use, 0 ) = 0) THEN
            SET search_intention_from = intention_use;
            SET search_intention_to = intention_use;
        ELSE
            SET search_intention_from = '1';
            SET search_intention_to = '12';
        END IF;

        IF (IFNULL( page_no, 0) = 0) THEN
            /** DEFAULT PAGE NO. */
        SET page_no := 1;
        END IF;
        IF (IFNULL( items_per_page, 0) = 0) THEN
            /** DEFAULT COUNT PER PAGE*/
        SET items_per_page := 10;
        END IF;

        SET read_offset := (page_no - 1) * items_per_page;
            SELECT rc.RPFP_CLASS_ID AS rpfpclass,
                   rc.TYPE_CLASS_ID AS typeclass,
                   rc.OTHERS_SPECIFY AS others_specify,
                   prov.LOCATION_DESCRIPTION AS province_name,
                   city.LOCATION_DESCRIPTION AS municipality_name,
                   lp.LOCATION_DESCRIPTION AS barangay,
                   rc.CLASS_NUMBER AS class_no,
                   COUNT(apc.COUPLES_ID) AS couples_encoded,
                   COUNT(fs.COUPLES_ID) AS served_count,
                   rc.DATE_CONDUCTED AS date_conduct,
                   up.LAST_NAME AS lastname,
                   up.FIRST_NAME AS firstname
              FROM rpfp.rpfp_class rc 
         LEFT JOIN rpfp.couples apc ON apc.RPFP_CLASS_ID = rc.RPFP_CLASS_ID
         LEFT JOIN rpfp.individual ic ON ic.COUPLES_ID = apc.COUPLES_ID
         LEFT JOIN rpfp.fp_details fd ON fd.COUPLES_ID = ic.COUPLES_ID
         LEFT JOIN rpfp.lib_psgc_locations lp ON lp.PSGC_CODE = rc.BARANGAY_ID
         LEFT JOIN rpfp.lib_psgc_locations city ON city.PSGC_CODE = (lp.MUNICIPALITY_CODE * POWER( 10, 3 ))
         LEFT JOIN rpfp.lib_psgc_locations prov ON prov.PSGC_CODE = (lp.PROVINCE_CODE * POWER( 10, 5 ))
         LEFT JOIN rpfp.fp_service fs ON fs.COUPLES_ID = apc.COUPLES_ID
         LEFT JOIN rpfp.user_profile up ON up.DB_USER_ID = rc.DB_USER_ID
             WHERE rc.CLASS_NUMBER LIKE CONCAT('%',class_number,'%')
               AND lp.PSGC_CODE >= location_code_from
               AND lp.PSGC_CODE <= location_code_to
               AND (
                        rc.TYPE_CLASS_ID >= type_class
                    AND rc.TYPE_CLASS_ID <= type_class_range
                )
               AND (
                        rc.DATE_CONDUCTED >= search_date_from
                    AND rc.DATE_CONDUCTED <= search_date_to
                )
               AND apc.IS_ACTIVE = status_active
               AND (   rc.DB_USER_ID = name_user
                    OR (   is_not_encoder
                        AND user_location = (rc.BARANGAY_ID DIV POWER( 10, multiplier ))
                    )
                )
               AND (
                        ic.FNAME LIKE CONCAT('%',couples_name,'%')
                    OR ic.LNAME LIKE CONCAT('%',couples_name,'%')
                )
               AND ic.AGE >= search_age_from
               AND ic.AGE <= search_age_to
               AND apc.NO_CHILDREN >= search_child_from
               AND apc.NO_CHILDREN <= search_child_to
               AND fd.TFP_TYPE_ID = tfp_used
               AND fd.TFP_STATUS_ID = 'A'
               AND fd.MFP_INTENTION_USE_ID >= search_intentionfp_from
               AND fd.MFP_INTENTION_USE_ID <= search_intentionfp_to
          GROUP BY rc.RPFP_CLASS_ID
          ORDER BY rc.DATE_CONDUCTED DESC
             LIMIT read_offset, items_per_page
        ; 
    END IF;
ELSE
    IF NOT EXISTS (
         SELECT rc.RPFP_CLASS_ID
           FROM rpfp.RPFP_CLASS rc
      LEFT JOIN rpfp.couples apc
             ON apc.RPFP_CLASS_ID = rc.RPFP_CLASS_ID
          WHERE apc.IS_ACTIVE = status_active
            AND (   rc.DB_USER_ID = name_user
                OR (   is_not_encoder
                    AND user_location = (rc.BARANGAY_ID DIV POWER( 10, multiplier ))
                )
            )
    ) THEN
                 SELECT NULL AS rpfpclass,
                        NULL AS typeclass,
                        NULL AS others_specify,
                        NULL AS province_name,
                        NULL AS municipality_name,
                        NULL AS barangay,
                        NULL AS class_no,
                        NULL AS couples_encoded,
                        NULL AS served_count,
                        NULL AS date_conduct,
                        NULL AS lastname,
                        NULL AS firstname
            ;
    ELSE    
        IF (IFNULL( page_no, 0) = 0) THEN
            /** DEFAULT PAGE NO. */
        SET page_no := 1;
        END IF;
        IF (IFNULL( items_per_page, 0) = 0) THEN
            /** DEFAULT COUNT PER PAGE*/
        SET items_per_page := 10;
        END IF;

        SET read_offset := (page_no - 1) * items_per_page;
        
            SELECT rc.RPFP_CLASS_ID AS rpfpclass,
                   rc.TYPE_CLASS_ID AS typeclass,
                   rc.OTHERS_SPECIFY AS others_specify,
                   prov.LOCATION_DESCRIPTION AS province_name,
                   city.LOCATION_DESCRIPTION AS municipality_name,
                   lp.LOCATION_DESCRIPTION AS barangay,
                   rc.CLASS_NUMBER AS class_no,
                   COUNT(apc.COUPLES_ID) AS couples_encoded,
                   COUNT(fs.COUPLES_ID) AS served_count,
                   rc.DATE_CONDUCTED AS date_conduct,
                   up.LAST_NAME AS lastname,
                   up.FIRST_NAME AS firstname
              FROM rpfp.rpfp_class rc 
         LEFT JOIN rpfp.couples apc ON apc.RPFP_CLASS_ID = rc.RPFP_CLASS_ID
         LEFT JOIN rpfp.individual ic ON ic.COUPLES_ID = apc.COUPLES_ID
         LEFT JOIN rpfp.fp_details fd ON fd.COUPLES_ID = ic.COUPLES_ID
         LEFT JOIN rpfp.lib_psgc_locations lp ON lp.PSGC_CODE = rc.BARANGAY_ID
         LEFT JOIN rpfp.lib_psgc_locations city ON city.PSGC_CODE = (lp.MUNICIPALITY_CODE * POWER( 10, 3 ))
         LEFT JOIN rpfp.lib_psgc_locations prov ON prov.PSGC_CODE = (lp.PROVINCE_CODE * POWER( 10, 5 ))
         LEFT JOIN rpfp.fp_service ON fs.COUPLES_ID = apc.COUPLES_ID
         LEFT JOIN rpfp.user_profile up ON up.DB_USER_ID = rc.DB_USER_ID
             WHERE rc.CLASS_NUMBER LIKE CONCAT('%',class_number,'%')
               AND lp.PSGC_CODE >= location_code_from
               AND lp.PSGC_CODE <= location_code_to
               AND (
                        rc.TYPE_CLASS_ID >= type_class
                    AND rc.TYPE_CLASS_ID <= type_class_range
                )
               AND (
                        rc.DATE_CONDUCTED >= search_date_from
                    AND rc.DATE_CONDUCTED <= search_date_to
                )
               AND apc.IS_ACTIVE = status_active
               AND (   rc.DB_USER_ID = name_user
                    OR (   is_not_encoder
                        AND user_location = (rc.BARANGAY_ID DIV POWER( 10, multiplier ))
                        )
                    )
               AND (
                        ic.FNAME LIKE CONCAT('%',couples_name,'%')
                    OR ic.LNAME LIKE CONCAT('%',couples_name,'%')
                )
               AND ic.AGE >= search_age_from
               AND ic.AGE <= search_age_to
               AND apc.NO_CHILDREN >= search_child_from
               AND apc.NO_CHILDREN <= search_child_to
               AND fd.TFP_TYPE_ID = tfp_used
               AND fd.TFP_STATUS_ID LIKE CONCAT('%',intention_status,'%')
          GROUP BY rc.RPFP_CLASS_ID
          ORDER BY rc.DATE_CONDUCTED DESC
             LIMIT read_offset, items_per_page
        ; 
    END IF;
END IF;
END$$

CREATE DEFINER=root@localhost PROCEDURE get_class_list_unmet (
    IN location_code_from INT,
    IN location_code_to INT,
    IN class_number VARCHAR(100),
    IN search_date_from DATE,
    IN search_date_to DATE,
    IN type_class INT,
    IN couples_name VARCHAR(100),
    IN search_age_from INT,
    IN search_age_to INT,
    IN no_child INT,
    IN mfp_used INT,
    IN tfp_used INT,
    IN intention_status VARCHAR(50),
    IN intention_use INT,
    IN search_status INT,
    IN status_active INT,
    IN username VARCHAR(50),
    IN page_no INT,
    IN items_per_page INT
    )   READS SQL DATA
    proc_exit_point :
BEGIN
    DECLARE type_class_range INT;
    DECLARE search_child_from INT;
    DECLARE search_child_to INT;
    DECLARE search_mfp_from INT;
    DECLARE search_mfp_to INT;
    DECLARE search_tfp_from INT;
    DECLARE search_tfp_to INT;
    DECLARE search_intention_from INT;
    DECLARE search_intention_to INT;
    DECLARE search_intentionfp_from INT;
    DECLARE search_intentionfp_to INT;
    /** 
    SEARCH STATUS
        1 - unmet need
        2 - served unmet need
        3 - shifters
        4 - served shifters
    */
    DECLARE name_user VARCHAR(50);
    DECLARE db_user_name VARCHAR(50);
    DECLARE read_offset INT;
    DECLARE user_scope INT;
    DECLARE user_location INT;
    DECLARE multiplier INT;
    DECLARE is_not_encoder INT(1);
    
    CALL rpfp.lib_extract_user_name( USER(), name_user, db_user_name );
    SET user_scope := rpfp.profile_get_scope( name_user );
    SET multiplier := rpfp.lib_get_multiplier( user_scope );
    SET user_location := rpfp.profile_get_location( name_user, user_scope );
    SET is_not_encoder := NOT IFNULL(rpfp.profile_check_if_encoder(), FALSE);

    IF (IFNULL( type_class, 0 ) = 0 ) THEN
        SET type_class = 1;
        SET type_class_range = 7;
    ELSE
        SET type_class_range = type_class;
    END IF;

    IF (IFNULL( no_child, 0 ) = 0) THEN
        SET search_child_from = 0;
        SET search_child_to = 200;
    END IF;
    
    IF search_age_from < 15 THEN
        SET search_age_from = 15;
    END IF;

    IF search_age_to > 49 THEN
        SET search_age_to = 49;
    END IF;
        
IF ( IFNULL( tfp_used, 0 ) = 0 ) THEN
    IF NOT EXISTS (
         SELECT rc.RPFP_CLASS_ID
           FROM rpfp.RPFP_CLASS rc
      LEFT JOIN rpfp.couples apc
             ON apc.RPFP_CLASS_ID = rc.RPFP_CLASS_ID
          WHERE apc.IS_ACTIVE = status_active
            AND (   rc.DB_USER_ID = name_user
                OR (   is_not_encoder
                    AND user_location = (rc.BARANGAY_ID DIV POWER( 10, multiplier ))
                )
            )
    ) THEN
                 SELECT NULL AS rpfpclass,
                        NULL AS typeclass,
                        NULL AS others_specify,
                        NULL AS province_name,
                        NULL AS municipality_name,
                        NULL AS barangay,
                        NULL AS class_no,
                        NULL AS couples_encoded,
                        NULL AS served_count,
                        NULL AS date_conduct,
                        NULL AS lastname,
                        NULL AS firstname
            ;
    ELSE
        IF (IFNULL( page_no, 0) = 0) THEN
            /** DEFAULT PAGE NO. */
        SET page_no := 1;
        END IF;
        IF (IFNULL( items_per_page, 0) = 0) THEN
            /** DEFAULT COUNT PER PAGE*/
        SET items_per_page := 10;
        END IF;

        SET read_offset := (page_no - 1) * items_per_page;
            SELECT rc.RPFP_CLASS_ID AS rpfpclass,
                   rc.TYPE_CLASS_ID AS typeclass,
                   rc.OTHERS_SPECIFY AS others_specify,
                   prov.LOCATION_DESCRIPTION AS province_name,
                   city.LOCATION_DESCRIPTION AS municipality_name,
                   lp.LOCATION_DESCRIPTION AS barangay,
                   rc.CLASS_NUMBER AS class_no,
                   COUNT(apc.COUPLES_ID) AS couples_encoded,
                   COUNT(fs.COUPLES_ID) AS served_count,
                   rc.DATE_CONDUCTED AS date_conduct,
                   up.LAST_NAME AS lastname,
                   up.FIRST_NAME AS firstname
              FROM rpfp.rpfp_class rc 
         LEFT JOIN rpfp.couples apc ON apc.RPFP_CLASS_ID = rc.RPFP_CLASS_ID
         LEFT JOIN rpfp.individual ic ON ic.COUPLES_ID = apc.COUPLES_ID
         LEFT JOIN rpfp.fp_details fd ON fd.COUPLES_ID = ic.COUPLES_ID
         LEFT JOIN rpfp.lib_psgc_locations lp ON lp.PSGC_CODE = rc.BARANGAY_ID
         LEFT JOIN rpfp.lib_psgc_locations city ON city.PSGC_CODE = (lp.MUNICIPALITY_CODE * POWER( 10, 3 ))
         LEFT JOIN rpfp.lib_psgc_locations prov ON prov.PSGC_CODE = (lp.PROVINCE_CODE * POWER( 10, 5 ))
         LEFT JOIN rpfp.fp_service fs ON fs.COUPLES_ID = apc.COUPLES_ID
         LEFT JOIN rpfp.user_profile up ON up.DB_USER_ID = rc.DB_USER_ID
             WHERE rc.CLASS_NUMBER LIKE CONCAT('%',class_number,'%')
               AND lp.PSGC_CODE >= location_code_from
               AND lp.PSGC_CODE <= location_code_to
               AND (
                        rc.TYPE_CLASS_ID >= type_class
                    AND rc.TYPE_CLASS_ID <= type_class_range
                )
               AND (
                        rc.DATE_CONDUCTED >= search_date_from
                    AND rc.DATE_CONDUCTED <= search_date_to
                )
               AND apc.IS_ACTIVE = status_active
               AND (   rc.DB_USER_ID = name_user
                   OR (   is_not_encoder
                      AND user_location = (rc.BARANGAY_ID DIV POWER( 10, multiplier ))
                    )
                )
               AND (
                        ic.FNAME LIKE CONCAT('%',couples_name,'%')
                     OR ic.LNAME LIKE CONCAT('%',couples_name,'%')
                )
               AND ic.AGE >= search_age_from
               AND ic.AGE <= search_age_to
               AND apc.NO_CHILDREN >= search_child_from
               AND apc.NO_CHILDREN <= search_child_to
            AND (   
                   fd.TFP_TYPE_ID <= 5
                OR fd.TFP_STATUS_ID = 'A'
                )
               AND fd.MFP_METHOD_USED_ID = mfp_used
          GROUP BY rc.RPFP_CLASS_ID
          ORDER BY rc.DATE_CONDUCTED DESC
             LIMIT read_offset, items_per_page
        ; 
    END IF;
    LEAVE proc_exit_point;
END IF;

IF intention_status = 'A' THEN
    IF NOT EXISTS (
         SELECT rc.RPFP_CLASS_ID
           FROM rpfp.RPFP_CLASS rc
      LEFT JOIN rpfp.couples apc
             ON apc.RPFP_CLASS_ID = rc.RPFP_CLASS_ID
          WHERE apc.IS_ACTIVE = status_active
            AND rc.DB_USER_ID = name_user
    ) THEN
                 SELECT NULL AS rpfpclass,
                        NULL AS typeclass,
                        NULL AS others_specify,
                        NULL AS province_name,
                        NULL AS municipality_name,
                        NULL AS barangay,
                        NULL AS class_no,
                        NULL AS couples_encoded,
                        NULL AS served_count,
                        NULL AS date_conduct,
                        NULL AS lastname,
                        NULL AS firstname
            ;
    ELSE
        IF (IFNULL( intention_use, 0 ) = 0) THEN
            SET search_intention_from = intention_use;
            SET search_intention_to = intention_use;
        ELSE
            SET search_intention_from = '1';
            SET search_intention_to = '12';
        END IF;

        IF (IFNULL( page_no, 0) = 0) THEN
            /** DEFAULT PAGE NO. */
        SET page_no := 1;
        END IF;
        IF (IFNULL( items_per_page, 0) = 0) THEN
            /** DEFAULT COUNT PER PAGE*/
        SET items_per_page := 10;
        END IF;

        SET read_offset := (page_no - 1) * items_per_page;
            SELECT rc.RPFP_CLASS_ID AS rpfpclass,
                   rc.TYPE_CLASS_ID AS typeclass,
                   rc.OTHERS_SPECIFY AS others_specify,
                   prov.LOCATION_DESCRIPTION AS province_name,
                   city.LOCATION_DESCRIPTION AS municipality_name,
                   lp.LOCATION_DESCRIPTION AS barangay,
                   rc.CLASS_NUMBER AS class_no,
                   COUNT(apc.COUPLES_ID) AS couples_encoded,
                   COUNT(fs.COUPLES_ID) AS served_count,
                   rc.DATE_CONDUCTED AS date_conduct,
                   up.LAST_NAME AS lastname,
                   up.FIRST_NAME AS firstname
              FROM rpfp.rpfp_class rc 
         LEFT JOIN rpfp.couples apc ON apc.RPFP_CLASS_ID = rc.RPFP_CLASS_ID
         LEFT JOIN rpfp.individual ic ON ic.COUPLES_ID = apc.COUPLES_ID
         LEFT JOIN rpfp.fp_details fd ON fd.COUPLES_ID = ic.COUPLES_ID
         LEFT JOIN rpfp.lib_psgc_locations lp ON lp.PSGC_CODE = rc.BARANGAY_ID
         LEFT JOIN rpfp.lib_psgc_locations city ON city.PSGC_CODE = (lp.MUNICIPALITY_CODE * POWER( 10, 3 ))
         LEFT JOIN rpfp.lib_psgc_locations prov ON prov.PSGC_CODE = (lp.PROVINCE_CODE * POWER( 10, 5 ))
         LEFT JOIN rpfp.fp_service ON fs.COUPLES_ID = apc.COUPLES_ID
         LEFT JOIN rpfp.user_profile up ON up.DB_USER_ID = rc.DB_USER_ID
             WHERE rc.CLASS_NUMBER LIKE CONCAT('%',class_number,'%')
               AND lp.PSGC_CODE >= location_code_from
               AND lp.PSGC_CODE <= location_code_to
               AND (
                        rc.TYPE_CLASS_ID >= type_class
                    AND rc.TYPE_CLASS_ID <= type_class_range
                )
               AND (
                        rc.DATE_CONDUCTED >= search_date_from
                    AND rc.DATE_CONDUCTED <= search_date_to
                )
               AND apc.IS_ACTIVE = status_active
               AND (   rc.DB_USER_ID = name_user
                    OR (   is_not_encoder
                        AND user_location = (rc.BARANGAY_ID DIV POWER( 10, multiplier ))
                    )
                )
               AND (
                        ic.FNAME LIKE CONCAT('%',couples_name,'%')
                    OR ic.LNAME LIKE CONCAT('%',couples_name,'%')
                )
               AND ic.AGE >= search_age_from
               AND ic.AGE <= search_age_to
               AND apc.NO_CHILDREN >= search_child_from
               AND apc.NO_CHILDREN <= search_child_to
               AND (   
                       fd.TFP_TYPE_ID <= 5
                    OR fd.TFP_STATUS_ID = 'A'
                )
               AND fd.TFP_TYPE_ID = tfp_used
               AND fd.TFP_STATUS_ID = 'A'
               AND fd.MFP_INTENTION_USE_ID >= search_intentionfp_from
               AND fd.MFP_INTENTION_USE_ID <= search_intentionfp_to
          GROUP BY rc.RPFP_CLASS_ID
          ORDER BY rc.DATE_CONDUCTED DESC
             LIMIT read_offset, items_per_page
        ; 
    END IF;
ELSE
    IF NOT EXISTS (
         SELECT rc.RPFP_CLASS_ID
           FROM rpfp.RPFP_CLASS rc
      LEFT JOIN rpfp.couples apc
             ON apc.RPFP_CLASS_ID = rc.RPFP_CLASS_ID
          WHERE apc.IS_ACTIVE = status_active
            AND (   rc.DB_USER_ID = name_user
                OR (   is_not_encoder
                    AND user_location = (rc.BARANGAY_ID DIV POWER( 10, multiplier ))
                )
            )
    ) THEN
                 SELECT NULL AS rpfpclass,
                        NULL AS typeclass,
                        NULL AS others_specify,
                        NULL AS province_name,
                        NULL AS municipality_name,
                        NULL AS barangay,
                        NULL AS class_no,
                        NULL AS couples_encoded,
                        NULL AS served_count,
                        NULL AS date_conduct,
                        NULL AS lastname,
                        NULL AS firstname
            ;
    ELSE    
        IF (IFNULL( page_no, 0) = 0) THEN
            /** DEFAULT PAGE NO. */
        SET page_no := 1;
        END IF;
        IF (IFNULL( items_per_page, 0) = 0) THEN
            /** DEFAULT COUNT PER PAGE*/
        SET items_per_page := 10;
        END IF;

        SET read_offset := (page_no - 1) * items_per_page;
        
            SELECT rc.RPFP_CLASS_ID AS rpfpclass,
                   rc.TYPE_CLASS_ID AS typeclass,
                   rc.OTHERS_SPECIFY AS others_specify,
                   prov.LOCATION_DESCRIPTION AS province_name,
                   city.LOCATION_DESCRIPTION AS municipality_name,
                   lp.LOCATION_DESCRIPTION AS barangay,
                   rc.CLASS_NUMBER AS class_no,
                   COUNT(apc.COUPLES_ID) AS couples_encoded,
                   COUNT(fs.COUPLES_ID) AS served_count,
                   rc.DATE_CONDUCTED AS date_conduct,
                   up.LAST_NAME AS lastname,
                   up.FIRST_NAME AS firstname
              FROM rpfp.rpfp_class rc 
         LEFT JOIN rpfp.couples apc ON apc.RPFP_CLASS_ID = rc.RPFP_CLASS_ID
         LEFT JOIN rpfp.individual ic ON ic.COUPLES_ID = apc.COUPLES_ID
         LEFT JOIN rpfp.fp_details fd ON fd.COUPLES_ID = ic.COUPLES_ID
         LEFT JOIN rpfp.lib_psgc_locations lp ON lp.PSGC_CODE = rc.BARANGAY_ID
         LEFT JOIN rpfp.lib_psgc_locations city ON city.PSGC_CODE = (lp.MUNICIPALITY_CODE * POWER( 10, 3 ))
         LEFT JOIN rpfp.lib_psgc_locations prov ON prov.PSGC_CODE = (lp.PROVINCE_CODE * POWER( 10, 5 ))
         LEFT JOIN rpfp.fp_service ON fs.COUPLES_ID = apc.COUPLES_ID
         LEFT JOIN rpfp.user_profile up ON up.DB_USER_ID = rc.DB_USER_ID
             WHERE rc.CLASS_NUMBER LIKE CONCAT('%',class_number,'%')
               AND lp.PSGC_CODE >= location_code_from
               AND lp.PSGC_CODE <= location_code_to
               AND (
                        rc.TYPE_CLASS_ID >= type_class
                    AND rc.TYPE_CLASS_ID <= type_class_range
                )
               AND (
                        rc.DATE_CONDUCTED >= search_date_from
                    AND rc.DATE_CONDUCTED <= search_date_to
                )
               AND apc.IS_ACTIVE = status_active
               AND (   rc.DB_USER_ID = name_user
                    OR (   is_not_encoder
                        AND user_location = (rc.BARANGAY_ID DIV POWER( 10, multiplier ))
                        )
                    )
               AND (
                       ic.FNAME LIKE CONCAT('%',couples_name,'%')
                    OR ic.LNAME LIKE CONCAT('%',couples_name,'%')
                )
               AND ic.AGE >= search_age_from
               AND ic.AGE <= search_age_to
               AND apc.NO_CHILDREN >= search_child_from
               AND apc.NO_CHILDREN <= search_child_to
               AND (   
                       fd.TFP_TYPE_ID <= 5
                    OR fd.TFP_STATUS_ID = 'A'
                )
               AND fd.TFP_TYPE_ID = tfp_used
               AND fd.TFP_STATUS_ID LIKE CONCAT('%',intention_status,'%')
          GROUP BY rc.RPFP_CLASS_ID
          ORDER BY rc.DATE_CONDUCTED DESC
             LIMIT read_offset, items_per_page
        ; 
    END IF;
END IF;
END$$

CREATE DEFINER=root@localhost PROCEDURE get_class_list_served_unmet (
    IN location_code_from INT,
    IN location_code_to INT,
    IN class_number VARCHAR(100),
    IN search_date_from DATE,
    IN search_date_to DATE,
    IN type_class INT,
    IN couples_name VARCHAR(100),
    IN search_age_from INT,
    IN search_age_to INT,
    IN no_child INT,
    IN mfp_used INT,
    IN tfp_used INT,
    IN intention_status VARCHAR(50),
    IN intention_use INT,
    IN search_status INT,
    IN status_active INT,
    IN username VARCHAR(50),
    IN page_no INT,
    IN items_per_page INT
    )   READS SQL DATA
    proc_exit_point :
BEGIN
    DECLARE type_class_range INT;
    DECLARE search_child_from INT;
    DECLARE search_child_to INT;
    DECLARE search_mfp_from INT;
    DECLARE search_mfp_to INT;
    DECLARE search_tfp_from INT;
    DECLARE search_tfp_to INT;
    DECLARE search_intention_from INT;
    DECLARE search_intention_to INT;
    DECLARE search_intentionfp_from INT;
    DECLARE search_intentionfp_to INT;
    /** 
    SEARCH STATUS
        1 - unmet need
        2 - served unmet need
        3 - shifters
        4 - served shifters
    */
    DECLARE name_user VARCHAR(50);
    DECLARE db_user_name VARCHAR(50);
    DECLARE read_offset INT;
    DECLARE user_scope INT;
    DECLARE user_location INT;
    DECLARE multiplier INT;
    DECLARE is_not_encoder INT(1);
    
    CALL rpfp.lib_extract_user_name( USER(), name_user, db_user_name );
    SET user_scope := rpfp.profile_get_scope( name_user );
    SET multiplier := rpfp.lib_get_multiplier( user_scope );
    SET user_location := rpfp.profile_get_location( name_user, user_scope );
    SET is_not_encoder := NOT IFNULL(rpfp.profile_check_if_encoder(), FALSE);

    IF (IFNULL( type_class, 0 ) = 0 ) THEN
        SET type_class = 1;
        SET type_class_range = 7;
    ELSE
        SET type_class_range = type_class;
    END IF;

    IF (IFNULL( no_child, 0 ) = 0) THEN
        SET search_child_from = 0;
        SET search_child_to = 200;
    END IF;

    IF search_age_from < 15 THEN
        SET search_age_from = 15;
    END IF;

    IF search_age_to > 49 THEN
        SET search_age_to = 49;
    END IF;
    
IF ( IFNULL( tfp_used, 0 ) = 0 ) THEN
    IF NOT EXISTS (
         SELECT rc.RPFP_CLASS_ID
           FROM rpfp.RPFP_CLASS rc
      LEFT JOIN rpfp.couples apc
             ON apc.RPFP_CLASS_ID = rc.RPFP_CLASS_ID
          WHERE apc.IS_ACTIVE = status_active
            AND (   rc.DB_USER_ID = name_user
                OR (   is_not_encoder
                    AND user_location = (rc.BARANGAY_ID DIV POWER( 10, multiplier ))
                )
            )
    ) THEN
                 SELECT NULL AS rpfpclass,
                        NULL AS typeclass,
                        NULL AS others_specify,
                        NULL AS province_name,
                        NULL AS municipality_name,
                        NULL AS barangay,
                        NULL AS class_no,
                        NULL AS couples_encoded,
                        NULL AS served_count,
                        NULL AS date_conduct,
                        NULL AS lastname,
                        NULL AS firstname
            ;
    ELSE
        IF (IFNULL( page_no, 0) = 0) THEN
            /** DEFAULT PAGE NO. */
        SET page_no := 1;
        END IF;
        IF (IFNULL( items_per_page, 0) = 0) THEN
            /** DEFAULT COUNT PER PAGE*/
        SET items_per_page := 10;
        END IF;

        SET read_offset := (page_no - 1) * items_per_page;
            SELECT rc.RPFP_CLASS_ID AS rpfpclass,
                   rc.TYPE_CLASS_ID AS typeclass,
                   rc.OTHERS_SPECIFY AS others_specify,
                   prov.LOCATION_DESCRIPTION AS province_name,
                   city.LOCATION_DESCRIPTION AS municipality_name,
                   lp.LOCATION_DESCRIPTION AS barangay,
                   rc.CLASS_NUMBER AS class_no,
                   COUNT(apc.COUPLES_ID) AS couples_encoded,
                   COUNT(fs.COUPLES_ID) AS served_count,
                   rc.DATE_CONDUCTED AS date_conduct,
                   up.LAST_NAME AS lastname,
                   up.FIRST_NAME AS firstname
              FROM rpfp.rpfp_class rc 
         LEFT JOIN rpfp.couples apc ON apc.RPFP_CLASS_ID = rc.RPFP_CLASS_ID
         LEFT JOIN rpfp.individual ic ON ic.COUPLES_ID = apc.COUPLES_ID
         LEFT JOIN rpfp.fp_details fd ON fd.COUPLES_ID = ic.COUPLES_ID
          LEFT JOIN rpfp.fp_service fs ON fs.COUPLES_ID = apc.COUPLES_ID
         LEFT JOIN rpfp.lib_psgc_locations lp ON lp.PSGC_CODE = rc.BARANGAY_ID
         LEFT JOIN rpfp.lib_psgc_locations city ON city.PSGC_CODE = (lp.MUNICIPALITY_CODE * POWER( 10, 3 ))
         LEFT JOIN rpfp.lib_psgc_locations prov ON prov.PSGC_CODE = (lp.PROVINCE_CODE * POWER( 10, 5 ))
         LEFT JOIN rpfp.user_profile up ON up.DB_USER_ID = rc.DB_USER_ID
             WHERE rc.CLASS_NUMBER LIKE CONCAT('%',class_number,'%')
               AND lp.PSGC_CODE >= location_code_from
               AND lp.PSGC_CODE <= location_code_to
               AND (
                        rc.TYPE_CLASS_ID >= type_class
                    AND rc.TYPE_CLASS_ID <= type_class_range
                )
               AND (
                        rc.DATE_CONDUCTED >= search_date_from
                    AND rc.DATE_CONDUCTED <= search_date_to
                )
               AND apc.IS_ACTIVE = status_active
               AND (   rc.DB_USER_ID = name_user
                   OR (   is_not_encoder
                      AND user_location = (rc.BARANGAY_ID DIV POWER( 10, multiplier ))
                    )
                )
               AND (
                        ic.FNAME LIKE CONCAT('%',couples_name,'%')
                     OR ic.LNAME LIKE CONCAT('%',couples_name,'%')
                )
               AND ic.AGE >= search_age_from
               AND ic.AGE <= search_age_to
               AND apc.NO_CHILDREN >= search_child_from
               AND apc.NO_CHILDREN <= search_child_to
               AND fs.IS_PROVIDED_SERVICE = 1
               AND (   
                        fd.TFP_TYPE_ID <= 5
                     OR fd.TFP_STATUS_ID = 'A'
                )
               AND fd.MFP_METHOD_USED_ID = mfp_used
          GROUP BY rc.RPFP_CLASS_ID
          ORDER BY rc.DATE_CONDUCTED DESC
             LIMIT read_offset, items_per_page
        ; 
    END IF;
    LEAVE proc_exit_point;
END IF;

IF intention_status = 'A' THEN
    IF NOT EXISTS (
         SELECT rc.RPFP_CLASS_ID
           FROM rpfp.RPFP_CLASS rc
      LEFT JOIN rpfp.couples apc
             ON apc.RPFP_CLASS_ID = rc.RPFP_CLASS_ID
          WHERE apc.IS_ACTIVE = status_active
            AND rc.DB_USER_ID = name_user
    ) THEN
                 SELECT NULL AS rpfpclass,
                        NULL AS typeclass,
                        NULL AS others_specify,
                        NULL AS province_name,
                        NULL AS municipality_name,
                        NULL AS barangay,
                        NULL AS class_no,
                        NULL AS couples_encoded,
                        NULL AS served_count,
                        NULL AS date_conduct,
                        NULL AS lastname,
                        NULL AS firstname
            ;
    ELSE
        IF (IFNULL( intention_use, 0 ) = 0) THEN
            SET search_intention_from = intention_use;
            SET search_intention_to = intention_use;
        ELSE
            SET search_intention_from = '1';
            SET search_intention_to = '12';
        END IF;

        IF (IFNULL( page_no, 0) = 0) THEN
            /** DEFAULT PAGE NO. */
        SET page_no := 1;
        END IF;
        IF (IFNULL( items_per_page, 0) = 0) THEN
            /** DEFAULT COUNT PER PAGE*/
        SET items_per_page := 10;
        END IF;

        SET read_offset := (page_no - 1) * items_per_page;
            SELECT rc.RPFP_CLASS_ID AS rpfpclass,
                   rc.TYPE_CLASS_ID AS typeclass,
                   rc.OTHERS_SPECIFY AS others_specify,
                   prov.LOCATION_DESCRIPTION AS province_name,
                   city.LOCATION_DESCRIPTION AS municipality_name,
                   lp.LOCATION_DESCRIPTION AS barangay,
                   rc.CLASS_NUMBER AS class_no,
                   COUNT(apc.COUPLES_ID) AS couples_encoded,
                   COUNT(fs.COUPLES_ID) AS served_count,
                   rc.DATE_CONDUCTED AS date_conduct,
                   up.LAST_NAME AS lastname,
                   up.FIRST_NAME AS firstname
              FROM rpfp.rpfp_class rc 
         LEFT JOIN rpfp.couples apc ON apc.RPFP_CLASS_ID = rc.RPFP_CLASS_ID
         LEFT JOIN rpfp.individual ic ON ic.COUPLES_ID = apc.COUPLES_ID
         LEFT JOIN rpfp.fp_details fd ON fd.COUPLES_ID = ic.COUPLES_ID
          LEFT JOIN rpfp.fp_service fs ON fs.COUPLES_ID = apc.COUPLES_ID
         LEFT JOIN rpfp.lib_psgc_locations lp ON lp.PSGC_CODE = rc.BARANGAY_ID
         LEFT JOIN rpfp.lib_psgc_locations city ON city.PSGC_CODE = (lp.MUNICIPALITY_CODE * POWER( 10, 3 ))
         LEFT JOIN rpfp.lib_psgc_locations prov ON prov.PSGC_CODE = (lp.PROVINCE_CODE * POWER( 10, 5 ))
         LEFT JOIN rpfp.user_profile up ON up.DB_USER_ID = rc.DB_USER_ID
             WHERE rc.CLASS_NUMBER LIKE CONCAT('%',class_number,'%')
               AND lp.PSGC_CODE >= location_code_from
               AND lp.PSGC_CODE <= location_code_to
               AND (
                        rc.TYPE_CLASS_ID >= type_class
                    AND rc.TYPE_CLASS_ID <= type_class_range
                )
               AND (
                        rc.DATE_CONDUCTED >= search_date_from
                    AND rc.DATE_CONDUCTED <= search_date_to
                )
               AND apc.IS_ACTIVE = status_active
               AND (   rc.DB_USER_ID = name_user
                    OR (   is_not_encoder
                        AND user_location = (rc.BARANGAY_ID DIV POWER( 10, multiplier ))
                    )
                )
               AND (
                        ic.FNAME LIKE CONCAT('%',couples_name,'%')
                    OR ic.LNAME LIKE CONCAT('%',couples_name,'%')
                )
               AND ic.AGE >= search_age_from
               AND ic.AGE <= search_age_to
               AND apc.NO_CHILDREN >= search_child_from
               AND apc.NO_CHILDREN <= search_child_to
               AND fs.IS_PROVIDED_SERVICE = 1
               AND (   
                        fd.TFP_TYPE_ID <= 5
                     OR fd.TFP_STATUS_ID = 'A'
                )
               AND fd.TFP_TYPE_ID = tfp_used
               AND fd.TFP_STATUS_ID = 'A'
               AND fd.MFP_INTENTION_USE_ID >= search_intentionfp_from
               AND fd.MFP_INTENTION_USE_ID <= search_intentionfp_to
          GROUP BY rc.RPFP_CLASS_ID
          ORDER BY rc.DATE_CONDUCTED DESC
             LIMIT read_offset, items_per_page
        ; 
    END IF;
ELSE
    IF NOT EXISTS (
         SELECT rc.RPFP_CLASS_ID
           FROM rpfp.RPFP_CLASS rc
      LEFT JOIN rpfp.couples apc
             ON apc.RPFP_CLASS_ID = rc.RPFP_CLASS_ID
          WHERE apc.IS_ACTIVE = status_active
            AND (   rc.DB_USER_ID = name_user
                OR (   is_not_encoder
                    AND user_location = (rc.BARANGAY_ID DIV POWER( 10, multiplier ))
                )
            )
    ) THEN
                 SELECT NULL AS rpfpclass,
                        NULL AS typeclass,
                        NULL AS others_specify,
                        NULL AS province_name,
                        NULL AS municipality_name,
                        NULL AS barangay,
                        NULL AS class_no,
                        NULL AS couples_encoded,
                        NULL AS served_count,
                        NULL AS date_conduct,
                        NULL AS lastname,
                        NULL AS firstname
            ;
    ELSE    
        IF (IFNULL( page_no, 0) = 0) THEN
            /** DEFAULT PAGE NO. */
        SET page_no := 1;
        END IF;
        IF (IFNULL( items_per_page, 0) = 0) THEN
            /** DEFAULT COUNT PER PAGE*/
        SET items_per_page := 10;
        END IF;

        SET read_offset := (page_no - 1) * items_per_page;
        
            SELECT rc.RPFP_CLASS_ID AS rpfpclass,
                   rc.TYPE_CLASS_ID AS typeclass,
                   rc.OTHERS_SPECIFY AS others_specify,
                   prov.LOCATION_DESCRIPTION AS province_name,
                   city.LOCATION_DESCRIPTION AS municipality_name,
                   lp.LOCATION_DESCRIPTION AS barangay,
                   rc.CLASS_NUMBER AS class_no,
                   COUNT(apc.COUPLES_ID) AS couples_encoded,
                   COUNT(fs.COUPLES_ID) AS served_count,
                   rc.DATE_CONDUCTED AS date_conduct,
                   up.LAST_NAME AS lastname,
                   up.FIRST_NAME AS firstname
              FROM rpfp.rpfp_class rc 
         LEFT JOIN rpfp.couples apc ON apc.RPFP_CLASS_ID = rc.RPFP_CLASS_ID
         LEFT JOIN rpfp.individual ic ON ic.COUPLES_ID = apc.COUPLES_ID
         LEFT JOIN rpfp.fp_details fd ON fd.COUPLES_ID = ic.COUPLES_ID
          LEFT JOIN rpfp.fp_service fs ON fs.COUPLES_ID = apc.COUPLES_ID
         LEFT JOIN rpfp.lib_psgc_locations lp ON lp.PSGC_CODE = rc.BARANGAY_ID
         LEFT JOIN rpfp.lib_psgc_locations city ON city.PSGC_CODE = (lp.MUNICIPALITY_CODE * POWER( 10, 3 ))
         LEFT JOIN rpfp.lib_psgc_locations prov ON prov.PSGC_CODE = (lp.PROVINCE_CODE * POWER( 10, 5 ))
         LEFT JOIN rpfp.user_profile up ON up.DB_USER_ID = rc.DB_USER_ID
             WHERE rc.CLASS_NUMBER LIKE CONCAT('%',class_number,'%')
               AND lp.PSGC_CODE >= location_code_from
               AND lp.PSGC_CODE <= location_code_to
               AND (
                        rc.TYPE_CLASS_ID >= type_class
                    AND rc.TYPE_CLASS_ID <= type_class_range
                )
               AND (
                        rc.DATE_CONDUCTED >= search_date_from
                    AND rc.DATE_CONDUCTED <= search_date_to
                )
               AND apc.IS_ACTIVE = status_active
               AND (   rc.DB_USER_ID = name_user
                    OR (   is_not_encoder
                        AND user_location = (rc.BARANGAY_ID DIV POWER( 10, multiplier ))
                        )
                    )
               AND (
                        ic.FNAME LIKE CONCAT('%',couples_name,'%')
                    OR ic.LNAME LIKE CONCAT('%',couples_name,'%')
                )
               AND ic.AGE >= search_age_from
               AND ic.AGE <= search_age_to
               AND apc.NO_CHILDREN >= search_child_from
               AND apc.NO_CHILDREN <= search_child_to
               AND fs.IS_PROVIDED_SERVICE = 1
               AND (   
                        fd.TFP_TYPE_ID <= 5
                     OR fd.TFP_STATUS_ID = 'A'
                )
               AND fd.TFP_TYPE_ID = tfp_used
               AND fd.TFP_STATUS_ID LIKE CONCAT('%',intention_status,'%')
          GROUP BY rc.RPFP_CLASS_ID
          ORDER BY rc.DATE_CONDUCTED DESC
             LIMIT read_offset, items_per_page
        ; 
    END IF;
END IF;
END$$

CREATE DEFINER=root@localhost PROCEDURE get_class_list_shifters (
    IN location_code_from INT,
    IN location_code_to INT,
    IN class_number VARCHAR(100),
    IN search_date_from DATE,
    IN search_date_to DATE,
    IN type_class INT,
    IN couples_name VARCHAR(100),
    IN search_age_from INT,
    IN search_age_to INT,
    IN no_child INT,
    IN mfp_used INT,
    IN tfp_used INT,
    IN intention_status VARCHAR(50),
    IN intention_use INT,
    IN search_status INT,
    IN status_active INT,
    IN username VARCHAR(50),
    IN page_no INT,
    IN items_per_page INT
    )   READS SQL DATA
    proc_exit_point :
BEGIN
    DECLARE type_class_range INT;
    DECLARE search_child_from INT;
    DECLARE search_child_to INT;
    DECLARE search_mfp_from INT;
    DECLARE search_mfp_to INT;
    DECLARE search_tfp_from INT;
    DECLARE search_tfp_to INT;
    DECLARE search_intention_from INT;
    DECLARE search_intention_to INT;
    DECLARE search_intentionfp_from INT;
    DECLARE search_intentionfp_to INT;
    /** 
    SEARCH STATUS
        1 - unmet need
        2 - served unmet need
        3 - shifters
        4 - served shifters
    */
    DECLARE name_user VARCHAR(50);
    DECLARE db_user_name VARCHAR(50);
    DECLARE read_offset INT;
    DECLARE user_scope INT;
    DECLARE user_location INT;
    DECLARE multiplier INT;
    DECLARE is_not_encoder INT(1);
    
    CALL rpfp.lib_extract_user_name( USER(), name_user, db_user_name );
    SET user_scope := rpfp.profile_get_scope( name_user );
    SET multiplier := rpfp.lib_get_multiplier( user_scope );
    SET user_location := rpfp.profile_get_location( name_user, user_scope );
    SET is_not_encoder := NOT IFNULL(rpfp.profile_check_if_encoder(), FALSE);

    IF (IFNULL( type_class, 0 ) = 0 ) THEN
        SET type_class = 1;
        SET type_class_range = 7;
    ELSE
        SET type_class_range = type_class;
    END IF;

    IF (IFNULL( no_child, 0 ) = 0) THEN
        SET search_child_from = 0;
        SET search_child_to = 200;
    END IF;

IF ( IFNULL( tfp_used, 0 ) = 0 ) THEN
    IF NOT EXISTS (
         SELECT rc.RPFP_CLASS_ID
           FROM rpfp.RPFP_CLASS rc
      LEFT JOIN rpfp.couples apc
             ON apc.RPFP_CLASS_ID = rc.RPFP_CLASS_ID
          WHERE apc.IS_ACTIVE = status_active
            AND (   rc.DB_USER_ID = name_user
                OR (   is_not_encoder
                    AND user_location = (rc.BARANGAY_ID DIV POWER( 10, multiplier ))
                )
            )
    ) THEN
                 SELECT NULL AS rpfpclass,
                        NULL AS typeclass,
                        NULL AS others_specify,
                        NULL AS province_name,
                        NULL AS municipality_name,
                        NULL AS barangay,
                        NULL AS class_no,
                        NULL AS couples_encoded,
                        NULL AS served_count,
                        NULL AS date_conduct,
                        NULL AS lastname,
                        NULL AS firstname
            ;
    ELSE
        IF (IFNULL( page_no, 0) = 0) THEN
            /** DEFAULT PAGE NO. */
        SET page_no := 1;
        END IF;
        IF (IFNULL( items_per_page, 0) = 0) THEN
            /** DEFAULT COUNT PER PAGE*/
        SET items_per_page := 10;
        END IF;

        SET read_offset := (page_no - 1) * items_per_page;
            SELECT rc.RPFP_CLASS_ID AS rpfpclass,
                   rc.TYPE_CLASS_ID AS typeclass,
                   rc.OTHERS_SPECIFY AS others_specify,
                   prov.LOCATION_DESCRIPTION AS province_name,
                   city.LOCATION_DESCRIPTION AS municipality_name,
                   lp.LOCATION_DESCRIPTION AS barangay,
                   rc.CLASS_NUMBER AS class_no,
                   COUNT(apc.COUPLES_ID) AS couples_encoded,
                   COUNT(fs.COUPLES_ID) AS served_count,
                   rc.DATE_CONDUCTED AS date_conduct,
                   up.LAST_NAME AS lastname,
                   up.FIRST_NAME AS firstname
              FROM rpfp.rpfp_class rc 
         LEFT JOIN rpfp.couples apc ON apc.RPFP_CLASS_ID = rc.RPFP_CLASS_ID
         LEFT JOIN rpfp.individual ic ON ic.COUPLES_ID = apc.COUPLES_ID
         LEFT JOIN rpfp.fp_details fd ON fd.COUPLES_ID = ic.COUPLES_ID
         LEFT JOIN rpfp.lib_psgc_locations lp ON lp.PSGC_CODE = rc.BARANGAY_ID
         LEFT JOIN rpfp.lib_psgc_locations city ON city.PSGC_CODE = (lp.MUNICIPALITY_CODE * POWER( 10, 3 ))
         LEFT JOIN rpfp.lib_psgc_locations prov ON prov.PSGC_CODE = (lp.PROVINCE_CODE * POWER( 10, 5 ))
         LEFT JOIN rpfp.fp_service fs ON fs.COUPLES_ID = apc.COUPLES_ID
         LEFT JOIN rpfp.user_profile up ON up.DB_USER_ID = rc.DB_USER_ID
             WHERE rc.CLASS_NUMBER LIKE CONCAT('%',class_number,'%')
               AND lp.PSGC_CODE >= location_code_from
               AND lp.PSGC_CODE <= location_code_to
               AND (
                        rc.TYPE_CLASS_ID >= type_class
                    AND rc.TYPE_CLASS_ID <= type_class_range
                )
               AND (
                        rc.DATE_CONDUCTED >= search_date_from
                    AND rc.DATE_CONDUCTED <= search_date_to
                )
               AND apc.IS_ACTIVE = status_active
               AND (   rc.DB_USER_ID = name_user
                   OR (   is_not_encoder
                      AND user_location = (rc.BARANGAY_ID DIV POWER( 10, multiplier ))
                    )
                )
               AND (
                        ic.FNAME LIKE CONCAT('%',couples_name,'%')
                     OR ic.LNAME LIKE CONCAT('%',couples_name,'%')
                )
               AND ic.AGE >= search_age_from
               AND ic.AGE <= search_age_to
               AND apc.NO_CHILDREN >= search_child_from
               AND apc.NO_CHILDREN <= search_child_to
               AND fd.MFP_INTENTION_SHIFT_ID >= 1
               AND fd.MFP_METHOD_USED_ID = mfp_used
          GROUP BY rc.RPFP_CLASS_ID
          ORDER BY rc.DATE_CONDUCTED DESC
             LIMIT read_offset, items_per_page
        ; 
    END IF;
    LEAVE proc_exit_point;
END IF;

IF intention_status = 'A' THEN
    IF NOT EXISTS (
         SELECT rc.RPFP_CLASS_ID
           FROM rpfp.RPFP_CLASS rc
      LEFT JOIN rpfp.couples apc
             ON apc.RPFP_CLASS_ID = rc.RPFP_CLASS_ID
          WHERE apc.IS_ACTIVE = status_active
            AND rc.DB_USER_ID = name_user
    ) THEN
                 SELECT NULL AS rpfpclass,
                        NULL AS typeclass,
                        NULL AS others_specify,
                        NULL AS province_name,
                        NULL AS municipality_name,
                        NULL AS barangay,
                        NULL AS class_no,
                        NULL AS couples_encoded,
                        NULL AS served_count,
                        NULL AS date_conduct,
                        NULL AS lastname,
                        NULL AS firstname
            ;
    ELSE
        IF (IFNULL( intention_use, 0 ) = 0) THEN
            SET search_intention_from = intention_use;
            SET search_intention_to = intention_use;
        ELSE
            SET search_intention_from = '1';
            SET search_intention_to = '12';
        END IF;

        IF (IFNULL( page_no, 0) = 0) THEN
            /** DEFAULT PAGE NO. */
        SET page_no := 1;
        END IF;
        IF (IFNULL( items_per_page, 0) = 0) THEN
            /** DEFAULT COUNT PER PAGE*/
        SET items_per_page := 10;
        END IF;

        SET read_offset := (page_no - 1) * items_per_page;
            SELECT rc.RPFP_CLASS_ID AS rpfpclass,
                   rc.TYPE_CLASS_ID AS typeclass,
                   rc.OTHERS_SPECIFY AS others_specify,
                   prov.LOCATION_DESCRIPTION AS province_name,
                   city.LOCATION_DESCRIPTION AS municipality_name,
                   lp.LOCATION_DESCRIPTION AS barangay,
                   rc.CLASS_NUMBER AS class_no,
                   COUNT(apc.COUPLES_ID) AS couples_encoded,
                   COUNT(fs.COUPLES_ID) AS served_count,
                   rc.DATE_CONDUCTED AS date_conduct,
                   up.LAST_NAME AS lastname,
                   up.FIRST_NAME AS firstname
              FROM rpfp.rpfp_class rc 
         LEFT JOIN rpfp.couples apc ON apc.RPFP_CLASS_ID = rc.RPFP_CLASS_ID
         LEFT JOIN rpfp.individual ic ON ic.COUPLES_ID = apc.COUPLES_ID
         LEFT JOIN rpfp.fp_details fd ON fd.COUPLES_ID = ic.COUPLES_ID
         LEFT JOIN rpfp.lib_psgc_locations lp ON lp.PSGC_CODE = rc.BARANGAY_ID
         LEFT JOIN rpfp.lib_psgc_locations city ON city.PSGC_CODE = (lp.MUNICIPALITY_CODE * POWER( 10, 3 ))
         LEFT JOIN rpfp.lib_psgc_locations prov ON prov.PSGC_CODE = (lp.PROVINCE_CODE * POWER( 10, 5 ))
         LEFT JOIN rpfp.fp_service fs ON fs.COUPLES_ID = apc.COUPLES_ID
         LEFT JOIN rpfp.user_profile up ON up.DB_USER_ID = rc.DB_USER_ID
             WHERE rc.CLASS_NUMBER LIKE CONCAT('%',class_number,'%')
               AND lp.PSGC_CODE >= location_code_from
               AND lp.PSGC_CODE <= location_code_to
               AND (
                        rc.TYPE_CLASS_ID >= type_class
                    AND rc.TYPE_CLASS_ID <= type_class_range
                )
               AND (
                        rc.DATE_CONDUCTED >= search_date_from
                    AND rc.DATE_CONDUCTED <= search_date_to
                )
               AND apc.IS_ACTIVE = status_active
               AND (   rc.DB_USER_ID = name_user
                    OR (   is_not_encoder
                        AND user_location = (rc.BARANGAY_ID DIV POWER( 10, multiplier ))
                    )
                )
               AND (
                        ic.FNAME LIKE CONCAT('%',couples_name,'%')
                    OR ic.LNAME LIKE CONCAT('%',couples_name,'%')
                )
               AND ic.AGE >= search_age_from
               AND ic.AGE <= search_age_to
               AND apc.NO_CHILDREN >= search_child_from
               AND apc.NO_CHILDREN <= search_child_to
               AND fd.MFP_INTENTION_SHIFT_ID >= 1
               AND fd.TFP_TYPE_ID = tfp_used
               AND fd.TFP_STATUS_ID = 'A'
               AND fd.MFP_INTENTION_USE_ID >= search_intentionfp_from
               AND fd.MFP_INTENTION_USE_ID <= search_intentionfp_to
          GROUP BY rc.RPFP_CLASS_ID
          ORDER BY rc.DATE_CONDUCTED DESC
             LIMIT read_offset, items_per_page
        ; 
    END IF;
ELSE
    IF NOT EXISTS (
         SELECT rc.RPFP_CLASS_ID
           FROM rpfp.RPFP_CLASS rc
      LEFT JOIN rpfp.couples apc
             ON apc.RPFP_CLASS_ID = rc.RPFP_CLASS_ID
          WHERE apc.IS_ACTIVE = status_active
            AND (   rc.DB_USER_ID = name_user
                OR (   is_not_encoder
                    AND user_location = (rc.BARANGAY_ID DIV POWER( 10, multiplier ))
                )
            )
    ) THEN
                 SELECT NULL AS rpfpclass,
                        NULL AS typeclass,
                        NULL AS others_specify,
                        NULL AS province_name,
                        NULL AS municipality_name,
                        NULL AS barangay,
                        NULL AS class_no,
                        NULL AS couples_encoded,
                        NULL AS served_count,
                        NULL AS date_conduct,
                        NULL AS lastname,
                        NULL AS firstname
            ;
    ELSE    
        IF (IFNULL( page_no, 0) = 0) THEN
            /** DEFAULT PAGE NO. */
        SET page_no := 1;
        END IF;
        IF (IFNULL( items_per_page, 0) = 0) THEN
            /** DEFAULT COUNT PER PAGE*/
        SET items_per_page := 10;
        END IF;

        SET read_offset := (page_no - 1) * items_per_page;
        
            SELECT rc.RPFP_CLASS_ID AS rpfpclass,
                   rc.TYPE_CLASS_ID AS typeclass,
                   rc.OTHERS_SPECIFY AS others_specify,
                   prov.LOCATION_DESCRIPTION AS province_name,
                   city.LOCATION_DESCRIPTION AS municipality_name,
                   lp.LOCATION_DESCRIPTION AS barangay,
                   rc.CLASS_NUMBER AS class_no,
                   COUNT(apc.COUPLES_ID) AS couples_encoded,
                   COUNT(fs.COUPLES_ID) AS served_count,
                   rc.DATE_CONDUCTED AS date_conduct,
                   up.LAST_NAME AS lastname,
                   up.FIRST_NAME AS firstname
              FROM rpfp.rpfp_class rc 
         LEFT JOIN rpfp.couples apc ON apc.RPFP_CLASS_ID = rc.RPFP_CLASS_ID
         LEFT JOIN rpfp.individual ic ON ic.COUPLES_ID = apc.COUPLES_ID
         LEFT JOIN rpfp.fp_details fd ON fd.COUPLES_ID = ic.COUPLES_ID
         LEFT JOIN rpfp.lib_psgc_locations lp ON lp.PSGC_CODE = rc.BARANGAY_ID
         LEFT JOIN rpfp.lib_psgc_locations city ON city.PSGC_CODE = (lp.MUNICIPALITY_CODE * POWER( 10, 3 ))
         LEFT JOIN rpfp.lib_psgc_locations prov ON prov.PSGC_CODE = (lp.PROVINCE_CODE * POWER( 10, 5 ))
         LEFT JOIN rpfp.fp_service fs ON fs.COUPLES_ID = apc.COUPLES_ID
         LEFT JOIN rpfp.user_profile up ON up.DB_USER_ID = rc.DB_USER_ID
             WHERE rc.CLASS_NUMBER LIKE CONCAT('%',class_number,'%')
               AND lp.PSGC_CODE >= location_code_from
               AND lp.PSGC_CODE <= location_code_to
               AND (
                        rc.TYPE_CLASS_ID >= type_class
                    AND rc.TYPE_CLASS_ID <= type_class_range
                )
               AND (
                        rc.DATE_CONDUCTED >= search_date_from
                    AND rc.DATE_CONDUCTED <= search_date_to
                )
               AND apc.IS_ACTIVE = status_active
               AND (   rc.DB_USER_ID = name_user
                    OR (   is_not_encoder
                        AND user_location = (rc.BARANGAY_ID DIV POWER( 10, multiplier ))
                        )
                    )
               AND (
                        ic.FNAME LIKE CONCAT('%',couples_name,'%')
                    OR ic.LNAME LIKE CONCAT('%',couples_name,'%')
                )
               AND ic.AGE >= search_age_from
               AND ic.AGE <= search_age_to
               AND apc.NO_CHILDREN >= search_child_from
               AND apc.NO_CHILDREN <= search_child_to
               AND fd.MFP_INTENTION_SHIFT_ID >= 1
               AND fd.TFP_TYPE_ID = tfp_used
               AND fd.TFP_STATUS_ID LIKE CONCAT('%',intention_status,'%')
          GROUP BY rc.RPFP_CLASS_ID
          ORDER BY rc.DATE_CONDUCTED DESC
             LIMIT read_offset, items_per_page
        ; 
    END IF;
END IF;
END$$

CREATE DEFINER=root@localhost PROCEDURE get_class_list_served_shifters (
    IN location_code_from INT,
    IN location_code_to INT,
    IN class_number VARCHAR(100),
    IN search_date_from DATE,
    IN search_date_to DATE,
    IN type_class INT,
    IN couples_name VARCHAR(100),
    IN search_age_from INT,
    IN search_age_to INT,
    IN no_child INT,
    IN mfp_used INT,
    IN tfp_used INT,
    IN intention_status VARCHAR(50),
    IN intention_use INT,
    IN search_status INT,
    IN status_active INT,
    IN username VARCHAR(50),
    IN page_no INT,
    IN items_per_page INT
    )   READS SQL DATA
    proc_exit_point :
BEGIN
    DECLARE type_class_range INT;
    DECLARE search_child_from INT;
    DECLARE search_child_to INT;
    DECLARE search_mfp_from INT;
    DECLARE search_mfp_to INT;
    DECLARE search_tfp_from INT;
    DECLARE search_tfp_to INT;
    DECLARE search_intention_from INT;
    DECLARE search_intention_to INT;
    DECLARE search_intentionfp_from INT;
    DECLARE search_intentionfp_to INT;
    /** 
    SEARCH STATUS
        1 - unmet need
        2 - served unmet need
        3 - shifters
        4 - served shifters
    */
    DECLARE name_user VARCHAR(50);
    DECLARE db_user_name VARCHAR(50);
    DECLARE read_offset INT;
    DECLARE user_scope INT;
    DECLARE user_location INT;
    DECLARE multiplier INT;
    DECLARE is_not_encoder INT(1);
    
    CALL rpfp.lib_extract_user_name( USER(), name_user, db_user_name );
    SET user_scope := rpfp.profile_get_scope( name_user );
    SET multiplier := rpfp.lib_get_multiplier( user_scope );
    SET user_location := rpfp.profile_get_location( name_user, user_scope );
    SET is_not_encoder := NOT IFNULL(rpfp.profile_check_if_encoder(), FALSE);

    IF (IFNULL( type_class, 0 ) = 0 ) THEN
        SET type_class = 1;
        SET type_class_range = 7;
    ELSE
        SET type_class_range = type_class;
    END IF;

    IF (IFNULL( no_child, 0 ) = 0) THEN
        SET search_child_from = 0;
        SET search_child_to = 200;
    END IF;

IF ( IFNULL( tfp_used, 0 ) = 0 ) THEN
    IF NOT EXISTS (
         SELECT rc.RPFP_CLASS_ID
           FROM rpfp.RPFP_CLASS rc
      LEFT JOIN rpfp.couples apc
             ON apc.RPFP_CLASS_ID = rc.RPFP_CLASS_ID
          WHERE apc.IS_ACTIVE = status_active
            AND (   rc.DB_USER_ID = name_user
                OR (   is_not_encoder
                    AND user_location = (rc.BARANGAY_ID DIV POWER( 10, multiplier ))
                )
            )
    ) THEN
                 SELECT NULL AS rpfpclass,
                        NULL AS typeclass,
                        NULL AS others_specify,
                        NULL AS province_name,
                        NULL AS municipality_name,
                        NULL AS barangay,
                        NULL AS class_no,
                        NULL AS couples_encoded,
                        NULL AS served_count,
                        NULL AS date_conduct,
                        NULL AS lastname,
                        NULL AS firstname
            ;
    ELSE
        IF (IFNULL( page_no, 0) = 0) THEN
            /** DEFAULT PAGE NO. */
        SET page_no := 1;
        END IF;
        IF (IFNULL( items_per_page, 0) = 0) THEN
            /** DEFAULT COUNT PER PAGE*/
        SET items_per_page := 10;
        END IF;

        SET read_offset := (page_no - 1) * items_per_page;
            SELECT rc.RPFP_CLASS_ID AS rpfpclass,
                   rc.TYPE_CLASS_ID AS typeclass,
                   rc.OTHERS_SPECIFY AS others_specify,
                   prov.LOCATION_DESCRIPTION AS province_name,
                   city.LOCATION_DESCRIPTION AS municipality_name,
                   lp.LOCATION_DESCRIPTION AS barangay,
                   rc.CLASS_NUMBER AS class_no,
                   COUNT(apc.COUPLES_ID) AS couples_encoded,
                   COUNT(fs.COUPLES_ID) AS served_count,
                   rc.DATE_CONDUCTED AS date_conduct,
                   up.LAST_NAME AS lastname,
                   up.FIRST_NAME AS firstname
              FROM rpfp.rpfp_class rc 
         LEFT JOIN rpfp.couples apc ON apc.RPFP_CLASS_ID = rc.RPFP_CLASS_ID
         LEFT JOIN rpfp.individual ic ON ic.COUPLES_ID = apc.COUPLES_ID
         LEFT JOIN rpfp.fp_details fd ON fd.COUPLES_ID = ic.COUPLES_ID
          LEFT JOIN rpfp.fp_service fs ON fs.COUPLES_ID = apc.COUPLES_ID
         LEFT JOIN rpfp.lib_psgc_locations lp ON lp.PSGC_CODE = rc.BARANGAY_ID
         LEFT JOIN rpfp.lib_psgc_locations city ON city.PSGC_CODE = (lp.MUNICIPALITY_CODE * POWER( 10, 3 ))
         LEFT JOIN rpfp.lib_psgc_locations prov ON prov.PSGC_CODE = (lp.PROVINCE_CODE * POWER( 10, 5 ))
         LEFT JOIN rpfp.user_profile up ON up.DB_USER_ID = rc.DB_USER_ID
             WHERE rc.CLASS_NUMBER LIKE CONCAT('%',class_number,'%')
               AND lp.PSGC_CODE >= location_code_from
               AND lp.PSGC_CODE <= location_code_to
               AND (
                        rc.TYPE_CLASS_ID >= type_class
                    AND rc.TYPE_CLASS_ID <= type_class_range
                )
               AND (
                        rc.DATE_CONDUCTED >= search_date_from
                    AND rc.DATE_CONDUCTED <= search_date_to
                )
               AND apc.IS_ACTIVE = status_active
               AND (   rc.DB_USER_ID = name_user
                   OR (   is_not_encoder
                      AND user_location = (rc.BARANGAY_ID DIV POWER( 10, multiplier ))
                    )
                )
               AND (
                        ic.FNAME LIKE CONCAT('%',couples_name,'%')
                     OR ic.LNAME LIKE CONCAT('%',couples_name,'%')
                )
               AND ic.AGE >= search_age_from
               AND ic.AGE <= search_age_to
               AND apc.NO_CHILDREN >= search_child_from
               AND apc.NO_CHILDREN <= search_child_to
               AND fd.MFP_INTENTION_SHIFT_ID >= 1
               AND fd.MFP_METHOD_USED_ID = mfp_used
          GROUP BY rc.RPFP_CLASS_ID
          ORDER BY rc.DATE_CONDUCTED DESC
             LIMIT read_offset, items_per_page
        ; 
    END IF;
    LEAVE proc_exit_point;
END IF;

IF intention_status = 'A' THEN
    IF NOT EXISTS (
         SELECT rc.RPFP_CLASS_ID
           FROM rpfp.RPFP_CLASS rc
      LEFT JOIN rpfp.couples apc
             ON apc.RPFP_CLASS_ID = rc.RPFP_CLASS_ID
          WHERE apc.IS_ACTIVE = status_active
            AND rc.DB_USER_ID = name_user
    ) THEN
                 SELECT NULL AS rpfpclass,
                        NULL AS typeclass,
                        NULL AS others_specify,
                        NULL AS province_name,
                        NULL AS municipality_name,
                        NULL AS barangay,
                        NULL AS class_no,
                        NULL AS couples_encoded,
                        NULL AS served_count,
                        NULL AS date_conduct,
                        NULL AS lastname,
                        NULL AS firstname
            ;
    ELSE
        IF (IFNULL( intention_use, 0 ) = 0) THEN
            SET search_intention_from = intention_use;
            SET search_intention_to = intention_use;
        ELSE
            SET search_intention_from = '1';
            SET search_intention_to = '12';
        END IF;

        IF (IFNULL( page_no, 0) = 0) THEN
            /** DEFAULT PAGE NO. */
        SET page_no := 1;
        END IF;
        IF (IFNULL( items_per_page, 0) = 0) THEN
            /** DEFAULT COUNT PER PAGE*/
        SET items_per_page := 10;
        END IF;

        SET read_offset := (page_no - 1) * items_per_page;
            SELECT rc.RPFP_CLASS_ID AS rpfpclass,
                   rc.TYPE_CLASS_ID AS typeclass,
                   rc.OTHERS_SPECIFY AS others_specify,
                   prov.LOCATION_DESCRIPTION AS province_name,
                   city.LOCATION_DESCRIPTION AS municipality_name,
                   lp.LOCATION_DESCRIPTION AS barangay,
                   rc.CLASS_NUMBER AS class_no,
                   COUNT(apc.COUPLES_ID) AS couples_encoded,
                   COUNT(fs.COUPLES_ID) AS served_count,
                   rc.DATE_CONDUCTED AS date_conduct,
                   up.LAST_NAME AS lastname,
                   up.FIRST_NAME AS firstname
              FROM rpfp.rpfp_class rc 
         LEFT JOIN rpfp.couples apc ON apc.RPFP_CLASS_ID = rc.RPFP_CLASS_ID
         LEFT JOIN rpfp.individual ic ON ic.COUPLES_ID = apc.COUPLES_ID
         LEFT JOIN rpfp.fp_details fd ON fd.COUPLES_ID = ic.COUPLES_ID
          LEFT JOIN rpfp.fp_service fs ON fs.COUPLES_ID = apc.COUPLES_ID
         LEFT JOIN rpfp.lib_psgc_locations lp ON lp.PSGC_CODE = rc.BARANGAY_ID
         LEFT JOIN rpfp.lib_psgc_locations city ON city.PSGC_CODE = (lp.MUNICIPALITY_CODE * POWER( 10, 3 ))
         LEFT JOIN rpfp.lib_psgc_locations prov ON prov.PSGC_CODE = (lp.PROVINCE_CODE * POWER( 10, 5 ))
         LEFT JOIN rpfp.user_profile up ON up.DB_USER_ID = rc.DB_USER_ID
             WHERE rc.CLASS_NUMBER LIKE CONCAT('%',class_number,'%')
               AND lp.PSGC_CODE >= location_code_from
               AND lp.PSGC_CODE <= location_code_to
               AND (
                        rc.TYPE_CLASS_ID >= type_class
                    AND rc.TYPE_CLASS_ID <= type_class_range
                )
               AND (
                        rc.DATE_CONDUCTED >= search_date_from
                    AND rc.DATE_CONDUCTED <= search_date_to
                )
               AND apc.IS_ACTIVE = status_active
               AND (   rc.DB_USER_ID = name_user
                    OR (   is_not_encoder
                        AND user_location = (rc.BARANGAY_ID DIV POWER( 10, multiplier ))
                    )
                )
               AND (
                        ic.FNAME LIKE CONCAT('%',couples_name,'%')
                    OR ic.LNAME LIKE CONCAT('%',couples_name,'%')
                )
               AND ic.AGE >= search_age_from
               AND ic.AGE <= search_age_to
               AND apc.NO_CHILDREN >= search_child_from
               AND apc.NO_CHILDREN <= search_child_to
               AND fd.MFP_INTENTION_SHIFT_ID >= 1
               AND fd.TFP_TYPE_ID = tfp_used
               AND fd.TFP_STATUS_ID = 'A'
               AND fd.MFP_INTENTION_USE_ID >= search_intentionfp_from
               AND fd.MFP_INTENTION_USE_ID <= search_intentionfp_to
          GROUP BY rc.RPFP_CLASS_ID
          ORDER BY rc.DATE_CONDUCTED DESC
             LIMIT read_offset, items_per_page
        ; 
    END IF;
ELSE
    IF NOT EXISTS (
         SELECT rc.RPFP_CLASS_ID
           FROM rpfp.RPFP_CLASS rc
      LEFT JOIN rpfp.couples apc
             ON apc.RPFP_CLASS_ID = rc.RPFP_CLASS_ID
          WHERE apc.IS_ACTIVE = status_active
            AND (   rc.DB_USER_ID = name_user
                OR (   is_not_encoder
                    AND user_location = (rc.BARANGAY_ID DIV POWER( 10, multiplier ))
                )
            )
    ) THEN
                 SELECT NULL AS rpfpclass,
                        NULL AS typeclass,
                        NULL AS others_specify,
                        NULL AS province_name,
                        NULL AS municipality_name,
                        NULL AS barangay,
                        NULL AS class_no,
                        NULL AS couples_encoded,
                        NULL AS served_count,
                        NULL AS date_conduct,
                        NULL AS lastname,
                        NULL AS firstname
            ;
    ELSE    
        IF (IFNULL( page_no, 0) = 0) THEN
            /** DEFAULT PAGE NO. */
        SET page_no := 1;
        END IF;
        IF (IFNULL( items_per_page, 0) = 0) THEN
            /** DEFAULT COUNT PER PAGE*/
        SET items_per_page := 10;
        END IF;

        SET read_offset := (page_no - 1) * items_per_page;
        
            SELECT rc.RPFP_CLASS_ID AS rpfpclass,
                   rc.TYPE_CLASS_ID AS typeclass,
                   rc.OTHERS_SPECIFY AS others_specify,
                   prov.LOCATION_DESCRIPTION AS province_name,
                   city.LOCATION_DESCRIPTION AS municipality_name,
                   lp.LOCATION_DESCRIPTION AS barangay,
                   rc.CLASS_NUMBER AS class_no,
                   COUNT(apc.COUPLES_ID) AS couples_encoded,
                   COUNT(fs.COUPLES_ID) AS served_count,
                   rc.DATE_CONDUCTED AS date_conduct,
                   up.LAST_NAME AS lastname,
                   up.FIRST_NAME AS firstname
              FROM rpfp.rpfp_class rc 
         LEFT JOIN rpfp.couples apc ON apc.RPFP_CLASS_ID = rc.RPFP_CLASS_ID
         LEFT JOIN rpfp.individual ic ON ic.COUPLES_ID = apc.COUPLES_ID
         LEFT JOIN rpfp.fp_details fd ON fd.COUPLES_ID = ic.COUPLES_ID
         LEFT JOIN rpfp.fp_service fs ON fs.COUPLES_ID = apc.COUPLES_ID
         LEFT JOIN rpfp.lib_psgc_locations lp ON lp.PSGC_CODE = rc.BARANGAY_ID
         LEFT JOIN rpfp.lib_psgc_locations city ON city.PSGC_CODE = (lp.MUNICIPALITY_CODE * POWER( 10, 3 ))
         LEFT JOIN rpfp.lib_psgc_locations prov ON prov.PSGC_CODE = (lp.PROVINCE_CODE * POWER( 10, 5 ))
         LEFT JOIN rpfp.user_profile up ON up.DB_USER_ID = rc.DB_USER_ID
             WHERE rc.CLASS_NUMBER LIKE CONCAT('%',class_number,'%')
               AND lp.PSGC_CODE >= location_code_from
               AND lp.PSGC_CODE <= location_code_to
               AND (
                        rc.TYPE_CLASS_ID >= type_class
                    AND rc.TYPE_CLASS_ID <= type_class_range
                )
               AND (
                        rc.DATE_CONDUCTED >= search_date_from
                    AND rc.DATE_CONDUCTED <= search_date_to
                )
               AND apc.IS_ACTIVE = status_active
               AND (   rc.DB_USER_ID = name_user
                    OR (   is_not_encoder
                        AND user_location = (rc.BARANGAY_ID DIV POWER( 10, multiplier ))
                        )
                    )
               AND (
                        ic.FNAME LIKE CONCAT('%',couples_name,'%')
                    OR ic.LNAME LIKE CONCAT('%',couples_name,'%')
                )
               AND ic.AGE >= search_age_from
               AND ic.AGE <= search_age_to
               AND apc.NO_CHILDREN >= search_child_from
               AND apc.NO_CHILDREN <= search_child_to
               AND fd.MFP_INTENTION_SHIFT_ID >= 1
               AND fd.TFP_TYPE_ID = tfp_used
               AND fd.TFP_STATUS_ID LIKE CONCAT('%',intention_status,'%')
          GROUP BY rc.RPFP_CLASS_ID
          ORDER BY rc.DATE_CONDUCTED DESC
             LIMIT read_offset, items_per_page
        ; 
    END IF;
END IF;
END$$
/** END SEARCH COUPLES */

/** PROCESS REPORTS */
CREATE DEFINER=root@localhost PROCEDURE encoder_process_accomplishment (
    IN date_from DATE,
    IN date_to DATE
    )  READS SQL DATA
proc_exit_point :
BEGIN
    DECLARE name_user VARCHAR(50);
    DECLARE db_user_name VARCHAR(50);
    DECLARE user_scope INT;
    DECLARE user_location INT;
    DECLARE multiplier INT;
    DECLARE is_not_encoder INT(1);

    CALL rpfp.lib_extract_user_name( USER(), name_user, db_user_name );
    SET user_scope := rpfp.profile_get_scope( name_user );
    SET multiplier := rpfp.lib_get_multiplier( user_scope );
    SET user_location := rpfp.profile_get_location( name_user, user_scope ) DIV POWER(10, 7);
    SET is_not_encoder := NOT IFNULL(rpfp.profile_check_if_encoder(), FALSE);

    CALL rpfp.process_accomplishment( name_user, date_from, date_to, user_location );

END$$

CREATE DEFINER=root@localhost PROCEDURE process_accomplishment (
    IN username VARCHAR(50),
    IN date_from DATE,
    IN date_to DATE,
    IN psgc_code INT
    )  READS SQL DATA
proc_exit_point :
BEGIN
    DECLARE count_id INT;
    DECLARE random_no VARCHAR(400);
    DECLARE out_message_1 VARCHAR(100);
    DECLARE out_message_2 VARCHAR(100);
    DECLARE out_message_3 VARCHAR(100);

    SET random_no = CONCAT("RPFP-",YEAR(date_from),MONTH(date_to),"-",CEILING(RAND()*10000000000));

    SELECT COUNT(*) INTO count_id FROM report_random_id WHERE RANDOM_ID = random_no;

    IF count_id > 0 THEN
        SELECT "CANNOT PROCESS RECORD WITH GIVEN PARAMETERS" AS MESSAGE;
        LEAVE proc_exit_point;
    END IF
    ;

    CALL process_check_duplication( username, date_from, date_to, psgc_code, random_no, out_message_1 );
    CALL process_couples_encoded( username, date_from, date_to, psgc_code, random_no, out_message_2 );
    -- CALL process_couples_served( username, date_from, date_to, psgc_code, random_no, out_message_3 );
    SELECT out_message_2 AS MESSAGE;
END$$

CREATE DEFINER=root@localhost PROCEDURE process_couples_encoded (
    IN username VARCHAR(50),
    IN date_from DATE,
    IN date_to DATE,
    IN psgc_code INT,
    IN random_id VARCHAR(400),
   OUT output_message VARCHAR(100)
    )  MODIFIES SQL DATA
proc_exit_point :
BEGIN
    DECLARE encoded_fin INTEGER DEFAULT 0;
    DECLARE class_no VARCHAR(100) DEFAULT "";
    DECLARE encoded_couples INT;
    DECLARE approved_couples INT;
    DECLARE pending_couples INT;
    DECLARE served_couples INT;
    DECLARE duplicates INT;
    DECLARE invalids INT;
    DECLARE firstname VARCHAR(50);
    DECLARE lastname VARCHAR(50);
    DECLARE extname VARCHAR(50);
    DECLARE birthdate DATE;
    DECLARE report_status INT DEFAULT 0;

    DECLARE cur_class_list CURSOR FOR 
        SELECT DISTINCT rc.CLASS_NUMBER
                   FROM rpfp.rpfp_class rc 
              LEFT JOIN rpfp.lib_psgc_locations lp
                     ON lp.PSGC_CODE = rc.BARANGAY_ID
                  WHERE rc.DATE_CONDUCTED >= date_from 
                    AND rc.DATE_CONDUCTED <= date_to
                    AND (
                            QUOTE(lp.REGION_CODE) = QUOTE(psgc_code)
                         OR (IFNULL( psgc_code, 0 ) = 0)
                        )
    ;

    DECLARE CONTINUE HANDLER FOR NOT FOUND
        BEGIN
            SET encoded_fin = 1;
        END;

    OPEN cur_class_list;

    get_cur_class_list: LOOP
        FETCH cur_class_list INTO class_no;
        IF encoded_fin = 1 THEN
            LEAVE get_cur_class_list;
        END IF;
    
         SELECT COUNT(apc.COUPLES_ID)
           INTO encoded_couples
           FROM rpfp.couples apc 
      LEFT JOIN rpfp.rpfp_class rc
             ON rc.RPFP_CLASS_ID = apc.RPFP_CLASS_ID
      LEFT JOIN rpfp.lib_psgc_locations lp
             ON lp.PSGC_CODE = rc.BARANGAY_ID
          WHERE rc.DATE_CONDUCTED >= date_from 
            AND rc.DATE_CONDUCTED <= date_to
            AND rc.CLASS_NUMBER = class_no
            AND (
                    QUOTE(lp.REGION_CODE) = QUOTE(psgc_code)
                 OR (IFNULL( psgc_code, 0 ) = 0)
                )
        ;

         SELECT COUNT(apc.COUPLES_ID)
           INTO approved_couples
           FROM rpfp.couples apc 
      LEFT JOIN rpfp.rpfp_class rc
             ON rc.RPFP_CLASS_ID = apc.RPFP_CLASS_ID
      LEFT JOIN rpfp.lib_psgc_locations lp
             ON lp.PSGC_CODE = rc.BARANGAY_ID
          WHERE apc.IS_ACTIVE = 0
            AND rc.DATE_CONDUCTED >= date_from 
            AND rc.DATE_CONDUCTED <= date_to
            AND rc.CLASS_NUMBER = class_no
            AND (
                    QUOTE(lp.REGION_CODE) = QUOTE(psgc_code)
                 OR (IFNULL( psgc_code, 0 ) = 0)
                )
        ;

         SELECT COUNT(apc.COUPLES_ID)
           INTO served_couples
           FROM rpfp.couples apc 
      LEFT JOIN rpfp.rpfp_class rc
             ON rc.RPFP_CLASS_ID = apc.RPFP_CLASS_ID
      LEFT JOIN rpfp.lib_psgc_locations lp
             ON lp.PSGC_CODE = rc.BARANGAY_ID
      LEFT JOIN rpfp.fp_service fs 
             ON fs.COUPLES_ID = apc.COUPLES_ID
          WHERE apc.IS_ACTIVE = 0
            AND fs.IS_PROVIDED_SERVICE = 1
            AND fs.DATE_SERVED >= date_from 
            AND fs.DATE_SERVED <= date_to
            AND rc.CLASS_NUMBER = class_no
            AND (
                    QUOTE(lp.REGION_CODE) = QUOTE(psgc_code)
                 OR (IFNULL( psgc_code, 0 ) = 0)
                )
        ;

         SELECT COUNT(apc.COUPLES_ID)
           INTO pending_couples
           FROM rpfp.couples apc 
      LEFT JOIN rpfp.rpfp_class rc
             ON rc.RPFP_CLASS_ID = apc.RPFP_CLASS_ID
      LEFT JOIN rpfp.lib_psgc_locations lp
             ON lp.PSGC_CODE = rc.BARANGAY_ID
          WHERE apc.IS_ACTIVE = 2
            AND rc.DATE_CONDUCTED >= date_from 
            AND rc.DATE_CONDUCTED <= date_to
            AND rc.CLASS_NUMBER = class_no
            AND (
                    QUOTE(lp.REGION_CODE) = QUOTE(psgc_code)
                 OR (IFNULL( psgc_code, 0 ) = 0)
                )
        ;

         SELECT COUNT(rad.REPORT_ID)
           INTO duplicates
           FROM rpfp.report_duplicate_encoded rad
          WHERE rad.RPFP_CLASS_NO = class_no
            AND rad.ACCOM_ID = random_id
        ;

        INSERT INTO rpfp.report_couples_encoded (
                    ACCOM_ID,
                    DATE_FROM,
                    DATE_TO,
                    PSGC_CODE,
                    RPFP_CLASS_NO,
                    ENCODED_COUPLES,
                    APPROVED_COUPLES,
                    PENDING_COUPLES,
                    SERVED_COUPLES,
                    DUPLICATES,
                    INVALIDS,
                    DB_USER_ID,
                    IS_ACTIVE,
                    DATE_PROCESSED
        ) VALUES (
                    random_id,
                    date_from,
                    date_to,
                    psgc_code,
                    class_no,
                    encoded_couples,
                    approved_couples,
                    pending_couples,
                    served_couples,
                    duplicates,
                    invalids,
                    username,
                    report_status,
                    CURRENT_DATE()
        );
            
    END LOOP get_cur_class_list;
    CLOSE cur_class_list;

    SELECT CONCAT( "NEW ENTRY: ", LAST_INSERT_ID() ) INTO output_message;
    
END$$

CREATE DEFINER=root@localhost PROCEDURE process_couples_served (
    IN username VARCHAR(50),
    IN date_from DATE,
    IN date_to DATE,
    IN psgc_code INT,
    IN random_id VARCHAR(400),
   OUT output_message VARCHAR(100)
    )  MODIFIES SQL DATA
proc_exit_point :
BEGIN
    DECLARE encoded_fin INTEGER DEFAULT 0;
    DECLARE class_no VARCHAR(100) DEFAULT "";
    DECLARE encoded_couples INT;
    DECLARE approved_couples INT;
    DECLARE pending_couples INT;
    DECLARE served_couples INT;
    DECLARE duplicates INT;
    DECLARE invalids INT;
    DECLARE firstname VARCHAR(50);
    DECLARE lastname VARCHAR(50);
    DECLARE extname VARCHAR(50);
    DECLARE birthdate DATE;
    DECLARE report_status INT DEFAULT 0;

    DECLARE cur_class_list CURSOR FOR 
        SELECT DISTINCT rc.CLASS_NUMBER
                   FROM rpfp.rpfp_class rc 
              LEFT JOIN rpfp.lib_psgc_locations lp
                     ON lp.PSGC_CODE = rc.BARANGAY_ID
              LEFT JOIN rpfp.couples apc 
                     ON apc.RPFP_CLASS_ID = rc.RPFP_CLASS_ID
              LEFT JOIN rpfp.fp_service fs 
                     ON fs.COUPLES_ID = apc.COUPLES_ID
                  WHERE rc.DATE_CONDUCTED < date_from
                    AND apc.IS_ACTIVE = 0
                    AND fs.IS_PROVIDED_SERVICE = 1
                    AND fs.DATE_SERVED >= date_from 
                    AND fs.DATE_SERVED <= date_to
                    AND (
                            QUOTE(lp.REGION_CODE) = QUOTE(psgc_code)
                         OR (IFNULL( psgc_code, 0 ) = 0)
                        )
    ;

    DECLARE CONTINUE HANDLER FOR NOT FOUND
        BEGIN
            SET encoded_fin = 1;
        END;

    OPEN cur_class_list;

    get_cur_class_list: LOOP
        FETCH cur_class_list INTO class_no;
        IF encoded_fin = 1 THEN
            LEAVE get_cur_class_list;
        END IF;
    
         SELECT COUNT(apc.COUPLES_ID)
           INTO encoded_couples
           FROM rpfp.couples apc 
      LEFT JOIN rpfp.rpfp_class rc
             ON rc.RPFP_CLASS_ID = apc.RPFP_CLASS_ID
      LEFT JOIN rpfp.lib_psgc_locations lp
             ON lp.PSGC_CODE = rc.BARANGAY_ID
          WHERE rc.DATE_CONDUCTED >= date_from 
            AND rc.DATE_CONDUCTED <= date_to
            AND rc.CLASS_NUMBER = class_no
            AND (
                    QUOTE(lp.REGION_CODE) = QUOTE(psgc_code)
                 OR (IFNULL( psgc_code, 0 ) = 0)
                )
        ;

         SELECT COUNT(apc.COUPLES_ID)
           INTO approved_couples
           FROM rpfp.couples apc 
      LEFT JOIN rpfp.rpfp_class rc
             ON rc.RPFP_CLASS_ID = apc.RPFP_CLASS_ID
      LEFT JOIN rpfp.lib_psgc_locations lp
             ON lp.PSGC_CODE = rc.BARANGAY_ID
          WHERE apc.IS_ACTIVE = 0
            AND rc.DATE_CONDUCTED >= date_from 
            AND rc.DATE_CONDUCTED <= date_to
            AND rc.CLASS_NUMBER = class_no
            AND (
                    QUOTE(lp.REGION_CODE) = QUOTE(psgc_code)
                 OR (IFNULL( psgc_code, 0 ) = 0)
                )
        ;

         SELECT COUNT(apc.COUPLES_ID)
           INTO served_couples
           FROM rpfp.couples apc 
      LEFT JOIN rpfp.rpfp_class rc
             ON rc.RPFP_CLASS_ID = apc.RPFP_CLASS_ID
      LEFT JOIN rpfp.lib_psgc_locations lp
             ON lp.PSGC_CODE = rc.BARANGAY_ID
      LEFT JOIN rpfp.fp_service fs 
             ON fs.COUPLES_ID = apc.COUPLES_ID
          WHERE apc.IS_ACTIVE = 0
            AND fs.IS_PROVIDED_SERVICE = 1
            AND fs.DATE_SERVED >= date_from 
            AND fs.DATE_SERVED <= date_to
            AND rc.CLASS_NUMBER = class_no
            AND (
                    QUOTE(lp.REGION_CODE) = QUOTE(psgc_code)
                 OR (IFNULL( psgc_code, 0 ) = 0)
                )
        ;

         SELECT COUNT(apc.COUPLES_ID)
           INTO pending_couples
           FROM rpfp.couples apc 
      LEFT JOIN rpfp.rpfp_class rc
             ON rc.RPFP_CLASS_ID = apc.RPFP_CLASS_ID
      LEFT JOIN rpfp.lib_psgc_locations lp
             ON lp.PSGC_CODE = rc.BARANGAY_ID
          WHERE apc.IS_ACTIVE = 2
            AND rc.DATE_CONDUCTED >= date_from 
            AND rc.DATE_CONDUCTED <= date_to
            AND rc.CLASS_NUMBER = class_no
            AND (
                    QUOTE(lp.REGION_CODE) = QUOTE(psgc_code)
                 OR (IFNULL( psgc_code, 0 ) = 0)
                )
        ;

         SELECT COUNT(rad.REPORT_ID)
           INTO duplicates
           FROM rpfp.report_duplicate_encoded rad
          WHERE rad.RPFP_CLASS_NO = class_no
            AND rad.ACCOM_ID = random_id
        ;

        INSERT INTO rpfp.report_couples_encoded (
                    ACCOM_ID,
                    DATE_FROM,
                    DATE_TO,
                    PSGC_CODE,
                    RPFP_CLASS_NO,
                    ENCODED_COUPLES,
                    APPROVED_COUPLES,
                    PENDING_COUPLES,
                    SERVED_COUPLES,
                    DUPLICATES,
                    INVALIDS,
                    DB_USER_ID,
                    IS_ACTIVE,
                    DATE_PROCESSED
        ) VALUES (
                    random_id,
                    date_from,
                    date_to,
                    psgc_code,
                    class_no,
                    encoded_couples,
                    approved_couples,
                    pending_couples,
                    served_couples,
                    duplicates,
                    invalids,
                    username,
                    report_status,
                    CURRENT_DATE()
        );
            
    END LOOP get_cur_class_list;
    CLOSE cur_class_list;

    SELECT CONCAT( "NEW ENTRY: ", LAST_INSERT_ID() ) INTO output_message;
    
END$$

CREATE DEFINER=root@localhost PROCEDURE process_check_duplication (
    IN username VARCHAR(50),
    IN date_from DATE,
    IN date_to DATE,
    IN psgc_code INT,
    IN random_id VARCHAR(400),
   OUT output_message VARCHAR(100)
    )  MODIFIES SQL DATA
proc_exit_point :
BEGIN
    DECLARE finished INTEGER DEFAULT 0;
    DECLARE class_no VARCHAR(100);
    DECLARE duplicates INT;
    DECLARE firstname VARCHAR(50);
    DECLARE lastname VARCHAR(50);
    DECLARE extname VARCHAR(50);
    DECLARE birthdate DATE;
    DECLARE count_record INT;
    DECLARE last_id INT DEFAULT 0;
    DECLARE report_status INT DEFAULT 0;

    DECLARE cur_duplicate_list CURSOR FOR
         SELECT ic.FNAME, ic.LNAME, ic.EXT_NAME, ic.BDATE, rc.CLASS_NUMBER, COUNT(apc.COUPLES_ID)
           FROM rpfp.individual ic
      LEFT JOIN rpfp.couples apc
             ON apc.COUPLES_ID = ic.COUPLES_ID
      LEFT JOIN rpfp.rpfp_class rc
             ON rc.RPFP_CLASS_ID = apc.RPFP_CLASS_ID
      LEFT JOIN rpfp.lib_psgc_locations lp
             ON lp.PSGC_CODE = rc.BARANGAY_ID
          WHERE apc.IS_ACTIVE = 0
            AND (
                    QUOTE(lp.REGION_CODE) = QUOTE(psgc_code)
                 OR (IFNULL( psgc_code, 0 ) = 0)
                )
       GROUP BY ic.FNAME, ic.LNAME, ic.EXT_NAME, ic.BDATE
    ;

    DECLARE CONTINUE HANDLER FOR NOT FOUND
        BEGIN
            SET finished = 1;
        END;

    OPEN cur_duplicate_list;

    get_cur_duplicate_list: LOOP
        FETCH cur_duplicate_list INTO firstname, lastname, extname, birthdate, class_no, duplicates;
        IF finished = 1 THEN
            LEAVE get_cur_duplicate_list;
        END IF;

        IF duplicates > 1 THEN
             SELECT COUNT(*)
               INTO count_record
               FROM rpfp.report_duplicate_encoded rde
              WHERE rde.FNAME = firstname
                AND rde.LNAME = lastname
                AND rde.EXT_NAME = extname
                AND rde.BDATE = birthdate
                AND rde.RPFP_CLASS_NO = class_no
                AND rde.DB_USER_ID = username
            ;

            IF count_record = 0 THEN
                INSERT INTO rpfp.report_duplicate_encoded (
                            ACCOM_ID,
                            DATE_FROM,
                            DATE_TO,
                            PSGC_CODE,
                            RPFP_CLASS_NO,
                            DUPLICATES,
                            FNAME,
                            LNAME,
                            EXT_NAME,
                            BDATE,
                            DB_USER_ID,
                            IS_ACTIVE,
                            DATE_PROCESSED
                ) VALUES (
                            random_id,
                            date_from,
                            date_to,
                            psgc_code,
                            class_no,
                            duplicates,
                            firstname,
                            lastname,
                            extname,
                            birthdate,
                            username,
                            report_status,
                            CURRENT_DATE()
                );
                SELECT LAST_INSERT_ID() INTO last_id;
            END IF;
        END IF;
    END LOOP;
    CLOSE cur_duplicate_list;

    SELECT CONCAT( "NEW ENTRY: ", last_id ) INTO output_message;    
END$$


CREATE DEFINER=root@localhost PROCEDURE process_demandgen (
    IN report_type INT,
    IN report_year INT,
    IN report_quarter INT,
    IN report_month INT,
    IN psgc_code INT
    )  MODIFIES SQL DATA
proc_exit_point :
BEGIN
DECLARE class_4ps INT;
DECLARE class_non4ps1 INT;
DECLARE class_non4ps2 INT;
DECLARE class_non4ps INT;
DECLARE class_usapan INT;
DECLARE class_pmc INT;
DECLARE class_h2h INT;
DECLARE class_profiled INT;
DECLARE class_total INT;
DECLARE target_couples INT;
DECLARE wra_4ps INT;
DECLARE wra_non4ps_a INT;
DECLARE wra_non4ps_b INT;
DECLARE wra_non4ps_total INT;
DECLARE wra_usapan INT;
DECLARE wra_pmc INT;
DECLARE wra_h2h INT;
DECLARE wra_profiled INT;
DECLARE wra_total INT;
DECLARE solo_male INT;
DECLARE solo_female INT;
DECLARE couple_attendee INT;
DECLARE reached_total INT;
DECLARE report_scope VARCHAR(100);
DECLARE report_range INT;
DECLARE count_month INT;
DECLARE report_code VARCHAR(50);
DECLARE report_status INT DEFAULT 0;
    
DECLARE random_no VARCHAR(100) DEFAULT 0 ;

IF report_type = 1 THEN
    SET report_scope = 'ANNUAL';
    SET report_range = report_year;
    SET report_month = 12;
    SET count_month = 1;
    SET report_code = 'Annual';
END IF;

IF report_type = 2 THEN
    SET report_scope = 'QUARTER';
    SET report_range = report_quarter;
    SET report_month = report_quarter * 3;
    SET count_month = report_quarter * 3 - 2;
    SET report_code = CONCAT('Quarter ', report_quarter);
END IF;

IF report_type = 3 THEN
    SET report_scope = 'MONTHLY';
    SET report_range = report_month;
    SET count_month = report_month;
    SET report_code = MONTHNAME(CONCAT(report_year,'-',report_month,'-1'));
END IF;

IF psgc_code = 0 THEN
    SET random_no = CONCAT("PMED-", report_scope, "-", psgc_code, "-", report_range);
ELSE
    SET random_no = CONCAT("RDM-", report_scope, "-", psgc_code, "-", report_range);
END IF;

loop_label: LOOP
    IF count_month > report_month THEN
        LEAVE loop_label;
    END IF;

      SELECT COUNT(DISTINCT rc.CLASS_NUMBER) 
        INTO class_4ps 
        FROM rpfp.rpfp_class rc 
   LEFT JOIN rpfp.lib_psgc_locations lp ON lp.PSGC_CODE = rc.BARANGAY_ID
       WHERE rc.TYPE_CLASS_ID = 1 
         AND YEAR(rc.DATE_CONDUCTED) = report_year 
         AND MONTH(rc.DATE_CONDUCTED) = count_month
         AND (
                QUOTE(lp.REGION_CODE) = QUOTE(psgc_code)
             OR (IFNULL( psgc_code, 0 ) = 0)
            )
    ;

      SELECT COUNT(DISTINCT rc.CLASS_NUMBER) 
        INTO class_non4ps1 
        FROM rpfp.rpfp_class rc 
   LEFT JOIN rpfp.lib_psgc_locations lp ON lp.PSGC_CODE = rc.BARANGAY_ID
       WHERE rc.TYPE_CLASS_ID = 2 
         AND YEAR(rc.DATE_CONDUCTED) = report_year 
         AND MONTH(rc.DATE_CONDUCTED) = count_month 
         AND (
                QUOTE(lp.REGION_CODE) = QUOTE(psgc_code)
             OR (IFNULL( psgc_code, 0 ) = 0)
            )
    ;

      SELECT COUNT(DISTINCT rc.CLASS_NUMBER) 
        INTO class_non4ps2 
        FROM rpfp.rpfp_class rc 
   LEFT JOIN rpfp.lib_psgc_locations lp ON lp.PSGC_CODE = rc.BARANGAY_ID
       WHERE rc.TYPE_CLASS_ID = 7 
         AND YEAR(rc.DATE_CONDUCTED) = report_year 
         AND MONTH(rc.DATE_CONDUCTED) = count_month 
         AND (
                QUOTE(lp.REGION_CODE) = QUOTE(psgc_code)
             OR (IFNULL( psgc_code, 0 ) = 0)
            )
    ;

         SET class_non4ps = class_non4ps1 + class_non4ps2;

      SELECT COUNT(DISTINCT rc.CLASS_NUMBER) 
        INTO class_usapan 
        FROM rpfp.rpfp_class rc 
   LEFT JOIN rpfp.lib_psgc_locations lp ON lp.PSGC_CODE = rc.BARANGAY_ID
       WHERE rc.TYPE_CLASS_ID = 4 
         AND YEAR(rc.DATE_CONDUCTED) = report_year 
         AND MONTH(rc.DATE_CONDUCTED) = count_month 
         AND (
                QUOTE(lp.REGION_CODE) = QUOTE(psgc_code)
             OR (IFNULL( psgc_code, 0 ) = 0)
            )
    ;

      SELECT COUNT(DISTINCT rc.CLASS_NUMBER) 
        INTO class_pmc 
        FROM rpfp.rpfp_class rc 
   LEFT JOIN rpfp.lib_psgc_locations lp ON lp.PSGC_CODE = rc.BARANGAY_ID
       WHERE rc.TYPE_CLASS_ID = 3 
         AND YEAR(rc.DATE_CONDUCTED) = report_year 
         AND MONTH(rc.DATE_CONDUCTED) = count_month 
         AND (
                QUOTE(lp.REGION_CODE) = QUOTE(psgc_code)
             OR (IFNULL( psgc_code, 0 ) = 0)
            )
    ;

      SELECT COUNT(DISTINCT rc.CLASS_NUMBER) 
        INTO class_h2h 
        FROM rpfp.rpfp_class rc 
   LEFT JOIN rpfp.lib_psgc_locations lp ON lp.PSGC_CODE = rc.BARANGAY_ID
       WHERE rc.TYPE_CLASS_ID = 5 
         AND YEAR(rc.DATE_CONDUCTED) = report_year 
         AND MONTH(rc.DATE_CONDUCTED) = count_month 
         AND (
                QUOTE(lp.REGION_CODE) = QUOTE(psgc_code)
             OR (IFNULL( psgc_code, 0 ) = 0)
            )
    ;

      SELECT COUNT(DISTINCT rc.CLASS_NUMBER) 
        INTO class_profiled 
        FROM rpfp.rpfp_class rc 
   LEFT JOIN rpfp.lib_psgc_locations lp ON lp.PSGC_CODE = rc.BARANGAY_ID
       WHERE rc.TYPE_CLASS_ID = 6 
         AND YEAR(rc.DATE_CONDUCTED) = report_year 
         AND MONTH(rc.DATE_CONDUCTED) = count_month 
         AND (
                QUOTE(lp.REGION_CODE) = QUOTE(psgc_code)
             OR (IFNULL( psgc_code, 0 ) = 0)
            )
    ;

      SELECT COUNT(DISTINCT rc.CLASS_NUMBER) 
        INTO class_total 
        FROM rpfp.rpfp_class rc 
   LEFT JOIN rpfp.lib_psgc_locations lp ON lp.PSGC_CODE = rc.BARANGAY_ID
       WHERE YEAR(rc.DATE_CONDUCTED) = report_year 
         AND MONTH(rc.DATE_CONDUCTED) = count_month 
         AND (
                QUOTE(lp.REGION_CODE) = QUOTE(psgc_code)
             OR (IFNULL( psgc_code, 0 ) = 0)
            )
    ;

      SELECT SUM(TARGET_COUNT)
	    INTO target_couples
        FROM target_couples tc
       WHERE tc.TARGET_YEAR = report_year 
         AND tc.TARGET_MONTH = count_month
         AND (
                QUOTE(tc.PSGC_CODE) = QUOTE(psgc_code)
             OR (IFNULL( psgc_code, 0 ) = 0)
            )
    ;
	
      SELECT COUNT(ic.INDV_ID) 
        INTO wra_4ps 
        FROM rpfp.individual ic
   LEFT JOIN rpfp.couples apc ON apc.COUPLES_ID = ic.COUPLES_ID
   LEFT JOIN rpfp.rpfp_class rc ON rc.RPFP_CLASS_ID = apc.RPFP_CLASS_ID
   LEFT JOIN rpfp.lib_psgc_locations lp ON lp.PSGC_CODE = rc.BARANGAY_ID
       WHERE apc.IS_ACTIVE = 0
         AND YEAR(rc.DATE_CONDUCTED) = report_year 
         AND MONTH(rc.DATE_CONDUCTED) = count_month 
         AND rc.TYPE_CLASS_ID = 1
         AND (
                QUOTE(lp.REGION_CODE) = QUOTE(psgc_code)
             OR (IFNULL( psgc_code, 0 ) = 0)
            )
       ;

      SELECT COUNT(ic.INDV_ID) 
        INTO wra_non4ps_total
        FROM rpfp.individual ic
   LEFT JOIN rpfp.couples apc ON apc.COUPLES_ID = ic.COUPLES_ID
   LEFT JOIN rpfp.rpfp_class rc ON rc.RPFP_CLASS_ID = apc.RPFP_CLASS_ID
   LEFT JOIN rpfp.lib_psgc_locations lp ON lp.PSGC_CODE = rc.BARANGAY_ID
       WHERE apc.IS_ACTIVE = 0
         AND YEAR(rc.DATE_CONDUCTED) = report_year 
         AND MONTH(rc.DATE_CONDUCTED) = count_month 
         AND (
                rc.TYPE_CLASS_ID = 2
             OR rc.TYPE_CLASS_ID = 7
         )
         AND (
                QUOTE(lp.REGION_CODE) = QUOTE(psgc_code)
             OR (IFNULL( psgc_code, 0 ) = 0)
            )
       ;

      SELECT COUNT(ic.INDV_ID) 
        INTO wra_usapan 
        FROM rpfp.individual ic
   LEFT JOIN rpfp.couples apc ON apc.COUPLES_ID = ic.COUPLES_ID
   LEFT JOIN rpfp.rpfp_class rc ON rc.RPFP_CLASS_ID = apc.RPFP_CLASS_ID
   LEFT JOIN rpfp.lib_psgc_locations lp ON lp.PSGC_CODE = rc.BARANGAY_ID
       WHERE apc.IS_ACTIVE = 0
         AND YEAR(rc.DATE_CONDUCTED) = report_year 
         AND MONTH(rc.DATE_CONDUCTED) = count_month 
         AND rc.TYPE_CLASS_ID = 4
         AND (
                QUOTE(lp.REGION_CODE) = QUOTE(psgc_code)
             OR (IFNULL( psgc_code, 0 ) = 0)
            )
       ;

      SELECT COUNT(ic.INDV_ID) 
        INTO wra_pmc 
        FROM rpfp.individual ic
   LEFT JOIN rpfp.couples apc ON apc.COUPLES_ID = ic.COUPLES_ID
   LEFT JOIN rpfp.rpfp_class rc ON rc.RPFP_CLASS_ID = apc.RPFP_CLASS_ID
   LEFT JOIN rpfp.lib_psgc_locations lp ON lp.PSGC_CODE = rc.BARANGAY_ID
       WHERE apc.IS_ACTIVE = 0
         AND YEAR(rc.DATE_CONDUCTED) = report_year 
         AND MONTH(rc.DATE_CONDUCTED) = count_month 
         AND rc.TYPE_CLASS_ID = 3
         AND (
                QUOTE(lp.REGION_CODE) = QUOTE(psgc_code)
             OR (IFNULL( psgc_code, 0 ) = 0)
            )
       ;

      SELECT COUNT(ic.INDV_ID) 
        INTO wra_h2h 
        FROM rpfp.individual ic
   LEFT JOIN rpfp.couples apc ON apc.COUPLES_ID = ic.COUPLES_ID
   LEFT JOIN rpfp.rpfp_class rc ON rc.RPFP_CLASS_ID = apc.RPFP_CLASS_ID
   LEFT JOIN rpfp.lib_psgc_locations lp ON lp.PSGC_CODE = rc.BARANGAY_ID
       WHERE apc.IS_ACTIVE = 0
         AND YEAR(rc.DATE_CONDUCTED) = report_year 
         AND MONTH(rc.DATE_CONDUCTED) = count_month 
         AND rc.TYPE_CLASS_ID = 5
         AND (
                QUOTE(lp.REGION_CODE) = QUOTE(psgc_code)
             OR (IFNULL( psgc_code, 0 ) = 0)
            )
       ;

      SELECT COUNT(ic.INDV_ID) 
        INTO wra_profiled
        FROM rpfp.individual ic
   LEFT JOIN rpfp.couples apc ON apc.COUPLES_ID = ic.COUPLES_ID
   LEFT JOIN rpfp.rpfp_class rc ON rc.RPFP_CLASS_ID = apc.RPFP_CLASS_ID
   LEFT JOIN rpfp.lib_psgc_locations lp ON lp.PSGC_CODE = rc.BARANGAY_ID
       WHERE apc.IS_ACTIVE = 0
         AND YEAR(rc.DATE_CONDUCTED) = report_year 
         AND MONTH(rc.DATE_CONDUCTED) = count_month 
         AND rc.TYPE_CLASS_ID = 6
         AND (
                QUOTE(lp.REGION_CODE) = QUOTE(psgc_code)
             OR (IFNULL( psgc_code, 0 ) = 0)
            )
       ;

      SELECT COUNT(ic.INDV_ID) 
        INTO wra_total 
        FROM rpfp.individual ic
   LEFT JOIN rpfp.couples apc ON apc.COUPLES_ID = ic.COUPLES_ID
   LEFT JOIN rpfp.rpfp_class rc ON rc.RPFP_CLASS_ID = apc.RPFP_CLASS_ID
   LEFT JOIN rpfp.lib_psgc_locations lp ON lp.PSGC_CODE = rc.BARANGAY_ID
       WHERE apc.IS_ACTIVE = 0
         AND YEAR(rc.DATE_CONDUCTED) = report_year 
         AND MONTH(rc.DATE_CONDUCTED) = count_month 
         AND (
                QUOTE(lp.REGION_CODE) = QUOTE(psgc_code)
             OR (IFNULL( psgc_code, 0 ) = 0)
            )
       ;

       SELECT COUNT(*) INTO solo_male
       FROM (
            SELECT husband.INDV_ID AS individualid,
                    husband.LNAME AS h_last,
                    husband.FNAME AS h_first,
                    husband.EXT_NAME AS h_ext,
                    husband.BDATE AS h_bday,
                    husband.SEX AS h_sex,
                    full_data.w_couplesid AS w_couplesid,
                    full_data.w_last AS w_last,
                    full_data.w_first AS w_first,
                    full_data.w_bday AS w_bday,
                    full_data.w_sex AS sex_w
               FROM rpfp.individual husband
          LEFT JOIN rpfp.couples couples ON couples.COUPLES_ID = husband.COUPLES_ID AND husband.SEX = 1
          LEFT JOIN rpfp.rpfp_class rc ON rc.RPFP_CLASS_ID = couples.RPFP_CLASS_ID
          LEFT JOIN rpfp.lib_psgc_locations lp ON lp.PSGC_CODE = rc.BARANGAY_ID
          LEFT JOIN (
                     SELECT wic.COUPLES_ID AS w_couplesid,
                            wife.LNAME AS w_last,
                            wife.FNAME AS w_first,
                            wife.BDATE AS w_bday,
                            wife.SEX AS w_sex
                       FROM rpfp.couples wic
                  LEFT JOIN rpfp.individual wife ON wife.COUPLES_ID = wic.COUPLES_ID AND wife.SEX = 2
                            ) full_data
                         ON full_data.w_couplesid = couples.COUPLES_ID
              WHERE couples.IS_ACTIVE = 0
                AND full_data.w_sex IS NULL
                AND YEAR(rc.DATE_CONDUCTED) = report_year 
                AND MONTH(rc.DATE_CONDUCTED) = count_month  
                AND (
                        QUOTE(lp.REGION_CODE) = QUOTE(08)
                     OR (IFNULL( 08, 0 ) = 0)
                    )
           GROUP BY individualid, h_last, h_first, h_ext, h_bday, h_sex, w_last, w_first, w_bday, w_sex
             HAVING COUNT(individualid)
        ) total_reached
        ;

       SELECT COUNT(*) INTO solo_female
       FROM (
             SELECT wife.INDV_ID AS individualid,
                    wife.LNAME AS w_last,
                    wife.FNAME AS w_first,
                    wife.BDATE AS w_bday,
                    wife.SEX AS w_sex,
                    full_data.h_couplesid AS h_couplesid,
                    full_data.h_last AS h_last,
                    full_data.h_first AS h_first,
                    full_data.h_bday AS h_bday,
                    full_data.h_sex AS sex_h
               FROM rpfp.individual wife
          LEFT JOIN rpfp.couples couples ON couples.COUPLES_ID = wife.COUPLES_ID AND wife.SEX = 2
          LEFT JOIN rpfp.rpfp_class rc ON rc.RPFP_CLASS_ID = couples.RPFP_CLASS_ID
          LEFT JOIN rpfp.lib_psgc_locations lp ON lp.PSGC_CODE = rc.BARANGAY_ID
          LEFT JOIN (
                     SELECT hic.COUPLES_ID AS h_couplesid,
                            husband.LNAME AS h_last,
                            husband.FNAME AS h_first,
                            husband.BDATE AS h_bday,
                            husband.SEX AS h_ext,
                            husband.SEX AS h_sex
                       FROM rpfp.couples hic
                  LEFT JOIN rpfp.individual husband ON husband.COUPLES_ID = hic.COUPLES_ID AND husband.SEX = 1
                            ) full_data
                         ON full_data.h_couplesid = couples.COUPLES_ID
              WHERE couples.IS_ACTIVE = 0
                AND full_data.h_sex IS NULL
                AND YEAR(rc.DATE_CONDUCTED) = report_year 
                AND MONTH(rc.DATE_CONDUCTED) = count_month  
                AND (
                        QUOTE(lp.REGION_CODE) = QUOTE(08)
                     OR (IFNULL( 08, 0 ) = 0)
                    )
           GROUP BY individualid, w_last, w_first, w_bday, w_sex, h_last, h_first, h_ext, h_bday, h_sex
             HAVING COUNT(individualid)
        ) total_reached
        ;

       SELECT COUNT(*) INTO couple_attendee
       FROM (
            SELECT 	couples.COUPLES_ID AS couplesid,
                    couples.IS_ACTIVE AS active_status,
                    husband.LNAME AS h_last,
                    husband.FNAME AS h_first,
                    husband.EXT_NAME AS h_ext,
                    husband.BDATE AS h_bday,
                    husband.SEX AS h_sex,
                    full_data.w_couplesid AS w_couplesid,
                    full_data.w_last AS w_last,
                    full_data.w_first AS w_first,
                    full_data.w_bday AS w_bday,
                    full_data.w_sex AS sex_w
               FROM rpfp.couples couples
          LEFT JOIN rpfp.rpfp_class rc ON rc.RPFP_CLASS_ID = couples.RPFP_CLASS_ID
          LEFT JOIN rpfp.lib_psgc_locations lp ON lp.PSGC_CODE = rc.BARANGAY_ID
          LEFT JOIN rpfp.individual husband ON husband.COUPLES_ID = couples.COUPLES_ID AND husband.SEX = 1
          LEFT JOIN (
                     SELECT wic.COUPLES_ID AS w_couplesid,
                            wife.LNAME AS w_last,
                            wife.FNAME AS w_first,
                            wife.BDATE AS w_bday,
                            wife.SEX AS w_sex
                       FROM rpfp.couples wic
                  LEFT JOIN rpfp.individual wife ON wife.COUPLES_ID = wic.COUPLES_ID AND wife.SEX = 2
                            ) full_data
                         ON full_data.w_couplesid = couples.COUPLES_ID
              WHERE couples.IS_ACTIVE = 0
                AND husband.SEX != 0
                AND full_data.w_sex != 0
                AND YEAR(rc.DATE_CONDUCTED) = report_year 
                AND MONTH(rc.DATE_CONDUCTED) = count_month  
                AND (
                        QUOTE(lp.REGION_CODE) = QUOTE(psgc_code)
                     OR (IFNULL( psgc_code, 0 ) = 0)
                    )
           GROUP BY couplesid, h_last, h_first, h_ext, h_bday, h_sex, w_last, w_first, w_bday, w_sex
             HAVING COUNT(couplesid)
        ) total_reached
        ;

       SELECT COUNT(*) INTO reached_total
       FROM (
            SELECT 	couples.COUPLES_ID AS couplesid,
                    couples.IS_ACTIVE AS active_status,
                    husband.LNAME AS h_last,
                    husband.FNAME AS h_first,
                    husband.EXT_NAME AS h_ext,
                    husband.BDATE AS h_bday,
                    husband.SEX AS h_sex,
                    full_data.w_couplesid AS w_couplesid,
                    full_data.w_last AS w_last,
                    full_data.w_first AS w_first,
                    full_data.w_bday AS w_bday,
                    full_data.w_sex AS sex_w
               FROM rpfp.couples couples
          LEFT JOIN rpfp.rpfp_class rc ON rc.RPFP_CLASS_ID = couples.RPFP_CLASS_ID
          LEFT JOIN rpfp.lib_psgc_locations lp ON lp.PSGC_CODE = rc.BARANGAY_ID
          LEFT JOIN rpfp.individual husband ON husband.COUPLES_ID = couples.COUPLES_ID AND husband.SEX = 1
          LEFT JOIN (
                     SELECT wic.COUPLES_ID AS w_couplesid,
                            wife.LNAME AS w_last,
                            wife.FNAME AS w_first,
                            wife.BDATE AS w_bday,
                            wife.SEX AS w_sex
                       FROM rpfp.couples wic
                  LEFT JOIN rpfp.individual wife ON wife.COUPLES_ID = wic.COUPLES_ID AND wife.SEX = 2
                            ) full_data
                         ON full_data.w_couplesid = couples.COUPLES_ID
              WHERE couples.IS_ACTIVE = 0
                AND YEAR(rc.DATE_CONDUCTED) = report_year 
                AND MONTH(rc.DATE_CONDUCTED) = count_month  
                AND (
                        QUOTE(lp.REGION_CODE) = QUOTE(psgc_code)
                     OR (IFNULL( psgc_code, 0 ) = 0)
                    )
           GROUP BY couplesid, h_last, h_first, h_ext, h_bday, h_sex, w_last, w_first, w_bday, w_sex
             HAVING COUNT(couplesid)
        ) total_reached
        ;

        INSERT INTO rpfp.report_demandgen (
                DEMANDGEN_ID,
                REPORT_YEAR,
                REPORT_CODE,
                REPORT_MONTH,
                PSGC_CODE,
                CLASS_4PS,
                CLASS_NON4PS,
                CLASS_USAPAN,
                CLASS_PMC,
                CLASS_H2H,
                CLASS_PROFILED,
                CLASS_TOTAL,
                TARGET_COUPLES,
                WRA_4PS,
                WRA_NON4PS,
                WRA_USAPAN,
                WRA_PMC,
                WRA_H2H,
                WRA_PROFILED,
                WRA_TOTAL,
                SOLO_MALE,
                SOLO_FEMALE,
                COUPLE_ATTENDEE,
                REACHED_TOTAL,
                IS_ACTIVE,
                DATE_PROCESSED
            )
        VALUES (
                random_no,
                report_year,
                report_code,
                count_month,
                psgc_code,
                class_4ps,
                class_non4ps,
                class_usapan,
                class_pmc,
                class_h2h,
                class_profiled,
                class_total,
                target_couples,
                wra_4ps,
                wra_non4ps_total,
                wra_usapan,
                wra_pmc,
                wra_h2h,
                wra_profiled,
                wra_total,
                solo_male,
                solo_female,
                couple_attendee,
                reached_total,
                report_status,
                CURRENT_DATE()
            )
        ;

        SET count_month = count_month + 1;
END LOOP;
    SELECT CONCAT( "NEW ENTRY: ", LAST_INSERT_ID() ) AS MESSAGE;
END$$

CREATE DEFINER=root@localhost PROCEDURE process_unmet_need (
    IN report_type INT,
    IN report_year INT,
    IN report_quarter INT,
    IN report_month INT,
    IN psgc_code INT
    )  MODIFIES SQL DATA
proc_exit_point :
BEGIN
DECLARE unmet_modern_tm INT;
DECLARE unmet_modern_nm INT;
DECLARE served_modern INT;
DECLARE no_intention INT;
DECLARE w_intention INT;
DECLARE served_traditional INT;
DECLARE total_unmet INT;
DECLARE total_served INT;
DECLARE report_scope VARCHAR(100);
DECLARE report_range INT;
DECLARE count_month INT;
DECLARE report_code VARCHAR(50);
DECLARE report_status INT DEFAULT 0;
    
DECLARE random_no VARCHAR(100) DEFAULT 0 ;

IF report_type = 1 THEN
    SET report_scope = 'ANNUAL';
    SET report_range = report_year;
    SET report_month = 12;
    SET count_month = 1;
    SET report_code = 'Annual';
END IF;

IF report_type = 2 THEN
    SET report_scope = 'QUARTER';
    SET report_range = report_quarter;
    SET report_month = report_quarter * 3;
    SET count_month = report_quarter * 3 - 2;
    SET report_code = CONCAT('Quarter ', report_quarter);
END IF;

IF report_type = 3 THEN
    SET report_scope = 'MONTHLY';
    SET report_range = report_month;
    SET count_month = report_month;
    SET report_code = MONTHNAME(CONCAT(report_year,'-',report_month,'-1'));
END IF;

IF psgc_code = 0 THEN
    SET random_no = CONCAT("PMED-", report_scope, "-", psgc_code, "-", report_range);
ELSE
    SET random_no = CONCAT("RDM-", report_scope, "-", psgc_code, "-", report_range);
END IF;

loop_label: LOOP
    IF count_month > report_month THEN
        LEAVE loop_label;
    END IF;

    SELECT COUNT(*) 
      INTO unmet_modern_tm 
      FROM rpfp.individual ic
 LEFT JOIN rpfp.couples apc ON apc.COUPLES_ID = ic.COUPLES_ID
 LEFT JOIN rpfp.rpfp_class rc ON rc.RPFP_CLASS_ID = apc.RPFP_CLASS_ID
 LEFT JOIN rpfp.fp_details fd ON fd.COUPLES_ID = ic.COUPLES_ID
 LEFT JOIN rpfp.lib_psgc_locations lp ON lp.PSGC_CODE = rc.BARANGAY_ID
     WHERE ic.SEX = 2 
       AND ic.AGE >= 15
       AND ic.AGE <= 49
       AND apc.IS_ACTIVE = 0
       AND YEAR(rc.DATE_CONDUCTED) = report_year 
       AND MONTH(rc.DATE_CONDUCTED) = report_month 
       AND fd.TFP_TYPE_ID > 0
       AND fd.TFP_TYPE_ID < 6
         AND (
                QUOTE(lp.REGION_CODE) = QUOTE(psgc_code)
             OR (IFNULL( psgc_code, 0 ) = 0)
            )
       ;

    SELECT COUNT(*)
      INTO unmet_modern_nm 
      FROM rpfp.individual ic
 LEFT JOIN rpfp.couples apc ON apc.COUPLES_ID = ic.COUPLES_ID
 LEFT JOIN rpfp.rpfp_class rc ON rc.RPFP_CLASS_ID = apc.RPFP_CLASS_ID
 LEFT JOIN rpfp.fp_details fd ON fd.COUPLES_ID = ic.COUPLES_ID
 LEFT JOIN rpfp.lib_psgc_locations lp ON lp.PSGC_CODE = rc.BARANGAY_ID
     WHERE ic.SEX = 2 
       AND ic.AGE >= 15
       AND ic.AGE <= 49
       AND apc.IS_ACTIVE = 0
       AND YEAR(rc.DATE_CONDUCTED) = report_year 
       AND MONTH(rc.DATE_CONDUCTED) = report_month 
       AND fd.TFP_TYPE_ID = 6
       AND fd.TFP_STATUS_ID = 1
         AND (
                QUOTE(lp.REGION_CODE) = QUOTE(psgc_code)
             OR (IFNULL( psgc_code, 0 ) = 0)
            )
       ;

    SELECT COUNT(*)
      INTO served_modern 
      FROM rpfp.fp_service fs
 LEFT JOIN rpfp.couples apc ON apc.COUPLES_ID = fs.COUPLES_ID
 LEFT JOIN rpfp.rpfp_class rc ON rc.RPFP_CLASS_ID = apc.RPFP_CLASS_ID
 LEFT JOIN rpfp.lib_psgc_locations lp ON lp.PSGC_CODE = rc.BARANGAY_ID
     WHERE fs.IS_PROVIDED_SERVICE = 1
       AND YEAR(fs.DATE_SERVED) = report_year 
       AND MONTH(fs.DATE_SERVED) = report_month
         AND (
                QUOTE(lp.REGION_CODE) = QUOTE(psgc_code)
             OR (IFNULL( psgc_code, 0 ) = 0)
            )
       ;

    SELECT COUNT(*)
      INTO no_intention 
      FROM rpfp.individual ic
 LEFT JOIN rpfp.couples apc ON apc.COUPLES_ID = ic.COUPLES_ID
 LEFT JOIN rpfp.rpfp_class rc ON rc.RPFP_CLASS_ID = apc.RPFP_CLASS_ID
 LEFT JOIN rpfp.fp_details fd ON fd.COUPLES_ID = ic.COUPLES_ID
 LEFT JOIN rpfp.lib_psgc_locations lp ON lp.PSGC_CODE = rc.BARANGAY_ID
     WHERE ic.SEX = 2 
       AND ic.AGE >= 15
       AND ic.AGE <= 49
       AND apc.IS_ACTIVE = 0
       AND YEAR(rc.DATE_CONDUCTED) = report_year 
       AND MONTH(rc.DATE_CONDUCTED) = report_month 
       AND fd.TFP_TYPE_ID > 0
       AND fd.TFP_TYPE_ID < 6
       AND fd.TFP_STATUS_ID > 1
         AND (
                QUOTE(lp.REGION_CODE) = QUOTE(psgc_code)
             OR (IFNULL( psgc_code, 0 ) = 0)
            )
       ;

    SELECT COUNT(*)
      INTO w_intention 
      FROM rpfp.individual ic
 LEFT JOIN rpfp.couples apc ON apc.COUPLES_ID = ic.COUPLES_ID
 LEFT JOIN rpfp.rpfp_class rc ON rc.RPFP_CLASS_ID = apc.RPFP_CLASS_ID
 LEFT JOIN rpfp.fp_details fd ON fd.COUPLES_ID = ic.COUPLES_ID
 LEFT JOIN rpfp.lib_psgc_locations lp ON lp.PSGC_CODE = rc.BARANGAY_ID
     WHERE ic.SEX = 2 
       AND ic.AGE >= 15
       AND ic.AGE <= 49
       AND apc.IS_ACTIVE = 0
       AND YEAR(rc.DATE_CONDUCTED) = report_year 
       AND MONTH(rc.DATE_CONDUCTED) = report_month 
       AND fd.TFP_TYPE_ID > 0
       AND fd.TFP_TYPE_ID < 6
       AND fd.TFP_STATUS_ID = 1
         AND (
                QUOTE(lp.REGION_CODE) = QUOTE(psgc_code)
             OR (IFNULL( psgc_code, 0 ) = 0)
            )
       ;

    SELECT COUNT(*)
      INTO served_traditional 
      FROM rpfp.individual ic
 LEFT JOIN rpfp.couples apc ON apc.COUPLES_ID = ic.COUPLES_ID
 LEFT JOIN rpfp.rpfp_class rc ON rc.RPFP_CLASS_ID = apc.RPFP_CLASS_ID
 LEFT JOIN rpfp.fp_details fd ON fd.COUPLES_ID = ic.COUPLES_ID
 LEFT JOIN rpfp.fp_service fs ON fs.COUPLES_ID = ic.COUPLES_ID
 LEFT JOIN rpfp.lib_psgc_locations lp ON lp.PSGC_CODE = rc.BARANGAY_ID
     WHERE ic.SEX = 2 
       AND ic.AGE >= 15
       AND ic.AGE <= 49
       AND apc.IS_ACTIVE = 0
       AND fd.TFP_TYPE_ID > 0
       AND fd.TFP_TYPE_ID < 6
       AND fd.TFP_STATUS_ID > 1
       AND fs.IS_PROVIDED_SERVICE = 1
       AND YEAR(fs.DATE_SERVED) = report_year 
       AND MONTH(fs.DATE_SERVED) = report_month
         AND (
                QUOTE(lp.REGION_CODE) = QUOTE(psgc_code)
             OR (IFNULL( psgc_code, 0 ) = 0)
            )
       ;

       SET total_unmet = unmet_modern_tm + unmet_modern_nm;
       SET total_served = served_modern;

        INSERT INTO rpfp.report_unmet_need (
                UNMET_ID,
                REPORT_YEAR,
                REPORT_CODE,
                REPORT_MONTH,
                PSGC_CODE,
                UNMET_MODERN_FP,
                SERVED_MODERN_FP,
                NO_INTENTION,
                W_INTENTION,
                SERVED_TRADITIONAL,
                TOTAL_UNMET,
                TOTAL_SERVED,
                IS_ACTIVE,
                DATE_PROCESSED
            )
        VALUES (
                random_no,
                report_year,
                report_code,
                count_month,
                psgc_code,
                total_unmet,
                served_modern,
                no_intention,
                w_intention,
                served_traditional,
                total_unmet,
                total_served,
                report_status,
                CURRENT_DATE()
            )
        ;

        SET count_month = count_month + 1;
END LOOP;
        SELECT CONCAT( "NEW ENTRY: ", LAST_INSERT_ID() ) AS MESSAGE;
END$$

CREATE DEFINER=root@localhost PROCEDURE process_served_method_mix (
    IN report_type INT,
    IN report_year INT,
    IN report_quarter INT,
    IN report_month INT,
    IN psgc_code INT
    )  MODIFIES SQL DATA
proc_exit_point :
BEGIN
DECLARE served_condom INT;
DECLARE served_iud INT;
DECLARE served_pills INT;
DECLARE served_injectables INT;
DECLARE served_nsv INT;
DECLARE served_btl INT;
DECLARE served_implant INT;
DECLARE served_cmm INT;
DECLARE served_bbt INT;
DECLARE served_symptothermal INT;
DECLARE served_sdm INT;
DECLARE served_lam INT;
DECLARE total_served INT;
DECLARE report_scope VARCHAR(100);
DECLARE report_range INT;
DECLARE count_month INT;
DECLARE report_code VARCHAR(50);
DECLARE report_status INT DEFAULT 0;

DECLARE random_no VARCHAR(100) DEFAULT 0 ;

IF report_type = 1 THEN
    SET report_scope = 'ANNUAL';
    SET report_range = report_year;
    SET report_month = 12;
    SET count_month = 1;
    SET report_code = 'Annual';
END IF;

IF report_type = 2 THEN
    SET report_scope = 'QUARTER';
    SET report_range = report_quarter;
    SET report_month = report_quarter * 3;
    SET count_month = report_quarter * 3 - 2;
    SET report_code = CONCAT('Quarter ', report_quarter);
END IF;

IF report_type = 3 THEN
    SET report_scope = 'MONTHLY';
    SET report_range = report_month;
    SET count_month = report_month;
    SET report_code = MONTHNAME(CONCAT(report_year,'-',report_month,'-1'));
END IF;

IF psgc_code = 0 THEN
    SET random_no = CONCAT("PMED-", report_scope, "-", psgc_code, "-", report_range);
ELSE
    SET random_no = CONCAT("RDM-", report_scope, "-", psgc_code, "-", report_range);
END IF;

loop_label: LOOP
    IF count_month > report_month THEN
        LEAVE loop_label;
    END IF;

    SELECT COUNT(*)
      INTO served_condom 
      FROM rpfp.couples apc
 LEFT JOIN rpfp.fp_service fs ON fs.COUPLES_ID = apc.COUPLES_ID
 LEFT JOIN rpfp.rpfp_class rc ON rc.RPFP_CLASS_ID = apc.RPFP_CLASS_ID
 LEFT JOIN rpfp.lib_psgc_locations lp ON lp.PSGC_CODE = rc.BARANGAY_ID
     WHERE apc.IS_ACTIVE = 0
       AND YEAR(fs.DATE_SERVED) = report_year 
       AND MONTH(fs.DATE_SERVED) = report_month
       AND fs.FP_SERVED_ID = 1
       AND fs.IS_PROVIDED_SERVICE = 1
         AND (
                QUOTE(lp.REGION_CODE) = QUOTE(psgc_code)
             OR (IFNULL( psgc_code, 0 ) = 0)
            )
       ;

    SELECT COUNT(*) 
      INTO served_iud 
      FROM rpfp.couples apc
 LEFT JOIN rpfp.fp_service fs ON fs.COUPLES_ID = apc.COUPLES_ID
 LEFT JOIN rpfp.rpfp_class rc ON rc.RPFP_CLASS_ID = apc.RPFP_CLASS_ID
 LEFT JOIN rpfp.lib_psgc_locations lp ON lp.PSGC_CODE = rc.BARANGAY_ID
     WHERE apc.IS_ACTIVE = 0
       AND YEAR(fs.DATE_SERVED) = report_year 
       AND MONTH(fs.DATE_SERVED) = report_month
       AND fs.FP_SERVED_ID = 2
       AND fs.IS_PROVIDED_SERVICE = 1
         AND (
                QUOTE(lp.REGION_CODE) = QUOTE(psgc_code)
             OR (IFNULL( psgc_code, 0 ) = 0)
            )
       ;

    SELECT COUNT(*)
      INTO served_pills 
      FROM rpfp.couples apc
 LEFT JOIN rpfp.fp_service fs ON fs.COUPLES_ID = apc.COUPLES_ID
 LEFT JOIN rpfp.rpfp_class rc ON rc.RPFP_CLASS_ID = apc.RPFP_CLASS_ID
 LEFT JOIN rpfp.lib_psgc_locations lp ON lp.PSGC_CODE = rc.BARANGAY_ID
     WHERE apc.IS_ACTIVE = 0
       AND YEAR(fs.DATE_SERVED) = report_year 
       AND MONTH(fs.DATE_SERVED) = report_month
       AND fs.FP_SERVED_ID = 3
       AND fs.IS_PROVIDED_SERVICE = 1
         AND (
                QUOTE(lp.REGION_CODE) = QUOTE(psgc_code)
             OR (IFNULL( psgc_code, 0 ) = 0)
            )
       ;

    SELECT COUNT(*)
      INTO served_injectables 
      FROM rpfp.couples apc
 LEFT JOIN rpfp.fp_service fs ON fs.COUPLES_ID = apc.COUPLES_ID
 LEFT JOIN rpfp.rpfp_class rc ON rc.RPFP_CLASS_ID = apc.RPFP_CLASS_ID
 LEFT JOIN rpfp.lib_psgc_locations lp ON lp.PSGC_CODE = rc.BARANGAY_ID
     WHERE apc.IS_ACTIVE = 0
       AND YEAR(fs.DATE_SERVED) = report_year 
       AND MONTH(fs.DATE_SERVED) = report_month
       AND fs.FP_SERVED_ID = 4
       AND fs.IS_PROVIDED_SERVICE = 1
         AND (
                QUOTE(lp.REGION_CODE) = QUOTE(psgc_code)
             OR (IFNULL( psgc_code, 0 ) = 0)
            )
       ;

    SELECT COUNT(*)
      INTO served_nsv 
      FROM rpfp.couples apc
 LEFT JOIN rpfp.fp_service fs ON fs.COUPLES_ID = apc.COUPLES_ID
 LEFT JOIN rpfp.rpfp_class rc ON rc.RPFP_CLASS_ID = apc.RPFP_CLASS_ID
 LEFT JOIN rpfp.lib_psgc_locations lp ON lp.PSGC_CODE = rc.BARANGAY_ID
     WHERE apc.IS_ACTIVE = 0
       AND YEAR(fs.DATE_SERVED) = report_year 
       AND MONTH(fs.DATE_SERVED) = report_month
       AND fs.FP_SERVED_ID = 5
       AND fs.IS_PROVIDED_SERVICE = 1
         AND (
                QUOTE(lp.REGION_CODE) = QUOTE(psgc_code)
             OR (IFNULL( psgc_code, 0 ) = 0)
            )
       ;

    SELECT COUNT(*)
      INTO served_btl 
      FROM rpfp.couples apc
 LEFT JOIN rpfp.fp_service fs ON fs.COUPLES_ID = apc.COUPLES_ID
 LEFT JOIN rpfp.rpfp_class rc ON rc.RPFP_CLASS_ID = apc.RPFP_CLASS_ID
 LEFT JOIN rpfp.lib_psgc_locations lp ON lp.PSGC_CODE = rc.BARANGAY_ID
     WHERE apc.IS_ACTIVE = 0
       AND YEAR(fs.DATE_SERVED) = report_year 
       AND MONTH(fs.DATE_SERVED) = report_month
       AND fs.FP_SERVED_ID = 6
       AND fs.IS_PROVIDED_SERVICE = 1
         AND (
                QUOTE(lp.REGION_CODE) = QUOTE(psgc_code)
             OR (IFNULL( psgc_code, 0 ) = 0)
            )
       ;

    SELECT COUNT(*) 
      INTO served_implant 
      FROM rpfp.couples apc
 LEFT JOIN rpfp.fp_service fs ON fs.COUPLES_ID = apc.COUPLES_ID
 LEFT JOIN rpfp.rpfp_class rc ON rc.RPFP_CLASS_ID = apc.RPFP_CLASS_ID
 LEFT JOIN rpfp.lib_psgc_locations lp ON lp.PSGC_CODE = rc.BARANGAY_ID
     WHERE apc.IS_ACTIVE = 0
       AND YEAR(fs.DATE_SERVED) = report_year 
       AND MONTH(fs.DATE_SERVED) = report_month
       AND fs.FP_SERVED_ID = 7
       AND fs.IS_PROVIDED_SERVICE = 1
         AND (
                QUOTE(lp.REGION_CODE) = QUOTE(psgc_code)
             OR (IFNULL( psgc_code, 0 ) = 0)
            )
       ;

    SELECT COUNT(*)
      INTO served_cmm 
      FROM rpfp.couples apc
 LEFT JOIN rpfp.fp_service fs ON fs.COUPLES_ID = apc.COUPLES_ID
 LEFT JOIN rpfp.rpfp_class rc ON rc.RPFP_CLASS_ID = apc.RPFP_CLASS_ID
 LEFT JOIN rpfp.lib_psgc_locations lp ON lp.PSGC_CODE = rc.BARANGAY_ID
     WHERE apc.IS_ACTIVE = 0
       AND YEAR(fs.DATE_SERVED) = report_year 
       AND MONTH(fs.DATE_SERVED) = report_month
       AND fs.FP_SERVED_ID = 8
       AND fs.IS_PROVIDED_SERVICE = 1
         AND (
                QUOTE(lp.REGION_CODE) = QUOTE(psgc_code)
             OR (IFNULL( psgc_code, 0 ) = 0)
            )
       ;

    SELECT COUNT(*)
      INTO served_bbt 
      FROM rpfp.couples apc
 LEFT JOIN rpfp.fp_service fs ON fs.COUPLES_ID = apc.COUPLES_ID
 LEFT JOIN rpfp.rpfp_class rc ON rc.RPFP_CLASS_ID = apc.RPFP_CLASS_ID
 LEFT JOIN rpfp.lib_psgc_locations lp ON lp.PSGC_CODE = rc.BARANGAY_ID
     WHERE apc.IS_ACTIVE = 0
       AND YEAR(fs.DATE_SERVED) = report_year 
       AND MONTH(fs.DATE_SERVED) = report_month
       AND fs.FP_SERVED_ID = 9
       AND fs.IS_PROVIDED_SERVICE = 1
         AND (
                QUOTE(lp.REGION_CODE) = QUOTE(psgc_code)
             OR (IFNULL( psgc_code, 0 ) = 0)
            )
       ;

    SELECT COUNT(*)
      INTO served_symptothermal 
      FROM rpfp.couples apc
 LEFT JOIN rpfp.fp_service fs ON fs.COUPLES_ID = apc.COUPLES_ID
 LEFT JOIN rpfp.rpfp_class rc ON rc.RPFP_CLASS_ID = apc.RPFP_CLASS_ID
 LEFT JOIN rpfp.lib_psgc_locations lp ON lp.PSGC_CODE = rc.BARANGAY_ID
     WHERE apc.IS_ACTIVE = 0
       AND YEAR(fs.DATE_SERVED) = report_year 
       AND MONTH(fs.DATE_SERVED) = report_month
       AND fs.FP_SERVED_ID = 10
       AND fs.IS_PROVIDED_SERVICE = 1
         AND (
                QUOTE(lp.REGION_CODE) = QUOTE(psgc_code)
             OR (IFNULL( psgc_code, 0 ) = 0)
            )
       ;

    SELECT COUNT(*)
      INTO served_sdm 
      FROM rpfp.couples apc
 LEFT JOIN rpfp.fp_service fs ON fs.COUPLES_ID = apc.COUPLES_ID
 LEFT JOIN rpfp.rpfp_class rc ON rc.RPFP_CLASS_ID = apc.RPFP_CLASS_ID
 LEFT JOIN rpfp.lib_psgc_locations lp ON lp.PSGC_CODE = rc.BARANGAY_ID
     WHERE apc.IS_ACTIVE = 0
       AND YEAR(fs.DATE_SERVED) = report_year 
       AND MONTH(fs.DATE_SERVED) = report_month
       AND fs.FP_SERVED_ID = 11
       AND fs.IS_PROVIDED_SERVICE = 1
         AND (
                QUOTE(lp.REGION_CODE) = QUOTE(psgc_code)
             OR (IFNULL( psgc_code, 0 ) = 0)
            )
       ;

    SELECT COUNT(*)
      INTO served_lam 
      FROM rpfp.couples apc
 LEFT JOIN rpfp.fp_service fs ON fs.COUPLES_ID = apc.COUPLES_ID
 LEFT JOIN rpfp.rpfp_class rc ON rc.RPFP_CLASS_ID = apc.RPFP_CLASS_ID
 LEFT JOIN rpfp.lib_psgc_locations lp ON lp.PSGC_CODE = rc.BARANGAY_ID
     WHERE apc.IS_ACTIVE = 0
       AND YEAR(fs.DATE_SERVED) = report_year 
       AND MONTH(fs.DATE_SERVED) = report_month
       AND fs.FP_SERVED_ID = 12
       AND fs.IS_PROVIDED_SERVICE = 1
         AND (
                QUOTE(lp.REGION_CODE) = QUOTE(psgc_code)
             OR (IFNULL( psgc_code, 0 ) = 0)
            )
       ;

    SELECT COUNT(*)
      INTO total_served 
      FROM rpfp.couples apc
 LEFT JOIN rpfp.fp_service fs ON fs.COUPLES_ID = apc.COUPLES_ID
 LEFT JOIN rpfp.rpfp_class rc ON rc.RPFP_CLASS_ID = apc.RPFP_CLASS_ID
 LEFT JOIN rpfp.lib_psgc_locations lp ON lp.PSGC_CODE = rc.BARANGAY_ID
     WHERE apc.IS_ACTIVE = 0
       AND YEAR(fs.DATE_SERVED) = report_year 
       AND MONTH(fs.DATE_SERVED) = report_month
       AND fs.IS_PROVIDED_SERVICE = 1
         AND (
                QUOTE(lp.REGION_CODE) = QUOTE(psgc_code)
             OR (IFNULL( psgc_code, 0 ) = 0)
            )
       ;

        INSERT INTO rpfp.report_served_method_mix (
                SERVED_ID,
                REPORT_YEAR,
                REPORT_CODE,
                REPORT_MONTH,
                PSGC_CODE,
                SERVED_CONDOM,
                SERVED_IUD,
                SERVED_PILLS,
                SERVED_INJECTABLES,
                SERVED_NSV,
                SERVED_BTL,
                SERVED_IMPLANT,
                SERVED_CMM,
                SERVED_BBT,
                SERVED_SYMPTOTHERMAL,
                SERVED_SDM,
                SERVED_LAM,
                TOTAL_SERVED,
                IS_ACTIVE,
                DATE_PROCESSED
            )
        VALUES (
                random_no,
                report_year,
                report_code,
                count_month,
                psgc_code,
                served_condom,
                served_iud,
                served_pills,
                served_injectables,
                served_nsv,
                served_btl,
                served_implant,
                served_cmm,
                served_bbt,
                served_symptothermal,
                served_sdm,
                served_lam,
                total_served,
                report_status,
                CURRENT_DATE()
            )
        ;

        SET count_month = count_month + 1;
END LOOP;
        SELECT CONCAT( "NEW ENTRY: ", LAST_INSERT_ID() ) AS MESSAGE;
END$$
/** END PROCESS REPORTS */

/** GET REPORTS */
CREATE DEFINER=root@localhost PROCEDURE get_report_accomplishment_list(
    IN username VARCHAR(50),
    IN page_no INT,
    IN items_per_page INT
    )   READS SQL DATA
BEGIN
    DECLARE name_user VARCHAR(50);
    DECLARE db_user_name VARCHAR(50);
    DECLARE read_offset INT;

    CALL rpfp.lib_extract_user_name( username, name_user, db_user_name );

    IF NOT EXISTS (
         SELECT rce.REPORT_ID
           FROM rpfp.report_couples_encoded rce
      LEFT JOIN rpfp.user_profile up
             ON up.REGION_CODE = rce.PSGC_CODE
          WHERE up.DB_USER_ID = name_user
    ) THEN
         SELECT NULL AS report_id,
                NULL AS date_from,
                NULL AS date_to,
                NULL AS accom_id,
                NULL AS date_processed
        ;
    ELSE
        IF (IFNULL( page_no, 0) = 0) THEN
            /** DEFAULT PAGE NO. */
            SET page_no := 1;
        END IF;
        IF (IFNULL( items_per_page, 0) = 0) THEN
            /** DEFAULT COUNT PER PAGE*/
            SET items_per_page := 10;
        END IF;

        SET read_offset := (page_no - 1) * items_per_page;
         SELECT rce.REPORT_ID AS report_id,
                rce.DATE_FROM AS date_from,
                rce.DATE_TO AS date_to,
                rce.ACCOM_ID AS accom_id,
                rce.DATE_PROCESSED AS date_processed
           FROM rpfp.report_couples_encoded rce
          WHERE rce.DB_USER_ID = name_user
            AND rce.IS_ACTIVE = 0
       GROUP BY rce.ACCOM_ID
       ORDER BY rce.DATE_PROCESSED ASC
          LIMIT read_offset, items_per_page
        ;
    END IF;
END$$

CREATE DEFINER=root@localhost PROCEDURE get_report_demandgen_list(
    IN page_no INT,
    IN items_per_page INT
    )   READS SQL DATA
proc_exit_point :
BEGIN
    DECLARE read_offset INT;
    DECLARE role_of_user INT;

    SET role_of_user := rpfp.profile_get_own_role();

    IF role_of_user = 90 THEN
        CALL pmed_get_report_demandgen_list(page_no, items_per_page);
        LEAVE proc_exit_point;
    END IF;

    IF role_of_user <= 80 THEN
        CALL rdm_get_report_demandgen_list(page_no, items_per_page);
        LEAVE proc_exit_point;
    END IF;

END$$

CREATE DEFINER=root@localhost PROCEDURE pmed_get_report_demandgen_list(
    IN page_no INT,
    IN items_per_page INT
    )   READS SQL DATA
proc_exit_point :
BEGIN
    DECLARE read_offset INT;

    IF NOT EXISTS (
         SELECT rd.REPORT_ID
           FROM rpfp.report_demandgen rd
    ) THEN
         SELECT NULL AS report_id,
                NULL AS report_no,
                NULL AS report_year,
                NULL AS report_code,
                NULL AS report_month,
                NULL AS psgc_code,
                NULL AS date_processed
        ;
        LEAVE proc_exit_point;
    ELSE
        IF (IFNULL( page_no, 0) = 0) THEN
            /** DEFAULT PAGE NO. */
            SET page_no := 1;
        END IF;
        IF (IFNULL( items_per_page, 0) = 0) THEN
            /** DEFAULT COUNT PER PAGE*/
            SET items_per_page := 10;
        END IF;

        SET read_offset := (page_no - 1) * items_per_page;

         SELECT rd.REPORT_ID AS report_id,
                rd.DEMANDGEN_ID AS report_no,
                rd.REPORT_YEAR AS report_year,
                rd.REPORT_CODE AS report_code,
                rd.REPORT_MONTH AS report_month,
                rd.PSGC_CODE AS psgc_code,
                rd.DATE_PROCESSED AS date_processed
           FROM rpfp.report_demandgen rd
          WHERE rd.IS_ACTIVE = 0
       GROUP BY rd.DEMANDGEN_ID
       ORDER BY rd.DATE_PROCESSED ASC
          LIMIT read_offset, items_per_page
        ;
    END IF;
END$$

CREATE DEFINER=root@localhost PROCEDURE rdm_get_report_demandgen_list(
    IN page_no INT,
    IN items_per_page INT
    )   READS SQL DATA
proc_exit_point :
BEGIN
    DECLARE read_offset INT;
    DECLARE region_of_user INT;

    SET region_of_user := rpfp.profile_get_own_region();

    IF NOT EXISTS (
         SELECT rd.REPORT_ID
           FROM rpfp.report_demandgen rd
          WHERE rd.PSGC_CODE = region_of_user
    ) THEN
         SELECT NULL AS report_id,
                NULL AS report_no,
                NULL AS report_year,
                NULL AS report_code,
                NULL AS report_month,
                NULL AS psgc_code,
                NULL AS date_processed
        ;
        LEAVE proc_exit_point;
    ELSE
        IF (IFNULL( page_no, 0) = 0) THEN
            /** DEFAULT PAGE NO. */
            SET page_no := 1;
        END IF;
        IF (IFNULL( items_per_page, 0) = 0) THEN
            /** DEFAULT COUNT PER PAGE*/
            SET items_per_page := 10;
        END IF;

        SET read_offset := (page_no - 1) * items_per_page;

         SELECT DISTINCT
                rd.REPORT_ID AS report_id,
                rd.DEMANDGEN_ID AS report_no,
                rd.REPORT_YEAR AS report_year,
                rd.REPORT_CODE AS report_code,
                rd.REPORT_MONTH AS report_month,
                rd.PSGC_CODE AS psgc_code,
                rd.DATE_PROCESSED AS date_processed
           FROM rpfp.report_demandgen rd
          WHERE rd.PSGC_CODE = region_of_user
            AND rd.IS_ACTIVE = 0
       GROUP BY rd.DEMANDGEN_ID
       ORDER BY rd.DATE_PROCESSED ASC
          LIMIT read_offset, items_per_page
        ;
    END IF;
END$$

CREATE DEFINER=root@localhost PROCEDURE get_report_unmet_need_list(
    IN page_no INT,
    IN items_per_page INT
    )   READS SQL DATA
proc_exit_point :
BEGIN
    DECLARE read_offset INT;
    DECLARE role_of_user INT;

    SET role_of_user := rpfp.profile_get_own_role();

    IF role_of_user = 90 THEN
        CALL pmed_get_report_unmet_need_list(page_no, items_per_page);
        LEAVE proc_exit_point;
    END IF;

    IF role_of_user <= 80 THEN
        CALL rdm_get_report_unmet_need_list(page_no, items_per_page);
        LEAVE proc_exit_point;
    END IF;
END$$

CREATE DEFINER=root@localhost PROCEDURE pmed_get_report_unmet_need_list(
    IN page_no INT,
    IN items_per_page INT
    )   READS SQL DATA
BEGIN
    DECLARE read_offset INT;

    IF NOT EXISTS (
         SELECT ru.REPORT_ID
           FROM rpfp.report_unmet_need ru
    ) THEN
         SELECT NULL AS report_id,
                NULL AS report_no,
                NULL AS report_year,
                NULL AS report_code,
                NULL AS report_month,
                NULL AS psgc_code,
                NULL AS date_processed
        ;
    ELSE
        IF (IFNULL( page_no, 0) = 0) THEN
            /** DEFAULT PAGE NO. */
            SET page_no := 1;
        END IF;
        IF (IFNULL( items_per_page, 0) = 0) THEN
            /** DEFAULT COUNT PER PAGE*/
            SET items_per_page := 10;
        END IF;

        SET read_offset := (page_no - 1) * items_per_page;
        
         SELECT ru.REPORT_ID AS report_id,
                ru.UNMET_ID AS report_no,
                ru.REPORT_YEAR AS report_year,
                ru.REPORT_CODE AS report_code,
                ru.REPORT_MONTH AS report_month,
                ru.PSGC_CODE AS psgc_code,
                ru.DATE_PROCESSED AS date_processed
           FROM rpfp.report_unmet_need ru
          WHERE ru.IS_ACTIVE = 0
       GROUP BY ru.UNMET_ID
       ORDER BY ru.DATE_PROCESSED ASC
          LIMIT read_offset, items_per_page
        ;
    END IF;
END$$

CREATE DEFINER=root@localhost PROCEDURE rdm_get_report_unmet_need_list(
    IN page_no INT,
    IN items_per_page INT
    )   READS SQL DATA
BEGIN
    DECLARE read_offset INT;
    DECLARE region_of_user INT;

    SET region_of_user := rpfp.profile_get_own_region();

    IF NOT EXISTS (
         SELECT ru.REPORT_ID
           FROM rpfp.report_unmet_need ru
          WHERE ru.PSGC_CODE = region_of_user
    ) THEN
         SELECT NULL AS report_id,
                NULL AS report_no,
                NULL AS report_year,
                NULL AS report_code,
                NULL AS report_month,
                NULL AS psgc_code,
                NULL AS date_processed
        ;
    ELSE
        IF (IFNULL( page_no, 0) = 0) THEN
            /** DEFAULT PAGE NO. */
            SET page_no := 1;
        END IF;
        IF (IFNULL( items_per_page, 0) = 0) THEN
            /** DEFAULT COUNT PER PAGE*/
            SET items_per_page := 10;
        END IF;

        SET read_offset := (page_no - 1) * items_per_page;
        
         SELECT ru.REPORT_ID AS report_id,
                ru.UNMET_ID AS report_no,
                ru.REPORT_YEAR AS report_year,
                ru.REPORT_CODE AS report_code,
                ru.REPORT_MONTH AS report_month,
                ru.PSGC_CODE AS psgc_code,
                ru.DATE_PROCESSED AS date_processed
           FROM rpfp.report_unmet_need ru
          WHERE ru.PSGC_CODE = region_of_user
            AND ru.IS_ACTIVE = 0
       GROUP BY ru.UNMET_ID
       ORDER BY ru.DATE_PROCESSED ASC
          LIMIT read_offset, items_per_page
        ;
    END IF;
END$$

CREATE DEFINER=root@localhost PROCEDURE get_report_served_method_mix_list(
    IN page_no INT,
    IN items_per_page INT
    )   READS SQL DATA
proc_exit_point :
BEGIN
    DECLARE read_offset INT;
    DECLARE role_of_user INT;

    SET role_of_user := rpfp.profile_get_own_role();

    IF role_of_user = 90 THEN
        CALL pmed_get_report_served_method_mix_list(page_no, items_per_page);
        LEAVE proc_exit_point;
    END IF;

    IF role_of_user <= 80 THEN
        CALL rdm_get_report_served_method_mix_list(page_no, items_per_page);
        LEAVE proc_exit_point;
    END IF;
END$$

CREATE DEFINER=root@localhost PROCEDURE pmed_get_report_served_method_mix_list(
    IN page_no INT,
    IN items_per_page INT
    )   READS SQL DATA
BEGIN
    DECLARE read_offset INT;
    DECLARE region_of_user INT;

    SET region_of_user := rpfp.profile_get_own_region();

    IF NOT EXISTS (
         SELECT rs.REPORT_ID
           FROM rpfp.report_served_method_mix rs
    ) THEN
         SELECT NULL AS report_id,
                NULL AS report_no,
                NULL AS report_year,
                NULL AS report_code,
                NULL AS report_month,
                NULL AS psgc_code,
                NULL AS date_processed
        ;
    ELSE
        IF (IFNULL( page_no, 0) = 0) THEN
            /** DEFAULT PAGE NO. */
            SET page_no := 1;
        END IF;
        IF (IFNULL( items_per_page, 0) = 0) THEN
            /** DEFAULT COUNT PER PAGE*/
            SET items_per_page := 10;
        END IF;

        SET read_offset := (page_no - 1) * items_per_page;
         SELECT rs.REPORT_ID AS report_id,
                rs.SERVED_ID AS report_no,
                rs.REPORT_YEAR AS report_year,
                rs.REPORT_CODE AS report_code,
                rs.REPORT_MONTH AS report_month,
                rs.PSGC_CODE AS psgc_code,
                rs.DATE_PROCESSED AS date_processed
           FROM rpfp.report_served_method_mix rs
          WHERE rs.IS_ACTIVE = 0
          GROUP BY rs.SERVED_ID
       ORDER BY rs.DATE_PROCESSED ASC
          LIMIT read_offset, items_per_page
        ;
    END IF;
END$$

CREATE DEFINER=root@localhost PROCEDURE rdm_get_report_served_method_mix_list(
    IN page_no INT,
    IN items_per_page INT
    )   READS SQL DATA
BEGIN
    DECLARE read_offset INT;
    DECLARE region_of_user INT;

    SET region_of_user := rpfp.profile_get_own_region();

    IF NOT EXISTS (
         SELECT rs.REPORT_ID
           FROM rpfp.report_served_method_mix rs
          WHERE rs.PSGC_CODE = region_of_user
    ) THEN
         SELECT NULL AS report_id,
                NULL AS report_no,
                NULL AS report_year,
                NULL AS report_code,
                NULL AS report_month,
                NULL AS psgc_code,
                NULL AS date_processed
        ;
    ELSE
        IF (IFNULL( page_no, 0) = 0) THEN
            /** DEFAULT PAGE NO. */
            SET page_no := 1;
        END IF;
        IF (IFNULL( items_per_page, 0) = 0) THEN
            /** DEFAULT COUNT PER PAGE*/
            SET items_per_page := 10;
        END IF;

        SET read_offset := (page_no - 1) * items_per_page;
         SELECT rs.REPORT_ID AS report_id,
                rs.SERVED_ID AS report_no,
                rs.REPORT_YEAR AS report_year,
                rs.REPORT_CODE AS report_code,
                rs.REPORT_MONTH AS report_month,
                rs.PSGC_CODE AS psgc_code,
                rs.DATE_PROCESSED AS date_processed
           FROM rpfp.report_served_method_mix rs
          WHERE rs.PSGC_CODE = region_of_user
            AND rs.IS_ACTIVE = 0
       GROUP BY rs.SERVED_ID
       ORDER BY rs.DATE_PROCESSED ASC
          LIMIT read_offset, items_per_page
        ;
    END IF;
END$$
/** END GET REPORTS */

/** GET REPORT DETAILS */
CREATE DEFINER=root@localhost PROCEDURE get_report_accomplishment_details(
    IN accom_id VARCHAR(100)
    )   READS SQL DATA
BEGIN
    IF NOT EXISTS (
         SELECT rce.REPORT_ID
           FROM rpfp.report_couples_encoded rce
          WHERE rce.ACCOM_ID = accom_id
    ) THEN
        BEGIN
             SELECT NULL AS date_from,
                    NULL AS date_to,
                    NULL AS psgc_code,
                    NULL AS accomplishment_id,
                    NULL AS class_no,
                    NULL AS encoded_couples,
                    NULL AS approved_couples,
                    NULL AS pending_couples,
                    NULL AS served_couples,
                    NULL AS duplicates,
                    NULL AS invalids,
                    NULL AS username,
                    NULL AS date_processed
            ;
        END;
    ELSE
        BEGIN
             SELECT rce.DATE_FROM AS date_from,
                    rce.DATE_TO AS date_to,
                    rce.PSGC_CODE AS psgc_code,
                    rce.RPFP_CLASS_NO AS class_no,
                    rce.ENCODED_COUPLES AS encoded_couples,
                    rce.APPROVED_COUPLES AS approved_couples,
                    rce.PENDING_COUPLES AS pending_couples,
                    rce.SERVED_COUPLES AS served_couples,
                    rce.DUPLICATES AS duplicates,
                    rce.INVALIDS AS invalids,
                    rce.DATE_PROCESSED AS date_processed
               FROM rpfp.report_couples_encoded rce
              WHERE rce.ACCOM_ID = accom_id
           ORDER BY rce.REPORT_ID ASC
            ;
        END;
    END IF;
END$$

CREATE DEFINER=root@localhost PROCEDURE get_report_demandgen_details(
    IN report_no VARCHAR(50),
    IN report_month INT,
    IN report_year INT
    )   READS SQL DATA
proc_exit_point :
BEGIN
    DECLARE read_offset INT;
    DECLARE role_of_user INT;

    SET role_of_user := rpfp.profile_get_own_role();

    IF role_of_user = 90 THEN
        CALL pmed_get_report_demandgen_details(report_no, report_month, report_year);
        LEAVE proc_exit_point;
    END IF;

    IF role_of_user <= 80 THEN
        CALL rdm_get_report_demandgen_details(report_no, report_month, report_year);
        LEAVE proc_exit_point;
    END IF;
END$$

CREATE DEFINER=root@localhost PROCEDURE pmed_get_report_demandgen_details(
    IN report_no VARCHAR(50),
    IN report_month INT,
    IN report_year INT
    )   READS SQL DATA
BEGIN
    DECLARE region_of_user INT;

    SET region_of_user := rpfp.profile_get_own_region();

    IF NOT EXISTS (
         SELECT rd.REPORT_ID
           FROM rpfp.report_demandgen rd
          WHERE rd.DEMANDGEN_ID = report_no
    ) THEN
        BEGIN
             SELECT NULL AS report_year,
                    NULL AS report_no,
                    NULL AS psgc_code,
                    NULL AS report_month,
                    NULL AS class_4ps,
                    NULL AS class_non4ps,
                    NULL AS class_usapan,
                    NULL AS class_pmc,
                    NULL AS class_h2h,
                    NULL AS class_profiled,
                    NULL AS class_total,
                    NULL AS target_couples,
                    NULL AS wra_4ps,
                    NULL AS wra_non4ps,
                    NULL AS wra_usapan,
                    NULL AS wra_pmc,
                    NULL AS wra_h2h,
                    NULL AS wra_profiled,
                    NULL AS wra_total,
                    NULL AS solo_male,
                    NULL AS solo_female,
                    NULL AS couple_attendee,
                    NULL AS reached_total,
                    NULL AS date_processed
            ;
        END;
    ELSE
        BEGIN
             SELECT DISTINCT
                    rd.DEMANDGEN_ID AS report_no,
                    rd.REPORT_YEAR AS report_year,
                    rd.PSGC_CODE AS psgc_code,
                    rd.REPORT_MONTH AS report_month,
                    rd.CLASS_4PS AS class_4ps,
                    rd.CLASS_NON4PS AS class_non4ps,
                    rd.CLASS_USAPAN AS class_usapan,
                    rd.CLASS_PMC AS class_pmc,
                    rd.CLASS_H2H AS class_h2h,
                    rd.CLASS_PROFILED AS class_profiled,
                    rd.CLASS_TOTAL AS class_total,
                    rd.TARGET_COUPLES AS target_couples,
                    rd.WRA_4PS AS wra_4ps,
                    rd.WRA_NON4PS AS wra_non4ps,
                    rd.WRA_USAPAN AS wra_usapan,
                    rd.WRA_PMC AS wra_pmc,
                    rd.WRA_H2H AS wra_h2h,
                    rd.WRA_PROFILED AS wra_profiled,
                    rd.WRA_TOTAL AS wra_total,
                    rd.SOLO_MALE AS solo_male,
                    rd.SOLO_FEMALE AS solo_female,
                    rd.COUPLE_ATTENDEE AS couple_attendee,
                    rd.REACHED_TOTAL AS reached_total,
                    rd.DATE_PROCESSED AS date_processed
               FROM rpfp.report_demandgen rd
              WHERE rd.REPORT_YEAR = report_year
                AND rd.DEMANDGEN_ID = report_no
           ORDER BY rd.REPORT_MONTH ASC
            ;
        END;
    END IF;
END$$

CREATE DEFINER=root@localhost PROCEDURE rdm_get_report_demandgen_details(
    IN report_no VARCHAR(50),
    IN report_month INT,
    IN report_year INT
    )   READS SQL DATA
BEGIN
    DECLARE region_of_user INT;

    SET region_of_user := rpfp.profile_get_own_region();

    IF NOT EXISTS (
         SELECT rd.REPORT_ID
           FROM rpfp.report_demandgen rd
          WHERE rd.DEMANDGEN_ID = report_no
    ) THEN
        BEGIN
             SELECT NULL AS report_year,
                    NULL AS psgc_code,
                    NULL AS report_month,
                    NULL AS class_4ps,
                    NULL AS class_non4ps,
                    NULL AS class_usapan,
                    NULL AS class_pmc,
                    NULL AS class_h2h,
                    NULL AS class_profiled,
                    NULL AS class_total,
                    NULL AS target_couples,
                    NULL AS wra_4ps,
                    NULL AS wra_non4ps,
                    NULL AS wra_usapan,
                    NULL AS wra_pmc,
                    NULL AS wra_h2h,
                    NULL AS wra_profiled,
                    NULL AS wra_total,
                    NULL AS solo_male,
                    NULL AS solo_female,
                    NULL AS couple_attendee,
                    NULL AS reached_total,
                    NULL AS date_processed
            ;
        END;
    ELSE
        BEGIN
             SELECT DISTINCT
                    rd.REPORT_YEAR AS report_year,
                    rd.PSGC_CODE AS psgc_code,
                    rd.REPORT_MONTH AS report_month,
                    rd.CLASS_4PS AS class_4ps,
                    rd.CLASS_NON4PS AS class_non4ps,
                    rd.CLASS_USAPAN AS class_usapan,
                    rd.CLASS_PMC AS class_pmc,
                    rd.CLASS_H2H AS class_h2h,
                    rd.CLASS_PROFILED AS class_profiled,
                    rd.CLASS_TOTAL AS class_total,
                    rd.TARGET_COUPLES AS target_couples,
                    rd.WRA_4PS AS wra_4ps,
                    rd.WRA_NON4PS AS wra_non4ps,
                    rd.WRA_USAPAN AS wra_usapan,
                    rd.WRA_PMC AS wra_pmc,
                    rd.WRA_H2H AS wra_h2h,
                    rd.WRA_PROFILED AS wra_profiled,
                    rd.WRA_TOTAL AS wra_total,
                    rd.SOLO_MALE AS solo_male,
                    rd.SOLO_FEMALE AS solo_female,
                    rd.COUPLE_ATTENDEE AS couple_attendee,
                    rd.REACHED_TOTAL AS reached_total,
                    rd.DATE_PROCESSED AS date_processed
               FROM rpfp.report_demandgen rd
              WHERE rd.REPORT_YEAR = report_year
                AND rd.DEMANDGEN_ID = report_no
           ORDER BY rd.REPORT_MONTH ASC
            ;
        END;
    END IF;
END$$

CREATE DEFINER=root@localhost PROCEDURE get_report_unmet_need_details(
    IN report_no VARCHAR(50),
    IN report_month INT,
    IN report_year INT
    )   READS SQL DATA
proc_exit_point :
BEGIN
    DECLARE read_offset INT;
    DECLARE role_of_user INT;

    SET role_of_user := rpfp.profile_get_own_role();

    IF role_of_user = 90 THEN
        CALL pmed_get_report_unmet_need_details(report_no, report_month, report_year);
        LEAVE proc_exit_point;
    END IF;

    IF role_of_user <= 80 THEN
        CALL rdm_get_report_unmet_need_details(report_no, report_month, report_year);
        LEAVE proc_exit_point;
    END IF;
END$$

CREATE DEFINER=root@localhost PROCEDURE pmed_get_report_unmet_need_details(
    IN report_no VARCHAR(50),
    IN report_month INT,
    IN report_year INT
    )   READS SQL DATA
BEGIN
    IF NOT EXISTS (
         SELECT ru.REPORT_ID
           FROM rpfp.report_unmet_need ru
          WHERE ru.REPORT_YEAR = report_year
    ) THEN
        BEGIN
             SELECT NULL AS report_year,
                    NULL AS report_no,
                    NULL AS psgc_code,
                    NULL AS report_month,
                    NULL AS unmet_modern,
                    NULL AS served_modern,
                    NULL AS no_intention,
                    NULL AS w_intention,
                    NULL AS served_traditional,
                    NULL AS total_unmet,
                    NULL AS total_served,
                    NULL AS date_processed
            ;
        END;
    ELSE
        BEGIN
             SELECT DISTINCT
                    ru.UNMET_ID AS report_no,
                    ru.REPORT_YEAR AS report_year,
                    ru.PSGC_CODE AS psgc_code,
                    ru.REPORT_MONTH AS report_month,
                    ru.UNMET_MODERN_FP AS unmet_modern,
                    ru.SERVED_MODERN_FP AS served_modern,
                    ru.NO_INTENTION AS no_intention,
                    ru.W_INTENTION AS w_intention,
                    ru.SERVED_TRADITIONAL AS served_traditional,
                    ru.TOTAL_UNMET AS total_unmet,
                    ru.TOTAL_SERVED AS total_served,
                    ru.DATE_PROCESSED AS date_processed
               FROM rpfp.report_unmet_need ru
              WHERE ru.REPORT_YEAR = report_year
                AND ru.UNMET_ID = report_no
           ORDER BY ru.REPORT_MONTH ASC
            ;
        END;
    END IF;
END$$

CREATE DEFINER=root@localhost PROCEDURE rdm_get_report_unmet_need_details(
    IN report_no VARCHAR(50),
    IN report_month INT,
    IN report_year INT
    )   READS SQL DATA
BEGIN
    IF NOT EXISTS (
         SELECT ru.REPORT_ID
           FROM rpfp.report_unmet_need ru
          WHERE ru.REPORT_YEAR = report_year
    ) THEN
        BEGIN
             SELECT NULL AS report_year,
                    NULL AS report_no,
                    NULL AS psgc_code,
                    NULL AS report_month,
                    NULL AS unmet_modern,
                    NULL AS served_modern,
                    NULL AS no_intention,
                    NULL AS w_intention,
                    NULL AS served_traditional,
                    NULL AS total_unmet,
                    NULL AS total_served,
                    NULL AS date_processed
            ;
        END;
    ELSE
        BEGIN
             SELECT DISTINCT
                    ru.REPORT_MONTH AS report_month,
                    ru.REPORT_YEAR AS report_year,
                    ru.PSGC_CODE AS psgc_code,
                    ru.UNMET_MODERN_FP AS unmet_modern,
                    ru.SERVED_MODERN_FP AS served_modern,
                    ru.NO_INTENTION AS no_intention,
                    ru.W_INTENTION AS w_intention,
                    ru.SERVED_TRADITIONAL AS served_traditional,
                    ru.TOTAL_UNMET AS total_unmet,
                    ru.TOTAL_SERVED AS total_served,
                    ru.DATE_PROCESSED AS date_processed
               FROM rpfp.report_unmet_need ru
              WHERE ru.REPORT_YEAR = report_year
                AND ru.UNMET_ID = report_no
           ORDER BY ru.REPORT_MONTH ASC
            ;
        END;
    END IF;
END$$

CREATE DEFINER=root@localhost PROCEDURE get_report_served_method_mix_details(
    IN report_no VARCHAR(100),
    IN report_month INT,
    IN report_year INT
    )   READS SQL DATA
proc_exit_point :
BEGIN
    DECLARE read_offset INT;
    DECLARE role_of_user INT;

    SET role_of_user := rpfp.profile_get_own_role();

    IF role_of_user = 90 THEN
        CALL pmed_get_report_served_method_mix_details(report_no, report_month, report_year);
        LEAVE proc_exit_point;
    END IF;

    IF role_of_user <= 80 THEN
        CALL rdm_get_report_served_method_mix_details(report_no, report_month, report_year);
        LEAVE proc_exit_point;
    END IF;
END$$

CREATE DEFINER=root@localhost PROCEDURE pmed_get_report_served_method_mix_details(
    IN report_no VARCHAR(100),
    IN report_month INT,
    IN report_year INT
    )   READS SQL DATA
BEGIN
    DECLARE region_of_user INT;

    SET region_of_user := rpfp.profile_get_own_region();

    IF NOT EXISTS (
         SELECT rs.REPORT_ID
           FROM rpfp.report_served_method_mix rs
          WHERE rs.REPORT_YEAR = report_year
    ) THEN
        BEGIN
             SELECT NULL AS report_year,
                    NULL AS report_no,
                    NULL AS psgc_code,
                    NULL AS report_month,
                    NULL AS served_condom,
                    NULL AS served_iud,
                    NULL AS served_pills,
                    NULL AS served_injectables,
                    NULL AS served_nsv,
                    NULL AS served_btl,
                    NULL AS served_implant,
                    NULL AS served_cmm,
                    NULL AS served_bbt,
                    NULL AS served_symptothermal,
                    NULL AS served_sdm,
                    NULL AS served_lam,
                    NULL AS total_served,
                    NULL AS date_processed
            ;
        END;
    ELSE
        BEGIN
             SELECT DISTINCT
                    rs.SERVED_ID AS report_no,
                    rs.REPORT_YEAR AS report_year,
                    rs.PSGC_CODE AS psgc_code,
                    rs.REPORT_MONTH AS report_month,
                    rs.SERVED_CONDOM AS served_condom,
                    rs.SERVED_IUD AS served_iud,
                    rs.SERVED_PILLS AS served_pills,
                    rs.SERVED_INJECTABLES AS served_injectables,
                    rs.SERVED_NSV AS served_nsv,
                    rs.SERVED_BTL AS served_btl,
                    rs.SERVED_IMPLANT AS served_implant,
                    rs.SERVED_CMM AS served_cmm,
                    rs.SERVED_BBT AS served_bbt,
                    rs.SERVED_SYMPTOTHERMAL AS served_symptothermal,
                    rs.SERVED_SDM AS served_sdm,
                    rs.SERVED_LAM AS served_lam,
                    rs.TOTAL_SERVED AS total_served,
                    rs.DATE_PROCESSED AS date_processed
               FROM rpfp.report_served_method_mix rs
              WHERE rs.REPORT_YEAR = report_year
                AND rs.SERVED_ID = report_no
           ORDER BY rs.REPORT_MONTH ASC
            ;
        END;
    END IF;
END$$

CREATE DEFINER=root@localhost PROCEDURE rdm_get_report_served_method_mix_details(
    IN report_no VARCHAR(100),
    IN report_month INT,
    IN report_year INT
    )   READS SQL DATA
BEGIN
    DECLARE region_of_user INT;

    SET region_of_user := rpfp.profile_get_own_region();

    IF NOT EXISTS (
         SELECT rs.REPORT_ID
           FROM rpfp.report_served_method_mix rs
          WHERE rs.REPORT_YEAR = report_year
    ) THEN
        BEGIN
             SELECT NULL AS report_year,
                    NULL AS report_no,
                    NULL AS psgc_code,
                    NULL AS report_month,
                    NULL AS served_condom,
                    NULL AS served_iud,
                    NULL AS served_pills,
                    NULL AS served_injectables,
                    NULL AS served_nsv,
                    NULL AS served_btl,
                    NULL AS served_implant,
                    NULL AS served_cmm,
                    NULL AS served_bbt,
                    NULL AS served_symptothermal,
                    NULL AS served_sdm,
                    NULL AS served_lam,
                    NULL AS total_served,
                    NULL AS date_processed
            ;
        END;
    ELSE
        BEGIN
             SELECT DISTINCT
                    rs.SERVED_ID AS report_no,
                    rs.REPORT_YEAR AS report_year,
                    rs.PSGC_CODE AS psgc_code,
                    rs.REPORT_MONTH AS report_month,
                    rs.SERVED_CONDOM AS served_condom,
                    rs.SERVED_IUD AS served_iud,
                    rs.SERVED_PILLS AS served_pills,
                    rs.SERVED_INJECTABLES AS served_injectables,
                    rs.SERVED_NSV AS served_nsv,
                    rs.SERVED_BTL AS served_btl,
                    rs.SERVED_IMPLANT AS served_implant,
                    rs.SERVED_CMM AS served_cmm,
                    rs.SERVED_BBT AS served_bbt,
                    rs.SERVED_SYMPTOTHERMAL AS served_symptothermal,
                    rs.SERVED_SDM AS served_sdm,
                    rs.SERVED_LAM AS served_lam,
                    rs.TOTAL_SERVED AS total_served,
                    rs.DATE_PROCESSED AS date_processed
               FROM rpfp.report_served_method_mix rs
              WHERE rs.REPORT_YEAR = report_year
                AND rs.SERVED_ID = report_no
           ORDER BY rs.REPORT_MONTH ASC
            ;
        END;
    END IF;
END$$
/** END GET REPORT DETAILS */

/** GET DASHBOARD DATA */
CREATE DEFINER=root@localhost PROCEDURE process_dashboard_snapshot(
    -- IN psgc_code INT
    )   READS SQL DATA
proc_exit_point :
BEGIN
    DECLARE report_year INT;
    DECLARE report_month INT;
    DECLARE count_id INT;
    DECLARE random_no VARCHAR(400);

    DECLARE couples_encoded_total INT;
    DECLARE couples_encoded_current INT;
    DECLARE couples_encoded_4ps INT;
    DECLARE couples_encoded_non4ps INT;
    DECLARE couples_encoded_fbos INT;
    DECLARE couples_encoded_pmc INT;
    DECLARE couples_encoded_usapan INT;
    DECLARE couples_encoded_others INT;
    DECLARE traditional_withdrawal INT;
    DECLARE traditional_rhythm INT;
    DECLARE traditional_calendar INT;
    DECLARE traditional_abstinence INT;
    DECLARE traditional_herbal INT;
    DECLARE traditional_no_method INT;
    DECLARE couples_with_intention INT;
    DECLARE couples_undecided INT;
    DECLARE couples_pregnant INT;
    DECLARE couples_no_intention INT;

    SET report_year = YEAR(NOW());
    SET report_month = MONTH(NOW());

    SET random_no = CONCAT("RPFP-",report_year,report_month,"-",CEILING(RAND()*10000000000));

    SELECT COUNT(*) INTO count_id FROM report_random_id WHERE RANDOM_ID = random_no;

    IF count_id > 0 THEN
        SELECT "CANNOT PROCESS RECORD WITH GIVEN PARAMETERS" AS MESSAGE;
        LEAVE proc_exit_point;
    END IF
    ;

    SELECT COUNT( apc.COUPLES_ID )
      INTO couples_encoded_total
      FROM rpfp.couples apc
     WHERE apc.IS_ACTIVE = 0
    ;

    SELECT COUNT( apc.COUPLES_ID )
      INTO couples_encoded_current
      FROM rpfp.couples apc 
 LEFT JOIN rpfp.rpfp_class rc ON rc.RPFP_CLASS_ID = apc.RPFP_CLASS_ID
     WHERE YEAR(rc.DATE_CONDUCTED) = YEAR(NOW())
       AND MONTH(rc.DATE_CONDUCTED) <= MONTH(NOW())
       AND apc.IS_ACTIVE = 0
    ;

    SELECT COUNT( apc.COUPLES_ID )
      INTO couples_encoded_4ps
      FROM rpfp.couples apc 
 LEFT JOIN rpfp.rpfp_class rc ON rc.RPFP_CLASS_ID = apc.RPFP_CLASS_ID
     WHERE YEAR(rc.DATE_CONDUCTED) = YEAR(NOW())
       AND MONTH(rc.DATE_CONDUCTED) <= MONTH(NOW())
       AND apc.IS_ACTIVE = 0
       AND rc.TYPE_CLASS_ID = 1
    ;

    SELECT COUNT( apc.COUPLES_ID )
      INTO couples_encoded_non4ps
      FROM rpfp.couples apc 
 LEFT JOIN rpfp.rpfp_class rc ON rc.RPFP_CLASS_ID = apc.RPFP_CLASS_ID
     WHERE YEAR(rc.DATE_CONDUCTED) = YEAR(NOW())
       AND MONTH(rc.DATE_CONDUCTED) <= MONTH(NOW())
       AND apc.IS_ACTIVE = 0
       AND rc.TYPE_CLASS_ID = 2
    ;

    SELECT COUNT( apc.COUPLES_ID )
      INTO couples_encoded_fbos
      FROM rpfp.couples apc 
 LEFT JOIN rpfp.rpfp_class rc ON rc.RPFP_CLASS_ID = apc.RPFP_CLASS_ID
     WHERE YEAR(rc.DATE_CONDUCTED) = YEAR(NOW())
       AND MONTH(rc.DATE_CONDUCTED) <= MONTH(NOW())
       AND apc.IS_ACTIVE = 0
       AND rc.TYPE_CLASS_ID = 3
    ;

    SELECT COUNT( apc.COUPLES_ID )
      INTO couples_encoded_pmc
      FROM rpfp.couples apc 
 LEFT JOIN rpfp.rpfp_class rc ON rc.RPFP_CLASS_ID = apc.RPFP_CLASS_ID
     WHERE YEAR(rc.DATE_CONDUCTED) = YEAR(NOW())
       AND MONTH(rc.DATE_CONDUCTED) <= MONTH(NOW())
       AND apc.IS_ACTIVE = 0
       AND rc.TYPE_CLASS_ID = 4
    ;

    SELECT COUNT( apc.COUPLES_ID )
      INTO couples_encoded_usapan
      FROM rpfp.couples apc 
 LEFT JOIN rpfp.rpfp_class rc ON rc.RPFP_CLASS_ID = apc.RPFP_CLASS_ID
     WHERE YEAR(rc.DATE_CONDUCTED) = YEAR(NOW())
       AND MONTH(rc.DATE_CONDUCTED) <= MONTH(NOW())
       AND apc.IS_ACTIVE = 0
       AND rc.TYPE_CLASS_ID = 5
    ;

    SELECT COUNT( apc.COUPLES_ID )
      INTO couples_encoded_others
      FROM rpfp.couples apc 
 LEFT JOIN rpfp.rpfp_class rc ON rc.RPFP_CLASS_ID = apc.RPFP_CLASS_ID
     WHERE YEAR(rc.DATE_CONDUCTED) = YEAR(NOW())
       AND MONTH(rc.DATE_CONDUCTED) <= MONTH(NOW())
       AND apc.IS_ACTIVE = 0
       AND rc.TYPE_CLASS_ID >= 6
    ;

    SELECT COUNT( apc.COUPLES_ID )
      INTO traditional_withdrawal
      FROM rpfp.couples apc 
 LEFT JOIN rpfp.rpfp_class rc ON rc.RPFP_CLASS_ID = apc.RPFP_CLASS_ID
 LEFT JOIN rpfp.fp_details fd ON fd.COUPLES_ID = apc.COUPLES_ID
     WHERE YEAR(rc.DATE_CONDUCTED) = YEAR(NOW())
       AND MONTH(rc.DATE_CONDUCTED) <= MONTH(NOW())
       AND apc.IS_ACTIVE = 0
       AND fd.TFP_TYPE_ID = 1
    ;

    SELECT COUNT( apc.COUPLES_ID )
      INTO traditional_rhythm
      FROM rpfp.couples apc 
 LEFT JOIN rpfp.rpfp_class rc ON rc.RPFP_CLASS_ID = apc.RPFP_CLASS_ID
 LEFT JOIN rpfp.fp_details fd ON fd.COUPLES_ID = apc.COUPLES_ID
     WHERE YEAR(rc.DATE_CONDUCTED) = YEAR(NOW())
       AND MONTH(rc.DATE_CONDUCTED) <= MONTH(NOW())
       AND apc.IS_ACTIVE = 0
       AND fd.TFP_TYPE_ID = 2
    ;

    SELECT COUNT( apc.COUPLES_ID )
      INTO traditional_calendar
      FROM rpfp.couples apc 
 LEFT JOIN rpfp.rpfp_class rc ON rc.RPFP_CLASS_ID = apc.RPFP_CLASS_ID
 LEFT JOIN rpfp.fp_details fd ON fd.COUPLES_ID = apc.COUPLES_ID
     WHERE YEAR(rc.DATE_CONDUCTED) = YEAR(NOW())
       AND MONTH(rc.DATE_CONDUCTED) <= MONTH(NOW())
       AND apc.IS_ACTIVE = 0
       AND fd.TFP_TYPE_ID = 3
    ;

    SELECT COUNT( apc.COUPLES_ID )
      INTO traditional_abstinence
      FROM rpfp.couples apc 
 LEFT JOIN rpfp.rpfp_class rc ON rc.RPFP_CLASS_ID = apc.RPFP_CLASS_ID
 LEFT JOIN rpfp.fp_details fd ON fd.COUPLES_ID = apc.COUPLES_ID
     WHERE YEAR(rc.DATE_CONDUCTED) = YEAR(NOW())
       AND MONTH(rc.DATE_CONDUCTED) <= MONTH(NOW())
       AND apc.IS_ACTIVE = 0
       AND fd.TFP_TYPE_ID = 4
    ;

    SELECT COUNT( apc.COUPLES_ID )
      INTO traditional_herbal
      FROM rpfp.couples apc 
 LEFT JOIN rpfp.rpfp_class rc ON rc.RPFP_CLASS_ID = apc.RPFP_CLASS_ID
 LEFT JOIN rpfp.fp_details fd ON fd.COUPLES_ID = apc.COUPLES_ID
     WHERE YEAR(rc.DATE_CONDUCTED) = YEAR(NOW())
       AND MONTH(rc.DATE_CONDUCTED) <= MONTH(NOW())
       AND apc.IS_ACTIVE = 0
       AND fd.TFP_TYPE_ID = 5
    ;

    SELECT COUNT( apc.COUPLES_ID )
      INTO traditional_no_method
      FROM rpfp.couples apc 
 LEFT JOIN rpfp.rpfp_class rc ON rc.RPFP_CLASS_ID = apc.RPFP_CLASS_ID
 LEFT JOIN rpfp.fp_details fd ON fd.COUPLES_ID = apc.COUPLES_ID
     WHERE YEAR(rc.DATE_CONDUCTED) = YEAR(NOW())
       AND MONTH(rc.DATE_CONDUCTED) <= MONTH(NOW())
       AND apc.IS_ACTIVE = 0
       AND fd.TFP_TYPE_ID = 6
    ;

    SELECT COUNT( apc.COUPLES_ID )
      INTO couples_with_intention
      FROM rpfp.couples apc 
 LEFT JOIN rpfp.rpfp_class rc ON rc.RPFP_CLASS_ID = apc.RPFP_CLASS_ID
 LEFT JOIN rpfp.fp_details fd ON fd.COUPLES_ID = apc.COUPLES_ID
     WHERE YEAR(rc.DATE_CONDUCTED) = YEAR(NOW())
       AND MONTH(rc.DATE_CONDUCTED) <= MONTH(NOW())
       AND apc.IS_ACTIVE = 0
       AND fd.TFP_STATUS_ID = 1
    ;

    SELECT COUNT( apc.COUPLES_ID )
      INTO couples_undecided
      FROM rpfp.couples apc 
 LEFT JOIN rpfp.rpfp_class rc ON rc.RPFP_CLASS_ID = apc.RPFP_CLASS_ID
 LEFT JOIN rpfp.fp_details fd ON fd.COUPLES_ID = apc.COUPLES_ID
     WHERE YEAR(rc.DATE_CONDUCTED) = YEAR(NOW())
       AND MONTH(rc.DATE_CONDUCTED) <= MONTH(NOW())
       AND apc.IS_ACTIVE = 0
       AND fd.TFP_STATUS_ID = 2
    ;

    SELECT COUNT( apc.COUPLES_ID )
      INTO couples_pregnant
      FROM rpfp.couples apc 
 LEFT JOIN rpfp.rpfp_class rc ON rc.RPFP_CLASS_ID = apc.RPFP_CLASS_ID
 LEFT JOIN rpfp.fp_details fd ON fd.COUPLES_ID = apc.COUPLES_ID
     WHERE YEAR(rc.DATE_CONDUCTED) = YEAR(NOW())
       AND MONTH(rc.DATE_CONDUCTED) <= MONTH(NOW())
       AND apc.IS_ACTIVE = 0
       AND fd.TFP_STATUS_ID = 3
    ;

    SELECT COUNT( apc.COUPLES_ID )
      INTO couples_no_intention
      FROM rpfp.couples apc 
 LEFT JOIN rpfp.rpfp_class rc ON rc.RPFP_CLASS_ID = apc.RPFP_CLASS_ID
 LEFT JOIN rpfp.fp_details fd ON fd.COUPLES_ID = apc.COUPLES_ID
     WHERE YEAR(rc.DATE_CONDUCTED) = YEAR(NOW())
       AND MONTH(rc.DATE_CONDUCTED) <= MONTH(NOW())
       AND apc.IS_ACTIVE = 0
       AND fd.TFP_STATUS_ID = 4
    ;

    
    SELECT couples_encoded_total;
    SELECT couples_encoded_current;
    SELECT couples_encoded_4ps;
    SELECT couples_encoded_non4ps;
    SELECT couples_encoded_fbos;
    SELECT couples_encoded_pmc;
    SELECT couples_encoded_usapan;
    SELECT couples_encoded_others;
    SELECT traditional_withdrawal;
    SELECT traditional_rhythm;
    SELECT traditional_calendar;
    SELECT traditional_abstinence;
    SELECT traditional_herbal;
    SELECT traditional_no_method;
    SELECT couples_with_intention;
    SELECT couples_undecided;
    SELECT couples_pregnant;
    SELECT couples_no_intention;

        INSERT INTO rpfp.dashboard_snapshot (
                    SNAPSHOT_ID,
                    REPORT_YEAR,
                    REPORT_MONTH,
                    PSGC_CODE,
                    COUPLES_ENCODED_TOTAL,
                    COUPLES_ENCODED_CURRENT,
                    COUPLES_ENCODED_4PS,
                    COUPLES_ENCODED_NON4PS,
                    COUPLES_ENCODED_FBOS,
                    COUPLES_ENCODED_PMC,
                    COUPLES_ENCODED_USAPAN,
                    COUPLES_ENCODED_OTHERS,
                    TRADITIONAL_WITHDRAWAL,
                    TRADITIONAL_RHYTHM,
                    TRADITIONAL_CALENDAR,
                    TRADITIONAL_ABSTINENCE,
                    TRADITIONAL_HERBAL,
                    TRADITIONAL_NO_METHOD,
                    COUPLES_WITH_INTENTION,
                    COUPLES_UNDECIDED,
                    COUPLES_PREGNANT,
                    COUPLES_NO_INTENTION,
                    DATE_PROCESSED
            )
        VALUES (
                random_no,
                report_year,
                report_month,
                psgc_code,
                couples_encoded_total,
                couples_encoded_current,
                couples_encoded_4ps,
                couples_encoded_non4ps,
                couples_encoded_fbos,
                couples_encoded_pmc,
                couples_encoded_usapan,
                couples_encoded_others,
                traditional_withdrawal,
                traditional_rhythm,
                traditional_calendar,
                traditional_abstinence,
                traditional_herbal,
                traditional_no_method,
                couples_with_intention,
                couples_undecided,
                couples_pregnant,
                couples_no_intention,
                CURRENT_DATE()
            )
            ;
    
        SELECT CONCAT( "NEW ENTRY: ", LAST_INSERT_ID() ) AS MESSAGE;
        LEAVE proc_exit_point;

    SELECT "SUCCESS!" AS MESSAGE;
END$$

CREATE DEFINER=root@localhost PROCEDURE process_dashboard_percentage_encoded(
    IN report_year INT
    )   READS SQL DATA
proc_exit_point :
BEGIN
    DECLARE count_id INT;
    DECLARE random_no VARCHAR(400);
    DECLARE report_month INT;
    DECLARE region_count INT;
    DECLARE couples_encoded INT;
    DECLARE region_target INT;
    DECLARE region_reached INT;
    DECLARE encoded_target INT;
    DECLARE encoded_reached INT;
    DECLARE target_reached INT;
    
    IF ( IFNULL( report_year, 0 ) = 0 ) THEN
        SET report_year = YEAR(NOW());
        SET report_month = MONTH(NOW());
    ELSE
        SET report_month = 12;
    END IF
    ;

    SET random_no = CONCAT("RPFP-",report_year,report_month,"-",CEILING(RAND()*10000000000));

    SELECT COUNT(*) INTO count_id FROM report_random_id WHERE RANDOM_ID = random_no;

    IF count_id > 0 THEN
        SELECT "CANNOT PROCESS RECORD WITH GIVEN PARAMETERS" AS MESSAGE;
        LEAVE proc_exit_point;
    END IF
    ;

    SET region_count = 0;

    percent_encoded: LOOP
        IF region_count = 17 THEN
            LEAVE percent_encoded;
        END IF
        ;
    
    SET region_count = region_count + 1;
    SET couples_encoded = "";
    SET region_target = "";
    SET region_reached = "";
    SET encoded_target = "";
    SET encoded_reached = "";
    SET target_reached = "";

    SELECT COUNT( apc.COUPLES_ID )
      INTO couples_encoded
      FROM rpfp.couples apc
 LEFT JOIN rpfp.rpfp_class rc ON rc.RPFP_CLASS_ID = apc.RPFP_CLASS_ID
 LEFT JOIN rpfp.lib_psgc_locations lp ON lp.PSGC_CODE = rc.BARANGAY_ID
     WHERE YEAR(rc.DATE_CONDUCTED) = report_year
       AND MONTH(rc.DATE_CONDUCTED) <= report_month
       AND apc.IS_ACTIVE = 0
       AND lp.REGION_CODE = region_count
    ;

    SELECT tc.TARGET_YEAR, SUM( tc.TARGET_COUNT ) 
      INTO report_year, region_target
      FROM rpfp.target_couples tc 
     WHERE tc.TARGET_YEAR = report_year
       AND tc.TARGET_MONTH <= report_month
       AND tc.PSGC_CODE = region_count
  GROUP BY tc.TARGET_YEAR
    ;

    SELECT rc.REACHED_YEAR, SUM( rc.REACHED_COUNT ) 
      INTO report_year, region_reached
      FROM rpfp.reached_couples rc 
     WHERE rc.REACHED_YEAR = report_year
       AND rc.REACHED_MONTH <= report_month
       AND rc.PSGC_CODE = region_count
  GROUP BY rc.REACHED_YEAR
    ;

    SET encoded_target = (couples_encoded/region_target)*100;
    SET encoded_reached = (couples_encoded/region_reached)*100;
    SET target_reached = (region_reached/region_target)*100;

    -- SET encoded_target = couples_encoded;
    -- SET encoded_reached = region_reached;
    -- SET target_reached = region_target;
       
        INSERT INTO rpfp.dashboard_percentage_encoded (
                    PERCENT_ENCODED_ID,
                    REPORT_YEAR,
                    REPORT_MONTH,
                    PSGC_CODE,
                    ENCODED_TARGET,
                    ENCODED_REACHED,
                    TARGET_REACHED,
                    DATE_PROCESSED
            )
        VALUES (
                random_no,
                report_year,
                report_month,
                region_count,
                encoded_target,
                encoded_reached,
                target_reached,
                CURRENT_DATE()
            )
            ;

        END LOOP;

        SELECT CONCAT( "NEW ENTRY: ", LAST_INSERT_ID() ) AS MESSAGE;
        LEAVE proc_exit_point;

    SELECT "SUCCESS!" AS MESSAGE;
END$$

CREATE DEFINER=root@localhost PROCEDURE get_dashboard_snapshot_details(
    )   READS SQL DATA
BEGIN
    IF NOT EXISTS (
         SELECT ds.REPORT_ID
           FROM rpfp.dashboard_snapshot ds
    ) THEN
        BEGIN
             SELECT NULL AS report_year,
                    NULL AS report_month,
                    NULL AS psgc_code,
                    NULL AS couples_encoded_total,
                    NULL AS couples_encoded_current,
                    NULL AS couples_encoded_4ps,
                    NULL AS couples_encoded_non4ps,
                    NULL AS couples_encoded_fbos,
                    NULL AS couples_encoded_pmc,
                    NULL AS couples_encoded_usapan,
                    NULL AS couples_encoded_others,
                    NULL AS traditional_withdrawal,
                    NULL AS traditional_rhythm,
                    NULL AS traditional_calendar,
                    NULL AS traditional_abstinence,
                    NULL AS traditional_herbal,
                    NULL AS traditional_no_method,
                    NULL AS couples_with_intention,
                    NULL AS couples_undecided,
                    NULL AS couples_pregnant,
                    NULL AS couples_no_intention,
                    NULL AS date_processed
            ;
        END;
    ELSE
        BEGIN
             SELECT ds.REPORT_YEAR AS report_year,
                    ds.PSGC_CODE AS psgc_code,
                    ds.REPORT_MONTH AS report_month,
                    ds.COUPLES_ENCODED_TOTAL AS couples_encoded_total,
                    ds.COUPLES_ENCODED_CURRENT AS couples_encoded_current,
                    ds.COUPLES_ENCODED_4PS AS couples_encoded_4ps,
                    ds.COUPLES_ENCODED_NON4PS AS couples_encoded_non4ps,
                    ds.COUPLES_ENCODED_FBOS AS couples_encoded_fbos,
                    ds.COUPLES_ENCODED_PMC AS couples_encoded_pmc,
                    ds.COUPLES_ENCODED_USAPAN AS couples_encoded_usapan,
                    ds.COUPLES_ENCODED_OTHERS AS couples_encoded_others,
                    ds.TRADITIONAL_WITHDRAWAL AS traditional_withdrawal,
                    ds.TRADITIONAL_RHYTHM AS traditional_rhythm,
                    ds.TRADITIONAL_CALENDAR AS traditional_calendar,
                    ds.TRADITIONAL_ABSTINENCE AS traditional_abstinence,
                    ds.TRADITIONAL_HERBAL AS traditional_herbal,
                    ds.TRADITIONAL_NO_METHOD AS traditional_no_method,
                    ds.COUPLES_WITH_INTENTION AS couples_with_intention,
                    ds.COUPLES_UNDECIDED AS couples_undecided,
                    ds.COUPLES_PREGNANT AS couples_pregnant,
                    ds.COUPLES_NO_INTENTION AS couples_no_intention,
                    ds.DATE_PROCESSED AS date_processed
               FROM rpfp.dashboard_snapshot ds
           ORDER BY ds.report_id DESC
           LIMIT 1
            ;
        END;
    END IF;
END$$

CREATE DEFINER=root@localhost PROCEDURE get_dashboard_percentage_encoded_details(
    IN report_year INT
    )   READS SQL DATA
BEGIN
    IF ( IFNULL( report_year, 0 ) = 0 ) THEN
        SET report_year = YEAR(NOW());
    END IF
    ;

    IF NOT EXISTS (
         SELECT gpe.PERCENT_ENCODED_ID
           FROM rpfp.dashboard_percentage_encoded gpe
    ) THEN
        BEGIN
             SELECT NULL AS graph_id,
                    NULL AS report_year,
                    NULL AS encoded_target,
                    NULL AS date_processed
            ;
        END;
    ELSE
        BEGIN
             SELECT 
                    gpe.PERCENT_ENCODED_ID AS graph_id,
                    gpe.REPORT_YEAR AS report_year,
                    GROUP_CONCAT(
                        gpe.ENCODED_TARGET SEPARATOR ','
                    ) encoded_target,
                    GROUP_CONCAT(
                        gpe.ENCODED_REACHED SEPARATOR ','
                    ) encoded_reached,
                    GROUP_CONCAT(
                        gpe.TARGET_REACHED SEPARATOR ','
                    ) target_reached,
                    gpe.DATE_PROCESSED AS date_processed
               FROM rpfp.dashboard_percentage_encoded gpe
              WHERE gpe.REPORT_YEAR = report_year
           GROUP BY gpe.PERCENT_ENCODED_ID
           ORDER BY gpe.DATE_PROCESSED DESC
           LIMIT 1
            ;
        END;
    END IF;
END$$
/** END GET DASHBOARD DATA */

DELIMITER ;
--
-- END OF STORED ROUTINES
--


/** PROFILE TABLES */
--
-- Table structure for table user_profile
--

CREATE TABLE user_profile (
          PROFILE_ID INT UNSIGNED NOT NULL AUTO_INCREMENT,
          DB_USER_ID VARCHAR(50) NOT NULL,
              E_MAIL VARCHAR(100),
           LAST_NAME VARCHAR(50) NOT NULL,
          FIRST_NAME VARCHAR(50) NOT NULL,
         PROFILE_PIC VARCHAR(50),
         REGION_CODE INT UNSIGNED,
           PSGC_CODE INT UNSIGNED,
 INITIAL_PASS_COLUMN INT(1) UNSIGNED NOT NULL DEFAULT TRUE,
           IS_ACTIVE INT(1) NOT NULL DEFAULT TRUE,
         PRIMARY KEY (PROFILE_ID)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------
/** END OF PROFILE TABLES */

/** LIBRARY TABLES */
--
-- Table structure for table lib_psgc_locations - LIBRARIES
--

CREATE TABLE lib_psgc_locations (
            LOCATION_ID INT UNSIGNED NOT NULL AUTO_INCREMENT,
            REGION_CODE INT UNSIGNED NOT NULL,
          PROVINCE_CODE INT UNSIGNED NOT NULL,
      MUNICIPALITY_CODE INT UNSIGNED NOT NULL,
              PSGC_CODE INT UNSIGNED NOT NULL,
            INTER_LEVEL VARCHAR(10),
   LOCATION_DESCRIPTION VARCHAR(100),
            PRIMARY KEY (LOCATION_ID)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table type_class - LIBRARIES
--

CREATE TABLE lib_type_class (
          TYPE_CLASS_ID INT UNSIGNED NOT NULL AUTO_INCREMENT,
        TYPE_CLASS_DESC VARCHAR(50) NOT NULL,
            PRIMARY KEY (TYPE_CLASS_ID)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Table structure for table lib_civil_status
--

CREATE TABLE lib_civil_status (
               CIVIL_ID INT UNSIGNED NOT NULL AUTO_INCREMENT,
             CIVIL_DESC VARCHAR(100),
            PRIMARY KEY (CIVIL_ID)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Table structure for table lib_educ_bckgrnd
--

CREATE TABLE lib_educ_bckgrnd (
        EDUC_BCKGRND_ID INT UNSIGNED NOT NULL AUTO_INCREMENT,
      EDUC_BCKGRND_DESC VARCHAR(100),
            PRIMARY KEY (EDUC_BCKGRND_ID)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;


--
-- Table structure for table lib_modern_fp_method
--

CREATE TABLE lib_modern_fp_method (
           MODERN_FP_ID INT UNSIGNED NOT NULL AUTO_INCREMENT,
         MODERN_FP_DESC VARCHAR(100),
            PRIMARY KEY (MODERN_FP_ID)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;


--
-- Table structure for table lib_traditional_fp_method
--

CREATE TABLE lib_traditional_fp_method (
      TRADITIONAL_FP_ID INT UNSIGNED NOT NULL AUTO_INCREMENT,
    TRADITIONAL_FP_DESC VARCHAR(100),
            PRIMARY KEY (TRADITIONAL_FP_ID)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;


--
-- Table structure for table lib_traditional_fp_status
--

CREATE TABLE lib_traditional_fp_status (
          TFP_STATUS_ID INT UNSIGNED NOT NULL AUTO_INCREMENT,
        TFP_STATUS_DESC VARCHAR(100),
            PRIMARY KEY (TFP_STATUS_ID)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;


--
-- Table structure for table lib_reason_intending_use
--

CREATE TABLE lib_reason_intending_use (
  REASON_INTENDING_USE_ID INT UNSIGNED NOT NULL AUTO_INCREMENT,
REASON_INTENDING_USE_DESC VARCHAR(100),
              PRIMARY KEY ( rEASON_INTENDING_USE_ID)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;


--
-- Table structure for table lib_provider_type
--

CREATE TABLE lib_provider_type (
         PROVIDER_TYPE_ID INT UNSIGNED NOT NULL AUTO_INCREMENT,
       PROVIDER_TYPE_DESC VARCHAR(100),
              PRIMARY KEY (PROVIDER_TYPE_ID)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------
/** END OF LIBRARY TABLES */


--
-- Table structure for table rpfp_class
--

CREATE TABLE rpfp_class (
          RPFP_CLASS_ID INT UNSIGNED NOT NULL AUTO_INCREMENT,
          TYPE_CLASS_ID INT NOT NULL,
         OTHERS_SPECIFY VARCHAR(100),
            BARANGAY_ID INT NOT NULL,
           CLASS_NUMBER VARCHAR(50) NOT NULL,
         DATE_CONDUCTED DATE NOT NULL,
             DB_USER_ID VARCHAR(50),
            PRIMARY KEY (RPFP_CLASS_ID)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Table structure for table rpfp_footer
--

CREATE TABLE rpfp_footer (
         RPFP_FOOTER_ID INT UNSIGNED NOT NULL AUTO_INCREMENT,
          RPFP_CLASS_ID INT NOT NULL,
            PREPARED_BY VARCHAR(100),
            REVIEWED_BY VARCHAR(100),
            APPROVED_BY VARCHAR(100),
            PRIMARY KEY (RPFP_FOOTER_ID)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Table structure for table couples
--

CREATE TABLE couples (
             COUPLES_ID INT UNSIGNED NOT NULL AUTO_INCREMENT,
          RPFP_CLASS_ID INT NOT NULL,
           DATE_ENCODED DATE,
          DATE_MODIFIED DATE,
          ADDRESS_NO_ST VARCHAR(50),
           ADDRESS_BRGY VARCHAR(50),
           ADDRESS_CITY VARCHAR(50),
               HH_ID_NO VARCHAR(50),
            NO_CHILDREN INT,
              IS_ACTIVE INT(1),
            PRIMARY KEY (COUPLES_ID)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table track_approved
--

CREATE TABLE track_approved (
               TRACK_ID INT UNSIGNED NOT NULL AUTO_INCREMENT,
             COUPLES_ID INT NOT NULL,
          DATE_APPROVED DATE,
            PRIMARY KEY (TRACK_ID)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table couples_verified
--

CREATE TABLE couples_verified (
            VERIFIED_ID INT UNSIGNED NOT NULL AUTO_INCREMENT,
             COUPLES_ID INT NOT NULL,
          DATE_VERIFIED DATE,
            PRIMARY KEY (VERIFIED_ID)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table individual
--

CREATE TABLE individual (
                  INDV_ID INT UNSIGNED NOT NULL AUTO_INCREMENT,
               COUPLES_ID INT NOT NULL,
                    LNAME VARCHAR(50),
                    FNAME VARCHAR(50),
                    MNAME VARCHAR(10),
                 EXT_NAME VARCHAR(10),
                      AGE INT,
                      SEX INT(1),
                    BDATE DATE,
                 CIVIL_ID INT,
          EDUC_BCKGRND_ID INT,
                 ETNICITY VARCHAR(50),
              IS_ATTENDEE INT(1),
              PRIMARY KEY (INDV_ID)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;


--
-- Table structure for table fp_details
--

CREATE TABLE fp_details (
          FP_DETAILS_ID INT UNSIGNED NOT NULL AUTO_INCREMENT,
             COUPLES_ID INT NOT NULL,
     MFP_METHOD_USED_ID INT,
 MFP_INTENTION_SHIFT_ID INT,
            TFP_TYPE_ID INT,
          TFP_STATUS_ID VARCHAR(1),
   MFP_INTENTION_USE_ID INT,
REASON_INTENDING_USE_ID INT,
            PRIMARY KEY (FP_DETAILS_ID)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;


--
-- Table structure for table fp_service
--

CREATE TABLE fp_service (
          FP_SERVICE_ID INT UNSIGNED NOT NULL AUTO_INCREMENT,
             COUPLES_ID INT NOT NULL,
             DATE_VISIT DATE,
           FP_SERVED_ID INT,
       PROVIDER_TYPE_ID INT,
          IS_COUNSELING INT,
          OTHER_CONCERN INT,
	   COUNSELED_TO_USE INT,
  OTHER_REASONS_SPECIFY VARCHAR(100),
    IS_PROVIDED_SERVICE INT,
            DATE_SERVED DATE,
          CLIENT_ADVISE VARCHAR(100),
          REFERRAL_NAME VARCHAR(100),
          PROVIDER_NAME VARCHAR(100),
           DATE_ENCODED DATE,
            PRIMARY KEY (FP_SERVICE_ID)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table report_demandgen
--

CREATE TABLE report_demandgen (
              REPORT_ID INT UNSIGNED NOT NULL AUTO_INCREMENT,
           DEMANDGEN_ID VARCHAR(100) NOT NULL,
            REPORT_YEAR INT NOT NULL,
              PSGC_CODE INT NOT NULL,
            REPORT_CODE VARCHAR(50),
           REPORT_MONTH INT NOT NULL,
              CLASS_4PS INT,
           CLASS_NON4PS INT,
           CLASS_USAPAN INT,
	          CLASS_PMC INT,
              CLASS_H2H INT,
         CLASS_PROFILED INT,
            CLASS_TOTAL INT,
         TARGET_COUPLES INT,
                WRA_4PS INT,
             WRA_NON4PS INT,
             WRA_USAPAN INT,
	            WRA_PMC INT,
                WRA_H2H INT,
           WRA_PROFILED INT,
              WRA_TOTAL INT,
	          SOLO_MALE INT,
            SOLO_FEMALE INT,
        COUPLE_ATTENDEE INT,
          REACHED_TOTAL INT,
              IS_ACTIVE INT,
         DATE_PROCESSED DATE,
            PRIMARY KEY (REPORT_ID)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table report_unmet_need
--

CREATE TABLE report_unmet_need (
              REPORT_ID INT UNSIGNED NOT NULL AUTO_INCREMENT,
               UNMET_ID VARCHAR(100) NOT NULL,
            REPORT_YEAR INT NOT NULL,
              PSGC_CODE INT NOT NULL,
            REPORT_CODE VARCHAR(50),
           REPORT_MONTH INT NOT NULL,
        UNMET_MODERN_FP INT,
       SERVED_MODERN_FP INT,
           NO_INTENTION INT,
	        W_INTENTION INT,
     SERVED_TRADITIONAL INT,
            TOTAL_UNMET INT,
           TOTAL_SERVED INT,
              IS_ACTIVE INT,
         DATE_PROCESSED DATE,
            PRIMARY KEY (REPORT_ID)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table report_served_method_mix
--

CREATE TABLE report_served_method_mix (
              REPORT_ID INT UNSIGNED NOT NULL AUTO_INCREMENT,
              SERVED_ID VARCHAR(100),
            REPORT_YEAR INT NOT NULL,
              PSGC_CODE INT NOT NULL,
            REPORT_CODE VARCHAR(50),
           REPORT_MONTH INT NOT NULL,
          SERVED_CONDOM INT,
             SERVED_IUD INT,
           SERVED_PILLS INT,
	 SERVED_INJECTABLES INT,
             SERVED_NSV INT,
             SERVED_BTL INT,
         SERVED_IMPLANT INT,
             SERVED_CMM INT,
             SERVED_BBT INT,
   SERVED_SYMPTOTHERMAL INT,
             SERVED_SDM INT,
             SERVED_LAM INT,
           TOTAL_SERVED INT,
              IS_ACTIVE INT,
         DATE_PROCESSED DATE,
            PRIMARY KEY (REPORT_ID)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table report_couples_encoded
--

CREATE TABLE report_couples_encoded (
              REPORT_ID INT UNSIGNED NOT NULL AUTO_INCREMENT,
               ACCOM_ID VARCHAR(400),
              DATE_FROM DATE NOT NULL,
                DATE_TO DATE NOT NULL,
              PSGC_CODE INT NOT NULL,
          RPFP_CLASS_NO VARCHAR(100),
        ENCODED_COUPLES INT,
       APPROVED_COUPLES INT,
        PENDING_COUPLES INT,
         SERVED_COUPLES INT,
             DUPLICATES INT,
               INVALIDS INT,
             DB_USER_ID VARCHAR(50),
              IS_ACTIVE INT,
         DATE_PROCESSED DATE,
            PRIMARY KEY (REPORT_ID)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table report_duplicate_encoded
--

CREATE TABLE report_duplicate_encoded (
              REPORT_ID INT UNSIGNED NOT NULL AUTO_INCREMENT,
               ACCOM_ID VARCHAR(400),
              DATE_FROM DATE NOT NULL,
                DATE_TO DATE NOT NULL,
              PSGC_CODE INT NOT NULL,
          RPFP_CLASS_NO VARCHAR(100),
             DUPLICATES INT,
                  FNAME VARCHAR(50),
                  LNAME VARCHAR(50),
               EXT_NAME VARCHAR(50),
                  BDATE DATE,
             DB_USER_ID VARCHAR(50),
              IS_ACTIVE INT,
         DATE_PROCESSED DATE,
            PRIMARY KEY (REPORT_ID)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table dashboard_snapshot
--

CREATE TABLE dashboard_snapshot (
              REPORT_ID INT UNSIGNED NOT NULL AUTO_INCREMENT,
            SNAPSHOT_ID VARCHAR(400),
            REPORT_YEAR INT NOT NULL,
           REPORT_MONTH INT NOT NULL,
              PSGC_CODE INT NOT NULL,
  COUPLES_ENCODED_TOTAL INT,
COUPLES_ENCODED_CURRENT INT,
    COUPLES_ENCODED_4PS INT,
 COUPLES_ENCODED_NON4PS INT,
   COUPLES_ENCODED_FBOS INT,
    COUPLES_ENCODED_PMC INT,
 COUPLES_ENCODED_USAPAN INT,
 COUPLES_ENCODED_OTHERS INT,
 TRADITIONAL_WITHDRAWAL INT,
     TRADITIONAL_RHYTHM INT,
   TRADITIONAL_CALENDAR INT,
 TRADITIONAL_ABSTINENCE INT,
     TRADITIONAL_HERBAL INT,
  TRADITIONAL_NO_METHOD INT,
 COUPLES_WITH_INTENTION INT,
      COUPLES_UNDECIDED INT,
       COUPLES_PREGNANT INT,
   COUPLES_NO_INTENTION INT,
           USERS_CONDOM INT,
              USERS_IUD INT,
            USERS_PILLS INT,
       USERS_INJECTABLE INT,
        USERS_VASECTOMY INT,
         USERS_LIGATION INT,
          USERS_IMPLANT INT,
     USERS_CMM_BILLINGS INT,
              USERS_BBT INT,
    USERS_SYMPTOTHERMAL INT,
              USERS_SDM INT,
              USERS_LAM INT,
         DATE_PROCESSED DATE,
            PRIMARY KEY (REPORT_ID)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table percentage_encoded
--

CREATE TABLE dashboard_percentage_encoded (
              REPORT_ID INT UNSIGNED NOT NULL AUTO_INCREMENT,
     PERCENT_ENCODED_ID VARCHAR(400),
            REPORT_YEAR INT NOT NULL,
           REPORT_MONTH INT NOT NULL,
              PSGC_CODE INT NOT NULL,
         ENCODED_TARGET INT,
        ENCODED_REACHED INT,
         TARGET_REACHED INT,
         DATE_PROCESSED DATE,
            PRIMARY KEY (REPORT_ID)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table couples_reached
--

CREATE TABLE dashboard_couples_reached (
              REPORT_ID INT UNSIGNED NOT NULL AUTO_INCREMENT,
             REACHED_ID VARCHAR(400),
            REPORT_YEAR INT NOT NULL,
           REPORT_MONTH INT NOT NULL,
              PSGC_CODE INT NOT NULL,
        COUPLES_REACHED INT,
      MALE_ONLY_REACHED INT,
    FEMALE_ONLY_REACHED INT,
         DATE_PROCESSED DATE,
            PRIMARY KEY (REPORT_ID)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table method_mix
--

CREATE TABLE dashboard_method_mix (
              REPORT_ID INT UNSIGNED NOT NULL AUTO_INCREMENT,
          METHOD_MIX_ID VARCHAR(400),
            REPORT_YEAR INT NOT NULL,
           REPORT_MONTH INT NOT NULL,
                 CONDOM INT,
                  PILLS INT,
             INJECTABLE INT,
              VASECTOMY INT,
               LIGATION INT,
                IMPLANT INT,
           CMM_BILLINGS INT,
                    BTT INT,
         SYMPTO_THERMAL INT,
                    SDM INT,
                    LAM INT,
            TRADITIONAL INT,
              NO_METHOD INT,
         DATE_PROCESSED DATE,
            PRIMARY KEY (REPORT_ID)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table wra_age_group
--

CREATE TABLE dashboard_wra_age_group (
              REPORT_ID INT UNSIGNED NOT NULL AUTO_INCREMENT,
       WRA_AGE_GROUP_ID VARCHAR(400),
            REPORT_YEAR INT NOT NULL,
           REPORT_MONTH INT NOT NULL,
         FIFTEEN_TWENTY INT,
   TWENTYONE_TWENTYFIVE INT,
       TWENTYSIX_THIRTY INT,
   THIRTYONE_THIRTYFIVE INT,
       THIRTYSIX_FOURTY INT,
   FOURTYONE_FOURTYFIVE INT,
        FOURTYSIX_FIFTY INT,
     FIFTYONE_FIFTYFIVE INT,
         FIFTYSIX_SIXTY INT,
         SIXTYONE_ABOVE INT,
         DATE_PROCESSED DATE,
            PRIMARY KEY (REPORT_ID)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table unmet_need_vs_served
--

CREATE TABLE dashboard_unmet_need_vs_served (
              REPORT_ID INT UNSIGNED NOT NULL AUTO_INCREMENT,
UNMET_NEED_VS_SERVED_ID VARCHAR(400),
            REPORT_YEAR INT NOT NULL,
           REPORT_MONTH INT NOT NULL,
              PSGC_CODE INT NOT NULL,
             UNMET_NEED INT,
                 SERVED INT,
         DATE_PROCESSED DATE,
            PRIMARY KEY (REPORT_ID)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table report_random_id
--

CREATE TABLE report_random_id (
              REPORT_ID INT UNSIGNED NOT NULL AUTO_INCREMENT,
              RANDOM_ID VARCHAR(400),
             DB_USER_ID VARCHAR(50),
         DATE_PROCESSED DATE,
            PRIMARY KEY (REPORT_ID)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table target_couples
--

CREATE TABLE target_couples (
              TARGET_ID INT UNSIGNED NOT NULL AUTO_INCREMENT,
            TARGET_YEAR INT NOT NULL,
           TARGET_MONTH INT NOT NULL,
              PSGC_CODE INT NOT NULL,
           TARGET_COUNT INT,
            PRIMARY KEY (TARGET_ID)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table reached_couples
--

CREATE TABLE reached_couples (
             REACHED_ID INT UNSIGNED NOT NULL AUTO_INCREMENT,
           REACHED_YEAR INT NOT NULL,
          REACHED_MONTH INT NOT NULL,
              PSGC_CODE INT NOT NULL,
          REACHED_COUNT INT,
            PRIMARY KEY (REACHED_ID)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

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
 GRANT EXECUTE ON FUNCTION rpfp.login_check_if_active TO 'rpfp_login';

 GRANT EXECUTE ON FUNCTION rpfp.profile_check_if_encoder TO 'rpfp_login';
 GRANT EXECUTE ON FUNCTION rpfp.profile_check_if_focal TO 'rpfp_login';
 GRANT EXECUTE ON FUNCTION rpfp.profile_check_if_data_manager TO 'rpfp_login';
 GRANT EXECUTE ON FUNCTION rpfp.profile_check_if_pmed TO 'rpfp_login';
 GRANT EXECUTE ON FUNCTION rpfp.profile_check_if_itdmu TO 'rpfp_login';
GRANT EXECUTE ON PROCEDURE rpfp.profile_get_own_profile TO 'rpfp_login';
GRANT EXECUTE ON PROCEDURE rpfp.profile_save_own_profile TO 'rpfp_login';
GRANT EXECUTE ON PROCEDURE rpfp.profile_get_own_pic TO 'rpfp_login';
GRANT EXECUTE ON PROCEDURE rpfp.profile_save_own_pic_filename TO 'rpfp_login';

GRANT EXECUTE ON PROCEDURE rpfp.lib_list_regions TO 'rpfp_login';
GRANT EXECUTE ON PROCEDURE rpfp.lib_list_provinces TO 'rpfp_login';
GRANT EXECUTE ON PROCEDURE rpfp.lib_list_cities TO 'rpfp_login';
GRANT EXECUTE ON PROCEDURE rpfp.lib_list_brgy TO 'rpfp_login';
GRANT EXECUTE ON PROCEDURE rpfp.lib_list_regional_cities TO 'rpfp_login';

GRANT EXECUTE ON PROCEDURE rpfp.itdmu_create_rpfp_user TO 'itdmu';
GRANT EXECUTE ON PROCEDURE rpfp.itdmu_update_first_login TO 'itdmu';
GRANT EXECUTE ON PROCEDURE rpfp.itdmu_change_user_password TO 'itdmu';
GRANT EXECUTE ON PROCEDURE rpfp.profile_get_profile TO 'itdmu';
GRANT EXECUTE ON PROCEDURE rpfp.profile_set_role TO 'itdmu';
GRANT EXECUTE ON PROCEDURE rpfp.profile_set_scope TO 'itdmu';
GRANT EXECUTE ON PROCEDURE rpfp.profile_save_profile TO 'itdmu';
GRANT EXECUTE ON PROCEDURE rpfp.profile_get_pic TO 'itdmu';
GRANT EXECUTE ON PROCEDURE rpfp.profile_save_pic_filename TO 'itdmu';
GRANT EXECUTE ON PROCEDURE rpfp.get_dashboard_percentage_encoded_details TO 'itdmu';

GRANT EXECUTE ON PROCEDURE rpfp.encoder_get_couple_fp_details TO 'encoder';
GRANT EXECUTE ON PROCEDURE rpfp.encoder_get_class_list_pending TO 'encoder';
GRANT EXECUTE ON PROCEDURE rpfp.encoder_get_class_list_approved TO 'encoder';
GRANT EXECUTE ON PROCEDURE rpfp.encoder_get_couples_list TO 'encoder';
GRANT EXECUTE ON PROCEDURE rpfp.encoder_get_couples_details TO 'encoder';
GRANT EXECUTE ON PROCEDURE rpfp.encoder_check_couples_details TO 'encoder';
GRANT EXECUTE ON PROCEDURE rpfp.encoder_get_fp_service TO 'encoder';
GRANT EXECUTE ON PROCEDURE rpfp.encoder_save_class TO 'encoder';
GRANT EXECUTE ON PROCEDURE rpfp.encoder_save_fp_details TO 'encoder';
GRANT EXECUTE ON PROCEDURE rpfp.encoder_save_fp_service TO 'encoder';
GRANT EXECUTE ON PROCEDURE rpfp.encoder_save_couple TO 'encoder';
GRANT EXECUTE ON PROCEDURE rpfp.encoder_save_individual TO 'encoder';
GRANT EXECUTE ON PROCEDURE rpfp.get_report_accomplishment_list TO 'encoder';
GRANT EXECUTE ON PROCEDURE rpfp.get_class_details TO 'encoder';
GRANT EXECUTE ON PROCEDURE rpfp.get_forms_list TO 'encoder';
GRANT EXECUTE ON PROCEDURE rpfp.get_report_accomplishment_details TO 'encoder';
GRANT EXECUTE ON PROCEDURE rpfp.encoder_get_couples_with_fp_details TO 'encoder';
GRANT EXECUTE ON PROCEDURE rpfp.process_accomplishment TO 'encoder';
GRANT EXECUTE ON PROCEDURE rpfp.check_couples_details TO 'encoder';
GRANT EXECUTE ON PROCEDURE rpfp.encoder_get_duplicate_details TO 'encoder';
GRANT EXECUTE ON PROCEDURE rpfp.lib_get_full_location TO 'encoder';
GRANT EXECUTE ON PROCEDURE rpfp.search_pending_data TO 'encoder';
GRANT EXECUTE ON PROCEDURE rpfp.search_data TO 'encoder';
GRANT EXECUTE ON PROCEDURE rpfp.check_for_duplications TO 'encoder';
GRANT EXECUTE ON PROCEDURE rpfp.delete_report_accomplishment TO 'encoder';

GRANT EXECUTE ON PROCEDURE rpfp.rdm_approve_couples TO 'regional_data_manager';
GRANT EXECUTE ON PROCEDURE rpfp.rdm_save_target TO 'regional_data_manager';
GRANT EXECUTE ON PROCEDURE rpfp.encoder_get_couple_fp_details TO 'regional_data_manager';
GRANT EXECUTE ON PROCEDURE rpfp.encoder_get_class_list_pending TO 'regional_data_manager';
GRANT EXECUTE ON PROCEDURE rpfp.encoder_get_class_list_approved TO 'regional_data_manager';
GRANT EXECUTE ON PROCEDURE rpfp.encoder_get_couples_list TO 'regional_data_manager';
GRANT EXECUTE ON PROCEDURE rpfp.encoder_get_couples_details TO 'regional_data_manager';
GRANT EXECUTE ON PROCEDURE rpfp.encoder_check_couples_details TO 'regional_data_manager';
GRANT EXECUTE ON PROCEDURE rpfp.encoder_get_fp_service TO 'regional_data_manager';
GRANT EXECUTE ON PROCEDURE rpfp.get_report_demandgen_list TO 'regional_data_manager';
GRANT EXECUTE ON PROCEDURE rpfp.get_report_unmet_need_list TO 'regional_data_manager';
GRANT EXECUTE ON PROCEDURE rpfp.get_report_served_method_mix_list TO 'regional_data_manager';
GRANT EXECUTE ON PROCEDURE rpfp.get_report_demandgen_details TO 'regional_data_manager';
GRANT EXECUTE ON PROCEDURE rpfp.get_report_unmet_need_details TO 'regional_data_manager';
GRANT EXECUTE ON PROCEDURE rpfp.get_report_served_method_mix_details TO 'regional_data_manager';
GRANT EXECUTE ON PROCEDURE rpfp.process_demandgen TO 'regional_data_manager';
GRANT EXECUTE ON PROCEDURE rpfp.process_unmet_need TO 'regional_data_manager';
GRANT EXECUTE ON PROCEDURE rpfp.process_served_method_mix TO 'regional_data_manager';
GRANT EXECUTE ON PROCEDURE rpfp.get_forms_list to 'regional_data_manager';
GRANT EXECUTE ON PROCEDURE rpfp.get_class_details to 'regional_data_manager';
GRANT EXECUTE ON PROCEDURE rpfp.encoder_get_couples_with_fp_details to 'regional_data_manager';
GRANT EXECUTE ON PROCEDURE rpfp.search_data TO 'regional_data_manager';
GRANT EXECUTE ON PROCEDURE rpfp.delete_report_demandgen TO 'regional_data_manager';
GRANT EXECUTE ON PROCEDURE rpfp.delete_report_served_method_mix TO 'regional_data_manager';
GRANT EXECUTE ON PROCEDURE rpfp.delete_report_unmet_need TO 'regional_data_manager';
GRANT EXECUTE ON PROCEDURE rpfp.search_pending_data TO 'regional_data_manager';

GRANT EXECUTE ON PROCEDURE rpfp.encoder_get_class_list_pending TO 'focal_person';
GRANT EXECUTE ON PROCEDURE rpfp.encoder_get_class_list_approved to 'focal_person';
GRANT EXECUTE ON PROCEDURE rpfp.get_report_demandgen_list to 'focal_person';
GRANT EXECUTE ON PROCEDURE rpfp.get_report_unmet_need_list to 'focal_person';
GRANT EXECUTE ON PROCEDURE rpfp.get_report_served_method_mix_list to 'focal_person';
GRANT EXECUTE ON PROCEDURE rpfp.get_forms_list to 'focal_person';
GRANT EXECUTE ON PROCEDURE rpfp.get_class_details to 'focal_person';
GRANT EXECUTE ON PROCEDURE rpfp.encoder_get_couples_with_fp_details to 'focal_person';
GRANT EXECUTE ON PROCEDURE rpfp.focal_verify_couples to 'focal_person';
GRANT EXECUTE ON PROCEDURE rpfp.get_report_demandgen_details TO 'focal_person';
GRANT EXECUTE ON PROCEDURE rpfp.get_report_unmet_need_details TO 'focal_person';
GRANT EXECUTE ON PROCEDURE rpfp.get_report_served_method_mix_details TO 'focal_person';

GRANT EXECUTE ON PROCEDURE rpfp.process_demandgen TO 'pmed';
GRANT EXECUTE ON PROCEDURE rpfp.process_unmet_need TO 'pmed';
GRANT EXECUTE ON PROCEDURE rpfp.process_served_method_mix TO 'pmed';
GRANT EXECUTE ON PROCEDURE rpfp.get_report_demandgen_list TO 'pmed';
GRANT EXECUTE ON PROCEDURE rpfp.get_report_unmet_need_list TO 'pmed';
GRANT EXECUTE ON PROCEDURE rpfp.get_report_served_method_mix_list TO 'pmed';
GRANT EXECUTE ON PROCEDURE rpfp.get_report_demandgen_details TO 'pmed';
GRANT EXECUTE ON PROCEDURE rpfp.get_report_unmet_need_details TO 'pmed';
GRANT EXECUTE ON PROCEDURE rpfp.get_report_served_method_mix_details TO 'pmed';



COMMIT;

-- --------------------------------------------------------
/**                */
/** DEFAULT VALUES */
/**                */

/** PSGC LOCATIONS  */
SOURCE ./psgc.sql;

/** TABLE CONSTANTS */
SOURCE ./libraries.sql;

/** TEST VALUES */
/** REMOVE THE FOLLOWING LINE IN PRODUCTION */
 SOURCE ./test.sql;

-- --------------------------------------------------------

/** END OF RPFP.SQL */
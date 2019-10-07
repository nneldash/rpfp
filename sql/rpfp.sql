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

    SET @sql_stmt1 := CONCAT( "REVOKE ALL PRIVILEGES, GRANT OPTION FROM ", db_user_name );
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
      WHERE prof.DB_USER_ID = USER()
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
        RETURN rpfp.profile_num_role( role_word );
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
        RETURN rpfp.profile_num_scope( scope_word );
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

    SET default_role := rpfp.profile_select_role( role_num );

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

    SET scope_role := rpfp.profile_select_scope( scope_reg_prov_or_muni );
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
     WHERE rm.ROLE = rpfp.profile_select_role( role_num )
       AND rm.USER = name_user
     LIMIT 1  
    ;
    
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

     SELECT prof.PROFILE_ID AS ID,
            prof.DB_USER_ID AS USERNAME,
            prof.E_MAIL AS EMAIL,
            prof.LAST_NAME AS SURNAME,
            prof.FIRST_NAME AS FIRSTNAME,
            prof.REGION_CODE AS REGION_ID,
            reg.LOCATION_DESCRIPTION AS REGION_NAME,
            prof.PSGC_CODE AS LOCATION_CODE,
            loc.LOCATION_DESCRIPTION AS LOCATION_NAME,
            rpfp.profile_get_role( db_user_name ) AS MY_ROLE,
            rpfp.profile_get_scope( db_user_name ) AS MY_SCOPE
       FROM rpfp.user_profile prof
  LEFT JOIN rpfp.lib_psgc_locations loc
         ON prof.PSGC_CODE = loc.PSGC_CODE
  LEFT JOIN rpfp.lib_psgc_locations reg
         ON reg.PSGC_CODE = (prof.REGION * POWER( 10, 7 ))
      WHERE prof.DB_USER_ID = name_user
        AND prof.REGION_CODE = loc.REGION_CODE
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

CREATE DEFINER=root@localhost FUNCTION profile_check_if_allowed_location(
    username VARCHAR(50),
    location_id INT UNSIGNED,
    location_level INT UNSIGNED
    )   RETURNS INT(1)
        READS SQL DATA
BEGIN
    RETURN profile_get_region( USER() );
END$$

/** END OF PROFILE PROCS */


/** LIBRARIES */
CREATE DEFINER=root@localhost PROCEDURE lib_get_full_location(
    IN  LOCATION_ID INT,
    OUT LOCATION_NAME VARCHAR(100),
    OUT MUNICIPALITY_ID INT,
    OUT MUNICIPALITY_NAME VARCHAR(100),
    OUT PROVINCE_ID INT,
    OUT PROVINCE_NAME VARCHAR(100),
    OUT REGION_ID INT,
    OUT REGION_NAME VARCHAR(100)
    )   READS SQL DATA
BEGIN
     SELECT reg.REGION_CODE,
            reg.LOCATION_DESCRIPTION,
            prov.PROVINCE_CODE,
            prov.LOCATION_DESCRIPTION,
            city.MUNICIPALITY_CODE,
            city.LOCATION_DESCRIPTION,
            brgy.LOCATION_DESCRIPTION
       INTO REGION_ID,
            REGION_NAME,
            PROVINCE_ID,
            PROVINCE_NAME,
            MUNICIPALITY_ID,
            MUNICIPALITY_NAME,
            LOCATION_NAME
       FROM rpfp.lib_psgc_locations reg
  LEFT JOIN rpfp.lib_psgc_locations brgy
         ON reg.PSGC_CODE = (brgy.REGION_CODE * POWER( 10, 7 ))
  LEFT JOIN rpfp.lib_psgc_locations prov
         ON prov.PSGC_CODE = (brgy.PROVINCE_CODE * POWER( 10, 5 ))
  LEFT JOIN rpfp.lib_psgc_locations city
         ON city.PSGC_CODE = (brgy.MUNICIPALITY_CODE * POWER( 10, 3 ))
      WHERE brgy.LOCATION_CODE = LOCATION_ID
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
     SELECT reg.REGION_CODE AS REGION_ID,
            reg.PSGC_CODE AS LOCATION_CODE,
            reg.LOCATION_DESCRIPTION AS LOCATION_NAME
       FROM rpfp.lib_psgc_locations reg
      WHERE reg.INTER_LEVEL = 'REG'
   ORDER BY reg.LOCATION_ID
    ;
END$$

CREATE DEFINER=root@localhost PROCEDURE lib_list_provinces(
    IN region_id INT UNSIGNED
    )    READS SQL DATA
BEGIN
     SELECT reg.REGION_CODE AS REGION_ID,
            reg.LOCATION_DESCRIPTION AS REGION_NAME,
            prov.PROVINCE_CODE AS LOCATION_CODE,
            prov.LOCATION_DESCRIPTION AS LOCATION_NAME
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
     SELECT reg.REGION_CODE AS REGION_ID,
            reg.LOCATION_DESCRIPTION AS REGION_NAME,
            prov.PROVINCE_CODE AS PROVINCE_ID,
            prov.LOCATION_DESCRIPTION AS PROVINCE_NAME,
            city.MUNICIPALITY_CODE AS LOCATION_CODE,
            city.LOCATION_DESCRIPTION AS LOCATION_NAME
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

CREATE DEFINER=root@localhost PROCEDURE lib_list_brgy(
    IN municipality_id INT UNSIGNED
    )    READS SQL DATA
BEGIN
     SELECT reg.REGION_CODE AS REGION_ID,
            reg.LOCATION_DESCRIPTION AS REGION_NAME,
            prov.PROVINCE_CODE AS PROVINCE_ID,
            prov.LOCATION_DESCRIPTION AS PROVINCE_NAME,
            city.MUNICIPALITY_CODE AS MUNICIPALITY_ID,
            city.LOCATION_DESCRIPTION AS MUNICIPALITY_NAME,
            brgy.PSGC_CODE AS LOCATION_CODE,
            brgy.LOCATION_DESCRIPTION AS LOCATION_NAME
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

CREATE DEFINER=root@localhost FUNCTION profile_select_role(
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

CREATE DEFINER=root@localhost FUNCTION profile_select_scope(
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

CREATE DEFINER=root@localhost FUNCTION profile_num_scope(
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

CREATE DEFINER=root@localhost FUNCTION profile_num_role(
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
/** END OF LIBRARIES */



/** CLASSES */
CREATE DEFINER=root@localhost PROCEDURE get_class_list(
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
      LEFT JOIN rpfp.pending_couples pc
             ON pc.RPFP_CLASS_ID = rc.RPFP_CLASS_ID
          WHERE pc.IS_ACTIVE = status_active
            AND rc.DB_USER_ID = name_user
    ) THEN
         SELECT NULL AS RPFPCLASS,
                NULL AS TYPECLASS,
                NULL AS OTHERS_SPECIFY,
                NULL AS CITY,
                NULL AS BARANGAY,
                NULL AS CLASS_NO,
                NULL AS DATE_CONDUCT
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
         SELECT rc.RPFP_CLASS_ID AS RPFPCLASS,
                rc.TYPE_CLASS_ID AS TYPECLASS,
                rc.OTHERS_SPECIFY AS OTHERS_SPECIFY,
                rc.CITY_ID AS CITY,
                rc.BARANGAY_ID AS BARANGAY,
                rc.CLASS_NUMBER AS CLASS_NO,
                rc.DATE_CONDUCTED AS DATE_CONDUCT
           FROM rpfp.rpfp_class rc
      LEFT JOIN rpfp.pending_couples pc
             ON pc.RPFP_CLASS_ID = rc.RPFP_CLASS_ID
          WHERE pc.IS_ACTIVE = status_active
            AND rc.DB_USER_ID = name_user
       GROUP BY rc.CLASS_NUMBER
       ORDER BY rc.DATE_CONDUCTED DESC
          LIMIT read_offset, items_per_page
        ;
    END IF;
END$$


CREATE DEFINER=root@localhost PROCEDURE encoder_get_class_list_pending (
    IN page_no INT,
    IN items_per_page INT
    )   READS SQL DATA
BEGIN
    DECLARE status_pending INT DEFAULT 2;
    CALL rpfp.get_class_list(
            status_pending,
            USER(),
            page_no,
            items_per_page
    );

END$$

CREATE DEFINER=root@localhost PROCEDURE encoder_get_class_list_approved (
    IN page_no INT,
    IN items_per_page INT
    )   READS SQL DATA
BEGIN
    DECLARE active_status INT DEFAULT 0;
    CALL rpfp.get_class_list(
            active_status,
            USER(),
            page_no,
            items_per_page
    );

END$$


CREATE DEFINER=root@localhost PROCEDURE encoder_get_couples_list(
    IN class_num VARCHAR(50)
    )   READS SQL DATA
BEGIN
    DECLARE name_user VARCHAR(50);
    DECLARE db_user_name VARCHAR(50);

    CALL rpfp.lib_extract_user_name( USER(), name_user, db_user_name );

    IF NOT EXISTS (
         SELECT pc.RPFP_CLASS_ID
           FROM rpfp.pending_couples pc
      LEFT JOIN rpfp.RPFP_CLASS rc
             ON rc.RPFP_CLASS_ID = pc.RPFP_CLASS_ID
          WHERE rc.DB_USER_ID = name_user
            AND rc.CLASS_NUMBER = class_num
    ) THEN
        BEGIN
             SELECT NULL AS CLASS_NO,
                    NULL AS COUPLESID,
                    NULL AS ISACTIVE,
                    NULL AS DATE_ENCODE,
                    NULL AS LASTNAME,
                    NULL AS FIRSTNAME,
                    NULL AS MIDDLE,
                    NULL AS EXT_NAME
            ;
        END;
    ELSE
        BEGIN
             SELECT rc.CLASS_NUMBER AS CLASS_NO,
                    pc.COUPLES_ID AS COUPLESID,
                    pc.IS_ACTIVE AS ISACTIVE,
                    pc.DATE_ENCODED AS DATE_ENCODE,
                    ic.LNAME AS LASTNAME,
                    ic.FNAME AS FIRSTNAME,
                    ic.MNAME AS MIDDLE,
                    ic.EXT_NAME AS EXT_NAME
               FROM rpfp.pending_couples pc
          LEFT JOIN rpfp.rpfp_class rc
                 ON rc.RPFP_CLASS_ID = pc.RPFP_CLASS_ID
          LEFT JOIN rpfp.individual ic
                 ON ic.COUPLES_ID = pc.COUPLES_ID
              WHERE rc.CLASS_NUMBER = class_num
                AND DB_USER_ID = name_user
           ORDER BY pc.COUPLES_ID ASC
            ;
        END;
    END IF;
END$$


CREATE DEFINER=root@localhost PROCEDURE encoder_get_couples_details(
    IN class_num VARCHAR(50)
    )   READS SQL DATA
BEGIN
    DECLARE name_user VARCHAR(50);
    DECLARE db_user_name VARCHAR(50);

    CALL rpfp.lib_extract_user_name( USER(), name_user, db_user_name );

    IF NOT EXISTS (
         SELECT pc.COUPLES_ID
           FROM rpfp.pending_couples pc
      LEFT JOIN rpfp.rpfp_class rc
             ON rc.RPFP_CLASS_ID = pc.RPFP_CLASS_ID
          WHERE rc.CLASS_NUMBER = class_num
            AND rc.DB_USER_ID = name_user
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
             SELECT ic.INDV_ID AS INDVID,
                    pc.COUPLES_ID AS COUPLESID,
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
               FROM rpfp.rpfp_class rc
          LEFT JOIN rpfp.pending_couples pc
                 ON rc.RPFP_CLASS_ID = pc.RPFP_CLASS_ID
          LEFT JOIN rpfp.individual ic
                 ON ic.COUPLES_ID = pc.COUPLES_ID
              WHERE rc.CLASS_NUMBER = class_num
                AND rc.DB_USER_ID = name_user
           ORDER BY ic.INDV_ID ASC
            ;
        END;
    END IF;
END$$


CREATE DEFINER=root@localhost PROCEDURE encoder_save_class(
    IN classid INT UNSIGNED,
    IN TYPE_CLASS INT,
    IN OTHERS_SPEC VARCHAR(100),
    IN BARANGAYID INT,
    IN CLASS_NO VARCHAR(50),
    IN DATECONDUCTED DATE
    )  MODIFIES SQL DATA
proc_exit_point :
BEGIN
    DECLARE rpfp_class_no INT UNSIGNED;
    DECLARE user_region_id INT UNSIGNED;
    DECLARE name_user VARCHAR(50);
    DECLARE db_user_name VARCHAR(50);

    SET user_region_id := profile_get_own_region();
    IF user_region_id != lib_get_region_from_location( BARANGAYID ) THEN
        SELECT "INVALID LOCATION" AS MESSAGE;
        LEAVE proc_exit_point;
    END IF;

    CALL rpfp.lib_extract_user_name( USER(), name_user, db_user_name );

    IF ( IFNULL( TYPE_CLASS, '' ) = '' )  THEN
        INSERT INTO rpfp.rpfp_class
            (
                TYPE_CLASS_ID,
                OTHERS_SPECIFY,
                CITY_ID,
                BARANGAY_ID,
                CLASS_NUMBER,
                DATE_CONDUCTED,
                DB_USER_ID
            )
             VALUES (
                 TYPE_CLASS,
                 OTHERS_SPEC,
                 CITYID,
                 BARANGAYID,
                 CLASS_NO,
                 DATECONDUCTED,
                 USER()
             )
        ;

        SELECT CONCAT( "NEW ENTRY: ", LAST_INSERT_ID() ) AS MESSAGE;
        LEAVE proc_exit_point;
    END IF;

     UPDATE rpfp.rpfp_class rc
        SET rc.TYPE_CLASS_ID = IF( IFNULL( TYPE_CLASS, '' ) = '', rc.TYPE_CLASS_ID, TYPE_CLASS ),
            rc.OTHERS_SPECIFY = IF( IFNULL( OTHERS_SPEC, '' ) = '', rc.OTHERS_SPECIFY, OTHERS_SPEC ),
            rc.CITY_ID =  IF( IFNULL( CITYID, '' ) = '', rc.CITY_ID, CITYID ),
            rc.BARANGAY_ID =  IF( IFNULL( BARANGAYID, '' ) = '', rc.BARANGAY_ID, BARANGAYID ),
            rc.CLASS_NUMBER =  IF( IFNULL( CLASS_NO, '' ) = '', rc.CLASS_NUMBE, CLASS_NO ),
            rc.DATE_CONDUCTED =  IF( IFNULL( DATECONDUCTED, '' ) = '', rc.DATE_CONDUCTED, DATECONDUCTED )
      WHERE rc.RPFP_CLASS_ID = classid
        AND rc.DB_USER_ID = name_user
    ;

    SELECT "SAVE SUCCESSFUL" AS MESSAGE;
END$$
/** END OF CLASSES */

/** COUPLES DETAILS */
CREATE DEFINER=root@localhost PROCEDURE encoder_get_couple_fp_details (IN couplesid INT UNSIGNED)  READS SQL DATA
BEGIN
    DECLARE name_user VARCHAR(50);
    DECLARE db_user_name VARCHAR(50);

    CALL rpfp.lib_extract_user_name( USER(), name_user, db_user_name );

    IF NOT EXISTS (
         SELECT pc.COUPLES_ID
           FROM rpfp.pending_couples pc
      LEFT JOIN rpfp.fp_details fd
             ON fd.COUPLES_ID = pc.COUPLES_ID
          WHERE IFNULL( fd.COUPLES_ID, 0) = couplesid
            AND pc.DB_USER_ID = name_user
    ) THEN
        BEGIN
             SELECT NULL AS FPDETAILSID,
                    NULL AS COUPLESID,
                    NULL AS MFP_USED,
                    NULL AS MFP_SHIFT,
                    NULL AS TFP_TYPE,
                    NULL AS TFP_STATUS,
                    NULL AS REASON_USE
            ;
        END;
    ELSE
        BEGIN
             SELECT fd.FP_DETAILS_ID AS FPDETAILSID,
                    pc.COUPLES_ID AS COUPLESID,
                    fd.MFP_METHOD_USED_ID AS MFP_USED,
                    fd.MFP_INTENTION_SHIFT_ID AS MFP_SHIFT,
                    fd.TFP_TYPE_ID AS TFP_TYPE,
                    fd.TFP_STATUS_ID as TFP_STATUS,
                    fd.REASON_INTENDING_USE_ID AS REASON_USE
               FROM rpfp.fp_details fd
          LEFT JOIN rpfp.pending_couples pc
                 ON fd.RPFP_CLASS_ID = pc.RPFP_CLASS_ID
              WHERE IFNULL( fd.COUPLES_ID, 0) = couplesid
                AND pc.DB_USER_ID = name_user
           ORDER BY fd.FP_DETAILS_ID ASC
            ;
        END;
    END IF;
END$$

CREATE DEFINER=root@localhost PROCEDURE encoder_get_fp_service (IN couplesid INT UNSIGNED)  READS SQL DATA
BEGIN
    DECLARE name_user VARCHAR(50);
    DECLARE db_user_name VARCHAR(50);

    CALL rpfp.lib_extract_user_name( USER(), name_user, db_user_name );

    IF NOT EXISTS (
         SELECT pc.COUPLES_ID
           FROM rpfp.pending_couples pc
      LEFT JOIN rpfp.FP_SERVICE fs
             ON fs.COUPLES_ID = pc.COUPLES_ID
          WHERE IFNULL( fs.COUPLES_ID, 0) = couplesid
            AND pc.DB_USER_ID = name_user
    ) THEN
        BEGIN
             SELECT NULL AS FPSERVICEID,
                    NULL AS COUPLESID,
                    NULL AS DATEVISIT,
                    NULL AS FP_SERVED,
                    NULL AS PROVIDER_TYPE,
                    NULL AS IS_COUNSELLING,
                    NULL AS OTHER_CONCERN,
                    NULL AS COUNSELED_FP,
                    NULL AS OTHER_SPECIFY,
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
             SELECT fs.FP_SERVICE_ID AS FPSERVICEID,
                    pc.COUPLES_ID AS COUPLESID,
                    fs.DATE_VISIT AS DATEVISIT,
                    fs.FP_SERVED_ID AS FP_SERVED,
                    fs.PROVIDER_TYPE_ID AS PROVIDER_TYPE,
                    fs.IS_COUNSELLING AS IS_COUNSELLING,
                    fs.OTHER_CONCERN AS OTHER_CONCERN,
                    fs.COUNSELED_TO_USE AS COUNSELED_FP,
                    fs.OTHER_REASONS_SPECIFY AS OTHER_SPECIFY,
                    fs.IS_PROVIDED_SERVICE AS IS_PROVIDED_SERVICE,
                    fs.DATE_SERVED AS DATESERVED,
                    fs.CLIENT_ADVISE AS CLIENT_ADVISE,
                    fs.REFERRAL_NAME AS REFERRALNAME,
                    fs.PROVIDER_NAME AS PROVIDERNAME,
                    fs.DATE_ENCODED AS DATE_ENCODE
               FROM rpfp.fp_service fs
          LEFT JOIN rpfp.pending_couples pc
                 ON fs.RPFP_CLASS_ID = pc.RPFP_CLASS_ID
              WHERE IFNULL( fs.COUPLES_ID, 0 ) = couplesid
                AND pc.DB_USER_ID = name_user                    
           ORDER BY fs.FP_SERVICE_ID ASC
            ;
        END;
    END IF;
END$$

CREATE DEFINER=root@localhost PROCEDURE encoder_save_couples (
    IN rpfp_classid INT UNSIGNED,
    IN couplesid INT UNSIGNED,
    
    IN lastname_m VARCHAR(100),
    IN firstname_m VARCHAR(100),
    IN middle_m VARCHAR(100),
    IN extname_m VARCHAR(100),
    IN age_years_m INT,
    IN birthdate_m DATE,
    IN civil_status_m INT,
    IN educ_bckgrnd_m INT,

    IN lastname_f VARCHAR(100),
    IN firstname_f VARCHAR(100),
    IN middle_f VARCHAR(100),
    IN age_years_f INT,
    IN birthdate_f DATE,
    IN civil_status_f INT,
    IN educ_bckgrnd_f INT,
    
    IN address_st_no VARCHAR(50),
    IN address_barangay VARCHAR(50),
    IN address_municipality VARCHAR(50),
    IN household_no VARCHAR(50),
    IN number_child INT
    )  MODIFIES SQL DATA
proc_exit_point :
BEGIN
    IF IFNULL( rpfp_classid, '' ) = '' THEN
        SELECT "CANNOT SAVE RECORD WITH GIVEN PARAMETERS" AS MESSAGE;
        LEAVE proc_exit_point;
    END IF;

    IF IFNULL( couplesid, '' ) = '' IS NULL THEN
        /**
            INSERT FOR NEW DATA
            
        */

        LEAVE proc_exit_point;
    ELSE
             UPDATE rpfp.couples apc
                SET apc.ADDRESS_NO_ST = IF( IFNULL( address_st_no, '') = '', apc.ADDRESS_NO_ST, address_st_no ),
                    apc.ADDRESS_BRGY = IF( IFNULL( address_barangay, '') = '', apc.ADDRESS_BRGY, address_barangay ),
                    apc.ADDRESS_CITY = IF( IFNULL( address_municipality, '') = '', apc.ADDRESS_CITY, address_municipality ),
                    apc.HH_ID_NO = IF( IFNULL( household_no, '') = '', apc.HH_ID_NO, household_no ),
                    apc.NO_CHILDREN = IF( IFNULL( number_child, '') = '', apc.NO_CHILDREN, number_child )
      WHERE apc.couples_id = couplesid
    ;


    END IF;

    /** CHANGE TO COUPLES  */
     UPDATE rpfp.pending_couples pc
        SET pc.DATE_ENCODED = CURRENT_DATE(),
            pc.IS_ACTIVE = 2
      WHERE pc.COUPLES_ID = couples_id
        AND pc.RPFP_CLASS_ID = rpfp_classid
    ;


    /** 
        SEARCH INDIVIDUALS FOR COUPLES ID
        IF NOT EXISTS, INSERT THE INDIVIDUALS
        ELSE UPDATE THE INDIVIDUALS
    */
     UPDATE rpfp.individual ic
        SET ic.LNAME = IF( IFNULL( lastname_m, '') = '', ic.LNAME, lastname ),
            ic.FNAME = IF( IFNULL( firstname_m, '') = '', ic.FNAME, firstname ),
            ic.MNAME = IF( IFNULL( middle_m, '') = '', ic.MNAME, middle ),
            ic.EXT_NAME = IF( IFNULL( extname_m, '') = '', ic.EXT_NAME, extname ),
            ic.AGE = IF( IFNULL( age_years_m, '') = '', ic.AGE, age_years ),
            ic.BDATE = IF( IFNULL( birthdate_m, '') = '', ic.BDATE, birthdate ),
            ic.CIVIL_ID = IF( IFNULL( civil_status_m, '') = '', ic.CIVIL_ID, civil_status ),
            ic.EDUC_BCKGRND_ID = IF( IFNULL( educ_bckgrnd, '') = '', ic.EDUC_BCKGRND_ID, educ_bckgrnd ),
            ic.ETNICITY = IF( IFNULL( etnic, '') = '', ic.ETNICITY, etnic ),
            ic.IS_ATTENDEE = IF( IFNULL( ATTENDEE, '') = '', ic.IS_ATTENDEE, ATTENDEE )
      WHERE ic.COUPLES_ID = couplesid
        AND ic.SEX = 1
    ;

     UPDATE rpfp.fp_details fd
        SET fd.MFP_METHOD_USED_ID = IF( IFNULL( MFP_USED, '') = '', fd.MFP_METHOD_USED_ID, MFP_USED ),
            fd.MFP_INTENTION_SHIFT_ID = IF( IFNULL( MFP_SHIFT, '') = '', fd.MFP_INTENTION_SHIFT_ID, MFP_SHIFT ),
            fd.TFP_TYPE_ID = IF( IFNULL( TFP_TYPE, '') = '', fd.TFP_TYPE_ID, TFP_TYPE ),                            
            fd.TFP_STATUS_ID = IF( IFNULL( TFP_STATUS, '') = '', fd.TFP_STATUS_ID, TFP_STATUS ),
            fd.REASON_INTENDING_USE_ID = IF( IFNULL( rEASON_USE, '') = '', fd.REASON_INTENDING_USE_ID, REASON_USE)
      WHERE fd.COUPLES_ID = couples_id
    ;

    SELECT "SUCCESS!" AS MESSAGE;
END$$

CREATE DEFINER=root@localhost PROCEDURE encoder_save_fp_service (
    IN fp_service_id INT UNSIGNED,
    IN couplesid INT,
    IN date_visit DATE,
    IN fp_served_id INT,
    IN provider_type_id INT,
    IN is_counselling INT,
    IN other_concern VARCHAR(100),
    IN counseled_fp VARCHAR(100),
    IN other_specify VARCHAR(100),
    IN is_provided_service INT,
    IN date_served DATE,
    IN client_advise VARCHAR(100),
    IN referral_name VARCHAR(50),
    IN provider_name VARCHAR(50),
    IN date_encoded DATE
    )  MODIFIES SQL DATA
proc_exit_point :
BEGIN
    DECLARE fp_service_id INT UNSIGNED;

    IF IFNULL( couplesid, '') = '' THEN
        SELECT "UNABLE TO GET RECORD WITH GIVEN PARAMETERS" AS MESSAGE;
        LEAVE proc_exit_point;
    END IF;

    IF NOT EXISTS (
         SELECT fs.fp_service_id
           FROM fp_service fs
          WHERE fs.COUPLES_ID = couplesid
    ) THEN
        SELECT "UNABLE TO RETRIEVE COUPLES WITH GIVEN PARAMETERS" AS MESSAGE;
        LEAVE proc_exit_point;
    END IF;


     UPDATE rpfp.fp_service fs
        SET fs.DATE_VISIT = IF( IFNULL( DATEVISIT, '') = '', fs.DATE_VISIT, DATEVISIT ),
            fs.FP_SERVED_ID = IF( IFNULL( FP_SERVED, '') = '', fs.FP_SERVED_ID, FP_SERVED ),
            fs.PROVIDER_TYPE_ID = IF( IFNULL( PROVIDER_TYPE, '') = '', fs.PROVIDER_TYPE_ID, PROVIDER_TYPE ),
            fs.IS_COUNSELLING = IF( IFNULL( IS_COUNSELING, '') = '', fs.IS_COUNSELLING, IS_COUNSELING ),
            fs.OTHER_CONCERN = IF( IFNULL( OTHERS, '') = '', fs.OTHER_CONCERN, OTHERS ),
            fs.COUNSELED_TO_USE = IF( IFNULL( COUNSELED_FP, '') = '', fs.COUNSELED_TO_USE, COUNSELED_FP ),
            fs.OTHER_REASONS_SPECIFY = IF( IFNULL( OTHER_SPECIFY, '') = '', fs.OTHER_REASONS_SPECIFY, OTHERS_SPECIFY ),
            fs.IS_PROVIDED_SERVICE = IF( IFNULL( IS_PROVIDED_SERVICE, '') = '', fs.IS_PROVIDED_SERVICE, IS_PROVIDED_SERVICE ),
            fs.DATE_SERVED = IF( IFNULL( DATESERVED, '') = '', fs.DATE_SERVED, DATESERVED ),
            fs.CLIENT_ADVISE = IF( IFNULL( CLIENT_ADVISE, '') = '', fs.CLIENT_ADVISE, CLIENT_ADVISE ),
            fs.REFERRAL_NAME = IF( IFNULL( rEFERRALNAME, '') = '', fs.REFERRAL_NAME, REFERRALNAME ),
            fs.PROVIDER_NAME = IF( IFNULL( PROVIDERNAME, '') = '', fs.PROVIDER_NAME, PROVIDERNAME ),
            fs.DATE_ENCODED = IF( IFNULL( DATE_ENCODE, '') = '', fs.DATE_ENCODED, DATE_ENCODE)
      WHERE fs.COUPLES_ID = couples_id
    ;

     UPDATE rpfp.fp_details fd
        SET fd.CURRENT_FP_METHOD_ID = IF( IFNULL( CURRENT_FP, '') = '', fd.CURRENT_FP_METHOD_ID, CURRENT_FP)
      WHERE fd.COUPLES_ID = couples_id
    ;

    SELECT "SUCCESS!" AS MESSAGE;
END$$
/** END COUPLES DETAILS */

/**  APPROVE COUPLES DETAILS  */
CREATE DEFINER=root@localhost PROCEDURE rdm_approve_couples (
    IN couples_id INT UNSIGNED,
    IN RPFP_CLASS_ID INT,
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
        SET ac.RPFP_CLASS_ID = IF( IFNULL( RPFP_CLASS, '') = '', ac.RPFP_CLASS_ID, RPFP_CLASS ),
            ac.IS_ACTIVE = 2,
            ac.DATE_ENCODED = IF( IFNULL( DATE_ENCODE, '') = '', ac.DATE_ENCODED, DATE_ENCODE)
      WHERE ac.COUPLES_ID = couples_id
    ;

    SELECT "SUCCESS!" AS MESSAGE;
END$$
/** END APPROVE COUPLES DETAILS */

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
          TFP_STATUS_ID INT(1) UNSIGNED NOT NULL AUTO_INCREMENT,
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
            REGION_CODE INT NOT NULL,
              PSGC_CODE INT NOT NULL,
           CLASS_NUMBER VARCHAR(50) NOT NULL,
         DATE_CONDUCTED DATE NOT NULL,
             DB_USER_ID INT NOT NULL,
            PRIMARY KEY (RPFP_CLASS_ID)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Table structure for table couples
--

CREATE TABLE couples (
             COUPLES_ID INT UNSIGNED NOT NULL AUTO_INCREMENT,
          RPFP_CLASS_ID INT NOT NULL,
       TYPE_PARTICIPANT VARCHAR(100),
           DATE_ENCODED DATE,
          ADDRESS_NO_ST VARCHAR(50),
           ADDRESS_BRGY VARCHAR(50),
           ADDRESS_CITY VARCHAR(50),
               HH_ID_NO VARCHAR(50),
            NO_CHILDREN INT,
              IS_ACTIVE INT(1),
             DB_USER_ID VARCHAR(50) NOT NULL,
            PRIMARY KEY (COUPLES_ID)
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
                 ATTENDEE INT(1),
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
          TFP_STATUS_ID INT,
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
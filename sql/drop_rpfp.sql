/** FOR DEVELOPMENT OF DATABASE CODES
    USED FOR CREATING A NEW DATABASE FOR RPFP
    BY DELETING THE OLD ONE

    mysql -u root test < drop_rpfp.sql
    mysql -u root test < rpfp.sql
*/

DROP DATABASE IF EXISTS rpfp;

DROP ROLE IF EXISTS no_scope;
DROP ROLE IF EXISTS rpfp_login;
DROP ROLE IF EXISTS itdmu;
DROP ROLE IF EXISTS pmed;
DROP ROLE IF EXISTS regional_data_manager;
DROP ROLE IF EXISTS focal_person;
DROP ROLE IF EXISTS partners;
DROP ROLE IF EXISTS encoder;
DROP ROLE IF EXISTS citiwide;
DROP ROLE IF EXISTS provincial;
DROP ROLE IF EXISTS regional;
DROP ROLE IF EXISTS national;

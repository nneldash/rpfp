/** FOR DEVELOPMENT OF DATABASE CODES
    USED FOR CREATING A NEW DATABASE FOR RPFP
    BY DELETING THE OLD ONE

    mysql -u root test < drop_rpfp.sql
    mysql -u root test < rpfp.sql
*/

drop database rpfp;

drop role no_scope;
drop role rpfp_login;
drop role itdmu;
drop role pmed;
drop role regional_data_manager;
drop role focal_person;
drop role encoder;
drop role citiwide;
drop role provincial;
drop role regional;
drop role national;

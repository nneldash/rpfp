SELECT "Loading Test values" AS MESSAGE;

CALL rpfp.itdmu_create_rpfp_user('test', 'test', 'rojo', 'rowell', 'x@com.com', 08, 80000000, 50, 40);
SELECT "User Created: Test" AS MESSAGE;

CALL rpfp.itdmu_create_rpfp_user('encoder4b', 'encoder4b', 'mimaropa', 'encoder', 'mimaropa@yahoo.com', 17, 170000000, 50, 40);
SELECT "User Created: Test" AS MESSAGE;

CALL rpfp.itdmu_create_rpfp_user('encoderncr', 'encoderncr', 'ncr', 'encoder', 'ncrpopcom@yahoo.com', 13, 130000000, 50, 40);
SELECT "User Created: Test" AS MESSAGE;

CALL rpfp.itdmu_create_rpfp_user('root', '', 'root', 'root', 'y@com.com', 08, 080000000, 50, 40);
SELECT "User Created: root" AS MESSAGE;

CALL rpfp.itdmu_create_rpfp_user('encoder8', 'encoder8', 'root', 'root', 'z@com.com', 08, 080000000, 50, 40);
SELECT "User Created: encoder8" AS MESSAGE;

CALL rpfp.itdmu_create_rpfp_user('focal8', 'focal8', 'root', 'root', 'f@com.com', 08, 080000000, 70, 40);
SELECT "User Created: focal8" AS MESSAGE;

CALL rpfp.itdmu_create_rpfp_user('partner8', 'partner8', 'root', 'root', 'v@com.com', 08, 080000000, 60, 40);
SELECT "User Created: partner8" AS MESSAGE;

CALL rpfp.itdmu_create_rpfp_user('rdm8', 'rdm8', 'root', 'root', 'w@com.com', 08, 080000000, 80, 40);
SELECT "User Created: rdm8" AS MESSAGE;

CALL rpfp.itdmu_create_rpfp_user('rdm4b', 'rdm4b', 'mimaropa', 'rdm', 'mimaropa@yahoo.com', 17, 170000000, 80, 40);
SELECT "User Created: rdm8" AS MESSAGE;

CALL rpfp.itdmu_create_rpfp_user('rdmncr', 'rdmncr', 'ncr', 'rdm', 'ncrpopcom@yahoo.com', 13, 130000000, 80, 40);
SELECT "User Created: rdm8" AS MESSAGE;

CALL rpfp.itdmu_create_rpfp_user('pmed', 'pmed', 'root', 'root', 'p@com.com', '', '', 90, 50);
SELECT "User Created: pmed" AS MESSAGE;

CALL rpfp.itdmu_create_rpfp_user('exect00', 'exect00', 'root', 'root', 'e@com.com', '', '', 100, 50);
SELECT "User Created: exect00" AS MESSAGE;

--
-- Dumping data for table `rpfp_class`
--
SELECT "Populating Seminars" AS MESSAGE;

INSERT INTO rpfp.`rpfp_class`
            (`RPFP_CLASS_ID`, `TYPE_CLASS_ID`, `OTHERS_SPECIFY`,`BARANGAY_ID`,`CLASS_NUMBER`,`DATE_CONDUCTED`,`DB_USER_ID`)
     VALUES (1, 1, NULL, 083747125, 'RPFP-TAC-2019-00001','2019-02-11', 'test'),
            (2, 2, NULL, 083747125, 'RPFP-TAC-2019-00001','2019-02-11', 'root'),
            (3, 2, NULL, 083747125, 'RPFP-TAC-2019-00002','2019-02-11', 'test'),
            (4, 2, NULL, 083747125, 'RPFP-TAC-2019-00003','2019-02-11', 'root'),
            (5, 2, NULL, 083747125, 'RPFP-TAC-2019-00004','2019-02-11', 'test'),
            (6, 2, NULL, 083747125, 'RPFP-TAC-2019-00005','2019-02-11', 'root'),
            (7, 2, NULL, 083747125, 'RPFP-TAC-2019-00005','2019-02-11', 'test'),
            (8, 2, NULL, 083747125, 'RPFP-TAC-2019-00006','2019-03-11', 'root'),
            (9, 2, NULL, 083747125, 'RPFP-TAC-2019-00006','2019-03-11', 'test'),
            (10, 2, NULL, 083747125, 'RPFP-TAC-2019-00006','2019-03-11', 'root'),
            (11, 1, NULL, 083747125, 'RPFP-TAC-2019-00007','2019-03-11', 'test'),
            (12, 2, NULL, 083747125, 'RPFP-TAC-2019-00007','2019-03-11', 'root')
;

-- --------------------------------------------------------

SELECT "Populating Couples" AS MESSAGE;

--
-- Dumping data for table `couples`
--

INSERT INTO rpfp.`couples`
            (`COUPLES_ID`, `RPFP_CLASS_ID`, `ADDRESS_NO_ST`, `ADDRESS_BRGY`, `ADDRESS_CITY`, `HH_ID_NO`,  `NO_CHILDREN`, `DATE_ENCODED`,`IS_ACTIVE`)
     VALUES (1, 1, '5 ISANG STREET', 'PINAGKAISAHAN', 'MANDALUYONG', '1-000-102453-2', 8,  '2019-03-01', 2 ),
            (2, 1, '2 ISANG STREET', 'PINAGKAISAHAN', 'MANDALUYONG', '1-000-102453-2', 5, '2019-03-01', 0 ),
            (3, 1, '3 ISANG STREET', 'PINAGKAISAHAN', 'MANDALUYONG', '1-000-102453-2', 4, '2019-03-01', 2 ),
            (4, 1, '4 ISANG STREET', 'PINAGKAISAHAN', 'MANDALUYONG', '1-000-102453-2', 3, '2019-03-01', 0 ),
            (5, 1, '1 ISANG STREET', 'PINAGKAISAHAN', 'MANDALUYONG', '1-000-102453-2', 2, '2019-03-01', 2 ),
            (6, 1, '7 ISANG STREET', 'PINAGKAISAHAN', 'MANDALUYONG', '1-000-102453-2', 6, '2019-03-01', 2 ),
            (7, 1, '6 ISANG STREET', 'PINAGKAISAHAN', 'MANDALUYONG', '1-000-102453-2', 2, '2019-03-01', 0 ),
            (8, 1, '9 ISANG STREET', 'PINAGKAISAHAN', 'MANDALUYONG', '1-000-102453-2', 1, '2019-03-01', 0 ),
            (9, 1, '8 ISANG STREET', 'PINAGKAISAHAN', 'MANDALUYONG', '1-000-102453-2', 0, '2019-03-01', 0 ),
            (10, 1, '10 ISANG STREET', 'PINAGKAISAHAN', 'MANDALUYONG', '1-000-102453-2', 5, '2019-03-01', 0 ),
            (11, 1, '14 ISANG STREET', 'PINAGKAISAHAN', 'MANDALUYONG', '1-000-102453-2', 4, '2019-03-01', 0 ),
            (12, 1, '13 ISANG STREET', 'PINAGKAISAHAN', 'MANDALUYONG', '1-000-102453-2', 3, '2019-03-01', 0 ),
            (13, 1, '12 ISANG STREET', 'PINAGKAISAHAN', 'MANDALUYONG', '1-000-102453-2', 7, '2019-03-01', 2 ),
            (14, 1, '11 ISANG STREET', 'PINAGKAISAHAN', 'MANDALUYONG', '1-000-102453-2', 2, '2019-03-01', 2 ),
            (15, 1, '15 ISANG STREET', 'PINAGKAISAHAN', 'MANDALUYONG', '1-000-102453-2', 2, '2019-03-01', 0 ),
            (16, 2, '2 DALAWA STREET', 'PINAGKAISAHAN', 'MANDALUYONG', '1-000-102453-2', 5, '2019-03-01', 0 ),
            (17, 2, '3 DALAWA STREET', 'PINAGKAISAHAN', 'MANDALUYONG', '1-000-102453-2', 4, '2019-03-01', 0 ),
            (18, 2, '4 DALAWA STREET', 'PINAGKAISAHAN', 'MANDALUYONG', '1-000-102453-2', 3, '2019-03-01', 0 ),
            (19, 2, '1 DALAWA STREET', 'PINAGKAISAHAN', 'MANDALUYONG', '1-000-102453-2', 2, '2019-03-01', 0 ),
            (20, 2, '7 DALAWA STREET', 'PINAGKAISAHAN', 'MANDALUYONG', '1-000-102453-2', 6, '2019-03-01', 0 ),
            (21, 2, '6 DALAWA STREET', 'PINAGKAISAHAN', 'MANDALUYONG', '1-000-102453-2', 2, '2019-03-01', 0 ),
            (22, 2, '9 DALAWA STREET', 'PINAGKAISAHAN', 'MANDALUYONG', '1-000-102453-2', 1, '2019-03-01', 0 ),
            (23, 2, '8 DALAWA STREET', 'PINAGKAISAHAN', 'MANDALUYONG', '1-000-102453-2', 0, '2019-03-01', 0 ),
            (24, 2, '10 DALAWA STREET', 'PINAGKAISAHAN', 'MANDALUYONG', '1-000-102453-2', 5, '2019-03-01', 0 ),
            (25, 2, '14 DALAWA STREET', 'PINAGKAISAHAN', 'MANDALUYONG', '1-000-102453-2', 4, '2019-03-01', 0 ),
            (26, 3, '13 TATLO STREET', 'PINAGKAISAHAN', 'MANDALUYONG', '1-000-102453-2', 3, '2019-03-01', 0 ),
            (27, 3, '12 TATLO STREET', 'PINAGKAISAHAN', 'MANDALUYONG', '1-000-102453-2', 7, '2019-03-01', 2 ),
            (28, 3, '11 TATLO STREET', 'PINAGKAISAHAN', 'MANDALUYONG', '1-000-102453-2', 2, '2019-03-01', 2 ),
            (29, 3, '15 TATLO STREET', 'PINAGKAISAHAN', 'MANDALUYONG', '1-000-102453-2', 2, '2019-03-01', 0 ),
            (30, 3, '2 TATLO STREET', 'PINAGKAISAHAN', 'MANDALUYONG', '1-000-102453-2', 5, '2019-03-01', 0 ),
            (31, 3, '3 TATLO STREET', 'PINAGKAISAHAN', 'MANDALUYONG', '1-000-102453-2', 4, '2019-03-01', 2 ),
            (32, 3, '4 TATLO STREET', 'PINAGKAISAHAN', 'MANDALUYONG', '1-000-102453-2', 3, '2019-03-01', 0 ),
            (33, 3, '1 TATLO STREET', 'PINAGKAISAHAN', 'MANDALUYONG', '1-000-102453-2', 2, '2019-03-01', 2 ),
            (34, 3, '7 TATLO STREET', 'PINAGKAISAHAN', 'MANDALUYONG', '1-000-102453-2', 6, '2019-03-01', 2 ),
            (35, 3, '6 TATLO STREET', 'PINAGKAISAHAN', 'MANDALUYONG', '1-000-102453-2', 2, '2019-03-01', 0 ),
            (36, 4, '9 APAT STREET', 'PINAGKAISAHAN', 'MANDALUYONG', '1-000-102453-2', 1, '2019-03-01', 0 ),
            (37, 4, '8 APAT STREET', 'PINAGKAISAHAN', 'MANDALUYONG', '1-000-102453-2', 0, '2019-03-01', 0 ),
            (38, 4, '10 APAT STREET', 'PINAGKAISAHAN', 'MANDALUYONG', '1-000-102453-2', 5, '2019-03-01', 0 ),
            (39, 4, '14 APAT STREET', 'PINAGKAISAHAN', 'MANDALUYONG', '1-000-102453-2', 4, '2019-03-01', 0 ),
            (40, 4, '13 APAT STREET', 'PINAGKAISAHAN', 'MANDALUYONG', '1-000-102453-2', 3, '2019-03-01', 0 ),
            (41, 4, '12 APAT STREET', 'PINAGKAISAHAN', 'MANDALUYONG', '1-000-102453-2', 7, '2019-03-01', 2 ),
            (42, 4, '11 APAT STREET', 'PINAGKAISAHAN', 'MANDALUYONG', '1-000-102453-2', 2, '2019-03-01', 2 ),
            (43, 4, '15 APAT STREET', 'PINAGKAISAHAN', 'MANDALUYONG', '1-000-102453-2', 2, '2019-03-01', 0 ),
            (44, 5, '4 ISANG STREET', 'PINAGKAISAHAN', 'MANDALUYONG', '1-000-102453-2', 3, '2019-03-01', 0 ),
            (45, 5, '1 ISANG STREET', 'PINAGKAISAHAN', 'MANDALUYONG', '1-000-102453-2', 2, '2019-03-01', 2 ),
            (46, 5, '7 ISANG STREET', 'PINAGKAISAHAN', 'MANDALUYONG', '1-000-102453-2', 6, '2019-03-01', 2 ),
            (47, 5, '6 ISANG STREET', 'PINAGKAISAHAN', 'MANDALUYONG', '1-000-102453-2', 2, '2019-03-01', 0 ),
            (48, 5, '9 ISANG STREET', 'PINAGKAISAHAN', 'MANDALUYONG', '1-000-102453-2', 1, '2019-03-01', 0 ),
            (49, 5, '8 ISANG STREET', 'PINAGKAISAHAN', 'MANDALUYONG', '1-000-102453-2', 0, '2019-03-01', 0 ),
            (50, 5, '10 ISANG STREET', 'PINAGKAISAHAN', 'MANDALUYONG', '1-000-102453-2', 5, '2019-03-01', 0 ),
            (51, 5, '14 ISANG STREET', 'PINAGKAISAHAN', 'MANDALUYONG', '1-000-102453-2', 4, '2019-03-01', 0 ),
            (52, 5, '13 ISANG STREET', 'PINAGKAISAHAN', 'MANDALUYONG', '1-000-102453-2', 3, '2019-03-01', 0 ),
            (53, 5, '12 ISANG STREET', 'PINAGKAISAHAN', 'MANDALUYONG', '1-000-102453-2', 7, '2019-03-01', 2 ),
            (54, 5, '11 ISANG STREET', 'PINAGKAISAHAN', 'MANDALUYONG', '1-000-102453-2', 2, '2019-03-01', 2 ),
            (55, 5, '15 ISANG STREET', 'PINAGKAISAHAN', 'MANDALUYONG', '1-000-102453-2', 2, '2019-03-01', 0 ),
            (56, 6, '2 DALAWA STREET', 'PINAGKAISAHAN', 'MANDALUYONG', '1-000-102453-2', 5, '2019-03-01', 0 ),
            (57, 6, '3 DALAWA STREET', 'PINAGKAISAHAN', 'MANDALUYONG', '1-000-102453-2', 4, '2019-03-01', 2 ),
            (58, 6, '4 DALAWA STREET', 'PINAGKAISAHAN', 'MANDALUYONG', '1-000-102453-2', 3, '2019-03-01', 0 ),
            (59, 6, '1 DALAWA STREET', 'PINAGKAISAHAN', 'MANDALUYONG', '1-000-102453-2', 2, '2019-03-01', 2 ),
            (60, 6, '7 DALAWA STREET', 'PINAGKAISAHAN', 'MANDALUYONG', '1-000-102453-2', 6, '2019-03-01', 2 ),
            (61, 6, '6 DALAWA STREET', 'PINAGKAISAHAN', 'MANDALUYONG', '1-000-102453-2', 2, '2019-03-01', 0 ),
            (62, 6, '9 DALAWA STREET', 'PINAGKAISAHAN', 'MANDALUYONG', '1-000-102453-2', 1, '2019-03-01', 0 ),
            (63, 6, '8 DALAWA STREET', 'PINAGKAISAHAN', 'MANDALUYONG', '1-000-102453-2', 0, '2019-03-01', 0 ),
            (64, 6, '10 DALAWA STREET', 'PINAGKAISAHAN', 'MANDALUYONG', '1-000-102453-2', 5, '2019-03-01', 0 ),
            (65, 6, '14 DALAWA STREET', 'PINAGKAISAHAN', 'MANDALUYONG', '1-000-102453-2', 4, '2019-03-01', 0 ),
            (66, 7, '13 TATLO STREET', 'PINAGKAISAHAN', 'MANDALUYONG', '1-000-102453-2', 3, '2019-03-01', 0 ),
            (67, 7, '12 TATLO STREET', 'PINAGKAISAHAN', 'MANDALUYONG', '1-000-102453-2', 7, '2019-03-01', 2 ),
            (68, 7, '11 TATLO STREET', 'PINAGKAISAHAN', 'MANDALUYONG', '1-000-102453-2', 2, '2019-03-01', 2 ),
            (69, 7, '15 TATLO STREET', 'PINAGKAISAHAN', 'MANDALUYONG', '1-000-102453-2', 2, '2019-03-01', 0 ),
            (70, 8, '2 TATLO STREET', 'PINAGKAISAHAN', 'MANDALUYONG', '1-000-102453-2', 5, '2019-03-01', 0 ),
            (71, 8, '3 TATLO STREET', 'PINAGKAISAHAN', 'MANDALUYONG', '1-000-102453-2', 4, '2019-03-01', 2 ),
            (72, 8, '4 TATLO STREET', 'PINAGKAISAHAN', 'MANDALUYONG', '1-000-102453-2', 3, '2019-03-01', 0 ),
            (73, 8, '1 TATLO STREET', 'PINAGKAISAHAN', 'MANDALUYONG', '1-000-102453-2', 2, '2019-03-01', 2 ),
            (74, 8, '7 TATLO STREET', 'PINAGKAISAHAN', 'MANDALUYONG', '1-000-102453-2', 6, '2019-03-01', 2 ),
            (75, 8, '6 TATLO STREET', 'PINAGKAISAHAN', 'MANDALUYONG', '1-000-102453-2', 2, '2019-03-01', 0 ),
            (76, 9, '9 APAT STREET', 'PINAGKAISAHAN', 'MANDALUYONG', '1-000-102453-2', 1, '2019-03-01', 0 ),
            (77, 9, '8 APAT STREET', 'PINAGKAISAHAN', 'MANDALUYONG', '1-000-102453-2', 0, '2019-03-01', 0 ),
            (78, 9, '10 APAT STREET', 'PINAGKAISAHAN', 'MANDALUYONG', '1-000-102453-2', 5, '2019-03-01', 0 ),
            (79, 9, '14 APAT STREET', 'PINAGKAISAHAN', 'MANDALUYONG', '1-000-102453-2', 4, '2019-03-01', 0 ),
            (80, 10, '13 APAT STREET', 'PINAGKAISAHAN', 'MANDALUYONG', '1-000-102453-2', 3, '2019-03-01', 0 ),
            (81, 10, '12 APAT STREET', 'PINAGKAISAHAN', 'MANDALUYONG', '1-000-102453-2', 7, '2019-03-01', 2 ),
            (82, 10, '11 APAT STREET', 'PINAGKAISAHAN', 'MANDALUYONG', '1-000-102453-2', 2, '2019-03-01', 2 ),
            (83, 10, '15 APAT STREET', 'PINAGKAISAHAN', 'MANDALUYONG', '1-000-102453-2', 2, '2019-03-01', 0 ),
            (84, 11, '10 ISANG STREET', 'PINAGKAISAHAN', 'MANDALUYONG', '1-000-102453-2', 5, '2019-03-01', 0 ),
            (85, 11, '14 ISANG STREET', 'PINAGKAISAHAN', 'MANDALUYONG', '1-000-102453-2', 4, '2019-03-01', 0 ),
            (86, 11, '13 ISANG STREET', 'PINAGKAISAHAN', 'MANDALUYONG', '1-000-102453-2', 3, '2019-03-01', 0 ),
            (87, 11, '12 ISANG STREET', 'PINAGKAISAHAN', 'MANDALUYONG', '1-000-102453-2', 7, '2019-03-01', 2 ),
            (88, 11, '11 ISANG STREET', 'PINAGKAISAHAN', 'MANDALUYONG', '1-000-102453-2', 2, '2019-03-01', 2 ),
            (89, 11, '15 ISANG STREET', 'PINAGKAISAHAN', 'MANDALUYONG', '1-000-102453-2', 2, '2019-03-01', 0 ),
            (90, 12, '2 DALAWA STREET', 'PINAGKAISAHAN', 'MANDALUYONG', '1-000-102453-2', 5, '2019-03-01', 0 ),
            (91, 12, '3 DALAWA STREET', 'PINAGKAISAHAN', 'MANDALUYONG', '1-000-102453-2', 4, '2019-03-01', 0 ),
            (92, 12, '4 DALAWA STREET', 'PINAGKAISAHAN', 'MANDALUYONG', '1-000-102453-2', 3, '2019-03-01', 0 ),
            (93, 12, '1 DALAWA STREET', 'PINAGKAISAHAN', 'MANDALUYONG', '1-000-102453-2', 2, '2019-03-01', 0 )
            
;

SELECT "Populating Individuals" AS MESSAGE;

--
-- Dumping data for table `individual`
--

INSERT INTO rpfp.`individual`
            (`INDV_ID`,
            `COUPLES_ID`,
            `LNAME`,
            `FNAME`,
            `MNAME`,
            `EXT_NAME`,
            `AGE`,
            `SEX`,
            `BDATE`,
            `CIVIL_ID`,
            `EDUC_BCKGRND_ID`,
            `IS_ATTENDEE`)
     VALUES (1, 1, 'Simon',        'Anna Margarette',  '', '', 36,       2,        '1984-02-07', 1, 8, 1 ),
            (2, 1, 'Simon',        'Carl Edward',      '', '', 38,       1,        '1981-09-09', 1, 8, 1 ),
            (3, 2, 'Alcantara',    'Gusion',           '', '', 30,       1,        '1989-01-07', 1, 7, 1 ),
            (4, 2, 'Alcantara',    'Gueneverre',       '', '', 30,       2,        '1989-12-09', 1, 6, 1 ),
            (5, 3, 'Moral',        'Claude Vincent',   '', '', 28,       1,        '1991-05-07', 1, 5, 1 ),
            (6, 3, 'Moral',        'Esmeralda',        '', '', 30,       2,        '1989-06-09', 1, 6, 1 ),
            (7, 4, 'Broquez',      'Lancelot',         '', '', 34,       1,        '1985-04-07', 1, 6, 1 ),
            (8, 4, 'Broquez',      'Odette',           '', '', 31,       2,        '1988-10-09', 1, 6, 1 ),
            (9, 5, 'Cervantes',    'Alucard',          '', '', 27,       1,        '1992-11-07', 1, 7, 1 ),
            (10, 5, 'Cervantes',   'Layla',            '', '', 25,       2,        '1994-12-09', 1, 8, 1 ),
            (11, 6, 'Montana',     'Hanabi',           '', '', 28,       2,        '1991-07-07', 1, 9, 1 ),
            (12, 6, 'Montana',     'Leo',              '', '', 28,       1,        '1991-08-09', 1, 8, 1 ),
            (13, 7, 'Rodriguez',   'Ruby',             '', '', 49,       2,        '1970-03-07', 1, 7, 1 ),
            (14, 7, 'Rodriguez',   'Clint',            '', '', 47,       1,        '1972-03-09', 1, 7, 1 ),
            (15, 8, 'Fargas',      'Bruno',            '', '', 50,       1,        '1970-03-07', 1, 4, 1 ),
            (16, 8, 'Fargas',      'Lesley',           '', '', 50,       2,        '1972-03-09', 1, 5, 0 ),
            (17, 9, 'Gonzaga',     'Alice',            '', '', 25,       2,        '1994-06-07', 5, 5, 1 ),
            (18, 9, 'Vargas',      'Alexander',        '', '', 29,       1,        '1990-08-07', 5, 3, 0 ),
            (19, 10, 'Halili',     'Miya',             '', '', 30,       2,        '1989-04-07', 5, 5, 1 ),
            (20, 10, 'Reyes',      'Miguel',           '', '', 30,       1,        '1989-01-07', 5, 5, 0 ),
            (21, 11, 'Gomez',      'Selena',           '', '', 21,       2,        '1998-11-05', 2, 8, 1 ),
            (22, 12, 'Isip',       'Angela',           '', '', 18,       2,        '2001-10-10', 2, 7, 1 ),
            (23, 13, 'Jimenez',    'Lylia',            '', '', 14,       2,        '2005-09-19', 2, 4, 1 ),
            (24, 14, 'Coronel',    'Hilda',            '', '', 47,       2,        '1972-02-02', 3, 7, 1 ),
            (25, 15, 'Lopez',      'Karina',           '', '', 40,       2,        '1979-12-10', 4, 8, 1 ),
            (26, 16, 'Aldana',      'Alejandro',      '', '', 38,       1,        '1981-09-09', 1, 8, 1 ),
            (27, 17, 'Aragon',  'Bayani',           '', '', 30,       1,        '1989-01-07', 1, 7, 1 ),
            (28, 17, 'Aragon',  'Rosamie',       '', '', 30,       2,        '1989-12-09', 1, 6, 1 ),
            (29, 18, 'Bautista',      'Crisanto',   '', '', 28,       1,        '1991-05-07', 1, 5, 1 ),
            (30, 18, 'Bautista',      'Jasmine',        '', '', 30,       2,        '1989-06-09', 1, 6, 1 ),
            (31, 19, 'Borbon',    'Vedasto',         '', '', 34,       1,        '1985-04-07', 1, 6, 1 ),
            (32, 19, 'Borbon',    'Blessica',           '', '', 31,       2,        '1988-10-09', 1, 6, 1 ),
            (33, 20, 'Calalang',  'Joselito',          '', '', 27,       1,        '1992-11-07', 1, 7, 1 ),
            (34, 20, 'Calalang',  'Tala',            '', '', 25,       2,        '1994-12-09', 1, 8, 1 ),
            (35, 21, 'Celestial',    'Jaslene',           '', '', 28,       2,        '1991-07-07', 1, 9, 1 ),
            (36, 21, 'Celestial',    'Rizalino',              '', '', 28,       1,        '1991-08-09', 1, 8, 1 ),
            (37, 22, 'Diaz',  'Benilda',             '', '', 49,       2,        '1970-03-07', 1, 7, 1 ),
            (38, 22, 'Diaz',  'Ernesto',            '', '', 47,       1,        '1972-03-09', 1, 7, 1 ),
            (39, 23, 'Duran',     'Keanu',            '', '', 50,       1,        '1970-03-07', 1, 4, 1 ),
            (40, 23, 'Duran',     'Floribeth',           '', '', 50,       2,        '1972-03-09', 1, 5, 0 ),
            (41, 24, 'Espina',    'Chesa',            '', '', 25,       2,        '1994-06-07', 5, 5, 1 ),
            (42, 25, 'Flores',     'Vergel',        '', '', 29,       1,        '1990-08-07', 5, 3, 0 ),
            (43, 26, 'Gopez',     'Marisol',             '', '', 30,       2,        '1989-04-07', 5, 5, 1 ),
            (44, 27, 'Hipolito',      'Antonio',           '', '', 30,       1,        '1989-01-07', 5, 5, 0 ),
            (45, 28, 'Isidro',      'Liezel',           '', '', 21,       2,        '1998-11-05', 2, 8, 1 ),
            (46, 29, 'Labrador',       'Luzviminda',           '', '', 18,       2,        '2001-10-10', 2, 7, 1 ),
            (47, 30, 'Liwanag',    'Nenita',            '', '', 14,       2,        '2005-09-19', 2, 4, 1 ),
            (48, 31, 'Magallanes',    'Rubylyn',            '', '', 47,       2,        '1972-02-02', 3, 7, 1 ),
            (49, 32, 'Manzano',      'Luningning',           '', '', 40,       2,        '1979-12-10', 4, 8, 1 ),
            (50, 33, 'Moreno',      'Juan',   '', '', 28,       1,        '1991-05-07', 1, 5, 1 ),
            (51, 33, 'Moreno',      'Lualhati',        '', '', 30,       2,        '1989-06-09', 1, 6, 1 ),
            (52, 34, 'Natividad',    'Rodrigo',         '', '', 34,       1,        '1985-04-07', 1, 6, 1 ),
            (53, 34, 'Natividad',    'Amor',           '', '', 31,       2,        '1988-10-09', 1, 6, 1 ),
            (54, 35, 'Oliveros',  'Efren',          '', '', 27,       1,        '1992-11-07', 1, 7, 1 ),
            (55, 35, 'Oliveros',  'Perlah',            '', '', 25,       2,        '1994-12-09', 1, 8, 1 ),
            (56, 36, 'Pascua',    'Reyna',           '', '', 28,       2,        '1991-07-07', 1, 9, 1 ),
            (57, 36, 'Pascua',    'Mauricio',              '', '', 28,       1,        '1991-08-09', 1, 8, 1 ),
            (58, 37, 'Posadas',  'Sampaguita',             '', '', 49,       2,        '1970-03-07', 1, 7, 1 ),
            (59, 37, 'Posadas',  'Fernandez',            '', '', 47,       1,        '1972-03-09', 1, 7, 1 ),
            (60, 38, 'Ricarte',     'Venancio',            '', '', 50,       1,        '1970-03-07', 1, 4, 1 ),
            (61, 38, 'Ricarte',     'Mahalia',           '', '', 50,       2,        '1972-03-09', 1, 5, 0 ),
            (62, 39, 'Rosario',    'Darna',            '', '', 25,       2,        '1994-06-07', 5, 5, 1 ),
            (63, 40, 'Soledad',     'Melchor',        '', '', 29,       1,        '1990-08-07', 5, 3, 0 ),
            (64, 41, 'Sangcap',     'Barbara',             '', '', 30,       2,        '1989-04-07', 5, 5, 1 ),
            (65, 42, 'Tizon',      'Danilo',           '', '', 30,       1,        '1989-01-07', 5, 5, 0 ),
            (66, 43, 'Abes',      'Charlene',           '', '', 21,       2,        '1998-11-05', 2, 8, 1 ),
            (67, 44, 'Abuque',  'Daniel',           '', '', 30,       1,        '1989-01-07', 1, 7, 1 ),
            (68, 44, 'Abuque',  'Celine',       '', '', 30,       2,        '1989-12-09', 1, 6, 1 ),
            (69, 45, 'Adlawan',      'Joshua',   '', '', 28,       1,        '1991-05-07', 1, 5, 1 ),
            (70, 45, 'Adlawan',      'Ciara',        '', '', 30,       2,        '1989-06-09', 1, 6, 1 ),
            (71, 46, 'Agbuya',    'Gabriel',         '', '', 34,       1,        '1985-04-07', 1, 6, 1 ),
            (72, 46, 'Agbuya',    'Consuelo',           '', '', 31,       2,        '1988-10-09', 1, 6, 1 ),
            (73, 47, 'Agcaoili',  'Nathaniel',          '', '', 27,       1,        '1992-11-07', 1, 7, 1 ),
            (74, 47, 'Agcaoili',  'Cristina',            '', '', 25,       2,        '1994-12-09', 1, 8, 1 ),
            (75, 48, 'Alcomendras',    'Beverly',           '', '', 28,       2,        '1991-07-07', 1, 9, 1 ),
            (76, 48, 'Alcomendras',    'John Mark',              '', '', 28,       1,        '1991-08-09', 1, 8, 1 ),
            (77, 49, 'Alvarez',  'Bernadette',             '', '', 49,       2,        '1970-03-07', 1, 7, 1 ),
            (78, 49, 'Alvarez',  'James',            '', '', 47,       1,        '1972-03-09', 1, 7, 1 ),
            (79, 50, 'Ambong',     'Francis',            '', '', 50,       1,        '1970-03-07', 1, 4, 1 ),
            (80, 50, 'Ambong',     'Beatrice',           '', '', 50,       2,        '1972-03-09', 1, 5, 0 ),
            (81, 51, 'Baccay',    'Barbara',            '', '', 25,       2,        '1994-06-07', 5, 5, 1 ),
            (82, 52, 'Bagatsing',     'Jacob',        '', '', 29,       1,        '1990-08-07', 5, 3, 0 ),
            (83, 53, 'Balingit',     'Aurora',             '', '', 30,       2,        '1989-04-07', 5, 5, 1 ),
            (84, 54, 'Banal',      'Christian',           '', '', 30,       1,        '1989-01-07', 5, 5, 0 ),
            (85, 55, 'Barte',      'April',           '', '', 21,       2,        '1998-11-05', 2, 8, 1 ),
            (86, 56, 'Basa',       'Annie',           '', '', 18,       2,        '2001-10-10', 2, 7, 1 ),
            (87, 57, 'Bauzon',    'Annette',            '', '', 14,       2,        '2005-09-19', 2, 4, 1 ),
            (88, 58, 'Bulan',    'Annabel',            '', '', 47,       2,        '1972-02-02', 3, 7, 1 ),
            (89, 59, 'Cabatuan',      'Anita',           '', '', 40,       2,        '1979-12-10', 4, 8, 1 ),
            (90, 60, 'Calinao',      'Amado',   '', '', 28,       1,        '1991-05-07', 1, 5, 1 ),
            (91, 60, 'Calinao',      'Angelie',        '', '', 30,       2,        '1989-06-09', 1, 6, 1 ),
            (92, 61, 'Canuto',    'Modesto',         '', '', 34,       1,        '1985-04-07', 1, 6, 1 ),
            (93, 61, 'Canuto',    'Mutya',           '', '', 31,       2,        '1988-10-09', 1, 6, 1 ),
            (94, 62, 'Capili',  'Macario',          '', '', 27,       1,        '1992-11-07', 1, 7, 1 ),
            (95, 62, 'Capili',  'Martha',            '', '', 25,       2,        '1994-12-09', 1, 8, 1 ),
            (96, 63, 'Catacutan',    'Manuela',           '', '', 28,       2,        '1991-07-07', 1, 9, 1 ),
            (97, 63, 'Catacutan',    'Marcelino',              '', '', 28,       1,        '1991-08-09', 1, 8, 1 ),
            (98, 64, 'Chavez',  'Margarita',             '', '', 49,       2,        '1970-03-07', 1, 7, 1 ),
            (99, 64, 'Chavez',  'Marcus',            '', '', 47,       1,        '1972-03-09', 1, 7, 1 ),
            (100, 65, 'Concepcion',     'Mariano',            '', '', 50,       1,        '1970-03-07', 1, 4, 1 ),
            (101, 65, 'Concepcion',     'Marian',           '', '', 50,       2,        '1972-03-09', 1, 5, 0 ),
            (102, 66, 'Dagohoy',    'Marie',            '', '', 25,       2,        '1994-06-07', 5, 5, 1 ),
            (103, 67, 'De Guzman',     'Mario',        '', '', 29,       1,        '1990-08-07', 5, 3, 0 ),
            (104, 68, 'Del Rosario',     'Marissa',             '', '', 30,       2,        '1989-04-07', 5, 5, 1 ),
            (105, 69, 'Del Valle',      'Marlon',           '', '', 30,       1,        '1989-01-07', 5, 5, 0 ),
            (106, 70, 'Dimarucut',      'Mabel',           '', '', 21,       2,        '1998-11-05', 2, 8, 1 ),
            (107, 71, 'Abinsay',    'Martin',         '', '', 34,       1,        '1985-04-07', 1, 6, 1 ),
            (108, 71, 'Abinsay',    'Martina',           '', '', 31,       2,        '1988-10-09', 1, 6, 1 ),
            (109, 72, 'Abot',  'Marvin',          '', '', 27,       1,        '1992-11-07', 1, 7, 1 ),
            (110, 72, 'Abot',  'Maurice',            '', '', 25,       2,        '1994-12-09', 1, 8, 1 ),
            (111, 73, 'Abuan',    'Maxima',           '', '', 28,       2,        '1991-07-07', 1, 9, 1 ),
            (112, 73, 'Abuan',    'Maynard',              '', '', 28,       1,        '1991-08-09', 1, 8, 1 ),
            (113, 74, 'Agas',  'Salome',             '', '', 49,       2,        '1970-03-07', 1, 7, 1 ),
            (114, 74, 'Agas',  'Salvador',            '', '', 47,       1,        '1972-03-09', 1, 7, 1 ),
            (115, 75, 'Agonoy',     'Sammy',            '', '', 50,       1,        '1970-03-07', 1, 4, 1 ),
            (116, 75, 'Agonoy',     'Samantha',           '', '', 50,       2,        '1972-03-09', 1, 5, 0 ),
            (117, 76, 'Alambat',    'Sandra',            '', '', 25,       2,        '1994-06-07', 5, 5, 1 ),
            (118, 77, 'Alday',     'Samson',        '', '', 29,       1,        '1990-08-07', 5, 3, 0 ),
            (119, 78, 'Alonto',     'Serena',             '', '', 30,       2,        '1989-04-07', 5, 5, 1 ),
            (120, 79, 'Ambulo',      'Sergio',           '', '', 30,       1,        '1989-01-07', 5, 5, 0 ),
            (121, 80, 'Ampong',      'Sheila',           '', '', 21,       2,        '1998-11-05', 2, 8, 1 ),
            (122, 81, 'Antalan',    'Sheldon',         '', '', 34,       1,        '1985-04-07', 1, 6, 1 ),
            (123, 81, 'Antalan',    'Shelley',           '', '', 31,       2,        '1988-10-09', 1, 6, 1 ),
            (124, 82, 'Bagasbas',  'Socrates',          '', '', 27,       1,        '1992-11-07', 1, 7, 1 ),
            (125, 82, 'Bagasbas',  'Socorro',            '', '', 25,       2,        '1994-12-09', 1, 8, 1 ),
            (126, 83, 'Balaba',    'Soraya',           '', '', 28,       2,        '1991-07-07', 1, 9, 1 ),
            (127, 83, 'Balaba',    'Spencer',              '', '', 28,       1,        '1991-08-09', 1, 8, 1 ),
            (128, 84, 'Cervantes',    'Alucard',          '', '', 27,       1,        '1992-11-07', 1, 7, 1 ),
            (129, 84, 'Cervantes',   'Layla',            '', '', 25,       2,        '1994-12-09', 1, 8, 1 ),
            (130, 85, 'Montana',     'Hanabi',           '', '', 28,       2,        '1991-07-07', 1, 9, 1 ),
            (131, 85, 'Montana',     'Leo',              '', '', 28,       1,        '1991-08-09', 1, 8, 1 ),
            (132, 86, 'Rodriguez',   'Ruby',             '', '', 49,       2,        '1970-03-07', 1, 7, 1 ),
            (133, 86, 'Rodriguez',   'Clint',            '', '', 47,       1,        '1972-03-09', 1, 7, 1 ),
            (134, 87, 'Fargas',      'Bruno',            '', '', 50,       1,        '1970-03-07', 1, 4, 1 ),
            (135, 87, 'Fargas',      'Lesley',           '', '', 50,       2,        '1972-03-09', 1, 5, 0 ),
            (136, 88, 'Gonzaga',     'Alice',            '', '', 25,       2,        '1994-06-07', 5, 5, 1 ),
            (137, 88, 'Vargas',      'Alexander',        '', '', 29,       1,        '1990-08-07', 5, 3, 0 ),
            (138, 89, 'Halili',     'Miya',             '', '', 30,       2,        '1989-04-07', 5, 5, 1 ),
            (239, 89, 'Reyes',      'Miguel',           '', '', 30,       1,        '1989-01-07', 5, 5, 0 ),
            (240, 90, 'Gomez',      'Selena',           '', '', 21,       2,        '1998-11-05', 2, 8, 1 ),
            (241, 91, 'Isip',       'Angela',           '', '', 18,       2,        '2001-10-10', 2, 7, 1 ),
            (242, 92, 'Jimenez',    'Lylia',            '', '', 14,       2,        '2005-09-19', 2, 4, 1 ),
            (243, 93, 'Coronel',    'Hilda',            '', '', 47,       2,        '1972-02-02', 3, 7, 1 ),
            (244, 94, 'Lopez',      'Karina',           '', '', 40,       2,        '1979-12-10', 4, 8, 1 )
            
;


SELECT "Populating details of FP Method used by couples" AS MESSAGE;
-- --------------------------------------------------------
--
-- Dumping data for table `fp_details`
--

INSERT INTO rpfp.`fp_details`
            (`FP_DETAILS_ID`, `COUPLES_ID`, `MFP_METHOD_USED_ID`, `MFP_INTENTION_SHIFT_ID`, `TFP_TYPE_ID`, `TFP_STATUS_ID`, `MFP_INTENTION_USE_ID`, `REASON_INTENDING_USE_ID`)
     VALUES (1, 1, 3, NULL, NULL, NULL, NULL, NULL),
            (2, 2, NULL, NULL, 1, 'D', NULL, NULL),
            (3, 3, 3, 2, NULL, NULL, NULL, NULL),
            (4, 4, NULL, NULL, 6, 'D', NULL, NULL),
            (5, 5, NULL, NULL, 6, 'C', NULL, NULL),
            (6, 6, NULL, NULL, 6, 'A', 6, 1),
            (7, 7, NULL, NULL, 1, 2, NULL, NULL),
            (8, 8, 12, NULL, NULL, NULL, NULL, NULL),
            (9, 9, NULL, NULL, 2, 'A', 7, 2),
            (10, 10, NULL, NULL, 6, 'A', 8, 2),
            (11, 11, NULL, NULL, 6, 'D', NULL, NULL),
            (12, 12, NULL, NULL, 6, 'D', NULL, NULL),
            (13, 13, NULL, NULL, 6, 'D', NULL, NULL),
            (14, 14, NULL, NULL, 6, 'D', NULL, NULL),
            (15, 15, NULL, NULL, 6, 'D', NULL, NULL),
            (16, 16, NULL, NULL, 1, 'D', NULL, NULL),
            (17, 17, 3, 2, NULL, NULL, NULL, NULL),
            (18, 18, NULL, NULL, 6, 'D', NULL, NULL),
            (19, 19, NULL, NULL, 6, 'C', NULL, NULL),
            (20, 20, NULL, NULL, 6, 'A', 9, 1),
            (21, 21, NULL, NULL, 1, 'B', NULL, NULL),
            (22, 22, 12, NULL, NULL, NULL, NULL, NULL),
            (23, 23, NULL, NULL, 2, 'A', 5, 2),
            (24, 24, NULL, NULL, 6, 'A', 5, 2),
            (25, 25, NULL, NULL, 6, 'D', NULL, NULL),
            (26, 26, NULL, NULL, 6, 'D', NULL, NULL),
            (27, 27, NULL, NULL, 6, 'D', NULL, NULL),
            (28, 28, NULL, NULL, 6, 'D', NULL, NULL),
            (29, 29, NULL, NULL, 6, 'D', NULL, NULL),
            (30, 30, NULL, NULL, 1, 'D', NULL, NULL),
            (31, 31, 3, 2, NULL, NULL, NULL, NULL),
            (32, 32, NULL, NULL, 6, 'D', NULL, NULL),
            (33, 33, NULL, NULL, 6, 'C', NULL, NULL),
            (34, 34, NULL, NULL, 6, 'A', 4, 1),
            (35, 35, NULL, NULL, 1, 'B', NULL, NULL),
            (36, 36, 12, NULL, NULL, NULL, NULL, NULL),
            (37, 37, NULL, NULL, 2, 'A', 1, 2),
            (38, 38, NULL, NULL, 6, 'A', 5, 2),
            (39, 39, NULL, NULL, 6, 'D', NULL, NULL),
            (40, 40, NULL, NULL, 6, 'D', NULL, NULL),
            (41, 41, NULL, NULL, 6, 'D', NULL, NULL),
            (42, 42, NULL, NULL, 6, 'D', NULL, NULL),
            (43, 43, NULL, NULL, 6, 'D', NULL, NULL),
            (44, 44, NULL, NULL, 6, 'D', NULL, NULL),
            (45, 45, NULL, NULL, 6, 'D', NULL, NULL),
            (46, 46, NULL, NULL, 1, 'D', NULL, NULL),
            (47, 47, 3, 2, NULL, NULL, NULL, NULL),
            (48, 48, NULL, NULL, 6, 'D', NULL, NULL),
            (49, 49, NULL, NULL, 6, 'C', NULL, NULL),
            (50, 50, NULL, NULL, 6, 'A', 4, 1),
            (51, 51, NULL, NULL, 1, 'B', NULL, NULL),
            (52, 52, 12, NULL, NULL, NULL, NULL, NULL),
            (53, 53, NULL, NULL, 2, 'A', 10, 2),
            (54, 54, NULL, NULL, 6, 'A', 11, 2),
            (55, 55, NULL, NULL, 6, 'D', NULL, NULL),
            (56, 56, NULL, NULL, 6, 'D', NULL, NULL),
            (57, 57, NULL, NULL, 6, 'D', NULL, NULL),
            (58, 58, NULL, NULL, 6, 'D', NULL, NULL),
            (59, 59, NULL, NULL, 6, 'D', NULL, NULL),
            (60, 60, NULL, NULL, 1, 'D', NULL, NULL),
            (61, 61, 3, 2, NULL, NULL, NULL, NULL),
            (62, 62, NULL, NULL, 6, 'D', NULL, NULL),
            (63, 63, NULL, NULL, 6, 'C', NULL, NULL),
            (64, 64, NULL, NULL, 6, 'A', 12, 1),
            (65, 65, NULL, NULL, 1, 'B', NULL, NULL),
            (66, 66, 12, NULL, NULL, NULL, NULL, NULL),
            (67, 67, NULL, NULL, 2, 'A', 3, 2),
            (68, 68, NULL, NULL, 6, 'A', 4, 2),
            (69, 69, NULL, NULL, 6, 'D', NULL, NULL),
            (70, 70, NULL, NULL, 6, 'D', NULL, NULL),
            (71, 71, NULL, NULL, 6, 'D', NULL, NULL),
            (72, 72, NULL, NULL, 6, 'D', NULL, NULL),
            (73, 73, NULL, NULL, 6, 'D', NULL, NULL),
            (74, 74, NULL, NULL, 1, 'B', NULL, NULL),
            (75, 75, 12, NULL, NULL, NULL, NULL, NULL),
            (76, 76, NULL, NULL, 2, 'A', 1, 2),
            (77, 77, NULL, NULL, 6, 'A', 2, 2),
            (78, 78, NULL, NULL, 6, 'D', NULL, NULL),
            (79, 79, NULL, NULL, 6, 'D', NULL, NULL),
            (80, 80, NULL, NULL, 6, 'D', NULL, NULL),
            (81, 81, NULL, NULL, 6, 'D', NULL, NULL),
            (82, 82, NULL, NULL, 6, 'D', NULL, NULL),
            (83, 83, NULL, NULL, 6, 'D', NULL, NULL),
            (84, 84, NULL, NULL, 6, 'C', NULL, NULL),
            (85, 85, NULL, NULL, 6, 'A', 4, 1),
            (86, 86, NULL, NULL, 1, 'B', NULL, NULL),
            (87, 87, 12, NULL, NULL, NULL, NULL, NULL),
            (88, 88, NULL, NULL, 2, 'A', 6, 2),
            (89, 89, NULL, NULL, 6, 'A', 7, 2),
            (90, 90, NULL, NULL, 6, 'D', NULL, NULL),
            (91, 91, NULL, NULL, 6, 'D', NULL, NULL),
            (92, 92, NULL, NULL, 6, 'D', NULL, NULL),
            (93, 93, NULL, NULL, 6, 'D', NULL, NULL)
;

SELECT "Populating details of target couples per month" AS MESSAGE;
-- --------------------------------------------------------
--
-- Dumping data for table `fp_details`
--

INSERT INTO rpfp.`target_couples`
            (`TARGET_ID`, `TARGET_YEAR`, `TARGET_MONTH`, `PSGC_CODE`, `TARGET_COUNT`)
     VALUES (1, 2019, 01, 08, 1000),
            (2, 2019, 02, 08, 1000),
            (3, 2019, 03, 08, 1000),
            (4, 2019, 04, 08, 1000),
            (5, 2019, 05, 08, 1000),
            (6, 2019, 06, 08, 1000),
            (7, 2019, 07, 08, 1000),
            (8, 2019, 08, 08, 1000),
            (9, 2019, 09, 08, 1000),
            (10, 2019, 10, 08, 1000),
            (11, 2019, 11, 08, 1000),
            (12, 2019, 12, 08, 1000),
            (13, 2019, 01, 02, 1000),
            (14, 2019, 02, 02, 1000),
            (15, 2019, 03, 02, 1000),
            (18, 2019, 04, 02, 1000),
            (19, 2019, 05, 02, 1000),
            (20, 2019, 06, 02, 1000),
            (21, 2019, 07, 02, 1000),
            (22, 2019, 08, 02, 1000),
            (23, 2019, 09, 02, 1000),
            (24, 2019, 10, 02, 1000),
            (25, 2019, 11, 02, 1000),
            (26, 2019, 12, 02, 1000),
            (27, 2019, 01, 04, 1000),
            (28, 2019, 02, 04, 1000),
            (29, 2019, 03, 04, 1000),
            (30, 2019, 04, 04, 1000),
            (31, 2019, 05, 04, 1000),
            (32, 2019, 06, 04, 1000),
            (33, 2019, 07, 04, 1000),
            (34, 2019, 08, 04, 1000),
            (35, 2019, 09, 04, 1000),
            (36, 2019, 10, 04, 1000),
            (37, 2019, 11, 04, 1000),
            (38, 2019, 12, 04, 1000),
            (39, 2019, 01, 11, 1000),
            (40, 2019, 02, 11, 1000),
            (41, 2019, 03, 11, 1000),
            (42, 2019, 04, 11, 1000),
            (43, 2019, 05, 11, 1000),
            (44, 2019, 06, 11, 1000),
            (45, 2019, 07, 11, 1000),
            (46, 2019, 08, 11, 1000),
            (47, 2019, 09, 11, 1000),
            (48, 2019, 10, 11, 1000),
            (49, 2019, 11, 11, 1000),
            (50, 2019, 12, 11, 1000)
;

-- --------------------------------------------------------

COMMIT;
SELECT "Done" AS MESSAGE;

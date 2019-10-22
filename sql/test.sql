SELECT "Loading Test values" AS MESSAGE;

CALL rpfp.itdmu_create_rpfp_user('test', 'test', 'rojo', 'rowell', 'x@com.com', 13, 130000000, 50, 40);
SELECT "User Created: Test" AS MESSAGE;

CALL rpfp.itdmu_create_rpfp_user('root', '', 'root', 'root', 'y@com.com', 08, 080000000, 50, 40);
SELECT "User Created: root" AS MESSAGE;


--
-- Dumping data for table `rpfp_class`
--
SELECT "Populating Seminars" AS MESSAGE;

INSERT INTO rpfp.`rpfp_class`
            (`RPFP_CLASS_ID`, `TYPE_CLASS_ID`, `OTHERS_SPECIFY`,`BARANGAY_ID`,`CLASS_NUMBER`,`DATE_CONDUCTED`,`DB_USER_ID`)
     VALUES (1, 1, NULL, 083747125, 'RPFP-TAC-2019-00001','2019-02-11', 'test'),
            (2, 2, NULL, 083747125, 'RPFP-TAC-2019-00001','2019-02-11', 'test'),
            (3, 2, NULL, 083747125, 'RPFP-TAC-2019-00002','2019-05-11', 'test'),
            (4, 2, NULL, 083747125, 'RPFP-TAC-2019-00003','2019-09-11', 'test')
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
            (17, 2, '3 DALAWA STREET', 'PINAGKAISAHAN', 'MANDALUYONG', '1-000-102453-2', 4, '2019-03-01', 2 ),
            (18, 2, '4 DALAWA STREET', 'PINAGKAISAHAN', 'MANDALUYONG', '1-000-102453-2', 3, '2019-03-01', 0 ),
            (19, 2, '1 DALAWA STREET', 'PINAGKAISAHAN', 'MANDALUYONG', '1-000-102453-2', 2, '2019-03-01', 2 ),
            (20, 2, '7 DALAWA STREET', 'PINAGKAISAHAN', 'MANDALUYONG', '1-000-102453-2', 6, '2019-03-01', 2 ),
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
            (43, 4, '15 APAT STREET', 'PINAGKAISAHAN', 'MANDALUYONG', '1-000-102453-2', 2, '2019-03-01', 0 )
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
     VALUES (1, 1, 'Simon',        'Anna Margarette',  '', '', 35,       2,        '1984-02-07', 1, 8, 1 ),
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
            (66, 43, 'Venosa',      'Adah',           '', '', 21,       2,        '1998-11-05', 2, 8, 1 )
;


SELECT "Populating details of FP Method used by couples" AS MESSAGE;
-- --------------------------------------------------------
--
-- Dumping data for table `fp_details`
--

INSERT INTO rpfp.`fp_details`
            (`FP_DETAILS_ID`, `COUPLES_ID`, `MFP_METHOD_USED_ID`, `MFP_INTENTION_SHIFT_ID`, `TFP_TYPE_ID`, `TFP_STATUS_ID`, `REASON_INTENDING_USE_ID`)
     VALUES (1, 1, 3, NULL, NULL, NULL, NULL),
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
            (15, 15, NULL, NULL, 6, 4, NULL),
            (16, 16, NULL, NULL, 1, 4, NULL),
            (17, 17, 3, 2, NULL, NULL, NULL),
            (18, 18, NULL, NULL, 6, 4, NULL),
            (19, 19, NULL, NULL, 6, 3, NULL),
            (20, 20, 4, NULL, 6, 1, 1),
            (21, 21, NULL, NULL, 1, 2, NULL),
            (22, 22, 12, NULL, NULL, NULL, NULL),
            (23, 23, 5, NULL, 2, 1, 2),
            (24, 24, 5, NULL, 6, 1, 2),
            (25, 25, NULL, NULL, 6, 4, NULL),
            (26, 26, NULL, NULL, 6, 4, NULL),
            (27, 27, NULL, NULL, 6, 4, NULL),
            (28, 28, NULL, NULL, 6, 4, NULL),
            (29, 29, NULL, NULL, 6, 4, NULL),
            (30, 30, NULL, NULL, 1, 4, NULL),
            (31, 31, 3, 2, NULL, NULL, NULL),
            (32, 32, NULL, NULL, 6, 4, NULL),
            (33, 33, NULL, NULL, 6, 3, NULL),
            (34, 34, 4, NULL, 6, 1, 1),
            (35, 35, NULL, NULL, 1, 2, NULL),
            (36, 36, 12, NULL, NULL, NULL, NULL),
            (37, 37, 5, NULL, 2, 1, 2),
            (38, 38, 5, NULL, 6, 1, 2),
            (39, 39, NULL, NULL, 6, 4, NULL),
            (40, 40, NULL, NULL, 6, 4, NULL),
            (41, 41, NULL, NULL, 6, 4, NULL),
            (42, 42, NULL, NULL, 6, 4, NULL),
            (43, 43, NULL, NULL, 6, 4, NULL)
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
            (15, 2019, 03, 02, 1000)
;

-- --------------------------------------------------------

COMMIT;
SELECT "Done" AS MESSAGE;

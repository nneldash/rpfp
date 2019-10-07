
call rpfp.itdmu_create_rpfp_user('test', 'test', 'rojo', 'rowell', 'x@com.com', 13, 130000000, 60, 40);

--
-- Dumping data for table `rpfp_class`
--

INSERT INTO `rpfp_class`
            (`RPFP_CLASS_ID`, `TYPE_CLASS_ID`, `OTHERS_SPECIFY`,`REGION_CODE`,`PSGC_CODE`,`CLASS_NUMBER`,`DATE_CONDUCTED`,`DB_USER_ID`)
     VALUES (1, 1, NULL, 12, 083747125, 'RPFP-TAC-2019-00001','02-11-2019', 'test')
;

-- --------------------------------------------------------

--
-- Dumping data for table `couples`
--

INSERT INTO `couples`
            (`COUPLES_ID`, `RPFP_CLASS_ID`, `ADDRESS_NO_ST`, `ADDRESS_BRGY`, `ADDRESS_CITY`, `HH_ID_NO`,  `NO_CHILDREN`, `DATE_ENCODED`, `DB_USER_ID`, `IS_ACTIVE`)
     VALUES (1, 1, '5 ISANG STREET', 'PINAGKAISAHAN', 'MANDALUYONG', '1-000-102453-2', 8,  '03-01-2019',  'test', 2 ),
            (2, 1, '2 ISANG STREET', 'PINAGKAISAHAN', 'MANDALUYONG', '1-000-102453-2', 5, '03-01-2019', 'test', 2 ),
            (3, 1, '3 ISANG STREET', 'PINAGKAISAHAN', 'MANDALUYONG', '1-000-102453-2', 4, '03-01-2019', 'test', 2 ),
            (4, 1, '4 ISANG STREET', 'PINAGKAISAHAN', 'MANDALUYONG', '1-000-102453-2', 3, '03-01-2019', 'test', 2 ),
            (5, 1, '1 ISANG STREET', 'PINAGKAISAHAN', 'MANDALUYONG', '1-000-102453-2', 2, '03-01-2019', 'test', 2 ),
            (6, 1, '7 ISANG STREET', 'PINAGKAISAHAN', 'MANDALUYONG', '1-000-102453-2', 6, '03-01-2019', 'test', 2 ),
            (7, 1, '6 ISANG STREET', 'PINAGKAISAHAN', 'MANDALUYONG', '1-000-102453-2', 2, '03-01-2019', 'test', 2 ),
            (8, 1, '9 ISANG STREET', 'PINAGKAISAHAN', 'MANDALUYONG', '1-000-102453-2', 1, '03-01-2019', 'test', 2 ),
            (9, 1, '8 ISANG STREET', 'PINAGKAISAHAN', 'MANDALUYONG', '1-000-102453-2', 0, '03-01-2019', 'test', 2 ),
            (10, 1, '10 ISANG STREET', 'PINAGKAISAHAN', 'MANDALUYONG', '1-000-102453-2', 5, '03-01-2019', 'test', 2 ),
            (11, 1, '14 ISANG STREET', 'PINAGKAISAHAN', 'MANDALUYONG', '1-000-102453-2', 4, '03-01-2019', 'test', 2 ),
            (12, 1, '13 ISANG STREET', 'PINAGKAISAHAN', 'MANDALUYONG', '1-000-102453-2', 3, '03-01-2019', 'test', 2 ),
            (13, 1, '12 ISANG STREET', 'PINAGKAISAHAN', 'MANDALUYONG', '1-000-102453-2', 7, '03-01-2019', 'test', 2 ),
            (14, 1, '11 ISANG STREET', 'PINAGKAISAHAN', 'MANDALUYONG', '1-000-102453-2', 2, '03-01-2019', 'test', 2 )
;

--
-- Dumping data for table `individual`
--

INSERT INTO `individual`
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
            `ETNICITY`,
            `ATTENDEE`)
     VALUES (1, 1, 'Simon', 'Anna Margarette', '', NULL, 35, 2, '1984-02-07', 4, 1, 3, 1 ),
            (2, 1, 'Simon', 'Carl Edward', '', NULL, 38, 1, '1981-09-09', 4, 1, 3, 1 ),
            (3, 2, 'Alcantara', 'Gusion', '', NULL, 30, 1, '1989-01-07', NULL, 1, 4, 1 ),
            (4, 2, 'Alcantara', 'Gueneverre', '', NULL, 30, 2, '1989-12-09', NULL, 1, 4, 1 ),
            (5, 3, 'Moral', 'Claude Vincent', '', NULL, 28, 1, '1991-05-07', NULL, 1, 4, 1 ),
            (6, 3, 'Moral', 'Esmeralda', '', NULL, 30, 2, '1989-06-09', NULL, 1, 4, 1 ),
            (7, 4, 'Broquez', 'Lancelot', '', NULL, 34, 1, '1985-04-07', NULL, 1, 4, 1 ),
            (8, 4, 'Broquez', 'Odette', '', NULL, 31, 2, '1988-10-09', NULL, 1, 4, 1 ),
            (9, 5, 'Cervantes', 'Alucard', '', NULL, 27, 1, '1992-11-07', 4, 1, 3, 1 ),
            (10, 5, 'Cervantes', 'Layla', '', NULL, 25, 2, '1994-12-09', 4, 1, 3, 1 ),
            (11, 6, 'Montana', 'Hanabi', '', NULL, 28, 2, '1991-07-07', NULL, 1, 4, 1 ),
            (12, 6, 'Montana', 'Leo', '', NULL, 28, 1, '1991-08-09', NULL, 1, 2, 1 ),
            (13, 7, 'Rodriguez', 'Ruby', '', NULL, 49, 2, '1970-03-07', 1, 1, 5, 1 ),
            (14, 7, 'Rodriguez', 'Clint', '', NULL, 47, 1, '1972-03-09', 1, 1, 5, 1 ),
            (15, 8, 'Fargas', 'Bruno', '', NULL, 50, 1, '1970-03-07', 1, 1, 4, 1 ),
            (16, 8, 'Fargas', 'Lesley', '', NULL, 50, 2, '1972-03-09', 2, 1, 4, 0 ),
            (17, 9, 'Gonzaga', 'Alice', '', NULL, 25, 2, '1994-06-07', 2, 5, 3, 1 ),
            (18, 9, 'Vargas', 'Alexander', '', NULL, NULL, NULL, NULL, NULL, 3, 1, 3, 0 ),
            (19, 10, 'Halili', 'Miya', '', NULL, 30, 2, '1989-04-07', NULL, 5, 3, 1 ),
            (20, 10, 'Reyes', 'Miguel', '', NULL, NULL, NULL, NULL, 3, 5, 3, 0)
;

-- --------------------------------------------------------
--
-- Dumping data for table `fp_details`
--

INSERT INTO `fp_details`
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
            (15, 15, NULL, NULL, 6, 4, NULL)
;

-- --------------------------------------------------------

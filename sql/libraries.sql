SELECT "Populating Libraries" AS MESSAGE;
--
-- Dumping data for table `lib_type_class`
--

INSERT INTO `lib_type_class` (`TYPE_CLASS_ID`, `TYPE_CLASS_DESC`) VALUES
(1, '4Ps' ),
(2, 'Faith-Based Organization' ),
(3, 'PMC' ),
(4, 'Usapan' ),
(5, 'House-to-House' ),
(6, 'Profile only' ),
(7, 'Others');

-- --------------------------------------------------------

--
-- Dumping data for table `lib_civil_status`
--

INSERT INTO `lib_civil_status` (`CIVIL_ID`, `CIVIL_DESC`) VALUES
(1, 'Married' ),
(2, 'Single' ),
(3, 'Widow/Widower' ),
(4, 'Separated' ),
(5, 'Live-in');

-- --------------------------------------------------------
--
-- Dumping data for table `lib_educ_bckgrnd`
--

INSERT INTO `lib_educ_bckgrnd` (`EDUC_BCKGRND_ID`, `EDUC_BCKGRND_DESC`) VALUES
(1, 'No Education' ),
(2, 'Elementary Level' ),
(3, 'Elementary Graduate' ),
(4, 'High School Level' ),
(5, 'High School Graduate' ),
(6, 'Vocational' ),
(7, 'College Level' ),
(8, 'College Graduate' ),
(9, 'Post Graduate');

-- --------------------------------------------------------
--
-- Dumping data for table `lib_modern_fp_method`
--

INSERT INTO `lib_modern_fp_method` (`MODERN_FP_ID`, `MODERN_FP_DESC`) VALUES
(1, 'Condom' ),
(2, 'IUD' ),
(3, 'Pills' ),
(4, 'Injectable' ),
(5, 'Vasectomy' ),
(6, 'Tubal Ligation' ),
(7, 'Implant' ),
(8, 'CMM/Billings' ),
(9, 'BBT' ),
(10, 'Sympto-Thermal' ),
(11, 'SDM' ),
(12, 'LAM');

-- --------------------------------------------------------
--
-- Dumping data for table `lib_traditional_fp_method`
--

INSERT INTO `lib_traditional_fp_method` (`TRADITIONAL_FP_ID`, `TRADITIONAL_FP_DESC`) VALUES
(1, 'Withdrawal' ),
(2, 'Rhythm' ),
(3, 'Calendar' ),
(4, 'Abstinence' ),
(5, 'Herbal' ),
(6, 'No Method');

-- --------------------------------------------------------
--
-- Dumping data for table lib_traditional_fp_status
--

INSERT INTO lib_traditional_fp_status 
    (TFP_STATUS_ID,
    TFP_STATUS_DESC)
VALUES
    (1, 'Expressing Intention to Use Modern FP Method' ),
    (2, 'Undecided' ),
	(3, 'Currently Pregnant' ),
	(4, 'No Intention to Use')
;

-- --------------------------------------------------------
--
-- Dumping data for table `lib_reason_intending_use`
--

INSERT INTO `lib_reason_intending_use` (`REASON_INTENDING_USE_ID`, `REASON_INTENDING_USE_DESC`) VALUES
(1, 'Spacing' ),
(2, 'Limiting' ),
(3, 'Achieving');

-- --------------------------------------------------------

COMMIT;
SELECT "Done" AS MESSAGE;
<?php
defined('BASEPATH') or exit('No direct script access allowed');

class User_m extends ci_model
{
    public function tdu()
    {
        $data = "SELECT
        sys0001.UserID,
        sys0001.UserName,
        sys0001.`Password`,
        sys0001.TDate
        FROM
        sys0001
        WHERE
        UserID NOT LIKE '%1%' 
        AND UserID NOT LIKE '%2%'
        AND UserID NOT LIKE '%3%'
        AND UserID NOT LIKE '%4%'";
        $query = $this->db->query($data);
        return $query->result();
    }

    public function validationSPL()
    {
        $data = "CREATE DEFINER=`manager`@`%` PROCEDURE `validationSPL`(IN m INT, IN y INT, IN idWG INT, IN idDiv INT, IN idDept INT, IN nk VARCHAR(255))
        BEGIN
            IF
                ( idWG IS NOT NULL ) THEN
                
                SELECT
                fn.nik,
            fn.NAME,
            fn.`position`,
            fn.dept,
            fn.division,
            fn.Workgroup,
            fn.day,
            fn.dt,
            fn.tIn,
            fn.tIn1,
            fn.tOut,
            fn.tOut1,
            CONCAT(fn.ot,' Jam')ot,
            fn.masuk,
            fn.pulang,
              CASE -- Validation SPL
                WHEN fn.pulang IS NULL 
                  THEN 'Lupa Absen'
                WHEN fn.ot IS NULL AND fn.pulang BETWEEN IFNULL(fn.tIn1,time('00:00:00')) AND ADDDATE(IFNULL(fn.tOut1,time('23:59:59')), INTERVAL 30 MINUTE)  
                  THEN NULL
                WHEN fn.staffStatus = 'S' AND fn.ot>4 THEN
                  CASE 
                    WHEN fn.pulang>fn.tOut1 AND fn.ot IS NULL THEN 'Tidak Ada SPL'
                    WHEN fn.tIn=fn.tIn1 AND fn.tOut!=fn.tOut1 
                    THEN IF(fn.pulang>ADDDATE(fn.tOut1,INTERVAL -30 MINUTE), 'OK', 
                     CONCAT('Valid ',
                        IF(MINUTE(TIMEDIFF(fn.pulang,fn.min))>30,
                             HOUR(TIMEDIFF(fn.pulang,fn.min))+1,
                             HOUR(TIMEDIFF(fn.pulang,fn.min))),
                               ' Jam')
                )
                  WHEN fn.tIn!=fn.tIn1 AND fn.tOut=fn.tOut1 
                    THEN IF(ADDDATE(fn.tIn1,INTERVAL 30 MINUTE)>fn.masuk, 'OK', 
                     concat('Valid ',
                        IF(MINUTE(TIMEDIFF(fn.max,fn.masuk))>30,
                             HOUR(TIMEDIFF(fn.max,fn.masuk))+1,
                             HOUR(TIMEDIFF(fn.max,fn.masuk))),
                               ' Jam')
                )
                  WHEN fn.tIn!=fn.tIn1 AND fn.tOut!=fn.tOut1 
                    THEN CASE WHEN (ADDDATE(fn.tIn1,INTERVAL 30 MINUTE)>fn.masuk) OR (fn.pulang>ADDDATE(fn.tOut1,INTERVAL -30 MINUTE)) THEN
                        CASE WHEN (ADDDATE(fn.tIn1,INTERVAL 30 MINUTE)>fn.masuk) THEN
                          IF(MINUTE(TIMEDIFF(fn.max,fn.masuk))>30,
                               HOUR(TIMEDIFF(fn.max,fn.masuk))+1,
                               HOUR(TIMEDIFF(fn.max,fn.masuk)))
                        ELSE HOUR(TIMEDIFF(fn.max,fn.min)) END
                               +
                        CASE WHEN (fn.pulang>ADDDATE(fn.tOut1,INTERVAL -30 MINUTE)) THEN 
                          IF(MINUTE(TIMEDIFF(fn.pulang,fn.min))>30,
                               HOUR(TIMEDIFF(fn.pulang,fn.min))+1,
                               HOUR(TIMEDIFF(fn.pulang,fn.min)))
                        ELSE HOUR(TIMEDIFF(fn.max,fn.min)) END
                    END 
                  ELSE 
                    'OK'
                  END
                WHEN fn.staffStatus = 'O' THEN
                  CASE 
                    WHEN fn.pulang>fn.tOut1 AND fn.ot IS NULL THEN 'Tidak Ada SPL'
                    WHEN fn.tIn=fn.tIn1 AND fn.tOut!=fn.tOut1 
                    THEN IF(fn.pulang>ADDDATE(fn.tOut1,INTERVAL -30 MINUTE), 'OK', 
                     CONCAT('Valid ',
                        IF(MINUTE(TIMEDIFF(fn.pulang,fn.min))>30,
                             HOUR(TIMEDIFF(fn.pulang,fn.min))+1,
                             HOUR(TIMEDIFF(fn.pulang,fn.min))),
                               ' Jam')
                )
                  WHEN fn.tIn!=fn.tIn1 AND fn.tOut=fn.tOut1 
                    THEN IF(ADDDATE(fn.tIn1,INTERVAL 30 MINUTE)>fn.masuk, 'OK', 
                     concat('Valid ',
                        IF(MINUTE(TIMEDIFF(fn.max,fn.masuk))>30,
                             HOUR(TIMEDIFF(fn.max,fn.masuk))+1,
                             HOUR(TIMEDIFF(fn.max,fn.masuk))),
                               ' Jam')
                )
                  WHEN fn.tIn!=fn.tIn1 AND fn.tOut!=fn.tOut1 
                    THEN CASE WHEN (ADDDATE(fn.tIn1,INTERVAL 30 MINUTE)>fn.masuk) OR (fn.pulang>ADDDATE(fn.tOut1,INTERVAL -30 MINUTE)) THEN
                        CASE WHEN (ADDDATE(fn.tIn1,INTERVAL 30 MINUTE)>fn.masuk) THEN
                          IF(MINUTE(TIMEDIFF(fn.max,fn.masuk))>30,
                               HOUR(TIMEDIFF(fn.max,fn.masuk))+1,
                               HOUR(TIMEDIFF(fn.max,fn.masuk)))
                        ELSE HOUR(TIMEDIFF(fn.max,fn.min)) END
                               +
                        CASE WHEN (fn.pulang>ADDDATE(fn.tOut1,INTERVAL -30 MINUTE)) THEN 
                          IF(MINUTE(TIMEDIFF(fn.pulang,fn.min))>30,
                               HOUR(TIMEDIFF(fn.pulang,fn.min))+1,
                               HOUR(TIMEDIFF(fn.pulang,fn.min)))
                        ELSE HOUR(TIMEDIFF(fn.max,fn.min)) END
                    END
                  ELSE 
                    'OK'
                  END
            END validation
                FROM
                (SELECT
                    a.nik,
                    a.NAME,
                    p.`position`,
                    d.dept,
                    d1.division,
                    w1.Workgroup,a.staffStatus,
                    DAYNAME( a.dt ) `day`,
                    a.dt,
              a.min,
              a.max,
              a.tIn,
                    a.tIn1,
                    a.tOut,
                    a.tOut1,
                    a.HOUR as ot,
                    a.masuk,
                IF
                    (
                        a.masuk = IFNULL( b.pulang1, c.pulang2 ),
                        NULL,
                        IFNULL( b.pulang1, c.pulang2 ) 
                    ) pulang
                            FROM
                                (
                                SELECT
                                    a.nik,
                                    a.NAME,
                                    a.idDept,
                                    a.idDiv,
                                    a.idWG,
                                    a.idPost, a.staffStatus,
                                    a.dt,
                                    a.tIn,
                                    a.tOut,
                                    a.tIn1,
                                    a.tOut1,
                                    a.min,
                                    a.max,
                                    a.HOUR,
                                    MIN( a.ts ) masuk 
                                FROM
                                    (
                                    SELECT
                                        a.nik,
                                        a.NAME,
                                        a.idDept,
                                        a.idDiv,
                                        a.idWG,
                                        a.idPost, a.staffStatus,
                                        a.dt,
                                        a.ts,
                                        a.idTS,
                                        a.idGroupShift,
                                        spl.HOUR,
                                    IF
                                        ( a.idTS IS NULL, gs.tIn, ts.tIn ) tIn,
                                    IF
                                        ( a.idTS IS NULL, gs.tOut, ts.tOut ) tOut,
                                        spl.min,
                                        spl.max,
                                    IF
                                        (
                                            spl.min <
                                        IF
                                            ( a.idTS IS NULL, gs.tIn, ts.tIn ),
                                            spl.min,
                                        IF
                                            ( a.idTS IS NULL, gs.tIn, ts.tIn ) 
                                        ) tIn1,
                                    IF
                                        (
                                            spl.max >
                                        IF
                                            ( a.idTS IS NULL, gs.tOut, ts.tOut ),
                                            spl.max,
                                        IF
                                            ( a.idTS IS NULL, gs.tOut, ts.tOut ) 
                                        ) tOut1 
                                    FROM
                                        (
                                        SELECT DISTINCT
                                            l.NIK nik,
                                            l.NAME NAME,
                                            l.idDept idDept,
                                            l.idDiv idDiv,
                                            l.idWG idWG,
                                            l.idPost idPost, l.staffStatus,
                                            l.dt dt,
                                            l.ts ts,
                                        CASE
                                                
                                                WHEN dt BETWEEN cs.dateStart 
                                                AND cs.dateEnd THEN
                                                    cs.idTS ELSE NULL 
                                                END idTS,
                            CASE
                                    
                                    WHEN dt NOT BETWEEN cs.dateStart 
                                    AND cs.dateEnd THEN
                                        l.idGroupShift ELSE COALESCE (
                                        CASE
                                                
                                                WHEN cs.idTS IS NOT NULL THEN
                                            NULL 
                                            END,
                                        CASE
                                                
                                                WHEN cs.idTS IS NOT NULL THEN
                                                NULL ELSE l.idGroupShift 
                                            END 
                                            ) 
                                        END idGroupShift 
        FROM
            (
            SELECT
                l.NIK,
                me.NAME,
                me.idDept,
                me.idDiv,
                me.idWG,
                me.idPost,me.staffStatus,
                TIME( l.enroll ) ts,
                DATE( l.enroll ) dt,
                w.idGroupShift 
            FROM
                mstEmp me
                LEFT JOIN mstWorkgroup w ON me.idWG = w.idWG
                LEFT JOIN attandenceLog l ON me.NIK = l.NIK 
            WHERE
                MONTH ( l.enroll ) = m 
                AND YEAR ( l.enroll ) = y 
                AND me.idWG = idWG 
            ) l
            LEFT JOIN (
            SELECT
                cs.NIK,
            IF
                (
                    ( MONTH ( cs.dateStart ) = m OR YEAR ( cs.dateStart ) = y ),
                    cs.dateStart,
                    DATE( CONCAT( y, '/', m, '/1' ) ) 
                ) dateStart,
            IF
                (
                    ( MONTH ( cs.dateEnd ) = m OR YEAR ( cs.dateEnd ) = y ),
                    cs.dateStart,
                    LAST_DAY( CONCAT( y, '/', m, '/1' ) ) 
                ) dateEnd,
                cs.idTS 
            FROM
                transaksiChangeShift cs 
            WHERE
                ( MONTH ( cs.dateStart ) = m OR MONTH ( cs.dateEnd ) = m ) 
                AND ( YEAR ( cs.dateStart ) = y OR YEAR ( cs.dateEnd ) = y ) 
            ) cs ON l.NIK = cs.NIK 
            ) a
            LEFT JOIN mstGroupShift gs ON a.idGroupShift = gs.idGroupShift 
            AND WEEKDAY( a.dt ) = gs.Idx
            LEFT JOIN mstTimeShifting ts ON a.idTS = ts.idTS
            LEFT JOIN (
            SELECT
                a.NIK_spv AS nik,
                a.date AS dt,
                MIN( a.min ) `min`,
                MAX( a.max ) `max`,
            IF
                (
                    MAX( a.max ) < MIN( a.min ),
                    ( SUM( a.HOUR ) ),
                    MAX( a.HOUR ) 
                ) `hour` 
            FROM
                (
                SELECT
                    sl.idL,
                    sl.NIK_spv,
                    sl.date,
                    sl.idSPL,
                    MIN( sl.START ) min,
                MAX( sl.END ) max,
            HOUR ( TIMEDIFF( MAX( sl.START ), MIN( sl.END ) ) ) HOUR 
        FROM
            LogSuratLembur sl 
        WHERE
            MONTH ( sl.date ) = m 
            AND YEAR ( sl.date ) = y 
            AND sl.approval4 = 1 
            AND sl.idSPL = 1 
        GROUP BY
            sl.idL,
            sl.NIK_spv,
            sl.date UNION ALL
        SELECT
            sl.idL,
            sl.NIK_spv,
            sl.date,
            sl.idSPL,
            MIN( sl.START ) min,
            MAX( sl.END ) max,
            HOUR ( TIMEDIFF( MAX( sl.START ), MIN( sl.END ) ) ) HOUR 
        FROM
            LogSuratLembur sl 
        WHERE
            MONTH ( sl.date ) = m 
            AND YEAR ( sl.date ) = y 
            AND sl.approval4 = 1 
            AND sl.idSPL = 2 
        GROUP BY
            sl.idL,
            sl.NIK_spv,
            sl.date 
            ) a 
        WHERE
            ( a.min ) != ( a.max ) 
        GROUP BY
            a.NIK_spv,
            a.date UNION ALL
        SELECT
            a.nik,
            a.date AS dt,
            MIN( a.min ) `min`,
            MAX( a.max ) `max`,
        IF
            (
                MAX( a.max ) < MIN( a.min ),
                ( SUM( a.HOUR ) ),
                MAX( a.HOUR ) 
            ) `hour` 
        FROM
            (
            SELECT
                sl.idL,
                ms.NIK_op AS nik,
                sl.date,
                sl.idSPL,
                MIN( sl.START ) min,
            MAX( sl.END ) max,
            HOUR ( TIMEDIFF( MAX( sl.START ), MIN( sl.END ) ) ) HOUR 
        FROM
            LogSuratLembur sl
            JOIN LogMemberSPL ms ON sl.idL = ms.idL 
        WHERE
            MONTH ( sl.date ) = m 
            AND YEAR ( sl.date ) = y 
            AND sl.approval4 = 1 
            AND sl.idSPL = 1 
        GROUP BY
            sl.idL,
            nik,
            sl.date UNION ALL
        SELECT
            sl.idL,
            ms.NIK_op AS nik,
            sl.date,
            sl.idSPL,
            MIN( sl.START ) min,
            MAX( sl.END ) max,
            HOUR ( TIMEDIFF( MAX( sl.START ), MIN( sl.END ) ) ) HOUR 
        FROM
            LogSuratLembur sl
            JOIN LogMemberSPL ms ON sl.idL = ms.idL 
        WHERE
            MONTH ( sl.date ) = m 
            AND YEAR ( sl.date ) = y 
            AND sl.approval4 = 1 
            AND sl.idSPL = 2 
        GROUP BY
            sl.idL,
            nik,
            sl.date 
            ) a 
        WHERE
            ( a.min ) != ( a.max ) 
        GROUP BY
            a.nik,
            a.date 
        ORDER BY
            dt ASC 
            ) spl ON a.nik = spl.NIK 
            AND a.dt = spl.dt 
        ORDER BY
            a.nik,
            a.dt 
            ) a 
        WHERE
            a.ts BETWEEN ADDDATE( IFNULL( a.tIn1, time( '00:00:00' ) ), INTERVAL - 90 MINUTE ) 
            AND IFNULL( a.tOut1, time( '23:59:59' ) ) 
        GROUP BY
            a.nik,
            a.NAME,
            a.idDept,
            a.idDiv,
            a.idWG,
            a.idPost,
            a.dt,
            a.tIn1,
            a.tOut1,
            a.HOUR,
            a.tIn,
            a.tOut,
            a.min,
            a.max, a.staffStatus
            ) a
            LEFT JOIN (
            SELECT
                a.nik,
                a.NAME,
                a.dt,
                a.tIn1,
                a.tOut1,
                MAX( a.ts ) pulang1 
            FROM
                (
                SELECT
                    a.nik,
                    a.NAME,
                    a.dt,
                    a.ts,
                    a.idTS,
                    a.idGroupShift,
                IF
                    (
                        spl.min <
                    IF
                        ( a.idTS IS NULL, gs.tIn, ts.tIn ),
                        spl.min,
                    IF
                        ( a.idTS IS NULL, gs.tIn, ts.tIn ) 
                    ) tIn1,
                IF
                    (
                        spl.max >
                    IF
                        ( a.idTS IS NULL, gs.tOut, ts.tOut ),
                        spl.max,
                    IF
                        ( a.idTS IS NULL, gs.tOut, ts.tOut ) 
                    ) tOut1 
                FROM
                    (
                    SELECT DISTINCT
                        l.NIK nik,
                        l.NAME NAME,
                        l.dt dt,
                        l.ts ts,
                    CASE
                            
                            WHEN dt BETWEEN cs.dateStart 
                            AND cs.dateEnd THEN
                                cs.idTS ELSE NULL 
                            END idTS,
        CASE
                
                WHEN dt NOT BETWEEN cs.dateStart 
                AND cs.dateEnd THEN
                    l.idGroupShift ELSE COALESCE (
                    CASE
                            
                            WHEN cs.idTS IS NOT NULL THEN
                        NULL 
                        END,
                    CASE
                            
                            WHEN cs.idTS IS NOT NULL THEN
                            NULL ELSE l.idGroupShift 
                        END 
                        ) 
                    END idGroupShift 
        FROM
            (
            SELECT
                l.NIK,
                me.NAME,
                TIME( l.enroll ) ts,
                DATE( l.enroll ) dt,
                w.idGroupShift 
            FROM
                mstEmp me
                LEFT JOIN mstWorkgroup w ON me.idWG = w.idWG
                LEFT JOIN attandenceLog l ON me.NIK = l.NIK 
            WHERE
                MONTH ( l.enroll ) = m 
                AND YEAR ( l.enroll ) = y 
                AND me.idWG = idWG 
            ) l
            LEFT JOIN (
            SELECT
                cs.NIK,
            IF
                (
                    ( MONTH ( cs.dateStart ) = m OR YEAR ( cs.dateStart ) = y ),
                    cs.dateStart,
                    DATE( CONCAT( y, '/', m, '/1' ) ) 
                ) dateStart,
            IF
                (
                    ( MONTH ( cs.dateEnd ) = m OR YEAR ( cs.dateEnd ) = y ),
                    cs.dateStart,
                    LAST_DAY( CONCAT( y, '/', m, '/1' ) ) 
                ) dateEnd,
                cs.idTS 
            FROM
                transaksiChangeShift cs 
            WHERE
                ( MONTH ( cs.dateStart ) = m OR MONTH ( cs.dateEnd ) = m ) 
                AND ( YEAR ( cs.dateStart ) = y OR YEAR ( cs.dateEnd ) = y ) 
            ) cs ON l.NIK = cs.NIK 
            ) a
            LEFT JOIN mstGroupShift gs ON a.idGroupShift = gs.idGroupShift 
            AND WEEKDAY( a.dt ) = gs.Idx
            LEFT JOIN mstTimeShifting ts ON a.idTS = ts.idTS
            LEFT JOIN (
            SELECT
                a.NIK_spv AS nik,
                a.date AS dt,
                MIN( a.min ) `min`,
                MAX( a.max ) `max` 
            FROM
                (
                SELECT
                    sl.idL,
                    sl.NIK_spv,
                    sl.date,
                    sl.idSPL,
                    MIN( sl.START ) min,
                MAX( sl.END ) max 
            FROM
                LogSuratLembur sl 
            WHERE
                MONTH ( sl.date ) = m 
                AND YEAR ( sl.date ) = y 
                AND sl.approval4 = 1 
                AND sl.idSPL = 1 
            GROUP BY
                sl.idL,
                sl.NIK_spv,
                sl.date UNION ALL
            SELECT
                sl.idL,
                sl.NIK_spv,
                sl.date,
                sl.idSPL,
                MIN( sl.START ) min,
            MAX( sl.END ) max 
        FROM
            LogSuratLembur sl 
        WHERE
            MONTH ( sl.date ) = m 
            AND YEAR ( sl.date ) = y 
            AND sl.approval4 = 1 
            AND sl.idSPL = 2 
        GROUP BY
            sl.idL,
            sl.NIK_spv,
            sl.date 
            ) a 
        WHERE
            ( a.min ) != ( a.max ) 
        GROUP BY
            a.NIK_spv,
            a.date UNION ALL
        SELECT
            a.nik,
            a.date AS dt,
            MIN( a.min ) `min`,
            MAX( a.max ) `max` 
        FROM
            (
            SELECT
                sl.idL,
                ms.NIK_op AS nik,
                sl.date,
                sl.idSPL,
                MIN( sl.START ) min,
            MAX( sl.END ) max 
        FROM
            LogSuratLembur sl
            JOIN LogMemberSPL ms ON sl.idL = ms.idL 
        WHERE
            MONTH ( sl.date ) = m 
            AND YEAR ( sl.date ) = y 
            AND sl.approval4 = 1 
            AND sl.idSPL = 1 
        GROUP BY
            sl.idL,
            nik,
            sl.date UNION ALL
        SELECT
            sl.idL,
            ms.NIK_op AS nik,
            sl.date,
            sl.idSPL,
            MIN( sl.START ) min,
            MAX( sl.END ) max 
        FROM
            LogSuratLembur sl
            JOIN LogMemberSPL ms ON sl.idL = ms.idL 
        WHERE
            MONTH ( sl.date ) = m 
            AND YEAR ( sl.date ) = y 
            AND sl.approval4 = 1 
            AND sl.idSPL = 2 
        GROUP BY
            sl.idL,
            nik,
            sl.date 
            ) a 
        WHERE
            ( a.min ) != ( a.max ) 
        GROUP BY
            a.nik,
            a.date 
        ORDER BY
            dt ASC 
            ) spl ON a.nik = spl.NIK 
            AND a.dt = spl.dt 
        ORDER BY
            a.nik,
            a.dt 
            ) a 
        WHERE
            a.ts BETWEEN IFNULL(a.tIn1,TIME( '00:00:00' )) 
            AND TIME( '23:59:59' ) 
            AND IFNULL(a.tOut1,TIME( '10:30:00' )) < TIME( '23:59:59' ) 
        GROUP BY
            a.nik,
            a.NAME,
            a.dt,
            a.tIn1,
            a.tOut1 
            ) b ON a.nik = b.nik 
            AND a.dt = b.dt
            LEFT JOIN (
            SELECT
                a.nik,
                a.NAME,
                ADDDATE( a.dt, INTERVAL - 1 DAY ) dt,
                a.tIn1,
                a.tOut1,
                MIN( a.ts ) pulang2 
            FROM
                (
                SELECT
                    a.nik,
                    a.NAME,
                    a.dt,
                    a.ts,
                    a.idTS,
                    a.idGroupShift,
                IF
                    (
                        spl.min <
                    IF
                        ( a.idTS IS NULL, gs.tIn, ts.tIn ),
                        spl.min,
                    IF
                        ( a.idTS IS NULL, gs.tIn, ts.tIn ) 
                    ) tIn1,
                IF
                    (
                        spl.max >
                    IF
                        ( a.idTS IS NULL, gs.tOut, ts.tOut ),
                        spl.max,
                    IF
                        ( a.idTS IS NULL, gs.tOut, ts.tOut ) 
                    ) tOut1 
                FROM
                    (
                    SELECT DISTINCT
                        l.NIK nik,
                        l.NAME NAME,
                        l.dt dt,
                        l.ts ts,
                    CASE
                            
                            WHEN dt BETWEEN cs.dateStart 
                            AND cs.dateEnd THEN
                                cs.idTS ELSE NULL 
                            END idTS,
        CASE
                
                WHEN dt NOT BETWEEN cs.dateStart 
                AND cs.dateEnd THEN
                    l.idGroupShift ELSE COALESCE (
                    CASE
                            
                            WHEN cs.idTS IS NOT NULL THEN
                        NULL 
                        END,
                    CASE
                            
                            WHEN cs.idTS IS NOT NULL THEN
                            NULL ELSE l.idGroupShift 
                        END 
                        ) 
                    END idGroupShift 
        FROM
            (
            SELECT
                l.NIK,
                me.NAME,
                TIME( l.enroll ) ts,
                DATE( l.enroll ) dt,
                w.idGroupShift 
            FROM
                mstEmp me
                LEFT JOIN mstWorkgroup w ON me.idWG = w.idWG
                LEFT JOIN attandenceLog l ON me.NIK = l.NIK 
            WHERE
                MONTH ( l.enroll ) = m 
                AND YEAR ( l.enroll ) = y 
                AND me.idWG = idWG 
            ) l
            LEFT OUTER JOIN (
            SELECT
                cs.NIK,
            IF
                (
                    ( MONTH ( cs.dateStart ) = m OR YEAR ( cs.dateStart ) = y ),
                    cs.dateStart,
                    DATE( CONCAT( y, '/', m, '/1' ) ) 
                ) dateStart,
            IF
                (
                    ( MONTH ( cs.dateEnd ) = m OR YEAR ( cs.dateEnd ) = y ),
                    cs.dateStart,
                    LAST_DAY( CONCAT( y, '/', m, '/1' ) ) 
                ) dateEnd,
                cs.idTS 
            FROM
                transaksiChangeShift cs 
            WHERE
                ( MONTH ( cs.dateStart ) = m OR MONTH ( cs.dateEnd ) = m ) 
                AND ( YEAR ( cs.dateStart ) = y OR YEAR ( cs.dateEnd ) = y ) 
            ) cs ON l.NIK = cs.NIK 
            ) a
            LEFT JOIN mstGroupShift gs ON a.idGroupShift = gs.idGroupShift 
            AND WEEKDAY( a.dt ) = gs.Idx
            LEFT JOIN mstTimeShifting ts ON a.idTS = ts.idTS
            LEFT JOIN (
            SELECT
                a.NIK_spv AS nik,
                a.date AS dt,
                MIN( a.min ) `min`,
                MAX( a.max ) `max` 
            FROM
                (
                SELECT
                    sl.idL,
                    sl.NIK_spv,
                    sl.date,
                    sl.idSPL,
                    MIN( sl.START ) min,
                MAX( sl.END ) max 
            FROM
                LogSuratLembur sl 
            WHERE
                MONTH ( sl.date ) = m 
                AND YEAR ( sl.date ) = y 
                AND sl.approval4 = 1 
                AND sl.idSPL = 1 
            GROUP BY
                sl.idL,
                sl.NIK_spv,
                sl.date UNION ALL
            SELECT
                sl.idL,
                sl.NIK_spv,
                sl.date,
                sl.idSPL,
                MIN( sl.START ) min,
            MAX( sl.END ) max 
        FROM
            LogSuratLembur sl 
        WHERE
            MONTH ( sl.date ) = m 
            AND YEAR ( sl.date ) = y 
            AND sl.approval4 = 1 
            AND sl.idSPL = 2 
        GROUP BY
            sl.idL,
            sl.NIK_spv,
            sl.date 
            ) a 
        WHERE
            ( a.min ) != ( a.max ) 
        GROUP BY
            a.NIK_spv,
            a.date UNION ALL
        SELECT
            a.nik,
            a.date AS dt,
            MIN( a.min ) `min`,
            MAX( a.max ) `max` 
        FROM
            (
            SELECT
                sl.idL,
                ms.NIK_op AS nik,
                sl.date,
                sl.idSPL,
                MIN( sl.START ) min,
            MAX( sl.END ) max 
        FROM
            LogSuratLembur sl
            JOIN LogMemberSPL ms ON sl.idL = ms.idL 
        WHERE
            MONTH ( sl.date ) = m 
            AND YEAR ( sl.date ) = y 
            AND sl.approval4 = 1 
            AND sl.idSPL = 1 
        GROUP BY
            sl.idL,
            nik,
            sl.date UNION ALL
        SELECT
            sl.idL,
            ms.NIK_op AS nik,
            sl.date,
            sl.idSPL,
            MIN( sl.START ) min,
            MAX( sl.END ) max 
        FROM
            LogSuratLembur sl
            JOIN LogMemberSPL ms ON sl.idL = ms.idL 
        WHERE
            MONTH ( sl.date ) = m 
            AND YEAR ( sl.date ) = y 
            AND sl.approval4 = 1 
            AND sl.idSPL = 2 
        GROUP BY
            sl.idL,
            nik,
            sl.date 
            ) a 
        WHERE
            ( a.min ) != ( a.max ) 
        GROUP BY
            a.nik,
            a.date 
        ORDER BY
            dt ASC 
            ) spl ON a.nik = spl.NIK 
            AND a.dt = spl.dt 
        ORDER BY
            a.nik,
            a.dt 
            ) a 
        WHERE
            a.ts BETWEEN TIME( '10:30:00' ) 
            AND IFNULL(a.tIn1,TIME( '23:59:59' )) 
            AND a.tOut1 BETWEEN TIME( '00:00:00' ) 
            AND TIME( '10:30:00' ) 
        GROUP BY
            a.nik,
            a.NAME,
            a.dt,
            a.tIn1,
            a.tOut1 
            ) c ON a.nik = c.nik 
            AND a.dt = c.dt
            LEFT JOIN mstDept d ON d.idDept = a.idDept
            LEFT JOIN mstDiv d1 ON d1.idDiv = a.idDiv
            LEFT JOIN mstWorkgroup w1 ON w1.idWG = a.idWG
            LEFT JOIN mstPost p ON p.idPost = a.idPost 
        ORDER BY
            a.idPost,
            a.nik,
            a.dt) fn;
        
        ELSEIF idDiv IS NOT NULL THEN
        SELECT
            a.nik,
            a.NAME,
            p.`position`,
            d.dept,
            d1.division,
            w1.Workgroup,
            DAYNAME( a.dt ) `day`,
            a.dt,
            a.tIn1,
            a.tOut,
            a.tOut1,
            CONCAT( a.HOUR, ' JAM' ) ot,
            a.masuk,
        IF
            (
                a.masuk = IFNULL( b.pulang1, c.pulang2 ),
                NULL,
                IFNULL( b.pulang1, c.pulang2 ) 
            ) pulang,
        CASE
                
                WHEN a.HOUR IS NULL 
                AND (
                    ( a.masuk BETWEEN ADDDATE( a.tIn, INTERVAL - 30 MINUTE ) AND a.tIn ) 
                    OR ( IFNULL( b.pulang1, c.pulang2 ) BETWEEN a.tOut AND ADDDATE( a.tOut, INTERVAL 30 MINUTE ) ) 
                    or ( IFNULL( b.pulang1, c.pulang2 ) BETWEEN a.tIn AND ADDDATE( a.tOut, INTERVAL 30 MINUTE ))
                    ) THEN
                    'BUKAN OT' 
                    WHEN a.HOUR IS NULL 
                    AND (
                        ADDDATE( a.tIn, INTERVAL 30 MINUTE ) > a.masuk 
                        OR ADDDATE( a.tOut, INTERVAL - 30 MINUTE ) < IFNULL( b.pulang1, c.pulang2 ) 
                        ) THEN
                        'TIDAK ADA SPL' 
                        WHEN a.HOUR IS NOT NULL 
                        AND (
                        CASE
                                
                                WHEN a.tIn = a.tIn1 
                                AND a.tOut != a.tOut1 THEN
                                    IFNULL( b.pulang1, c.pulang2 ) < ADDDATE( a.tOut1, INTERVAL - 30 MINUTE ) 
                                END 
                                    ) THEN
                                    CONCAT( 'VALID ', HOUR ( TIMEDIFF( IFNULL( b.pulang1, c.pulang2 ), a.min ) ), ' JAM' ) 
                                    WHEN a.HOUR IS NOT NULL 
                                    AND (
                                    CASE
                                            
                                            WHEN a.tIn != a.tIn1 
                                            AND a.tOut = a.tOut1 THEN
                                                a.masuk > ADDDATE( a.tIn1, INTERVAL 30 MINUTE ) 
                                            END 
                                                ) THEN
                                                CONCAT( 'VALID ', HOUR ( TIMEDIFF( a.min, a.masuk ) ), ' JAM' ) 
                                                WHEN a.HOUR IS NOT NULL 
                                                AND (
                                                CASE
                                                        
                                                        WHEN a.tIn != a.tIn1 
                                                        AND a.tOut != a.tOut1 THEN
                                                            IFNULL( b.pulang1, c.pulang2 ) < ADDDATE( a.tOut1, INTERVAL - 30 MINUTE ) OR a.masuk > ADDDATE( a.tIn1, INTERVAL 30 MINUTE ) 
                                                        END 
                                                            ) THEN
                                                            CONCAT(
                                                                'VALID ',
                                                                HOUR ( TIMEDIFF( IFNULL( b.pulang1, c.pulang2 ), a.min ) ) + HOUR ( TIMEDIFF( a.min, a.masuk ) ),
                                                                ' JAM' 
                                                            ) 
                                                            WHEN a.masuk = IFNULL( b.pulang1, c.pulang2 ) 
                                                            OR ( b.pulang1 IS NULL OR c.pulang2 IS NULL ) THEN
                                                                'Lupa Absen' ELSE 'VALID' 
                                                                END validation 
                    FROM
                        (
                        SELECT
                            a.nik,
                            a.NAME,
                            a.idDept,
                            a.idDiv,
                            a.idWG,
                            a.idPost,
                            a.dt,
                            a.tIn,
                            a.tOut,
                            a.tIn1,
                            a.tOut1,
                            a.min,
                            a.max,
                            a.HOUR,
                            MIN( a.ts ) masuk 
                        FROM
                            (
                            SELECT
                                a.nik,
                                a.NAME,
                                a.idDept,
                                a.idDiv,
                                a.idWG,
                                a.idPost,
                                a.dt,
                                a.ts,
                                a.idTS,
                                a.idGroupShift,
                                spl.HOUR,
                            IF
                                ( a.idTS IS NULL, gs.tIn, ts.tIn ) tIn,
                            IF
                                ( a.idTS IS NULL, gs.tOut, ts.tOut ) tOut,
                                spl.min,
                                spl.max,
                            IF
                                (
                                    spl.min <
                                IF
                                    ( a.idTS IS NULL, gs.tIn, ts.tIn ),
                                    spl.min,
                                IF
                                    ( a.idTS IS NULL, gs.tIn, ts.tIn ) 
                                ) tIn1,
                            IF
                                (
                                    spl.max >
                                IF
                                    ( a.idTS IS NULL, gs.tOut, ts.tOut ),
                                    spl.max,
                                IF
                                    ( a.idTS IS NULL, gs.tOut, ts.tOut ) 
                                ) tOut1 
                            FROM
                                (
                                SELECT DISTINCT
                                    l.NIK nik,
                                    l.NAME NAME,
                                    l.idDept idDept,
                                    l.idDiv idDiv,
                                    l.idWG idWG,
                                    l.idPost idPost,
                                    l.dt dt,
                                    l.ts ts,
                                CASE
                                        
                                        WHEN dt BETWEEN cs.dateStart 
                                        AND cs.dateEnd THEN
                                            cs.idTS ELSE NULL 
                                        END idTS,
                    CASE
                            
                            WHEN dt NOT BETWEEN cs.dateStart 
                            AND cs.dateEnd THEN
                                l.idGroupShift ELSE COALESCE (
                                CASE
                                        
                                        WHEN cs.idTS IS NOT NULL THEN
                                    NULL 
                                    END,
                                CASE
                                        
                                        WHEN cs.idTS IS NOT NULL THEN
                                        NULL ELSE l.idGroupShift 
                                    END 
                                    ) 
                                END idGroupShift 
        FROM
            (
            SELECT
                l.NIK,
                me.NAME,
                me.idDept,
                me.idDiv,
                me.idWG,
                me.idPost,
                TIME( l.enroll ) ts,
                DATE( l.enroll ) dt,
                w.idGroupShift 
            FROM
                mstEmp me
                LEFT JOIN mstWorkgroup w ON me.idWG = w.idWG
                LEFT JOIN attandenceLog l ON me.NIK = l.NIK 
            WHERE
                MONTH ( l.enroll ) = m 
                AND YEAR ( l.enroll ) = y 
                AND me.idDiv = idDiv 
            ) l
            LEFT OUTER JOIN (
            SELECT
                cs.NIK,
            IF
                (
                    ( MONTH ( cs.dateStart ) = m OR YEAR ( cs.dateStart ) = y ),
                    cs.dateStart,
                    DATE( CONCAT( y, '/', m, '/1' ) ) 
                ) dateStart,
            IF
                (
                    ( MONTH ( cs.dateEnd ) = m OR YEAR ( cs.dateEnd ) = y ),
                    cs.dateStart,
                    LAST_DAY( CONCAT( y, '/', m, '/1' ) ) 
                ) dateEnd,
                cs.idTS 
            FROM
                transaksiChangeShift cs 
            WHERE
                ( MONTH ( cs.dateStart ) = m OR MONTH ( cs.dateEnd ) = m ) 
                AND ( YEAR ( cs.dateStart ) = y OR YEAR ( cs.dateEnd ) = y ) 
            ) cs ON l.NIK = cs.NIK 
            ) a
            LEFT JOIN mstGroupShift gs ON a.idGroupShift = gs.idGroupShift 
            AND WEEKDAY( a.dt ) = gs.Idx
            LEFT JOIN mstTimeShifting ts ON a.idTS = ts.idTS
            LEFT JOIN (
            SELECT
                a.NIK_spv AS nik,
                a.date AS dt,
                MIN( a.min ) `min`,
                MAX( a.max ) `max`,
            IF
                (
                    MAX( a.max ) < MIN( a.min ),
                    ( SUM( a.HOUR ) ),
                    MAX( a.HOUR ) 
                ) `hour` 
            FROM
                (
                SELECT
                    sl.idL,
                    sl.NIK_spv,
                    sl.date,
                    sl.idSPL,
                    MIN( sl.START ) min,
                MAX( sl.END ) max,
            HOUR ( TIMEDIFF( MAX( sl.START ), MIN( sl.END ) ) ) HOUR 
        FROM
            LogSuratLembur sl 
        WHERE
            MONTH ( sl.date ) = m 
            AND YEAR ( sl.date ) = y 
            AND sl.approval4 = 1 
            AND sl.idSPL = 1 
        GROUP BY
            sl.idL,
            sl.NIK_spv,
            sl.date UNION ALL
        SELECT
            sl.idL,
            sl.NIK_spv,
            sl.date,
            sl.idSPL,
            MIN( sl.START ) min,
            MAX( sl.END ) max,
            HOUR ( TIMEDIFF( MAX( sl.START ), MIN( sl.END ) ) ) HOUR 
        FROM
            LogSuratLembur sl 
        WHERE
            MONTH ( sl.date ) = m 
            AND YEAR ( sl.date ) = y 
            AND sl.approval4 = 1 
            AND sl.idSPL = 2 
        GROUP BY
            sl.idL,
            sl.NIK_spv,
            sl.date 
            ) a 
        WHERE
            ( a.min ) != ( a.max ) 
        GROUP BY
            a.NIK_spv,
            a.date UNION ALL
        SELECT
            a.nik,
            a.date AS dt,
            MIN( a.min ) `min`,
            MAX( a.max ) `max`,
        IF
            (
                MAX( a.max ) < MIN( a.min ),
                ( SUM( a.HOUR ) ),
                MAX( a.HOUR ) 
            ) `hour` 
        FROM
            (
            SELECT
                sl.idL,
                ms.NIK_op AS nik,
                sl.date,
                sl.idSPL,
                MIN( sl.START ) min,
            MAX( sl.END ) max,
            HOUR ( TIMEDIFF( MAX( sl.START ), MIN( sl.END ) ) ) HOUR 
        FROM
            LogSuratLembur sl
            JOIN LogMemberSPL ms ON sl.idL = ms.idL 
        WHERE
            MONTH ( sl.date ) = m 
            AND YEAR ( sl.date ) = y 
            AND sl.approval4 = 1 
            AND sl.idSPL = 1 
        GROUP BY
            sl.idL,
            nik,
            sl.date UNION ALL
        SELECT
            sl.idL,
            ms.NIK_op AS nik,
            sl.date,
            sl.idSPL,
            MIN( sl.START ) min,
            MAX( sl.END ) max,
            HOUR ( TIMEDIFF( MAX( sl.START ), MIN( sl.END ) ) ) HOUR 
        FROM
            LogSuratLembur sl
            JOIN LogMemberSPL ms ON sl.idL = ms.idL 
        WHERE
            MONTH ( sl.date ) = m 
            AND YEAR ( sl.date ) = y 
            AND sl.approval4 = 1 
            AND sl.idSPL = 2 
        GROUP BY
            sl.idL,
            nik,
            sl.date 
            ) a 
        WHERE
            ( a.min ) != ( a.max ) 
        GROUP BY
            a.nik,
            a.date 
        ORDER BY
            dt ASC 
            ) spl ON a.nik = spl.NIK 
            AND a.dt = spl.dt 
        ORDER BY
            a.nik,
            a.dt 
            ) a 
        WHERE
            a.ts BETWEEN ADDDATE( IFNULL( a.tIn1, time( '00:00:00' ) ), INTERVAL - 90 MINUTE ) 
            AND IFNULL( a.tOut1, time( '23:59:59' ) ) 
        GROUP BY
            a.nik,
            a.NAME,
            a.idDept,
            a.idDiv,
            a.idWG,
            a.idPost,
            a.dt,
            a.tIn1,
            a.tOut1,
            a.HOUR,
            a.tIn,
            a.tOut,
            a.min,
            a.max 
            ) a
            LEFT JOIN (
            SELECT
                a.nik,
                a.NAME,
                a.dt,
                a.tIn1,
                a.tOut1,
                MAX( a.ts ) pulang1 
            FROM
                (
                SELECT
                    a.nik,
                    a.NAME,
                    a.dt,
                    a.ts,
                    a.idTS,
                    a.idGroupShift,
                IF
                    (
                        spl.min <
                    IF
                        ( a.idTS IS NULL, gs.tIn, ts.tIn ),
                        spl.min,
                    IF
                        ( a.idTS IS NULL, gs.tIn, ts.tIn ) 
                    ) tIn1,
                IF
                    (
                        spl.max >
                    IF
                        ( a.idTS IS NULL, gs.tOut, ts.tOut ),
                        spl.max,
                    IF
                        ( a.idTS IS NULL, gs.tOut, ts.tOut ) 
                    ) tOut1 
                FROM
                    (
                    SELECT DISTINCT
                        l.NIK nik,
                        l.NAME NAME,
                        l.dt dt,
                        l.ts ts,
                    CASE
                            
                            WHEN dt BETWEEN cs.dateStart 
                            AND cs.dateEnd THEN
                                cs.idTS ELSE NULL 
                            END idTS,
        CASE
                
                WHEN dt NOT BETWEEN cs.dateStart 
                AND cs.dateEnd THEN
                    l.idGroupShift ELSE COALESCE (
                    CASE
                            
                            WHEN cs.idTS IS NOT NULL THEN
                        NULL 
                        END,
                    CASE
                            
                            WHEN cs.idTS IS NOT NULL THEN
                            NULL ELSE l.idGroupShift 
                        END 
                        ) 
                    END idGroupShift 
        FROM
            (
            SELECT
                l.NIK,
                me.NAME,
                TIME( l.enroll ) ts,
                DATE( l.enroll ) dt,
                w.idGroupShift 
            FROM
                mstEmp me
                LEFT JOIN mstWorkgroup w ON me.idWG = w.idWG
                LEFT JOIN attandenceLog l ON me.NIK = l.NIK 
            WHERE
                MONTH ( l.enroll ) = m 
                AND YEAR ( l.enroll ) = y 
                AND me.idDiv = idDiv 
            ) l
            LEFT OUTER JOIN (
            SELECT
                cs.NIK,
            IF
                (
                    ( MONTH ( cs.dateStart ) = m OR YEAR ( cs.dateStart ) = y ),
                    cs.dateStart,
                    DATE( CONCAT( y, '/', m, '/1' ) ) 
                ) dateStart,
            IF
                (
                    ( MONTH ( cs.dateEnd ) = m OR YEAR ( cs.dateEnd ) = y ),
                    cs.dateStart,
                    LAST_DAY( CONCAT( y, '/', m, '/1' ) ) 
                ) dateEnd,
                cs.idTS 
            FROM
                transaksiChangeShift cs 
            WHERE
                ( MONTH ( cs.dateStart ) = m OR MONTH ( cs.dateEnd ) = m ) 
                AND ( YEAR ( cs.dateStart ) = y OR YEAR ( cs.dateEnd ) = y ) 
            ) cs ON l.NIK = cs.NIK 
            ) a
            LEFT JOIN mstGroupShift gs ON a.idGroupShift = gs.idGroupShift 
            AND WEEKDAY( a.dt ) = gs.Idx
            LEFT JOIN mstTimeShifting ts ON a.idTS = ts.idTS
            LEFT JOIN (
            SELECT
                a.NIK_spv AS nik,
                a.date AS dt,
                MIN( a.min ) `min`,
                MAX( a.max ) `max` 
            FROM
                (
                SELECT
                    sl.idL,
                    sl.NIK_spv,
                    sl.date,
                    sl.idSPL,
                    MIN( sl.START ) min,
                MAX( sl.END ) max 
            FROM
                LogSuratLembur sl 
            WHERE
                MONTH ( sl.date ) = m 
                AND YEAR ( sl.date ) = y 
                AND sl.approval4 = 1 
                AND sl.idSPL = 1 
            GROUP BY
                sl.idL,
                sl.NIK_spv,
                sl.date UNION ALL
            SELECT
                sl.idL,
                sl.NIK_spv,
                sl.date,
                sl.idSPL,
                MIN( sl.START ) min,
            MAX( sl.END ) max 
        FROM
            LogSuratLembur sl 
        WHERE
            MONTH ( sl.date ) = m 
            AND YEAR ( sl.date ) = y 
            AND sl.approval4 = 1 
            AND sl.idSPL = 2 
        GROUP BY
            sl.idL,
            sl.NIK_spv,
            sl.date 
            ) a 
        WHERE
            ( a.min ) != ( a.max ) 
        GROUP BY
            a.NIK_spv,
            a.date UNION ALL
        SELECT
            a.nik,
            a.date AS dt,
            MIN( a.min ) `min`,
            MAX( a.max ) `max` 
        FROM
            (
            SELECT
                sl.idL,
                ms.NIK_op AS nik,
                sl.date,
                sl.idSPL,
                MIN( sl.START ) min,
            MAX( sl.END ) max 
        FROM
            LogSuratLembur sl
            JOIN LogMemberSPL ms ON sl.idL = ms.idL 
        WHERE
            MONTH ( sl.date ) = m 
            AND YEAR ( sl.date ) = y 
            AND sl.approval4 = 1 
            AND sl.idSPL = 1 
        GROUP BY
            sl.idL,
            nik,
            sl.date UNION ALL
        SELECT
            sl.idL,
            ms.NIK_op AS nik,
            sl.date,
            sl.idSPL,
            MIN( sl.START ) min,
            MAX( sl.END ) max 
        FROM
            LogSuratLembur sl
            JOIN LogMemberSPL ms ON sl.idL = ms.idL 
        WHERE
            MONTH ( sl.date ) = m 
            AND YEAR ( sl.date ) = y 
            AND sl.approval4 = 1 
            AND sl.idSPL = 2 
        GROUP BY
            sl.idL,
            nik,
            sl.date 
            ) a 
        WHERE
            ( a.min ) != ( a.max ) 
        GROUP BY
            a.nik,
            a.date 
        ORDER BY
            dt ASC 
            ) spl ON a.nik = spl.NIK 
            AND a.dt = spl.dt 
        ORDER BY
            a.nik,
            a.dt 
            ) a 
        WHERE
            a.ts BETWEEN a.tIn1 
            AND TIME( '23:59:59' ) 
            AND a.tOut1 < TIME( '23:59:59' ) 
        GROUP BY
            a.nik,
            a.NAME,
            a.dt,
            a.tIn1,
            a.tOut1 
            ) b ON a.nik = b.nik 
            AND a.dt = b.dt
            LEFT JOIN (
            SELECT
                a.nik,
                a.NAME,
                ADDDATE( a.dt, INTERVAL - 1 DAY ) dt,
                a.tIn1,
                a.tOut1,
                MIN( a.ts ) pulang2 
            FROM
                (
                SELECT
                    a.nik,
                    a.NAME,
                    a.dt,
                    a.ts,
                    a.idTS,
                    a.idGroupShift,
                IF
                    (
                        spl.min <
                    IF
                        ( a.idTS IS NULL, gs.tIn, ts.tIn ),
                        spl.min,
                    IF
                        ( a.idTS IS NULL, gs.tIn, ts.tIn ) 
                    ) tIn1,
                IF
                    (
                        spl.max >
                    IF
                        ( a.idTS IS NULL, gs.tOut, ts.tOut ),
                        spl.max,
                    IF
                        ( a.idTS IS NULL, gs.tOut, ts.tOut ) 
                    ) tOut1 
                FROM
                    (
                    SELECT DISTINCT
                        l.NIK nik,
                        l.NAME NAME,
                        l.dt dt,
                        l.ts ts,
                    CASE
                            
                            WHEN dt BETWEEN cs.dateStart 
                            AND cs.dateEnd THEN
                                cs.idTS ELSE NULL 
                            END idTS,
        CASE
                
                WHEN dt NOT BETWEEN cs.dateStart 
                AND cs.dateEnd THEN
                    l.idGroupShift ELSE COALESCE (
                    CASE
                            
                            WHEN cs.idTS IS NOT NULL THEN
                        NULL 
                        END,
                    CASE
                            
                            WHEN cs.idTS IS NOT NULL THEN
                            NULL ELSE l.idGroupShift 
                        END 
                        ) 
                    END idGroupShift 
        FROM
            (
            SELECT
                l.NIK,
                me.NAME,
                TIME( l.enroll ) ts,
                DATE( l.enroll ) dt,
                w.idGroupShift 
            FROM
                mstEmp me
                LEFT JOIN mstWorkgroup w ON me.idWG = w.idWG
                LEFT JOIN attandenceLog l ON me.NIK = l.NIK 
            WHERE
                MONTH ( l.enroll ) = m 
                AND YEAR ( l.enroll ) = y 
                AND me.idDiv = idDiv 
            ) l
            LEFT OUTER JOIN (
            SELECT
                cs.NIK,
            IF
                (
                    ( MONTH ( cs.dateStart ) = m OR YEAR ( cs.dateStart ) = y ),
                    cs.dateStart,
                    DATE( CONCAT( y, '/', m, '/1' ) ) 
                ) dateStart,
            IF
                (
                    ( MONTH ( cs.dateEnd ) = m OR YEAR ( cs.dateEnd ) = y ),
                    cs.dateStart,
                    LAST_DAY( CONCAT( y, '/', m, '/1' ) ) 
                ) dateEnd,
                cs.idTS 
            FROM
                transaksiChangeShift cs 
            WHERE
                ( MONTH ( cs.dateStart ) = m OR MONTH ( cs.dateEnd ) = m ) 
                AND ( YEAR ( cs.dateStart ) = y OR YEAR ( cs.dateEnd ) = y ) 
            ) cs ON l.NIK = cs.NIK 
            ) a
            LEFT JOIN mstGroupShift gs ON a.idGroupShift = gs.idGroupShift 
            AND WEEKDAY( a.dt ) = gs.Idx
            LEFT JOIN mstTimeShifting ts ON a.idTS = ts.idTS
            LEFT JOIN (
            SELECT
                a.NIK_spv AS nik,
                a.date AS dt,
                MIN( a.min ) `min`,
                MAX( a.max ) `max` 
            FROM
                (
                SELECT
                    sl.idL,
                    sl.NIK_spv,
                    sl.date,
                    sl.idSPL,
                    MIN( sl.START ) min,
                MAX( sl.END ) max 
            FROM
                LogSuratLembur sl 
            WHERE
                MONTH ( sl.date ) = m 
                AND YEAR ( sl.date ) = y 
                AND sl.approval4 = 1 
                AND sl.idSPL = 1 
            GROUP BY
                sl.idL,
                sl.NIK_spv,
                sl.date UNION ALL
            SELECT
                sl.idL,
                sl.NIK_spv,
                sl.date,
                sl.idSPL,
                MIN( sl.START ) min,
            MAX( sl.END ) max 
        FROM
            LogSuratLembur sl 
        WHERE
            MONTH ( sl.date ) = m 
            AND YEAR ( sl.date ) = y 
            AND sl.approval4 = 1 
            AND sl.idSPL = 2 
        GROUP BY
            sl.idL,
            sl.NIK_spv,
            sl.date 
            ) a 
        WHERE
            ( a.min ) != ( a.max ) 
        GROUP BY
            a.NIK_spv,
            a.date UNION ALL
        SELECT
            a.nik,
            a.date AS dt,
            MIN( a.min ) `min`,
            MAX( a.max ) `max` 
        FROM
            (
            SELECT
                sl.idL,
                ms.NIK_op AS nik,
                sl.date,
                sl.idSPL,
                MIN( sl.START ) min,
            MAX( sl.END ) max 
        FROM
            LogSuratLembur sl
            JOIN LogMemberSPL ms ON sl.idL = ms.idL 
        WHERE
            MONTH ( sl.date ) = m 
            AND YEAR ( sl.date ) = y 
            AND sl.approval4 = 1 
            AND sl.idSPL = 1 
        GROUP BY
            sl.idL,
            nik,
            sl.date UNION ALL
        SELECT
            sl.idL,
            ms.NIK_op AS nik,
            sl.date,
            sl.idSPL,
            MIN( sl.START ) min,
            MAX( sl.END ) max 
        FROM
            LogSuratLembur sl
            JOIN LogMemberSPL ms ON sl.idL = ms.idL 
        WHERE
            MONTH ( sl.date ) = m 
            AND YEAR ( sl.date ) = y 
            AND sl.approval4 = 1 
            AND sl.idSPL = 2 
        GROUP BY
            sl.idL,
            nik,
            sl.date 
            ) a 
        WHERE
            ( a.min ) != ( a.max ) 
        GROUP BY
            a.nik,
            a.date 
        ORDER BY
            dt ASC 
            ) spl ON a.nik = spl.NIK 
            AND a.dt = spl.dt 
        ORDER BY
            a.nik,
            a.dt 
            ) a 
        WHERE
            a.ts BETWEEN TIME( '00:00:00' ) 
            AND a.tIn1 
            AND a.tOut1 BETWEEN TIME( '00:00:00' ) 
            AND TIME( '10:30:00' ) 
        GROUP BY
            a.nik,
            a.NAME,
            a.dt,
            a.tIn1,
            a.tOut1 
            ) c ON a.nik = c.nik 
            AND a.dt = c.dt
            LEFT JOIN mstDept d ON d.idDept = a.idDept
            LEFT JOIN mstDiv d1 ON d1.idDiv = a.idDiv
            LEFT JOIN mstWorkgroup w1 ON w1.idWG = a.idWG
            LEFT JOIN mstPost p ON p.idPost = a.idPost 
        ORDER BY
            a.idPost,
            a.nik,
            a.dt;
        
        ELSEIF idDept IS NOT NULL THEN
        SELECT
            a.nik,
            a.NAME,
            p.`position`,
            d.dept,
            d1.division,
            w1.Workgroup,
            DAYNAME( a.dt ) `day`,
            a.dt,
            a.tIn1,
            a.tOut,
            a.tOut1,
            CONCAT( a.HOUR, ' JAM' ) ot,
            a.masuk,
        IF
            (
                a.masuk = IFNULL( b.pulang1, c.pulang2 ),
                NULL,
                IFNULL( b.pulang1, c.pulang2 ) 
            ) pulang,
        CASE
                
                WHEN a.HOUR IS NULL 
                AND (
                    ( a.masuk BETWEEN ADDDATE( a.tIn, INTERVAL - 30 MINUTE ) AND a.tIn ) 
                    OR ( IFNULL( b.pulang1, c.pulang2 ) BETWEEN a.tOut AND ADDDATE( a.tOut, INTERVAL 30 MINUTE ) ) 
                    or ( IFNULL( b.pulang1, c.pulang2 ) BETWEEN a.tIn AND ADDDATE( a.tOut, INTERVAL 30 MINUTE ))
                    ) THEN
                    'BUKAN OT' 
                    WHEN a.HOUR IS NULL 
                    AND (
                        ADDDATE( a.tIn, INTERVAL 30 MINUTE ) > a.masuk 
                        OR ADDDATE( a.tOut, INTERVAL - 30 MINUTE ) < IFNULL( b.pulang1, c.pulang2 ) 
                        ) THEN
                        'TIDAK ADA SPL' 
                        WHEN a.HOUR IS NOT NULL 
                        AND (
                        CASE
                                
                                WHEN a.tIn = a.tIn1 
                                AND a.tOut != a.tOut1 THEN
                                    IFNULL( b.pulang1, c.pulang2 ) < ADDDATE( a.tOut1, INTERVAL - 30 MINUTE ) 
                                END 
                                    ) THEN
                                    CONCAT( 'VALID ', HOUR ( TIMEDIFF( IFNULL( b.pulang1, c.pulang2 ), a.min ) ), ' JAM' ) 
                                    WHEN a.HOUR IS NOT NULL 
                                    AND (
                                    CASE
                                            
                                            WHEN a.tIn != a.tIn1 
                                            AND a.tOut = a.tOut1 THEN
                                                a.masuk > ADDDATE( a.tIn1, INTERVAL 30 MINUTE ) 
                                            END 
                                                ) THEN
                                                CONCAT( 'VALID ', HOUR ( TIMEDIFF( a.min, a.masuk ) ), ' JAM' ) 
                                                WHEN a.HOUR IS NOT NULL 
                                                AND (
                                                CASE
                                                        
                                                        WHEN a.tIn != a.tIn1 
                                                        AND a.tOut != a.tOut1 THEN
                                                            IFNULL( b.pulang1, c.pulang2 ) < ADDDATE( a.tOut1, INTERVAL - 30 MINUTE ) OR a.masuk > ADDDATE( a.tIn1, INTERVAL 30 MINUTE ) 
                                                        END 
                                                            ) THEN
                                                            CONCAT(
                                                                'VALID ',
                                                                HOUR ( TIMEDIFF( IFNULL( b.pulang1, c.pulang2 ), a.min ) ) + HOUR ( TIMEDIFF( a.min, a.masuk ) ),
                                                                ' JAM' 
                                                            ) 
                                                            WHEN a.masuk = IFNULL( b.pulang1, c.pulang2 ) 
                                                            OR IFNULL( b.pulang1, c.pulang2 ) IS NULL THEN
                                                                'Lupa Absen' ELSE 'VALID' 
                                                                END validation 
                    FROM
                        (
                        SELECT
                            a.nik,
                            a.NAME,
                            a.idDept,
                            a.idDiv,
                            a.idWG,
                            a.idPost,
                            a.dt,
                            a.tIn,
                            a.tOut,
                            a.tIn1,
                            a.tOut1,
                            a.min,
                            a.max,
                            a.HOUR,
                            MIN( a.ts ) masuk 
                        FROM
                            (
                            SELECT
                                a.nik,
                                a.NAME,
                                a.idDept,
                                a.idDiv,
                                a.idWG,
                                a.idPost,
                                a.dt,
                                a.ts,
                                a.idTS,
                                a.idGroupShift,
                                spl.HOUR,
                            IF
                                ( a.idTS IS NULL, gs.tIn, ts.tIn ) tIn,
                            IF
                                ( a.idTS IS NULL, gs.tOut, ts.tOut ) tOut,
                                spl.min,
                                spl.max,
                            IF
                                (
                                    spl.min <
                                IF
                                    ( a.idTS IS NULL, gs.tIn, ts.tIn ),
                                    spl.min,
                                IF
                                    ( a.idTS IS NULL, gs.tIn, ts.tIn ) 
                                ) tIn1,
                            IF
                                (
                                    spl.max >
                                IF
                                    ( a.idTS IS NULL, gs.tOut, ts.tOut ),
                                    spl.max,
                                IF
                                    ( a.idTS IS NULL, gs.tOut, ts.tOut ) 
                                ) tOut1 
                            FROM
                                (
                                SELECT DISTINCT
                                    l.NIK nik,
                                    l.NAME NAME,
                                    l.idDept idDept,
                                    l.idDiv idDiv,
                                    l.idWG idWG,
                                    l.idPost idPost,
                                    l.dt dt,
                                    l.ts ts,
                                CASE
                                        
                                        WHEN dt BETWEEN cs.dateStart 
                                        AND cs.dateEnd THEN
                                            cs.idTS ELSE NULL 
                                        END idTS,
                    CASE
                            
                            WHEN dt NOT BETWEEN cs.dateStart 
                            AND cs.dateEnd THEN
                                l.idGroupShift ELSE COALESCE (
                                CASE
                                        
                                        WHEN cs.idTS IS NOT NULL THEN
                                    NULL 
                                    END,
                                CASE
                                        
                                        WHEN cs.idTS IS NOT NULL THEN
                                        NULL ELSE l.idGroupShift 
                                    END 
                                    ) 
                                END idGroupShift 
        FROM
            (
            SELECT
                l.NIK,
                me.NAME,
                me.idDept,
                me.idDiv,
                me.idWG,
                me.idPost,
                TIME( l.enroll ) ts,
                DATE( l.enroll ) dt,
                w.idGroupShift 
            FROM
                mstEmp me
                LEFT JOIN mstWorkgroup w ON me.idWG = w.idWG
                LEFT JOIN attandenceLog l ON me.NIK = l.NIK 
            WHERE
                MONTH ( l.enroll ) = m 
                AND YEAR ( l.enroll ) = y 
                AND me.idDept = idDept 
            ) l
            LEFT OUTER JOIN (
            SELECT
                cs.NIK,
            IF
                (
                    ( MONTH ( cs.dateStart ) = m OR YEAR ( cs.dateStart ) = y ),
                    cs.dateStart,
                    DATE( CONCAT( y, '/', m, '/1' ) ) 
                ) dateStart,
            IF
                (
                    ( MONTH ( cs.dateEnd ) = m OR YEAR ( cs.dateEnd ) = y ),
                    cs.dateStart,
                    LAST_DAY( CONCAT( y, '/', m, '/1' ) ) 
                ) dateEnd,
                cs.idTS 
            FROM
                transaksiChangeShift cs 
            WHERE
                ( MONTH ( cs.dateStart ) = m OR MONTH ( cs.dateEnd ) = m ) 
                AND ( YEAR ( cs.dateStart ) = y OR YEAR ( cs.dateEnd ) = y ) 
            ) cs ON l.NIK = cs.NIK 
            ) a
            LEFT JOIN mstGroupShift gs ON a.idGroupShift = gs.idGroupShift 
            AND WEEKDAY( a.dt ) = gs.Idx
            LEFT JOIN mstTimeShifting ts ON a.idTS = ts.idTS
            LEFT JOIN (
            SELECT
                a.NIK_spv AS nik,
                a.date AS dt,
                MIN( a.min ) `min`,
                MAX( a.max ) `max`,
            IF
                (
                    MAX( a.max ) < MIN( a.min ),
                    ( SUM( a.HOUR ) ),
                    MAX( a.HOUR ) 
                ) `hour` 
            FROM
                (
                SELECT
                    sl.idL,
                    sl.NIK_spv,
                    sl.date,
                    sl.idSPL,
                    MIN( sl.START ) min,
                MAX( sl.END ) max,
            HOUR ( TIMEDIFF( MAX( sl.START ), MIN( sl.END ) ) ) HOUR 
        FROM
            LogSuratLembur sl 
        WHERE
            MONTH ( sl.date ) = m 
            AND YEAR ( sl.date ) = y 
            AND sl.approval4 = 1 
            AND sl.idSPL = 1 
        GROUP BY
            sl.idL,
            sl.NIK_spv,
            sl.date UNION ALL
        SELECT
            sl.idL,
            sl.NIK_spv,
            sl.date,
            sl.idSPL,
            MIN( sl.START ) min,
            MAX( sl.END ) max,
            HOUR ( TIMEDIFF( MAX( sl.START ), MIN( sl.END ) ) ) HOUR 
        FROM
            LogSuratLembur sl 
        WHERE
            MONTH ( sl.date ) = m 
            AND YEAR ( sl.date ) = y 
            AND sl.approval4 = 1 
            AND sl.idSPL = 2 
        GROUP BY
            sl.idL,
            sl.NIK_spv,
            sl.date 
            ) a 
        WHERE
            ( a.min ) != ( a.max ) 
        GROUP BY
            a.NIK_spv,
            a.date UNION ALL
        SELECT
            a.nik,
            a.date AS dt,
            MIN( a.min ) `min`,
            MAX( a.max ) `max`,
        IF
            (
                MAX( a.max ) < MIN( a.min ),
                ( SUM( a.HOUR ) ),
                MAX( a.HOUR ) 
            ) `hour` 
        FROM
            (
            SELECT
                sl.idL,
                ms.NIK_op AS nik,
                sl.date,
                sl.idSPL,
                MIN( sl.START ) min,
            MAX( sl.END ) max,
            HOUR ( TIMEDIFF( MAX( sl.START ), MIN( sl.END ) ) ) HOUR 
        FROM
            LogSuratLembur sl
            JOIN LogMemberSPL ms ON sl.idL = ms.idL 
        WHERE
            MONTH ( sl.date ) = m 
            AND YEAR ( sl.date ) = y 
            AND sl.approval4 = 1 
            AND sl.idSPL = 1 
        GROUP BY
            sl.idL,
            nik,
            sl.date UNION ALL
        SELECT
            sl.idL,
            ms.NIK_op AS nik,
            sl.date,
            sl.idSPL,
            MIN( sl.START ) min,
            MAX( sl.END ) max,
            HOUR ( TIMEDIFF( MAX( sl.START ), MIN( sl.END ) ) ) HOUR 
        FROM
            LogSuratLembur sl
            JOIN LogMemberSPL ms ON sl.idL = ms.idL 
        WHERE
            MONTH ( sl.date ) = m 
            AND YEAR ( sl.date ) = y 
            AND sl.approval4 = 1 
            AND sl.idSPL = 2 
        GROUP BY
            sl.idL,
            nik,
            sl.date 
            ) a 
        WHERE
            ( a.min ) != ( a.max ) 
        GROUP BY
            a.nik,
            a.date 
        ORDER BY
            dt ASC 
            ) spl ON a.nik = spl.NIK 
            AND a.dt = spl.dt 
        ORDER BY
            a.nik,
            a.dt 
            ) a 
        WHERE
            a.ts BETWEEN ADDDATE( IFNULL( a.tIn1, time( '00:00:00' ) ), INTERVAL - 90 MINUTE ) 
            AND IFNULL( a.tOut1, time( '23:59:59' ) ) 
        GROUP BY
            a.nik,
            a.NAME,
            a.idDept,
            a.idDiv,
            a.idWG,
            a.idPost,
            a.dt,
            a.tIn1,
            a.tOut1,
            a.HOUR,
            a.tIn,
            a.tOut,
            a.min,
            a.max 
            ) a
            LEFT JOIN (
            SELECT
                a.nik,
                a.NAME,
                a.dt,
                a.tIn1,
                a.tOut1,
                MAX( a.ts ) pulang1 
            FROM
                (
                SELECT
                    a.nik,
                    a.NAME,
                    a.dt,
                    a.ts,
                    a.idTS,
                    a.idGroupShift,
                IF
                    (
                        spl.min <
                    IF
                        ( a.idTS IS NULL, gs.tIn, ts.tIn ),
                        spl.min,
                    IF
                        ( a.idTS IS NULL, gs.tIn, ts.tIn ) 
                    ) tIn1,
                IF
                    (
                        spl.max >
                    IF
                        ( a.idTS IS NULL, gs.tOut, ts.tOut ),
                        spl.max,
                    IF
                        ( a.idTS IS NULL, gs.tOut, ts.tOut ) 
                    ) tOut1 
                FROM
                    (
                    SELECT DISTINCT
                        l.NIK nik,
                        l.NAME NAME,
                        l.dt dt,
                        l.ts ts,
                    CASE
                            
                            WHEN dt BETWEEN cs.dateStart 
                            AND cs.dateEnd THEN
                                cs.idTS ELSE NULL 
                            END idTS,
        CASE
                
                WHEN dt NOT BETWEEN cs.dateStart 
                AND cs.dateEnd THEN
                    l.idGroupShift ELSE COALESCE (
                    CASE
                            
                            WHEN cs.idTS IS NOT NULL THEN
                        NULL 
                        END,
                    CASE
                            
                            WHEN cs.idTS IS NOT NULL THEN
                            NULL ELSE l.idGroupShift 
                        END 
                        ) 
                    END idGroupShift 
        FROM
            (
            SELECT
                l.NIK,
                me.NAME,
                TIME( l.enroll ) ts,
                DATE( l.enroll ) dt,
                w.idGroupShift 
            FROM
                mstEmp me
                LEFT JOIN mstWorkgroup w ON me.idWG = w.idWG
                LEFT JOIN attandenceLog l ON me.NIK = l.NIK 
            WHERE
                MONTH ( l.enroll ) = m 
                AND YEAR ( l.enroll ) = y 
                AND me.idDept = idDept 
            ) l
            LEFT OUTER JOIN (
            SELECT
                cs.NIK,
            IF
                (
                    ( MONTH ( cs.dateStart ) = m OR YEAR ( cs.dateStart ) = y ),
                    cs.dateStart,
                    DATE( CONCAT( y, '/', m, '/1' ) ) 
                ) dateStart,
            IF
                (
                    ( MONTH ( cs.dateEnd ) = m OR YEAR ( cs.dateEnd ) = y ),
                    cs.dateStart,
                    LAST_DAY( CONCAT( y, '/', m, '/1' ) ) 
                ) dateEnd,
                cs.idTS 
            FROM
                transaksiChangeShift cs 
            WHERE
                ( MONTH ( cs.dateStart ) = m OR MONTH ( cs.dateEnd ) = m ) 
                AND ( YEAR ( cs.dateStart ) = y OR YEAR ( cs.dateEnd ) = y ) 
            ) cs ON l.NIK = cs.NIK 
            ) a
            LEFT JOIN mstGroupShift gs ON a.idGroupShift = gs.idGroupShift 
            AND WEEKDAY( a.dt ) = gs.Idx
            LEFT JOIN mstTimeShifting ts ON a.idTS = ts.idTS
            LEFT JOIN (
            SELECT
                a.NIK_spv AS nik,
                a.date AS dt,
                MIN( a.min ) `min`,
                MAX( a.max ) `max` 
            FROM
                (
                SELECT
                    sl.idL,
                    sl.NIK_spv,
                    sl.date,
                    sl.idSPL,
                    MIN( sl.START ) min,
                MAX( sl.END ) max 
            FROM
                LogSuratLembur sl 
            WHERE
                MONTH ( sl.date ) = m 
                AND YEAR ( sl.date ) = y 
                AND sl.approval4 = 1 
                AND sl.idSPL = 1 
            GROUP BY
                sl.idL,
                sl.NIK_spv,
                sl.date UNION ALL
            SELECT
                sl.idL,
                sl.NIK_spv,
                sl.date,
                sl.idSPL,
                MIN( sl.START ) min,
            MAX( sl.END ) max 
        FROM
            LogSuratLembur sl 
        WHERE
            MONTH ( sl.date ) = m 
            AND YEAR ( sl.date ) = y 
            AND sl.approval4 = 1 
            AND sl.idSPL = 2 
        GROUP BY
            sl.idL,
            sl.NIK_spv,
            sl.date 
            ) a 
        WHERE
            ( a.min ) != ( a.max ) 
        GROUP BY
            a.NIK_spv,
            a.date UNION ALL
        SELECT
            a.nik,
            a.date AS dt,
            MIN( a.min ) `min`,
            MAX( a.max ) `max` 
        FROM
            (
            SELECT
                sl.idL,
                ms.NIK_op AS nik,
                sl.date,
                sl.idSPL,
                MIN( sl.START ) min,
            MAX( sl.END ) max 
        FROM
            LogSuratLembur sl
            JOIN LogMemberSPL ms ON sl.idL = ms.idL 
        WHERE
            MONTH ( sl.date ) = m 
            AND YEAR ( sl.date ) = y 
            AND sl.approval4 = 1 
            AND sl.idSPL = 1 
        GROUP BY
            sl.idL,
            nik,
            sl.date UNION ALL
        SELECT
            sl.idL,
            ms.NIK_op AS nik,
            sl.date,
            sl.idSPL,
            MIN( sl.START ) min,
            MAX( sl.END ) max 
        FROM
            LogSuratLembur sl
            JOIN LogMemberSPL ms ON sl.idL = ms.idL 
        WHERE
            MONTH ( sl.date ) = m 
            AND YEAR ( sl.date ) = y 
            AND sl.approval4 = 1 
            AND sl.idSPL = 2 
        GROUP BY
            sl.idL,
            nik,
            sl.date 
            ) a 
        WHERE
            ( a.min ) != ( a.max ) 
        GROUP BY
            a.nik,
            a.date 
        ORDER BY
            dt ASC 
            ) spl ON a.nik = spl.NIK 
            AND a.dt = spl.dt 
        ORDER BY
            a.nik,
            a.dt 
            ) a 
        WHERE
            a.ts BETWEEN a.tIn1 
            AND TIME( '23:59:59' ) 
            AND a.tOut1 < TIME( '23:59:59' ) 
        GROUP BY
            a.nik,
            a.NAME,
            a.dt,
            a.tIn1,
            a.tOut1 
            ) b ON a.nik = b.nik 
            AND a.dt = b.dt
            LEFT JOIN (
            SELECT
                a.nik,
                a.NAME,
                ADDDATE( a.dt, INTERVAL - 1 DAY ) dt,
                a.tIn1,
                a.tOut1,
                MIN( a.ts ) pulang2 
            FROM
                (
                SELECT
                    a.nik,
                    a.NAME,
                    a.dt,
                    a.ts,
                    a.idTS,
                    a.idGroupShift,
                IF
                    (
                        spl.min <
                    IF
                        ( a.idTS IS NULL, gs.tIn, ts.tIn ),
                        spl.min,
                    IF
                        ( a.idTS IS NULL, gs.tIn, ts.tIn ) 
                    ) tIn1,
                IF
                    (
                        spl.max >
                    IF
                        ( a.idTS IS NULL, gs.tOut, ts.tOut ),
                        spl.max,
                    IF
                        ( a.idTS IS NULL, gs.tOut, ts.tOut ) 
                    ) tOut1 
                FROM
                    (
                    SELECT DISTINCT
                        l.NIK nik,
                        l.NAME NAME,
                        l.dt dt,
                        l.ts ts,
                    CASE
                            
                            WHEN dt BETWEEN cs.dateStart 
                            AND cs.dateEnd THEN
                                cs.idTS ELSE NULL 
                            END idTS,
        CASE
                
                WHEN dt NOT BETWEEN cs.dateStart 
                AND cs.dateEnd THEN
                    l.idGroupShift ELSE COALESCE (
                    CASE
                            
                            WHEN cs.idTS IS NOT NULL THEN
                        NULL 
                        END,
                    CASE
                            
                            WHEN cs.idTS IS NOT NULL THEN
                            NULL ELSE l.idGroupShift 
                        END 
                        ) 
                    END idGroupShift 
        FROM
            (
            SELECT
                l.NIK,
                me.NAME,
                TIME( l.enroll ) ts,
                DATE( l.enroll ) dt,
                w.idGroupShift 
            FROM
                mstEmp me
                LEFT JOIN mstWorkgroup w ON me.idWG = w.idWG
                LEFT JOIN attandenceLog l ON me.NIK = l.NIK 
            WHERE
                MONTH ( l.enroll ) = m 
                AND YEAR ( l.enroll ) = y 
                AND me.idDept = idDept 
            ) l
            LEFT OUTER JOIN (
            SELECT
                cs.NIK,
            IF
                (
                    ( MONTH ( cs.dateStart ) = m OR YEAR ( cs.dateStart ) = y ),
                    cs.dateStart,
                    DATE( CONCAT( y, '/', m, '/1' ) ) 
                ) dateStart,
            IF
                (
                    ( MONTH ( cs.dateEnd ) = m OR YEAR ( cs.dateEnd ) = y ),
                    cs.dateStart,
                    LAST_DAY( CONCAT( y, '/', m, '/1' ) ) 
                ) dateEnd,
                cs.idTS 
            FROM
                transaksiChangeShift cs 
            WHERE
                ( MONTH ( cs.dateStart ) = m OR MONTH ( cs.dateEnd ) = m ) 
                AND ( YEAR ( cs.dateStart ) = y OR YEAR ( cs.dateEnd ) = y ) 
            ) cs ON l.NIK = cs.NIK 
            ) a
            LEFT JOIN mstGroupShift gs ON a.idGroupShift = gs.idGroupShift 
            AND WEEKDAY( a.dt ) = gs.Idx
            LEFT JOIN mstTimeShifting ts ON a.idTS = ts.idTS
            LEFT JOIN (
            SELECT
                a.NIK_spv AS nik,
                a.date AS dt,
                MIN( a.min ) `min`,
                MAX( a.max ) `max` 
            FROM
                (
                SELECT
                    sl.idL,
                    sl.NIK_spv,
                    sl.date,
                    sl.idSPL,
                    MIN( sl.START ) min,
                MAX( sl.END ) max 
            FROM
                LogSuratLembur sl 
            WHERE
                MONTH ( sl.date ) = m 
                AND YEAR ( sl.date ) = y 
                AND sl.approval4 = 1 
                AND sl.idSPL = 1 
            GROUP BY
                sl.idL,
                sl.NIK_spv,
                sl.date UNION ALL
            SELECT
                sl.idL,
                sl.NIK_spv,
                sl.date,
                sl.idSPL,
                MIN( sl.START ) min,
            MAX( sl.END ) max 
        FROM
            LogSuratLembur sl 
        WHERE
            MONTH ( sl.date ) = m 
            AND YEAR ( sl.date ) = y 
            AND sl.approval4 = 1 
            AND sl.idSPL = 2 
        GROUP BY
            sl.idL,
            sl.NIK_spv,
            sl.date 
            ) a 
        WHERE
            ( a.min ) != ( a.max ) 
        GROUP BY
            a.NIK_spv,
            a.date UNION ALL
        SELECT
            a.nik,
            a.date AS dt,
            MIN( a.min ) `min`,
            MAX( a.max ) `max` 
        FROM
            (
            SELECT
                sl.idL,
                ms.NIK_op AS nik,
                sl.date,
                sl.idSPL,
                MIN( sl.START ) min,
            MAX( sl.END ) max 
        FROM
            LogSuratLembur sl
            JOIN LogMemberSPL ms ON sl.idL = ms.idL 
        WHERE
            MONTH ( sl.date ) = m 
            AND YEAR ( sl.date ) = y 
            AND sl.approval4 = 1 
            AND sl.idSPL = 1 
        GROUP BY
            sl.idL,
            nik,
            sl.date UNION ALL
        SELECT
            sl.idL,
            ms.NIK_op AS nik,
            sl.date,
            sl.idSPL,
            MIN( sl.START ) min,
            MAX( sl.END ) max 
        FROM
            LogSuratLembur sl
            JOIN LogMemberSPL ms ON sl.idL = ms.idL 
        WHERE
            MONTH ( sl.date ) = m 
            AND YEAR ( sl.date ) = y 
            AND sl.approval4 = 1 
            AND sl.idSPL = 2 
        GROUP BY
            sl.idL,
            nik,
            sl.date 
            ) a 
        WHERE
            ( a.min ) != ( a.max ) 
        GROUP BY
            a.nik,
            a.date 
        ORDER BY
            dt ASC 
            ) spl ON a.nik = spl.NIK 
            AND a.dt = spl.dt 
        ORDER BY
            a.nik,
            a.dt 
            ) a 
        WHERE
            a.ts BETWEEN TIME( '00:00:00' ) 
            AND a.tIn1 
            AND a.tOut1 BETWEEN TIME( '00:00:00' ) 
            AND TIME( '10:30:00' ) 
        GROUP BY
            a.nik,
            a.NAME,
            a.dt,
            a.tIn1,
            a.tOut1 
            ) c ON a.nik = c.nik 
            AND a.dt = c.dt
            LEFT JOIN mstDept d ON d.idDept = a.idDept
            LEFT JOIN mstDiv d1 ON d1.idDiv = a.idDiv
            LEFT JOIN mstWorkgroup w1 ON w1.idWG = a.idWG
            LEFT JOIN mstPost p ON p.idPost = a.idPost 
        ORDER BY
            a.idPost ASC,
            a.nik,
            a.dt;
        
        ELSEIF 
        ( nk IS NOT NULL ) THEN 
                SELECT
              fn.nik,
            fn.NAME,
            fn.`position`,
            fn.dept,
            fn.division,
            fn.Workgroup,
            fn.day,
            fn.dt,
            fn.tIn,
            fn.tIn1,
            fn.tOut,
            fn.tOut1,
            CONCAT(fn.ot,' Jam')ot,
            fn.masuk,
            fn.pulang,
              CASE -- Validation SPL
                WHEN fn.pulang IS NULL 
                  THEN 'Lupa Absen'
                WHEN fn.ot IS NULL AND fn.pulang BETWEEN IFNULL(fn.tIn1,time('00:00:00')) AND ADDDATE(IFNULL(fn.tOut1,time('23:59:59')), INTERVAL 30 MINUTE)  
                  THEN NULL
                WHEN fn.staffStatus = 'S' AND fn.ot>4 THEN
                  CASE 
                    WHEN fn.pulang>fn.tOut1 AND fn.ot IS NULL THEN 'Tidak Ada SPL'
                    WHEN fn.tIn=fn.tIn1 AND fn.tOut!=fn.tOut1 
                    THEN IF(fn.pulang>ADDDATE(fn.tOut1,INTERVAL -30 MINUTE), 'OK', 
                     CONCAT('Valid ',
                        IF(MINUTE(TIMEDIFF(fn.pulang,fn.min))>30,
                             HOUR(TIMEDIFF(fn.pulang,fn.min))+1,
                             HOUR(TIMEDIFF(fn.pulang,fn.min))),
                               ' Jam')
                )
                  WHEN fn.tIn!=fn.tIn1 AND fn.tOut=fn.tOut1 
                    THEN IF(ADDDATE(fn.tIn1,INTERVAL 30 MINUTE)>fn.masuk, 'OK', 
                     concat('Valid ',
                        IF(MINUTE(TIMEDIFF(fn.max,fn.masuk))>30,
                             HOUR(TIMEDIFF(fn.max,fn.masuk))+1,
                             HOUR(TIMEDIFF(fn.max,fn.masuk))),
                               ' Jam')
                )
                  WHEN fn.tIn!=fn.tIn1 AND fn.tOut!=fn.tOut1 
                    THEN CASE WHEN (ADDDATE(fn.tIn1,INTERVAL 30 MINUTE)>fn.masuk) OR (fn.pulang>ADDDATE(fn.tOut1,INTERVAL -30 MINUTE)) THEN
                        CASE WHEN (ADDDATE(fn.tIn1,INTERVAL 30 MINUTE)>fn.masuk) THEN
                          IF(MINUTE(TIMEDIFF(fn.max,fn.masuk))>30,
                               HOUR(TIMEDIFF(fn.max,fn.masuk))+1,
                               HOUR(TIMEDIFF(fn.max,fn.masuk)))
                        ELSE HOUR(TIMEDIFF(fn.max,fn.min)) END
                               +
                        CASE WHEN (fn.pulang>ADDDATE(fn.tOut1,INTERVAL -30 MINUTE)) THEN 
                          IF(MINUTE(TIMEDIFF(fn.pulang,fn.min))>30,
                               HOUR(TIMEDIFF(fn.pulang,fn.min))+1,
                               HOUR(TIMEDIFF(fn.pulang,fn.min)))
                        ELSE HOUR(TIMEDIFF(fn.max,fn.min)) END
                    END 
                  ELSE 
                    'OK'
                  END
                WHEN fn.staffStatus = 'O' THEN
                  CASE 
                    WHEN fn.pulang>fn.tOut1 AND fn.ot IS NULL THEN 'Tidak Ada SPL'
                    WHEN fn.tIn=fn.tIn1 AND fn.tOut!=fn.tOut1 
                    THEN IF(fn.pulang>ADDDATE(fn.tOut1,INTERVAL -30 MINUTE), 'OK', 
                     CONCAT('Valid ',
                        IF(MINUTE(TIMEDIFF(fn.pulang,fn.min))>30,
                             HOUR(TIMEDIFF(fn.pulang,fn.min))+1,
                             HOUR(TIMEDIFF(fn.pulang,fn.min))),
                               ' Jam')
                )
                  WHEN fn.tIn!=fn.tIn1 AND fn.tOut=fn.tOut1 
                    THEN IF(ADDDATE(fn.tIn1,INTERVAL 30 MINUTE)>fn.masuk, 'OK', 
                     concat('Valid ',
                        IF(MINUTE(TIMEDIFF(fn.max,fn.masuk))>30,
                             HOUR(TIMEDIFF(fn.max,fn.masuk))+1,
                             HOUR(TIMEDIFF(fn.max,fn.masuk))),
                               ' Jam')
                )
                  WHEN fn.tIn!=fn.tIn1 AND fn.tOut!=fn.tOut1 
                    THEN CASE WHEN (ADDDATE(fn.tIn1,INTERVAL 30 MINUTE)>fn.masuk) OR (fn.pulang>ADDDATE(fn.tOut1,INTERVAL -30 MINUTE)) THEN
                        CASE WHEN (ADDDATE(fn.tIn1,INTERVAL 30 MINUTE)>fn.masuk) THEN
                          IF(MINUTE(TIMEDIFF(fn.max,fn.masuk))>30,
                               HOUR(TIMEDIFF(fn.max,fn.masuk))+1,
                               HOUR(TIMEDIFF(fn.max,fn.masuk)))
                        ELSE HOUR(TIMEDIFF(fn.max,fn.min)) END
                               +
                        CASE WHEN (fn.pulang>ADDDATE(fn.tOut1,INTERVAL -30 MINUTE)) THEN 
                          IF(MINUTE(TIMEDIFF(fn.pulang,fn.min))>30,
                               HOUR(TIMEDIFF(fn.pulang,fn.min))+1,
                               HOUR(TIMEDIFF(fn.pulang,fn.min)))
                        ELSE HOUR(TIMEDIFF(fn.max,fn.min)) END
                    END
                  ELSE 
                    'OK'
                  END
            END validation
            FROM
            (SELECT
            a.nik,
            a.NAME,
            p.`position`,
            d.dept,
            d1.division,
            w1.Workgroup,a.staffStatus,
            DAYNAME( a.dt ) `day`,
            a.dt,
          a.min,
          a.max,
          a.tIn,
            a.tIn1,
            a.tOut,
            a.tOut1,
            CONCAT( a.HOUR, ' JAM' ) ot,
            a.masuk,
        IF
            (
                a.masuk = IFNULL( b.pulang1, c.pulang2 ),
                NULL,
                IFNULL( b.pulang1, c.pulang2 ) 
            ) pulang
                    FROM
                        (
                        SELECT
                            a.nik,
                            a.NAME,
                            a.idDept,
                            a.idDiv,
                            a.idWG,
                            a.idPost,a.staffStatus,
                            a.dt,
                            a.tIn,
                            a.tOut,
                            a.tIn1,
                            a.tOut1,
                            a.min,
                            a.max,
                            a.HOUR,
                            MIN( a.ts ) masuk 
                        FROM
                            (
                            SELECT
                                a.nik,
                                a.NAME,
                                a.idDept,
                                a.idDiv,
                                a.idWG,
                                a.idPost,a.staffStatus,
                                a.dt,
                                a.ts,
                                a.idTS,
                                a.idGroupShift,
                                spl.HOUR,
                            IF
                                ( a.idTS IS NULL, gs.tIn, ts.tIn ) tIn,
                            IF
                                ( a.idTS IS NULL, gs.tOut, ts.tOut ) tOut,
                                spl.min,
                                spl.max,
                            IF
                                (
                                    spl.min <
                                IF
                                    ( a.idTS IS NULL, gs.tIn, ts.tIn ),
                                    spl.min,
                                IF
                                    ( a.idTS IS NULL, gs.tIn, ts.tIn ) 
                                ) tIn1,
                            IF
                                (
                                    spl.max >
                                IF
                                    ( a.idTS IS NULL, gs.tOut, ts.tOut ),
                                    spl.max,
                                IF
                                    ( a.idTS IS NULL, gs.tOut, ts.tOut ) 
                                ) tOut1 
                            FROM
                                (
                                SELECT DISTINCT
                                    l.NIK nik,
                                    l.NAME NAME,
                                    l.idDept idDept,
                                    l.idDiv idDiv,
                                    l.idWG idWG,
                                    l.idPost idPost,l.staffStatus,
                                    l.dt dt,
                                    l.ts ts,
                                CASE
                                        
                                        WHEN dt BETWEEN cs.dateStart 
                                        AND cs.dateEnd THEN
                                            cs.idTS ELSE NULL 
                                        END idTS,
                    CASE
                            
                            WHEN dt NOT BETWEEN cs.dateStart 
                            AND cs.dateEnd THEN
                                l.idGroupShift ELSE COALESCE (
                                CASE
                                        
                                        WHEN cs.idTS IS NOT NULL THEN
                                    NULL 
                                    END,
                                CASE
                                        
                                        WHEN cs.idTS IS NOT NULL THEN
                                        NULL ELSE l.idGroupShift 
                                    END 
                                    ) 
                                END idGroupShift 
        FROM
            (
            SELECT
                l.NIK,
                me.NAME,
                me.idDept,
                me.idDiv,
                me.idWG,
                me.idPost,me.staffStatus,
                TIME( l.enroll ) ts,
                DATE( l.enroll ) dt,
                w.idGroupShift 
            FROM
                mstEmp me
                LEFT JOIN mstWorkgroup w ON me.idWG = w.idWG
                LEFT JOIN attandenceLog l ON me.NIK = l.NIK 
            WHERE
                MONTH ( l.enroll ) = m 
                AND YEAR ( l.enroll ) = y 
                AND me.NIK = nk 
            ) l
            LEFT OUTER JOIN (
            SELECT
                cs.NIK,
            IF
                (
                    ( MONTH ( cs.dateStart ) = m OR YEAR ( cs.dateStart ) = y ),
                    cs.dateStart,
                    DATE( CONCAT( y, '/', m, '/1' ) ) 
                ) dateStart,
            IF
                (
                    ( MONTH ( cs.dateEnd ) = m OR YEAR ( cs.dateEnd ) = y ),
                    cs.dateStart,
                    LAST_DAY( CONCAT( y, '/', m, '/1' ) ) 
                ) dateEnd,
                cs.idTS 
            FROM
                transaksiChangeShift cs 
            WHERE
                ( MONTH ( cs.dateStart ) = m OR MONTH ( cs.dateEnd ) = m ) 
                AND ( YEAR ( cs.dateStart ) = y OR YEAR ( cs.dateEnd ) = y ) 
            ) cs ON l.NIK = cs.NIK 
            ) a
            LEFT JOIN mstGroupShift gs ON a.idGroupShift = gs.idGroupShift 
            AND WEEKDAY( a.dt ) = gs.Idx
            LEFT JOIN mstTimeShifting ts ON a.idTS = ts.idTS
            LEFT JOIN (
            SELECT
                a.NIK_spv AS nik,
                a.date AS dt,
                MIN( a.min ) `min`,
                MAX( a.max ) `max`,
            IF
                (
                    MAX( a.max ) < MIN( a.min ),
                    ( SUM( a.HOUR ) ),
                    MAX( a.HOUR ) 
                ) `hour` 
            FROM
                (
                SELECT
                    sl.idL,
                    sl.NIK_spv,
                    sl.date,
                    sl.idSPL,
                    MIN( sl.START ) min,
                MAX( sl.END ) max,
            HOUR ( TIMEDIFF( MAX( sl.START ), MIN( sl.END ) ) ) HOUR 
        FROM
            LogSuratLembur sl 
        WHERE
            MONTH ( sl.date ) = m 
            AND YEAR ( sl.date ) = y 
            AND sl.approval4 = 1 
            AND sl.idSPL = 1 
        GROUP BY
            sl.idL,
            sl.NIK_spv,
            sl.date UNION ALL
        SELECT
            sl.idL,
            sl.NIK_spv,
            sl.date,
            sl.idSPL,
            MIN( sl.START ) min,
            MAX( sl.END ) max,
            HOUR ( TIMEDIFF( MAX( sl.START ), MIN( sl.END ) ) ) HOUR 
        FROM
            LogSuratLembur sl 
        WHERE
            MONTH ( sl.date ) = m 
            AND YEAR ( sl.date ) = y 
            AND sl.approval4 = 1 
            AND sl.idSPL = 2 
        GROUP BY
            sl.idL,
            sl.NIK_spv,
            sl.date 
            ) a 
        WHERE
            ( a.min ) != ( a.max ) 
        GROUP BY
            a.NIK_spv,
            a.date UNION ALL
        SELECT
            a.nik,
            a.date AS dt,
            MIN( a.min ) `min`,
            MAX( a.max ) `max`,
        IF
            (
                MAX( a.max ) < MIN( a.min ),
                ( SUM( a.HOUR ) ),
                MAX( a.HOUR ) 
            ) `hour` 
        FROM
            (
            SELECT
                sl.idL,
                ms.NIK_op AS nik,
                sl.date,
                sl.idSPL,
                MIN( sl.START ) min,
            MAX( sl.END ) max,
            HOUR ( TIMEDIFF( MAX( sl.START ), MIN( sl.END ) ) ) HOUR 
        FROM
            LogSuratLembur sl
            JOIN LogMemberSPL ms ON sl.idL = ms.idL 
        WHERE
            MONTH ( sl.date ) = m 
            AND YEAR ( sl.date ) = y 
            AND sl.approval4 = 1 
            AND sl.idSPL = 1 
        GROUP BY
            sl.idL,
            nik,
            sl.date UNION ALL
        SELECT
            sl.idL,
            ms.NIK_op AS nik,
            sl.date,
            sl.idSPL,
            MIN( sl.START ) min,
            MAX( sl.END ) max,
            HOUR ( TIMEDIFF( MAX( sl.START ), MIN( sl.END ) ) ) HOUR 
        FROM
            LogSuratLembur sl
            JOIN LogMemberSPL ms ON sl.idL = ms.idL 
        WHERE
            MONTH ( sl.date ) = m 
            AND YEAR ( sl.date ) = y 
            AND sl.approval4 = 1 
            AND sl.idSPL = 2 
        GROUP BY
            sl.idL,
            nik,
            sl.date 
            ) a 
        WHERE
            ( a.min ) != ( a.max ) 
        GROUP BY
            a.nik,
            a.date 
        ORDER BY
            dt ASC 
            ) spl ON a.nik = spl.NIK 
            AND a.dt = spl.dt 
        ORDER BY
            a.nik,
            a.dt 
            ) a 
        WHERE
            a.ts BETWEEN ADDDATE( IFNULL( a.tIn1, time( '00:00:00' ) ), INTERVAL - 90 MINUTE ) 
            AND IFNULL( a.tOut1, time( '23:59:59' ) ) 
        GROUP BY
            a.nik,
            a.NAME,
            a.idDept,
            a.idDiv,
            a.idWG,
            a.idPost,a.staffStatus,
            a.dt,
            a.tIn1,
            a.tOut1,
            a.HOUR,
            a.tIn,
            a.tOut,
            a.min,
            a.max 
            ) a
            LEFT JOIN (
            SELECT
                a.nik,
                a.NAME,
                a.dt,
                a.tIn1,
                a.tOut1,
                MAX( a.ts ) pulang1 
            FROM
                (
                SELECT
                    a.nik,
                    a.NAME,
                    a.dt,
                    a.ts,
                    a.idTS,
                    a.idGroupShift,
                IF
                    (
                        spl.min <
                    IF
                        ( a.idTS IS NULL, gs.tIn, ts.tIn ),
                        spl.min,
                    IF
                        ( a.idTS IS NULL, gs.tIn, ts.tIn ) 
                    ) tIn1,
                IF
                    (
                        spl.max >
                    IF
                        ( a.idTS IS NULL, gs.tOut, ts.tOut ),
                        spl.max,
                    IF
                        ( a.idTS IS NULL, gs.tOut, ts.tOut ) 
                    ) tOut1 
                FROM
                    (
                    SELECT DISTINCT
                        l.NIK nik,
                        l.NAME NAME,
                        l.dt dt,
                        l.ts ts,
                    CASE
                            
                            WHEN dt BETWEEN cs.dateStart 
                            AND cs.dateEnd THEN
                                cs.idTS ELSE NULL 
                            END idTS,
        CASE
                
                WHEN dt NOT BETWEEN cs.dateStart 
                AND cs.dateEnd THEN
                    l.idGroupShift ELSE COALESCE (
                    CASE
                            
                            WHEN cs.idTS IS NOT NULL THEN
                        NULL 
                        END,
                    CASE
                            
                            WHEN cs.idTS IS NOT NULL THEN
                            NULL ELSE l.idGroupShift 
                        END 
                        ) 
                    END idGroupShift 
        FROM
            (
            SELECT
                l.NIK,
                me.NAME,
                TIME( l.enroll ) ts,
                DATE( l.enroll ) dt,
                w.idGroupShift 
            FROM
                mstEmp me
                LEFT JOIN mstWorkgroup w ON me.idWG = w.idWG
                LEFT JOIN attandenceLog l ON me.NIK = l.NIK 
            WHERE
                MONTH ( l.enroll ) = m 
                AND YEAR ( l.enroll ) = y 
                AND me.NIK = nk 
            ) l
            LEFT OUTER JOIN (
            SELECT
                cs.NIK,
            IF
                (
                    ( MONTH ( cs.dateStart ) = m OR YEAR ( cs.dateStart ) = y ),
                    cs.dateStart,
                    DATE( CONCAT( y, '/', m, '/1' ) ) 
                ) dateStart,
            IF
                (
                    ( MONTH ( cs.dateEnd ) = m OR YEAR ( cs.dateEnd ) = y ),
                    cs.dateStart,
                    LAST_DAY( CONCAT( y, '/', m, '/1' ) ) 
                ) dateEnd,
                cs.idTS 
            FROM
                transaksiChangeShift cs 
            WHERE
                ( MONTH ( cs.dateStart ) = m OR MONTH ( cs.dateEnd ) = m ) 
                AND ( YEAR ( cs.dateStart ) = y OR YEAR ( cs.dateEnd ) = y ) 
            ) cs ON l.NIK = cs.NIK 
            ) a
            LEFT JOIN mstGroupShift gs ON a.idGroupShift = gs.idGroupShift 
            AND WEEKDAY( a.dt ) = gs.Idx
            LEFT JOIN mstTimeShifting ts ON a.idTS = ts.idTS
            LEFT JOIN (
            SELECT
                a.NIK_spv AS nik,
                a.date AS dt,
                MIN( a.min ) `min`,
                MAX( a.max ) `max` 
            FROM
                (
                SELECT
                    sl.idL,
                    sl.NIK_spv,
                    sl.date,
                    sl.idSPL,
                    MIN( sl.START ) min,
                MAX( sl.END ) max 
            FROM
                LogSuratLembur sl 
            WHERE
                MONTH ( sl.date ) = m 
                AND YEAR ( sl.date ) = y 
                AND sl.approval4 = 1 
                AND sl.idSPL = 1 
            GROUP BY
                sl.idL,
                sl.NIK_spv,
                sl.date UNION ALL
            SELECT
                sl.idL,
                sl.NIK_spv,
                sl.date,
                sl.idSPL,
                MIN( sl.START ) min,
            MAX( sl.END ) max 
        FROM
            LogSuratLembur sl 
        WHERE
            MONTH ( sl.date ) = m 
            AND YEAR ( sl.date ) = y 
            AND sl.approval4 = 1 
            AND sl.idSPL = 2 
        GROUP BY
            sl.idL,
            sl.NIK_spv,
            sl.date 
            ) a 
        WHERE
            ( a.min ) != ( a.max ) 
        GROUP BY
            a.NIK_spv,
            a.date UNION ALL
        SELECT
            a.nik,
            a.date AS dt,
            MIN( a.min ) `min`,
            MAX( a.max ) `max` 
        FROM
            (
            SELECT
                sl.idL,
                ms.NIK_op AS nik,
                sl.date,
                sl.idSPL,
                MIN( sl.START ) min,
            MAX( sl.END ) max 
        FROM
            LogSuratLembur sl
            JOIN LogMemberSPL ms ON sl.idL = ms.idL 
        WHERE
            MONTH ( sl.date ) = m 
            AND YEAR ( sl.date ) = y 
            AND sl.approval4 = 1 
            AND sl.idSPL = 1 
        GROUP BY
            sl.idL,
            nik,
            sl.date UNION ALL
        SELECT
            sl.idL,
            ms.NIK_op AS nik,
            sl.date,
            sl.idSPL,
            MIN( sl.START ) min,
            MAX( sl.END ) max 
        FROM
            LogSuratLembur sl
            JOIN LogMemberSPL ms ON sl.idL = ms.idL 
        WHERE
            MONTH ( sl.date ) = m 
            AND YEAR ( sl.date ) = y 
            AND sl.approval4 = 1 
            AND sl.idSPL = 2 
        GROUP BY
            sl.idL,
            nik,
            sl.date 
            ) a 
        WHERE
            ( a.min ) != ( a.max ) 
        GROUP BY
            a.nik,
            a.date 
        ORDER BY
            dt ASC 
            ) spl ON a.nik = spl.NIK 
            AND a.dt = spl.dt 
        ORDER BY
            a.nik,
            a.dt 
            ) a 
        WHERE
            a.ts BETWEEN IFNULL(a.tIn1,time('00:00:00')) 
            AND TIME( '23:59:59' ) 
            AND IFNULL(a.tOut1,time('23:59:58')) < TIME( '23:59:59' ) 
        GROUP BY
            a.nik,
            a.NAME,
            a.dt,
            a.tIn1,
            a.tOut1 
            ) b ON a.nik = b.nik 
            AND a.dt = b.dt
            LEFT JOIN (
            SELECT
                a.nik,
                a.NAME,
                ADDDATE( a.dt, INTERVAL - 1 DAY ) dt,
                a.tIn1,
                a.tOut1,
                MIN( a.ts ) pulang2 
            FROM
                (
                SELECT
                    a.nik,
                    a.NAME,
                    a.dt,
                    a.ts,
                    a.idTS,
                    a.idGroupShift,
                IF
                    (
                        spl.min <
                    IF
                        ( a.idTS IS NULL, gs.tIn, ts.tIn ),
                        spl.min,
                    IF
                        ( a.idTS IS NULL, gs.tIn, ts.tIn ) 
                    ) tIn1,
                IF
                    (
                        spl.max >
                    IF
                        ( a.idTS IS NULL, gs.tOut, ts.tOut ),
                        spl.max,
                    IF
                        ( a.idTS IS NULL, gs.tOut, ts.tOut ) 
                    ) tOut1 
                FROM
                    (
                    SELECT DISTINCT
                        l.NIK nik,
                        l.NAME NAME,
                        l.dt dt,
                        l.ts ts,
                    CASE
                            
                            WHEN dt BETWEEN cs.dateStart 
                            AND cs.dateEnd THEN
                                cs.idTS ELSE NULL 
                            END idTS,
        CASE
                
                WHEN dt NOT BETWEEN cs.dateStart 
                AND cs.dateEnd THEN
                    l.idGroupShift ELSE COALESCE (
                    CASE
                            
                            WHEN cs.idTS IS NOT NULL THEN
                        NULL 
                        END,
                    CASE
                            
                            WHEN cs.idTS IS NOT NULL THEN
                            NULL ELSE l.idGroupShift 
                        END 
                        ) 
                    END idGroupShift 
        FROM
            (
            SELECT
                l.NIK,
                me.NAME,
                TIME( l.enroll ) ts,
                DATE( l.enroll ) dt,
                w.idGroupShift 
            FROM
                mstEmp me
                LEFT JOIN mstWorkgroup w ON me.idWG = w.idWG
                LEFT JOIN attandenceLog l ON me.NIK = l.NIK 
            WHERE
                MONTH ( l.enroll ) = m 
                AND YEAR ( l.enroll ) = y 
                AND me.NIK = nk 
            ) l
            LEFT OUTER JOIN (
            SELECT
                cs.NIK,
            IF
                (
                    ( MONTH ( cs.dateStart ) = m OR YEAR ( cs.dateStart ) = y ),
                    cs.dateStart,
                    DATE( CONCAT( y, '/', m, '/1' ) ) 
                ) dateStart,
            IF
                (
                    ( MONTH ( cs.dateEnd ) = m OR YEAR ( cs.dateEnd ) = y ),
                    cs.dateStart,
                    LAST_DAY( CONCAT( y, '/', m, '/1' ) ) 
                ) dateEnd,
                cs.idTS 
            FROM
                transaksiChangeShift cs 
            WHERE
                ( MONTH ( cs.dateStart ) = m OR MONTH ( cs.dateEnd ) = m ) 
                AND ( YEAR ( cs.dateStart ) = y OR YEAR ( cs.dateEnd ) = y ) 
            ) cs ON l.NIK = cs.NIK 
            ) a
            LEFT JOIN mstGroupShift gs ON a.idGroupShift = gs.idGroupShift 
            AND WEEKDAY( a.dt ) = gs.Idx
            LEFT JOIN mstTimeShifting ts ON a.idTS = ts.idTS
            LEFT JOIN (
            SELECT
                a.NIK_spv AS nik,
                a.date AS dt,
                MIN( a.min ) `min`,
                MAX( a.max ) `max` 
            FROM
                (
                SELECT
                    sl.idL,
                    sl.NIK_spv,
                    sl.date,
                    sl.idSPL,
                    MIN( sl.START ) min,
                MAX( sl.END ) max 
            FROM
                LogSuratLembur sl 
            WHERE
                MONTH ( sl.date ) = m 
                AND YEAR ( sl.date ) = y 
                AND sl.approval4 = 1 
                AND sl.idSPL = 1 
            GROUP BY
                sl.idL,
                sl.NIK_spv,
                sl.date UNION ALL
            SELECT
                sl.idL,
                sl.NIK_spv,
                sl.date,
                sl.idSPL,
                MIN( sl.START ) min,
            MAX( sl.END ) max 
        FROM
            LogSuratLembur sl 
        WHERE
            MONTH ( sl.date ) = m 
            AND YEAR ( sl.date ) = y 
            AND sl.approval4 = 1 
            AND sl.idSPL = 2 
        GROUP BY
            sl.idL,
            sl.NIK_spv,
            sl.date 
            ) a 
        WHERE
            ( a.min ) != ( a.max ) 
        GROUP BY
            a.NIK_spv,
            a.date UNION ALL
        SELECT
            a.nik,
            a.date AS dt,
            MIN( a.min ) `min`,
            MAX( a.max ) `max` 
        FROM
            (
            SELECT
                sl.idL,
                ms.NIK_op AS nik,
                sl.date,
                sl.idSPL,
                MIN( sl.START ) min,
            MAX( sl.END ) max 
        FROM
            LogSuratLembur sl
            JOIN LogMemberSPL ms ON sl.idL = ms.idL 
        WHERE
            MONTH ( sl.date ) = m 
            AND YEAR ( sl.date ) = y 
            AND sl.approval4 = 1 
            AND sl.idSPL = 1 
        GROUP BY
            sl.idL,
            nik,
            sl.date UNION ALL
        SELECT
            sl.idL,
            ms.NIK_op AS nik,
            sl.date,
            sl.idSPL,
            MIN( sl.START ) min,
            MAX( sl.END ) max 
        FROM
            LogSuratLembur sl
            JOIN LogMemberSPL ms ON sl.idL = ms.idL 
        WHERE
            MONTH ( sl.date ) = m 
            AND YEAR ( sl.date ) = y 
            AND sl.approval4 = 1 
            AND sl.idSPL = 2 
        GROUP BY
            sl.idL,
            nik,
            sl.date 
            ) a 
        WHERE
            ( a.min ) != ( a.max ) 
        GROUP BY
            a.nik,
            a.date 
        ORDER BY
            dt ASC 
            ) spl ON a.nik = spl.NIK 
            AND a.dt = spl.dt 
        ORDER BY
            a.nik,
            a.dt 
            ) a 
        WHERE
            a.ts BETWEEN TIME( '00:00:00' ) 
            AND IFNULL(a.tIn1 , time('23:59:59'))
            AND IFNULL(a.tOut1,time('10:30:00')) BETWEEN TIME( '00:00:00' ) 
            AND TIME( '10:30:00' ) 
        GROUP BY
            a.nik,
            a.NAME,
            a.dt,
            a.tIn1,
            a.tOut1 
            ) c ON a.nik = c.nik 
            AND a.dt = c.dt
            LEFT JOIN mstDept d ON d.idDept = a.idDept
            LEFT JOIN mstDiv d1 ON d1.idDiv = a.idDiv
            LEFT JOIN mstWorkgroup w1 ON w1.idWG = a.idWG
            LEFT JOIN mstPost p ON p.idPost = a.idPost 
        ORDER BY
            a.idPost,
            a.nik,
            a.dt)fn;
        
        END IF;
        
        END";
        $query = $this->db->query($data);
        return $query->result();
    }
}

<?php



// Constants for expressing human-readable intervals
// in their respective number of seconds.
define( 'MINUTE_IN_SECONDS', 60 );
define( 'HOUR_IN_SECONDS',   60 * MINUTE_IN_SECONDS );
define( 'DAY_IN_SECONDS',    24 * HOUR_IN_SECONDS   );
define( 'WEEK_IN_SECONDS',    7 * DAY_IN_SECONDS    );
define( 'YEAR_IN_SECONDS',  365 * DAY_IN_SECONDS    );

class Helper {


        public static function _n($a, $b, $num) {
                return ($num > 1) ? $b : $a;
        }


        /**
         * Wordpress human time difference.
         *
         * @param mixed $from
         * @param mixed $to
         * @see http://core.trac.wordpress.org/browser/tags/3.6.1/wp-includes/formatting.php#L2133
         * @return string
         */
        public static function humanTimeDiff( $from, $to = '' ) {
                if ( empty( $to ) )
                        $to = time();
                $diff = (int) abs( $to - $from );
                if ( $diff < HOUR_IN_SECONDS ) {
                        $mins = round( $diff / MINUTE_IN_SECONDS );
                        if ( $mins <= 1 )
                                $mins = 1;
                        /* translators: min=minute */
                        $since = sprintf( self::_n( '%s min', '%s mins', $mins ), $mins );
                } elseif ( $diff < DAY_IN_SECONDS && $diff >= HOUR_IN_SECONDS ) {
                        $hours = round( $diff / HOUR_IN_SECONDS );
                        if ( $hours <= 1 )
                                $hours = 1;
                        $since = sprintf( self::_n( '%s hour', '%s hours', $hours ), $hours );
                } elseif ( $diff < WEEK_IN_SECONDS && $diff >= DAY_IN_SECONDS ) {
                        $days = round( $diff / DAY_IN_SECONDS );
                        if ( $days <= 1 )
                                $days = 1;
                        $since = sprintf( self::_n( '%s day', '%s days', $days ), $days );
                } elseif ( $diff < 30 * DAY_IN_SECONDS && $diff >= WEEK_IN_SECONDS ) {
                        $weeks = round( $diff / WEEK_IN_SECONDS );
                        if ( $weeks <= 1 )
                                $weeks = 1;
                        $since = sprintf( self::_n( '%s week', '%s weeks', $weeks ), $weeks );
                } elseif ( $diff < YEAR_IN_SECONDS && $diff >= 30 * DAY_IN_SECONDS ) {
                        $months = round( $diff / ( 30 * DAY_IN_SECONDS ) );
                        if ( $months <= 1 )
                                $months = 1;
                        $since = sprintf( self::_n( '%s month', '%s months', $months ), $months );
                } elseif ( $diff >= YEAR_IN_SECONDS ) {
                        $years = round( $diff / YEAR_IN_SECONDS );
                        if ( $years <= 1 )
                                $years = 1;
                        $since = sprintf( self::_n( '%s year', '%s years', $years ), $years );
                }
                return $since;
        }
}
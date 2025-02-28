<?php
if( ! function_exists('unique_random') ){
    /**
     *
     * Generate a unique random string of characters
     * uses str_random() helper for generating the random string
     *
     * @param     $table - name of the table
     * @param     $col - name of the column that needs to be tested
     * @param int $chars - length of the random string
     *
     * @return string
     */
    function unique_random($table, $col, $chars = 16){

        $unique = false;

        // Store tested results in array to not test them again
        $tested = [];

        do{

            // Generate random string of characters
            $random = \Str::random($chars);

            // Check if it's already testing
            // If so, don't query the database again
            if( in_array($random, $tested) ){
                continue;
            }

            // Check if it is unique in the database
            $count = \DB::table($table)->where($col, '=', $random)->count();

            // Store the random character in the tested array
            // To keep track which ones are already tested
            $tested[] = $random;

            // String appears to be unique
            if( $count == 0){
                // Set unique to true to break the loop
                $unique = true;
            }

            // If unique is still false at this point
            // it will just repeat all the steps until
            // it has generated a random string of characters

        }
        while(!$unique);


        return $random;
    }

}

// Format number with decimals
function decimalFormat($number = 0, $decimals = 2)
{
    return number_format((float)$number, $decimals, '.', '');
}

function iubenda_system( $html, $type = 'page' ) {
    if ( empty( $html ) )
        return;

    require_once( 'iubenda.class.php' );

    // separator
    if ( ! iubendaParser::consent_given() && ! iubendaParser::bot_detected() ) {
        $iubenda = new iubendaParser( $html, array( 'type' => in_array( $type, array( 'page', 'faster' ), true ) ? $type : 'page' ) );
        $html = $iubenda->parse();
    }

    // finished
    return $html;
}

if( ! function_exists('formatSize') ) {
    function formatSize($bytes)
    {
        $kb = 1024;
        $mb = $kb * 1024;
        $gb = $mb * 1024;
        $tb = $gb * 1024;
        if (($bytes >= 0) && ($bytes < $kb)) {
            return $bytes . ' B';
        } elseif (($bytes >= $kb) && ($bytes < $mb)) {
            return ceil($bytes / $kb) . ' KB';
        } elseif (($bytes >= $mb) && ($bytes < $gb)) {
            return ceil($bytes / $mb) . ' MB';
        } elseif (($bytes >= $gb) && ($bytes < $tb)) {
            return ceil($bytes / $gb) . ' GB';
        } elseif ($bytes >= $tb) {
            return ceil($bytes / $tb) . ' TB';
        } else {
            return $bytes . ' B';
        }
    }
}

if( ! function_exists('folderSize') ) {
    function folderSize($dir)
    {
        $total_size = 0;
        $count = 0;
        $dir_array = scandir($dir);
        foreach ($dir_array as $key => $filename) {
            if ($filename != ".." && $filename != ".") {
                if (is_dir($dir . "/" . $filename)) {
                    $new_foldersize = foldersize($dir . "/" . $filename);
                    $total_size = $total_size + $new_foldersize;
                } else if (is_file($dir . "/" . $filename)) {
                    $total_size = $total_size + filesize($dir . "/" . $filename);
                    $count++;
                }
            }
        }
        return $total_size;
    }

}

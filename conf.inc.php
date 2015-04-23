<?php
	session_start();
    include('db.php');
	
    define("UPDATE_TIME", "1429748255614");

    function isCLI()
	{
	    return (php_sapi_name() === 'cli');
	}

    function getMonth($str) {
        $array = array(
            'January' => 1,
            'February' => 2,
            'March' => 3,
            'April' => 4,
            'May' => 5,
            'June' => 6,
            'July' => 7,
            'August' => 8,
            'September' => 9,
            'October' => 10,
            'November' => 11,
            'December' => 12
        );
        if(array_key_exists($str, $array))
            return $array[$str];

        return 0;
    }

    function getTimeStamp($str) {
        // MONTH 0, 1234
        return strtotime($str);
    }
?>























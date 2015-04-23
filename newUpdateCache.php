<?php
    include('conf.inc.php');

    fwrite(STDOUT, "debug text\n");

    if(!isCLI()) {
        echo "Not CLI, exiting";
        $lb = "<br />";
        die();
    } else {
        define('REDIRECT_STDERR', 1);
        $lb = "\n";
    }

    while(true) {
        $db = getDB();
        if(!$s = $db->query("SELECT * FROM `players` ORDER BY `id` DESC")) {
            echo "First query failed, exiting";
            die();
        }

        echo "First query succeeded".$lb;

        error_reporting(E_ALL);

        $num = $s->num_rows;

        echo $num." rows found".$lb;

        $pages = floor($num / 50);
        if(($pages * 50) != $num)
            $pages++;

        echo $pages." pages".$lb;
        $players = array();
        for($i=0;$i<$pages;$i++) {
            echo "Caching page ".($i + 1).$lb;
            $curPage = $i + 1;
            $first = ($i * 50);
            $amount = 50;
            if(($first + $amount) > $num)
                $amount = ($num - $first);
            echo "Getting rows ".$first." to ".$first + $amount." ".$lb;
            $string = '<script type="text/javascript">
        if(typeof lastRefresh != "undefined") {
            if(lastRefresh < '.UPDATE_TIME.') {
                window.location.replace("http://icurse.nl/betalist/");
            }
        } else {
            window.location.replace("http://icurse.nl/betalist/");
        }
    </script>';
        if($curPage > 1) {
            $string .= '
                <a style="display: block; width: 50%; float: left; text-align: left;" href="?page='.($curPage - 1).'">< Page '.($curPage - 1).'</a>';
        }
        if($curPage < $pages) {
            $string .= '
                <a style="display: block; width: 50%; float: right; text-align: right;" href="?page='.($curPage + 1).'">Page '.($curPage + 1).' ></a>';
        }
        $string .= '
            <table style="width: 100%; margin: 0px; padding: 0px;">
                <thead>
                    <tr>
                        <th style="font-weight: bold;">#</th>
                        <th style="font-weight: bold;">Name</th>
                        <th style="font-weight: bold;">Exiled since</th>
                        <th style="font-weight: bold;">Posts</th>
                        <th style="font-weight: bold;">Last active</th>
                    </tr>
                </thead>
                <tbody>';
                if($s2 = $db->query("SELECT * FROM `players` ORDER BY `id` DESC LIMIT ".$first.", ".$amount."")) {
                    $num2 = $num - ($first);
                    while($r = $s2->fetch_assoc()) {
                        $players[] = $r['name'];
                        //echo "Adding player ".$r['name']." to the cache ".$lb;

                    $string .='
                        <tr'. ($num2 % 2 == 0 ? ' style="background-color: rgba(255,255,255,0.1);"' : '') .'>
                            <td>'. $num2 .'</td>
                            <td><a href="http://www.pathofexile.com/account/view-profile/'. $r['name'] .'"'.($r['banned'] == '1' ? ' style="text-decoration: line-through;"' : '').' target="_blank" alt="'. $r['name'] .'\'s profile">'. $r['name'] .'</a></td>
                            <td>'. $r['register_date'] .'</td>
                            <td>'. $r['forum_posts'] .'</td>
                            <td>'. $r['last_active'] .'</td>
                        </tr>';
                        $num2--;
                    }
                } else {
                    $string .='
                        <tr'. ($num2 % 2 == 0 ? ' style="background-color: rgba(255,255,255,0.1);"' : '') .'>
                            <td>Error, will be back in 3 seconds</td>
                            <td>&nbsp;</td>
                            <td>&nbsp;</td>
                            <td>&nbsp;</td>
                            <td>&nbsp;</td>
                        </tr>';
                }
                $string .= '
                </tbody>
                <tfoot>
                    <tr>
                        <th style="font-weight: bold;">#</th>
                        <th style="font-weight: bold;">Name</th>
                        <th style="font-weight: bold;">Exiled since</th>
                        <th style="font-weight: bold;">Posts</th>
                        <th style="font-weight: bold;">Last active</th>
                    </tr>
                </tfoot>
            </table>';

            if($curPage > 1) {
                $string .= '
                    <a style="display: block; width: 50%; float: left; text-align: left;" href="?page='.($curPage - 1).'">< Page '.($curPage - 1).'</a>';
            }
            if($curPage < $pages) {
                $string .= '
                    <a style="display: block; width: 50%; float: right; text-align: right;" href="?page='.($curPage + 1).'">Page '.($curPage + 1).' ></a>';
            }
            $string .=' <!-- Updated on '.date('H:i:s').' !-->';
            file_put_contents('cache/page'.($i+1).'.htm', $string);
            echo "Cached page ".($i + 1).$lb;
        }
        file_put_contents('players.json', json_encode($players, JSON_PRETTY_PRINT));
        echo "Cached players.json".$lb;
        sleep(5);
    }
?>                                        
<?php
    include('conf.inc.php');
    if(!isCLI())
        die();
    
    while(true) {
        $players = array();
        $string = '<script type="text/javascript">
    if(typeof lastRefresh != "undefined") {
        if(lastRefresh < 1429748255614) {
            window.location.replace("http://icurse.nl/betalist/");
        }
    } else {
        window.location.replace("http://icurse.nl/betalist/");
    }
</script>';
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
                                            $db = getDB();
                                            if($s = $db->query("SELECT * FROM `players` ORDER BY `id` DESC")) {
                                                $num = $s->num_rows;
                                                while($r = $s->fetch_assoc()) {
                                                    $players[] = $r['name'];

                                                $string .='
                                                    <tr'. ($num % 2 == 0 ? ' style="background-color: rgba(255,255,255,0.1);"' : '') .'>
                                                        <td>'. $num .'</td>
                                                        <td><a href="http://www.pathofexile.com/account/view-profile/'. $r['name'] .'"'.($r['banned'] == '1' ? ' style="text-decoration: line-through;"' : '').' target="_blank" alt="'. $r['name'] .'\'s profile">'. $r['name'] .'</a></td>
                                                        <td>'. $r['register_date'] .'</td>
                                                        <td>'. $r['forum_posts'] .'</td>
                                                        <td>'. $r['last_active'] .'</td>
                                                    </tr>';
                                                    $num--;
                                                }
                                            } else {
                                                $string .='
                                                    <tr'. ($num % 2 == 0 ? ' style="background-color: rgba(255,255,255,0.1);"' : '') .'>
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
                                        </table>
                                        <!-- Updated on '.date('H:i:s').' !-->';
        file_put_contents('cache.htm', $string);
        file_put_contents('players.json', json_encode($players, JSON_PRETTY_PRINT));
        echo "Updated \n";
        sleep(5);
    }
?>                                        
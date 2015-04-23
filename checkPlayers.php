<?php
	include('conf.inc.php');
	include('simple_html_dom.php');
	error_reporting(E_WARNING);
	while(true) {
		$db = getDB();
	    if($s = $db->query("SELECT * FROM `players` ORDER BY `id` DESC")) {
	        $num = $s->num_rows;
	        while($r = $s->fetch_assoc()) {
				try {
					$html = file_get_html('http://www.pathofexile.com/account/view-profile/'.$r['name']);
					$name = $r['name'];
					$ret = $html->find('.banned');
					if(!empty($ret)) {
						if($r['banned'] == '0') {
							$db->query("UPDATE `players` SET `banned` = '1' WHERE `id` = '".$r['id']."'");
							echo $name." is banned\n";
						} else {
							echo $name." checked\n";
						}
					} else {
						if($r['banned'] == '1') {
							$db->query("UPDATE `players` SET `banned` = '0' WHERE `id` = '".$r['id']."'");
							echo $name." is unbanned\n";
						} else {
							echo $name." checked\n";
						}
					}
					$ff = $html->find('.details', 0);
					if(!empty($ff)) {
						$ptags = $ff->find('p');
						if(!empty($ptags)) {
							foreach($ptags as $ele) {
								if($ele->find('strong', 0)->innertext == "Last Visited:") {
									if($r['last_active'] != trim(str_replace('Last Visited:', '', $ele->plaintext))) {
										$db->query("UPDATE `players` SET `last_active` = '".trim(str_replace('Last Visited:', '', $ele->plaintext))."' WHERE `id` = '".$r['id']."'");
										echo $name." last active updated\n";
									}
								}
								if($ele->find('strong', 0)->innertext == "Joined:") {
									$joined = trim(str_replace('Joined:', '', $ele->plaintext));
									if($r['register_date'] != $joined) {
										$db->query("UPDATE `players` SET `register_date` = '".$joined."' WHERE `id` = '".$r['id']."'");
										echo $name." exiled since updated\n";
									}
								}
								if($ele->find('strong', 0)->innertext == "Total Forum Posts:") {
									$posts = trim(str_replace('Total Forum Posts:', '', $ele->plaintext));
									if($r['forum_posts'] != $posts) {
										$db->query("UPDATE `players` SET `forum_posts` = '".$posts."' WHERE `id` = '".$r['id']."'");
										echo $name." posts updated\n";
									}
								}
							}
						}
					}
					if($r['join_timestamp'] == '0') {
						$timestamp = getTimeStamp($r['register_date']) + (60 * 60);
						//echo " ".date('Y-m-d', $timestamp)." \n";
						if(!$db->query("UPDATE `players` SET `join_timestamp` = '".$$timestamp."' WHERE `id` = '".$r['id']."'")) {
							$db->error;
						} else {
							echo "Date updated\n";
						}
					}
				} catch(exception $e) {

				}
			}
		}
		sleep(60 * 10); //Sleep for 10 minutes
	}
?>
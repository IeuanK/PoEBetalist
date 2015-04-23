<?php
	error_reporting(0);
	include('conf.inc.php');
	include('simple_html_dom.php');
	while(true) {
		$nextPlayer = json_decode(file_get_contents('http://www.pathofexile.com/scripts/beta-invite-query.php?mode=next'), true);
		$next = $nextPlayer["p1"]["upcoming"][0]["name"];
		$exists = false;
		$db = getDB();
		if($s = $db->query("SELECT * FROM `players` WHERE `name` = '".$next."'")) {
			if($s->num_rows > 0) {
				$exists = true;
			} else {
				echo ".\n";
			}
		} else {
			echo "<>\n";
		}

		if(!$exists) {
			try {
				$html = file_get_html('http://www.pathofexile.com/account/view-profile/'.$next);
				$player = array();
				$player['name'] = $next;
				foreach($html->find('.details', 0)->find('p') as $ele) {
					try {
						if($ele->find('strong', 0)->innertext == "Joined:") {
							$player['joined'] = trim(str_replace('Joined:', '', $ele->plaintext));
						}
						if($ele->find('strong', 0)->innertext == "Total Forum Posts:") {
							$player['posts'] = trim(str_replace('Total Forum Posts:', '', $ele->plaintext));
						}
						if($ele->find('strong', 0)->innertext == "Last Visited:") {
							$player['last_active'] = trim(str_replace('Last Visited:', '', $ele->plaintext));
						}
					} catch(exception $e) {

					}
				}
				$db->query("INSERT INTO `players` (
					`name`,
					`register_date`,
					`forum_posts`,
					`last_active`
				) VALUES (
					'".$player['name']."',
					'".$player['joined']."',
					'".$player['posts']."',
					'".$player['last_active']."'
				)");
				echo $player['name']." added\n";
			} catch (exception $e) {
				
			}
		}
		sleep(3);
	}
?>

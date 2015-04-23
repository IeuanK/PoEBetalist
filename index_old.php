<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN"
  "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">

<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" dir="ltr">

<head>

    <meta http-equiv="content-type" content="text/html; charset=utf-8" />

    <title>Path of Exile Awakening players</title>

    <base href="" />

    <!-- meta tags: -->
    <meta name="Author" content="/u/Daylen" />
    <meta name="Description" content="Automatic PoE Awakening crawler" />
    <script src="//code.jquery.com/jquery-1.11.2.min.js"></script>
    <link rel="stylesheet" href="http://webcdn.pathofexile.com/css/http/screen.css?v=8c63680be11cdb82008ab39998b41ba1" />
    <script type="text/javascript">
        (function(i, s, o, g, r, a, m) {
            i['GoogleAnalyticsObject'] = r;
            i[r] = i[r] || function() {
                (i[r].q = i[r].q || []).push(arguments)
            }, i[r].l = 1 * new Date();
            a = s.createElement(o),
                m = s.getElementsByTagName(o)[0];
            a.async = 1;
            a.src = g;
            m.parentNode.insertBefore(a, m)
        })(window, document, 'script', '//www.google-analytics.com/analytics.js', 'ga');

        ga('create', 'UA-62087774-1', 'auto');
        ga('send', 'pageview');
    </script>

</head>

<body>
    <div id="siteContainer" style="background: none;">
        <div id="siteCentered" style="min-height: 729px;">
            <div id="mainContainer" class="boxLayout">
                <!--<div id="mainContainerBg"></div>!-->
                <div class="layoutBox1 layoutBoxFull noneTheme">

                    <div class="layoutBoxContent">
                        <!--<div id="mainNewsItems">


                        </div>!-->
                        <div class="newsList">
                            <h1>Path of Exile Awakening Beta list</h1>
                            <div class="newsListItem">
                                <div class="content">

                                    <div id="list">
                                        <?php $data=json_decode(file_get_contents( 'players.json'), true); foreach($data as $name) { echo '<a href="http://www.pathofexile.com/account/view-profile/'.$name.'" target="_blank" alt="'.$name.'\'s profile">'.$name.'</a><br />'; } ?>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>

            </div>
        </div>
    </div>
    <script type="text/javascript">
        function update() {
            $.get("list.php", function(data) {
                if (data != $('#list').html()) {
                    $('#list').html(data);
                }
            });
        }

        $(function() {
            setInterval(update, 5000);
        });
    </script>
</body>

</html>
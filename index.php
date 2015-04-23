<?php
    include('conf.inc.php');
    $_SESSION['last_refresh'] = time();
?>
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
    <link href="//netdna.bootstrapcdn.com/bootstrap/3.0.0/css/bootstrap-glyphicons.css" rel="stylesheet">
    <link rel="stylesheet" href="http://webcdn.pathofexile.com/css/http/screen.css?v=8c63680be11cdb82008ab39998b41ba1" />
    <style type="text/css">
        #salt {
            display: none;
        }
        h1:hover > #salt {
            display: inline-block;
        }
    </style>
    <script src="//code.jquery.com/jquery-1.11.2.min.js"></script>
    <script type="text/javascript">
        var d = new Date();
        var t = d.getTime();
        var lastRefresh = t;
        var refreshRate = 5000;
    </script>
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
        <div style="height: 20px; background-color: #000; color: #fff; width: auto; display: block; position: relative: left: 0px; bottom: 0px;">
            This website is in no way related to or created by Grinding Gear Games. Assets visible are property of Grinding Gear Games.
            <div style="line-height: 20px; background-color: #000; color: #fff; width: 150px; display: block; position: absolute: left: 0px; bottom: 0px; text-align: left;">
                Contact me:<br />
                <a href="http://www.reddit.com/user/Daylen/">/u/Daylen</a><br />
                <a href="mailto:ieuan@icurse.nl">ieuan@icurse.nl</a><br />
                <a href="http://www.reddit.com/r/pathofexile/comments/33i13s/realtime_beta_list_info_stats/">Reddit post</a>
            </div>
            <div style="height: 150px; background-color: #000; color: #fff; width: 150px; display: block; position: absolute: right: 0px; bottom: 0px; text-align: left; overflow: hidden;">
                <script async src="//pagead2.googlesyndication.com/pagead/js/adsbygoogle.js"></script>
                <!-- Betalist -->
                <ins class="adsbygoogle"
                     style="display:inline-block;width:150px;height:150px"
                     data-ad-client="ca-pub-0775331596383337"
                     data-ad-slot="4082527903"></ins>
                <script>
                (adsbygoogle = window.adsbygoogle || []).push({});
                </script>
                Please disable adblock to help me cover server costs
            </div>
            <iframe src="http://strawpoll.me/embed_1/4182905" style="height: 260px; background-color: #000; color: #fff; width: 300px; display: block; position: absolute: right: 0px; bottom: 0px; text-align: left; overflow: hidden;" scrolling="no" seamless="seamless">Loading poll...</iframe>
        </div>

            
        <div id="siteCentered" style="min-height: 729px;">
            <div id="mainContainer" class="boxLayout">
                <!--<div id="mainContainerBg"></div>!-->
                <div class="layoutBox1 layoutBoxFull noneTheme">

                    <div class="layoutBoxContent">
                        <!--<div id="mainNewsItems">


                        </div>!-->
                        <div class="newsList">
                            <h1 style="display: block; width: 100%; overflow: hidden;"><span style="float: left;display: inline-block;">Path of Exile Awakening Beta<span id="salt">&nbsp;salt</span> list</span><select id="updateInterval" style="float:right;display: inline-block;">
                                <option value="5000">5 seconds</option>
                                <option value="10000">10 seconds</option>
                                <option value="30000">30 seconds</option>
                                <option value="<?= (60 * 1000); ?>">1 minute</option>
                                <option value="<?= (60 * 1000 * 5); ?>">5 minutes</option>
                                <option value="<?= (60 * 1000 * 10); ?>">10 minutes</option>
                                <option value="<?= (60 * 1000 * 15); ?>">15 minutes</option>
                                <option value="<?= (60 * 1000 * 30); ?>">30 minutes</option>
                            </select></h1>
                            <div class="newsListItem">
                                <div class="content">

                                    <div id="list">
                                        Data loading...
                                </div>
                            </div>
                        </div>
                    </div>

                </div>

            </div>
        </div>
    </div>
    <script type="text/javascript">
        var focus = true;
        var intervalTimer = 0;
        var intervalRate = refreshRate;

        function update() {
            if(intervalRate != refreshRate) {
                clearInterval(intervalTimer);
                intervalTimer = setInterval(update, refreshRate);
                intervalRate = refreshRate;
            }
            if(focus) {
                var d = new Date();
                var n = d.getTime();
                <?php
                    $page = 1;
                    if(isset($_GET['page'])) {
                        if(is_numeric($_GET['page'])) {
                            if(file_exists('cache/page'.$_GET['page'].'.htm')) {
                                $page = $_GET['page'];
                            }
                        }
                    } else {
                        $page = 1;
                    }
                ?>
                $.get("cache/page<?= $page; ?>.htm?v="+n, function(data) {
                    if (data != $('#list').html()) {
                        $('#list').html(data);
                    }
                });
            }
        }

        function onBlur() {
            focus = false;
        };
        function onFocus(){
            focus = true;
            update();
        };

        if (/*@cc_on!@*/false) { // check for Internet Explorer
            document.onfocusin = onFocus;
            document.onfocusout = onBlur;
        } else {
            window.onfocus = onFocus;
            window.onblur = onBlur;
        }

        $(function() {
            update();
            intervalTimer = setInterval(update, refreshRate);
        });

        $('#updateInterval').on('change', function() {
            refreshRate = $(this).val();
            update();
        });
    </script>
</body>

</html>
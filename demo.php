<!doctype html>
<!--[if lt IE 7]> <html class="no-js ie6 oldie" lang="fr"> <![endif]-->
<!--[if IE 7]>    <html class="no-js ie7 oldie" lang="fr"> <![endif]-->
<!--[if IE 8]>    <html class="no-js ie8 oldie" lang="fr"> <![endif]-->
<!--[if gt IE 8]><!--> <html class="no-js" lang="fr"> <!--<![endif]-->
<head>
<meta charset="UTF-8" />
<meta name="viewport" content="width=device-width,initial-scale=1"/>
<title>Intégration API Twitter 1.1 | NOE interactive</title>
<link rel="profile" href="http://gmpg.org/xfn/11" />
<link rel="stylesheet" type="text/css" media="all" href="skinNoe/skin.css" />

<meta name='robots' content='noindex,nofollow' />
<link rel='stylesheet' id='demo-css'  href='twitterapi.css' type='text/css' media='all' />

<meta name="description" content="How to use the latest Twitter 1.1 API, by NOE Interactive, by NOE Interactive" />
<meta name="keywords" content="Twitter, oAuth, NOE Interactive, php" />
<link rel="canonical" href="http://noe-interactive.com/demo/!/twitterapi"/>

</head>

<body class="page lang-fr">

<div id="wrapper" class="hfeed">

    <header>
        <section class="contained">
            <a id="logo"  title="NOE interactive" href="http://noe-interactive.com">NOE interactive</a>
        </section>
    </header>

	<div id="main" role="main">
<section id="content">
    <article id="post-988" class="post-988 page type-page status-publish hentry">
        <div class="entry-title">
            <h1>Intégration API Twitter 1.1</h1>
        </div>
        <div id="tinymce" class="entry-content">
            <section class="contained">
                <?php
                //The demonstration starts here
                ?>
                <?php

                    //1 - Settings (please update to math your own)
                    $consumer_key=''; //Provide your application consumer key
                    $consumer_secret=''; //Provide your application consumer secret
                    $oauth_token = ''; //Provide your oAuth Token
                    $oauth_token_secret = ''; //Provide your oAuth Token Secret

                    //You can now copy paste the folowing

                    if(!empty($consumer_key) && !empty($consumer_secret) && !empty($oauth_token) && !empty($oauth_token_secret)) {

                    //2 - Include @abraham's PHP twitteroauth Library
                    require_once('twitteroauth/twitteroauth.php');

                    //3 - Authentication
                    /* Create a TwitterOauth object with consumer/user tokens. */
                    $connection = new TwitterOAuth($consumer_key, $consumer_secret, $oauth_token, $oauth_token_secret);

                    //4 - Start Querying
                    $query = 'https://api.twitter.com/1.1/statuses/user_timeline.json?screen_name=NOE_interactive&count=1'; //Your Twitter API query
                    $content = $connection->get($query);

                    }

                    /*
                     * Examples
                     *  Verify your connection by displaying your account: $query = 'account/verify_credentials';
                     *  Display a user's timeline: $query = 'https://api.twitter.com/1.1/statuses/user_timeline.json?screen_name=NOE_interactive';
                     *  Display a user's latest tweet : $query = 'https://api.twitter.com/1.1/statuses/user_timeline.json?screen_name=NOE_interactive&count=1';
                     *  Search for a hastag : $query = 'http://search.twitter.com/search.json?q='.urlencode('#NOE10');
                     */
                    echo '
                    <div id="twintegration">
                        <h2>Exemple d\'intégration du dernier tweet de @NOE_interactive</h2>
                        <div class="formField">
                            Cette démonstration se base sur le tutoriel <a href="http://noe-interactive.com/comment-integrer-la-nouvelle-api-twitter-1-1-en-php" title="Comment intégrer la nouvelle API twitter (1.1) en php" target="_blank">Comment intégrer la nouvelle API twitter (1.1) en php</a> de notre blog.
                            Cela implique que vous ayez accomplis toutes les étapes du tutoriel jusqu\'au point 2.3.1.
                            Du coup cet exemple commence typiquement à partir du point 2.3.2 et vous montre comment procéder pour mettre en forme le dernier tweet d\'un compte particulier.
                        </div>';

                    if(!empty($consumer_key) && !empty($consumer_secret) && !empty($oauth_token) && !empty($oauth_token_secret)) {
                        echo'
                        <div class="formField">
                            <label>Query: </label>
                            <span>'.$query.'</span>
                        </div>
                        <div class="formField">
                            <label>Résultat depuis $connection, $content= </label>
                            <p><code>'.substr(print_r($content,true),0,1000).'</code> etc ...</p>
                        </div>
                        <div class="formField">
                            <label>Le Résultat: </label>
                            <p>';
                            if(!empty($content)){ foreach($content as $tweet){
                                echo'
                                <div class="twitter_status" id="'.$tweet->id_str.'">
                                    <div class="bloc_content">
                                        <p class="status tw_status">'.parseTweet($tweet->text).'</p>
                                    </div>
                                    <div class="bloc_caption">
                                        <a href="http://twitter.com/'.$tweet->user->screen_name.'">
                                            <img src="'.$tweet->user->profile_image_url.'" alt="@'.$tweet->user->name.'" class="userimg tw_userimg"/>
                                            <span class="username tw_username">@'.$tweet->user->screen_name.'</span>
                                        </a>
                                        <span class="timestamp tw_timestamp">'.date('d M / H:i',strtotime($tweet->created_at)).'</span>
                                    </div>
                                </div>';
                            }}
                                echo'
                            </p>
                            <div class="visualClear"></div>
                        </div>';
                    } else {
                        echo'<p>Please update your settings to provide valid credentials</p>';
                    }
                    echo '</div>';

/*
 * Transform Tweet plain text into clickable text
 */
function parseTweet($text) {
    $text = preg_replace('#http://[a-z0-9._/-]+#i', '<a  target="_blank" href="$0">$0</a>', $text); //Link
    $text = preg_replace('#@([a-z0-9_]+)#i', '@<a  target="_blank" href="http://twitter.com/$1">$1</a>', $text); //usernames
    $text = preg_replace('# \#([a-z0-9_-]+)#i', ' #<a target="_blank" href="http://search.twitter.com/search?q=%23$1">$1</a>', $text); //Hashtags
    $text = preg_replace('#https://[a-z0-9._/-]+#i', '<a  target="_blank" href="$0">$0</a>', $text); //Links
    return $text;
}

                ?>
            </section>
        </div>
    </article>
</section>
	</div><!-- #main -->

	<div class="visualClear"></div>

    <footer>
    <section class="contained">
    	<section class="aix">
    		<h2>Aix les Bains</h2>
    		<address>Savoie Hexapole<br />Batiment papyrus<br />73420 Méry</address>
    		<span class="tel">Tél. 04 79 63 39 73</span>
    	</section>

    	<section class="lyon">
    		<h2>Lyon</h2>
    		<address>11 rue waldeck<br />Rousseau<br />69006 Lyon</address>
    		<span class="tel">Tél. 04 72 37 41 49</span>
    	</section>

    	<a href="http://twitter.com/NOE_Interactive/" title="Twitter : @NOE_Interactive" class="twitter tooltip-s" target="_blank"><span>Twitter</span></a>
    	<a href="http://www.facebook.com/NOEinteractive" title="Facebook : NOE interactive" class="facebook tooltip-s" target="_blank"><span>Facebook</span></a>

		<ul id="footerlinks">
			<!-- <li><a href="/mentions">Mentions Légales</a></li> -->
			<li><a id="noecopy" href="http://www.noe-interactive.com/" target="_blank" title="handmade by NOE">©2002-2012 NOE interactive</a></li>
		</ul>
	</section>
    </footer>

</div><!-- #wrapper -->

</body>
</html>
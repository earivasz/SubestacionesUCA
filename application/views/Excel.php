<!DOCTYPE html>
<html lang="en">
<head>

<meta charset="utf-8">
<title>Importar Excel a Mysql en CI</title>

<link rel="stylesheet" type="text/css" href="http://www.jqueryeasy.com/wp-content/themes/bigfoot/style.css" media="screen" />
<link rel="alternate" type="application/rss+xml" title="jQuery Easy RSS Feed" href="http://www.jqueryeasy.com/feed/" />
<link rel="alternate" type="application/atom+xml" title="jQuery Easy Atom Feed" href="http://www.jqueryeasy.com/feed/atom/" />
<link rel="pingback" href="http://www.jqueryeasy.com/xmlrpc.php" />
<link rel="shortcut icon" href="http://www.jqueryeasy.com/wp-content/themes/bigfoot/images/favicon.ico" />
<link rel='stylesheet' id='wp-pagenavi-css'  href='http://www.jqueryeasy.com/wp-content/plugins/wp-pagenavi/pagenavi-css.css?ver=2.70' type='text/css' media='all' />
<link rel="EditURI" type="application/rsd+xml" title="RSD" href="http://www.jqueryeasy.com/xmlrpc.php?rsd" />
<link rel="wlwmanifest" type="application/wlwmanifest+xml" href="http://www.jqueryeasy.com/wp-includes/wlwmanifest.xml" /> 
<link rel='index' title='jQuery Easy' href='http://www.jqueryeasy.com/' />
<meta name="generator" content="WordPress 3.2.1" />

<!-- All in One SEO Pack 1.6.13.8 by Michael Torbert of Semper Fi Web Design[280,300] -->
<meta name="description" content="Blog donde podrás encontrar una serie artículos, tutoriales,  relacionados a la creación de aplicaciones web, utilizando las últimas tecnologías que actualmente existen como jQuery, PHP, Mysql, CSS3 y mas." />
<meta name="keywords" content="aplicaciones, jquery,css,php,html,javascript,java,aplicaciones jquery,seo,android,codeinigter,xml, aplicaciones codeigniter, cursos jquery, cursos, tutoriales" />
<link rel="canonical" href="http://www.jqueryeasy.com/" />
<!-- /all in one seo pack -->
    
<!--[if lt IE 7]>

<script type="text/javascript" src="http://www.jqueryeasy.com/wp-content/themes/bigfoot/javascripts/pngfix.js"></script>

<script type="text/javascript" src="http://www.jqueryeasy.com/wp-content/themes/bigfoot/javascripts/menu.js"></script>

<link rel="stylesheet" type="text/css" media="all" href="http://www.jqueryeasy.com/wp-content/themes/bigfoot/css/ie.css" />

<![endif]-->

	<style type="text/css">

	::selection{ background-color: #E13300; color: white; }
	::moz-selection{ background-color: #E13300; color: white; }
	::webkit-selection{ background-color: #E13300; color: white; }

	body {
		background-color: #fff;
		font: 13px/20px normal Helvetica, Arial, sans-serif;
		color: #4F5155;
	}

	a {
		color:#03C;
		background-color: transparent;
		font-weight: normal;
	}

	h1 {
		color: #444;
		background-color: transparent;
		border-bottom: 1px solid #D0D0D0;
		font-size: 19px;
		font-weight: normal;
		margin: 0 0 14px 0;
		padding: 14px 15px 10px 15px;
	}

	code {
		font-family: Consolas, Monaco, Courier New, Courier, monospace;
		font-size: 12px;
		background-color: #f9f9f9;
		border: 1px solid #D0D0D0;
		color: #002166;
		display: block;
		margin: 14px 0 14px 0;
		padding: 12px 10px 12px 10px;
	}

	#body{
		margin: 0 15px 0 15px;
	}
	
	#container{
		margin: 10px;
		border: 1px solid #D0D0D0;
		-webkit-box-shadow: 0 0 8px #D0D0D0;
	}
	#container a{
		color:#03C;
		text-decoration:underline
	}
	</style>
</head>
<body>
<!--<div id="top">
	<div class="wrap">
			<ul id="page-nav" class="topnav">
			<li class="first"><a href="http://www.jqueryeasy.com">Inicio</a></li>
			<li class="page_item page-item-2"><a href="http://www.jqueryeasy.com/pagina-ejemplo/" title="Sobre mi">Sobre mi</a></li>
		</ul>
    	<ul class="topnav right">
        	<li class="subscribe">Suscribir:</li>
            <li class="first"><a href="http://www.jqueryeasy.com/feed/" title="Subscribe to RSS feed">Posts</a></li>
            <li><a href="http://www.jqueryeasy.com/comments/feed/" title="Subscribe to Comments feed">Comentarios</a></li>
            <li class="last"><a href="http://feedburner.google.com/fb/a/mailverify?uri=jqueryeasy/orER&amp;loc=en_US" rel="nofollow" target="_blank">Email</a></li>                
       	</ul>
    	<div class="clear"></div>
    </div>
</div>
-->
<!--
<div id="header">
   	<div class="wrap">
   		<div class="left">
			<div id="logo">

                <a href="http://www.jqueryeasy.com" title="Otro sitio realizado con WordPress">
					<img src="http://www.jqueryeasy.com/wp-content/themes/bigfoot/images/logo.png" alt="Otro sitio realizado con WordPress" /> 
				</a>
				<div class="flike">
                	<div class="fb-like" data-href="http://www.facebook.com/pages/JQueryEasy/246795248721504" data-send="false" data-layout="button_count" data-width="450" data-show-faces="false"></div>
                </div>
			</div>
		</div> 
		<div id="search">
			<form method="get" id="searchform" action="http://www.jqueryeasy.com">

				<input type="text" class="field" name="s" id="s"  value="Buscar en este blog..." onfocus="if (this.value == 'Buscar en este blog...') {this.value = '';}" onblur="if (this.value == '') {this.value = 'Buscar en este blog...';}" />

				<input class="submit btn" type="image" src="http://www.jqueryeasy.com/wp-content/themes/bigfoot/images/icon-search.png" value="Go" />

			</form>
		</div>
    </div>
</div>
-->
<div id="container">
    <h1>Importar Excel en CI</h1>

    <div id="body">
        <form action="<?php echo base_url() ?>index.php/excel/importar" method="post" enctype="multipart/form-data">
            <p>Excel de ejemplo <a href="demo.xls">Aqui</a> </p>
            <p>&nbsp;</p>
            <p>Seleccionar Excel: <input type="file" name="file"> &nbsp;&nbsp; <input type="submit" value="Importar"></p>
            
            <p>&nbsp;
                
            </p>
        </form>
    </div>
</div>


<script type="text/javascript">

  var _gaq = _gaq || [];
  _gaq.push(['_setAccount', 'UA-27704019-1']);
  _gaq.push(['_trackPageview']);

  (function() {
	var ga = document.createElement('script'); ga.type = 'text/javascript'; ga.async = true;
	ga.src = ('https:' == document.location.protocol ? 'https://ssl' : 'http://www') + '.google-analytics.com/ga.js';
	var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(ga, s);
  })();

</script>
		

</body>
</html>
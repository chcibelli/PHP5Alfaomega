<?php
require("clsSeo.php");

$seo = new SEO();
ob_start(array('SEO', 'setUrls')); 
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN"
"http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd"
<[  
	<!ATTLIST a url-basepath CDATA #IMPLIED>
	<!ATTLIST a url-title CDATA #IMPLIED>
]>
<html>
<head>
</head>
<body>
<a href="http://www.misitio.com/index.php?tipo=nota&id=982" target="_self" url-title="El lanzamiento del iPhone 4 genera expectativa en todo el mundo" url-basepath="http://www.misitio.com/notas/982">Link a la nota</a>
<br/>
<a href="http://www.misitio.com/index.php?tipo=nota&id=9334" target="_self" url-title="iPad un gadget para elegidos" url-basepath="http://www.misitio.com/notas/9334">Ver detalles</a>
</body>
<?php
ob_end_flush();
?>
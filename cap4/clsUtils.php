<?php
class Utils {


	public function esCrawler($agente_usuario) {
	
		if($agente_usuario == "") return false;
		
		$bot_strings = Array(
		       "google",     "bot",
        	    "yahoo",     "spider",
            	"archiver",   "curl",
           		"python",     "nambu",
          	 	"twitt",     "perl",
            	"sphere",     "PEAR",
            	"java",     "wordpress",
            	"radian",     "crawl",
            	"yandex",     "eventbox",
            	"monitor",   "mechanize",
            	"facebookexternal"
			);
			
		foreach($bot_strings as $bot) { 
			if(strpos(strtolower($agente_usuario), $bot) !== false) return true;
		}
		
		return false;
	}


}
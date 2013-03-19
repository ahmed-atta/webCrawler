<?php

    define(HOST, "localhost");
    define(USER, "username");
    define(PASS, "password");
    define(DB, "database"); 

    
    // what type of sites do you want the crawler to visit?
	$searchString = "miami seo";

    $filterString = "";

    // search engines hate spaces
    $searchString = str_replace(' ', '+', $searchString);

    // how many search engine pages to crawl?
    $pages = 1;	

    // filter out certain sites and terms
    $filteredWords = array("google.com", "yahoo.com", ".png", ".jpeg", ".jpg", ".gif", "webcrawler", "altavista", "google", "search", "youtube");
    
    // start the bot - get URL's from the search engines
	getURLs($searchString, $pages, $filteredWords);


        function getURLs($searchString, $pages, $filteredWords) 
        {            

            while ($i < $pages)
            {               

            $searchEngine = pickServer($searchString, $page, $i);            

            $search = curl_init();

            curl_setopt($search, CURLOPT_URL, $searchEngine);

            curl_setopt($search, CURLOPT_RETURNTRANSFER, 1);

            sleep(5);

            $page = curl_exec($search);

            preg_match_all('/\b(?:(?:https?|ftp):\/\/|www\.)[-a-z0-9+&@#\/%?=~_|!:,.;]*[-a-z0-9+&@#\/%=~_|]/i', $page, $links);            

            $links = array_unique($links);

            $i++;

            }
            

            foreach ($links[0] as $key => $websites)
            {                

                if (in_array($websites, $filteredWords))
                {
                    unset($links[0][$key]);

                }
                foreach ($filteredWords as $filter)
                {
                    if (strpos($websites, $filter))
                    {
                        unset($links[0][$key]);
                    }
                }                              

            }

            

            foreach ($links[0] as $key => $websites)
            {        
                echo "$websites <br/>";                     

            }                   
        }
    

        function pickServer($searchString, $page, $i)
        {          

            $serverToUse = serverToUse();         

                if ($serverToUse == 'altavista')
                {    
                    if ($i > 1) 
                    {
                        $page = str_pad($i, 2 , "0");
                    }     

                    $searchEngine == "http://www.altavista.com/web/results?itag=ody&q=". $searchString . "&kgs=1&kls=1&stq=" . $page . ""; // http://www.altavista.com/web/results?q=krio+media&stq=10

                }
                else if ($serverToUse == 'google')
                {
                    if ($i > 1) 
                    {
                        $page = str_pad($i, 2 , "0");
                    }                      

                    $searchEngine = "http://www.google.com/search?q=". $searchString . "&start=" . $page . ""; // http://www.google.com/search?q=krio+media&start=20 

                }
                else if ($serverToUse == 'yahoo')
                {
                    if ($i > 1) 
                    {
                        $page = str_pad($i, 2 , "1");
                    }                      

                    $searchEngine = "http://search.yahoo.com/search?p=". $searchString . "&b=" . $page . ""; // http://search.yahoo.com/search?p=krio+media&b=21

                }
                else if ($serverToUse == 'bing')
                {
                    if ($i > 1) 
                    {
                        $page = str_pad($i, 2 , "1");
                    }                  

                    $searchEngine = "http://www.bing.com/search?q=". $searchString . "&first=" . $page . ""; // http://www.bing.com/search?q=krio+media&first=31

                }
                else if ($serverToUse == 'lycos')
                {
                     $searchEngine = "http://search.lycos.com/?query=". $searchString . "&page2=" . $i . ""; // http://search.lycos.com/?query=krio+media&page2=1

                }
                else if ($serverToUse == 'dogpile')
                {
                    if ($i > 1) 
                    {
                        $page = str_pad($i, 2 , "1");
                    }  

                    $searchEngine = "http://www.dogpile.com/dogpile/ws/results/Web/". $searchString . "/3/0/0/Relevance/zoom=off/qi=" . $page . "/qk=20/bepersistence=true/_iceUrlFlag=7?_IceUrl=true"; // http://www.dogpile.com/dogpile/ws/results/Web/krio%20media/3/0/0/Relevance/zoom=off/qi=11/qk=20/bepersistence=true/_iceUrlFlag=7?_IceUrl=true

                }
                else if ($serverToUse == 'oneriot')
                {                                  
                    $searchEngine = "http://www.oneriot.com/search?q=". $searchString . "&st=web&ot="; // http://www.oneriot.com/search?q=krio+media&st=web&ot= NO PAGES
                }
                else if ($serverToUse == 'icerocket')
                {                                 
                    $searchEngine = "http://www.icerocket.com/search?tab=web&p=" . $i . "&q=". $searchString . "&lng=&"; // http://www.icerocket.com/search?tab=web&p=3&q=krio+media&lng=&
                }
                else if ($serverToUse == 'aol')
                {                   
                    $searchEngine = "http://search.aol.com/aol/search?q=". $searchString . "&page=" . $i . ""; // http://search.aol.com/aol/search?q=krio+media&page=3
                }
                else if ($serverToUse == 'alltheweb')
                {
                    if ($i > 1) 
                    {
                        $page = str_pad($i, 2 , "0");
                    }  
                    $searchEngine = "http://www.alltheweb.com/search?q=". $searchString . "&o=" . $page . ""; // http://www.alltheweb.com/search?q=krio+media&o=20
                }
                else if ($serverToUse == 'gigablast')
                {
                    if ($i > 1) 
                    {
                        $page = str_pad($i, 2 , "0");
                    }  
                    $searchEngine = "http://www.gigablast.com/search?s=" . $page . "&q=". $searchString . ""; // http://www.gigablast.com/search?s=50&q=krio+media
                }
                else if ($serverToUse == 'rollyo')
                {
                    if ($i > 1) 
                    {
                        $page = str_pad($i, 2 , "1");
                    }                    
                    $searchEngine = "http://rollyo.com/search.html?q=". $searchString . "&sid=web&start=" . $page . ""; // http://rollyo.com/search.html?q=krio%20media&sid=web&start=31
                }
                else if ($serverToUse == 'business')
                {
                    if ($i > 1) 
                    {
                        $page = str_pad($i, 2 , "0");
                    }  
                    $searchEngine = "http://www.business.com/search/rslt_default.asp?type=web&stype=google&set=1&StartAt=" . $page . "&query=". $searchString . ""; // http://www.business.com/search/rslt_default.asp?type=web&stype=google&set=1&StartAt=30&query=krio+media
                }
                else if ($serverToUse == 'jayde')
                {
                    if ($i > 1) 
                    {
                        $page = str_pad($i, 2 , "5");
                    }  
                    $searchEngine = "http://directory.jayde.com/search?r=" . $page . "&q=". $searchString . ""; // http://directory.jayde.com/search?r=45&q=krio+media
                }
                
            return $searchEngine;

        }   

        // search engines won't allow you to bombard their site with requests, so you need to rotate them after each request. 
        function serverToUse()
        {           

            $chooseServer = mysql_connect(HOST, USER, PASS);
            mysql_select_db(DB, $chooseServer);   
                     
            // your list of server to use in the row should look like: bing, yahoo, google, dogpile, jayde, rollyo, alltheweb, icerocket, business, aol, lycos
            $getServers = "SELECT servers FROM servers WHERE id='1'";
            $servers = mysql_query($getServers);
            $serversfetch = mysql_fetch_assoc($servers);
            $listOfServers = $serversfetch[servers];
            $serversArray = explode(',', $listOfServers);
            $serverToUse = array_shift($serversArray);
            array_push($serversArray, $serverToUse);            

            $serversArrayComma = implode(",", $serversArray);

            $updateTable = "UPDATE servers SET servers='$serversArrayComma' WHERE id=1";

            mysql_query($updateTable);         
            mysql_close($chooseServer);
            return $serverToUse;

        }
        

		function goToWebsite($websites)
		{

			// create curl resource

	        $ch1 = curl_init();	

	        // set url

	        curl_setopt($ch1, CURLOPT_URL, "$personalwebsite/");	

	        //return the transfer as a string

	        curl_setopt($ch1, CURLOPT_RETURNTRANSFER, 1);
	

	        // $output contains the output string

	        $html = curl_exec($ch1);  

	        // close curl resource to free up system resources

	        curl_close($ch1);     

            // what do you want to look for?
			preg_match('//', $html, $info);

			if (!empty($info)) 
			{  
			    // do something with the $info that you gained from the document like insert it into a db
                
                $select_db = mysql_connect(HOST, USER, PASS);
				$connect_database = mysql_select_db(DB, $select_db);	
                mysql_query("INSERT INTO scraped (info) VALUES ('$info')");
			    mysql_close($select_db);

			}

		}

?>
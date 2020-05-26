<?php

class article extends dbclass {
	
	public function getArticle($from,$to,$lang){
		$query="SELECT * FROM article_meta INNER JOIN article ON article_meta.aid=article.aid where article_meta.status='active' AND article_meta.trending='yes' ";
		if($lang!='NA'){
			$query .= "AND  sub1='$lang' ";
		}
		$query .="ORDER BY article_meta.aid DESC LIMIT $from, $to"; 
		return $this->fetchResult($query);
	}
	public function getArticleByCategory($from,$to,$cate,$lang){
		$query="SELECT * FROM article_meta INNER JOIN article ON article_meta.aid=article.aid where article_meta.status='active' AND article_meta.trending='yes' AND category='$cate' ";
		if($lang!='NA'){
			$query .= " sub1='$lang' ";
		}
		$query .="ORDER BY article_meta.aid DESC LIMIT $from, $to"; 
		return $this->fetchResult($query);
	}

	public function getUserName($id){
		$query="SELECT name FROM users WHERE id=$id"; 
		return $this->fetchRow($query)['name'];
	}

	public function getAllCategory(){
		$sql = "SELECT * FROM category WHERE template='category-page' ORDER BY title ASC ";
		return $this->fetchResult($sql);
	}

	public function truncate($text, $length) {
	   $length = abs((int)$length);
	   if(strlen($text) > $length) {
	      $text = preg_replace("/^(.{1,$length})(\s.*|$)/s", '\\1...', $text);
	   }
	   return($text);
	}

	public function getShortContent($text, $lang, $suffix = '&hellip;', $isHTML = true) {
		$length = ($lang=='hindi') ? 1300 : 500 ;
		$text =  preg_replace('/<a href=\"(.*?)\">(.*?)<\/a>/', "\\2", $text);
    	$text = preg_replace("/<img[^>]+\>/i", "(image) ", $text);
    	$text = strip_tags($text);
    	$text = substr($text,0,$length);
    	$text = $text.$suffix;
		
		return $text;

}

	public function dateReplace($date){  
		$d = explode('-', $date);
		$dd = explode(' ',$d[2]);
		return $dd[0].'/'.$d[1].'/'.$d[0];
	}

	public function getSlug($article_id,$flag=null,$slug=null,$heading=null){
		if($flag!=null){
			return  ($flag==1) ? $slug : $this->filterSlug($heading);
		}
		else{
			$sql = "SELECT article.heading, article_meta.sub3, article_meta.sub4 FROM article_meta INNER JOIN article ON article_meta.aid=article.aid WHERE article.aid=$article_id";
			$r=$this->fetchRow($sql);
			if($r['sub4']==1){
				return $r['sub3'];
			}
			else{
				return $this->filterSlug($r['heading']);
			}
		}
	}

	function filterSlug($title){
		$title  = preg_replace('/([~@#$:;)(".,+!"])/', '', $title); // Removes special chars.
   		$title  = preg_replace('/%/', ' percent', $title); // Removes % symbol.
   		$title  = preg_replace('/&/', ' and ', $title); // Removes & symbol.
   		$title  = str_replace(' ', '-', $title); // Replaces all spaces with hyphens.
   		$title  = preg_replace('/-+/', '-', $title); // Replaces multiple hyphens with single one
		return $title;
	}
	
	public function cleanString($string)
	{
	  	// allow only letters
	  	$string = str_replace(' ', '-', $string);
	  	$string = str_replace(',', '-', $string);
	  	$string = str_replace('"', '-', $string);
	  	$string = str_replace('\'', '-', $string);
	  	$string = str_replace('`', '-', $string);
		$string = str_replace('%', '-percent', $string);
	  	$string = str_replace('&', '-and', $string);
	  	//$string = preg_replace("/[^a-zA-Z0-9-]/", "", $string);
	  	$string = preg_replace('/-+/', '-', $string);
	  	$string = strtolower($string);

  		return $string;
	}

	public function getCount($category, $lastID){
		if($category=='top'){
			$sql = "SELECT COUNT(*) as num_rows FROM article_meta INNER JOIN article ON article_meta.aid=article.aid where article.aid < '$lastID' AND article_meta.status='active'";
		}
		$r=$this->fetchRow($sql);
		if($r){
			return $r['num_rows'];
		} else {
			return NULL;
		}
	}
	
	public function getTopCount($lastID){	
		$sql = "SELECT COUNT(*) as num_rows FROM article_meta INNER JOIN article ON article_meta.aid=article.aid where article.aid < '$lastID' AND article_meta.status='active' ORDER BY article_meta.aid DESC";
		$r=$this->fetchRow($sql);
		if($r){
			return $r['num_rows'];
		} else {
			return NULL;
		}
	}
	public function getCategoryCount($category, $lastID){	
		$sql = "SELECT COUNT(*) as num_rows FROM article_meta INNER JOIN article ON article_meta.aid=article.aid where article.aid < '$lastID' AND article_meta.status='active' AND category='$category' ORDER BY article_meta.aid DESC";
		$r=$this->fetchRow($sql);
		if($r){
			return $r['num_rows'];
		} else {
			return NULL;
		}
	}
	function filterImage($string){
		if($string==''){
			//return SITE_URL.'/assets/images/article_image.jpeg';}
			return '#';}
		else if (strncmp($string, PROTOCOL, strlen(PROTOCOL)) === 0){
			return $string;}
		else{
			return 'http://alldatmatterz.com/'.$string;}
	}




	public function getLead(){
		$query="SELECT * FROM lead ORDER BY `date` DESC"; 
		$_SESSION['report'] = $query;
		return $this->fetchResult($query);
	}

	public function getURL(){
		$query="SELECT * FROM url ORDER BY `created` DESC"; 
		$_SESSION['url_report'] = $query;
		return $this->fetchResult($query);
	}

	public function getUser(){
		$query="SELECT * FROM user WHERE user_role=2 ORDER BY `updated` DESC"; 
		return $this->fetchResult($query);
	}

	// REPORT SECTION
	public function getSource(){
		$query="SELECT DISTINCT utm_source FROM lead"; 
		return $this->fetchResult($query);
	}
	public function getMedium(){
		$query="SELECT DISTINCT utm_medium FROM lead"; 
		return $this->fetchResult($query);
	}
	public function getContent(){
		$query="SELECT DISTINCT utm_content FROM lead"; 
		return $this->fetchResult($query);
	}
	public function getCampaign(){
		$query="SELECT DISTINCT utm_campaign FROM lead"; 
		return $this->fetchResult($query);
	}
	public function getTerm(){
		$query="SELECT DISTINCT utm_term FROM lead"; 
		return $this->fetchResult($query);
	}
	public function getURLContent(){
		$query="SELECT DISTINCT content FROM url ORDER BY `created` DESC"; 
		return $this->fetchResult($query);
	}

	public function getArticleWeb($from,$to,$website=null,$writer=null,$status=null){
		$from 	= $from.' 00:00:00';
      	$to 	= $to.' 23:59:59';
		$query ="SELECT article.*, website.name, writer.* FROM article JOIN website on article.website=website.id JOIN writer ON article.writer=writer.w_id WHERE article.date >='$from' and article.date <='$to' ";
		if($website!=null){
			$query .= "and website= '$website' ";
		}
		if($writer!=null){
			$query .= "and writer= '$writer' ";
		}
		if($status!=null){
			$query .= "and article.status= '$status' ";
		}
		$query .= "ORDER BY `date` DESC"; 
		return $this->fetchResult($query);
	}
	
} // END USER CLASS

// Create Object
$article = new article();

?>
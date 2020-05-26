<?php

require_once '../../config.php';
require_once CLASS_DIR.'/dbclass.php';
require_once CLASS_DIR.'/article.php';

if(isset($_POST['action']) && $_POST['action']=='loadMore' && $_POST['dataFrom']!=''){
	$ids = array();
	$lastID = $_POST['dataFrom'];
	$limit = 3;
	$language = $_POST['language'];
	$category = $_POST['category'];
	$success = 1;
	
	$hltd = NULL;
	$uid = NULL;

	$word_length = ($language=='hindi') ? 1300 : 500 ;

	if($category=='top'){
		$allNumRows = $article->getTopCount($lastID);
		$query = "SELECT * FROM article_meta INNER JOIN article ON article_meta.aid=article.aid where article.aid < '$lastID' AND article_meta.status='active' ";
		if($language!='NA'){
			$query .="AND sub1='$language' ";
		}
		$query .="ORDER BY article_meta.aid DESC LIMIT $limit";
	}


	else{
		$allNumRows = $article->getCategoryCount($category, $lastID);
		$query = "SELECT *  FROM article_meta INNER JOIN article ON article_meta.aid=article.aid where article.aid < '$lastID' AND article_meta.status='active' AND category='$category' ORDER BY article_meta.aid DESC LIMIT $limit";
	}
	
	
	
	$row = $db->fetchResult($query);
if($row){
	foreach($row as $data){
		if($hltd){
          $data['heading'] = preg_replace("/\s*?$hltd\s*/i", '<span style="background:#fbf46c;">$0</span>', $data['heading']);
      	}

      	$msg .='<div class="block">
      <div class="row">
        <div class="col-md-6">
          <div class="image-block" style="background-image: url(\''.$data['img1'].'\')">
          </div>
          <div class="meta-block">
            <span><strong>By </strong>'.$article->getUserName($data['uid']).'</span>
            <span><strong>On </strong>'.$article->dateReplace($data['timestamp']).'</span>
          </div>
        </div>
        <div class="col-md-6">
          <div class="content-block">
            <h1 class="heading">'.$data['heading'].'</h1>
            <p>'.$article->getShortContent($data['subhd1'],$language).'</p>
          </div>
        </div>
        <div class="readmore">
          <a target="_blanck" href="'.MAIN_SITE_URL."/article/".$data['aid']."/".$article->getSlug(1,$data['sub4'],$data['sub3'],$data['heading']).'">Read more</a>
        </div>
        <div class="social">
          <ul>
            <li><a onClick="window.open("http://www.facebook.com/sharer.php?s=100&amp;p[title]='.$data['heading'].'&amp;p[url]='.MAIN_SITE_URL."/article/".$data['aid']."/".$article->getSlug(1,$data['sub4'],$data['sub3'],$data['heading']).'&amp;&p[images][0]='.$data['img1'].'", "sharer", "toolbar=0,status=0,width=548,height=325");" target="_parent" href="javascript: void(0)"><img src="'.ASSETS_PATH.'/img/fb.png"></a></li>
            <li><a href="whatsapp://send?text='.MAIN_SITE_URL."/article/".$data['aid']."/".$article->getSlug(1,$data['sub4'],$data['sub3'],$data['heading']).'" data-action="share/whatsapp/share"><img src="'.ASSETS_PATH.'/img/wp.png"></a></li>
          </ul>
        </div>

        </div>
      </div>';



		$lastID = $data['aid'];
		$uid 	= $data['uid']; 
	}

	$msg .='<div class="text-center" style="display: none;">
        <button type="button" class="load_more btn btn-theam" data-action="loadMore" data-url="'.ACTION_PATH.'/load_content.php" data-lang="'.$language.'" data-category="'.$category.'" data-from="'.$lastID.'" id="">Load More <span id="load_more_span" class="badge">'.$article->getCount($category, $lastId).'</span></button></div>';
	
	
	
}


    
//	$msg = htmlentities( $msg ); 
	echo $msg;
  
	
	//$responce = array('response'=> $success, 'msg'=> $msg, 'last'=>$lastID);
	//echo json_encode($responce,true);

}



<?php 
    require_once 'config.php'; 
    require_once CLASS_DIR.'/dbclass.php';
    require_once CLASS_DIR.'/article.php';


    $from = 0;
    $to = 20;
    $lang = $_GET['lang'] ? $_GET['lang'] : 'NA';

    $cate = $_GET['cate'] ? $_GET['cate'] : 'top';

    if($cate=='top')
      $articles = $article->getArticle($from,$to,$lang);
    else
      $articles = $article->getArticleByCategory($from,$to,$cate,$lang);

    $word_length = ($lang=='hindi') ? 1300 : 500 ;
?>
<!doctype html>

<html lang="en">
  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    <link rel="stylesheet" href="<?=ASSETS_PATH?>/css/style.css">
    <link rel="shortcut icon" href="http://alldatmatterz.com/assets/images/favicon.ico" type="image/x-icon">
    <title>Inshorts | All Dat Matterz</title>
  </head>
  <body>
    <div id="overlay" onclick="closeNav()" class="overlay"></div>
    <!-- Sidebar navigation -->
      <?php $menu = $article->getAllCategory();  ?>
      <div id="mySidenav" class="sidenav pb-4">
      <!--  <a href="javascript:void(0)" class="closebtn" onclick="closeNav()">&times;</a> -->
          <?php foreach($menu as $item){ ?>
          <a href="<?=SITE_URL.'?cate='.$item['slug']; ?>"><img src="<?php  echo (!empty($item['icon'])) ? $item['icon'] : IMAGE_PATH.'/home.ico' ?>"><?=$item['title']; ?></a>

          <?php } ?>
          
        <ul class="sidenav-footer">
          <li><a href="<?=MAIN_SITE_URL ?>/about_us/">About us</a></li>
          <li><a href="<?=MAIN_SITE_URL ?>/privacy_policy/">Privacy & Policy</a></li>
          <li><a href="<?=MAIN_SITE_URL ?>/term_and_condition/">Term & Condition</a></li>
        </ul>
      </div>
    <!-- End ofSidebar navigation -->

    <nav class="navbar navbar-expand-lg navbar-light  bg-theam fixed-top">
      <!-- <button  class="btn btn-menu"> -->
          <a id="navicon-button" class="navicon-button x"><div class="navicon"></div></a>
          <!-- </button> -->
          
          <div class="dropdown">
            <a class="btn btn-secondary dropdown-toggle" href="#" role="button" id="dropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
              <img src="http://alldatmatterz.com/assets/images/lang.png">
            </a>

            <div class="dropdown-menu" aria-labelledby="dropdownMenuLink">
              <a class="dropdown-item" href="<?=APP_URL ?>/?lang=hindi">
                <img src="http://alldatmatterz.com/assets/images/hindi.jpg"> Hindi
              </a>
              <a class="dropdown-item" href="<?=APP_URL ?>/?lang=english">
                <img src="http://alldatmatterz.com/assets/images/english.jpg"> English
              </a>
            </div>
          </div>
          <a class="navbar-brand" href="<?=APP_URL?>"><img src="http://alldatmatterz.com/assets/images/adm_logo_main.png"></a>
      </nav>


    <div class="container-fluid mt-6" id="loadResult">

      <?php foreach($articles as $key =>$value){ ?>
      <div class="block">
      <div class="row">
        <div class="col-md-6">
          <div class="image-block" style="background-image: url('<?=$value['img1']; ?>')">
          </div>
          <div class="meta-block">
            <span><strong>By </strong><?=$article->getUserName($value['uid']); ?></span>
            <span><strong>On </strong><?=$article->dateReplace($value['timestamp']); ?></span>
          </div>
        </div>
        <div class="col-md-6">
          <div class="content-block">
            <h1 class="heading"><?=$value['heading'] ?></h1>
            <p><?=$article->getShortContent($value['subhd1'],$lang) ?></p>
            
          </div>
        </div>
        <div class="social">
          <ul>
            <li><a href=""><img src="<?=ASSETS_PATH ?>/img/fb.png"></a></li>
            <li><a href=""><img src="<?=ASSETS_PATH ?>/img/wp.png"></a></li>
          </ul>
        </div>
        <div class="readmore">
          <a target="_blanck" href="<?php echo MAIN_SITE_URL."/article/".$value['aid']."/".$article->getSlug(1,$value['sub4'],$value['sub3'],$value['heading']); ?>">Read more</a>
        </div>
        <div class="social">
          <ul>
            <li><a target="_blank" href="https://www.facebook.com/sharer/sharer.php?u=<?php echo MAIN_SITE_URL."/article/".$value['aid']."/".$article->getSlug(1,$value['sub4'],$value['sub3'],$value['heading']); ?>"><img src="<?=ASSETS_PATH ?>/img/fb.png"></a></li>
            <li><a href="whatsapp://send?text=<?php echo MAIN_SITE_URL."/article/".$value['aid']."/".$article->getSlug(1,$value['sub4'],$value['sub3'],$value['heading']); ?>" data-action="share/whatsapp/share"><img src="<?=ASSETS_PATH ?>/img/wp.png"></a></li>
          </ul>
        </div>
      </div>
      </div>
      
    <?php $lastId=$value['aid']; } ?>
    
       <div class="text-center" style="display: none;">
        <button type="button" class="load_more btn btn-theam" data-action="loadMore" data-url="<?php echo ACTION_PATH ?>/load_content.php" data-lang="<?=$lang; ?>" data-category="<?php echo $cate; ?>" data-from="<?php echo $lastId; ?>" id="">Load More <span id="load_more_span" class="badge"><?php echo ($article->getCount($cate, $lastId)); ?></span></button>
      </div>
    </div>

    
    <div class="container">
      <!--<div id="loading" style="text-align:center;"><img src="<?=ASSETS_PATH ?>/img/loader.gif" /></div>-->
      <!-- <div class="text-center" style="display: none;">-->
      <!--  <button type="button" class="btn btn-theam" data-action="loadMore" data-url="<?php echo ACTION_PATH ?>/load_content.php" data-lang="<?=$lang; ?>" data-category="<?php echo $cate; ?>" data-from="<?php echo $lastId; ?>" id="load_more">Load More <span id="load_more_span" class="badge"><?php echo ($article->getCount($cate, $lastId)); ?></span></button>-->
      <!--</div>-->
      <div id="loading" style="text-align:center;"><img src="<?=ASSETS_PATH ?>/img/loader.gif" /></div>
      <div class="footer m-4">
        <p class="m-0 text-center text-dark">Copyright © ADM 2019</p>
      </div>
    </div>


  <script>
function openNav() {
  document.getElementById("mySidebar").style.width = "295px";
  document.getElementById("main").style.marginLeft = "295px";
}

function closeNav() {
  document.getElementById("mySidebar").style.width = "0";
  document.getElementById("main").style.marginLeft= "0";
}
</script>
    <!-- Optional JavaScript -->
    <!-- jQuery first, then Popper.js, then Bootstrap JS -->
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
    <script src="https://code.jquery.com/jquery-3.1.1.min.js"></script>
    <script src="<?=ASSETS_PATH  ?>/js/custom.js"></script>
  </body>
</html>
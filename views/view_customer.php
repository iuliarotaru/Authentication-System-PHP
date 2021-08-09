 <?php
  //Check if the user is logged in
  session_start();
  if (!isset($_SESSION['uuid'])) {
    header('Location: /login');
    exit();
  }
  //Check if the user is a customer
  if ($_SESSION['role'] != 1) {
    header('Location: /therapist');
    exit();
  }

  require_once($_SERVER['DOCUMENT_ROOT'] . '/views/view_top.php');
  require_once(__DIR__ . '/../db/db.php');

  try {
    $q = $db->prepare('SELECT * FROM users WHERE uuid = :user_uuid'); //doar ce trebuie
    $q->bindValue(':user_uuid', $_SESSION['uuid']);
    $q->execute();
    $user = $q->fetch();
    if (!$user) {
      header('Location: /login');
      exit();
    }
  ?>
   <div class="admin_main">
     <h1 class="hi_user">Hi there <?php echo "$user->name" ?>! Welcome</h1>
     <button class="home_menu" onclick="toggleHomeMenu()">
       <span>Home menu</span>
       <i class="fa fa-bars fa-lg hamburger"></i>
     </button>
     <div class="admin_right hide_home_links">
       <button class="talk_with_therapist">Talk with a therapist</button>
     </div>
     <div class="admin_left hide_home_links">
       <h4 class="menu">Menu</h4>
       <a href="" class="selected"><i class="fa fa-home fa-fw" aria-hidden="true"></i>Home</a>
       <a href=""><i class="fa fa-file fa-fw" aria-hidden="true"></i>Topics</a>
       <a href=""><i class="fa fa-bookmark fa-fw" aria-hidden="true"></i>Saved</a>
       <a href=""><i class="fa fa-check fa-fw" aria-hidden="true"></i>Following</a>
     </div>

     <!-- <a href="/logout">Log out</a>
   <a href="/delete">Delete account</a>
   <a href="/update">Profile information</a> -->

     <?php
      $q = $db->prepare('SELECT posts.post_id, title, body, likes.like_id, count(number_likes.like_id) as likes FROM posts LEFT JOIN likes ON likes.post_id = posts.post_id AND likes.user_id = :uuid LEFT JOIN likes as number_likes ON number_likes.post_id = posts.post_id GROUP BY posts.post_id');
      $q->bindValue(':uuid', $_SESSION['uuid']);
      $q->execute();
      $posts = $q->fetchAll();

      ?>
     <div id="posts">
       <?php
        foreach ($posts as $post) {
        ?>
         <div class="post" id="<?= $post->post_id ?>">
           <h2><?= $post->title ?></h2>
           <p id="post_text"><?= substr($post->body, 0, 300) ?><span id="points">...</span><span id="moreText"><?= substr($post->body, 300) ?></span>
             <button onclick="toggleText()" id="textButton">Read more</button>
           </p>
           <div class="position_likes">
             <div class="author">
               <img src="/assets/male-avatar.png" alt="male profile" class="author_image">
               Posted by: <b>John Doe</b>
             </div>
             <div class="likes">
               <div>
                 <?php if (!$post->like_id) { ?>
                   <button id="like-button" class="icon icon-like" onclick="likePost('<?= $post->post_id ?>')"> </button> <?php } else { ?>
                   <button id="dislike-button" class="icon icon-liked" onclick="dislikePost('<?= $post->post_id ?>')"></button> <?php } ?>
               </div>
               <p id="likes"><?= $post->likes ?></p>
             </div>
           </div>
         </div>
       <?php
        }
        ?>
     </div>
   </div>
 <?php
  } catch (PDOException $ex) {
    echo $ex;
  }

  ?>
 <script src="../javascript/general.js"></script>
 <script src="../javascript/like_dislike_post.js"></script>
 <?php
  require_once($_SERVER['DOCUMENT_ROOT'] . '/views/view_bottom.php');
  ?>
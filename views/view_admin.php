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
    $q = $db->prepare('SELECT * FROM users WHERE uuid = :user_uuid');
    $q->bindValue(':user_uuid', $_SESSION['uuid']);
    $q->execute();
    $user = $q->fetch();
    if (!$user) {
      header('Location: /login');
      exit();
    }
  ?>
   <h1>Hi there <?php echo "$user->name" ?>!Welcome</h1>
   <img src="/images/<?= $user->image_path ?>" class="user-img" id="image_placeholder" />
   <a href="/logout">Log out</a>
   <a href="/delete">Delete account</a>
   <a href="/update">Profile information</a>

   <?php
    $q = $db->prepare('SELECT posts.post_id, title, body, likes.like_id, count(number_likes.like_id) as likes FROM posts LEFT JOIN likes ON likes.post_id = posts.post_id AND likes.user_id = :uuid LEFT JOIN likes as number_likes ON number_likes.post_id = posts.post_id GROUP BY posts.post_id');
    $q->bindValue(':uuid', $_SESSION['uuid']);
    $q->execute();
    $posts = $q->fetchAll();


    foreach ($posts as $post) {
    ?>
     <div>
       <h2><?= $post->title ?></h2>
       <p><?= substr($post->body, 0, 300) ?><span id="points">...</span><span id="moreText"><?= substr($post->body, 300) ?></span>
         <button onclick="toggleText()" id="textButton">Read more</button>
       </p>
       <p>Posted by: <b>John Doe</b></p>
       <div>
         <?php if (!$post->like_id) { ?>
           <button id="like-button" class="icon icon-like" onclick="like_post('<?= $post->post_id ?>')"> </button> <?php } else { ?>
           <button id="dislike-button" class="icon icon-liked" onclick="dislike_post('<?= $post->post_id ?>')"></button> <?php } ?>
       </div>
       <p id="likes"><?= $post->likes ?></p>
     </div>
 <?php
    }
  } catch (PDOException $ex) {
    echo $ex;
  }

  require_once($_SERVER['DOCUMENT_ROOT'] . '/views/view_bottom.php');
  ?>
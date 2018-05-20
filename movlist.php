<?php
include_once "dbh.inc.php";
include "comment.inc.php";
?>
<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <title>영화목록</title>
  <style>
  body{
    background-color: lightgrey;
  }
    header{
      font-size:80px;
      color:rgba(180,20,20,0.8);
      text-align: center;
      margin-bottom: 30px;
    }
    #pic{
      column-width:200px;
      display: inline-block;
      width:300px;
      margin-left: 3%;

    }
    #pic figure{
      display:inline-block;
      border:2px solid rgba(0,0,0,0.2);
      margin:5px;
      column-gap:15px;
      margin-bottom:20px;

    }
    #pic figure img{
      width:300px;
    }
    #pic figure figcaption{
      padding:10px;
      margin-top:10px;
      border-top:1px solid rgba(0,0,0,0.2);
      text-align:center;
    }
    .button{
      width:100%;
      height:30px;
    }
    .button1{
      width:30%;
      height:40px;
      font-size:20px;
    }

  </style>
</head>
<body>
  <?php
  if(isset($_SESSION['customer_id'])){
    echo "<p style='background-color:rgba(255,255,255,0.8)' class='welcome'>You are logged in
    <span style='color:rgba(255,30,30,0.9)'>".$_SESSION['username']."</span></p>";
  }else{
    echo "Nobody is logged in";
  }?>
  <header>
    JDBC
  </header>
  <!-- <form action="login.html" method="post">
    <button class="button1" type="submit" name="Reservation">Reservation</button>
    <button class="button1" type="submit" name="myAccount">myAccount</button>
  </form> -->

  <?php
  $rlt = mysqli_query($conn,"SELECT * FROM MovieInfoList");
  while($List = mysqli_fetch_array($rlt)){
    ?>
  <div id="pic">
    <figure>
      <img src="<?php echo $List['poster_img'];?>"/>
      <figcaption><?php echo $List['title']?></figcaption>
      <figcaption><?php echo $List['genre']?></figcaption>
      <figcaption><?php echo $List['running_time']?></figcaption>
      <figcaption><?php echo $List['release_date']?></figcaption>
      <figcaption><?php echo $List['director']?></figcaption>
      <figcaption><?php echo $List['actor']?></figcaption>
      <figcaption><?php echo $List['is_rated']?></figcaption>
      <figcaption><?php
            $content = $List['content'];
            //echo strlen($content);
            if(strlen($content) > 80){
                echo iconv_substr($content,0,80, "utf-8").'...';
            }
            else echo $content;?></figcaption>
      <figcaption><?php echo $List['studio']?></figcaption>
      <?php  echo "<form method='POST' action='comment.php'>
        <input type='hidden' name='movie_id' value='".$List['movie_id']."'>
        <button class='button' name='lookinfo'>
        영화정보보기</button>
      </form>";
      ?>
    </figure>
  </div>
<?php } ?>
</body>
</html>

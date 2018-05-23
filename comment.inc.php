<?php
session_start();


function setComments($conn){
  if(isset($_POST['submitcomment'])){
    $cid=$_POST['customer_id'];
    $date=$_POST['date'];
    $message=$_POST['message'];
    $movie_id=$_SESSION['movie_id'];
    $starpoint=$_POST['starpoint'];

    $sql="INSERT INTO commentlist (starpoint, movie_id, customer_id, date, message) VALUES ('$starpoint','$movie_id','$cid','$date','$message')";
    $result=mysqli_query($conn,$sql);
  }
}

function getComments($conn){
  echo "<div class='order'>Order by: ";
  echo "<form method='POST' action='comment.php'>
  <input type='hidden' name='customer_id' value='".$_SESSION['customer_id']."'>
  <input type='hidden' name='date' value='".date('Y-m-d H:i:s')."'>
  <button type='submit' class='btn' name='orderLike'>Most Likes</button>
  <button type='submit' class='btn 'name='orderRecent'>Most Recent</button></form></div>";

  $movie_id=$_SESSION['movie_id'];
  $sql="";
  if(isset($_POST['orderRecent'])){
    $sql="SELECT * FROM customerlist NATURAL JOIN (SELECT * FROM commentlist)cm WHERE cm.movie_id='$movie_id' ORDER BY date DESC";
  }elseif(isset($_POST['orderLike'])){
    $sql="SELECT * FROM customerlist NATURAL JOIN(SELECT * FROM commentlist NATURAL JOIN (SELECT * FROM countlikenum)likenum WHERE likenum.comment_id=commentlist.comment_id)cm WHERE cm.movie_id='$movie_id'ORDER BY counter DESC;";
  }else{
    $sql="SELECT * FROM customerlist NATURAL JOIN (SELECT * FROM commentlist)cm WHERE cm.movie_id='$movie_id'";
  }
  
  $result=mysqli_query($conn,$sql);
  while($row=mysqli_fetch_assoc($result)){
      echo "<div class='comm_box'>";
      echo "<div class='titleBox' id='starpoint'><label><span style='font-weight:bold;'>Starpoint: </span>".$row['starpoint']."</label></div>";
      echo "<div class='titleBox'><label>".$row['username']."</label></div>";
      echo "<div class='titleBox'><label>".$row['date']."</label></div>";
      echo "<form class='delete' method='POST' action='".deleteComments($conn)."'>
        <input type='hidden' name='movie_id' value'".$row['movie_id']."'>
        <input type='hidden' name='customer_id' value='".$row['customer_id']."'>
        <input type='hidden' name='comment_id' value='".$row['comment_id']."'>
        <button type='submit' class='btn' name='delete'>Delete</button>
        </form>
        <form class='edit' method='POST' action='editcomment.php'>
          <input type='hidden' name='customer_id' value='".$row['customer_id']."'>
          <input type='hidden' name='comment_id' value='".$row['comment_id']."'>
          <input type='hidden' name='message' value='".$row['message']."'>
          <button class='btn'>Edit</button>
        </form>";
      echo "<div class='commentBox'><p class='taskDescription'>".$row['message']."</p></div>";
      echo "<form class='like' method='POST' action='".like($conn)."'>
        <input type='hidden' name='comment_id' value='".$row['comment_id']."'>
        <button type='submit' class='btn' name='liked'>Like</button>
        <button type='submit' class='btn' name='disliked'>Dislike</button>
        </form>";
      $comm=$row['comment_id'];
      $sqltwo="SELECT COUNT(comment_id) AS count FROM likelist WHERE comment_id='$comm'";
      $resulttwo=mysqli_query($conn,$sqltwo);
      $rowtwo=mysqli_fetch_assoc($resulttwo);
      echo "<br><img src='likebutton.png' style='width:35px;'>";
      echo $rowtwo['count'];
      echo "</div>";

  }
}

function editComments($conn){
  if(isset($_POST['editcomment'])){
    $comment_id=$_POST['comment_id'];
    $date=$_POST['date'];
    $message=$_POST['message'];

    $sql="UPDATE commentlist SET message='$message', date='$date' WHERE comment_id='$comment_id'";
    $result=mysqli_query($conn,$sql);
    header("Location: movlist.php?Success");
  }
}

function deleteComments($conn){
  if(isset($_POST['delete'])){
    $comment_id=$_POST['comment_id'];
    $cid=$_POST['customer_id'];

    if($cid==$_SESSION['customer_id']){
      $sqltwo="DELETE FROM commentlist WHERE comment_id='$comment_id'";
      $result=mysqli_query($conn,$sqltwo);
      movieDisplay($conn);
    }else{
      header("Location: movlist.php?wrongUserDenyDelete");
    }
  }
}

function movieDisplay($conn){
  if(isset($_POST['lookinfo'])){
    $movie_id=$_POST['movie_id'];
    $_SESSION['movie_id']=$movie_id;

    $sql="SELECT * FROM movieinfolist WHERE movie_id='$movie_id'";
    $result=mysqli_query($conn,$sql);
    $List=mysqli_fetch_assoc($result);
    echo "
    <table class='movie'>
    <tr>
      <th rowspan='11'>
      <img src='".$List['poster_img']."' class='pic' '></th>
      <th>제목 : </th>
      <td>".$List['title']."</td>
    </tr>
    <tr>
      <th>장르 : </th>
      <td>".$List['genre']."</td>
    </tr>
    <tr>
      <th>런닝타임 : </th>
      <td>".$List['running_time']."</td>
    </tr>
    <tr>
      <th>개봉일자 : </th>
      <td>".$List['release_date']."</td>
    </tr>
    <tr>
      <th>제한연령 : </th>
      <td>".$List['is_rated']."</td>
    </tr>
    <tr>
      <th>제작사 : </th>
      <td>".$List['studio']."</td>
    </tr>
    <tr>
      <th>감독 : </th>
      <td>".$List['director']."</td>
    </tr>
    <tr>
      <th>배우 : </th>
      <td>".$List['actor']."</td>
    </tr>
    </table><br><br>";
    echo "<div class='summary'><p><span style='font-weight:bold;'>줄거리</span><br><br> : ".$List['content']."</p></div>";

  }

}
function like($conn){
  if(isset($_POST['liked'])){
  $comment_id=$_POST['comment_id'];
  $current_login=$_SESSION['customer_id'];
  mysqli_query($conn,"INSERT INTO likelist(comment_id, customer_id) VALUES('$comment_id','$current_login')");
  movieDisplay($conn);
  }
  if(isset($_POST['disliked'])){
  $comment_id=$_POST['comment_id'];
  $current_login=$_SESSION['customer_id'];
  mysqli_query($conn,"DELETE FROM likelist WHERE comment_id='$comment_id' AND customer_id='$current_login'");
  movieDisplay($conn);
  }
}

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

    exit();
  }
}

function getComments($conn){
  $movie_id=$_SESSION['movie_id'];
  $sql="SELECT * FROM customerlist NATURAL JOIN (SELECT * FROM commentlist)cm WHERE cm.movie_id='$movie_id'";
  $result=mysqli_query($conn,$sql);
  while($row=mysqli_fetch_assoc($result)){
      echo "<div class='comm_box'>";
      echo "<div class='titleBox' id='starpoint'><label>Rating: ".$row['starpoint']."</label></div>";
      echo "<div class='titleBox'><label>".$row['username']."</label></div>";
      echo "<div class='titleBox'><label>".$row['date']."</label></div>";
      echo "<form class='delete' method='POST' action='".deleteComments($conn)."'>
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
    }else{
      header("Location: movlist.php?wrongUserDenyDelete");
    }
  }
}

function orderBy($conn){
  // $sql="";
  // if(!isset($_POST['orderRecent'])){
  //   $sql="SELECT * FROM customerlist NATURAL JOIN (SELECT * FROM commentlist)cm WHERE cm.movie_id='$movie_id'";
  // }else{
  //   $sql="SELECT * FROM customerlist NATURAL JOIN (SELECT * FROM commentlist)cm WHERE cm.movie_id='$movie_id' ORDER BY date DESC";
  // }
}

function movieDisplay($conn){
  if(isset($_POST['lookinfo'])){
    $movie_id=$_POST['movie_id'];
    $_SESSION['movie_id']=$movie_id;

    $sql="SELECT poster_img FROM movieinfolist WHERE movie_id='$movie_id'";
    $result=mysqli_query($conn,$sql);
    $List=mysqli_fetch_assoc($result);
    echo "
    <div class='comm_box'><img src='".$List['poster_img']."' class='pic'>
    </div>";
  }

}
function like($conn){
  if(isset($_POST['liked'])){
  $comment_id=$_POST['comment_id'];
  $current_login=$_SESSION['customer_id'];
  mysqli_query($conn,"INSERT INTO likelist(comment_id, customer_id) VALUES('$comment_id','$current_login')");
  header("Location: comment.php?LikeClicked");
  }
  if(isset($_POST['disliked'])){
  $comment_id=$_POST['comment_id'];
  $current_login=$_SESSION['customer_id'];

  header("Location: comment.php?DislikeClicked");

  mysqli_query($conn,"DELETE FROM likelist WHERE comment_id='$comment_id' AND customer_id='$current_login'");
  exit();
  }
}

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

    header("Location: comment.php?commentMadeSuccessfully");
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
        <input type='hidden' name='customer_id' value='".$row['customer_id']."'>
        <input type='hidden' name='comment_id' value='".$row['comment_id']."'>
        <button type='submit' class='btn' name='liked'>Like</button>
        </form>";
      echo $row['likes'];
      echo "</div>";


  }
}

function editComments($conn){
  if(isset($_POST['editcomment'])){
    $customer_id=$_POST['customer_id'];
    $comment_id=$_POST['comment_id'];
    $date=$_POST['date'];
    $message=$_POST['message'];

    $sql="UPDATE commentlist SET message='$message', date='$date' WHERE comment_id='$comment_id'";
    $result=mysqli_query($conn,$sql);
    printf("%d", mysqli_affected_rows());
    header("Location: comment.php?Success");
  }

}

function deleteComments($conn){
  if(isset($_POST['delete'])){
    $comment_id=$_POST['comment_id'];
    $cid=$_POST['customer_id'];

    if($cid==$_SESSION['customer_id']){
      $sqltwo="DELETE * FROM commentlist WHERE comment_id='$comment_id'";
      mysqli_query($conn,$sqltwo);

      header("Location: comment.php?");
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
  $customer_id=$_POST['customer_id'];
  $comment_id=$_POST['comment_id'];
  $sql="SELECT * FROM commentlist WHERE comment_id='$comment_id'";
  $result=mysqli_query($conn,$sql);
  $row=mysqli_fetch_assoc($result);
  $N=$row['likes'];

  mysqli_query($conn,"UPDATE commentlist SET likes='$N'+1 WHERE comment_id='$comment_id'");
  mysqli_query($conn,"INSERT INTO likes(customer_id,comment_id) VALUES('$customer_id','$comment_id')");
  exit();
  }
  //
  // if(isset($_POST['unliked'])){
  // $customer_id=$_SESSION['customer_id'];
  // $comment_id=$_POST['comment_id'];
  // $sql="SELECT * FROM commentlist WHERE comment_id='$comment_id'";
  // $result=mysqli_query($conn,$result);
  // $row=mysqli_fetch_assoc($result);
  // $N=$row['likes'];
  //
  // mysqli_query($conn,"DELETE FROM likes WHERE comment_id='$comment_id' AND customer_id='$customer_id'");
  // mysqli_query($conn,"UPDATE commentlist SET likes='$n'-1 WHERE comment_id='$comment_id'");
  // exit();
  // }
}

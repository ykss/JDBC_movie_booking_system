<?php
session_start();

function setComments($conn){
  if(isset($_POST['submitcomment'])){
    $cid=$_POST['customer_id'];
    $date=$_POST['date'];
    $message=$_POST['message'];

    $sql="INSERT INTO commentlist (customer_id, date, message) VALUES ('$cid','$date','$message')";
    $result=mysqli_query($conn,$sql);

    header("Location: comment.php?commentMadeSuccessfully");
  }
}

function getComments($conn){
  $sql="SELECT * FROM customerlist NATURAL JOIN commentlist";
  $result=mysqli_query($conn,$sql);
  while($row=mysqli_fetch_assoc($result)){
      echo "<div class='comm_box'>";
      echo "<div class=titleBox'><label>".$row['username']."</label></div>";
      echo "<form class='delete' methond='POST' action='".deleteComments($conn)."'>
        <input type='hidden' name='customer_id' value='".$row['customer_id']."'>
        <button type='submit' class='delete_btn' name='Delete'>Delete</button>
        </form>
        <form class='edit' methond='POST' action='editcomment.php'>
          <input type='hidden' name='customer_id' value='".$row['customer_id']."'>
          <input type='hidden' name='comment_id' value='".$row['comment_id']."'>
          <input type='hidden' name='message' value='".$row['message']."'>
          <button class='edit_btn'>Edit</button>
        </form>";
      echo "<div class='commentBox'><p class='taskDescription'>".$row['message']."</p></div>";
      echo "</div>";



  }
}

function editComments($conn){
  if(isset($_POST['commentSubmit'])){
    $comment_id=$_POST['customer_id'];
    $uid=$_POST['comment_id'];
    $date=$_POST['date'];
    $message=$_POST['message'];

    $sql="UPDATE commentlist SET message='$message' WHERE customer_id='$comment_id'";
    $result=mysqli_query($conn,$sql);
    header("Location: comment.php");
  }

}

function deleteComments($conn){
  if(isset($_POST['Delete'])){
    $customer_id=$_POST['customer_id'];
    header("Location: comment.php?Hi");

    if($_SESSION['customer_id']===$customer_id){
      $sql="DELETE * FROM commentlist WHERE comment_id='$comment_id'";
      $result=mysqli_query($conn,$sql);
      header("Location: comment.php?successDelete");
    }else{
      header("Location: comment.php?wrongUserDenyDelete");
    }
  }
}

function userLogout(){
  if(isset($_POST['logoutSubmit'])){
    session_start();
    session_destroy();
    header("Location: comment.php");
    exit();
  }
}

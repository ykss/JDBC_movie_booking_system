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
    header{
      font-size:80px;
      color:rgba(180,20,20,0.8);
      text-align: center;
      margin-bottom: 30px;
    }
  .rank{
    text-align:center;
    margin-top:10px;
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
      echo "<span style='color:rgba(255,30,30,0.9)'>".$_SESSION['username']."님이 로그인하셨습니다.</span>";
  }else{
    echo "Nobody is logged in";
  }?>
  <h1 style="text-align:center;">ALL Movies in JDBC Theater</h1>


  <form class="rankstd" action="movlist.php" method="post" >
      <div class="rank">
        <p class="rate">영화 검색</p>
        <?php $selectedSearch = isset($_POST['find'])?$_POST['find']:''; ?>
      <select class="std" name="find">
        <option <?php if($selectedSearch == 'all'){echo("selected");}?> value="all">전체</option>
        <option <?php if($selectedSearch == 'title'){echo("selected");}?> value="title">제목으로 찾기</option>
        <option <?php if($selectedSearch == 'director'){echo("selected");}?> value="director">감독으로 찾기</option>
        <option <?php if($selectedSearch == 'actor'){echo("selected");}?> value="actor">배우로 찾기</option>
      </select>
      <input type="text" name="search" placeholder="키워드를 입력하세요." />
      <input type="submit" name="submit" value="검색" />
        <?php
        if(isset($_POST['search'])){
          $searchq = $_POST['search'];
        } ?>
        <br><br>
        <?php
        $sql = "SELECT * FROM MovieInfoList WHERE title LIKE '%요건%'";
        switch ($selectedSearch) {
          case 'title':
              $sql = isset($selectedSearch) ? "SELECT * FROM MovieInfoList WHERE title LIKE '%".$searchq."%'" : '';
              break;
          case 'director':
              $sql = isset($selectedSearch) ? "SELECT * FROM MovieInfoList WHERE director LIKE '%".$searchq."%'" : '';
              break;
          case 'actor':
              $sql= isset($selectedSearch) ? "SELECT * FROM MovieInfoList WHERE actor LIKE '%".$searchq."%'" : '';
              break;
          case 'all':
              $sql= isset($selectedSearch) ? "SELECT * FROM MovieInfoList WHERE title LIKE '%$searchq%' OR actor LIKE '%$searchq%' OR director LIKE '%$searchq%'" : '';
              break;
        }
          ?>
          </div>
        </form>
        <?php
          if($result = mysqli_query($conn,$sql)){
            while($row = mysqli_fetch_array($result)){
              ?>
              <div id="pic">
                <figure>
                  <img src="<?php echo $row['poster_img'];?>"/>
                  <figcaption><?php echo '제목 : '.$row['title']?></figcaption>
                  <figcaption><?php echo '장르 : '.$row['genre']?></figcaption>
                  <figcaption><?php echo '런닝타임 : '.$row['running_time'].'분'?></figcaption>
                  <figcaption><?php echo '개봉일자 : '.$row['release_date']?></figcaption>
                  <figcaption><?php echo '제한연령 : '.$row['is_rated'].'세 이상'?></figcaption>
                  <figcaption><?php echo '제작사 : '.$row['studio']?></figcaption>
                  <?php  echo "<form method='POST' action='comment.php'>
                    <input type='hidden' name='movie_id' value='".$row['movie_id']."'>
                    <button class='button' name='lookinfo'>
                    영화정보보기</button>
                  </form>";
                  ?>
                  <?php  echo "<form method='POST' action='reserve.php'>
                    <input type='hidden' name='movie_id' value='".$row['movie_id']."'>
                    <button class='button' name='makereserve'>
                    예매하기</button>
                  </form>";
                  ?>
                </figure>
              </div>
      <?php } ?>
    <?php  } ?>
  <form class="rankstd" action="movList.php" method="post">
    <div class="rank">
      <p class="rate" style="text-align:center;">전체 영화목록</p>
      <?php
        $selected = isset($_POST['std'])? $_POST['std']:'';
      ?>
      <select class="std" name="std">
        <option <?php if($selected == 'starpoint'){echo("selected");}?> value = "starpoint">평점순</option>
        <option <?php if($selected == 'reserved_rate'){echo("selected");}?> value = "reserved_rate">예매율순</option>
        <option <?php if($selected == 'release_date'){echo("selected");}?> value = "release_date">개봉일순</option>
        <option <?php if($selected == 'title'){echo("selected");}?> value = "title">제목순</option>
      </select>
      <?php
      $order = '';
      $selectedOption = isset($_POST['std']) ? $_POST['std'] : 'starpoint';
      switch ($selectedOption) {
        case 'starpoint':
            $order = isset($selectedOption) ? "DESC": '';
            break;
        case 'reserved_rate':
            $order = isset($selectedOption) ? "DESC": '';
            break;
        case 'release_date':
            $order = isset($selectedOption) ? "DESC": '';
            break;
        case 'title':
            $order = isset($selectedOption) ? "ASC": '';
            break;
        default:
            $selectedOption='title';
            break;
      } ?>
      <button type="submit">조회</button>
    </div>
  </form>
  <br>
  <a href="index.php"><input type="button" value="메인페이지" style="float: right;"></a>
  <br>


  <?php
  if($result = $selectedOption!='starpoint' ? 
  $selectedOption!='reserved_rate'?
  mysqli_query($conn,"SELECT * FROM MovieInfoList ORDER BY $selectedOption $order"):          
  mysqli_query($conn,"SELECT * FROM MovieInfoList NATURAL JOIN (SELECT movie_id,reserved_rate FROM reservedrate)rr WHERE rr.movie_id=movie_id ORDER BY $selectedOption $order") : 
  mysqli_query($conn,"SELECT * FROM MovieInfoList NATURAL JOIN (SELECT movie_id,AVG(starpoint) AS avg FROM commentlist GROUP BY movie_id)cm WHERE cm.movie_id=movie_id ORDER BY avg DESC")){
  while($List = mysqli_fetch_array($result)){
    ?>
  <div id="pic">
    <figure>
      <img src="<?php echo $List['poster_img'];?>"/>
      <figcaption><?php echo '제목 : '.$List['title']?></figcaption>
      <figcaption><?php echo '장르 : '.$List['genre']?></figcaption>
      <figcaption><?php echo '런닝타임 : '.$List['running_time'].'분'?></figcaption>
      <figcaption><?php echo '개봉일자 : '.$List['release_date']?></figcaption>
      <figcaption><?php echo '연령제한 : '.$List['is_rated'].'세 이상'?></figcaption>
      <figcaption><?php echo '제작사 : '.$List['studio']?></figcaption>
      <?php $movie_id=$List['movie_id'];
      $sqll="SELECT reserved_rate FROM MovieInfoList NATURAL JOIN (SELECT movie_id,reserved_rate FROM reservedrate)rr WHERE rr.movie_id=$movie_id";
      $resultt = mysqli_query($conn,$sqll);
      $value = mysqli_fetch_assoc($resultt); ?>
      <figcaption><?php echo '예매율 : '.$value['reserved_rate'].'%' ?></figcaption>
      <?php $movie_id=$List['movie_id'];
      $sqll="SELECT AVG(starpoint) AS avg FROM commentlist WHERE movie_id='$movie_id'";
      $resultt=mysqli_query($conn,$sqll);
      $value = mysqli_fetch_assoc($resultt); ?>
      <figcaption><?php echo '평점 : '.$value['avg']?></figcaption>
      <figcaption><?php
            $content = $List['content'];
            //echo strlen($content);
            if(strlen($content) > 80){
                echo iconv_substr($content,0,80, "utf-8").'...';
            }
            else echo $content;?></figcaption>
      <?php  echo "<form method='POST' action='comment.php'>
        <input type='hidden' name='movie_id' value='".$List['movie_id']."'>
        <button class='button' name='lookinfo'>
        영화정보보기</button>
      </form>";
      ?>
    </figure>
  </div>
<?php } ?>
<?php } ?>
</body>
</html>

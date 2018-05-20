<?php
include "server.php"
?>
<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <title>Welcome to JDBC Theater</title>
    <h1 class="rank">JDBC Theater</h1>
    <?php
    if(isset($_SESSION['customer_id'])){
      echo "<span style='color:rgba(255,30,30,0.9)'>".$_SESSION['username']."님이 로그인하셨습니다.</span>";
    }else{
      echo "Nobody is logged in";
    }?>
    <style>
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
        margin-top:5px;
        border-top:1px solid rgba(0,0,0,0.2);
        text-align:center;
      }
      .button{
        width:100%;
        height:30px;
      }
      .viewall{
        text-align: right;
      }
    </style>
  </head>
  <body>
    <div class="row">
    <div class="col-lg-12 text-center v-center">
      <p class="lead" style="text-align:center;">영화 검색</p>
      <form class="col-lg-12" action="index.php" method="post">
        <div class="input-group" style="width:340px;text-align:center;margin:0 auto;">
          <?php $selectedSearch = isset($_POST['find'])?$_POST['find']:''; ?>
        <select class="find" name="find">
          <option <?php if($selectedSearch == 'all'){echo("selected");}?> value="all">전체</option>
          <option <?php if($selectedSearch == 'title'){echo("selected");}?> value="title">제목으로 찾기</option>
          <option <?php if($selectedSearch == 'director'){echo("selected");}?> value="director">감독으로 찾기</option>
          <option <?php if($selectedSearch == 'actor'){echo("selected");}?> value="actor">배우로 찾기</option>
        </select>
        <?php
        if(isset($_POST['search'])){
          $searchq = $_POST['search'];
          $searchq = preg_replace("#[^0-9a-z]#i","",$searchq);
        } ?>
        <?php
        $sql='';
        switch ($selectedSearch) {
          case 'title':
              $sql = isset($selectedSearch) ? "title LIKE '%$searchq%'" : '';
              break;
          case 'director':
              $sql = isset($selectedSearch) ? "director LIKE '%$searchq%'" : '';
              break;
          case 'actor':
              $sql= isset($selectedSearch) ? "actor LIKE '%$searchq%'" : '';
              break;
          case 'all':
              $sql= isset($selectedSearch) ? "title LIKE '%$searchq%' OR actor LIKE '%$searchq%' OR director LIKE '%$searchq%'" : '';
              break;
        }
        if($result = mysqli_query($conn,"SELECT * FROM MovieInfoList WHERE $sql ")){
          $count = mysqli_num_rows($result);
          if($count == 0){
            $output="검색결과가 존재하지 않습니다.";
          }else{
            while($row = mysqli_fetch_array($result)){
              $movietitle = $row['title'];
              
            }
          }
        }
        ?>
        <input type="text" name="search" placeholder="키워드를 입력하세요." />
        <input type="submit" name="submit" value="검색" />
        </div>

      </form>
      </div>
    </div> <!-- /row -->
    <form class="rankstd" action="index.php" method="post">
      <div class="rank">
        <p class="rate" style="text-align:center;">영화 순위</p>
        <?php
          $selected = isset($_POST['std'])? $_POST['std']:'';
        ?>
        <select class="std" name="std">
          <option <?php if($selected == 'is_rated'){echo("selected");}?> value = "is_rated">평점순</option>
          <option <?php if($selected == 'release_date'){echo("selected");}?> value = "release_date">개봉일순</option>
          <option <?php if($selected == 'title'){echo("selected");}?> value = "title">제목순</option>
        </select>
        <?php
        $order = '';
        $selectedOption = isset($_POST['std']) ? $_POST['std'] : '';
        switch ($selectedOption) {
          case 'is_rated':
              $order = isset($selectedOption) ? "DESC": '';
              break;
          case 'release_date':
              $order = isset($selectedOption) ? "DESC": '';
              break;
          case 'title':
              $order = isset($selectedOption) ? "ASC": '';
              break;
        } ?>
        <button id="button" class="btn btn-lg btn-primary" type="submit">변경</button>
      </div>
    </form>
    <br>
    <a href="movlist.php"><input type="button" value="전체영화보기" style="float: right;"></a>
    <a href="schedule.php"><input type="button" value="예약하기" style="float: right;"></a>
    <a href="mypage.php"><input type="button" value="마이페이지" style="float: right;"></a>
    <br>

    <?php
    if($result = mysqli_query($conn,"SELECT * FROM MovieInfoList ORDER BY $selectedOption $order LIMIT 6")){
      $i = 1;
      while($List = mysqli_fetch_array($result)){
        ?>
        <div id="pic">
          <figure>
            <figcaption><?php echo $i.'위';?></figcaption>
            <img src="<?php echo $List['poster_img'];?>"/>
            <figcaption><?php echo '제목 : '.$List['title']?></figcaption>
            <figcaption><?php echo '장르 : '.$List['genre']?></figcaption>
            <figcaption><?php echo '런닝타임 : '.$List['running_time'].'분'?></figcaption>
            <figcaption><?php echo '개봉일자 : '.$List['release_date']?></figcaption>
            <figcaption><?php echo '누적평점 : '.$List['is_rated']?></figcaption>
            <figcaption><?php echo '제작사 : '.$List['studio']?></figcaption>
            <?php  echo "<form method='POST' action='comment.php'>
              <input type='hidden' name='movie_id' value='".$List['movie_id']."'>
              <button class='button' name='lookinfo'>
              영화정보보기</button>
            </form>";
            ?>
            <?php  echo "<form method='POST' action='reserve.php'>
              <input type='hidden' name='movie_id' value='".$List['movie_id']."'>
              <button class='button' name='makereserve'>
              예매하기</button>
            </form>";
            ?>
          </figure>
          <?php $i = $i+1; ?>
        </div>
  <?php } ?>
<?php  } ?>
  </body>
</html>

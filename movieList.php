<?php
include_once "dbh.inc.php"
?>

<html>

<style>
  table {
    width: 100%;
    border: 1px solid #444444;
    border-collapse: collapse;
    text-align: center;
  }
  th, td{
    border: 1px solid #444444;
    text-align: center;
  }
</style>

<body>
  <table>
  <thead>
      <tr>
          <th>제목</th>
          <th>장르</th>
          <th>상영시간</th>
          <th>개봉일</th>
          <th>감독</th>
          <th>배우</th>
          <th>관람등급</th>
          <th>줄거리</th>
          <th>제작사</th>
          <th>포스터</th>
      </tr>
  </thead>

  <?php  $rlt = $conn->query("SELECT * FROM MovieInfoList");
  while($List = mysqli_fetch_array($rlt)){
    ?>
<tbody>
  <tr>
      <td><?php echo $List['title']?></td>
      <td><?php echo $List['genre']?></td>
      <td><?php echo $List['running_time']?></td>
      <td><?php echo $List['release_date']?></td>
      <td><?php echo $List['director']?></td>
      <td><?php echo $List['actor']?></td>
      <td><?php echo $List['is_rated']?></td>
      <td><?php
            $content = $List['content'];
            //echo strlen($content);
            if(strlen($content) > 80){
                echo iconv_substr($content,0,80, "utf-8").'...';
            }
            else echo $content;?></td>
      <td width="10%"><?php echo $List['studio']?></td>
     <td width="10%"><img src="<?php echo $List['poster_img'];?>" width ="130" height="160"></td>
     </tr>
</tbody>
<?php } ?>
</table>

<!--
<button onclick=""> 전체 영화목록 조회</button>
<button onclick=""> 개봉예정작 조회</button>
<br>
!-->

</body>
</html>

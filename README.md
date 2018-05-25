# JDBC_movie_booking_system

Project manager and DB designer : 유경상
DB Manipulator : 김도진
Application Developer : 심소정
DB administrator : 차은비

<br><br>
<strong>Login and Register</strong><br>

login.php - checks username and password and allows a user to login to the system.<br>
register.php - if a user does not have a username or password, he/she can register to the system.<br>
server.php - enables web to connect with database. <br>
error.php - when sufficient information is not filled in register or login section error message appears<br>
main.css - css file decorating all files related to login and register.<br>
dbh.inc.php - contains information that enables access to local server. (password is set to "", in order to use files in local server the user must edit and insert his/her own local server password)<br><br><br>

<strong>Comment and MovieList</strong><br>
com.css- css file decroating all files reated to comments
comment.inc.php- enables website to create comment, delete, edit, increase like numbers and etc.
comment.php- shows detailed information of the movie and shows comments below a movie.
editcomment.php- enables a user to edit a comment that is written by her/him.
movlist.php - shows all movies stored in database.
<br><br><br>

<strong>Main Page</strong><br>
index.php - shows at most 6 movies that exist in a database by some type of sorting. The user can search movies by keywords<br><br><br>

<strong>My Page</strong><br>
mypage.php - shows user's information
mypageEdit.php - allows a user to edit ones' information
updateInfo.php - allows a user to edit ones' information
<br><br><br>

<strong>Reservation</strong><br>
schedule.php- shows all schedules that can be reserved and allows a user to select specific movie schedule and a seat
reserve.php- enables reservation if all requirements are fulfilled


dbname is set to ressystem

<h2>How to install DataBase</h2>

1. Download ressystem.sql file
2. Go to phpmyadmin
3. Execute query "CREATE DATABASE ressytem;"
4. Click "가져오기" or "Import"
5. Select file "ressystem.sql"
6. Press "실행" or "Go"
7. Database is inserted!

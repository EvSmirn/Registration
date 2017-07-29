<html>
    <head>
    <title>Регистрация</title>
      <link rel="stylesheet" type="text/css" href="style.css">
    </head>
    <body>
    <h2 align="center">Регистрация</h2>
  <?php 

$db_server = mysqli_connect('localhost', 'root', '', 'user');
if (!$db_server) {
    die("Невозможно подключиться к MySQL: " . mysqli_error());
}
mysqli_select_db($db_server, 'user')
or die("Невозможно выбрать базу данных: " . mysqli_error());


?>
    <form action="reg.php" method="post" id = "form">
         <table width="100%" cellspacing="0" cellpadding="11">
        <tr>
        <td align="right" width="100">Ваш логин:</td>
        <td><input name="login" type="text" size="15" maxlength="15" id = "login" required></td>
        </tr>

        <tr>
        <td align="right">Пароль:</td>
        <td><input name="password" type="password" size="15" maxlength="15" id="password" required></td>
       
        <a class="tooltip" href="#">       
        <div id="pswd_info">
	 <h4>Пароль должен соответствовать критериям:</h4>
	 <ul>
	  <li id="letter">Минимум <strong>одна буква</strong></li>
	  <li id="capital">Минимум <strong>одна заглавная буква</strong></li>
          <li id="number">Минимум <strong>одна цифра</strong></li>
	  <li id="length">Быть не менее <strong>8 символов</strong></li>
	 </ul>
	</div>
            </a>
        </tr>

    <tr>
        <td align="right">Фамилия:</td>
        <td><input name="surename" type="text" size="15" maxlength="15" id="surename" required></td>
     </tr>

      <tr>
        <td align="right">Имя:</td>
       <td> <input name="name" type="text" size="15" maxlength="15" id="name" required></td>
        </tr>
 
        <tr>
    <td align="right">Отчество:</td>
        <td><input name="middle_name" type="text" size="15" maxlength="15" id="middle_name" required></td>
        </tr>
 
        <tr>
        <td align="right">Номер паспорта:</td>
        <td><input name="passport_ID" type="text" size="15" maxlength="15" id="passport_ID" required></td>
    </tr>
 
        <tr>
        <td align="right">Кем выдан:</td>
        <td><input name="issued_by" type="text" size="15" maxlength="15" id="issued_by" required><td>
       </tr>

       <tr>
        <td align="right">Телефон:</td>
        <td><input name="phone_number" type="text" size="15" maxlength="16" id="phone_number" required><td>
        </tr>
 
     <tr>
        <td align="right">Адрес:</td>
       <td> <input name="address" type="text" size="15" maxlength="30" id="address" required><td>
        </tr>
 
        <tr>
        <td align="right">E-mail:</td>
       <td> <input name="e_mail" type="text" size="15" maxlength="15" id="e_mail"></td>
        </tr>
        <tr> 
     <td></td>
     <td><input type="submit" name="submit" value="Зарегистрироваться"></td>
     </tr>
         </table>
</form>
    <?php

    if (isset($_POST['login']) &&
isset($_POST['password']) &&
isset($_POST['surename']) &&
isset($_POST['name']) &&
isset($_POST['middle_name']) &&
isset($_POST['issued_by']) &&
isset($_POST['phone_number']) &&
isset($_POST['address']) &&
isset($_POST['e_mail']) &&
isset($_POST['passport_ID']))
{
$login = get_post($db_server, 'login');
$password = get_post($db_server, 'password');
$surename = get_post($db_server,'surename');
$name = get_post($db_server,'name');
$middle_name = get_post($db_server,'middle_name');
$issued_by = get_post($db_server,'issued_by');
$phone_number = get_post($db_server,'phone_number');
$address = get_post($db_server,'address');
$e_mail = get_post($db_server,'e_mail');
$passport_ID = get_post($db_server,'passport_ID');

$login = stripslashes($login);
$login = htmlspecialchars($login);
$password = stripslashes($password);
$password = htmlspecialchars($password);
 //удаляем лишние пробелы
 $login = trim($login);
 $password = trim($password);
 $password    = md5($password);//шифруем пароль          
$password    = strrev($password);// для надежности добавим реверс       

   
    $result = mysqli_query($db_server, "SELECT id FROM users WHERE login='$login'");
    $myrow = mysqli_fetch_array($result);
    if (!empty($myrow['id'])) {
    exit ("Извините, введённый вами логин уже зарегистрирован. Введите другой логин.");
    }

    // если такого нет, то сохраняем данные
 
   $result2 = mysqli_query ($db_server, "INSERT INTO users (login,password,surename,name,middle_name,issued_by,phone_number,address,e_mail, passport_ID) VALUES('$login','$password','$surename','$name','$middle_name','$issued_by','$phone_number','$address','$e_mail','$passport_ID')");
    // Проверяем, есть ли ошибки
  if ($result2=='TRUE')
    {
    echo "Вы успешно зарегистрированы! Теперь вы можете зайти на сайт. <a href='index.php'>Главная страница</a>";
    }
 else {
    echo "Ошибка! Вы не зарегистрированы.";
    }
}
mysqli_close($db_server);
function get_post($db_server, $var)
{
return mysqli_real_escape_string($db_server, trim($_POST[$var]));
}
    ?>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
           <script src="js/jquery.validate.min.js"></script>
        <script src="js/bootstrap.min.js"></script>
        <script src="js/jquery.validate.js"></script>
        <script src="js/jVal.js"></script>
        <script src="js/jPas.js"></script>
         <script src="js/jquery.inputmask.js"></script>
        

    </body>
    </html>
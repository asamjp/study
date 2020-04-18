<!DOCTYPE html>
<html lang="ja">
  <head>

    <meta charset="utf-8">
    <title>顧客情報</title>
  
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link rel="stylesheet" href="css/style.css" type="text/css">
    <link rel="stylesheet" href="css/test.css" type="text/css">
    <link rel="stylesheet" href="css/bootstrap.css" type="text/css">

    <!-- <meta content="顧客情報" name="Description" /> -->
    <script type="text/javascript" src="js/jquery-3.4.1.js"></script>
    <script type="text/javascript" src="js/bootstrap.bundle.js"></script>

    <!-- js処理 ここから -->
    <script>
    
    </script>
    <!-- js処理 ここまで -->

  </head>
  <body>
  
  <div class="userkanri">
    <h5 class="userkanri-title">USER INFO</h5>
    
    <form action="kokyaku_mnt.php" method="post">
      <div class="user-info">
        <ul>
          <li class="name">
            <label for="name">NAME</label>
            <input id="neme" type="text" name="name" placeholder="okinawa hanako" size="40">
          </li>
          <li class="email">
            <label for="email">EMAIL</label>
            <input id="email" type="text" name="email" placeholder="info@ros.com" size="40">
          </li>
          <li>
            <label for="usertype">USERTYPE</label>
            <type="select" name="usertype">
              <select name="usertype">
                <option value="0">GOOD</option>
                <option value="1">NORMAL</option>
                <option value="2">BAD</option>
              </select>
          </li>
          <li class="msg">
            <label for="msg">MESSAGE</label>
            <textarea id="mag" name="msg" size="40"></textarea>
          </li>         
          <li><input id="button" type="submit" name="button" value="submit!">
          </li>
        </ul>
      </div>
   </form>
</div>
    

  </body>
</html>
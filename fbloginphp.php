<?php
//Facebook SDK for PHP の src/ にあるファイルを
//サーバ内の適当な場所にコピーしておく
require_once("facebook.php");

$config = array(
'appId'  => '[取得した App ID]',
'secret' => '[取得した App Secret]'
);

$facebook = new Facebook($config);
//リダイレクト先が最初のページと別の場合
//$params = array('redirect_uri' => '[リダイレクト先の URI]');
//$loginUrl = $facebook->getLoginUrl($params);


$loginUrl = $facebook->getLoginUrl();
//ログイン済みの場合はユーザー情報を取得
if ($facebook->getUser()) {
  try {
    $user = $facebook->api('/me','GET');
  } catch(FacebookApiException $e) {
    //取得に失敗したら例外をキャッチしてエラーログに出力
    error_log($e->getType());
    error_log($e->getMessage());
  }
}
?>
<html>
<body>
  <?php
  if (isset($user)) {
    //ログイン済みでユーザー情報が取れていれば表示
    echo '<pre>';
    print_r($user);
    echo '</pre>';
  } else {
    //未ログインならログイン URL を取得してリンクを出力
    $loginUrl = $facebook->getLoginUrl();
      //リダイレクト先が最初のページと別の場合
      //$params = array('redirect_uri' => '[リダイレクト先の URI]');
      //$loginUrl = $facebook->getLoginUrl($params);
    echo '<a href="' . $loginUrl . '">Login with Facebook</a>';
  }
  ?>
</body>
</html>
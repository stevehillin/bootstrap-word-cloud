<?php

/************************************************
  Simple 'Word Cloud' using Bootstrap buttons
  Author: Steve Hillin <stevehillin@gmail.com>
************************************************/

$config = json_decode(file_get_contents('config.json'));
$keywords = json_decode(file_get_contents('keywords.json'));

if($config->do_sort)
{
	$array = json_decode(json_encode($keywords), true);
        ksort($array);
	$keywords = json_decode(json_encode($array));
}

if($config->send_email)
{
	$msg = new stdClass();
	if($config->do_geo)
	{
		$curl = curl_init();
		curl_setopt_array($curl, array(
			CURLOPT_URL => "https://freegeoip.app/json/".$_SERVER['REMOTE_ADDR'],
			CURLOPT_RETURNTRANSFER => true,
			CURLOPT_ENCODING => "",
			CURLOPT_MAXREDIRS => 10,
			CURLOPT_TIMEOUT => 30,
			CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
			CURLOPT_CUSTOMREQUEST => "GET",
			CURLOPT_HTTPHEADER => array(
				"accept: application/json",
				"content-type: application/json"
			),
		));
		$response = curl_exec($curl);
		$err = curl_error($curl);
		curl_close($curl);
		if($err)
		{
			$msg->curlError = $err;
		} else {
			$msg->GeoInfo = json_decode($response);
		}
	}

	$msg->IP = $_SERVER['REMOTE_ADDR'];
	if(!empty($_SERVER['HTTP_REFERER']))
	{
		$msg->Referrer = $_SERVER['HTTP_REFERER'];
	}
	$msg->UserAgent = $_SERVER['HTTP_USER_AGENT'];
//	mail($config->email, $config->email_subject, json_encode($msg, JSON_PRETTY_PRINT));
}
?>
<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js" integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" integrity="sha384-JcKb8q3iqJ61gNV9KGb8thSsNjpSL0n8PARn9HuZOnIxN0hoP+VmmDGMN5t9UJ0Z" crossorigin="anonymous">
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js" integrity="sha384-B4gt1jrGC7Jh4AgTPSdUtOBvfO8shuf57BaghqFfPlYxofvL8/KUEfYiJOMMV+rV" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.bundle.min.js" integrity="sha384-LtrjvnR4Twt/qOuYxE721u19sVFLVSA4hf/rRt6PrZTmiPltdZcI7q7PXQBYTKyf" crossorigin="anonymous"></script>
    <link href="css.css" rel="stylesheet">
    <title><?=$config->name?></title>
  </head>
  <body>
    <main role="main" class="container">
      <h3 class="mt-5"><?=$config->name?></h3>
      <p><?=$config->p_tag?></p>
      <div class="row">
<?php
foreach($config->buttons AS $boot => $label)
{
	echo '      <button type="button" id="btn-'.$boot.'" class="btn btn-'.$boot.' mr-2 option-select">'.$label.'</button>'.PHP_EOL;
}
?>
      </div>
      <hr>
      <div class="row">
<?php
foreach($keywords AS $skill => $competency)
{
	echo '        <button type="button" class="btn btn-'.$competency.' mr-2 mt-2">'.$skill.'</button>'.PHP_EOL;
}
?>
      </div>
    </main>
    <footer class="footer">
      <div class="container">
<?php
foreach($config->links AS $name => $link)
{
	echo '        <a href="'.$link.'"><button type="button" class="btn btn-danger mr-2 mt-2">'.$name.'</button></a>'.PHP_EOL;
}
?>
      </div>
    </footer>

    <script>
      $(document).ready(function() {
        $(".option-select").click(function(e) {
        var newActiveClass = e.target.id;
        $('[class*="btn-"]').addClass('disabled');
        $('.' + newActiveClass).removeClass('disabled');
        });
      });
    </script>

  </body>
</html>

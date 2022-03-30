<?php
// Merchant key here as provided by Payu
$key = "7rnFly";//"yt13u";
$salt = "pjVQAWpA";
$command = "verify_payment";
$var1 = "8705c9ba1f0d62fd4278"; // Transaction ID


$hash_str = $key  . '|' . $command . '|' . $var1 . '|' . $salt ;
$hash = strtolower(hash('sha512', $hash_str));

    $r = array('key' => $key , 'hash' =>$hash , 'var1' => $var1, 'command' => $command);
	echo $hash;
    
    $qs= http_build_query($r);
    $wsUrl = "https://test.payu.in/merchant/postservice.php?form=1";
    //$wsUrl = "https://info.payu.in/merchant/postservice?form=1";
   	$c = curl_init();
    curl_setopt($c, CURLOPT_URL, $wsUrl);
    curl_setopt($c, CURLOPT_POST, 1);
    curl_setopt($c, CURLOPT_POSTFIELDS, $qs);
    curl_setopt($c, CURLOPT_CONNECTTIMEOUT, 30);
    curl_setopt($c, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($c, CURLOPT_SSL_VERIFYHOST, 0);
    curl_setopt($c, CURLOPT_SSL_VERIFYPEER, 0);
    $o = curl_exec($c);
    if (curl_errno($c)) {
      $sad = curl_error($c);
      throw new Exception($sad);
    }
    curl_close($c);

    $valueSerialized = @unserialize($o);
    if($o === 'b:0;' || $valueSerialized !== false) {
      print_r($valueSerialized);
    }
    print_r($o);
?>
<?php
include 'curl.php';
function headers($token = null) {
        $huruf = '0123456789ABCDEFGHIJKLMOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz';
        $uniq = '';
        for ($i = 0; $i < 16; $i++) {
        $uniq .= $huruf[mt_rand(0, strlen($huruf) - 1)];
        }

    if  ($token != "") {

        $headers = array(
        'Accept: application/json',
        'X-Session-ID: 28667f0c-80e8-43db-9ab4-c6d411f00a86',
        'X-AppVersion: 3.39.1',
        'X-AppId: com.gojek.app',
        'X-Platform: Android',
        'X-UniqueId: '.$uniq,
        'D1: 4A:7D:0B:8F:17:12:D7:E2:D0:C6:E8:34:7C:D4:93:33:03:E8:E0:58:19:C9:05:70:00:34:BA:28:74:CC:B4:F8',
        'Authorization: Bearer '.$token,
        'X-DeviceOS: Android,8.1.0',
        'User-uuid: 654547255d',
        'X-DeviceToken: dcmYpIKCHHk:APA91bHYItfFL5wff_248ia4ViPtmpo5abW3MmezEqP7zoW9N6O6ih-eQvg9c1vwhyI7xSKG38AV69odAgYXTLTmRzB8pfbxS1U_XhGZwRv65CDqlltpPBCGiPUzU4gXYayBbfmimuUE',
        'X-PushTokenType: FCM',
		'X-PhoneModel: xiaomi,Redmi 6',
        'Accept-Language: id-ID',
        'X-User-Locale: id_ID',
        'X-Location: -6.9212751658159934,107.62244586389556',
        'X-Location-Accuracy: 0.1',
        'X-M1: 1:__42fc4f569ca44d5984f3f5ec5876b428,2:35439844,3:1572003928449-5687198026716491624,4:7935,5:|2400|1,6:UNKNOWN,7:\"rldjqt7828\",8:576x1024,9:passive,gps,network,10:1,11:UNKNOWN',
        'Content-Type: application/json; charset=UTF-8',
        'Host: api.gojekapi.com',
        'User-Agent: okhttp/3.12.1'
        );

        return $headers;

    } else {

        $headers = array(
'Accept: application/json',
        'D1: 4A:7D:0B:8F:17:12:D7:E2:D0:C6:E8:34:7C:D4:93:33:03:E8:E0:58:19:C9:05:70:00:34:BA:28:74:CC:B4:F8',
        'X-Session-ID: 28667f0c-80e8-43db-9ab4-c6d411f00a86',
        'X-AppVersion: 3.39.1',
        'X-AppId: com.gojek.app',
        'X-Platform: Android',
        'X-UniqueId: '.$uniq,
        'Authorization: Bearer ',
        'X-DeviceOS: Android,8.1.0',
        'User-uuid: ',
        'X-DeviceToken: dcmYpIKCHHk:APA91bHYItfFL5wff_248ia4ViPtmpo5abW3MmezEqP7zoW9N6O6ih-eQvg9c1vwhyI7xSKG38AV69odAgYXTLTmRzB8pfbxS1U_XhGZwRv65CDqlltpPBCGiPUzU4gXYayBbfmimuUE',
        'X-PushTokenType: FCM',
        'X-PhoneModel: xiaomi,Redmi 6',
        'Accept-Language: id-ID',
        'X-User-Locale: id_ID',
        'X-M1: 1:__42fc4f569ca44d5984f3f5ec5876b428,2:35439844,3:1572003928449-5687198026716491624,4:7935,5:|2400|1,6:UNKNOWN,7:\"rldjqt7828\",8:576x1024,9:passive,gps,network,10:1,11:UNKNOWN',
        'Content-Type: application/json; charset=UTF-8',
        'Host: api.gojekapi.com',
        'User-Agent: okhttp/3.12.1'
        );
return $headers;

    }

}

function register_gojek() {
	 $fakename = curl('https://fakenametool.net/random-name-generator/random/id_ID/indonesia/1');
     preg_match('/<span>(.*?)<\/span>/s', $fakename, $name);
	 echo "Generating name and email";
	 $email = strtolower(str_replace(' ',  '', $name[1])).rand(0000,2222).'@gmail.com';
	 for ($i=0; $i < 2 ; $i++) {
                        sleep(1);
                        echo ".";
                    }
		echo "\nSuccess Generate\n";
     echo "Nomor (without +) : ";
     $phone = trim(fgets(STDIN));
	 $datanya = '{"name":"' .$name[1]. '","email":"'.$email.'","phone":"+'.$phone.'","signed_up_country":"ID"}';
     $register = curl('https://api.gojekapi.com/v5/customers',$datanya,headers());

    if (stripos($register, '"success":true')) {
        $otp_token = fetch_value($register,'"otp_token":"','","');
        echo "OTP : ";
        $otp_code = trim(fgets(STDIN));

        $verify = curl('https://api.gojekapi.com/v5/customers/phone/verify','{"client_name":"gojek:cons:android","client_secret":"83415d06-ec4e-11e6-a41b-6c40088ab51e","data":{"otp":"'.$otp_code.'","otp_token":"'.$otp_token.'"}}',headers());

        if (stripos($verify, '"access_token"')) {
		$access_token = fetch_value($verify,'"access_token":"','"');

                  $claim = curl('https://api.gojekapi.com/go-promotions/v1/promotions/enrollments','{"promo_code":"GOFOODBOBA07"}',headers($access_token));
                  //echo "\nAuthorization: Bearer : ".$access_token;
                  echo "\n\nRedeeming Voucher";
                    for ($i=0; $i < 3 ; $i++) {
                        sleep(1);
                        echo ".";
                    }
                    echo "\n";
                    sleep(3);
                    if (stripos($claim, '"success":true')) {
                        echo "Redemption is complete !";
                    } else {
                        echo "Redemption failed\n";
                }

            } else {
                echo "Promo tidak ditemukan\n";
            }
    } else {
echo "Gagal mendaftar No HP / Email Sudah Terdaftar\n";
    }

}
echo "GOJEK AUTO CREATE+AUTO REDEEM\n";
echo "Date: ".date('d-m-Y H:i:s')."\n";
register_gojek()

?>
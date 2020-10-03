<?php
if (strpos($_SERVER['REQUEST_URI'], basename(__FILE__)) !== false) {die('Invalid request');}

include_once("basecontroller.php");
//include_once("model/churchhistory.php");
include_once("model/fcm.php");
include_once("model/notification.php");
use Kreait\Firebase\Factory;
use Kreait\Firebase\ServiceAccount;
use Kreait\Firebase\Messaging\CloudMessage;
use Kreait\Firebase\Messaging\Notification;

class FCM extends AuthController {
	private $model;	
	
	public function __construct() {
		parent::__construct();
        $this->model        = NULL;
		$this->masterLayout = "view/templates/mainlayout.php";
    }
	
	public function saveToken() {
		$fcm = new FCMModel();
		$value = $fcm->getDetailsById($_POST['fcm']);
		if (!empty($value))
		  return $this->renderJson(["isSuccess" => true]);

		$id            = $fcm->save($_POST);
		$isSuccess     = ($id > 0);
		return $this->renderJson(["isSuccess" => $isSuccess]);
	}

    public static function pushNotification($data){
	    $fcm = new FCMModel();
        $fcmtokens=$fcm->get();
        foreach ($fcmtokens as $fcmtoken){
            $data['registration_ids'][]=$fcmtoken['fcm'];
        }
        $data['collapse_key']="type_a";
        $data['notification']=$data;
        self::sendNotification($data);

    }
    private static function sendNotification($data){


        $curl = curl_init();

        curl_setopt_array($curl, array(
            CURLOPT_URL => "https://fcm.googleapis.com/fcm/send",
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => "",
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => "POST",
            CURLOPT_POSTFIELDS =>json_encode($data,true),
            CURLOPT_HTTPHEADER => array(
                "Authorization: key=AAAA8LUTMQg:APA91bET_zqzxd5U9CSmElTguIpqaVdVzQUW3Jh8pu6cXF8M8Tsh-yRuffDkz-ZWkV9jyNyn04lF2FuzsnOMQdwA3dSMI3fQRChcql_kQNGd7PPN1PiLvudk2HY-vahA_tPJn9Ymbc7F",
                "Content-Type: application/json"
            ),
        ));

        $response = curl_exec($curl);

        curl_close($curl);


    }
}

?>
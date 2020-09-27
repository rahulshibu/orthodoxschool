<?php
if (strpos($_SERVER['REQUEST_URI'], basename(__FILE__)) !== false) {die('Invalid request');}

include_once("basecontroller.php");
include_once("model/prayerrequest.php");

//include_once("c/m.php");
include ('./controller/Email.php');

class PrayerRequest extends AuthController
{
    private $model;

    public function __construct()
    {
        parent::__construct();
        $this->model = NULL;
        $this->masterLayout = "view/templates/mainlayout.php";
    }

    public function index()
    {
        $records = [];
        $request = new PrayerRequestModel();
        $records["churchHistory"] = $request->get();
        return $this->renderView('view/prayerrequest.php', $records);
    }

    public function saveRequest()
    {
        $Request = new PrayerRequestModel();

        if (isset($_POST['sendEmail']) && $_POST['sendEmail']) {
            $_GET['id'] = $_POST['id'];
            $result = json_decode($this->getRequestDetailsById(), true);
            if (isset($result) && isset($result[0])) {
                if ($_POST['status']==1){
                    $msg  =  "Accepted";
                }elseif ($_POST['status']){
                    $msg = "Rejected";
                }
                Email::sendMail($result[0]['email'], 'Orthodox Bible School Prayer Request '.$msg, $this->emailContent($result[0]['name'], $result[0]['subject'],$_POST['status']));
            }
            unset($_POST['sendEmail']);
        }
        $id = $Request->save($_POST);
        $isSuccess = ($id > 0);
        return $this->renderJson(["isSuccess" => $isSuccess, "id" => $id]);
    }

    public function requestPrayer()
    {
        $Question = new PrayerRequestModel();
        if (!isset($_POST['email']) || !isset($_POST['name']) || !isset($_POST['subject'])||!isset($_POST['message']) || empty($_POST['email']) || empty($_POST['message'])|| empty($_POST['name']) || empty($_POST['subject'])) {
            return $this->rendorError(['error' => "Mandatory fields required"]);
        }
        if (!filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)) {
            return $this->rendorError(['error' => "Invalid email"]);
        }

        $id = $Question->save($_POST);
        $isSuccess = ($id > 0);
        return $this->renderJson(["isSuccess" => $isSuccess, "id" => $id]);
    }

    public function getRequest()
    {
        $Request = new PrayerRequestModel();
        $response = $Request->get();
        return $this->renderJson($response);
    }

    public function getRequestDetailsById()
    {
        $churchHistory = new PrayerRequestModel();
        $response = $churchHistory->getRequestDetailsById($_GET["id"]);
        return $this->renderJson($response);
    }

    public function deleteRequest()
    {
        $Request = new PrayerRequestModel();
        $response = $Request->delete($_GET["id"]);
        return $this->renderJson(["isSuccess" => $response]);
    }

    public function emailContent($name, $request,$status)
    {
        if ($status==1){
          $msg  =  "accepted";
        }elseif ($status){
            $msg = "rejected";
        }
        $email = "<!DOCTYPE html>
            <html>
            <body>

            <p>Hi " . $name . ",</p>

            <p>Your prayer request <b>" . $request . "</b> is ".$msg."</p>

            <p>Regards,<br> Orthodox Bible School</p>



            </body>
            </html>";
        return $email;
    }
}
?>
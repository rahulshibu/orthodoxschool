<?php



include 'route.php';

// $route->add( <Controller name>, <Method>, <Supported Http verbs and other url attributes>)

$route = new Route();


$route->add('/home/', "index",    ["httpVerb" => "get", "default" => True]);

$route->add('/account/', "index", ["httpVerb" => "get"]);

$route->add('/account/', "login", ["httpVerb" => "post"]);

$route->add('/logout/',  "index", ["httpVerb" => "get"]);



$route->add('/prayertypes/', "index",             ["httpVerb" => "get"]);

$route->add('/prayertypes/', "savePrayerType",    ["httpVerb" => "post"]);

$route->add('/prayertypes/', "getPrayerTypes",    ["httpVerb" => "get"]);

$route->add('/prayertypes/', "deletePrayerTypes", ["httpVerb" => "get"]);



$route->add('/prayer/', "index",        ["httpVerb" => "get"]);

$route->add('/prayer/', "savePrayer",   ["httpVerb" => "post"]);

$route->add('/prayer/', "getPrayer",    ["httpVerb" => "get"]);

$route->add('/prayer/', "deletePrayer", ["httpVerb" => "get"]);



$route->add('/biblewords/', "index",                ["httpVerb" => "get"]);

$route->add('/biblewords/', "saveBibleWords",       ["httpVerb" => "post"]);

$route->add('/biblewords/', "getBibleWords",        ["httpVerb" => "get"]);

$route->add('/biblewords/', "getBibleWordThoughts", ["httpVerb" => "get"]);

$route->add('/biblewords/', "deleteBibleWords",     ["httpVerb" => "get"]);



$route->add('/faith/', "index",              ["httpVerb" => "get"]);

$route->add('/faith/', "saveFaith",          ["httpVerb" => "post"]);

$route->add('/faith/', "getFaith",           ["httpVerb" => "get"]);

$route->add('/faith/', "getFaithDetailsById",["httpVerb" => "get"]);

$route->add('/faith/', "deleteFaith",        ["httpVerb" => "get"]);



$route->add('/saint/', "index",              ["httpVerb" => "get"]);

$route->add('/saint/', "saveSaint",          ["httpVerb" => "post"]);

$route->add('/saint/', "getSaint",           ["httpVerb" => "get"]);

$route->add('/saint/', "getSaintDetailsById",["httpVerb" => "get"]);

$route->add('/saint/', "deleteSaint",        ["httpVerb" => "get"]);



$route->add('/calendar/', "index",             ["httpVerb" => "get"]);

$route->add('/calendar/', "saveEvent",         ["httpVerb" => "post"]);

$route->add('/calendar/', "getCalendarByMonth",["httpVerb" => "get"]);

$route->add('/calendar/', "deleteEvent",       ["httpVerb" => "get"]);

$route->add('/churchHistory/', "index",                      ["httpVerb" => "get"]);
$route->add('/churchHistory/', "saveChurchHistory",          ["httpVerb" => "post"]);
$route->add('/churchHistory/', "getChurchHistory",           ["httpVerb" => "get"]);
$route->add('/churchHistory/', "getChurchHistoryDetailsById",["httpVerb" => "get"]);
$route->add('/churchHistory/', "deleteChurchHistory",        ["httpVerb" => "get"]);

$route->add('/faq/', "index",                      ["httpVerb" => "get"]);
$route->add('/faq/', "saveFAQ",          ["httpVerb" => "post"]);
$route->add('/faq/', "getFAQ",           ["httpVerb" => "get"]);
$route->add('/faq/', "getFAQDetailsById",["httpVerb" => "get"]);
$route->add('/faq/', "deleteFAQ",        ["httpVerb" => "get"]);

$route->add('/question/', "index",                      ["httpVerb" => "get"]);
$route->add('/question/', "saveQuestion",          ["httpVerb" => "post"]);
$route->add('/question/', "askQuestion",          ["httpVerb" => "post"]);
$route->add('/question/', "getQuestion",           ["httpVerb" => "get"]);
$route->add('/question/', "getQuestionDetailsById",["httpVerb" => "get"]);
$route->add('/question/', "deleteQuestion",        ["httpVerb" => "get"]);


$route->add('/prayerrequest/', "index",                      ["httpVerb" => "get"]);
$route->add('/prayerrequest/', "saveRequest",          ["httpVerb" => "post"]);
$route->add('/prayerrequest/', "requestPrayer",          ["httpVerb" => "post"]);
$route->add('/prayerrequest/', "getRequest",           ["httpVerb" => "get"]);
$route->add('/prayerrequest/', "getRequestDetailsById",["httpVerb" => "get"]);
$route->add('/prayerrequest/', "deleteRequest",        ["httpVerb" => "get"]);

$route->add('/notification/', "index",                      ["httpVerb" => "get"]);
$route->add('/notification/', "saveNotification",          ["httpVerb" => "post"]);
$route->add('/notification/', "getNotification",           ["httpVerb" => "get"]);
$route->add('/notification/', "getNotificationDetailsById",["httpVerb" => "get"]);
$route->add('/notification/', "deleteNotification",        ["httpVerb" => "get"]);

$route->add('/fcm/', "saveToken",        ["httpVerb" => "post"]);

// Admin

$route->add('/admin/', "",           ["httpVerb" => "get", "url" => '/admin/login/', "method" => "index" ]);

$route->process();

?>
<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/
 use Mailjet\Resources;
Route::get('/', function () {
    return view('welcome');
});
Route::get('/sendgrid', function () {
   
//require 'vendor/autoload.php'; 
// If you're using Composer (recommended)
// Comment out the above line if not using Composer
// require("<PATH TO>/sendgrid-php.php");
// If not using Composer, uncomment the above line and
// download sendgrid-php.zip from the latest release here,
// replacing <PATH TO> with the path to the sendgrid-php.php file,
// which is included in the download:
// https://github.com/sendgrid/sendgrid-php/releases
$email = new \SendGrid\Mail\Mail(); 
$email->setFrom("arunajamal@yahoo.com", "Jamal");
$email->setSubject("Sending with SendGrid is Fun");
$email->addTo("it@iou.edu.gm", "Tunde Aruna");
$email->addContent("text/plain", "and easy to do anywhere, even with PHP");
$email->addContent(
    "text/html", "<strong>and easy to do anywhere, even with PHP</strong>"
);
$sendgrid = new \SendGrid(env('SENDGRID_API_KEY'));
try {
    $response = $sendgrid->send($email);
    print $response->statusCode() . "\n";
    print_r($response->headers());
    print $response->body() . "\n";
} catch (Exception $e) {
    echo 'Caught exception: '. $e->getMessage() ."\n";
}

});


Route::get('/mailjet', function () {
 
  //require 'vendor/autoload.php';
 
  /*$mj = new \Mailjet\Client('b1446d95aa7b466baa712ac0b47b3f5c','5a3daa01c88acc83cb723baaa0c8a339',true,['version' => 'v3.1']);*/
  $mj = new \Mailjet\Client(env('MAIlJET_APIKEY_PUBLIC'),env('MAIlJET_APIKEY_PRIVATE'),true,['version' => 'v3.1']);

  $body = [
    'Messages' => [
      [
        'From' => [
          'Email' => "it@iou.edu.gm",
         // 'Email' => "arunajamal@yahoo.com",
          'Name' => "Jamal"
        ],
        'To' => [
          [
            'Email' => "arunajamal@yahoo.com",
            'Name' => "Jamal"
          ]
        ],
        'Subject' => "Greetings from Mailjet.",
        'TextPart' => "My first Mailjet email",
        'HTMLPart' => "<h3>Dear passenger 4, welcome to <a href='https://www.mailjet.com/'>Mailjet</a>!</h3><br />May the delivery force be with you!",
        'CustomID' => "AppGettingStartedTest"
      ]
    ]
  ];
  $response = $mj->post(Resources::$Email, ['body' => $body]);
  $response->success() && var_dump($response->getData());

});

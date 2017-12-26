<?php
// กรณีตอ้ งการตรวจสอบการแจง้ error ใหเ้ ปิด 3 บรรทัดล่างนี??ใหท้ ำงาน กรณีไม่ ให้ comment ปิดไป
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
// include composer autoload
require_once '../vendor/autoload.php';
// การตั??งเกี??ยวกับ bot
require_once 'bot_settings.php';
// กรณีมีการเชื??อมต่อกับฐานขอ้ มูล
//require_once("dbconnect.php");
///////////// ส่วนของการเรียกใชง้ าน class ผ่าน namespace
use LINE\LINEBot;
use LINE\LINEBot\HTTPClient;
use LINE\LINEBot\HTTPClient\CurlHTTPClient;
//use LINE\LINEBot\Event;
//use LINE\LINEBot\Event\BaseEvent;
//use LINE\LINEBot\Event\MessageEvent;
use LINE\LINEBot\MessageBuilder;
use LINE\LINEBot\MessageBuilder\TextMessageBuilder;
use LINE\LINEBot\MessageBuilder\StickerMessageBuilder;
use LINE\LINEBot\MessageBuilder\ImageMessageBuilder;
use LINE\LINEBot\MessageBuilder\LocationMessageBuilder;
use LINE\LINEBot\MessageBuilder\AudioMessageBuilder;
use LINE\LINEBot\MessageBuilder\VideoMessageBuilder;
use LINE\LINEBot\ImagemapActionBuilder;
use LINE\LINEBot\ImagemapActionBuilder\AreaBuilder;
use LINE\LINEBot\ImagemapActionBuilder\ImagemapMessageActionBuilder ;
use LINE\LINEBot\ImagemapActionBuilder\ImagemapUriActionBuilder;
use LINE\LINEBot\MessageBuilder\Imagemap\BaseSizeBuilder;
use LINE\LINEBot\MessageBuilder\ImagemapMessageBuilder;
use LINE\LINEBot\MessageBuilder\MultiMessageBuilder;
use LINE\LINEBot\TemplateActionBuilder;
use LINE\LINEBot\TemplateActionBuilder\DatetimePickerTemplateActionBuilder;
use LINE\LINEBot\TemplateActionBuilder\MessageTemplateActionBuilder;
use LINE\LINEBot\TemplateActionBuilder\PostbackTemplateActionBuilder;
use LINE\LINEBot\TemplateActionBuilder\UriTemplateActionBuilder;
use LINE\LINEBot\MessageBuilder\TemplateBuilder;
use LINE\LINEBot\MessageBuilder\TemplateMessageBuilder;
use LINE\LINEBot\MessageBuilder\TemplateBuilder\ButtonTemplateBuilder;
use LINE\LINEBot\MessageBuilder\TemplateBuilder\CarouselTemplateBuilder;
use LINE\LINEBot\MessageBuilder\TemplateBuilder\CarouselColumnTemplateBuilder;
use LINE\LINEBot\MessageBuilder\TemplateBuilder\ConfirmTemplateBuilder;
use LINE\LINEBot\MessageBuilder\TemplateBuilder\ImageCarouselTemplateBuilder;
use LINE\LINEBot\MessageBuilder\TemplateBuilder\ImageCarouselColumnTemplateBuilder;
// เชื??อมต่อกับ LINE Messaging API
$httpClient = new CurlHTTPClient(LINE_MESSAGE_ACCESS_TOKEN);
$bot = new LINEBot($httpClient, array('channelSecret' => LINE_MESSAGE_CHANNEL_SECRET));
// คำสั??งรอรับการส่งค่ามาของ LINE Messaging API
$content = file_get_contents('php://input (php://input)');
// แปลงขอ้ ความรูปแบบ JSON ใหอ้ ยใู่ นโครงสรา้ งตัวแปร array
$events = json_decode($content, true);
if(!is_null($events)){
// ถา้ มีค่า สรา้ งตัวแปรเก็บ replyToken ไวใ้ ชง้ าน
$replyToken = $events['events'][0]['replyToken'];
}
// ส่วนของคำสั??งจัดเตียมรูปแบบขอ้ ความสำหรับส่ง
$textMessageBuilder = new TextMessageBuilder(json_encode($events));
//l ส่วนของคำสั??งตอบกลับขอ้ ความ
$response = $bot->replyMessage($replyToken,$textMessageBuilder);
if ($response->isSucceeded()) {
echo 'Succeeded!';
return;
}
// Failed
echo $response->getHTTPStatus() . ' ' . $response->getRawBody();
?>
<?php


namespace frontend\controllers;


use booking\helpers\scr;
use booking\helpers\SysHelper;
use yii\web\Controller;

class TestController extends Controller
{
    public $layout = 'blank';

    public function actionIndex()
    {
        //$result = file_get_contents("https://www.instagram.com/kuda_dety39/");
        //$result = file_get_contents("https://www.instagram.com/p/CQAnCEHiWp0/");
        //$result2 = file_get_contents($_SERVER['DOCUMENT_ROOT'] . ‘/здесь_путь’);
        //scr::v($result);

        //SysHelper::isMobile()

// For getting information about account you don't need to auth:

        try {
           /* $url = 'https://www.instagram.com/kuda_dety39/?__a=1';
            $url = 'https://koenigs.ru/';
            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL, $url);
            curl_setopt($ch, CURLOPT_USERAGENT, 'Mozilla/5.0 (Linux; U; Android 4.4.2; en-us; SCH-I535 Build/KOT49H) AppleWebKit/534.30 (KHTML, like Gecko) Version/4.0 Mobile Safari/534.30');
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);

            $result = curl_exec($ch);
            $response_code = curl_getinfo($ch);
            scr::v(curl_error($ch));
            curl_close ($ch);
            return $this->render('index', [
                //'account' => $account,
                'result_video' => [],
                'result_photo' => [],
                'list' => [],
                'result' => $response_code,
            ]);*/
            //scr::v($response_code);
            //echo $server_output;
           /* $opts = [
                'http' => [
                    'method'=>"GET",
                    'header' =>
                        "accept-language: ru-RU,ru;q=0.9,en-US;q=0.8,en;q=0.7\r\n" .
                         "HTTP/1.1 200 OK\r\n" .
                         ":authority: www.instagram.com\r\n" .
                         ":method: GET\r\n" .
                         ":path: /kuda_dety39/\r\n" .
                         ":scheme: https\r\n" .
                         "accept: text/html,application/xhtml+xml,application/xml;q=0.9,image/avif,image/webp,image/apng;q=0.8,application/signed-exchange;v=b3;q=0.9\r\n" .
                         "accept-encoding: gzip, deflate, br\r\n" .
                         "accept-language: ru-RU,ru;q=0.9,en-US;q=0.8,en;q=0.7\r\n" .
                         "cache-control: max-age=0\r\n" .
                         "cookie: ig_did=DE908916-58CA-4B69-B74F-7073FB879F0E; mid=YFTHiAAAAAEemAJHL-w1-X-sGzZq; ig_nrcb=1; ds_user_id=44283000195; csrftoken=Bwmw3vSuVpD6NkLX2RCyCf2FhrB8o8N5; sessionid=44283000195%3AteTVmfhMaBQPLI%3A19; shbid=9423; rur=VLL; shbts=1624286005.647977\r\n" .
                         "dnt: 1\r\n" .
                         "sec-ch-ua: \";Not A Brand\";v=\"99\", \"Chromium\";v=\"88\"\r\n" .
                         "sec-ch-ua-mobile: ?0\r\n" .
                         "sec-fetch-dest: document\r\n" .
                         "sec-fetch-mode: navigate\r\n" .
                         "sec-fetch-site: same-origin\r\n" .
                         "sec-fetch-user: ?1\r\n" .
                         "upgrade-insecure-requests: 1\r\n" .
                        "user-agent: Mozilla/5.0 (Linux; U; Android 4.4.2; en-us; SCH-I535 Build/KOT49H) AppleWebKit/534.30 (KHTML, like Gecko) Version/4.0 Mobile Safari/534.30\r\n"
                ]];

            $context = stream_context_create($opts);*/

           // $result = file_get_contents('https://www.instagram.com/koenigs.ru/?__a=1'/*, false, $context*/);
            //https://www.instagram.com/kevin/?__a=1
            //$result = file_get_contents("https://www.instagram.com/p/CQAnCEHiWp0/");
            //$instagram = \InstagramScraper\Instagram::withCredentials(new \GuzzleHttp\Client(), 'koenigs.ru', 'Foolprof03', null);
            //$instagram->login();
            $client = new \GuzzleHttp\Client();
            //$client->request('GET', 'https://www.instagram.com', ['proxy' => 'http://localhost:8125']);
            $instagram = new \InstagramScraper\Instagram(new \GuzzleHttp\Client(['proxy' => 'http://localhost:9124']));
            //\InstagramScraper\Instagram::setHttpClient(new \GuzzleHttp\Client());
            //$instagram->setUserAgent('Mozilla/5.0 (Linux; U; Android 4.4.2; en-us; SCH-I535 Build/KOT49H) AppleWebKit/534.30 (KHTML, like Gecko) Version/4.0 Mobile Safari/534.30');
            $account = $instagram->getAccount('kuda_dety39');

            //$ar_result = [];
            //preg_match('~<script type="text/javascript">window\._sharedData = (.+)</script>~', $result, $ar_result);
            //$result = $ar_result[1];
            //$result = substr($result,0,-1);
            $ar_result = json_decode($result, true); //edges
            $result_video = $ar_result['graphql']['user']['edge_felix_video_timeline']['edges'];
            $result_photo = $ar_result['graphql']['user']['edge_owner_to_timeline_media']['edges'];
            $_list = [];
            foreach ($result_video as $key => $item) {
                $url = $item['node']['display_url'];
                $text = $item['node']['edge_media_to_caption']['edges'][0]['node']['text'];
                $date = $item['node']['taken_at_timestamp'];
                $_list[] = [
                    'url' => $url,
                    'text' => $text,
                    'date' => $date,
                ];
            }

            foreach ($result_photo as $key => $item) {
                $url = $item['node']['display_url'];
                $text = $item['node']['edge_media_to_caption']['edges'][0]['node']['text'];
                $date = $item['node']['taken_at_timestamp'];
                $_list[] = [
                    'url' => $url,
                    'text' => $text,
                    'date' => $date,
                ];
            }
            //scr::_v($result);
            //scr::v(json_decode($result, true));
            //$contents = file_get_contents('http://mydomain.com/folder/image.jpg');
        } catch (\Throwable $e) {
            //   $account = null;
            //$result = '------------';
            \Yii::$app->session->setFlash('error', $e->getMessage());
        }
        return $this->render('index', [
            //'account' => $account,
            'result_video' => $result_video,
            'result_photo' => $result_photo,
            'list' => $_list,
            'result' => $result,
        ]);
    }
}
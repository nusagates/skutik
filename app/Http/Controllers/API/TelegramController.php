<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;

class TelegramController extends Controller
{
    private $api_url;

    public function __construct()
    {
        $this->api_url = "https://api.telegram.org/bot1590978111:AAHqwik9_T2ieSA_U8LnPcESxAhyt0K9omY/";
    }

    public function response(Request $request)
    {
        Post::create([
            'slug' => now()->timestamp,
            'user_id' => 1,
            'post_title' => "Bot",
            'post_content' => json_encode($request->post()),
        ]);
        $data = $request->post();
        $response = 'no response';
        if (isset($data['message'])) {
            $message = $data['message'];
            $chat_id = $message['chat']['id'];
            $text = $message['text'];
            switch ($text) {
                case 'info':
                    $response = $this->sendMessage($chat_id, "Pilih Menu di Bawah", 'info');
                    break;
                case 'about':
                    $response = $this->sendMessage($chat_id, "Pilih Menu di Bawah", 'about');
                    break;
                case 'hari':
                    $this->sendMessage($chat_id, strftime("%A", strtotime(date("Y-m-d"))));
                    break;
                case 'jadwal':
                    $this->sendChatAction($chat_id, 'typing');
                    break;
            }
        } elseif (isset($data["callback_query"])) {
            $data = $data["callback_query"];
            $message = $data['message'];
            $chat_id = $message['chat']['id'];
            $text = $data['data'];
            switch ($text) {
                case 'about':
                    $response = $this->sendMessage($chat_id, "Pilih Menu di Bawah", 'about');
                    break;
                case 'profil':
                    $response = $this->sendMessage($chat_id, "Dibuat oleh Blogger Sejoli yang ditujukan untuk berbagi kisah dan ragam tulisan menarik lainnya.");
                    break;
            }
        }
        return $response;
    }

    private function sendMessage($chat_id, $message, $reply = '')
    {
        $info = [
            'inline_keyboard' => [
                [
                    ['text' => 'Tentang Skutik', 'callback_data' => 'about'],
                    ['text' => 'Jadwal Sholat', 'callback_data' => 'someString'],
                ],
                [
                    ['text' => 'Baca Artikel', 'callback_data' => 'someString'],
                    ['text' => 'Pinjam Buku', 'callback_data' => 'someString'],
                ],
                [
                    ['text' => 'Kamus', 'callback_data' => 'someString']
                ]
            ]
        ];
        $info_reply = [
            'inline_keyboard' => [
                [
                    ['text' => 'Profil', 'callback_data' => 'profil'],
                ],
                [
                    ['text' => 'Author', 'callback_data' => 'Skutikku'],
                    ['text' => 'Visi & Misi', 'callback_data' => 'someString'],
                ]
            ]
        ];
        $keyboard = '';
        if ($reply == 'info') {
            $keyboard = json_encode($info);
        } elseif ($reply == 'about') {
            $keyboard = json_encode($info_reply);
        }
        return Http::post($this->api_url . "sendMessage", [
            'chat_id' => $chat_id,
            'text' => $message,
            'reply_markup' => $keyboard
        ]);
    }

    private function sendChatAction($chat_id, $type)
    {
        $response = Http::post($this->api_url . "sendChatAction", [
            'chat_id' => $chat_id,
            'action' => $type,
        ]);
    }
}

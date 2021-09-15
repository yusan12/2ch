<?php

namespace App\Http\Controllers;

use App\Image;
use Illuminate\Http\Request;
use App\Http\Requests\MessageRequest;
use App\Services\MessageService;
use App\Services\ImageService;
use Illuminate\Support\Facades\Auth;

class MessageController extends Controller
{
    protected $message_service;

    /**
     * The ImageService implementation.
     *
     * @var ImageService
     */
    protected $image_service;

    public function __construct(
        MessageService $message_service,
        ImageService $image_service
    )
    {
        $this->middleware('auth');
        $this->message_service = $message_service;
        $this->image_service = $image_service;
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(MessageRequest $request, int $id)
    {
        try {
            $data = $request->validated();// バリデーションした値を変数へ。
            $data['user_id'] = Auth::id(); // ログイン中のユーザー id を配列に追加。
            $message = $this->message_service->createNewMessage($data, $id);

            $images = $request->file('images'); // 投稿された画像を $images に代入
            if ($images) {// $images が存在するか（画像投稿されたかどうか）
                $this->image_service->createNewImages($images, $message->id);
            }
        } catch (Exception $error) {
            return redirect()->route('threads.show', $id)->with('error', 'メッセージの投稿ができませんでした。');
        }
        return redirect()->route('threads.show', $id)->with('success', 'メッセージを投稿しました');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}

<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreRequest;
use App\Models\Message;
use Illuminate\Http\Request;

class ChatController extends Controller
{
    public function index(): Factory|View|Application
    {
        auth()->loginUsingId(1);

        return view('chat');
    }

    public function messages(): Collection|array
    {
        return Message::query()
//            ->with('user')
            ->get();
    }

    public function send(StoreRequest $request)
    {
        $message = $request->user()
            ->messages()
            ->create($request->validated());

        broadcast(new MessageSent($request->user(), $message));

        return $message;
    }
}

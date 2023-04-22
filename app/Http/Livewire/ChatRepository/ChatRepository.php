<?php

/**
 * Created by PhpStorm.
 * User: Francis
 * Date: 10.04.2023
 * Time: 2:58
 */
namespace App\Http\Livewire\ChatRepository;
use App\Models\User;
use App\Models\Message;
use App\Models\ChatTitle;
use App\Models\UsersChat;
use App\Models\Notification;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

class ChatRepository
{
    public static function search($search): object
    {
        $search = User::where('name', 'like', '%' . $search . '%')
            ->orWhere('email', 'like', '%' . $search . '%')
            ->orWhere('phone', 'like', '%' . $search . '%')
            ->get();
        return $search;
    }

    public static function addUserToChat($user_id, $chat = []): void
    {
        $user = User::findOrFail($user_id);

        if ($chat) {
            $chat_id = $chat[0]['id'];
        } else {
            $chat_id = null;
        }

        UsersChat::create([
            'user_id' => $user->id,
            // 'total_messages' => ,
            'creator_id' => Auth::id(),
            'chat_id' => $chat_id,
        ]);
    }

    public static function getUsers(): object
    {
        return UsersChat::where('creator_id', Auth::id())
            ->where('chat_id', null)
            ->get();
    }

    public static function selectUser($id)
    {
        $user = UsersChat::where('user_id', $id)
            ->where('creator_id', Auth::id())
            ->where('chat_id', null)
            ->get();
        return $user;
    }

    public static function setMessage(
        $receiver = [],
        $message,
        $chat = []
    ): void {
        if ($chat) {
            $chat_id = $chat[0]['id'];
            $id = null;
            self::setGroupUnreadMessages($chat_id);
        } else {
            $receiver = collect($receiver)->toArray();
            $id = $receiver[0]['user_id'];
            $chat_id = null;
            self::startChat($id); // start chat if not already started
        }

        Message::create([
            'sender_id' => Auth::id(),
            'receiver_id' => $id,
            'message' => $message,
            'chat_id' => $chat_id,
        ]);
    }

    public static function getMessages($id)
    {
        // dump($id);
        $messages = Message::where('sender_id', $id)
            ->where('receiver_id', Auth::id())
            ->orWhere('sender_id', Auth::id())
            ->where('receiver_id', $id)
            ->where('chat_id', null)
            ->orderBy('created_at', 'ASC')
            ->get();
        // dump( $messages);
        return $messages;
    }

    public static function unReadMessages()
    {
        $id = auth()->id();
        $users = UsersChat::pluck('user_id')->toArray();
        $senderIds = Message::all()
            ->where('receiver_id', $id)
            ->whereIn('sender_id', $users)
            ->where('isRead', 0)
            ->where('chat_id', null)
            ->pluck('sender_id')
            ->toArray();
        $messageCount = [];
        foreach ($senderIds as $id) {
            isset($messageCount[$id])
                ? $messageCount[$id]++
                : ($messageCount[$id] = 1);
        }

        return $messageCount;
    }

    public static function readMessages($id)
    {
        $messages = Message::where('receiver_id', Auth::id())
            ->where('sender_id', $id)
            ->where('isRead', 0)
            ->get();
        foreach ($messages as $message) {
            $message->isRead = 1;
            $message->save();
        }
    }

    public static function isUserInChat($model, $user_id, $chat = [])
    {
        if ($chat) {
            $chat_id = collect($chat)->toArray();
        } else {
            $chat_id = null;
        }

        $response = '';
        $users = $model
            ::where('creator_id', Auth::id())
            ->where('chat_id', $chat_id)
            ->pluck('user_id')
            ->toArray();

        in_array($user_id, $users) ? ($response = true) : ($response = false);

        return $response;
    }

    private static function startChat($id)
    {
        // creates a chat with the user if the chat is not already started. (if already not in a users chat group)
        $users = UsersChat::where('user_id', Auth::id())
            ->where('creator_id', $id)
            ->get()
            ->toArray();
        if (!$users) {
            UsersChat::create([
                'user_id' => Auth::id(),
                // 'total_messages' => ,
                'creator_id' => $id,
            ]);
        }
    }

    public static function setNotification()
    {
        $routeName = Route::currentRouteName();

        $newMesaages = Message::where('receiver_id', Auth::id())
            ->where('isRead', 0)
            ->get()
            ->toArray();
        $notifications = Notification::where('receiver_id', Auth::id())
            ->where('message', 'You have new messages')
            ->where('read_at', 0)
            ->get()
            ->toArray();
        if (!$notifications) {
            if ($newMesaages) {
                if ($routeName !== 'chat') {
                    Notification::create([
                        'sender_id' => Auth::id(),
                        'receiver_id' => Auth::id(),
                        'message' => 'You have new messages',
                    ]);
                }
            }
        }
    }

    public static function createGroupChat($string): void
    {
        $chat = ChatTitle::create([
            'title' => $string,
        ]);

        if ($chat) {
            UsersChat::create([
                'user_id' => Auth::id(),
                'creator_id' => Auth::id(),
                'chat_id' => $chat->id,
            ]);
        }
    }

    public static function getGroupChats()
    {
        $myGroupChats = UsersChat::where('user_id', Auth::id())
            //->where('chat_id', Auth::id())
            ->pluck('chat_id')

            ->toArray();

        $groups = ChatTitle::whereIn('id', $myGroupChats)->get();
        return $groups;
    }

    public static function selectGroup($id)
    {
        $activeGroup = ChatTitle::where('id', $id)->get();
        return $activeGroup;
    }

    public static function getGroupMembers($id)
    {
        $groupMembers = UsersChat::where('chat_id', $id)->get();
        return $groupMembers;
    }

    public static function getGroupMessages($id)
    {
        if ($id == null) {
            $groupMessages = [];
        } else {
            $groupMessages = Message::where('chat_id', $id)->get();
            self::readGroupMessages($id);
        }

        //dump(  $groupMessages,$id );
        return $groupMessages;
    }

    public static function unreadGroupMessages()
    {
        $chatGroups = UsersChat::where('user_id', Auth::id())
            ->pluck('chat_id')
            ->toArray();
        $groups = UsersChat::where('user_id', Auth::id())
            ->whereIn('chat_id', $chatGroups)
            ->get();

        $groupMessageCount = [];
        foreach ($groups as $chat) {
            $groupMessageCount[$chat->chat_id] =
                $chat->group_chat_message_count;
        }
        //dump( $groupMessageCount);
        return $groupMessageCount;
    }

    private static function setGroupUnreadMessages($chat_id): void
    {
        $users = UsersChat::where('chat_id', $chat_id)
            ->where('user_id', '!=', Auth::id())
            ->get();

        foreach ($users as $user) {
            $user->group_chat_message_count++;
            $user->save();
        }
    }

    private static function readGroupMessages($chat_id)
    {
        $users = UsersChat::where('chat_id', $chat_id)
            ->where('user_id', Auth::id())
            ->get();
        foreach ($users as $user) {
            $user->group_chat_message_count = 0;
            $user->save();
        }
    }

    public static function isAdmin($groupID)
    {
        $user = UsersChat::where('chat_id', $groupID)
        ->whereRaw('user_id = creator_id')->first();
        if( $user->user_id == Auth::id())
        {
           return true;
        }
    
}
}
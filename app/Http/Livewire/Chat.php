<?php

namespace App\Http\Livewire;


use Livewire\Component;
use Illuminate\Support\Facades\Auth;
use App\Http\Livewire\ChatRepository\ChatRepository;
use App\Models\UsersChat;

class Chat extends Component
{
    // public $chat = [];
    public $search;
    public $message;
    public $activeUserId;
    public $activeUser = [];

    public function mount($setDefaultUser)
    {
        $this->selectUser($setDefaultUser);
    }

    public function search()
    {
        return ChatRepository::search($this->search);
    }

    public function addUserToChat($id): void
    {
        // dump($id,(array)$this->getUsers());
        if ($id == Auth::id()) {
            $this->dispatchBrowserEvent('message', [
                'text' => 'Cant chat with Urself',
            ]);
        } elseif (ChatRepository::isUserInChat(UsersChat::class, $id)) {
            $this->dispatchBrowserEvent('message', [
                'text' => 'User already added',
            ]);
        } else {
            ChatRepository::addUserToChat($id);
            $this->dispatchBrowserEvent('message', [
                'text' => 'User added to chat',
            ]);
            $this->search = null;
        }
    }

    public function getUsers()
    {
        return ChatRepository::getUsers();
    }

    public function selectUser($id)
    {
        $activeUser = ChatRepository::selectUser($id);
        $this->getMessage($id);
        $this->activeUserId = $id;
        return $this->activeUser = $activeUser;
    }

    public function setMessage(): void
    {
        ChatRepository::setMessage($this->activeUser, $this->message);
        $this->message = '';
    }

    public function getMessage($id)
    {
        ChatRepository::readMessages($id);
        return ChatRepository::getMessages($id);
    }

    public function unReadMessages()
    {
        return ChatRepository::unReadMessages();
    }

    public function render()
    {
      // ChatRepository::setNotification();
        $unreadCount = $this->unReadMessages();
        $searchUsers = [];
        $users = $this->getUsers();
        $messages = $this->getMessage($this->activeUserId);
        // dd( $messages );
        $this->search != null ? ($searchUsers = $this->search()) : '';

        return view('livewire.chat', [
            'unreadCount' => $unreadCount,
            'searchUsers' => $searchUsers,
            'messages' => $messages,
            'users' => $users,
        ]);
    }
}

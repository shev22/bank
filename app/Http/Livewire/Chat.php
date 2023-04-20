<?php

namespace App\Http\Livewire;

use Livewire\Component;
use Illuminate\Support\Facades\Auth;
use App\Http\Livewire\ChatRepository\ChatRepository;
use App\Models\UsersChat;

class Chat extends Component
{
    public $search;
    public $message;
    public $groupName;
    public $activeUserId;
    public $activeGroupId;
    //public $messages = [];
    public $activeUser = [];
    public $activeGroup = [];
    public $groupMembers = [];

    public function mount($setDefaultUser)
    {
        $this->selectUser($setDefaultUser);
    }

    public function rules()
    {
        return [
           
            'message' => 'required|string',
        ];
    }

    public function updated($propertyName)
    {
        $this->validateOnly($propertyName);
    }

    public function search()
    {
       
        return ChatRepository::search($this->search);
    }

    public function addUserToChat($user_id, $chat): void
    {
        if ($user_id == Auth::id()) {
            $this->dispatchBrowserEvent('message', [
                'text' => 'Cant chat with Urself',
            ]);
        } elseif (
            ChatRepository::isUserInChat(
                UsersChat::class,
                $user_id,
                $this->activeGroup
            )
        ) {
            $this->dispatchBrowserEvent('message', [
                'text' => 'User already added',
            ]);
        } else {
            ChatRepository::addUserToChat($user_id, $chat);
            $this->dispatchBrowserEvent('message', [
                'text' => 'User added to chat',
            ]);
           // $this->search = null;
        }
    }

    public function getUsers()
    {
        return ChatRepository::getUsers();
    }

    public function selectUser($id)
    {

        // dump($id);
        $activeUser = ChatRepository::selectUser($id);
       // $this->messages = $this->getMessage($id);
        $this->activeUserId = $id;
        $this->activeGroup = [];
        $this->activeUser = $activeUser;
    }

    public function setMessage(): void
    {
        $validatedData = $this->validate();
        ChatRepository::setMessage(
            $this->activeUser,
            $this->message,
            $this->activeGroup
        );

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

    public function createGroupChat(): void
    {
        ChatRepository::createGroupChat($this->groupName);
    }

    public function getGroupChats()
    {
        return ChatRepository::getGroupChats();
    }

    public function selectGroup($id)
    {
        $this->activeGroupId = $id;
        $activeGroup = ChatRepository::selectGroup($id);
        $this->activeUser = [];
        $this->activeGroup = $activeGroup;
        $this->getGroupMembers($id);
       // $this->messages = $this->getGroupMessages($id);
    }

    public function getGroupMembers($id)
    {
        $groupMembers = ChatRepository::getGroupMembers($id);
        $this->groupMembers = $groupMembers;
    }

    public function getGroupMessages($id)
    {
        return ChatRepository::getGroupMessages($id);
    }

    public  function unreadGroupMessages()
    {
      return ChatRepository::unreadGroupMessages();
    }
    public function render()
    {
      
        $searchUsers = [];
        $users = $this->getUsers();
        $groups = $this->getGroupChats();
        $unreadCount = $this->unReadMessages();
        $groupUnreadCount = $this->unreadGroupMessages();
        $messages = $this->getMessage($this->activeUserId);
        $this->search != null ? ($searchUsers = $this->search()) : '';
        $groupMessages = $this->getGroupMessages($this->activeGroupId);
      // dump( $groupMessages);

        return view('livewire.chat', [
            'groupUnreadCount' => $groupUnreadCount,
            'groupMessages' => $groupMessages,
            'unreadCount' => $unreadCount,
            'searchUsers' => $searchUsers,
            'messages' => $messages, 
            'groups' => $groups,
            'users' => $users,
        ]);
    }
}

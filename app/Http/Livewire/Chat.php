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
    public $activeUser = array();
    public $activeGroup = array();
    public $groupMembers = array();
   
  
 
   

    public function mount($setDefaultUser)
    {
    
        $this->selectUser($setDefaultUser);
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
        } elseif (ChatRepository::isUserInChat(UsersChat::class, $user_id, $this->activeGroup )) {
            $this->dispatchBrowserEvent('message', [
                'text' => 'User already added',
            ]);
        } else {
            ChatRepository::addUserToChat($user_id,  $chat);
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
        $this->activeGroup = array();
        $this->activeUser = $activeUser;
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

    public  function createGroupChat(): void
    {
      ChatRepository::createGroupChat($this->groupName);
    }

    public function getGroupChats()
    {
     return(ChatRepository::getGroupChats()) ;
    }

    public  function selectGroup($id)
    {
      $activeGroup = ChatRepository::selectGroup($id);
      $this->activeUser =  array();
      $this->activeGroup = $activeGroup;
      $this->getGroupMembers($id);
    }

    public  function getGroupMembers($id)
    {
      $groupMembers = ChatRepository::getGroupMembers($id);
       $this->groupMembers =  $groupMembers ;
    }


































    public function render()
    {
    
     
       
        $searchUsers = array();    
        $users = $this->getUsers();
        $groups = $this->getGroupChats();
        $unreadCount = $this->unReadMessages();
        $messages = $this->getMessage($this->activeUserId);
        $this->search != null ? ($searchUsers = $this->search()) : '';

        return view('livewire.chat', [
            'unreadCount' => $unreadCount,
            'searchUsers' => $searchUsers,
            'messages' => $messages,
            'groups' => $groups,
            'users' => $users,
        ]);
    }
}

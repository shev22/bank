
<div>
    {{-- @include('frontend.modals.group-chat') --}}
    {{-- <link href="//maxcdn.bootstrapcdn.com/bootstrap/4.1.1/css/bootstrap.min.css" rel="stylesheet" id="bootstrap-css"> 
 <script src="//maxcdn.bootstrapcdn.com/bootstrap/4.1.1/js/bootstrap.min.js"></script>
     <script src="//cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script> --}}
    <!------ Include the above in your HEAD tag ---------->

    <!DOCTYPE html>
    <html>

    <head>
        <title>Chat</title>
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet">
        <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.5.0/css/all.css">
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
        <link rel="stylesheet" type="text/css"
            href="https://cdnjs.cloudflare.com/ajax/libs/malihu-custom-scrollbar-plugin/3.1.5/jquery.mCustomScrollbar.min.css">
        <script type="text/javascript"
            src="https://cdnjs.cloudflare.com/ajax/libs/malihu-custom-scrollbar-plugin/3.1.5/jquery.mCustomScrollbar.min.js">
        </script>
        <link href="{{ asset('assets/css/chat.css') }}" rel="stylesheet" />
        <script>
            $(document).ready(function() {
                $('#action_menu_btn').click(function() {
                    $('.action_menu').toggle();
                });

                $('#create_chat_button').click(function() {
                    $('.action_menu_group_chat').slideToggle("500");
                });
            });
        </script>

    </head>

    <body>
   
      <div class="container-fluid h-100"> 
        <div class="container-fluid h-100">
            <div class="row justify-content-center h-100">
                <div class="col-md-4 col-xl-3 chat">
                    <div class="card mb-sm-3 mb-md-0 contacts_card">
                        <div class="card-header">
                         
                            <h6 class="text-secondary mx-3 text-sm fw-bold"> {{ date('l, M-d  H:m:s') }}</h6>
                            <span id="create_chat_button"><i class="fas fa-ellipsis-v"></i></span> 
                            
                            <div class="action_menu_group_chat mb-0">
                                <ul>
                                    <li><button data-bs-toggle="modal" data-bs-target="#group-chat"    type="button" class="btn btn-outline-secondary btn-sm mb-0 mt-2 mx-auto"><i class="fas fa-plus "> </i><span class="mx-2">create chat</span> </button></li>            
                                </ul>
                            </div>
                  
                            <div class="input-group">
                                
                                <input type="text" placeholder="Search..." wire:model="search"
                                    class="form-control search">
                                <div class="input-group-prepend">
                                    <span class="input-group-text search_btn"><i class="fas fa-search"></i></span>
                                </div>
                            </div>
                        </div>
                        <div class="card-body contacts_body">
                            <ul style="text-decoration: none">
                                @foreach ($searchUsers as $item)
                                    <li class="active ">
                                        <div class="d-flex bd-highlight ">
                                            <div class="user_info">

                                                @if ($this->activeGroup)
                                                <a wire:click="addUserToChat({{ $item->id }}, {{ $this->activeGroup }})"> <span
                                                    class="text-sm fst-italic "
                                                    role='button'>{{ $item->name }}</span></a> 
                                                @else
                                                     <a wire:click="addUserToChat({{ $item->id }}, null)"> <span
                                                        class="text-sm fst-italic "
                                                        role='button'>{{ $item->name }}</span></a> 
                                                @endif

                                              




                                            </div>
                                        </div>
                                    </li>
                                @endforeach
                            </ul>
                     

                            <ui class="contacts">
                                @foreach ($groups as $item)
                                <a wire:click="selectGroup({{ $item->id }})">
                                        <li class="active p-0">

                                            <div class="d-flex bd-highlight mx-3 p-0">
                                              
                                                <div class="img_cont_msg">
                                                    <img src="https://static.turbosquid.com/Preview/001292/481/WV/_D.jpg"
                                                        class="rounded-circle user_img_msg ">                                                     
                                                </div>
                                                <div class="user_info">
                                                    <span class="text-sm fw-bold">{{ $item->title }} </span>
                                                </div>
                                            </div>
                                        </li>
                                    </a>
                                @endforeach
                        


                 
                                @foreach ($users as $item)
                                    <a wire:click="selectUser({{ $item->user_id }})">
                                        <li class="active">

                                            <div class="d-flex bd-highlight">
                                                <div class="img_cont">
                                                    <img src="https://static.turbosquid.com/Preview/001292/481/WV/_D.jpg"
                                                        class="rounded-circle user_img">
                                                    <span class="online_icon"></span>
                                                </div>
                                                <div class="user_info">
                                                    <span class="text-sm fw-bold">{{ $item->user->name }} </span>

                                                    @foreach ($unreadCount as $key => $value)
                                                        @if ($item->user_id == $key)
                                                            <span style="font-size: 9px; "
                                                                class="badge rounded-pill text-bg-danger ">{{ $value }}</span>
                                                        @endif
                                                    @endforeach

                                                    <p>online</p>
                                                </div>
                                            </div>

                                        </li>
                                    </a>
                                @endforeach
                            </ui>
                        </div>
                        <div class="card-footer"></div>
                    </div>
                </div>
                <div class="col-md-8 col-xl-6 chat" >
                    <div class="card">
                        <div class="card-header msg_head">
                            <div class="d-flex bd-highlight">
                                <div class="img_cont">
                                    <img src="https://static.turbosquid.com/Preview/001292/481/WV/_D.jpg"
                                        class="rounded-circle user_img">
                                    <span class="online_icon"></span>
                                </div>
                                @foreach ($activeUser as $item)
                                    <div class="user_info">

                                        <span class="fw-bold">{{ $item->user->name }}</span>
                                        <p>{{ $item->total_messages }} Messages</p>
                                    </div>
                                @endforeach
                                @foreach ($activeGroup as $item)
                                <div class="user_info">

                                    <span class="fw-bold">{{ $item->title }}</span>
                                    <p>{{ $item->total_messages }} Messages</p>
                                </div>
                            @endforeach

                            <div class="video_cam">
                                <span><i class="fas fa-video"></i></span>
                                <span><i class="fas fa-phone"></i></span>
                            </div>
                         
                                
                            </div>
                          
                            <span id="action_menu_btn" wire:ignore><i class="fas fa-ellipsis-v"></i></span>
                        @if ($this->activeGroup)
                            <div class="action_menu"  >
                                <ul>

                                    {{-- <li><i class="fas fa-user-circle"></i> View profile</li>
                                    <li><i class="fas fa-users"></i> Add to close friends</li>
                                    <li><i class="fas fa-plus"></i> Add to group</li>
                                    <li><i class="fas fa-ban"></i> Block</li>
                               --}}
                               <li><i class="fas fa-users"></i> Group members</li>
                                  @foreach ($groupMembers as $item)
                                  <li>
                                    @if ( $item->creator_id == Auth::id())
                                    <span class="text-danger text-sm"><i class="fas fa-trash"></i></span> 
                                    
                                    @elseif ($item->user_id == Auth::id() )
                                    <span class="text-danger text-sm"><i class="fas fa-trash"></i></span> 
                                    @endif
                                     
                                     
                                     {{ $item->user->name }} <span class="mx-4 text-sm text-success fst-italic fw-bold">
                                        {{ $item->creator_id == $item->user_id  ? ' Admin' : ''}}</span>
                                    
                                    
                                    </li>
                                  @endforeach
                               
                                </ul>
                            </div>
                            @else
                            <div class="action_menu"  >
                                <ul>

                                    <li><i class="fas fa-user-circle"></i> View profile</li>
                                    <li><i class="fas fa-users"></i> Add to close friends</li>
                              
                              
                                    

                                  
                                </ul>
                            </div>

                         @endif
                       
                        </div>
                        <div class="card-body msg_card_body">

                            @foreach ($messages as $message)
                                @if ($message->sender_id == $this->activeUserId)
                                    <div class="d-flex justify-content-start mb-4">
                                        <div class="img_cont_msg">
                                            <img src="https://static.turbosquid.com/Preview/001292/481/WV/_D.jpg"
                                                class="rounded-circle user_img_msg">
                                        </div>
                                        <div class="msg_cotainer fw-bold">
                                            {{ $message->message }}
                                            <span
                                                class="msg_time">{{ Carbon\Carbon::parse($message->updated_at)->diffForHumans() }}</span>
                                        </div>
                                    </div>
                                @elseif($message->sender_id == Auth::id())
                                    <div class="d-flex justify-content-end mb-4">
                                        <div class="msg_cotainer_send fw-bold">
                                            {{ $message->message }}
                                            <span
                                                class="msg_time_send">{{ Carbon\Carbon::parse($message->updated_at)->diffForHumans()  }}</span>
                                        </div>
                                        <div class="img_cont_msg">
                                            <img src="https://static.turbosquid.com/Preview/001292/481/WV/_D.jpg"
                                                class="rounded-circle user_img_msg">
                                        </div>
                                    </div>
                                @endif
                            @endforeach


                        </div>

                        <form wire:submit.prevent="setMessage()">
                            <div class="card-footer">
                                <div class="input-group">
                                    <input wire:model.lazy="message" class="form-control type_msg"
                                        placeholder="Type your message...">
                                    <div class="input-group-append">
                                        <button class="input-group-text send_btn"><i
                                                class="fas fa-location-arrow"></i></button>
                                    </div>
                                </div>
                            </div>
                        </form>

                    </div>
                </div>
            </div>
        </div>
    </body>

    </html>
</div>

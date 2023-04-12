<nav class="navbar navbar-main navbar-expand-lg px-0 mx-4 shadow-none border-radius-xl" id="navbarBlur" data-scroll="true">
    <div class="container-fluid py-1 px-3">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb bg-transparent mb-0 pb-0 pt-1 px-0 me-sm-6 me-5">
                <li class="breadcrumb-item text-sm"><a class="opacity-5 text-dark" href="{{Request::route()->getName()}}">Pages</a></li>
                <li class="breadcrumb-item text-sm text-dark active" aria-current="page">
                    {{ ucfirst(Request::route()->getName()) }}</li>
            </ol>
            <h6 class="font-weight-bolder mb-0">{{ ucwords(strtolower(Request::route()->getName())) }} </h6>
        </nav>


        @if (Session::has('message'))
            <p class="alert {{ Session::get('alert-class', 'alert-info') }}"><span
                    class="text-white fw-bold">{{ Session::get('message') }}</span></p>
        @endif

        @error('account_name')
            <p class="alert alert-class alert-danger"><span class="text-white fw-bold">{{ $message }}</span></p>
        @enderror
        <br>
        @error('account_currency')
            <p class="alert alert-class alert-danger"><span class="text-white fw-bold">{{ $message }}</span></p>
        @enderror
         <br>
        @error('search')
            <p class="alert alert-class alert-danger"><span class="text-white fw-bold">{{ $message }}</span></p>
        @enderror
        <div class="collapse navbar-collapse mt-sm-0 mt-2 me-md-0 me-sm-4" id="navbar">
            <div class="ms-md-auto pe-md-3 d-flex align-items-center">

                <form method="post" action="{{ url('search') }}">
                    @csrf
                    <div class="input-group input-group-outline">
                        <label class="form-label">Type here...</label>
                        <input type="text" class="form-control" name="search">

                    </div>
                </form>

            </div>

            <ul class="navbar-nav  justify-content-end">

                <li class="nav-item dropdown">
                    <a id="navbarDropdown" class="nav-link text-body font-weight-bold px-0 dropdown-toggle"
                        href="#" role="button" data-bs-toggle="dropdown" aria-haspopup="true"
                        aria-expanded="false" v-pre>
                        <i class="fa fa-user me-sm-1"></i>
                        <span class="d-sm-inline d-none">{{ Auth::user()->name }}</span>
                    </a>

                    <div class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdown">
                        <a class="dropdown-item" href="{{ route('logout') }}"
                            onclick="event.preventDefault();
                                   document.getElementById('logout-form').submit();">
                            {{ __('Logout') }}
                        </a>

                        <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                            @csrf
                        </form>
                    </div>
                </li>

                <li class="nav-item px-3 d-flex align-items-center">
                    <a href="javascript:;" class="nav-link text-body p-0">
                        <i class="fa fa-cog fixed-plugin-button-nav cursor-pointer"></i>
                    </a>
                </li>
                <li class="nav-item dropdown pe-2 d-flex align-items-center">
                    <a href="javascript:;" class="nav-link text-body p-0 position-relative " id="dropdownMenuButton"
                        data-bs-toggle="dropdown" aria-expanded="false">

                        <div class="newMessage">
                            <i class="fa fa-bell cursor-pointer "></i>
                            @if ($newMessage !== [])
                                <span
                                    class="position-absolute top-0 start-100 translate-middle p-1 bg-danger border border-light rounded-circle ">
                                    <span class="visually-hidden">New alerts</span>
                                </span>
                        </div>
                        @endif
                    </a>
                    <ul class="dropdown-menu  dropdown-menu-end  px-2 py-3 me-sm-n4"
                        aria-labelledby="dropdownMenuButton">
                        <li class="mb-2">
                            <a class="dropdown-item border-radius-md" href="javascript:;">
                                <div class="d-flex py-1">
                                    <div class="my-auto">
                                        <img src="../assets/img/team-2.jpg" class="avatar avatar-sm  me-3 ">
                                    </div>
                                    <div class="d-flex flex-column justify-content-center">
                                        <h6 class="text-sm font-weight-normal mb-1">
                                            <span class="font-weight-bold">New message</span> from Laur
                                        </h6>
                                        <p class="text-xs text-secondary mb-0">
                                            <i class="fa fa-clock me-1"></i>
                                            13 minutes ago
                                        </p>
                                    </div>
                                </div>
                            </a>
                        </li>

                        @foreach ($notifications as $notification)
                            <div id="notification ">
                                <li>
                                    <a class="dropdown-item read border-radius-md" id="{{ $notification->id }}">
                                        <input type="hidden" id="data" name="data"
                                            value="{{ $notification->message }}">
                                        <div class="d-flex py-1 overflow-auto">
                                            <div class="avatar avatar-sm bg-gradient-secondary  me-3  my-auto">
                                                <svg width="12px" height="12px" viewBox="0 0 43 36" version="1.1"
                                                    xmlns="http://www.w3.org/2000/svg"
                                                    xmlns:xlink="http://www.w3.org/1999/xlink">
                                                    <title>credit-card</title>
                                                    <g stroke="none" stroke-width="1" fill="none"
                                                        fill-rule="evenodd">
                                                        <g transform="translate(-2169.000000, -745.000000)"
                                                            fill="#FFFFFF" fill-rule="nonzero">
                                                            <g transform="translate(1716.000000, 291.000000)">
                                                                <g transform="translate(453.000000, 454.000000)">
                                                                    <path class="color-background"
                                                                        d="M43,10.7482083 L43,3.58333333 C43,1.60354167 41.3964583,0 39.4166667,0 L3.58333333,0 C1.60354167,0 0,1.60354167 0,3.58333333 L0,10.7482083 L43,10.7482083 Z"
                                                                        opacity="0.593633743"></path>
                                                                    <path class="color-background"
                                                                        d="M0,16.125 L0,32.25 C0,34.2297917 1.60354167,35.8333333 3.58333333,35.8333333 L39.4166667,35.8333333 C41.3964583,35.8333333 43,34.2297917 43,32.25 L43,16.125 L0,16.125 Z M19.7083333,26.875 L7.16666667,26.875 L7.16666667,23.2916667 L19.7083333,23.2916667 L19.7083333,26.875 Z M35.8333333,26.875 L28.6666667,26.875 L28.6666667,23.2916667 L35.8333333,23.2916667 L35.8333333,26.875 Z">
                                                                    </path>
                                                                </g>
                                                            </g>
                                                        </g>
                                                    </g>
                                                </svg>
                                            </div>
                                            <div class="d-flex flex-column justify-content-center .overflow-auto"
                                                id="content{{ $notification->id }}">
                                                <h6
                                                    class="text-sm font-weight-{{ $notification->read_at == 0 ? 'bold' : 'normal' }} mb-1">
                                                    {{ $notification->message }}
                                                </h6>
                                                <p class="text-xs text-secondary mb-0">
                                                    <i class="fa fa-clock me-1"></i>
                                                    {{ Carbon\Carbon::parse($notification->created_at)->diffForHumans() }}
                                                </p>
                                            </div>
                                        </div>
                                    </a>
                                </li>
                            </div>
                        @endforeach
                    </ul>
                </li>
            </ul>
        </div>
    </div>
</nav>
{{-- @php
  App\Http\Livewire\ChatRepository\ChatRepository::setNotification();  //  check for new messages
@endphp --}}
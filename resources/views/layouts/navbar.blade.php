<nav class="navbar navbar-expand-lg navbar-dark" style="background-color: #363636;">
    <a class="navbar-brand mb-0 h1" href={{ route('index') }}>Dashboard</a>
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNavDropdown" aria-controls="navbarNavDropdown" aria-expanded="false" aria-label="Toggle navigation">
    <span class="navbar-toggler-icon"></span>
    </button>
        <div class="collapse navbar-collapse" id="navbarNavDropdown">
            <ul class="navbar-nav mr-auto">
                <li class="nav-item">
                  <a class="nav-link font-weight-bold" href={{ route('index') }}>Home <span class="sr-only">(current)</span></a>
                </li>
                <li class="nav-item">
                  <a class="nav-link font-weight-bold" href={{ route('posts.index') }}>簡易公告系統</a>
                </li>
                @auth
                <li class="nav-item dropdown">
                    <a class="nav-link font-weight-bold dropdown-toggle" href="#" id="navbarDropdownMenuLink" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">資料查詢</a>
                    <div class="dropdown-menu" aria-labelledby="navbarDropdownMenuLink">
                        <a class="dropdown-item font-weight-bold" id='search1' href={{ route('searchs.search1')}}>進退貨資訊查詢</a>
                        <a class="dropdown-item font-weight-bold" id='search2' href={{ route('searchs.search2')}}>展場庫存查詢</a>
                        <a class="dropdown-item font-weight-bold" href={{ route('searchs.index')}}>資料查詢_All</a>
                    </div>
                </li>
                @if (auth()->user()->user_level==9 or auth()->user()->user_level==5)
                <li class="nav-item dropdown">
                    <a class="nav-link font-weight-bold dropdown-toggle" href="#" id="navbarDropdownMenuLink" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">財務專用</a>
                    <div class="dropdown-menu" aria-labelledby="navbarDropdownMenuLink">
                        <a class="dropdown-item font-weight-bold" id='fsearch1' href={{ route('finance.fsearch1')}}>對帳單查詢</a>
                        <a class="dropdown-item font-weight-bold" id='fsearch2' href={{ route('finance.fsearch2')}}>結帳前&後檢查</a>
                        <a class="dropdown-item font-weight-bold" href={{ route('searchs.index')}}>資料查詢_All</a>
                    </div>
                </li>
                @endif
                <li class="nav-item">
                    <a class="nav-link font-weight-bold" href={{ route('AllUserExport')}}>資料匯入</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link font-weight-bold" href={{ route('auth.dbresult')}}>DB連線檢查</a>                    
                </li>
                @endauth
                <li class="nav-item">
                  <a class="nav-link font-weight-bold" href="#">Other</a>
                </li>
            </ul>
            <ul class="navbar-nav ml-auto">
                @guest
                <li class="nav-item">
                    <a class="nav-link font-weight-bold" href={{ route('login')}}>Login</a>
                </li>
                @endguest
                @auth
                <li class="nav-item">
                    <a class="nav-link font-weight-bold" >{{ auth()->user()->name }} 你好!</a>
                </li
                <li class="nav-item">
                    <a class="nav-link font-weight-bold" href="{{ route('logout') }}" onclick="event.preventDefault();
                      document.getElementById('logout-form').submit();"> Logout
                    </a>
                </li>
                    <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                    @csrf
                    </form>
                @if (auth()->user()->user_level==9)
                <li class="nav-item">
                    <a class="nav-link font-weight-bold" href={{ route('UsersProfile.UsersIndex')}}>使用者列表</a>
                </li>
                @endif
                @endauth
            </ul>
        </div>
</nav>
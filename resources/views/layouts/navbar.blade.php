<nav class="navbar navbar-expand-lg navbar-dark" style="background-color: #363636;">
    <a class="navbar-brand mb-0 h1" href={{ route('index') }}><img src="/images/Tensall-logo-mini.jpg" border="0"></a>
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNavDropdown" aria-controls="navbarNavDropdown" aria-expanded="false" aria-label="Toggle navigation">
    <span class="navbar-toggler-icon"></span>
    </button>
        <div class="collapse navbar-collapse" id="navbarNavDropdown">
            <ul class="navbar-nav mr-auto">
                <li class="nav-item">
                  <a class="nav-link font-weight-bold" style="font-size:16px" href={{ route('index') }}>Home</a>
                </li>
                @auth
                @if (auth()->user()->user_level==9)
                <li class="nav-item">
                  <a class="nav-link font-weight-bold" style="font-size:16px" href={{ route('posts.index') }}>公告系統</a>
                </li>
                @endif
                <li class="nav-item dropdown">
                    <a class="nav-link font-weight-bold dropdown-toggle" style="font-size:16px" href="#" id="navbarDropdownMenuLink" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">資料查詢</a>
                    <div class="dropdown-menu" aria-labelledby="navbarDropdownMenuLink">
                        <a class="dropdown-item font-weight-bold" style="font-size:16px" id='search1' href={{ route('searchs.search1')}}>銷退貨資訊查詢</a>
                        <a class="dropdown-item font-weight-bold" style="font-size:16px" id='search2' href={{ route('searchs.search2')}}>展場資料查詢</a>
                        <a class="dropdown-item font-weight-bold" style="font-size:16px" href={{ route('searchs.search3')}}>產線資料查詢</a>
                        <a class="dropdown-item font-weight-bold" style="font-size:16px" href={{ route('searchs.index')}}>其他資料查詢</a>
                    </div>
                </li>
                @if (auth()->user()->user_level==9 or auth()->user()->user_level==2)
                <li class="nav-item dropdown">
                    <a class="nav-link font-weight-bold dropdown-toggle" style="font-size:16px" href="#" id="navbarDropdownMenuLink" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">行銷業務</a>
                    <div class="dropdown-menu" aria-labelledby="navbarDropdownMenuLink">
                        <a class="dropdown-item font-weight-bold" style="font-size:16px" id='fsearch1' href={{ route('sales.ts6index')}}>TS6會員訂單資料分析查詢</a>
                        <a class="dropdown-item font-weight-bold" style="font-size:16px" id='fsearch2' href=#>其他資料</a>
                    </div>
                </li>
                @endif
                @if (auth()->user()->user_level==9 or auth()->user()->user_level==5)
                <li class="nav-item dropdown">
                    <a class="nav-link font-weight-bold dropdown-toggle" style="font-size:16px" href="#" id="navbarDropdownMenuLink" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">財務查詢</a>
                    <div class="dropdown-menu" aria-labelledby="navbarDropdownMenuLink">
                        <a class="dropdown-item font-weight-bold" style="font-size:16px" id='fsearch1' href={{ route('finance.fsearch1')}}>結帳&銷貨相關查詢</a>
                        <a class="dropdown-item font-weight-bold" style="font-size:16px" id='fsearch2' href={{ route('finance.fsearch2')}}>結帳前後資料檢查</a>
                    </div>
                </li>
                @endif
                @if (auth()->user()->user_level==9)
                <li class="nav-item">
                    <a class="nav-link font-weight-bold" style="font-size:16px" href={{ route('AllUserExport')}}>資料管理</a>
                </li>
                @endif
                @endauth
                <li class="nav-item dropdown">
                  <a class="nav-link font-weight-bold dropdown-toggle" style="font-size:16px" href="#" id="navbarDropdownMenuLink" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Other</a>
                    <div class="dropdown-menu" aria-labelledby="navbarDropdownMenuLink">
                            <a class="dropdown-item font-weight-bold" style="font-size:16px" id='osearch1' href="https://www.tensall.com.tw">Tensall官網</a>
                            <a class="dropdown-item font-weight-bold" style="font-size:16px" id='osearch2' href="https://www.ts6.com.tw">TS6官網</a>
                            <a class="dropdown-item font-weight-bold" style="font-size:16px" id='osearch3' href="#">Other</a>
                    </div>
                </li>
            </ul>
            <ul class="navbar-nav ml-auto">
                @guest
                <li class="nav-item">
                    <a class="nav-link font-weight-bold" style="font-size:16px" href={{ route('login')}}>Login</a>
                </li>
                @endguest
                @auth
                <li class="nav-item">
                <a class="nav-link font-weight-bold" style="font-size:16px" href="{{ route('UsersProfile.UsersEdit',auth()->user()->username) }}">{{ auth()->user()->name }} 你好!</a>
                </li
                <li class="nav-item">
                    <a class="nav-link font-weight-bold" style="font-size:16px" href="{{ route('logout') }}" onclick="event.preventDefault();
                      document.getElementById('logout-form').submit();"> Logout
                    </a>
                </li>
                    <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                    @csrf
                    </form>
                @if (auth()->user()->user_level==9)
                <li class="nav-item">
                    <a class="nav-link font-weight-bold" style="font-size:16px" href={{ route('UsersProfile.UsersIndex')}}>使用者列表</a>
                </li>
                @endif
                @endauth
            </ul>
        </div>
</nav>
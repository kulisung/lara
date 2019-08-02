<nav class="navbar navbar-expand-lg navbar-dark bg-primary">
    <a class="navbar-brand mb-0 h1" href={{ route('index') }}>Dashboard</a>
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
    <span class="navbar-toggler-icon"></span>
    </button>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav mr-auto">
                <li class="nav-item">
                  <a class="nav-link font-weight-bold" href={{ route('index') }}>Home <span class="sr-only">(current)</span></a>
                </li>
                <li class="nav-item">
                  <a class="nav-link font-weight-bold" href={{ route('posts.index') }}>簡易公告系統</a>
                </li>
                @auth
                <li class="nav-item">
                    <a class="nav-link font-weight-bold" href={{ route('searchs.index')}}>資料查詢</a>
                </li>
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
                <li class="nav-item">
                    <a class="nav-link font-weight-bold" href={{ route('register')}}>Register</a>
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
                @endauth
            </ul>
        </div>
</nav>
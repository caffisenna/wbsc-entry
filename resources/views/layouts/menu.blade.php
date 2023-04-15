{{-- 認証されてなければサイドメニューを表示しない --}}
@auth
    {{-- 一般ユーザー --}}
    @unless (Auth::user()->is_admin || Auth::user()->is_staff || Auth::user()->is_commi)
        <p class="uk-text-warning">参加申込</p>
        <li class="nav-item">
            <a href="{{ route('entryInfos.index') }}" class="nav-link {{ Request::is('entryInfos*') ? 'active' : '' }}">
                <p>申込情報</p>
            </a>
        </li>

        <p class="uk-text-warning">写真アップロード</p>
        <li class="nav-item">
            <a href="{{ route('face_upload.index') }}" class="nav-link {{ Request::is('face_upload*') ? 'active' : '' }}">
                <p>顔写真</p>
            </a>
        </li>
    @endunless

    {{-- 管理者 --}}
    @if (Auth::user()->is_admin)
        <h3 class="uk-text-warning">管理者メニュー</h3>
        <li class="nav-item">
            <a href="{{ url('/home') }}" class="nav-link {{ Request::is('admin_entryInfos*') ? 'active' : '' }}">
                <p>HOME</p>
            </a>
        </li>
        <li class="nav-item">
            <a href="{{ route('admin_entryInfos.index') }}"
                class="nav-link {{ Request::is('admin_entryInfos*') ? 'active' : '' }}">
                <p>申込一覧</p>
            </a>
        </li>
        <li class="nav-item">
            <a href="{{ route('admin_export') }}" class="nav-link {{ Request::is('admin_export*') ? 'active' : '' }}">
                <p>エクスポート(xlsx)</p>
            </a>
        </li>
        <h3 class="uk-text-warning">コース設定</h3>
        <li class="nav-item">
            <a href="{{ route('courseLists.index') }}"
               class="nav-link {{ Request::is('courseLists*') ? 'active' : '' }}">
                <p>スカウトコース</p>
            </a>
        </li>
        <li class="nav-item">
            <a href="{{ route('divisionLists.index') }}"
               class="nav-link {{ Request::is('divisionLists*') ? 'active' : '' }}">
                <p>課程別研修</p>
            </a>
        </li>


        <h3 class="uk-text-warning">事務局メニュー</h3>
        <li class="nav-item">
            <a href="{{ route('fee_check') }}" class="nav-link {{ Request::is('fee_check*') ? 'active' : '' }}">
                <p>参加費確認</p>
            </a>
        </li>
    @endif

    {{-- 地区コミ --}}
    @if (Auth::user()->is_commi)
        <h3 class="uk-text-warning">地区コミ</h3>
        <li class="nav-item">
            <a href="{{ route('commi_entryInfos.index') }}"
                class="nav-link {{ Request::is('commi_entryInfos*') ? 'active' : '' }}">
                <p>申込一覧</p>
            </a>
        </li>
    @endif

@endauth

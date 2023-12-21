{{-- 認証されてなければサイドメニューを表示しない --}}
@auth
    {{-- 一般ユーザー --}}
    @unless (Auth::user()->is_admin || Auth::user()->is_ais || Auth::user()->is_commi || Auth::user()->is_course_staff)
        <p class="uk-text-warning">参加申込</p>
        <li class="nav-item">
            <a href="{{ route('entryInfos.index') }}" class="nav-link {{ Request::is('entryInfos*') ? 'active' : '' }}">
                <p>申込情報</p>
            </a>
        </li>

        {{-- <p class="uk-text-warning">写真アップロード</p>
        <li class="nav-item">
            <a href="{{ route('face_upload.index') }}" class="nav-link {{ Request::is('face_upload*') ? 'active' : '' }}">
                <p>顔写真</p>
            </a>
        </li> --}}
    @endunless

    {{-- 管理者 --}}
    @if (Auth::user()->is_admin)
        <h3 class="uk-text-warning">管理者</h3>
        <li class="nav-item">
            <a href="{{ url('/home') }}" class="nav-link {{ Request::is('admin_entryInfos*') ? 'active' : '' }}">
                <p><span uk-icon="list"></span>コース・課程別一覧</p>
            </a>
        </li>
        <li class="nav-item">
            <a href="{{ route('admin_entryInfos.index') }}"
                class="nav-link {{ Request::is('admin_entryInfos*') ? 'active' : '' }}">
                <p><span uk-icon="table"></span>申込一覧</p>
            </a>
        </li>

        {{-- 地区AIS委員はエクスポートさせない --}}
        @unless (Auth::user()->is_ais)
            <li class="nav-item">
                <a href="{{ url('/admin/certificate') }}?list=all"
                    class="nav-link {{ Request::is('admin/certificate*') || str_contains(request()->fullUrl(), 'certificate=true') ? 'active' : '' }}">
                    <p><span uk-icon="bolt"></span>修了認定</p>
                </a>
            </li>

            <li class="nav-item">
                <a href="{{ route('admin_export') }}" class="nav-link {{ Request::is('admin_export*') ? 'active' : '' }}">
                    <p><span uk-icon="pull"></span>エクスポート(xlsx)</p>
                </a>
            </li>

            <li class="nav-item">
                <a href="{{ route('add_users.index') }}" class="nav-link {{ Request::is('addUsers*') ? 'active' : '' }}">
                    {{-- <i class="nav-icon fas fa-user"></i> --}}
                    <p><span uk-icon="users"></span>アカウント管理</p>
                </a>
            </li>

            <li class="nav-item">
                <a href="{{ route('email_not_verified') }}"
                    class="nav-link {{ Request::is('admin/email_not_verified*') ? 'active' : '' }}">
                    <p><span uk-icon="mail"></span>メール未認証</p>
                </a>
            </li>

            <li class="nav-item">
                <a href="{{ route('health_memo') }}" class="nav-link {{ Request::is('admin/health_memo*') ? 'active' : '' }}">
                    <p><span uk-icon="lifesaver"></span>健康情報入力者</p>
                </a>
            </li>


            <h3 class="uk-text-warning">コース設定</h3>
            <li class="nav-item">
                <a href="{{ route('courseLists.index') }}"
                    class="nav-link {{ Request::is('*courseLists*') ? 'active' : '' }}">
                    <p><span uk-icon="cog"></span>スカウトコース</p>
                </a>
            </li>
            <li class="nav-item">
                <a href="{{ route('divisionLists.index') }}"
                    class="nav-link {{ Request::is('*divisionLists*') ? 'active' : '' }}">
                    <p><span uk-icon="cog"></span>課程別研修</p>
                </a>
            </li>
            <li class="nav-item">
                <a href="{{ route('dankenLists.index') }}"
                    class="nav-link {{ Request::is('*dankenLists*') ? 'active' : '' }}">
                    <p><span uk-icon="cog"></span>団研</p>
                </a>
            </li>

            <h3 class="uk-text-warning">事務局</h3>
            <li class="nav-item">
                <a href="{{ route('fee_check', ['cat' => 'sc']) }}"
                    class="nav-link {{ request()->has('cat') && request()->query('cat') === 'sc' && str_contains(request()->url(), 'fee_check') ? 'active' : '' }}
                    ">
                    <p><span uk-icon="cart"></span>参加費確認(SC)</p>
                </a>
            </li>
            <li class="nav-item">
                <a href="{{ route('fee_check', ['cat' => 'div']) }}"
                    class="nav-link {{ request()->has('cat') && request()->query('cat') === 'div' && str_contains(request()->url(), 'fee_check') ? 'active' : '' }}
                    ">
                    <p><span uk-icon="cart"></span>参加費確認(課程別)</p>
                </a>
            </li>
            <li class="nav-item">
                <a href="{{ route('fee_check', ['cat' => 'danken']) }}"
                    class="nav-link {{ request()->has('cat') && request()->query('cat') === 'danken' && str_contains(request()->url(), 'fee_check') ? 'active' : '' }}
                    ">
                    <p><span uk-icon="cart"></span>参加費確認(団研)</p>
                </a>
            </li>
        @endunless
    @endif

    {{-- 地区コミ --}}
    @if (Auth::user()->is_commi && Auth::user()->is_admin == 0)
        <h3 class="uk-text-warning">地区コミ</h3>
        <li class="nav-item">
            <a href="{{ route('commi_entryInfos.index') }}"
                class="nav-link {{ Request::is('commi_entryInfos*') ? 'active' : '' }}">
                <p><span uk-icon="list"></span>申込一覧</p>
            </a>
        </li>
        <li class="nav-item">
            <a href="{{ url('/commi/priority') }}"
                class="nav-link {{ Request::is('/commi_entryInfos.priority') ? 'active' : '' }}">
                <p><span uk-icon="arrow-up"></span>優先順位</p>
            </a>
        </li>
        <li class="nav-item">
            <a href="{{ url('/howto_commi') }}" class="nav-link {{ Request::is('/howto_commi') ? 'active' : '' }}">
                <p><span uk-icon="file-text"></span>使い方ガイド</p>
            </a>
        </li>
    @endif

    @if (Auth::user()->is_course_staff)
        <h3 class="uk-text-warning">コーススタッフ</h3>
        <li class="nav-item">
            <a href="{{ route('course_staff.index') }}"
                class="nav-link {{ Request::is('course_staff*') ? 'active' : '' }}">
                <p><span uk-icon="list"></span>申込一覧</p>
            </a>
        </li>
        <li class="nav-item">
            <a href="{{ route('course_staff_export') }}"
                class="nav-link {{ Request::is('course_staff/export') ? 'active' : '' }}">
                <p><span uk-icon="download"></span>申込一覧DL</p>
            </a>
        </li>
    @endif
@else
    <h3 class="uk-text-warning">使い方ガイド</h3>
    <li class="nav-item">
        <a href="{{ url('/howto_gm') }}" class="nav-link {{ Request::is('/howto_gm') ? 'active' : '' }}" target="_blank">
            <p><span uk-icon="file-text"></span>団承認の仕方</p>
        </a>
    </li>
    <li class="nav-item">
        <a href="{{ url('/howto_trainer') }}" class="nav-link {{ Request::is('/howto_trainer') ? 'active' : '' }}"
            target="_blank">
            <p><span uk-icon="file-text"></span>トレーナー認定の仕方</p>
        </a>
    </li>
@endauth

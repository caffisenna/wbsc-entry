<!-- Name Field -->
<div class="form-group col-sm-6">
    {!! Form::label('name', '氏名:') !!}
    {!! Form::text('name', null, ['class' => 'form-control', 'required']) !!}
    @error('name')
        <div class="error text-danger">{{ $message }}</div>
    @enderror
</div>

<!-- Email Field -->
<div class="form-group col-sm-6">
    {!! Form::label('email', 'Email:') !!}
    {!! Form::text('email', null, ['class' => 'form-control', 'required']) !!}
    @error('email')
        <div class="error text-danger">{{ $message }}</div>
    @enderror
</div>

<!-- Role Field -->
<div class="form-group col-sm-6">
    {!! Form::label('role', 'アカウント種類', ['class' => 'form-role-label']) !!}
    {!! Form::select(
        'role',
        [
            '' => '',
            'admin' => '管理者',
            'AIS' => '地区AIS委員',
            'commi' => '地区コミ',
            'course_staff' => 'コーススタッフ',
            'participant' => '参加者',
        ],
        null,
        [
            'class' => 'form-control custom-select',
            'id' => 'role',
            'onChange' => 'toggleTextbox()',
        ],
    ) !!}
    @error('role')
        <div class="error text-danger">{{ $message }}</div>
    @enderror
</div>

<div id="textboxContainer" style="display:none;">
    <!-- District Field -->
    <div class="form-group col-sm-8">
        {!! Form::label('district', '地区:') !!}
        {!! Form::select(
            'district',
            [
                '' => '',
                '大都心' => '大都心',
                'さくら' => 'さくら',
                '城東' => '城東',
                '山手' => '山手',
                'つばさ' => 'つばさ',
                '世田谷' => '世田谷',
                'あすなろ' => 'あすなろ',
                '城北' => '城北',
                '練馬' => '練馬',
                '多摩西' => '多摩西',
                '新多磨' => '新多磨',
                '南武蔵野' => '南武蔵野',
                '町田' => '町田',
                '北多摩' => '北多摩',
            ],
            null,
            ['class' => 'form-control custom-select'],
        ) !!}
        @error('district')
            <div class="error text-danger">{{ $message }}</div>
        @enderror
    </div>
</div>

<div id="courseStaffContainer" style="display:none;">
    <!-- District Field -->
    <div class="form-group">
        {!! Form::label('course_staff', 'コーススタッフ:') !!}
        {!! Form::text('course_staff', null, ['class' => 'form-control']) !!}
        <h3>コーススタッフ入力例</h3>
        <ul>
            <li>スカウトコース: <span class="uk-text-success">SC29, SC30</span> (SC + 開催期数)</li>
            <li>課程別研修: <span class="uk-text-success">BVS14,CS14,BS14,VS14</span> (課程の略号 + 開催回数)</li>
            <li>団研: <span class="uk-text-success">団研</span></li>
        </ul>
        @error('course_staff')
            <div class="error text-danger">{{ $message }}</div>
        @enderror
    </div>
</div>

<!-- Password Field -->
@unless (isset($addUser->password))
    @php
        function generateRandomString($length = 8)
        {
            $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
            $randomString = '';

            for ($i = 0; $i < $length; $i++) {
                $randomString .= $characters[rand(0, strlen($characters) - 1)];
            }

            return $randomString;
        }
    @endphp
    <div class="form-group col-sm-6">
        {!! Form::label('password', 'パスワード:') !!}
        {!! Form::text('password', generateRandomString(8), ['class' => 'form-control', 'required']) !!}
        <span class="uk-text-small">↑削除して任意のパスワードを設定してもOK</span><br>
        <span class="uk-text-warning">ユーザーにパスワードを伝えること!</span>
        @error('password')
            <div class="error text-danger">{{ $message }}</div>
        @enderror
    </div>
@endunless

<script>
    function toggleTextbox() {
        var selectbox = document.getElementById("role");
        var textboxContainer = document.getElementById("textboxContainer");
        var courseStaffContainer = document.getElementById("courseStaffContainer");
        var selectedOption = selectbox.options[selectbox.selectedIndex].value;

        // 判定と表示の切り替え
        textboxContainer.style.display = (selectedOption === "AIS" || selectedOption === "commi"|| selectedOption === "participant") ? "block" : "none";
        courseStaffContainer.style.display = (selectedOption === "course_staff") ? "block" : "none";
    }
</script>

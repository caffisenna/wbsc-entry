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
    {!! Form::select('role', ['' => '', 'admin' => '管理者', 'AIS' => '地区AIS委員', 'commi' => '地区コミ'], null, [
        'class' => 'form-control custom-select',
        'id' => 'role',
        'onChange' => 'toggleTextbox()',
    ]) !!}
    @error('role')
        <div class="error text-danger">{{ $message }}</div>
    @enderror
</div>

<div id="textboxContainer" style="display:none;">
    <!-- District Field -->
    <div class="form-group col-sm-6">
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

<!-- Password Field -->
@unless (isset($addUser->password))
    <div class="form-group col-sm-6">
        {!! Form::label('password', 'パスワード:') !!}
        {!! Form::text('password', null, ['class' => 'form-control', 'required']) !!}
        @error('password')
            <div class="error text-danger">{{ $message }}</div>
        @enderror
    </div>
@endunless
<script>
    function toggleTextbox() {
        var selectbox = document.getElementById("role");
        var textboxContainer = document.getElementById("textboxContainer");
        var selectedOption = selectbox.options[selectbox.selectedIndex].value;

        if (selectedOption === "admin") {
            textboxContainer.style.display = "none";
        } else {
            textboxContainer.style.display = "block";
        }
    }
</script>

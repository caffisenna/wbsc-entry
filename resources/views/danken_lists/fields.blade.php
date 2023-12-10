<!-- Number Field -->
<div class="form-group col-sm-6">
    {!! Form::label('number', '回数:') !!}
    {{-- {!! Form::text('number', null, ['class' => 'form-control', 'required']) !!} --}}
    {!! Form::input('number', 'number', null, ['class' => 'form-control', 'required', 'step' => '1']) !!}

</div>

<!-- Director Field -->
<div class="form-group col-sm-6">
    {!! Form::label('director', '主任講師:') !!}
    {!! Form::text('director', null, ['class' => 'form-control', 'required']) !!}
</div>

<!-- Place Field -->
<div class="form-group col-sm-6">
    {!! Form::label('place', '場所:') !!}
    {!! Form::text('place', null, ['class' => 'form-control', 'required']) !!}
</div>

<!-- Day Start Field -->
<div class="form-group col-sm-6">
    {!! Form::label('day_start', '開始日:') !!}
    {!! Form::input('date', 'day_start', isset($dankenLists) ? ($dankenLists->day_start ? \Carbon\Carbon::parse($dankenLists->day_start)->format('Y-m-d') : null) : null, ['class' => 'form-control', 'required']) !!}
</div>

<!-- Day End Field -->
<div class="form-group col-sm-6">
    {!! Form::label('day_end', '終了日:') !!}
    {!! Form::input('date', 'day_end', isset($dankenLists) ? ($dankenLists->day_end ? \Carbon\Carbon::parse($dankenLists->day_end)->format('Y-m-d') : null) : null, ['class' => 'form-control', 'required']) !!}
</div>

<!-- Deadline Field -->
<div class="form-group col-sm-6">
    {!! Form::label('deadline', '申込締切:') !!}
    {!! Form::input('date', 'deadline', isset($dankenLists) ? ($dankenLists->deadline ? \Carbon\Carbon::parse($dankenLists->deadline)->format('Y-m-d') : null) : null, ['class' => 'form-control', 'required']) !!}
</div>




<!-- Drive url Field -->
<div class="form-group col-sm-6">
    {!! Form::label('drive_url', '共有URL:') !!}
    {!! Form::text('drive_url', null, ['class' => 'form-control']) !!}
</div>

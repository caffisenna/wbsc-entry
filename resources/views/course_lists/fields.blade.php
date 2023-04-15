<!-- Category Field -->
{{-- <div class="form-group col-sm-6">
    {!! Form::label('category', 'カテゴリー:') !!}
    {!! Form::select(
        'category',
        ['' => '', 'sc' => 'スカウトコース', 'BVS' => 'BVS', 'CS' => 'CS', 'BS' => 'BS', 'VS' => 'VS'],
        NULL,
        [
            'class' => 'form-control',
            'required',
        ],
    ) !!}
</div> --}}

<!-- Number Field -->
<div class="form-group col-sm-6">
    {!! Form::label('number', '期数:') !!}
    {!! Form::number('number', null, ['class' => 'form-control', 'required']) !!}
</div>

<!-- Director Field -->
<div class="form-group col-sm-6">
    {!! Form::label('director', '所長:') !!}
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
    {!! Form::date('day_start', isset($courseList->day_start) ? $courseList->day_start->format('Y-m-d') : null, [
        'class' => 'form-control',
        'required',
    ]) !!}
</div>

<!-- Day End Field -->
<div class="form-group col-sm-6">
    {!! Form::label('day_end', '終了日:') !!}
    {!! Form::date('day_end', isset($courseList->day_end) ? $courseList->day_end->format('Y-m-d') : null, [
        'class' => 'form-control',
        'required',
    ]) !!}
</div>

<!-- Guidance Date Field -->
<div class="form-group col-sm-6">
    {!! Form::label('guidance_date', '参加者説明会:') !!}
    {!! Form::date('guidance_date', isset($courseList->guidance_date) ? $courseList->guidance_date->format('Y-m-d') : null, [
        'class' => 'form-control',
        'required',
    ]) !!}
</div>

<!-- Deadline Field -->
<div class="form-group col-sm-6">
    {!! Form::label('deadline', '申込締切:') !!}
    {!! Form::date('deadline', isset($courseList->deadline) ? $courseList->deadline->format('Y-m-d') : null, [
        'class' => 'form-control',
        'required',
    ]) !!}
</div>


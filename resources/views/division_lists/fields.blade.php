{{-- 課程 --}}
<div class="form-group col-sm-6">
    {!! Form::label('division', '課程:') !!}
    {!! Form::select('division', ['' => '', 'BVS' => 'BVS', 'CS' => 'CS', 'BS' => 'BS', 'VS' => 'VS'], null, [
        'class' => 'form-control',
        'required',
    ]) !!}
</div>

<!-- Number Field -->
<div class="form-group col-sm-6">
    {!! Form::label('number', '回数:') !!}
    {!! Form::number('number', null, ['class' => 'form-control', 'required']) !!}
</div>

<!-- Director Field -->
<div class="form-group col-sm-6">
    {!! Form::label('director', '主任所員:') !!}
    {!! Form::text('director', null, ['class' => 'form-control', 'required']) !!}
</div>

<!-- Place Field -->
<div class="form-group col-sm-6">
    {!! Form::label('place', '開催場所:') !!}
    {!! Form::text('place', null, ['class' => 'form-control', 'required']) !!}
</div>

<!-- Day Start Field -->
<div class="form-group col-sm-6">
    {!! Form::label('day_start', '開催日:') !!}
    {!! Form::date(
        'day_start',
        isset($divisionList->day_start) ? $divisionList->day_start->format('Y-m-d') : null,
        ['class' => 'form-control', 'required'],
    ) !!}
</div>

<!-- Guidance Date Field -->
<div class="form-group col-sm-6">
    {!! Form::label('guidance_date', '説明会:') !!}
    {!! Form::date(
        'guidance_date',
        isset($divisionList->guidance_date) ? $divisionList->guidance_date->format('Y-m-d') : null,
        ['class' => 'form-control', 'required'],
    ) !!}
</div>

<!-- Deadline Field -->
<div class="form-group col-sm-6">
    {!! Form::label('deadline', '申込締切:') !!}
    {!! Form::date(
        'deadline',
        isset($divisionList->deadline) ? $divisionList->deadline->format('Y-m-d') : null,
        ['class' => 'form-control', 'required'],
    ) !!}
</div>

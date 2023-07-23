@extends('layouts.app')

@section('content')
    <section class="content-header">
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css"
            integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
        <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/v/dt/dt-1.10.12/datatables.min.css" />
        <link rel="stylesheet" type="text/css"
            href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" />
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-10">
                    <h1>地区内優先順位</h1>
                    <span class="uk-text-danger">行をドラッグして順位を入れ換えられます</span>
                </div>
                <div class="col-sm-6">
                </div>
            </div>
        </div>
    </section>

    <div class="content px-3">

        @include('flash::message')

        <div class="clearfix"></div>
        <div class="table-responsive">
            <table class="uk-table uk-table-divider uk-table-small" id="entryInfos-table">
                <thead>
                    <tr>
                        {{-- <th>優先順位</th> --}}
                        <th>順位</th>
                        <th>氏名</th>
                        <th>役務</th>
                        <th>参加</th>
                    </tr>
                </thead>
                {{-- {!! Form::open(['route' => 'priority_post']) !!} --}}
                <tbody id="tablecontents">
                    @foreach ($entryInfos as $entryInfo)
                        {{-- 申込情報がブランクなら無視 --}}
                        @if (isset($entryInfo->entry_info))
                            {{-- <tr class="row1"> --}}
                            {{-- <td class="pl-3"><i class="fa fa-sort"> --}}
                            {{-- <select name="priority-{{ $entryInfo->entry_info->id }}" class="form-control"
                                        id="priority-{{ $entryInfo->entry_info->id }}"
                                        onchange="updateSelectOptions('priority-{{ $entryInfo->entry_info->id }}')">
                                        <option value=""></option>
                                        @for ($key = 1; $key <= count($entryInfos); $key++)
                                            <option value="{{ $key }}"
                                                @if (old('entry_info') == $key) selected @endif>{{ $key }}
                                            </option>
                                        @endfor
                                    </select> --}}

                            {{-- </td> --}}
                            <tr class="row1" data-id="{{ $entryInfo->entry_info->id }}">
                                <td class="pl-3">
                                    <i class="fa fa-sort"></i>
                                    <span class="uk-hidden">{{ $entryInfo->entry_info->order }}</span>
                                </td>
                                <td><a
                                        href="{{ route('commi_entryInfos.show', [$entryInfo->id]) }}">{{ $entryInfo->name }}</a>
                                    @if ($entryInfo->entry_info->additional_comment)
                                        <span uk-icon="comment" class="uk-text-danger"></span>
                                    @endif
                                    <br>
                                    {{ $entryInfo->entry_info->dan }}
                                </td>
                                <td>{{ $entryInfo->entry_info->troop }} {{ $entryInfo->entry_info->troop_role }}</td>
                                <td>
                                    @unless ($entryInfo->entry_info->sc_number == 'done')
                                        {{ $entryInfo->entry_info->sc_number }}期<br>
                                    @else
                                        <span
                                            class="uk-text-warning">{{ $entryInfo->entry_info->sc_number_done }}期(済)</span><br>
                                    @endunless
                                    @unless ($entryInfo->entry_info->division_number == 'etc')
                                        {{ $entryInfo->entry_info->division_number }}回
                                    @else
                                        <span class="uk-text-warning">それ以外</span>
                                    @endunless
                                </td>
                            </tr>
                        @endif
                    @endforeach
                </tbody>
            </table>
        </div>
        <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
        <script src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.10.3/jquery-ui.min.js"></script>
        <script type="text/javascript" src="https://cdn.datatables.net/v/dt/dt-1.10.12/datatables.min.js"></script>

        <script type="text/javascript">
            $(function() {
                $("#entryInfos-table").DataTable();

                $("#tablecontents").sortable({
                    items: "tr",
                    cursor: 'move',
                    opacity: 0.6,
                    update: function() {
                        sendOrderToServer();
                    }
                });

                function sendOrderToServer() {
                    var order = [];
                    var token = $('meta[name="csrf-token"]').attr('content');
                    $('tr.row1').each(function(index, element) {
                        order.push({
                            id: $(this).attr('data-id'),
                            position: index + 1
                        });
                    });

                    $.ajax({
                        type: "POST",
                        dataType: "json",
                        url: "{{ url('/commi/priority_sortable') }}",
                        data: {
                            order: order,
                            _token: token
                        },
                        success: function(response) {
                            if (response.status == "success") {
                                console.log(response);
                            } else {
                                console.log(response);
                            }
                        }
                    });
                }
            });
        </script>
    @endsection

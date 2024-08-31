<link rel="stylesheet" href="{{ asset('css/dataTables.dataTables.min.css') }}">

<div class="table-responsive">
    <div class="uk-overflow-auto">
        <table class="uk-table uk-table-striped" id="entryInfos-table">
            <thead>
                <tr>
                    <th>氏名</th>
                    <th>写真</th>
                    <th>地区</th>
                    <th>団</th>
                    <th>SC/団研</th>
                    <th>課程別</th>
                    <th>参加認定</th>
                    <th>団委員長</th>
                    <th>トレーナー認定</th>
                    <th>地区コミ</th>
                    <th>委員会確認</th>
                    <th>操作</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($entryInfos as $entryInfo)
                    {{-- 申込情報がブランクなら無視 --}}
                    @if (isset($entryInfo))
                        @if ($entryInfo->cancel)
                            <tr class="uk-text-muted">
                            @else
                            <tr>
                        @endif
                        @if (isset($entryInfo->cancel) || isset($entryInfo->cancel_div))
                            <td bgcolor="#ccc" uk-tooltip="{{ $entryInfo->cancel }}<br>{{ $entryInfo->cancel_div }}">
                            @else
                            <td>
                        @endif
                        @if (isset($entryInfo->cancel) || isset($entryInfo->cancel_div))
                            <span class="uk-text-danger">[欠]</span>
                        @endif
                        <a href="{{ route('admin_entryInfos.show', [$entryInfo->uuid]) }}"
                            class='uk-link'>{{ $entryInfo->user->name }}
                            @if ($entryInfo->additional_comment)
                                <span uk-icon="commenting" class="uk-text-danger"></span>
                            @endif
                        </a>
                        <span class="uk-text-small"> {{ $entryInfo->bvs_exception == 'on' ? 'ビーバー特例' : '' }}</span>
                        </td>
                        <td>
                            @if ($entryInfo->user->face_picture)
                                <img src="{{ url('/storage/picture/') }}/{{ $entryInfo->user->face_picture }}"
                                    alt="" width="50px" height="">
                            @endif
                        </td>
                        <td>{{ $entryInfo->district }}</td>
                        <td>{{ $entryInfo->dan }}</td>
                        <td>
                            @unless ($entryInfo->bvs_exception == 'on')
                                @if ($entryInfo->danken)
                                    団研{{ $entryInfo->danken }}<br>
                                    @if ($entryInfo->assignment_danken)
                                        <span class=" uk-text-success">課題済</span>
                                    @else
                                        <span class=" uk-text-danger">未提出</span>
                                    @endif
                                @elseif ($entryInfo->sc_number !== 'done')
                                    {{ $entryInfo->sc_number }}期<br>
                                    @if ($entryInfo->assignment_sc)
                                        <span class=" uk-text-success">課題済</span>
                                    @else
                                        <span class=" uk-text-danger">未提出</span>
                                    @endif
                                @elseif($entryInfo->sc_number_done)
                                    <span class="uk-text-warning">{{ $entryInfo->sc_number_done }}<br>(修了済み)</span>
                                @endif
                            @else
                                <span class="uk-text-small">ビーバー特例</span>
                            @endunless
                        </td>
                        <td>
                            @unless ($entryInfo->danken)
                                @if ($entryInfo->division_number == 'etc')
                                    それ以外<br>
                                @else
                                    {{ $entryInfo->division_number }}回<br>
                                @endif
                                @if ($entryInfo->assignment_division)
                                    <span class=" uk-text-success">課題済</span>
                                @else
                                    <span class=" uk-text-danger">未提出</span>
                                @endif
                            @endunless
                        </td>
                        <td>
                            {{-- 参加認定 --}}
                            {!! $entryInfo->sc_accepted_at ? 'SC<span class="uk-text-success">〇</span><br>' : '' !!}
                            {!! $entryInfo->sc_rejected_at ? 'SC<span class="uk-text-danger">×</span><br>' : '' !!}
                            {!! $entryInfo->div_accepted_at ? '課程別<span class="uk-text-success">〇</span><br>' : '' !!}
                            {!! $entryInfo->div_rejected_at ? '課程別<span class="uk-text-danger">×</span><br>' : '' !!}
                            {!! $entryInfo->danken_accepted_at ? '団研<span class="uk-text-success">〇</span>' : '' !!}
                            {!! $entryInfo->danken_rejected_at ? '団研<span class="uk-text-danger">×</span>' : '' !!}
                        </td>
                        <td>
                            @if (isset($entryInfo->gm_checked_at))
                                {{ $entryInfo->gm_checked_at->format('m-d') }}
                            @else
                                <span class=" uk-text-danger">未</span>
                            @endif
                        </td>
                        <td>
                            {{ $entryInfo->danken ? '' : 'SC:' }}
                            @if (isset($entryInfo->trainer_sc_checked_at) || isset($entryInfo->trainer_danken_checked_at))
                                <span class=" uk-text-success">済</span>
                            @else
                                <span class=" uk-text-danger">未</span>
                            @endif
                            @unless ($entryInfo->danken)
                                <br>
                                課程別:@if (isset($entryInfo->trainer_division_checked_at))
                                    <span class=" uk-text-success">済</span>
                                @else
                                    <span class=" uk-text-danger">未</span>
                                @endif
                            @endunless
                        </td>
                        <td>
                            @if (isset($entryInfo->commi_checked_at))
                                {{ $entryInfo->commi_checked_at->format('m-d') }}
                            @else
                                <span class=" uk-text-danger">未</span>
                            @endif
                        </td>
                        <td>
                            @if (isset($entryInfo->ais_checked_at))
                                {{ $entryInfo->ais_checked_at->format('Y-m-d') }}
                            @else
                                <a href="{{ route('ais_check', ['id' => $entryInfo->uuid]) }}"
                                    class=" uk-button uk-button-primary uk-button-small"
                                    onclick="return confirm('{{ $entryInfo->name }}さん 地区AIS委員長として確認OKですか?')">確認</a>
                            @endif
                        </td>
                        <td>
                            {!! Form::open(['route' => ['admin_entryInfos.destroy', $entryInfo->id], 'method' => 'delete']) !!}
                            <div class='btn-group'>
                                <a href="{{ route('admin_pdf', ['id' => $entryInfo->uuid]) }}"
                                    class='uk-button uk-button-default uk-button-small'>
                                    <span uk-icon="download"></span>PDF
                                </a>
                                <a href="{{ route('admin_entryInfos.edit', [$entryInfo->uuid]) }}"
                                    class='btn btn-default'>
                                    <i class="far fa-edit"></i>
                                </a>
                                {!! Form::button('<i class="far fa-trash-alt"></i>', [
                                    'type' => 'submit',
                                    'class' => 'btn btn-danger',
                                    'onclick' => "return confirm('{$entryInfo->name}さんの情報を削除しますか?')",
                                ]) !!}
                            </div>
                            {!! Form::close() !!}
                        </td>
                        </tr>
                    @endif
                @endforeach
            </tbody>
        </table>
    </div>
</div>
<script src="{{ asset('js/dataTables.min.js') }}"></script>
<script>
    let table = new DataTable('#entryInfos-table');
</script>

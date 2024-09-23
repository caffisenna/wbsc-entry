<link rel="stylesheet" href="{{ asset('css/dataTables.dataTables.min.css') }}">

<div class="table-responsive">
    <div class="uk-overflow-auto">
        <table class="uk-table" id="entryInfos-table">
            <thead>
                <tr>
                    <th>氏名</th>
                    <th>地区</th>
                    <th>団</th>
                    <th>認定</th>
                    <th>非認定</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($entryInfos as $entryInfo)
                    {{-- 申込情報がブランクなら無視 --}}
                    @if (isset($entryInfo))
                        <tr>
                            @if (isset($_REQUEST['q']) || isset($_REQUEST['danken']))
                                <td
                                    @if ($entryInfo->cancel) bgcolor="#ccc" uk-tooltip="{{ $entryInfo->cancel }}" @endif>
                                    <a href="{{ route('admin_entryInfos.show', [$entryInfo->uuid]) }}" class='uk-link'>
                                        @if ($entryInfo->cancel)
                                            <span class="uk-text-danger">[欠]</span>
                                        @endif
                                        {{ $entryInfo->user->name }}
                                    </a>
                                </td>
                            @elseif(isset($_REQUEST['div']))
                                <td
                                    @if ($entryInfo->cancel_div) bgcolor="#ccc" uk-tooltip="{{ $entryInfo->cancel_div }}" @endif>
                                    <a href="{{ route('admin_entryInfos.show', [$entryInfo->uuid]) }}" class='uk-link'>
                                        @if ($entryInfo->cancel_div)
                                            <span class="uk-text-danger">[欠]</span>
                                        @endif
                                        {{ $entryInfo->user->name }}
                                    </a>
                                </td>
                            @endif

                            <td>{{ $entryInfo->district }}</td>
                            <td>{{ $entryInfo->dan }}</td>
                            {{-- 認定がpass、ngが入っていなければボタンを表示 --}}
                            @unless (
                                $entryInfo->certification_sc ||
                                    $entryInfo->certification_div ||
                                    $entryInfo->certification_danken)
                                <td>
                                    {{-- 地区AIS委員長はボタンを隠す --}}
                                    @if (Auth::user()->is_ais == null)
                                        <a href="{{ route('certificate', ['status' => 'pass', 'uuid' => $entryInfo->uuid, 'cat' => $request['cat']]) }}"
                                            class='uk-button uk-button-primary uk-button-small'
                                            onclick="return confirm('{{ $entryInfo->name }}さんを認定しますか?')">
                                            <span uk-icon="check"></span>認定
                                        </a>
                                    @endif
                                </td>
                                <td>
                                    {{-- 地区AIS委員長はボタンを隠す --}}
                                    @if (Auth::user()->is_ais == null)
                                        <a href="{{ route('certificate', ['status' => 'ng', 'uuid' => $entryInfo->uuid, 'cat' => $request['cat']]) }}"
                                            class='uk-button uk-button-danger uk-button-small'
                                            onclick="return confirm('{{ $entryInfo->name }}さんを否認しますか?')">
                                            <span uk-icon="close"></span>非認定
                                        </a>
                                    @endif
                                </td>
                            @else
                                {{-- 認定結果を表示 --}}
                                @if ($entryInfo->certification_sc == 'pass')
                                    <td><span class="uk-text-success">認定済み</span></td>
                                    <td></td>
                                @elseif ($entryInfo->certification_sc == 'ng')
                                    <td><span class="uk-text-danger">否認済み</span></td>
                                    <td></td>
                                @elseif ($entryInfo->certification_div == 'pass')
                                    <td><span class="uk-text-success">認定済み</span></td>
                                    <td></td>
                                @elseif ($entryInfo->certification_div == 'ng')
                                    <td><span class="uk-text-danger">否認済み</span></td>
                                    <td></td>
                                @elseif ($entryInfo->certification_danken == 'pass')
                                    <td><span class="uk-text-success">認定済み</span></td>
                                    <td></td>
                                @elseif ($entryInfo->certification_danken == 'ng')
                                    <td><span class="uk-text-danger">否認済み</span></td>
                                    <td></td>
                                @endif
                            @endunless
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

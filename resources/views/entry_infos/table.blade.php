<div class="table-responsive">
    <table class="uk-table uk-table-divider" id="entryInfos-table">
        <tr>
            <th>写真</th>
            <td>
                @if ($entryInfo->user->face_picture)
                    <img src="{{ url('/storage/picture/') }}{{ '/' . Auth::user()->face_picture }}" alt=""
                        width="100px">
                    <a href="#modal-delete-face" uk-toggle
                        class="uk-link uk-button uk-button-danger uk-button-small"><span uk-icon="trash"></span>削除</a>
                @else
                    <a href="{{ route('face_upload.index') }}" class="uk-button uk-button-primary">顔写真をアップロード</a>
                @endif
            </td>
        </tr>
        @if (isset($entryInfo->danken))
            <tr>
                <th>団委員研修所</th>
                <td>東京第{{ $entryInfo->danken }}期</td>
            </tr>
        @else
            @unless ($entryInfo->bvs_exception == 'on')
                <tr>
                    <th>スカウトコース期数</th>
                    <td>
                        @if ($entryInfo->sc_number && !$entryInfo->sc_number_done == 'done')
                            スカウトコース{{ $entryInfo->sc_number }}期
                        @elseif($entryInfo->sc_number_done)
                            スカウトコース{{ $entryInfo->sc_number_done }} (修了済み)
                        @endif
                    </td>
                </tr>
            @endunless
            <tr>
                <th>課程別回数</th>
                <td>
                    @if ($entryInfo->division_number == 'etc')
                        それ以外
                    @elseif ($entryInfo->division_number)
                        {{ $entryInfo->division_number }}回
                        {{ $entryInfo->bvs_exception == 'on' ? '(ビーバー特例)' : '' }}
                    @endif
                </td>
            </tr>
        @endif
        <tr>
            <th>健康調査</th>
            <td>
                @if ($healthInfo)
                    <span class="uk-text-default">入力済み</span> <a href="{{ route('health_info') }}">[確認]</a>
                @else
                    <a href="{{ route('health_info') }}" class="uk-button uk-button-primary uk-button-small"><span
                            uk-icon="file-text"></span>入力する</a>
                @endif
            </td>
        </tr>
        @unless ($entryInfo->bvs_exception == 'on')
            <tr>
                <th>
                    {{ $entryInfo->danken ? '課題提出' : 'スカウトコース課題' }}
                </th>
                <td>
                    @if (isset($entryInfo->danken))
                        @if ($entryInfo->assignment_danken == 'up')
                            <span class="uk-text-default">アップロード完了</span>
                            <a href="/storage/assignment/sc/{{ $entryInfo->uuid }}.pdf"
                                class="uk-button uk-button-primary uk-button-small"><span uk-icon="file-text"></span>確認</a>
                            @unless ($entryInfo->trainer_sc_name)
                                <a href="#modal-delete-assignment-sc" uk-toggle
                                    class="uk-link uk-button uk-button-danger uk-button-small"><span
                                        uk-icon="trash"></span>削除</a>
                            @else
                                <button class="uk-button uk-button-default uk-button-small" disabled
                                    uk-tooltip="トレーナー認定が完了した後は課題の削除ができません。"><span uk-icon="trash"></span>削除</button>
                            @endunless
                            <br>
                            @if ($entryInfo->trainer_danken_checked_at)
                                <span class="uk-text-success">トレーナー認定済み {{ $entryInfo->trainer_danken_name }}</span>
                            @else
                                <span class="uk-text-danger"><span uk-icon="comment"></span>トレーナー未認定(認定をお待ちください)</span>
                            @endif
                        @else
                            <a href="/user/upload/?uuid={{ $entryInfo->uuid }}&q=sc"
                                class="uk-button uk-button-primary uk-button-small uk-width-1-2"
                                uk-icon="icon: upload">団委員研修所の課題をアップロード</a>
                        @endif
                    @else
                        @if ($entryInfo->assignment_sc == 'up')
                            <span class="uk-text-default">アップロード完了</span>
                            <a href="/storage/assignment/sc/{{ $entryInfo->uuid }}.pdf"
                                class="uk-button uk-button-primary uk-button-small"><span uk-icon="file-text"></span>確認</a>
                            @unless ($entryInfo->trainer_sc_name)
                                <a href="#modal-delete-assignment-sc" uk-toggle
                                    class="uk-link uk-button uk-button-danger uk-button-small"><span
                                        uk-icon="trash"></span>削除</a>
                            @else
                                <button class="uk-button uk-button-default uk-button-small" disabled
                                    uk-tooltip="トレーナー認定が完了した後は課題の削除ができません。"><span uk-icon="trash"></span>削除</button>
                            @endunless
                            <br>
                            @if ($entryInfo->trainer_sc_checked_at)
                                <span class="uk-text-success">トレーナー認定済み {{ $entryInfo->trainer_sc_name }}</span>
                            @else
                                <span class="uk-text-danger"><span uk-icon="comment"></span>トレーナー未認定(認定をお待ちください)</span>
                            @endif
                        @else
                            <a href="/user/upload/?uuid={{ $entryInfo->uuid }}&q=sc"
                                class="uk-button uk-button-primary uk-button-small uk-width-1-2"
                                uk-icon="icon: upload">スカウトコースの課題をアップロード</a>
                        @endif
                    @endif
                </td>
            </tr>
        @endunless
        @unless (isset($entryInfo->danken))
            <tr>
                <th>課程別研修課題</th>
                <td>
                    @if ($entryInfo->assignment_division == 'up')
                        <span class="uk-text-default">アップロード完了</span>
                        <a href="/storage/assignment/division/{{ $entryInfo->uuid }}.pdf"
                            class="uk-button uk-button-primary uk-button-small"><span uk-icon="file-text"></span>確認</a>
                        @unless ($entryInfo->trainer_division_name)
                            <a href="#modal-delete-assignment-division" uk-toggle
                                class="uk-link uk-button uk-button-danger uk-button-small"><span uk-icon="trash"></span>削除</a>
                        @else
                            <button class="uk-button uk-button-default uk-button-small" disabled
                                uk-tooltip="トレーナー認定が完了した後は課題の削除ができません。"><span uk-icon="trash"></span>削除</button>
                        @endif
                        <br>
                        @if ($entryInfo->trainer_division_checked_at)
                            <span class="uk-text-success">トレーナー認定済み {{ $entryInfo->trainer_division_name }}</span>
                        @else
                            <span class="uk-text-danger"><span uk-icon="comment"></span>トレーナー未認定(認定をお待ちください)</span>
                        @endif
                    @else
                        <a href="/user/upload/?uuid={{ $entryInfo->uuid }}&q=division"
                            class="uk-button uk-button-primary uk-button-small uk-width-1-2"
                            uk-icon="icon: upload">課程別研修の課題をアップロード</a>
                        @endif
                    </td>
                </tr>
            @endunless
            <tr>
                <th>団承認</th>
                <td>
                    @if (isset($entryInfo->gm_checked_at))
                        {{ $entryInfo->gm_checked_at->format('Y-m-d') }}
                    @else
                        <span class="uk-text-danger"><span uk-icon="comment"></span>未承認(承認をお待ちください)</span>
                    @endif
                </td>
            </tr>
            <tr>
                <th>地区コミッショナー推薦</th>
                <td>
                    @if (isset($entryInfo->commi_checked_at))
                        {{ $entryInfo->commi_checked_at->format('Y-m-d') }}
                    @else
                        <span class="uk-text-danger"><span uk-icon="comment"></span>未承認(推薦をお待ちください)</span>
                    @endif
                </td>
            </tr>
            {{-- <tr>
            <th>地区AIS委員会確認</th>
            <td>
                @if (isset($entryInfo->ais_checked_at))
                    {{ $entryInfo->ais_checked_at->format('Y-m-d') }}<br>
                    <span class="uk-text-warning">地区AIS委員会の認定後はデータの修正はできません</span>
                @else
                    <span class="uk-text-danger"><span uk-icon="comment"></span>未認定(認定をお待ちください)</span>
                @endif
            </td>
        </tr> --}}
            @if ($entryInfo->danken)
                {{-- 団研の参加認定 --}}
                <tr>
                    <th>参加認定</th>
                    <td>
                        @if ($entryInfo->danken_accepted_at)
                            参加認定 {{ $entryInfo->danken_accepted_at }}
                        @elseif($entryInfo->danken_rejected_at)
                            <span class="uk-text-danger">参加否認</span> {{ $entryInfo->danken_rejected_at }}
                        @else
                            <span class="uk-text-danger"><span uk-icon="comment"></span>未認定(認定をお待ちください)</span>
                        @endif
                    </td>
                </tr>
            @else
                @unless ($entryInfo->bvs_exception == 'on')
                    <tr>
                        <th>参加認定(スカウトコース)</th>
                        <td>
                            @if ($entryInfo->sc_accepted_at)
                                参加認定 {{ $entryInfo->sc_accepted_at }}
                            @elseif($entryInfo->sc_rejected_at)
                                <span class="uk-text-danger">参加否認</span> {{ $entryInfo->sc_rejected_at }}
                            @else
                                <span class="uk-text-danger"><span uk-icon="comment"></span>未認定(認定をお待ちください)</span>
                            @endif
                        </td>
                    </tr>
                @endunless
            @endif

            @unless ($entryInfo->danken)
                <tr>
                    <th>参加認定(課程別研修)</th>
                    <td>
                        @if ($entryInfo->div_accepted_at)
                            参加認定 {{ $entryInfo->div_accepted_at }}
                        @elseif($entryInfo->div_rejected_at)
                            <span class="uk-text-danger">参加否認</span> {{ $entryInfo->div_rejected_at }}
                        @else
                            <span class="uk-text-danger"><span uk-icon="comment"></span>未認定(認定をお待ちください)</span>
                        @endif
                    </td>
                </tr>
            @endunless
            @if ($entryInfo->danken)
                <tr>
                    <th>団委員研修所参加費</th>
                    <td>
                        @if ($entryInfo->danken_fee_checked_at == null)
                            <span class="uk-text-danger"><span uk-icon="comment"></span>未確認(振込案内をお待ちください)</span>
                        @elseif($entryInfo->danken_fee_checked_at)
                            <span class="uk-text-success">納入済み</span>
                        @endif
                    </td>
                </tr>
            @else
                @unless ($entryInfo->sc_number == 'done')
                    <tr>
                        <th>スカウトコース参加費</th>
                        <td>
                            @if ($entryInfo->sc_fee_checked_at == null)
                                <span class="uk-text-danger"><span uk-icon="comment"></span>未確認(振込案内をお待ちください)</span>
                            @elseif($entryInfo->sc_fee_checked_at)
                                <span class="uk-text-success">納入済み</span>
                            @endif
                        </td>
                    </tr>
                @endunless
            @endif
            @unless ($entryInfo->danken)
                <tr>
                    <th>課程別研修参加費</th>
                    <td>
                        @if ($entryInfo->div_fee_checked_at == null)
                            <span class="uk-text-danger"><span uk-icon="comment"></span>未確認(振込案内をお待ちください)</span>
                        @elseif($entryInfo->div_fee_checked_at)
                            <span class="uk-text-success">納入済み</span>
                        @endif
                    </td>
                </tr>
            @endunless

            <tr>
                <th>操作</th>
                <td>
                    <div class='btn-group'>
                        <a href="{{ route('pdf') }}" class='btn btn-default'>
                            <span uk-icon="download"></span>PDFでダウンロード
                        </a>
                        <a href="{{ route('entryInfos.show', [$entryInfo->id]) }}"
                            class='uk-button uk-button-default uk-button-small'>
                            申込内容の確認
                        </a>
                        @unless (isset($entryInfo->gm_checked_at) ||
                                isset($entryInfo->trainer_sc_checked_at) ||
                                isset($entryInfo->trainer_division_checked_at) ||
                                isset($entryInfo->trainer_danken_checked_at))
                            <a href="{{ route('entryInfos.edit', [$entryInfo->id]) }}"
                                class='uk-button uk-button-default uk-button-small'>申込内容の修正</a>
                        @else
                            <button class="uk-button uk-button-default" disabled
                                uk-tooltip="団承認かトレーナー認定が完了した後はデータの修正ができません。"><span uk-icon="lock"></span>修正できません</button>
                        @endunless
                    </div>
                    {!! Form::close() !!}
                </td>
            </tr>
        </table>
    </div>
    <div id="modal-delete-face" uk-modal>
        <div class="uk-modal-dialog uk-modal-body">
            <h2 class="uk-modal-title uk-text-danger">顔写真の削除</h2>
            <p>顔写真を削除します。削除すると再アップロードが必要になりますので充分にご注意ください。</p>
            <p class="uk-text-right">
                <button class="uk-button uk-button-default uk-modal-close uk-width-1-1@m" type="button">キャンセル</button>
                <a class="uk-button uk-button-danger uk-width-1-1@m"
                    href="{{ route('delete_file', ['id' => $entryInfo->uuid, 'q' => 'face']) }}">削除する</a>
            </p>
        </div>
    </div>

    <div id="modal-delete-assignment-sc" uk-modal>
        <div class="uk-modal-dialog uk-modal-body">
            <h2 class="uk-modal-title uk-text-danger">課題の削除</h2>
            <p>アップロード済みの{{ $entryInfo->danken ? '団委員研修所' : 'スカウトコース' }}の課題を削除します。削除すると再アップロードが必要になりますので充分にご注意ください。</p>
            <p class="uk-text-right">
                <button class="uk-button uk-button-default uk-modal-close uk-width-1-1@m" type="button">キャンセル</button>
                <a class="uk-button uk-button-danger uk-width-1-1@m"
                    href="{{ route('delete_file', ['id' => $entryInfo->uuid, 'q' => 'sc']) }}">削除する</a>
            </p>
        </div>
    </div>

    <div id="modal-delete-assignment-division" uk-modal>
        <div class="uk-modal-dialog uk-modal-body">
            <h2 class="uk-modal-title uk-text-danger">課題の削除</h2>
            <p>アップロード済みの課程別研修の課題を削除します。削除すると再アップロードが必要になりますので充分にご注意ください。</p>
            <p class="uk-text-right">
                <button class="uk-button uk-button-default uk-modal-close uk-width-1-1@m" type="button">キャンセル</button>
                <a class="uk-button uk-button-danger uk-width-1-1@m"
                    href="{{ route('delete_file', ['id' => $entryInfo->uuid, 'q' => 'division']) }}">削除する</a>
            </p>
        </div>
    </div>

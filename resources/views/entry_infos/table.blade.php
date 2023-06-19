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
        <tr>
            <th>課程別回数</th>
            <td>
                @if ($entryInfo->division_number)
                    {{ $entryInfo->division_number }}回
                @endif
            </td>
        </tr>
        <tr>
            <th>スカウトコース課題</th>
            <td>
                @if ($entryInfo->assignment_sc == 'up')
                    <span class="uk-text-default">アップロード完了</span>
                    <a href="/storage/assignment/sc/{{ $entryInfo->uuid }}.pdf"
                        class="uk-button uk-button-primary uk-button-small"><span uk-icon="file-text"></span>確認</a>
                    <a href="#modal-delete-assignment-sc" uk-toggle
                        class="uk-link uk-button uk-button-danger uk-button-small"><span uk-icon="trash"></span>削除</a>
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
            </td>
        </tr>
        <tr>
            <th>課程別研修課題</th>
            <td>
                @if ($entryInfo->assignment_division == 'up')
                    <span class="uk-text-default">アップロード完了</span>
                    <a href="/storage/assignment/division/{{ $entryInfo->uuid }}.pdf"
                        class="uk-button uk-button-primary uk-button-small"><span uk-icon="file-text"></span>確認</a>
                    <a href="#modal-delete-assignment-division" uk-toggle
                        class="uk-link uk-button uk-button-danger uk-button-small"><span uk-icon="trash"></span>削除</a>
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
        <tr>
            <th>団の承認</th>
            <td>
                @if (isset($entryInfo->gm_checked_at))
                    {{ $entryInfo->gm_checked_at->format('Y-m-d') }}
                @else
                    <span class="uk-text-danger"><span uk-icon="comment"></span>未承認(承認をお待ちください)</span>
                @endif
            </td>
        </tr>
        <tr>
            <th>地区コミの承認</th>
            <td>
                @if (isset($entryInfo->commi_checked_at))
                    {{ $entryInfo->commi_checked_at->format('Y-m-d') }}
                @else
                    <span class="uk-text-danger"><span uk-icon="comment"></span>未承認(承認をお待ちください)</span>
                @endif
            </td>
        </tr>
        <tr>
            <th>地区AIS委員会の認定</th>
            <td>
                @if (isset($entryInfo->ais_checked_at))
                    {{ $entryInfo->ais_checked_at->format('Y-m-d') }}<br>
                    <span class="uk-text-warning">地区AIS委員会の認定後はデータの修正はできません</span>
                @else
                    <span class="uk-text-danger"><span uk-icon="comment"></span>未認定(認定をお待ちください)</span>
                @endif
            </td>
        </tr>
        <tr>
            <th>参加認定</th>
            <td>

            </td>
        </tr>
        @unless ($entryInfo->sc_number == 'done')
            <tr>
                <th>スカウトコース参加費</th>
                <td>
                    @if ($entryInfo->sc_fee_checked_at == null)
                        <span class="uk-text-warning">未確認(振込案内をお待ちください)</span>
                    @elseif($entryInfo->sc_fee_checked_at)
                        <span class="uk-text-success">納入済み</span>
                    @endif
                </td>
            </tr>
        @endunless
        <tr>
            <th>課程別研修参加費</th>
            <td>
                @if ($entryInfo->div_fee_checked_at == null)
                    <span class="uk-text-warning">未確認(振込案内をお待ちください)</span>
                @elseif($entryInfo->div_fee_checked_at)
                    <span class="uk-text-success">納入済み</span>
                @endif
            </td>
        </tr>
        <tr>
            <th>操作</th>
            <td>
                <div class='btn-group'>
                    <a href="{{ url('/user/pdf') }}" class='btn btn-default'>
                        <span uk-icon="download"></span>PDFでダウンロード
                    </a>
                    <a href="{{ route('entryInfos.show', [$entryInfo->id]) }}"
                        class='uk-button uk-button-default uk-button-small'>
                        <span uk-icon="eye"></span>申込内容の確認
                    </a>
                    @unless (isset($entryInfo->ais_checked_at))
                        <a href="{{ route('entryInfos.edit', [$entryInfo->id]) }}"
                            class='uk-button uk-button-default uk-button-small'><span
                                uk-icon="icon: file-edit"></span>申込内容の修正</a>
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
                href="{{ url('/') }}/user/delete_file/?id={{ Auth::user()->face_picture }}&q=face">削除する</a>
        </p>
    </div>
</div>

<div id="modal-delete-assignment-sc" uk-modal>
    <div class="uk-modal-dialog uk-modal-body">
        <h2 class="uk-modal-title uk-text-danger">課題の削除</h2>
        <p>アップロード済みのスカウトコースの課題を削除します。削除すると再アップロードが必要になりますので充分にご注意ください。</p>
        <p class="uk-text-right">
            <button class="uk-button uk-button-default uk-modal-close uk-width-1-1@m" type="button">キャンセル</button>
            <a class="uk-button uk-button-danger uk-width-1-1@m"
                href="{{ url('/') }}/user/delete_file/?id={{ $entryInfo->uuid }}&q=sc">削除する</a>
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
                href="{{ url('/') }}/user/delete_file/?id={{ $entryInfo->uuid }}&q=division">削除する</a>
        </p>
    </div>
</div>

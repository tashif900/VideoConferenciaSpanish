@extends('layouts.app')
@section('title', 'Sala')
@section('styles')
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/dropzone/5.5.1/min/dropzone.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">
    <style>
        .comment-active {
            background: rgba(241, 196, 15, .15);
        }
    </style>
@endsection
@section('content')
    <div class="row mt-4">
        <div class="col-12">
            <div class="card-white">
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-12 mt-4 mb-4">
                            <a href="javascript:history.back()"><span class="ti-arrow-left"></span> Regresar</a>
                        </div>
                        <div class="col-12">
                            <h4 class="title-blue text-left">{{ \Str::title($meeting->name) }}</h4>
                            <input type="hidden" id="meetingId" value="{{ $meeting->id }}">
                        </div>
                        <div class="col-12 col-md-7">
                            <div id="video"></div>
                        </div>
                        <div class="col-12 col-md-5">
                            <div class="form-group row">
                                <label for="staticEmail" class="col-sm-4 col-form-label">Sala</label>
                                <div class="col-sm-8">
                                    <input type="text" class="form-control" value="{{ $meeting->name }}" id="staticEmail">
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="staticEmail" class="col-sm-4 col-form-label">Instructor</label>
                                <div class="col-sm-8">
                                    <input type="text" class="form-control" id="staticEmail" value="{{ $meeting->user->name }}">
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="staticEmail" class="col-sm-4 col-form-label">Hora de inicio</label>
                                <div class="col-sm-8">
                                    <input type="text" class="form-control" id="staticEmail" value="{{ date('d-m-Y H:m', strtotime($meeting->hour_start)) }}">
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="staticEmail" class="col-sm-4 col-form-label">Código de la Sala</label>
                                <div class="col-sm-8">
                                    <input type="text" class="form-control" id="staticEmail" value="{{ $meeting->code }}">
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row mt-4">
                        <div class="col-12">
                            <ul class="nav nav-tabs" id="myTab" role="tablist">
                            <li class="nav-item" role="presentation">
                                <a class="nav-link active" id="description-tab" data-toggle="tab" href="#description" role="tab" aria-controls="description" aria-selected="true">Descripción</a>
                            </li>
                            <li class="nav-item" role="presentation">
                                <a class="nav-link" id="comments-tab" data-toggle="tab" href="#comments" role="tab" aria-controls="comments" aria-selected="false">Comentarios</a>
                            </li>
                            <li class="nav-item" role="presentation">
                                <a class="nav-link" id="resources-tab" data-toggle="tab" href="#resources" role="tab" aria-controls="resources" aria-selected="false">Recursos</a>
                            </li>
                            </ul>
                            <div class="tab-content" id="myTabContent">
                                <div class="tab-pane fade show active" id="description" role="tabpanel" aria-labelledby="description-tab">
                                    <div class="row mt-4">
                                        <div class="col">
                                            <label><strong>Descripción</strong></label>
                                            <p>{{ $meeting->description }}</p>
                                        </div>
                                    </div>
                                </div>
                                <div class="tab-pane fade" id="comments" role="tabpanel" aria-labelledby="comments-tab">
                                    <div class="row mt-4">
                                        <div class="col">
                                            <label><strong>Comentarios</strong></label>
                                            
                                            <form id="frm_comment">
                                                <textarea name="comment" id="comment" class="form-control" placeholder="Escribe tu Comentario"></textarea>
                                                <button class="btn btn-custom-blue btn-rounded float-right mt-2 mb-4" type="submit">Enviar</button>
                                            </form>
                                        </div>
                                    </div>
                                    <div class="row mb-4">
                                        <div class="col-12">
                                            <ul class="list-unstyled" id="comments">
                                                @foreach ($meeting->comments()->orderBy('created_at', 'desc')->get() as $comment)
                                                    <li class="media border-bottom p-3 {{ $comment->user_id == $meeting->user->id ? 'comment-active' : '' }}">
                                                        <img src="{{ $comment->user->photo }}" class="mr-3" width="64px" height="64px">
                                                        <div class="media-body">
                                                            <h5 class="mt-0 mb-1">{{ $comment->user->name }} <small class="text-muted">{{ \Carbon\Carbon::parse($comment->created_at)->diffForHumans() }}</small></h5>
                                                            {{ $comment->comment }}
                                                        </div>
                                                    </li>
                                                @endforeach
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                                <div class="tab-pane fade" id="resources" role="tabpanel" aria-labelledby="resources-tab">
                                    <div class="row mt-4">
                                        <div class="col-12">
                                            
                                        </div>
                                    </div>
                                    <div class="row my-4">
                                        <div class="col-12">
                                            <h4>Recursos de la Clase</h4>
                                        </div>
                                        <div class="col-12">
                                            <div class="list-group">
                                                <a href="#!" class="list-group-item list-group-item-action active">Recurso 1</a>
                                                <a href="#!" class="list-group-item list-group-item-action">Recurso 2</a>
                                                <a href="#!" class="list-group-item list-group-item-action">Recurso 3</a>
                                                <a href="#!" class="list-group-item list-group-item-action">Recurso 4</a>
                                                <a href="#!" class="list-group-item list-group-item-action disabled">Recurso 5</a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div> 
                    
                </div>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    <script src="https://meet.jit.si/external_api.js"></script>
    <script>
        const domain = '{{ $domain }}';
        const options = {
            configOverwrite: {
                channelLastN: '{{ $channelLastCam }}',
                startWithAudioMuted: true,
                startWithVideoMuted: true,
            },
            roomName: '{{ $roomName }}',
            jwt: '{{ $jwt }}',
            parentNode: document.querySelector('#video'),
            interfaceConfigOverwrite: {
                TOOLBAR_BUTTONS: {!! str_replace("'", "\'", json_encode($toolBar)) !!},
                SHOW_JITSI_WATERMARK: false,
            },
            width: '100%',
            height: 550,
        }
        var api = new JitsiMeetExternalAPI(domain, options);
        api.executeCommand('displayName', 'nombre');
        api.executeCommand('subject', '{{ $roomName }}}');
        api.on('readyToClose', () => {
            api.dispose();
            // location.href = '{{ url()->previous() }}';
        });
    </script>
    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>
    <script>
        $('#frm_comment').submit(function(e) {
            e.preventDefault();
            let data = $('#frm_comment').serialize();

            const token = localStorage.access_token;
            console.log(token);

            $.ajaxSetup({
                headers: {
                    'Authorization':  "Bearer " + token
                }
            });

            var url = '/api/store-comments';
            $.ajax({
                type: 'post',
                url: url,
                data: {meeting: $('#meetingId').val(), comment: $('#comment').val() },
                dataType: 'json',
                success: function (data) {
                    if (data == -9) {
                        toastr.warning('Ya hizo un comentario para esta clase', ":/");
                    } else {
                        toastr.success('Se agregó correctamente su comentario.', ":D");
                        $('#comment').val('');
                        $('#comments').load(' #comments');
                    }
                },
                error: function (data) {
                    console.log(data);
                }
            });
        });
    </script>
@endsection

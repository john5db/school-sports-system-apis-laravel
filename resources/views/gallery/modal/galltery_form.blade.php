<div class="modal fade" id="galleryModal" role="dialog">
    <div class="modal-dialog modal-md">

        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">

                <h4 class="modal-title form_title">Edit photo tags</h4>
            </div>
            <div class="modal-body">
                <div class="row">

                    <div class="col-md-6">
                        <div class="form-group-sm">
                            <div class="col-s-3">

                                    {!! Form::open(array('url'=>'gallery/', 'method'=>'POST', 'files'=>true)) !!}
                            </div>
                        </div>
                    </div>
                </div>
                <div class="form-group select_sport">
                    {!! Form::label('title', 'Sport:', ['class' => 'control-label']) !!}
                    {{ Form::select('sport_modal_id[]', $sports, null, ['class' => 'form-control', 'id' => 'sport_modal_id', 'style' => 'width: 100%', 'multiple', 'required'=> 'true']) }}
                    {!! Form::label('title[]', 'Level:', ['class' => 'control-label']) !!}
                    {{ Form::select('level_modal_id[]', $levelcreate, null, ['class' => 'form-control', 'id' => 'level_modal_id', 'style' => 'width: 100%', 'multiple']) }}

                    {!! Form::label('title', 'Player:', ['class' => 'control-label']) !!}
                    {{ Form::select('roster_modal_id[]', $rosters, null, ['class' => 'form-control','id' => 'roster_modal_id', 'style' => 'width: 100%', 'multiple']) }}
                    {!! Form::label('title', 'Game:', ['class' => 'control-label']) !!}
                    {{ Form::select('game_modal_id[]', $games, null, ['class' => 'form-control','id' => 'game_modal_id', 'style' => 'width: 100%', 'multiple']) }}
                    {{ Form::hidden('gallery_invisible_id', null, ['id' => 'gallery_invisible_id']) }}
                </div>
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group-sm">
                            <div class="col-s-3">
                                <br>

                                {!! Form::submit('Update photo tags', ['class' => 'submit_news_modal btn btn-primary']) !!}
                                &nbsp;
                                <button style="vertical-align: center;" type="button" class="btn btn-default"
                                        data-dismiss="modal">Close
                                </button>
                            </div>
                        </div>
                    </div>
                </div>


                {!! Form::close() !!}
            </div>
        </div>
    </div>
</div>
@extends('layouts.master')
@section('content')
<div class="container" style="width: 100% !important;">



        @include('partials.error-messages.success')
        @include('partials.error-messages.error')


        <div class="row">
          <div class="col-sm-8">
            <h3 style="text-align: center; margin-bottom: 50px;">Update Staff</h3>
            {!! Form::model($staff, ['method' => 'put', 'url' => 'staff/'.$staff->id, 'files' => true]) !!}
            @if($staff->photo)
                <img style="margin: 20px auto; display: block" src="{{asset('uploads/staff/'.$staff->photo)}}" alt="image" width="200px" height="200px">
            @else
                <img style="margin: 20px auto; display: block" src="{{asset('uploads/def.png')}}" height="200px" width="200px" alt="image">
            @endif
          </div>
            <div class="col-sm-8">
                <div class="row">
            <div class="col-md-6">
              <div class="form-group-sm">
                  <div class="col-s-3">
                {!!Form::label('name', 'Name:', ['class' => 'control-label']) !!}
                {!! Form::text('name', null, ['class' => 'form-control', 'required' =>true]) !!}
            </div>
              </div>
                </div>
            <div class="col-md-6">
              <div class="form-group-sm">
                  <div class="col-s-3">
                {!!Form::label('photo', 'Image:', ['class' => 'control-label']) !!}
                {!! Form::file('photo', ['class' => 'form-control']) !!}
            </div>
          </div>
        </div>
        </div>

        <div class="row">
            <div class="col-md-6">
              <div class="form-group-sm">
                  <div class="col-s-3">
                {!!Form::label('title', 'Title:', ['class' => 'control-label']) !!}
                {!! Form::text('title', null, ['class' => 'form-control']) !!}
            </div>
          </div>
        </div>
            <div class="col-md-6">
              <div class="form-group-sm">
                  <div class="col-s-3">
                {!!Form::label('email', 'Email:', ['class' => 'control-label']) !!}
                {!! Form::email('email', null, ['class' => 'form-control']) !!}
            </div>
        </div>
          </div>
</div>
        <div class="row">
            <div class="col-md-6">
              <div class="form-group-sm">
                  <div class="col-s-3">
                {!!Form::label('phone', 'Phone:', ['class' => 'control-label']) !!}
                {!! Form::text('phone', null, ['class' => 'form-control']) !!}
            </div>
                </div>
                    </div>
            <div class="col-md-6">
              <div class="form-group-sm">
                  <div class="col-s-3">
                {!!Form::label('website', 'Website:', ['class' => 'control-label']) !!}
                {!! Form::text('website', null, ['class' => 'form-control']) !!}
            </div>
                </div>
                    </div>
        </div>

        <div class="row">
            <div class="col-md-6">
              <div class="form-group-sm">
                  <div class="col-s-3">
                {!!Form::label('description', 'Description:', ['class' => 'control-label']) !!}
                {!! Form::textarea('description', null, ['class' => 'form-control']) !!}
            </div>
          </div>
      </div>
            <div class="col-md-6">
              <div class="form-group-sm">
                  <div class="col-s-3">
                {!! Form::label('year', 'Year', ['class' => 'control-label']) !!}
                {!! Form::selectYear('year', 2005, \Carbon\Carbon::now()->year, \Carbon\Carbon::now()->year, [
                'class' => 'form-control', 'required' => true]) !!}

                {!! Form::label('season_id', 'Season', ['class' => 'control-label']) !!}
                {!! Form::select('season_id', $seasons, null, ['class' => 'form-control', 'required' => true]) !!}
              </div>
          </div>
            </div>
        </div>

        <div class="row">
          <div class="col-md-6 col-md-offset-5" style="margin-top: 30px">
              <div class="form-group-sm">
                  <div class="col-s-3">
                {!! Form::submit('Update Staff', ['class' => 'btn btn-primary']) !!}
            </div>
          </div>
          </div>
        </div>
        </div>
</div>
    </div>
<br><br><br><br>

        {!! Form::close() !!}

@endsection
@section('footer')
    @include('partials.error-messages.footer-script')
@stop

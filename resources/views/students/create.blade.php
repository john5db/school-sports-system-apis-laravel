@extends('layouts.master')
@section('content')
    <div class="container-fluid" id="dynamics-form-outer">
        <h2 style="text-align: center">Add Student</h2>

        @include('partials.error-messages.success')
        @include('partials.error-messages.error')

        {!! Form::open(['url' => 'students/', 'files' =>true]) !!}

        <div class="row">
            <div class="col-md-6">
                {!! Form::label('title', 'Name:', ['class' => 'control-label']) !!}
                {!! Form::text('name', null, ['class' => 'fn form-control', 'required' => 'true']) !!}
            </div>
            <div class="col-md-6">
                {!! Form::label('academic_year', 'Academic Year:', ['class' => 'control-label']) !!}
                {!! Form::select('academic_year',
                        ['Freshman' => 'Freshman', 'Sohphomore' => 'Sohphomore',
                         'Junior' => 'Junior', 'Senior' => 'Senior'], 'Please Select'
                        ,['class' => 'form-control']) !!}
            </div>
        </div>

        <div class="row">
            <div class="col-md-6">
                {!! Form::label('title', 'Weight(pounds):', ['class' => 'control-label']) !!}
                {!! Form::selectRange('weight', 80, 220, 80, ['class' => 'form-control']) !!}
            </div>
            <div class="col-md-6">
                <div class="row">
                    <div class="col-md-6">
                        {!! Form::label('title', 'Height in Feet:', ['class' => 'control-label']) !!}
                        {!! Form::selectRange('height_feet', 4, 7, 4, ['class' => 'form-control']) !!}
                    </div>
                    <div class="col-md-6">
                        {!! Form::label('title', 'Height in Inches:', ['class' => 'control-label']) !!}
                        {!! Form::selectRange('height_inches', 0, 12, 0, ['class' => 'form-control']) !!}
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-md-6">
                {!! Form::label('pro_free', 'Pro/Free:', ['class' => 'control-label']) !!}
                {!! Form::select('pro_free', ['' => 'Please Select', '0' => 'Free', '1' => 'Pro'],'please select',
                 ['class' => 'fn form-control', 'id'=>'pro_free_', 'onchange' => 'return pro()', 'required' => true]) !!}
            </div>
            <div class="col-md-6">

            </div>
        </div>

        <div class="row">
            <div class="col-md-6">
                {!! Form::label('pro_head_photo', 'Pro Head Photo:', ['class' => 'control-label hide-pro']) !!}
                {!! Form::file('pro_head_photo', ['class' => 'fn form-control hide-pro']) !!}
            </div>
            <div class="col-md-6">
                {!! Form::label('pro_cover_photo', 'Pro Cover Photo:', ['class' => 'control-label hide-pro']) !!}
                {!! Form::file('pro_cover_photo', ['class' => 'fn form-control hide-pro']) !!}
            </div>
        </div>

        {{--show custom fields--}}
        <div class="row" style="margin: 20px 20px 20px 0px">
            <div class="col-md-12">
                <b>{{$school->name}} Custom Fields: </b>
                <button style="" type="button" id="add-field" class="btn btn-default">
                    Add Fields?</button>
            </div>
        </div>
        <div class="row" id="dynamic-fields-row">
            {{--will append the data on button click--}}
        </div>

        @if($customFields)
            @foreach($customFields as $customField)

                <div class="row" id="" style="">
                    <div class="col-md-6" id="">
                        <div class="row" style="margin-top: 10px">
                            <div class="col-md-6">
                                <input value="{{$customField->custom_label}}" readonly type="text" name="custom-field-name[]" class="form-control col-md-3">
                            </div>
                            <div class="col-md-6">
                                <input type="text" name="custom-field-value[]" class="form-control col-md-3" placeholder="Value">
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        @endif

        {{--add rosters to students--}}
        <div class="row" id="add-rosters-before">
            <div class="col-md-12">
                <h3 style="text-align: center">Add to Sports</h3>
                <div class="row">
                    <div class="col-md-4 col-md-offset-3">
                        {!! Form::select('rosters', $rosters, null, ['class' => 'form-control',
                        'id' => 'rosters_id']) !!}
                    </div>
                    <div class="col-md-4">
                        <button class="btn btn-default" id="add-rosters-btn">Add Roster?</button>
                    </div>
                </div>
            </div>
        </div>

        <div class="row" style="margin: 0 auto; width: 300px; padding: 10px">
            <div class="" style="margin-top: 20px; margin-left: 10px !important; float: left;">
                {!! Form::submit('Create Student', ['class' => 'btn btn-primary']) !!}
            </div>
        </div>

        {!! Form::close() !!}
    </div>
@endsection
@section('footer')
    @include('partials.error-messages.footer-script')
    @include('students.partials.footer')
    <script src="{{asset('js/students/students.js')}}"></script>
@endsection
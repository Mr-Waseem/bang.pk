<!-- User Information Section -->
<input type="hidden" id="status" name="status" value="user">
<div class="row">
    <!-- First Column -->
    <div class="col-md-6">
        <div class="form-group row">
            {!! Form::label('name', 'Name', ['class' => 'col-md-4 col-form-label']) !!}
            <div class="col-md-8">
                {!! Form::text('name', null, ['id' => 'name', 'class' => 'form-control']) !!}
            </div>
        </div>
        
        <div class="form-group row mt-3">
            {!! Form::label('email', 'Email', ['class' => 'col-md-4 col-form-label']) !!}
            <div class="col-md-8">
                {!! Form::text('email', null, ['id' => 'email', 'class' => 'form-control']) !!}
            </div>
        </div>
    </div>
    
    <!-- Second Column -->
    <div class="col-md-6">
        <div class="form-group row">
            {!! Form::label('password', 'Password', ['class' => 'col-md-4 col-form-label']) !!}
            <div class="col-md-8">
                <input type="password" id="password" class="form-control" name="password">
            </div>
        </div>
        
        <div class="form-group row mt-3">
            {!! Form::label('type', 'Status', ['class' => 'col-md-4 col-form-label']) !!}
            <div class="col-md-8">
                {!! Form::select('type', [
                    'ACTIVE' => 'ACTIVE', 
                    'INACTIVE' => 'INACTIVE'
                ], null, ['id' => 'type', 'class' => 'form-control']) !!}
            </div>
        </div>
    </div>
</div>

<!-- Submit Button -->
<div class="row mt-4">
    <div class="col-md-12 text-center">
        {!! Form::submit($submitbutton, ['class' => 'btn btn-primary px-4']) !!}
    </div>
</div>
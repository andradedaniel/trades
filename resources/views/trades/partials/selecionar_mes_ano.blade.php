<div class="form-group">
    <label for="sel1">Select list:</label>
{!! Form::open(array('url' => '/trades')) !!}
{{ Form::select('size', ['L' => 'Large', 'S' => 'Small'], 'S',['class'=>'form-control']) }}
{{ Form::submit('Salvar',array('class' => 'btn btn-primary')) }}
{!! Form::close() !!}
</div>
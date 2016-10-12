{{--<div class="form-group">--}}
    {{--<label for="mes" class="inline">Select list:</label>--}}
{!! Form::open(array('url' => '/trades?mes=')) !!}
{{--{{ Form::select('size', ['L' => 'Large', 'S' => 'Small'], 'S',['class'=>'form-control']) }}--}}
    <?php setlocale(LC_TIME,'pt_BR'); ?>
{{ Form::selectMonth('mes',$mes,['id'=>'mes','class'=>'form-control']) }}
{{--{{ Form::selectRange('ano',2016,2017,\Carbon\Carbon::now()->year,['class'=>'form-control']) }}--}}
{{--{{ Form::submit('Salvar',array('class' => 'btn btn-primary')) }}--}}
{!! Form::close() !!}
{{--</div>--}}

{{--TODO: https://silviomoreto.github.io/bootstrap-select/examples/--}}
<script>
    $(function() {
        // bind change event to select
        $('#mes').on('change', function() {
            var url = $(this).parent().attr('action') + $(this).val();
            if (url) { // require a URL
                window.location = url; // redirect
            }
            return false;
        });
    });
</script>

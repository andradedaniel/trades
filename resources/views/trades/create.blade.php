<div class="box">
    <div class="box-body with-border">
        {{--<div class="form-group col-sm-12">--}}
        <div class="col-sm-12">
            {!! Form::open(array('url' => '/trades')) !!}
                {{Form::hidden('ativo_id',$ativoId)}}
                <div class="col-sm-2">{{ Form::date('data', \Carbon\Carbon::now(),['class'=>'form-control']) }}</div>
                <div class="col-sm-2" style="padding-top: 6px">
                    <label class="radio-inline">{{ Form::radio('tipo', 'buy') }} <b>buy</b></label>
                    <label class="radio-inline">{{ Form::radio('tipo', 'sell') }} <b>sell</b></label>
                </div>
                <div class="col-sm-2">{{ Form::text('preco',null,['placeholder'=>'Preço','class'=>'form-control']) }}</div>
                <div class="col-sm-2">{{ Form::text('volume',null,['placeholder'=>'Volume','class'=>'form-control']) }}</div>
                <div class="col-sm-1 text-right">{{ Form::submit('Salvar',array('class' => 'btn btn-primary')) }}</div>
            {!! Form::close() !!}
        </div>
    </div>
</div>
<br>
{{--<script>--}}
    {{--$(function () {--}}
        {{--$('input').iCheck({--}}
            {{--checkboxClass: 'icheckbox_square-blue',--}}
            {{--radioClass: 'iradio_square-blue',--}}
{{--//            increaseArea: '20%' // optional--}}
        {{--});--}}
    {{--});--}}
{{--</script>--}}
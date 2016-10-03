{!! Form::open(array('url' => '/trades')) !!}
<div class="form-group">
    <div class="container spark-screen">
        <div class="row" style="margin-bottom: 5px;">
            <div class="col-md-10">
                <div class="col-sm-2">{{ Form::date('data', \Carbon\Carbon::now(),['class'=>'form-control']) }}</div>
                {{--<div class="col-sm-2">{{ Form::radio('tipo', 'buy') }} buy {{ Form::radio('tipo', 'sell') }} sell</div>--}}
                <div class="col-sm-2" style="padding-top: 6px">
                        <label class="radio-inline">{{ Form::radio('tipo', 'buy') }} <b>buy</b></label>
                        <label class="radio-inline">{{ Form::radio('tipo', 'sell') }} <b>sell</b></label>
                    </div>
                <div class="col-sm-2">{{ Form::text('preco',null,['placeholder'=>'Preço','class'=>'form-control']) }}</div>
                <div class="col-sm-2">{{ Form::text('volume',null,['placeholder'=>'Volume','class'=>'form-control']) }}</div>
                <div class="col-sm-1 text-right">{{ Form::submit('Salvar',array('class' => 'btn btn-primary')) }}</div>

            </div>
        </div>

    {{--<label for="exampleInputEmail1">Email address</label>--}}
    {{--<input type="email" class="form-control" id="exampleInputEmail1" placeholder="Enter email">--}}
    </div>

    {{--<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>--}}

</div>
{!! Form::close() !!}
<div id="addTradeFormModal" class="modal fade bs-example-modal-sm" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel">
    <div class="modal-dialog modal-sm" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="myModalLabel">Adicionar Trade</h4>
            </div>
            <div class="modal-body">
                {!! Form::open(array('url' => '/trades')) !!}
                <div class="form-group">
                    {{ Form::label('data', 'Data') }}
                    {{ Form::date('data', \Carbon\Carbon::now(),array('class'=>'form-control')) }}
                    {{--<label for="exampleInputEmail1">Email address</label>--}}
                    {{--<input type="email" class="form-control" id="exampleInputEmail1" placeholder="Enter email">--}}
                </div>



            </div>
            <div class="modal-footer">
                {{--<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>--}}
                {{ Form::submit('Salvar',array('class' => 'btn btn-primary')) }}
            </div>
            {!! Form::close() !!}
        </div>
    </div>
</div>
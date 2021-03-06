<!-- Left side column. contains the logo and sidebar -->
<aside class="main-sidebar">

    <!-- sidebar: style can be found in sidebar.less -->
    <section class="sidebar">

        <!-- Sidebar user panel (optional) -->
        {{--@if (! Auth::guest())--}}
            {{--<div class="user-panel">--}}
                {{--<div class="pull-left image">--}}
                    {{--<img src="{{asset('/img/user2-160x160.jpg')}}" class="img-circle" alt="User Image" />--}}
                {{--</div>--}}
                {{--<div class="pull-left info">--}}
                    {{--<p>{{ Auth::user()->name }}</p>--}}
                    {{--<!-- Status -->--}}
                    {{--<a href="#"><i class="fa fa-circle text-success"></i> {{ trans('adminlte_lang::message.online') }}</a>--}}
                {{--</div>--}}
            {{--</div>--}}
        {{--@endif--}}

        <!-- search form (Optional) -->
        {{--<form action="#" method="get" class="sidebar-form">--}}
            {{--<div class="input-group">--}}
                {{--<input type="text" name="q" class="form-control" placeholder="{{ trans('adminlte_lang::message.search') }}..."/>--}}
              {{--<span class="input-group-btn">--}}
                {{--<button type='submit' name='search' id='search-btn' class="btn btn-flat"><i class="fa fa-search"></i></button>--}}
              {{--</span>--}}
            {{--</div>--}}
        {{--</form>--}}
        <!-- /.search form -->

        <!-- Sidebar Menu -->
        <ul class="sidebar-menu">
            <li class="header">{{ trans('message.leftMenuHeader') }}</li>
            <!-- Optionally, you can add icons to the links -->
            <li class="active"><a href="{{ url('/') }}"><i class='fa fa-home'></i> <span>{{ trans('adminlte_lang::message.home') }}</span></a></li>
            <li><a href="{{ url('/trades') }}"><i class='fa fa-usd'></i> <span>{{ 'WINQ16' }}</span></a></li>

            {{--@foreach($carteiras as $carteira)--}}
                {{--<li><a href="#"><i class='fa fa-link'></i> <span>{{ $carteira->nome }}</span></a></li>--}}
                {{--<li class="treeview">--}}
                    {{--<a href="{{ url('/carteira/'.$carteira->id) }}"><i class='fa fa-link'></i> <span>{{ $carteira->nome }}</span> <i class="fa fa-angle-left pull-right"></i></a>--}}
                    {{--<ul class="treeview-menu">--}}
                        {{--@if ($carteira->ativos->isEmpty())--}}
                            {{--<li><a href="#">{{ 'Nenhum ativo cadastrado.' }}</a></li>--}}
                        {{--@endif--}}
                    {{--@foreach($carteira->ativos as $ativo)--}}
                        {{--<li><a href="{{ url('/ativo/'.$ativo->id) }}">{{ $ativo->codigo }}</a></li>--}}
                    {{--@endforeach--}}
                    {{--</ul>--}}
                {{--</li>--}}
            {{--@endforeach--}}
        </ul><!-- /.sidebar-menu -->
    </section>
    <!-- /.sidebar -->
</aside>

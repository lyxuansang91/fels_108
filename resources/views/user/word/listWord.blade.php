@extends('user.main')

@section('content')
    {{-- <section class="content"> --}}
    <div class="container">
        <div class="col-md-12">
        <div class="row">
            <div class="col-md-12">
                <div class="box">
                    <ol class="breadcrumb">
                        <li><a href="{!! route('user.index') !!}"><i class="fa fa-home"></i> Home</a></li>
                        <li class="active">Word's list</li>
                    </ol>
                    <div class="box-header">
                        <h3 class="box-title">List Word</h3>
                    </div><!-- /.box-header -->

                    {!! Form::open(['route'=>'user.words.store', 'class'=>'form-horizontal']) !!}
                    <div class="form-group">
                        <div class="input-group input-group-sm col-sm-3 pull-right">
                        {!! Form::text('search', '', ['class'=>'form-control', 'placeholder'=>'search word']) !!}
                            <span class="input-group-btn">
                                {!! Form::submit('search', ['class'=>'btn btn-default btn-flat', 'name'=>'submit', 'style'=>'margin-right: 30px;']) !!}
                            </span>
                        </div>
                    </div>
                        <div class="box-body">
                            @if(count($errors) > 0)
                            <div class="form-group">
                                <div class="alert alert-danger alert-dismissable col-sm-8">
                                    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                                    <h4><i class="icon fa fa-ban"></i> Alert!</h4>
                                    @foreach($errors->all() as $error)
                                        <li>{!! $error !!}</li>
                                    @endforeach
                                </div>
                            </div>
                            @endif
                            @if(session()->has('messages'))
                                <div class="alert alert-warning alert-dismissable">
                                    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                                    <h4><i class="icon fa fa-ban"></i> Alert!</h4>
                                    {!! session('messages') !!}
                                </div>
                            @endif
                            <div class="form-group">
                                <label for="inputEmail3" class="col-sm-2 control-label">Category</label>
                                <div class="col-sm-4">
                                    {!! Form::select('category_id', $categoryArray, isset($data['category_id']) ? $data['category_id'] : '', ['class'=>'form-control', 'onchange'=>"showDiv(this)"]) !!}
                                </div>
                                <div class="col-sm-1">
                                    {!! Form::submit('Filter', ['class' => 'btn btn-default']) !!}
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="inputEmail3" class="col-sm-2 control-label"></label>
                                <div class="col-sm-1 radio">
                                    @if(isset($data['status']) && $data['status'] == \App\Models\Word::LEARNED)
                                        <label>{!! Form::radio('status', \App\Models\Word::LEARNED, true) !!} Learned</label>
                                    @else
                                        <label>{!! Form::radio('status', \App\Models\Word::LEARNED) !!} Learned</label>
                                    @endif
                                </div>
                                <div class="col-sm-1 radio">
                                    @if(isset($data['status']) && $data['status'] == \App\Models\Word::NOT_LEARNED)
                                        <label>{!! Form::radio('status', \App\Models\Word::NOT_LEARNED, true) !!} Not learned</label>
                                    @else
                                        <label>{!! Form::radio('status', \App\Models\Word::NOT_LEARNED) !!} Not learned</label>
                                    @endif
                                </div>
                                <div class="col-sm-1 radio">
                                    @if(!$data || (isset($data['status']) && $data['status'] == \App\Models\Word::ALL_WORD))
                                        <label>{!! Form::radio('status', \App\Models\Word::ALL_WORD, true) !!} All</label>
                                    @else
                                        <label>{!! Form::radio('status', \App\Models\Word::ALL_WORD) !!} All</label>
                                    @endif
                                </div>
                            </div>
                            {!! $words->appends($data)->render() !!}
                        </div><!-- /.box-body -->
                        <div class="box-footer">
                        </div><!-- /.box-footer -->
                    {!! Form::close() !!}

                    <div class="box-body">
                        <table id="example1" class="table table-bordered table-striped">
                            @if($words->count() > 0)
                                <thead>
                                    <tr>
                                        <th>Japanese</th>
                                        <th>VietNamese</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($words as $word)
                                        <tr>
                                            <td>{{{ $word->word }}}</td>
                                            <td>{{{ $word->transWord->trans_word }}}</td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            @else
                                List Word is empty
                            @endif
                        </table>
                    </div><!-- /.box-body -->
                </div><!-- /.box -->
            </div><!-- /.col -->
        </div><!-- /.row -->
        </div>
    </div>
    {{-- </section>/.content --}}
    {!! HTML::script('/myJs/showWord.js') !!}
@stop
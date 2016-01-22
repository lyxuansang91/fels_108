@extends('main')

@section('content')
    <section class="content">
        <div class="row">
            <div class="col-xs-12">
                <div class="box">
                    <div class="box-header">
                        <h3 class="box-title">List Word</h3>
                    </div><!-- /.box-header -->

                    <div class="form-group">
                        <div class="input-group input-group-sm col-sm-2 pull-right">
                            <input type="text" class="form-control">
                            <span class="input-group-btn">
                                <button class="btn btn-default btn-flat" type="button" style="margin-right: 30px;">search</button>
                            </span>
                        </div>
                    </div>
                    {!! Form::open(['route'=>'admin.words.store', 'class'=>'form-horizontal']) !!}
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
                            @if(Session::has('messages'))
                                <div class="alert alert-warning alert-dismissable">
                                    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                                    <h4><i class="icon fa fa-ban"></i> Alert!</h4>
                                    {!! Session::get('messages') !!}
                                </div>
                            @endif
                            <div class="form-group">
                                <label for="inputEmail3" class="col-sm-2 control-label">Category</label>
                                <div class="col-sm-4">
                                    {!! Form::select('category_id', $cateArray, Session::get('categoryId'), ['class'=>'form-control', 'onchange'=>"showDiv(this)"]) !!}
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="inputEmail3" class="col-sm-2 control-label">Word</label>
                                <div class="col-xs-2">
                                    {!! Form::text('word', '', ['class'=>'form-control', 'placeholder'=>'Word']) !!}
                                </div>
                                <div class="col-xs-2">
                                    {!! Form::text('trans_word', '', ['class'=>'form-control', 'placeholder'=>'Translate word']) !!}
                                </div>
                            </div>

                        </div><!-- /.box-body -->
                        <div class="box-footer">
                            {!! Form::submit('Add word', ['class'=>'btn btn-primary']) !!}
                        </div><!-- /.box-footer -->
                    {!! Form::close() !!}

                    <div class="box-body">
                        <table id="example1" class="table table-bordered table-striped">
                            @if(count($words) > 0)
                                <thead>
                                    <tr>
                                        <th>Japanese</th>
                                        <th>VietNamese</th>
                                        <th>Edit</th>
                                        <th>Delete</th>
                                    </tr>
                                </thead>
                                @if(Session::has('categoryId'))
                                    @foreach($cateArray as $key => $category)
                                        @if($key == Session::get('categoryId'))
                                            <tbody id="category{!! $key !!}" class="category">
                                        @else
                                            <tbody id="category{!! $key !!}" style="display:none" class="category">
                                        @endif
                                        @foreach($words as $word)
                                            @if($word->category_id == $key)
                                                <tr>
                                                    <td>{{{ $word->word }}}</td>
                                                    <td>{{{ $word->trans_word->trans_word }}}</td>
                                                    <td><a href="{!! route('admin.words.edit', $word->id) !!}" class="btn btn-primary">Edit</a></td>
                                                    {!! Form::open(['route' => ['admin.words.destroy', $word->id], 'method' => 'delete']) !!}
                                                    <td>{!! Form::submit('Delete', ['class'=>'btn btn-danger', 'onclick'=>"return confirm('Are you sure you want to delete this item?')"]) !!}</td>
                                                    {!! Form::close() !!}
                                                </tr>
                                            @endif
                                        @endforeach
                                        </tbody>
                                    @endforeach
                                @else
                                    @foreach($cateArray as $key => $category)
                                        @if($key == array_keys($cateArray)[0])
                                            <tbody id="category{!! $key !!}" class="category">
                                        @else
                                            <tbody id="category{!! $key !!}" style="display:none" class="category">
                                        @endif
                                        @foreach($words as $word)
                                            @if($word->category_id == $key)
                                                <tr>
                                                    <td>{{{ $word->word }}}</td>
                                                    <td>{{{ $word->trans_word->trans_word }}}</td>
                                                    <td><a href="{!! route('admin.words.edit', $word->id) !!}" class="btn btn-primary">Edit</a></td>
                                                    {!! Form::open(['route' => ['admin.words.destroy', $word->id], 'method' => 'delete']) !!}
                                                    <td>{!! Form::submit('Delete', ['class'=>'btn btn-danger', 'onclick'=>"return confirm('Are you sure you want to delete this item?')"]) !!}</td>
                                                    {!! Form::close() !!}
                                                </tr>
                                            @endif
                                        @endforeach
                                        </tbody>
                                    @endforeach
                                @endif
                            @else
                                List Word is empty
                            @endif
                        </table>
                    </div><!-- /.box-body -->
                </div><!-- /.box -->
            </div><!-- /.col -->
        </div><!-- /.row -->
    </section><!-- /.content -->
<script type="text/javascript">
    function showDiv(e){
        var strdisplay = e.options[e.selectedIndex].value;
        console.log(strdisplay);
        var x = document.getElementsByClassName("category");
        for(i = 0; i < x.length; i++) {
            x[i].style.display = "none";
        }
        document.getElementById('category' + strdisplay).style.display = "table-row-group";
}
</script>
@stop
@extends('layouts.master')

@section('title')
    <div class="blog-post">
        <h3>List of Account Category</h3>
    </div>
@endsection

@section('button')
    <button type="button" class="btn btn-outline-primary" aria-label="Left Align"
            data-toggle="modal" data-target="#exampleModal" onclick="add();">
        <i class="fas fa-plus-circle fa-1x"></i> Add new
    </button>
@endsection

<style>
    .tr-class td {
        vertical-align: top;
        padding: 15px;
    }

    .tr-header th {
        color: white;
        background: #343a40;
        padding-left: 15px;
        padding-right: 15px;
        padding-bottom: 20px;
        padding-top: 20px;
    }
</style>

@section('content')
    <div>
        <table width="100%" style="font-size: 90%">
            <thead>
            <tr class="tr-header card-header">
                <th width="5%">#</th>
                <th width="30%">Category Description</th>
                <th width="23%">Status</th>
                <th width="25%">Logs</th>
                <th width="17%">Actions</th>
            </tr>
            </thead>

            <tbody>
            @php($ctr = 1)
            @foreach($account_categories as $account_category)
                <tr class="tr-class">
                    <td>{{ $ctr++ }})</td>
                    <td>{{ $account_category->description }}</td>
                    <td>
                        @if($account_category->disabled == 'N')
                            <span style="color: dodgerblue">Enabled</span>
                        @else
                            <span style="color: red">Disabled</span><br><br>
                            {{ $account_category->disabled_by }}<br>
                            <i class="far fa-clock"></i>&nbsp;
                            {{--<span style="color: blue">{{ $account_category->date_disabled->diffForHumans() }}</span>--}}
                        @endif
                    </td>

                    <td>{{ $account_category->logs }}<br>
                        <i class="far fa-clock"></i>&nbsp;
                        {{--<span style="color: dodgerblue">{{ $account_category->created_at->diffForHumans() }}</span><br><br>--}}
                        {{ $account_category->last_modified }}<br>

                        @if($account_category->last_modified != '')
                            <i class="far fa-clock"></i>&nbsp;
                            <span style="color: dodgerblue">
                            {{--{{ $account_category->updated_at->diffForHumans() }}--}}
                            </span>
                        @endif
                    </td>

                    <td>
                        <div class="form-inline">
                            <form method="POST"
                                  action="{{ url('/financial/account_category', $account_category->id) }}">
                                {{ method_field('DELETE') }}
                                {{ csrf_field() }}

                                <button type="button" class="btn btn-outline-dark" aria-label="Left Align"
                                        onclick="edit({{ $account_category }});">
                                    <i class="fas fa-edit"></i>
                                </button>

                                <button type="submit" class="btn btn-outline-danger" aria-label="Left Align">
                                    <i class="fas fa-trash-alt"></i>
                                </button>

                                <hr>
                                <a href="{{ url('/financial/account_category/update_status', $account_category->id) }}">
                                    {{ $account_category->disabled == 'N' ? 'Disable' : 'Enable' }}</a>
                            </form>
                        </div>
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>
    </div>
@endsection

@section('modal_title')
    Add New Account Category
@endsection

@section('modal_body')
    <form id="form" name="form" method="POST" action="{{ url('/financial/account_category') }}">
        <input type="hidden" name="_method" id="_method" value="POST">
        {{ csrf_field() }}

        <input type="hidden" id="id" name="id"/>

        <div class="form-group">
            <label for="exampleInputEmail1">Category Description</label>
            <input type="text" class="form-control" id="description" name="description" required>
        </div>

        <div class="form-group mt-5">
            <button type="submit" class="btn btn-primary px-3">Save</button>
            <button type="button" class="btn btn-secondary px-3 mx-2" data-dismiss="modal">Close</button>
        </div>

        @include('layouts.errors')
    </form>
@endsection

<script type="text/javascript">
    function add() {
        $('#form').trigger("reset");
        $('#form').attr('action', '/financial/account_category');
        $('#_method').val('POST');
    }

    function edit(account_category) {
        $('#exampleModalLabel').text('Edit Account Category');
        $('#exampleModal').modal('show');
        $('#form').attr('action', '/financial/account_category/' + account_category.id);
        $('#_method').val('PUT');
        $('#id').val(account_category.id);
        $('#description').val(account_category.description);
    }
</script>
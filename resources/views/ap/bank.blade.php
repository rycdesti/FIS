@extends('layouts.master')

@section('title')
    <div class="blog-post">
        <h3>List of Banks</h3>
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
                <th width="25%">Bank Name</th>
                <th width="15%">Bank Code</th>
                <th width="18%">Status</th>
                <th width="20%">Logs</th>
                <th width="17%">Actions</th>
            </tr>
            </thead>

            <tbody>
            @php($ctr = 1)
            @foreach($banks as $bank)
                <tr class="tr-class">
                    <td>{{ $ctr++ }})</td>
                    <td>{{ $bank->bank_name }}</td>
                    <td>{{ $bank->bank_code }}</td>
                    <td>
                        @if($bank->disabled == 'N')
                            <span style="color: dodgerblue">Enabled</span>
                        @else
                            <span style="color: red">Disabled</span><br><br>
                            {{ $bank->disabled_by }}<br>
                            <i class="far fa-clock"></i>&nbsp;
                            <span style="color: blue">{{ $bank->date_disabled->diffForHumans() }}</span>
                        @endif
                    </td>

                    <td>{{ $bank->logs }}<br>
                        <i class="far fa-clock"></i>&nbsp;
                        <span style="color: dodgerblue">{{ $bank->created_at->diffForHumans() }}</span><br><br>
                        {{ $bank->last_modified }}<br>

                        @if($bank->last_modified != '')
                            <i class="far fa-clock"></i>&nbsp;
                            <span style="color: dodgerblue">
                            {{ $bank->updated_at->diffForHumans() }}
                            </span>
                        @endif
                    </td>

                    <td>
                        <div class="form-inline">
                            <form method="POST"
                                  action="{{ url('/ap/bank', $bank->id) }}">
                                {{ method_field('DELETE') }}
                                {{ csrf_field() }}

                                <button type="button" class="btn btn-outline-dark" aria-label="Left Align"
                                        onclick="edit({{ $bank }});">
                                    <i class="fas fa-edit"></i>
                                </button>

                                <button type="submit" class="btn btn-outline-danger" aria-label="Left Align">
                                    <i class="fas fa-trash-alt"></i>
                                </button>

                                <hr>
                                <a href="{{ url('/ap/bank_account', $bank->id) }}">
                                    Manage Bank Accounts</a><br>
                                <a href="{{ url('/ap/bank/update_status', $bank->id) }}">
                                    {{ $bank->disabled == 'N' ? 'Disable' : 'Enable' }}</a>
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
    Add New Bank
@endsection

@section('modal_body')
    <form id="form" name="form" method="POST" action="{{ url('/ap/bank') }}">
        <input type="hidden" name="_method" id="_method" value="POST">
        {{ csrf_field() }}

        <input type="hidden" id="id" name="id"/>

        <div class="form-group">
            <label for="exampleInputEmail1">Bank Name</label>
            <input type="text" class="form-control" id="bank_name" name="bank_name" required>
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
        $('#form').attr('action', '/ap/bank');
        $('#_method').val('POST');
    }

    function edit(bank) {
        $('#exampleModalLabel').text('Edit Bank');
        $('#exampleModal').modal('show');
        $('#form').attr('action', '/ap/bank/' + bank.id);
        $('#_method').val('PUT');
        $('#id').val(bank.id);
        $('#bank_name').val(bank.bank_name);
    }
</script>
@extends('layouts.master')

@section('title')
    <div class="blog-post">
        <h3>List of Chart of Accounts</h3>
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
                <th width="30%">Account Code</th>
                <th width="28%">Information</th>
                <th width="20%">Logs</th>
                <th width="17%">Actions</th>
            </tr>
            </thead>

            <tbody>
            @php($ctr = 1)
            @foreach($chart_accounts as $chart_account)
                <tr class="tr-class">
                    <td>{{ $ctr++ }})</td>
                    <td>{{ $chart_account->acct_code }}</td>
                    <td>Description: <b>{{ $chart_account->description }}</b><br>
                        Category:
                        <b>{{ $account_categories->toArray()[array_search($chart_account->category_id, array_column($account_categories->toArray(), 'id'))]['description'] }}</b><br>
                        Posting Type: <b>{{ $posting_types[$chart_account->posting_type] }}</b><br>
                        Typical Balance: <b>{{ $typical_balances[$chart_account->typical_balance] }}</b><br>
                        Status:
                        @if($chart_account->disabled == 'N')
                            <span style="color: dodgerblue">Enabled</span>
                        @else
                            <span style="color: red">Disabled</span><br><br>
                            {{ $chart_account->disabled_by }}<br>
                            <i class="far fa-clock"></i>&nbsp;
                            <span style="color: blue">{{ $chart_account->date_disabled->diffForHumans() }}</span>
                        @endif
                    </td>

                    <td>{{ $chart_account->logs }}<br>
                        <i class="far fa-clock"></i>&nbsp;
                        <span style="color: dodgerblue">{{ $chart_account->created_at->diffForHumans() }}</span><br><br>
                        {{ $chart_account->last_modified }}<br>

                        @if($chart_account->last_modified != '')
                            <i class="far fa-clock"></i>&nbsp;
                            <span style="color: dodgerblue">
                            {{ $chart_account->updated_at->diffForHumans() }}
                            </span>
                        @endif
                    </td>

                    <td>
                        <div class="form-inline">
                            <form method="POST"
                                  action="{{ url('/financial/chart_account', $chart_account->id) }}">
                                {{ method_field('DELETE') }}
                                {{ csrf_field() }}

                                <button type="button" class="btn btn-outline-dark" aria-label="Left Align"
                                        onclick="edit({{ $chart_account }});">
                                    <i class="fas fa-edit"></i>
                                </button>

                                <button type="submit" class="btn btn-outline-danger" aria-label="Left Align">
                                    <i class="fas fa-trash-alt"></i>
                                </button>

                                <hr>
                                <a href="{{ url('/financial/chart_account/update_status', $chart_account->id) }}">
                                    {{ $chart_account->disabled == 'N' ? 'Disable' : 'Enable' }}</a>
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
    Add New Chart of Accounts
@endsection

@section('modal_body')
    <form id="form" name="form" method="POST" action="{{ url('/financial/chart_account') }}">
        <input type="hidden" name="_method" id="_method" value="POST">
        {{ csrf_field() }}

        <input type="hidden" id="id" name="id"/>

        <div class="form-group">
            <div class="mb-3">
                <label for="exampleInputEmail1">Account Code</label>
                <input type="text" class="form-control" id="acct_code" name="acct_code" required>
            </div>

            <div class="mb-3">
                <label for="exampleInputEmail1">Description</label>
                <input type="text" class="form-control" id="description" name="description" required>
            </div>

            <div class="mb-3">
                <label for="exampleInputEmail1">Account Category</label>
                <select class="form-control" id="category_id" name="category_id" required>
                    <option value=""></option>
                    @foreach($account_categories as $account_category)
                        <option value="{{ $account_category->id }}">{{ $account_category->description }}</option>
                    @endforeach
                </select>
            </div>

            <div class="mb-3">
                <label for="exampleInputEmail1">Posting Type</label>
                <select class="form-control" id="posting_type" name="posting_type" required>
                    <option value=""></option>
                    @foreach($posting_types as $posting_type => $value)
                        <option value="{{ $posting_type }}">{{ $value }}</option>
                    @endforeach
                </select>
            </div>

            <div class="mb-3">
                <label for="exampleInputEmail1">Typical Balance</label>
                <select class="form-control" id="typical_balance" name="typical_balance" required>
                    <option value=""></option>
                    @foreach($typical_balances as $typical_balance => $value)
                        <option value="{{ $typical_balance }}">{{ $value }}</option>
                    @endforeach
                </select>
            </div>
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
        $('#form').attr('action', '/financial/chart_account');
        $('#_method').val('POST');
        $('#acct_code').prop('disabled', false);
        $('#category_id').find('option:selected').removeAttr('selected');
        $('#posting_type').find('option:selected').removeAttr('selected');
        $('#typical_balance').find('option:selected').removeAttr('selected');
    }

    function edit(chart_account) {
        $('#exampleModalLabel').text('Edit Chart of Account');
        $('#exampleModal').modal('show');
        $('#form').attr('action', '/financial/chart_account/' + chart_account.id);
        $('#_method').val('PUT');
        $('#id').val(chart_account.id);
        $('#acct_code').val(chart_account.acct_code);
        $('#acct_code').prop('disabled', true);
        $('#description').val(chart_account.description);
        $('#category_id option[value=' + chart_account.category_id + ']').attr('selected', 'selected');
        $('#posting_type option[value=' + chart_account.posting_type + ']').attr('selected', 'selected');
        $('#typical_balance option[value=' + chart_account.typical_balance + ']').attr('selected', 'selected');
    }
</script>
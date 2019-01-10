@extends('layouts.master')

@section('title')
    <div class="blog-post">
        <h3>List of Bank Accounts</h3>
        <h6>{{ $bank->bank_name }} - ({{ $bank->bank_code }})</h6>
    </div>
@endsection

@section('button')
    <a href="{{ url('/ap/bank') }}">
        <button type="button" class="btn btn-outline-primary" aria-label="Left Align">
            <i class="fas fa-arrow-left fa-1x"></i> Back to List of Banks
        </button>
    </a>
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
                <th width="20%">Bank Information</th>
                <th width="26%">Account Information</th>
                <th width="16%">Status</th>
                <th width="16%">Logs</th>
                <th width="17%">Actions</th>
            </tr>
            </thead>

            <tbody>
            @php($ctr = 1)
            @foreach($bank_accounts as $bank_account)
                <tr class="tr-class">
                    <td>{{ $ctr++ }})</td>
                    <td>Address: <b>{{ $bank_account->bank_address }}</b></td>
                    <td>Account Code: <b>{{ $bank_account->acct_code }}</b><br>
                        Account Number: <b>{{ $bank_account->acct_no }}</b><br>
                        Account Type: <b>{{ $account_types[$bank_account->acct_type] }}</b><br>
                        Currency: <b>{{ $currencies[$bank_account->currency] }}</b><br>
                        Beginning Balance: <b>{{ $bank_account->beginning_balance }}</b></td>
                    <td>
                        @if($bank_account->disabled == 'N')
                            <span style="color: dodgerblue">Enabled</span>
                        @else
                            <span style="color: red">Disabled</span><br><br>
                            {{ $bank_account->disabled_by }}<br>
                            <i class="far fa-clock"></i>&nbsp;
                            <span style="color: blue">{{ $bank_account->date_disabled->diffForHumans() }}</span>
                        @endif
                    </td>

                    <td>{{ $bank_account->logs }}<br>
                        <i class="far fa-clock"></i>&nbsp;
                        <span style="color: dodgerblue">{{ $bank_account->created_at->diffForHumans() }}</span><br><br>
                        {{ $bank_account->last_modified }}<br>

                        @if($bank_account->last_modified != '')
                            <i class="far fa-clock"></i>&nbsp;
                            <span style="color: dodgerblue">
                            {{ $bank_account->updated_at->diffForHumans() }}
                            </span>
                        @endif
                    </td>

                    <td>
                        <div class="form-inline">
                            <form method="POST"
                                  action="{{ url('/ap/bank_account/delete/'. $bank->id . '/' . $bank_account->id) }}">
                                {{ method_field('DELETE') }}
                                {{ csrf_field() }}

                                <button type="button" class="btn btn-outline-dark" aria-label="Left Align"
                                        onclick="edit({{ $bank_account }});">
                                    <i class="fas fa-edit"></i>
                                </button>

                                <button type="submit" class="btn btn-outline-danger" aria-label="Left Align">
                                    <i class="fas fa-trash-alt"></i>
                                </button>

                                <hr>
                                @if($bank_account->acct_type == "C")
                                    <a href="{{ url('/ap/check/get/' . $bank->id . '/' . $bank_account->id ) }}">
                                        Manage Check Booklet</a><br>
                                @endif

                                <a href="{{ url('/ap/bank_account/update_status/' . $bank->id . '/' . $bank_account->id ) }}">
                                    {{ $bank_account->disabled == 'N' ? 'Disable' : 'Enable' }}</a>
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
    <form id="form" name="form" method="POST" action="{{ url('/ap/bank_account') }}">
        <input type="hidden" name="_method" id="_method" value="POST">
        {{ csrf_field() }}

        <input type="hidden" id="id" name="id"/>
        <input type="hidden" id="bank_id" name="bank_id" value="{{ $bank->id }}"/>
        <input type="hidden" id="bank_id" name="bank_code" value="{{ $bank->bank_code }}"/>

        <div class="form-group">
            <div class="mb-3">
                <label for="exampleInputEmail1">Bank Name</label>
                <input type="text" class="form-control" id="bank_name" name="bank_name" value="{{ $bank->bank_name }}"
                       disabled>
            </div>

            <div class="mb-3">
                <label for="exampleInputEmail1">Bank Address</label>
                <input type="text" class="form-control" id="bank_address" name="bank_address" required>
            </div>

            <div class="mb-3">
                <label for="exampleInputEmail1">Account Code</label>
                <input type="text" class="form-control" id="acct_code" name="acct_code" required>
            </div>

            <div class="mb-3">
                <label for="exampleInputEmail1">Account Number</label>
                <input type="text" class="form-control" id="acct_no" name="acct_no" required>
            </div>

            <div class="mb-3">
                <label for="exampleInputEmail1">Account Type</label>
                <select class="form-control" id="acct_type" name="acct_type" required>
                    <option value=""></option>
                    @foreach($account_types as $account_type => $value)
                        <option value="{{ $account_type }}">{{ $value }}</option>
                    @endforeach
                </select>
            </div>

            <div class="mb-3">
                <label for="exampleInputEmail1">Currency</label>
                <select class="form-control" id="currency" name="currency" required>
                    <option value=""></option>
                    @foreach($currencies as $currency => $value)
                        <option value="{{ $currency }}">{{ $value }}</option>
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
        $('#form').attr('action', '/ap/bank_account');
        $('#_method').val('POST');
    }

    function edit(bank_account) {
        $('#exampleModalLabel').text('Edit Bank');
        $('#exampleModal').modal('show');
        $('#form').attr('action', '/ap/bank_account/' + bank_account.id);
        $('#_method').val('PUT');
        $('#id').val(bank_account.id);
        $('#bank_address').val(bank_account.bank_address);
        $('#acct_code').val(bank_account.acct_code);
        $('#acct_no').val(bank_account.acct_no);
        $('#acct_type option[value=' + bank_account.acct_type + ']').attr('selected', 'selected');
        $('#currency option[value=' + bank_account.currency + ']').attr('selected', 'selected');
    }
</script>
@extends('layouts.master')

@section('title')
    <div class="blog-post">
        <h3>List of Check Booklets</h3>
        <h6>{{ $bank->bank_name }} - ({{ $bank->bank_code }})</h6>
    </div>
@endsection

@section('button')
    <a href="{{ url('/ap/bank_account',$bank->id) }}">
        <button type="button" class="btn btn-outline-primary" aria-label="Left Align">
            <i class="fas fa-arrow-left fa-1x"></i> Back to List of Bank Accounts
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
                <th width="17%">Account Number</th>
                <th width="20%">Check Sequence From</th>
                <th width="20%">Check Sequence To</th>
                <th width="20%">Logs</th>
                <th width="20%">Actions</th>
            </tr>
            </thead>

            <tbody>
            @php($ctr = 1)
            @foreach($checks as $check)
                <tr class="tr-class">
                    <td>{{ $ctr++ }})</td>
                    <td>{{ $check->acct_no }}</td>
                    <td>{{ $check->check_from }}</td>
                    <td>{{ $check->check_to }}</td>
                    <td>{{ $check->logs }}<br>
                        <i class="far fa-clock"></i>&nbsp;
                        {{--<span style="color: dodgerblue">{{ $check->created_at->diffForHumans() }}</span><br><br>--}}
                        {{ $check->last_modified }}<br>

                        @if($check->last_modified != '')
                            <i class="far fa-clock"></i>&nbsp;
                            <span style="color: dodgerblue">
                            {{--{{ $check->updated_at->diffForHumans() }}--}}
                            </span>
                        @endif
                    </td>

                    <td>
                        <div class="form-inline">
                            <form method="POST"
                                  action="{{ url('/ap/check/delete/'. $check->id . '/'. $bank->id) }}">
                                {{ method_field('DELETE') }}
                                {{ csrf_field() }}

                                <button type="submit" class="btn btn-outline-danger" aria-label="Left Align">
                                    <i class="fas fa-trash-alt"></i>
                                </button>

                                <hr>
                                <a href="{{ url('/ap/check/get/' .  $check->id . '/' . $bank->id) }}">
                                    View Check Booklet</a><br>
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
    <form id="form" name="form" method="POST" action="{{ url('/ap/check') }}">
        <input type="hidden" name="_method" id="_method" value="POST">
        {{ csrf_field() }}

        <input type="hidden" id="id" name="id"/>
        <input type="hidden" id="bank_id" name="bank_id" value="{{ $bank->id }}"/>
        <input type="hidden" id="bank_account_id" name="bank_account_id" value="{{ $bank_account->id }}"/>
        <input type="hidden" id="acct_no" name="acct_no" value="{{ $bank_account->acct_no }}"/>

        <div class="form-group">
            <div class="mb-3">
                <label>Check Sequence From</label>
                <input class="form-control"
                       type='number'
                       name='check_from'
                       id='check_from'
                       title="Check Sequence From"
                       min='0' maxlength='20'
                       required
                       autofocus
                       onchange='return UpdateValueFrom(this)'
                       onkeypress='return validateFloatKeyPress(this, event)'/>
            </div>

            <div class="mb-3">
                <label class='f_required'>Check Sequence To</label>
                <input class="form-control"
                       type='number'
                       name='check_to'
                       id='check_to'
                       title="Check Sequence To"
                       min='0' maxlength='20'
                       required
                       autofocus
                       onchange='return UpdateValueTo(this)'
                       onkeypress='return validateFloatKeyPress(this, event)'/>
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
        $('#form').attr('action', '/ap/check');
        $('#_method').val('POST');
    }

    function edit(check) {
        $('#exampleModalLabel').text('Edit Bank');
        $('#exampleModal').modal('show');
        $('#form').attr('action', '/ap/check/' + check.id);
        $('#_method').val('PUT');
        $('#id').val(check.id);
        $('#bank_address').val(check.bank_address);
        $('#acct_code').val(check.acct_code);
        $('#acct_no').val(check.acct_no);
    }

    function validateFloatKeyPress(el, evt) {
        var charCode = (evt.which) ? evt.which : event.keyCode;
        var number = el.value.split('.');
        if (charCode !== 46 && charCode > 31 && (charCode < 48 || charCode > 57)) {
            return false;
        }
        //just one dot (thanks ddlab)
        if (number.length > 1 && charCode === 46) {
            return false;
        }
        //get the carat position
        var amountPos = getSelectionStart(el);
        var dotPos = el.value.indexOf(".");
        if (amountPos > dotPos && dotPos > -1 && (number[1].length > 1)) {
            return false;
        }
        return true;
    }

    function UpdateValueFrom(data) {
        $('#n_check_to').attr('min', data.value).attr('value'.data.value);

    }

    function UpdateValueTo(data) {
        $('#n_check_from').attr('max', data.value).attr('value'.data.value);
    }
</script>
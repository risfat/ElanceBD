@extends('back-end.master')
@section('content')
    <section class="wt-haslayout wt-dbsectionspace">
        <div class="row">
            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 col-xl-9 float-right" id="invoice_list">
                <div class="wt-dashboardbox wt-dashboardinvocies">
                    <div class="wt-dashboardboxtitle wt-titlewithsearch">
                        <h2>{{ trans('lang.payouts') }}</h2>
                    </div>
                    <div class="wt-dashboardboxcontent wt-categoriescontentholder wt-categoriesholder">
                        <table class="wt-tablecategories">
                            <thead>
                                <tr>
                                    <th>
                                        <span class="wt-checkbox">
                                            <input id="wt-name" type="checkbox" name="head">
                                            <label for="wt-name"></label>
                                        </span>
                                    </th>
                                    <th>{{ trans('lang.user_name') }}</th>
                                    <th>{{ trans('lang.amount') }}</th>
                                    <th>{{ trans('lang.payment_method') }}</th>
                                    <th>{{ trans('lang.processing_date') }}</th>
                                </tr>
                            </thead>
                            @if ($payouts->count() > 0)
                                <tbody>
                                    @foreach ($payouts as $key => $payout)
                                        <tr>
                                            <td>
                                                <span class="wt-checkbox">
                                                    <input id="wt-{{{ $key }}}" type="checkbox" name="head">
                                                    <label for="wt-{{{ $key }}}"></label>
                                                </span>
                                            </td>
                                            <td>{{ Helper::getUserName($payout->user_id) }}</td>
                                            <td>{{ Helper::currencyList($payout->currency)['symbol'] }}{{{ $payout->amount }}}</td>
                                            <td>{{{ $payout->payment_method }}}</td>
                                            <td>{{{ \Carbon\Carbon::parse($payout->created_at)->format('M d, Y') }}}</td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            @endif
                        </table>
                        @if ($payouts->count() === 0)
                            @include('errors.no-record')
                        @endif
                        @if ( method_exists($payouts,'links') ) 
                            {{ $payouts->links('pagination.custom') }} 
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
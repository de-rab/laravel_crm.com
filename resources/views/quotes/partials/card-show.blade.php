@component('laravel-crm::components.card')

    @component('laravel-crm::components.card-header')

        @slot('title')
            {{ $quote->title }}
        @endslot

        @slot('actions')
            <span class="float-right">
                <a type="button" class="btn btn-outline-secondary btn-sm" href="{{ url(route('laravel-crm.quotes.index')) }}"><span class="fa fa-angle-double-left"></span> {{ ucfirst(__('laravel-crm::lang.back_to_quotes')) }}</a> 
                @can('edit crm quotes') |
                    @livewire('send-quote',[
                    'quote' => $quote
                    ])
                    @if(!$quote->accepted_at && !$quote->rejected_at)
                        <a href="{{ route('laravel-crm.quotes.accept',$quote) }}" class="btn btn-success btn-sm">{{ ucfirst(__('laravel-crm::lang.mark_as_accepted')) }}</a>
                        <a href="{{ route('laravel-crm.quotes.reject',$quote) }}" class="btn btn-danger btn-sm">{{ ucfirst(__('laravel-crm::lang.mark_as_rejected')) }}</a>
                    @elseif($quote->accepted_at)
                         <a href="{{ route('laravel-crm.quotes.unaccept',$quote) }}" class="btn btn-outline-secondary btn-sm">{{ ucfirst(__('laravel-crm::lang.unaccept')) }}</a>
                    @endif
                @endcan
                @include('laravel-crm::partials.navs.activities') |
                @can('edit crm quotes')
                <a href="{{ url(route('laravel-crm.quotes.edit', $quote)) }}" type="button" class="btn btn-outline-secondary btn-sm"><span class="fa fa-edit" aria-hidden="true"></span></a>
                @endcan
                @can('delete crm quotes')
                <form action="{{ route('laravel-crm.quotes.destroy',$quote) }}" method="POST" class="form-check-inline mr-0 form-delete-button">
                    {{ method_field('DELETE') }}
                    {{ csrf_field() }}
                    <button class="btn btn-danger btn-sm" type="submit" data-model="{{ __('laravel-crm::lang.quote') }}"><span class="fa fa-trash-o" aria-hidden="true"></span></button>
                </form>
                @endcan
            </span>
        @endslot

    @endcomponent

    @component('laravel-crm::components.card-body')

        <div class="row card-show card-fa-w30">
            <div class="col-sm-6 border-right">
                <h6 class="text-uppercase">{{ ucfirst(__('laravel-crm::lang.details')) }}</h6>
                <hr />
                <dl class="row">
                    <dt class="col-sm-3 text-right">Reference</dt>
                    <dd class="col-sm-9">{{ $quote->reference }}</dd>
                    <dt class="col-sm-3 text-right">Issue Date</dt>
                    <dd class="col-sm-9">{{ ($quote->issue_at) ? $quote->issue_at->toFormattedDateString() : null }}</dd>
                    <dt class="col-sm-3 text-right">Expiry Date</dt>
                    <dd class="col-sm-9">{{ ($quote->expire_at) ? $quote->expire_at->toFormattedDateString() : null }}</dd>
                    <dt class="col-sm-3 text-right">Description</dt>
                    <dd class="col-sm-9">{{ $quote->description }}</dd>
                    <dt class="col-sm-3 text-right">Labels</dt>
                    <dd class="col-sm-9">@include('laravel-crm::partials.labels',[
                            'labels' => $quote->labels
                    ])</dd>
                    <dt class="col-sm-3 text-right">Owner</dt>
                    <dd class="col-sm-9">{{ $quote->ownerUser->name ?? null }}</dd>
                </dl>
                
                <h6 class="mt-4 text-uppercase">{{ ucfirst(__('laravel-crm::lang.contact_person')) }}</h6>
                <hr />
                <p><span class="fa fa-user" aria-hidden="true"></span> {{ $quote->person->name ?? null }} </p>
                @isset($email)
                    <p><span class="fa fa-envelope" aria-hidden="true"></span> <a href="mailto:{{ $email->address }}">{{ $email->address }}</a> ({{ ucfirst($email->type) }})</p>
                @endisset
                @isset($phone)
                    <p><span class="fa fa-phone" aria-hidden="true"></span> <a href="tel:{{ $phone->number }}">{{ $phone->number }}</a> ({{ ucfirst($phone->type) }})</p>
                @endisset
                <h6 class="mt-4 text-uppercase">{{ ucfirst(__('laravel-crm::lang.organization')) }}</h6>
                <hr />
                <p><span class="fa fa-building" aria-hidden="true"></span> {{ $quote->organisation->name ?? null }}</p>
                <p><span class="fa fa-map-marker" aria-hidden="true"></span> {{ ($organisation_address) ? \VentureDrake\LaravelCrm\Http\Helpers\AddressLine\addressSingleLine($organisation_address) : null }} </p>
                @can('view crm products')
                <h6 class="text-uppercase mt-4 section-h6-title-table"><span>{{ ucfirst(__('laravel-crm::lang.quote_items')) }} ({{ $quote->quoteProducts->count() }})</span></h6>
                <table class="table table-hover">
                    <thead>
                    <tr>
                        <th scope="col">{{ ucfirst(__('laravel-crm::lang.item')) }}</th>
                        <th scope="col">{{ ucfirst(__('laravel-crm::lang.price')) }}</th>
                        <th scope="col">{{ ucfirst(__('laravel-crm::lang.quantity')) }}</th>
                        <th scope="col">{{ ucfirst(__('laravel-crm::lang.amount')) }}</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($quote->quoteProducts()->whereNotNull('product_id')->get() as $quoteProduct)
                        <tr>
                            <td>{{ $quoteProduct->product->name }}</td>
                            <td>{{ money($quoteProduct->price ?? null, $quoteProduct->currency) }}</td>
                            <td>{{ $quoteProduct->quantity }}</td>
                            <td>{{ money($quoteProduct->amount ?? null, $quoteProduct->currency) }}</td>
                        </tr>
                    @endforeach
                    </tbody>
                    <tfoot>
                        <tr>
                            <td></td>
                            <td></td>
                            <td><strong>{{ ucfirst(__('laravel-crm::lang.sub_total')) }}</strong></td>
                            <td>{{ money($quote->subtotal, $quote->currency) }}</td>
                        </tr>
                        <tr>
                            <td></td>
                            <td></td>
                            <td><strong>{{ ucfirst(__('laravel-crm::lang.discount')) }}</strong></td>
                            <td>{{ money($quote->discount, $quote->currency) }}</td>
                        </tr>
                        <tr>
                            <td></td>
                            <td></td>
                            <td><strong>{{ ucfirst(__('laravel-crm::lang.tax')) }}</strong></td>
                            <td>{{ money($quote->tax, $quote->currency) }}</td>
                        </tr>
                        <tr>
                            <td></td>
                            <td></td>
                            <td><strong>{{ ucfirst(__('laravel-crm::lang.adjustment')) }}</strong></td>
                            <td>{{ money($quote->adjustments, $quote->currency) }}</td>
                        </tr>
                        <tr>
                            <td></td>
                            <td></td>
                            <td><strong>{{ ucfirst(__('laravel-crm::lang.total')) }}</strong></td>
                            <td>{{ money($quote->total, $quote->currency) }}</td>
                        </tr>
                    </tfoot>
                </table>
                @endcan    
            </div>
            <div class="col-sm-6">
                @include('laravel-crm::partials.activities', [
                    'model' => $quote
                ])
            </div>
        </div>

    @endcomponent

@endcomponent    
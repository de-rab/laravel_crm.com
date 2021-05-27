@component('laravel-crm::components.card')

    @component('laravel-crm::components.card-header')

        @slot('title')
            {{ $organisation->name }} <small>@include('laravel-crm::partials.labels',[
                            'labels' => $organisation->labels
                    ])</small>
        @endslot

        @slot('actions')
            <span class="float-right">
                <a type="button" class="btn btn-outline-secondary btn-sm" href="{{ url(route('laravel-crm.organisations.index')) }}"><span class="fa fa-angle-double-left"></span>  {{ ucfirst(__('laravel-crm::lang.back_to_organizations')) }}</a> | 
                <a href="{{ url(route('laravel-crm.deals.create',['model' => 'organisation', 'id' => $organisation->id])) }}" alt="Add deal" class="btn btn-success btn-sm"><span class="fa fa-plus" aria-hidden="true"></span> Add new deal</a>
                @include('laravel-crm::partials.navs.activities') | 
                <a href="{{ url(route('laravel-crm.organisations.edit', $organisation)) }}" type="button" class="btn btn-outline-secondary btn-sm"><span class="fa fa-edit" aria-hidden="true"></span></a>
                <form action="{{ route('laravel-crm.organisations.destroy',$organisation) }}" method="POST" class="form-check-inline mr-0 form-delete-button">
                    {{ method_field('DELETE') }}
                    {{ csrf_field() }}
                    <button class="btn btn-danger btn-sm" type="submit" data-model="{{ __('laravel-crm::lang.organization') }}"><span class="fa fa-trash-o" aria-hidden="true"></span></button>
                </form>
            </span>
        @endslot

    @endcomponent

    @component('laravel-crm::components.card-body')

        <div class="row">
            <div class="col-sm-6 border-right">
                <h6 class="text-uppercase">Details</h6>
                <hr />
                <dl class="row">
                    <dt class="col-sm-3 text-right">Name</dt>
                    <dd class="col-sm-9">{{ $organisation->name }}</dd>
                    <dt class="col-sm-3 text-right">Address</dt>
                    <dd class="col-sm-9">{{ ($address) ? \VentureDrake\LaravelCrm\Http\Helpers\AddressLine\addressSingleLine($address) : null }}</dd>
                    <dt class="col-sm-3 text-right">Description</dt>
                    <dd class="col-sm-9">{{ $organisation->description }}</dd>
                </dl>
                <h6 class="text-uppercase mt-4 section-h6-title"><span>People ({{ $organisation->people->count() }})</span><span class="float-right"><a href="{{ url(route('laravel-crm.people.create',['model' => 'organisation', 'id' => $organisation->id])) }}" class="btn btn-outline-secondary btn-sm"><span class="fa fa-plus" aria-hidden="true"></span></a></span></h6>
                <hr />
                @foreach($organisation->people as $person)
                    <p><span class="fa fa-user" aria-hidden="true"></span> {{ $person->name }}</p>
                @endforeach
                <h6 class="text-uppercase mt-4 section-h6-title"><span>Deals ({{ $organisation->deals->count() }})</span><span class="float-right"><a href="{{ url(route('laravel-crm.deals.create',['model' => 'organisation', 'id' => $organisation->id])) }}" class="btn btn-outline-secondary btn-sm"><span class="fa fa-plus" aria-hidden="true"></span></a></span></h6>
                <hr />
                @foreach($organisation->deals as $deal)
                    <p>{{ $deal->title }}<br />
                        <small>{{ money($deal->amount, $deal->currency) }}</small></p>
                @endforeach
                <h6 class="text-uppercase mt-4">Owner</h6>
                <hr />
                <dl class="row">
                    <dt class="col-sm-3 text-right">Name</dt>
                    <dd class="col-sm-9">{{ $organisation->ownerUser->name }}</dd>
                </dl>
            </div>
            <div class="col-sm-6">
                <h6 class="text-uppercase">Notes</h6>
                <hr />
                ...
                <h6 class="text-uppercase mt-4">Files</h6>
                <hr />
                ...
                <h6 class="text-uppercase mt-4">Activities</h6>
                <hr />
                ...
            </div>
        </div>

    @endcomponent

@endcomponent    
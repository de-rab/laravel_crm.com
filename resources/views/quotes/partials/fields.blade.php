<div class="row">
    <div class="col-sm-6 border-right">
        @include('laravel-crm::partials.form.hidden',[
             'name' => 'lead_id',
             'value' => old('lead_id', $quote->lead->id ?? $lead->id ?? null),
        ])
        <span class="autocomplete">
             @include('laravel-crm::partials.form.hidden',[
               'name' => 'person_id',
               'value' => old('person_id', $quote->person->id ?? $person->id ?? null),
            ])
            <script type="text/javascript">
                let people =  {!! \VentureDrake\LaravelCrm\Http\Helpers\AutoComplete\people() !!}
            </script>
            @include('laravel-crm::partials.form.text',[
               'name' => 'person_name',
               'label' => ucfirst(__('laravel-crm::lang.contact_person')),
               'prepend' => '<span class="fa fa-user" aria-hidden="true"></span>',
               'value' => old('person_name', $quote->person->name ?? $person->name ?? null),
               'attributes' => [
                  'autocomplete' => \Illuminate\Support\Str::random()
               ]
            ])
        </span>
        <span class="autocomplete">
            @include('laravel-crm::partials.form.hidden',[
              'name' => 'organisation_id',
              'value' => old('organisation_id', $quote->organisation->id ?? $organisation->id ??  null),
            ])
            <script type="text/javascript">
                let organisations = {!! \VentureDrake\LaravelCrm\Http\Helpers\AutoComplete\organisations() !!}
            </script>
            @include('laravel-crm::partials.form.text',[
                'name' => 'organisation_name',
                'label' => ucfirst(__('laravel-crm::lang.organization')),
                'prepend' => '<span class="fa fa-building" aria-hidden="true"></span>',
                'value' => old('organisation_name',$quote->organisation->name ?? $organisation->name ?? null),
                'attributes' => [
                  'autocomplete' => \Illuminate\Support\Str::random()
               ]
            ])
        </span>    
        @include('laravel-crm::partials.form.text',[
            'name' => 'title',
            'label' => ucfirst(__('laravel-crm::lang.title')),
            'value' => old('title',$quote->title ?? null)
        ])
        @include('laravel-crm::partials.form.textarea',[
             'name' => 'description',
             'label' => ucfirst(__('laravel-crm::lang.description')),
             'rows' => 5,
             'value' => old('description', $quote->description ?? null) 
        ])
        <div class="row">
            <div class="col-sm-6">
                @include('laravel-crm::partials.form.text',[
                      'name' => 'amount',
                      'label' => ucfirst(__('laravel-crm::lang.value')),
                      'prepend' => '<span class="fa fa-dollar" aria-hidden="true"></span>',
                      'value' => old('amount', ((isset($quote->amount)) ? ($quote->amount / 100) : null) ?? null) 
                  ])
            </div>
            <div class="col-sm-6">
                @include('laravel-crm::partials.form.select',[
                    'name' => 'currency',
                    'label' => ucfirst(__('laravel-crm::lang.currency')),
                    'options' => \VentureDrake\LaravelCrm\Http\Helpers\SelectOptions\currencies(),
                    'value' => old('currency', $quote->currency ?? \VentureDrake\LaravelCrm\Models\Setting::currency()->value ?? 'USD')
                ])
            </div>
        </div>
        @include('laravel-crm::partials.form.text',[
             'name' => 'expected_close',
             'label' => ucfirst(__('laravel-crm::lang.expected_close_date')),
             'value' => old('expected_close', (isset($quote->expected_close)) ? \Carbon\Carbon::parse($quote->expected_close)->format('Y/m/d') : null),
             'attributes' => [
                 'autocomplete' => \Illuminate\Support\Str::random()
              ]
         ])

        @include('laravel-crm::partials.form.multiselect',[
            'name' => 'labels',
            'label' => ucfirst(__('laravel-crm::lang.labels')),
            'options' => \VentureDrake\LaravelCrm\Http\Helpers\SelectOptions\optionsFromModel(\VentureDrake\LaravelCrm\Models\Label::all(), false),      
            'value' =>  old('labels', (isset($quote)) ? $quote->labels->pluck('id')->toArray() : null)
        ])

        @include('laravel-crm::partials.form.select',[
                 'name' => 'user_owner_id',
                 'label' => ucfirst(__('laravel-crm::lang.owner')),
                 'options' => \VentureDrake\LaravelCrm\Http\Helpers\SelectOptions\users(false),
                 'value' =>  old('user_owner_id', $quote->user_owner_id ?? auth()->user()->id),
              ])
    </div>
    <div class="col-sm-6">
        <h6 class="text-uppercase"><span class="fa fa-user" aria-hidden="true"></span> {{ ucfirst(__('laravel-crm::lang.person')) }}</h6>
        <hr />
        <span class="autocomplete-person">
            <div class="row">
                <div class="col-sm-6">
                    @include('laravel-crm::partials.form.text',[
                     'name' => 'phone',
                     'label' => ucfirst(__('laravel-crm::lang.phone')),
                     'value' => old('phone', $phone->number ?? null),
                     'attributes' => [
                         'disabled' => 'disabled'
                     ]
                  ])
                </div>
                <div class="col-sm-6">
                    @include('laravel-crm::partials.form.select',[
                     'name' => 'phone_type',
                     'label' => ucfirst(__('laravel-crm::lang.type')),
                     'options' => \VentureDrake\LaravelCrm\Http\Helpers\SelectOptions\phoneTypes(),
                     'value' => old('phone_type', $phone->type ??  'mobile'),
                     'attributes' => [
                         'disabled' => 'disabled'
                     ]
                  ])
                </div>
            </div>
            <div class="row">
                <div class="col-sm-6">
                    @include('laravel-crm::partials.form.text',[
                     'name' => 'email',
                     'label' => ucfirst(__('laravel-crm::lang.email')),
                     'value' => old('email', $email->address ?? null),
                     'attributes' => [
                         'disabled' => 'disabled'
                     ]
                  ])
                </div>
                <div class="col-sm-6">
                    @include('laravel-crm::partials.form.select',[
                     'name' => 'email_type',
                     'label' => ucfirst(__('laravel-crm::lang.type')),
                     'options' => \VentureDrake\LaravelCrm\Http\Helpers\SelectOptions\emailTypes(),
                     'value' => old('email_type', $email->type ?? 'work'),
                     'attributes' => [
                         'disabled' => 'disabled'
                     ]
                  ])
                </div>
            </div>
        </span>
        <h6 class="text-uppercase mt-4"><span class="fa fa-building" aria-hidden="true"></span> {{ ucfirst(__('laravel-crm::lang.organization')) }}</h6>
        <hr />
        <span class="autocomplete-organisation">
            {{--@include('laravel-crm::partials.form.text',[
                'name' => 'address',
                'label' => ucfirst(__('laravel-crm::lang.address')),
                'value' => old('address', $address ?? null)
            ])--}}
            @include('laravel-crm::partials.form.text',[
               'name' => 'line1',
               'label' => ucfirst(__('laravel-crm::lang.address_line_1')),
               'value' => old('line1', $address->line1 ?? null),
               'attributes' => [
                    'disabled' => 'disabled'
               ]
            ])
            @include('laravel-crm::partials.form.text',[
               'name' => 'line2',
               'label' => ucfirst(__('laravel-crm::lang.address_line_2')),
               'value' => old('line2', $address->line2 ?? null),
               'attributes' => [
                    'disabled' => 'disabled'
               ]
            ])
            @include('laravel-crm::partials.form.text',[
               'name' => 'line3',
               'label' => ucfirst(__('laravel-crm::lang.address_line_3')),
               'value' => old('line3', $address->line3 ?? null),
               'attributes' => [
                    'disabled' => 'disabled'
               ]
            ])
            <div class="row">
                <div class="col-sm-6">
                    @include('laravel-crm::partials.form.text',[
                       'name' => 'city',
                       'label' => ucfirst(__('laravel-crm::lang.suburb')),
                       'value' => old('city', $address->city ?? null),
                       'attributes' => [
                            'disabled' => 'disabled'
                       ]
                    ])
                </div>
                <div class="col-sm-6">
                    @include('laravel-crm::partials.form.text',[
                       'name' => 'state',
                       'label' => ucfirst(__('laravel-crm::lang.state')),
                       'value' => old('state', $address->state ?? null),
                       'attributes' => [
                            'disabled' => 'disabled'
                       ]
                    ])
                </div>
            </div>
            <div class="row">
                <div class="col-sm-6">
                    @include('laravel-crm::partials.form.text',[
                       'name' => 'code',
                       'label' => ucfirst(__('laravel-crm::lang.postcode')),
                       'value' => old('code', $address->code ?? null),
                       'attributes' => [
                            'disabled' => 'disabled'
                        ]
                    ])
                </div>
                <div class="col-sm-6">
                    @include('laravel-crm::partials.form.select',[
                     'name' => 'country',
                     'label' => ucfirst(__('laravel-crm::lang.country')),
                     'options' => \VentureDrake\LaravelCrm\Http\Helpers\SelectOptions\countries(),
                     'value' => old('country', $address->country ?? 'United States'),
                     'attributes' => [
                            'disabled' => 'disabled'
                       ]
                  ])
                </div>
            </div>
        </span>
        <h6 class="text-uppercase mt-4 section-h6-title"><span class="fa fa-cart-arrow-down" aria-hidden="true"></span> {{ ucfirst(__('laravel-crm::lang.products')) }} <span class="float-right"><a href="{{ (isset($quote)) ? url(route('laravel-crm.quote-products.create', $quote)) : url(route('laravel-crm.quote-products.create-product')) }}" class="btn btn-outline-secondary btn-sm btn-action-add-quote-product"><span class="fa fa-plus" aria-hidden="true"></span></a></span></h6>
        <hr />
        <script type="text/javascript">
            let products =  {!! \VentureDrake\LaravelCrm\Http\Helpers\AutoComplete\products() !!}
        </script>
        <span id="quoteProducts">
            @if(isset($quote) && method_exists($quote,'quoteProducts'))
                @foreach($quote->quoteProducts as $quoteProduct)
                    @include('laravel-crm::quote-products.partials.fields',[
                        'index' => $loop->index
                    ])
                @endforeach
            @endif    
        </span>
    </div>
</div>
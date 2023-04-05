<?php

namespace VentureDrake\LaravelCrm\Http\Livewire;

use Livewire\Component;
use VentureDrake\LaravelCrm\Models\Client;

class LiveOrderForm extends Component
{
    public $client_id;
    public $clientHasOrganisations = false;
    public $clientHasPeople = false;
    public $client_name;
    public $people = [];
    public $person_id;
    public $person_name;
    public $organisations = [];
    public $organisation_id;
    public $organisation_name;

    public function mount($order)
    {
        $this->client_id = old('client_id') ?? $order->client->id ?? null;
        $this->client_name = old('client_name') ?? $order->client->name ?? null;
        $this->person_id = old('person_id') ?? $order->person->id ?? null;
        $this->person_name = old('person_name') ?? $order->person->name ?? null;
        $this->organisation_id = old('organisation_id') ?? $order->organisation->id ?? null;
        $this->organisation_name = old('organisation_name') ?? $order->organisation->name ?? null;

        if ($this->client_id) {
            $this->getClientOrganisations();

            $this->getClientPeople();
        }
    }

    public function updatedClientName($value)
    {
        if ($this->client_id) {
            $this->getClientOrganisations();

            $this->getClientPeople();
        }
    }
    
    public function getClientOrganisations()
    {
        foreach (Client::find($this->client_id)->contacts()
                     ->where('entityable_type', 'LIKE', '%Organisation%')
                     ->get() as $contact) {
            $this->organisations[$contact->entityable_id] = $contact->entityable->name;
            $this->clientHasOrganisations = true;
        }
    }

    public function getClientPeople()
    {
        foreach (Client::find($this->client_id)->contacts()
                     ->where('entityable_type', 'LIKE', '%Person%')
                     ->get() as $contact) {
            $this->people[$contact->entityable_id] = $contact->entityable->name;
            $this->clientHasPeople = true;
        }
    }
    
    public function render()
    {
        return view('laravel-crm::livewire.order-form');
    }
}

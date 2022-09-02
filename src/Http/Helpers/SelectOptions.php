<?php

namespace VentureDrake\LaravelCrm\Http\Helpers\SelectOptions;

use \App\User;
use Rinvex\Country\CountryLoader;
use Rinvex\Country\CurrencyLoader;

function optionsFromModel($model, $null = true)
{
    $array = [];

    if ($null) {
        $array[''] = '';
    }

    if ($model) {
        foreach ($model as $item) {
            $array[$item->id] = $item->name;
        }
    }

    return $array;
}

function users($null = true)
{
    $array = [];

    if ($null) {
        $array[''] = '';
    }
    
    $users = [];

    if (config('laravel-crm.teams')) {
        if (auth()->user()->currentTeam) {
            $users = auth()->user()->currentTeam->allUsers();
        }
    } else {
        $users = User::all();
    }

    foreach ($users as $item) {
        $array[$item->id] = $item->name;
    }

    return $array;
}

function phoneTypes($null = true)
{
    $array = [];
    
    if ($null) {
        $array[''] = '';
    }

    $array = array_merge($array, [
        'work' => 'Work',
        'home' => 'Home',
        'mobile' => 'Mobile',
        'fax' => 'Fax',
        'other' => "Other",
    ]);
    
    return $array;
}

function emailTypes($null = true)
{
    $array = [];

    if ($null) {
        $array[''] = '';
    }

    $array = array_merge($array, [
        'work' => 'Work',
        'home' => 'Home',
        'other' => "Other",
    ]);

    return $array;
}

function countries()
{
    /* $countries = new Countries();
     $items = [];

     foreach ($countries->all()->pluck('name.common')->toArray() as $country) {
         $items[$country] = $country;
     }*/

    foreach (CountryLoader::countries() as $country) {
        $items[$country['name']] = $country['name'];
    }

    return $items;
}

function currencies()
{
    /*$countries = new Countries();
    $items = [];
    foreach ($countries->currencies()->sortBy('name')->toArray() as $currencyCode => $currency) {
        $items[$currencyCode] = $currency['name'].(' ('.$currencyCode.')');
    }*/

    foreach (CurrencyLoader::currencies(true) as $currency) {
        $items[$currency['iso_4217_code']] = $currency['iso_4217_name'].(' ('.$currency['iso_4217_code'].')');
    }

    return $items;
}


function timezones()
{
    /*$countries = new Countries();
    $collection = $countries->all()->hydrate('timezones')->pluck("timezones");

    foreach ($collection->toArray() as $timezone) {
        $items[array_key_first($timezone)] = current($timezone)['zone_name'];
    }

    return $items;*/
}

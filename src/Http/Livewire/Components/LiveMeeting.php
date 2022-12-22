<?php

namespace VentureDrake\LaravelCrm\Http\Livewire\Components;

use Livewire\Component;
use VentureDrake\LaravelCrm\Models\Meeting;
use VentureDrake\LaravelCrm\Traits\NotifyToast;

class LiveMeeting extends Component
{
    use NotifyToast;

    public $meeting;
    public $editMode = false;
    public $name;
    public $description;
    public $start_at;
    public $finish_at;
    public $view;

    protected $listeners = [
        'refreshComponent' => '$refresh',
    ];

    public function mount(Meeting $meeting, $view = 'meeting')
    {
        $this->meeting = $meeting;
        $this->name = $meeting->name;
        $this->description = $meeting->description;
        $this->start_at = ($meeting->start_at) ? $meeting->start_at->format('Y/m/d H:i') : null;
        $this->finish_at = ($meeting->finish_at) ? $meeting->finish_at->format('Y/m/d H:i') : null;
        $this->view = $view;
    }

    /**
     * Returns validation rules.
     *
     * @return array
     */
    protected function rules()
    {
        return [
            'name' => "required",
            'description' => "nullable",
            'start_at' => 'required',
            'finish_at' => 'required',
        ];
    }

    public function update()
    {
        $this->validate();
        $this->meeting->update([
            'name' => $this->name,
            'description' => $this->description,
            'start_at' => $this->start_at,
            'finish_at' => $this->finish_at,
        ]);
        $this->toggleEditMode();
        $this->emit('refreshComponent');
        $this->notify(
            ucfirst(trans('laravel-crm::lang.meeting_updated'))
        );
    }

    public function delete()
    {
        $this->meeting->delete();

        $this->emit('meetingDeleted');
        $this->notify(
            ucfirst(trans('laravel-crm::lang.meeting_deleted'))
        );
    }

    public function toggleEditMode()
    {
        $this->editMode = ! $this->editMode;

        $this->dispatchBrowserEvent('meetingEditModeToggled');
    }

    public function render()
    {
        return view('laravel-crm::livewire.components.'.$this->view);
    }
}

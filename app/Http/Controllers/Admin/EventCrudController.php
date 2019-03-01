<?php

namespace App\Http\Controllers\Admin;

use Backpack\CRUD\app\Http\Controllers\CrudController;

// VALIDATION: change the requests to match your own file names if you need form validation
use App\Http\Requests\EventRequest as StoreRequest;
use App\Http\Requests\EventRequest as UpdateRequest;
use Backpack\CRUD\CrudPanel;

use Carbon\Carbon;

/**
 * Class EventCrudController
 * @package App\Http\Controllers\Admin
 * @property-read CrudPanel $crud
 */
class EventCrudController extends CrudController
{
    public function setup()
    {
        /*
        |--------------------------------------------------------------------------
        | CrudPanel Basic Information
        |--------------------------------------------------------------------------
        */
        $this->crud->setModel('App\Models\Event');
        $this->crud->setRoute(config('backpack.base.route_prefix') . '/event');
        $this->crud->setEntityNameStrings('event', 'events');

        /*
        |--------------------------------------------------------------------------
        | CrudPanel Configuration
        |--------------------------------------------------------------------------
        */

        // TODO: remove setFromDb() and manually define Fields and Columns
        $this->crud->addField([
            'name' => 'title',
            'label' => 'Event Title',
            'type' => 'text',
        ]);
        $this->crud->addField([
            'name' => 'description',
            'label' => 'Event Description',
            'type' => 'text',
        ]);
        $this->crud->addField([
            'name' => 'event_date_range',
            'start_name' => 'event_start',
            'end_name' => 'event_end',
            'label' => 'Event Date and Time',
            'type' => 'date_range',

            'start_default' => Carbon::now('Asia/Jakarta'),
            'end_default' => Carbon::now('Asia/Jakarta')->addHours(2),
            'date_range_options' => [
                'timePicker' => true,
                'locale' => ['format' => 'DD/MM/YYYY HH:mm']
            ]
        ]);

        $this->crud->addColumns([
            [
                'name' => 'title',
                'label' => 'Event Title',
            ],
            [
                'name' => 'description',
                'label' => 'Event Description',
            ],
            [
                'name' => 'event_url',
                'label' => 'URL',
                'type' => 'model_function',
                'function_name' => 'getPublicURL',
                'limit' => 120,
            ],
        ]);

        // add asterisk for fields that are required in EventRequest
        $this->crud->setRequiredFields(StoreRequest::class, 'create');
        $this->crud->setRequiredFields(UpdateRequest::class, 'edit');
    }

    public function store(StoreRequest $request)
    {
        // your additional operations before save here
        $redirect_location = parent::storeCrud($request);
        // your additional operations after save here
        // use $this->data['entry'] or $this->crud->entry
        return $redirect_location;
    }

    public function update(UpdateRequest $request)
    {
        // your additional operations before save here
        $redirect_location = parent::updateCrud($request);
        // your additional operations after save here
        // use $this->data['entry'] or $this->crud->entry
        return $redirect_location;
    }
}

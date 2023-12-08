<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use App\Models\Contact;
use App\Http\Requests\FilterContactRequest;
use App\Http\Requests\StoreContactRequest;
use App\Http\Requests\UpdateContactRequest;

class ContactController extends Controller
{
    /**
     * @var \App\Models\Contact
     */
    protected $contact;

    /**
     * Create a new ContactController instance.
     *
     * @return void
     */
    public function __construct(Contact $contact)
    {
        $this->contact = $contact;
    }

    /**
     * Get list of the contacts
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $contacts = $this->contact->indexData();

        return response()->json([
            'status' => 'success',
            'contacts' => $contacts,
        ]);
    }

    /**
     * Get filtered list of the contacts
     *
     * @param  \Illuminate\Http\FilterContactRequest  $request
     *
     * @return \Illuminate\Http\Response
     */
    public function filter(FilterContactRequest $request)
    {
        $contacts = $this->contact->filterData($request);

        return response()->json([
            'status' => 'success',
            'contacts' => $contacts ?? [],
        ]);
    }

    /**
     * Show the contact
     *
     * @param  int  $id
     *
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $contact = Contact::findOrFail($id);

        $contact = $contact->showData();

        return response()->json([
            'status' => 'success',
            'contact' => $contact,
        ]);
    }

    /**
     * Create the contact
     *
     * @param  \Illuminate\Http\StoreContactRequest  $request
     *
     * @return \Illuminate\Http\Response
     */
    public function store(StoreContactRequest $request)
    {
        $contact = $this->contact->storeData($request->all());

        return response()->json([
            'status' => 'success',
            'message' => 'Contact created successfully.',
            'contact' => $contact,
        ]);
    }

    /**
     * Update the contact
     *
     * @param  \Illuminate\Http\UpdateContactRequest  $request
     * @param  int  $id
     *
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateContactRequest $request, $id)
    {
        $contact = Contact::findOrFail($id);

        $contact->updateData($request->all());

        return response()->json([
            'status' => 'success',
            'message' => 'Contact was updated successfully.',
            'contact' => $contact,
        ]);
    }

    /**
     * Delete the contact
     *
     * @param  int  $id
     *
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $contact = Contact::findOrFail($id);

        $contact->deleteData();

        return response()->json([
            'status' => 'success',
            'message' => 'Contact was deleted successfully.',
        ]);
    }
}

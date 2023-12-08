<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Collection;

use Orchid\Filters\Filterable;
use Orchid\Filters\Types\Like;
use Orchid\Filters\Types\Where;
use Orchid\Metrics\Chartable;
use Orchid\Screen\AsSource;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class Contact extends Model
{
    use Filterable, AsSource, Chartable, HasFactory;

    /**
     * @var string
     */
    protected $table = 'contacts';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'id',
        'name',
        'surname',
        'phone',
        'email',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [];

    /**
     * The attributes for which you can use filters in url.
     *
     * @var array
     */
    protected $allowedFilters = [
        'id'    => Where::class,
        'phone' => Like::class,
        'email' => Like::class,
    ];

    /**
     * The attributes for which can use sort in url.
     *
     * @var array
     */
    protected $allowedSorts = [
        'id',
        'name',
        'surname',
        'phone',
        'email',
        'updated_at',
        'created_at',
    ];

    /**
     * Get list of the contacts
     *
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function indexData() {
        $contacts = Contact::all();
        return $contacts;
    }

    /**
     * Get filtered list of the contacts
     *
     * @param  \Illuminate\Http\Request  $request
     *
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function filterData($request) {
        $validatedCollection = collect($request->validated());

        $q = $validatedCollection->get('q');

        $contacts = new Contact();
        if(!empty($q)) {
            $contacts = Contact::where('name', 'LIKE', '%'.$q.'%')
                ->orWhere('surname', 'LIKE', '%'.$q.'%');
        }

        $contactsGrouped = [];
        $contacts->get()->each(function ($item) use (&$contactsGrouped) {
            $firstLetter = Str::substr($item->surname, 0, 1);
            $contactsGrouped[$firstLetter][] = $item;
        });
        ksort($contactsGrouped);

        return $contactsGrouped;
    }

    /**
     * Show the contact
     *
     * @return \App\Models\Contact
     */
    public function showData() {
        return $this;
    }

    /**
     * Create the contact
     *
     * @param  array  $data
     *
     * @return \App\Models\Contact
     */
    public function storeData($data) {
        DB::transaction(function() use ($data) {
            $this->fill($data)
                ->save();
        });

        return $this;
    }

    /**
     * Update the contact
     *
     * @param  array  $data
     *
     * @return void
     */
    public function updateData($data) {
        DB::transaction(function() use ($data) {
            $this->fill($data)
                ->save();
        });

        return $this;
    }

    /**
     * Delete the contact
     *
     * @return boolean
     */
    public function deleteData() {
        DB::transaction(function() {
            $this->delete();
        });

        return true;
    }
}

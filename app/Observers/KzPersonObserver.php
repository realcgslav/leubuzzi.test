<?php

namespace App\Observers;

use App\Models\KzPerson;
use Illuminate\Support\Facades\DB;

class KzPersonObserver
{
    /**
     * Handle the KzPerson "deleting" event.
     *
     * @param  \App\Models\KzPerson  $kzPerson
     * @return void
     */
    public function deleting(KzPerson $kzPerson)
    {
        // Delete related records in the pivot table
        DB::table('journalist_kz_people')->where('kz_person_id', $kzPerson->id)->delete();
    }
}

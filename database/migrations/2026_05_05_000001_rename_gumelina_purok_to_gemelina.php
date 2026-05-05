<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (Schema::hasTable('users') && Schema::hasColumn('users', 'purok')) {
            $rows = DB::table('users')
                ->whereNotNull('purok')
                ->whereRaw('LOWER(purok) LIKE ?', ['%gumelina%'])
                ->get(['user_id', 'purok']);

            foreach ($rows as $row) {
                $new = preg_replace('/Gumelina/iu', 'Gemelina', $row->purok);
                if ($new !== $row->purok) {
                    DB::table('users')->where('user_id', $row->user_id)->update(['purok' => $new]);
                }
            }
        }

        if (Schema::hasTable('residents') && Schema::hasColumn('residents', 'purok')) {
            $rows = DB::table('residents')
                ->whereNotNull('purok')
                ->whereRaw('LOWER(purok) LIKE ?', ['%gumelina%'])
                ->get(['resident_id', 'purok']);

            foreach ($rows as $row) {
                $new = preg_replace('/Gumelina/iu', 'Gemelina', $row->purok);
                if ($new !== $row->purok) {
                    DB::table('residents')->where('resident_id', $row->resident_id)->update(['purok' => $new]);
                }
            }
        }
    }

    public function down(): void
    {
        if (Schema::hasTable('users') && Schema::hasColumn('users', 'purok')) {
            $rows = DB::table('users')
                ->whereNotNull('purok')
                ->whereRaw('LOWER(purok) LIKE ?', ['%gemelina%'])
                ->get(['user_id', 'purok']);

            foreach ($rows as $row) {
                $new = preg_replace('/Gemelina/iu', 'Gumelina', $row->purok);
                if ($new !== $row->purok) {
                    DB::table('users')->where('user_id', $row->user_id)->update(['purok' => $new]);
                }
            }
        }

        if (Schema::hasTable('residents') && Schema::hasColumn('residents', 'purok')) {
            $rows = DB::table('residents')
                ->whereNotNull('purok')
                ->whereRaw('LOWER(purok) LIKE ?', ['%gemelina%'])
                ->get(['resident_id', 'purok']);

            foreach ($rows as $row) {
                $new = preg_replace('/Gemelina/iu', 'Gumelina', $row->purok);
                if ($new !== $row->purok) {
                    DB::table('residents')->where('resident_id', $row->resident_id)->update(['purok' => $new]);
                }
            }
        }
    }
};

<?php

namespace Database\Seeders\Traits;

use Illuminate\Support\Facades\DB;

trait TruncateTable {
    protected function truncate($table): void {
        DB::table($table)->truncate();
    }
}

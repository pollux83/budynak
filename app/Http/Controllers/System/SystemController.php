<?php

namespace App\Http\Controllers\System;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;

class SystemController extends Controller {
    public function dbbackup() {
        return view('admin.system.database_backup');
    }

    public function csvexport() {
        return view('admin.system.export_to_csv');
    }

    public function csvimport() {
        return view('admin.system.import_from_csv');
    }

}

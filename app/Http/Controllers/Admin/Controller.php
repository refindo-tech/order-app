<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller as BaseController;

abstract class Controller extends BaseController
{
    // Base controller untuk panel Admin.
    // Middleware auth akan ditambahkan di Phase 1 - Setup autentikasi Admin.
}

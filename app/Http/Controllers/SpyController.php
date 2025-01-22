<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateSpyRequest;

class SpyController extends Controller
{
   public function store(CreateSpyRequest $request) {
     return $request->validated();
   }
}

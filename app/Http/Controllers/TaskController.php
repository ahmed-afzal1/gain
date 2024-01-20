<?php

namespace App\Http\Controllers;

use App\Http\Requests\TaskRequest;
use App\Repositories\TaskRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

class TaskController extends Controller
{
    public $repository;
    public function __construct(TaskRepository $repository)
    {
        $this->repository = $repository;
    }

    public function index()
    {
        return view('welcome');
    }

    public function segmentCheck(TaskRequest $request)
    {
        $inputData = $request->all();
        return $this->repository->logicCheck($inputData);
    }
}

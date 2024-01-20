<?php

namespace App\Http\Controllers;

use App\Repositories\TaskRepository;
use Illuminate\Http\Request;

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
}

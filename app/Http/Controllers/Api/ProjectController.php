<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Project;
use App\Repositories\ProjectRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ProjectController extends Controller {
    protected $projectRepo;

    public function __construct()
    {
        $this->projectRepo = new ProjectRepository();
    }

    public function index(Request $request) {
        $filters = $request->only(['company_id', 'project_user']);

        $projects = Project::with(['company', 'projectUsers']);

        if (!empty($filters['company_id'])) {
            $projects = $projects->where('company_id', $filters['company_id']);
        }

        if (!empty($filters['project_user'])) {
            $userId = Auth::user()->id;
            $projects = $projects->whereHas('projectUsers', function ($query) use($userId) {
                $query->where('user_id', $userId);
            });
        }

        $projects = $projects->orderBy('id', 'desc')->get();
        return response()->json($projects);
    }

    public function store(Request $request) {
        return response()->json($this->projectRepo->store($request->all()));
    }

    public function delete($id = null) {
        return response()->json($this->projectRepo->delete($id));
    }

    public function detail($id = null) {
        return response()->json($this->projectRepo->detail($id));
    }

    public function assignUserToProject(Request $request) {
        return response()->json($this->projectRepo->assignUserToProject($request->all()));
    }

    public function unassign($id = null) {
        return response()->json($this->projectRepo->unassign($id));
    }
}
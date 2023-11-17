<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Project;
use App\Repositories\ProjectRepository;
use Illuminate\Http\Request;

class ProjectController extends Controller {
    protected $projectRepo;

    public function __construct()
    {
        $this->projectRepo = new ProjectRepository();
    }

    public function index(Request $request) {
        $filters = $request->only(['company_id']);

        $projects = Project::with(['company', 'projectUsers']);

        if (!empty($filters['company_id'])) {
            $projects = $projects->where('company_id', $filters['company_id']);
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
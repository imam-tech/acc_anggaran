<?php

namespace App\Repositories;

use App\Models\Company;
use App\Models\CompanyUser;
use App\Models\Project;
use App\Models\ProjectUser;
use App\Models\User;

class ProjectRepository {
    public function store($data) {
        try {
            $validator = \Validator::make($data, [
                "company_id" => "required",
                "title" => "required",
                "description" => "required",
            ]);

            if ($validator->fails()) return resultFunction("Err code PR-St: " . collect($validator->errors()->all())->implode(" , "));

            $company = Company::find($data['company_id']);
            if (!$company) return resultFunction("Err code PR-St: company not found for ID " . $data['company_id']);

            if ($data['id']) {
                $project = Project::find($data['id']);
                if (!$project) return resultFunction("Err code PR-St: project not found for ID " . $data['id']);
            } else {
                $project = new Project();
            }
            $project->company_id = $data['company_id'];
            $project->title = $data['title'];
            $project->description = $data['description'];
            $project->save();
            return resultFunction("Creating Project successfully", true, $project);
        } catch (\Exception $e) {
            return resultFunction("Err code PR-St: catch " . $e->getMessage());
        }
    }

    public function delete($id) {
        try {
            $project = Project::find($id);
            if (!$project) return resultFunction("Err code PR-Dl: project not found for ID " .$id);

            $project->delete();

            return resultFunction("Deleting Project successfully", true);
        } catch (\Exception $e) {
            return resultFunction("Err code PR-Dl: catch " . $e->getMessage());
        }
    }

    public function detail($id) {
        try {
            $project = Project::with(['company', 'projectUsers.user'])->find($id);
            if (!$project) return resultFunction("Err code PR-Dl: project not found for ID " .$id);
            return resultFunction("", true, $project);
        } catch (\Exception $e) {
            return resultFunction("Err code PR-Dl: catch " . $e->getMessage());
        }
    }
    public function assignUserToProject($data) {
        try {
            $validator = \Validator::make($data, [
                "user_id" => "required",
                "project_id" => "required",
            ]);

            if ($validator->fails()) return resultFunction("Err code PR-St: " . collect($validator->errors()->all())->implode(" , "));

            $project = Project::with(['company'])->find($data['project_id']);
            if (!$project) return resultFunction("Err code PR-St: company not found for ID " . $data['company_id']);

            $user = User::find($data['user_id']);
            if (!$user) return resultFunction("Err code PR-St: user not found for ID " . $data['user_id']);

            $projectUserHistory = ProjectUser::where('project_id', $data['project_id'])->where('user_id', $data['user_id'])
                ->first();
            if ($projectUserHistory) return resultFunction("Err code PR-St: the user is already assigning to project " . $project->title);

            $projectUser = new ProjectUser();
            $projectUser->project_id = $data['project_id'];
            $projectUser->user_id = $data['user_id'];
            $projectUser->save();

            return resultFunction("Assigning User to Project successfully", true, $projectUser);
        } catch (\Exception $e) {
            return resultFunction("Err code PR-St: catch " . $e->getMessage());
        }
    }

    public function unassign($id) {
        try {
            $projectUser = ProjectUser::find($id);
            if (!$projectUser) return resultFunction("Err code PR-Dl: project user not found for ID " .$id);

            $projectUser->delete();

            return resultFunction("Deleting user from project successfully", true);
        } catch (\Exception $e) {
            return resultFunction("Err code PR-Dl: catch " . $e->getMessage());
        }
    }
}
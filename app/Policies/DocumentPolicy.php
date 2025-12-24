<?php

namespace App\Policies;

use App\Models\Document;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;
use Illuminate\Auth\Access\Response;

class DocumentPolicy
{
    /**
     * Determine whether the user can view any models.
     */
    use HandlesAuthorization;
    public function viewAny(User $user): bool
    {
        return false;
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, Document $document): bool
    {
        return false;
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        return false;
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, Document $document): bool
    {
        return false;
    }

    /**
     * Determine whether the user can delete the model.
     */
    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, Document $document): bool
    {
        return false;
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, Document $document): bool
    {
        return false;
    }


    public function download(User $user, Document $document)
    {
        // 1. Manager mặc định có quyền
        if ($user->role === 'manager') {
            return true;
        }

        // 2. Chủ sở hữu file
        if ($user->id === $document->uploaded_by) {
            return true;
        }

        // 3. Nhân viên được giao Task liên quan
        if ($document->documentable_type === 'App\Models\Task') {
            $task = $document->documentable;
            if ($task && $user->employee && $task->employee_id === $user->employee->id) {
                return true;
            }
        }

        return false;
    }

    public function delete(User $user, Document $document)
    {
        // 1. Chủ sở hữu file
        if ($user->id === $document->uploaded_by) {
            return true;
        }

        // 2. Manager của Project chứa file đó
        $parent = $document->documentable;
        if ($document->documentable_type === 'App\Models\Project') {
            return $user->id === $parent->manager_id;
        }

        // Nếu file thuộc Task, Manager của Project đó cũng có quyền xóa
        if ($document->documentable_type === 'App\Models\Task') {
            return $user->id === $parent->project->manager_id;
        }

        return false;
    }
}

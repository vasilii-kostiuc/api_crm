<?php
/**
 * api_crm.loc - LeadCommentService.php
 *
 * Created by Admin
 * Created on: 23.01.2022 13:36
 */

namespace App\Modules\Admin\LeadComment\Services;

use App\Modules\Admin\Lead\Models\Lead;
use App\Modules\Admin\LeadComment\Models\LeadComment;
use App\Modules\Admin\Status\Models\Status;
use App\Modules\Admin\User\Models\User;

class LeadCommentService
{
    public static function saveComment(
        string $text,
        Lead $lead,
        User $user,
        Status $status,
        string $commentValue = null,
        bool $isEvent = true
    ) {
        $comment = new LeadComment([
                'text'          => $text,
                'comment_value' => $commentValue,
            ]
        );
        $comment->is_event = $isEvent;

        $comment
            ->lead()
            ->associate($lead)
            ->user()
            ->associate($user)
            ->status()
            ->associate($status)
            ->save();

        return $lead;
    }
}

<?php
/**
 * api_crm.loc - LeadService.php
 *
 * Created by Admin
 * Created on: 15.01.2022 12:18
 */

namespace App\Modules\Admin\Lead\Services;


use App\Modules\Admin\Lead\Models\Lead;
use App\Modules\Admin\LeadComment\Services\LeadCommentService;
use App\Modules\Admin\Status\Models\Status;
use App\Modules\Admin\Lead\Requests\LeadCreateRequest;
use Illuminate\Contracts\Auth\Authenticatable;

class LeadService
{

    public function getLeads()
    {
        $leads = (new Lead)->getLeads();
        $statuses = Status::all();

        $resultLeads = [];

        $statuses->each(function ($item, $key) use (&$resultLeads, $leads) {
            $collection = $leads->where('status_id', $item->id);
            $resultLeads[$item->title] = $collection->map(function ($element) {
                return $element;
            });
        });

        return $resultLeads;
    }

    public function store(LeadCreateRequest $request, Authenticatable $user)
    {
        $lead = new Lead();
        $lead->fill($request->only($lead->getFillable()));

        $status = Status::where('title', 'new')->first();

        $lead->status()->associate($status);

        $user->leads()->save($lead);

        $this->addStoreComments($lead, $request);

        return $lead;
    }

    private function addStoreComments($lead, $request, $user, $status)
    {
        $is_event = true;
        $tmpText = "Автор <strong>".$user->fullname.'</strong> создал лид со статусом '.$status->title_ru;
        LeadCommentService::saveComment($tmpText, $lead, $user, $status, null, $is_event);

        if($request->text) {
            $is_event = false;
            $tmpText = "Пользователь <strong>".$user->fullname.'</strong> оставил комментарий '.$request->text;
            LeadCommentService::saveComment($tmpText, $lead, $user, $status, $request->text, $is_event);
        }

    }
}

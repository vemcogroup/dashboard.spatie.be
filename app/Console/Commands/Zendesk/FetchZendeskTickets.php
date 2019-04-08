<?php

namespace App\Console\Commands\Zendesk;

use Illuminate\Console\Command;
use App\Events\Helpdesk\TicketsFetched;
use Zendesk\API\Exceptions\AuthException;
use Zendesk\API\HttpClient as ZendeskAPI;

class FetchZendeskTickets extends Command
{
    protected $signature = 'dashboard:fetch-zendesk-tickets';

    protected $description = 'Fetch Zendesk tickets';

    protected $agentTicketData;

    /** @var ZendeskAPI */
    protected $client;

    public function handle(): void
    {
        try {
            $this->client = new ZendeskAPI(env('ZENDESK_SUBDOMAIN'));
            $this->client->setAuth('basic', ['username' => env('ZENDESK_USERNAME'), 'token' => env('ZENDESK_TOKEN')]);
        } catch (AuthException $e) {
        }

        $dataArray = collect();
        $dataArray->put('unassigned', $this->client->search()->find('assignee:none+status<solved group:support group:notifications')->count);
        $tickets = $this->client->search()->find('status:open+status:pending group:support group:notifications');
        $dataArray->put('open', $tickets->count);
        $this->populateResult($tickets->results, 'openTickets');

        date('D') === 'Mon' ? $mon_time = 'Monday' : $mon_time = 'last Monday';
        $this->getSolvedTickets(date('Y-m-d', strtotime($mon_time)), date('Y-m-d'), 'solvedThisWeek');
        $this->getSolvedTickets(date('Y-m-d', strtotime($mon_time . ' -1 week')), date('Y-m-d', strtotime('last Sunday')), 'solvedLastWeek');

        $agentData = collect();
        foreach ($this->agentTicketData as $email => $data) {
            $agentData->put($data['name'], [
                'name' => $data['name'],
                'open' => $data['openTickets'] ?? 0,
                'solvedThisWeek' => $data['solvedThisWeek'] ?? 0,
                'solvedLastWeek' => $data['solvedLastWeek'] ?? 0,
            ]);
        }

        $dataArray->put(
            'agents',
            $agentData
            ->sortBy('name')
            ->filter(function ($agent) {
                return $agent['open'] || $agent['solvedThisWeek'] || $agent['solvedLastWeek'];
            })
        );

        event(new TicketsFetched($dataArray->all()));
    }

    protected function getSolvedTickets($from, $to, $key, $page = 1): void
    {
        $tickets = $this->client->search()->find('solved>=' . $from . '+solved<=' . $to, ['page' => $page]);
        if ($tickets && $tickets->next_page) {
            $this->getSolvedTickets($from, $to, $key, $page + 1);
        }
        $this->populateResult($tickets->results, $key);
    }

    protected function populateResult($results, $type): void
    {
        $origType = $type;
        foreach ($results as $ticket) {
            $type = $origType;
            $agent = $this->getAgentById($ticket->assignee_id);

            if (!$agent) {
                continue;
            }

            if (!isset($this->agentTicketData[$agent->user->email])) {
                $this->agentTicketData[$agent->user->email] = [
                    'name' => $agent->user->name,
                    'photo' => isset($agent->user->photo) ? $agent->user->photo->content_url : '',
                ];
            }

            // split solved tickets into support/orders/other
            if ($ticket->via->channel === 'email' && in_array($type, ['solvedThisWeek', 'solvedLastWeek'])) {
                switch ($ticket->via->source->from->address) {
                    case 'new_sensor@vemcount.com':
                        $type = 'newSensor';
                        break;

                    case 'reports@mycountinfo.com':
                        $type = 'other';
                        break;

                    case 'order@ecco.vemcount.com':
                    case 'order@vemcount.com':
                        $type = 'order';
                        break;
                }
            }

            if (!isset($this->agentTicketData[$agent->user->email][$type])) {
                $this->agentTicketData[$agent->user->email][$type] = 0;
            }


            $this->agentTicketData[$agent->user->email][$type]++;
        }
    }

    protected function getAgentById($agentId)
    {
        $key = 'agent-' . $agentId;
        if (!($userInfo = cache($key, false))) {
            try {
                $userInfo = $this->client->users()->find($agentId);
            } catch (\Exception $e) {
            }
            cache([$key => $userInfo], 60);
        }

        return $userInfo;
    }
}

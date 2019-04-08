<template>
    <tile :position="position" modifiers="overflow">
        <section>
            <h1>Helpdesk tickets (<span class="gold">{{ tickets.open }}</span> / <span class="text-red">{{ tickets.unassigned }}</span>)</h1>

            <table class="w-full text-lg">
                <tr>
                    <th class="py-3 text-left">Name</th>
                    <th class="text-right w-16">Open</th>
                    <th class="text-right w-16">TW</th>
                    <th class="text-right w-16">LW</th>
                </tr>
                <tr class="border-b-2 border-grey-darker" v-for="ticket in tickets.agents">
                    <td class="py-2">{{ ticket.name }}</td>
                    <td class="text-right gold">{{ ticket.open }}</td>
                    <td class="text-right gold">{{ ticket.solvedThisWeek }}</td>
                    <td class="text-right gold">{{ ticket.solvedLastWeek }}</td>
                </tr>
            </table>
        </section>
    </tile>
</template>

<script>
import echo from '../../mixins/echo';
import Tile from '../atoms/Tile';
import saveState from 'vue-save-state';

export default {
    components: {
        Tile,
    },

    mixins: [echo, saveState],

    props: ['position'],

    data() {
        return {
            tickets: [],
        };
    },

    methods: {
        getEventHandlers() {
            return {
                'Helpdesk.TicketsFetched': response => {
                    this.tickets = response.tickets ? response.tickets : [];
                },
            };
        },
        getSaveStateConfig() {
            return {
                cacheKey: `helpdesk-tickets`,
            };
        },
    },
};
</script>

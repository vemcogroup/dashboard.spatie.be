<template>
    <tile :position="position" modifiers="overflow">
        <section>
            <h1>Helpdesk tickets (<span class="text-red">{{ tickets.unassigned }}</span>)</h1>

            <table class="w-full text-lg">
                <thead>
                    <tr>
                        <th class="py-3 text-left">Name</th>
                        <th class="text-right w-16">Open</th>
                        <th class="text-right w-16">TW</th>
                        <th class="text-right w-16">LW</th>
                    </tr>
                </thead>
                <tbody>
                    <tr class="border-b-2 border-grey-darker" v-for="ticket in tickets.agents">
                        <td class="py-2">{{ ticket.name }}</td>
                        <td class="text-right gold">{{ ticket.open }}</td>
                        <td class="text-right gold">{{ ticket.solvedThisWeek }}</td>
                        <td class="text-right gold">{{ ticket.solvedLastWeek }}</td>
                    </tr>
                </tbody>
                <tfoot>
                  <tr class="border-b-2 border-grey-darker">
                      <td class="py-3"></td>
                      <td class="py-3 text-right gold text-xl">{{ totals }}</td>
                      <td class="text-right gold text-xl">{{ totalsThisWeek }}</td>
                      <td class="text-right gold text-xl">{{ totalsLastWeek }}</td>
                  </tr>
                </tfoot>
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
    computed: {
        totals() {
            return Object.values(this.tickets.agents).reduce((total, ticket) => total + parseInt(ticket.open), 0)
        },
        totalsThisWeek() {
            return Object.values(this.tickets.agents).reduce((total, ticket) => total + parseInt(ticket.solvedThisWeek), 0)
        },
        totalsLastWeek() {
            return Object.values(this.tickets.agents).reduce((total, ticket) => total + parseInt(ticket.solvedLastWeek), 0)
        },
    }
};
</script>

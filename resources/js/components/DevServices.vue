<template>
    <tile :position="position" modifiers="overflow" class="z-10" :style="styles" no-fade>
        <section v-if="down.length">
            <h1 class="text-red">Services ({{ count }})</h1>

            <table class="w-full text-lg border-b-2 border-grey-darker">
                <template v-for="service in down">
                    <tr class="border-t-2 py-3 border-grey-darker">
                        <td class="text-red py-2">{{ service.label }}</td>
                        <td class="text-right gold"><i class="service-down">{{ service.value }}</i></td>
                    </tr>
                    <tr v-if="service.description">
                        <td colspan="2" class="gold text-xs pb-2">{{ service.description }}</td>
                    </tr>
                </template>
            </table>

        </section>
    </tile>
</template>

<script>
    import twemoji from 'twemoji';
    import Tile from './atoms/Tile';
    import echo from '../mixins/echo';
    import saveState from 'vue-save-state';

    export default {
        components: {
            Tile,
        },

        mixins: [echo, saveState],

        props: ['position'],

        data() {
            return {
                services: [],
            };
        },

        methods: {
            getEventHandlers() {
                return {
                    'Services.DevServices': response => {
                        this.services = response.services ? response.services : [];
                    },
                };
            },
            getSaveStateConfig() {
                return {
                    cacheKey: `services-dev-services`,
                };
            },
            icon(text) {
                return twemoji.parse(text);
            }
        },
        computed: {
            styles() {
                return {
                '--bg-tile': this.down.length ? 'inherit' : 'transparent'
                }
            },
            count() {
                return this.services.length;
            },
            down() {
                return this.services.filter((service) => {
                    return !service.status;
                })
            },
            up() {
                return this.services.filter((service) => {
                    return service.status;
                })
            }
        }
    };
</script>

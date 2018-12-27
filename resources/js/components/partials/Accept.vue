<template>
    <div>
        <a v-if="authorize('accept', answer)"
            title="Mark this answer as best answer"
            :class="classes"
            @click.prevent="create"
        >
            <i class="fas fa-check fa-2x"></i>
        </a>
        <a v-if="accepted"
                title="The question owner accepted this answer as best answer"
                :class="classes"
        >
            <i class="fas fa-check fa-2x"></i>
        </a>
    </div>
</template>

<script>
    import eventBus from '../event-bus';

    export default {
        name: "Accept",
        props: ['answer'],
        data() {
          return {
                isBest: this.answer.is_best,
                id: this.answer.id
            }
        },

        created() {
          eventBus.$on('accepted', id => {
              this.isBest = id === this.id;
          })
        },

        computed: {
            canAccept() {
                return true;
            },
            accepted() {
                return !this.canAccept && this.isBest;
            },
            classes() {
                return [
                    'mt-2',
                    'answer-accepted-' + this.id,
                    this.isBest ? 'votes-accepted' : ''
                ];
            }
        },

        methods: {
            create() {
                axios.post(`/answers/${this.id}/accept`)
                    .then(response => {
                        this.$toast.success(response.data.message, 'Success', {
                            timeout: 3000,
                            position: 'topRight'
                        });

                        this.isBest = true;
                        eventBus.$emit('accepted', this.id);
                    });
            }
        },
    }
</script>

<style scoped>

</style>
<template>
    <a
        title="Click to mark as favorite (Click again to undo)"
        :class="classes"
        @click.prevent="toggle"
    >
        <i class="fas fa-star fa-2x"></i>
        <span class="favorites-count">{{ count }}</span>
    </a>

</template>

<script>
    export default {
        name: "favorite",
        props: ['question'],

        data() {
            return {
                id: this.question.id,
                isFavorite: this.question.is_favorited,
                count: this.question.favorites_count
            }
        },

        computed: {
            classes() {
                return [
                    'favorite',
                    'mt-2',
                    !this.signedIn ? 'off' : (this.isFavorite ? 'favorited' : '')
                ];
            },
            endPoint() {
                return `/questions/${this.id}/favorite`
            },
            signedIn() {
                return window.Auth.signedIn;
            }
        },

        methods: {
            toggle() {
                if ( !this.signedIn) {
                    this.$toast.warning('Please, login first', 'warning', {
                        timeout: 3000,
                        position: 'topLeft'
                    });
                    return;
                }
                this.isFavorite ? this.destroy() : this.create();
            },

            create() {
                axios.post(`/questions/${this.id}/favorite`)
                .then(response => {
                    this.isFavorite = true;
                    this.count++;
                });
            },

            destroy () {
                axios.delete(`/questions/${this.id}/favorite`)
                    .then(response => {
                        this.isFavorite = false;
                        this.count--;
                    });
            }
        }
    }
</script>

<style scoped>

</style>

<template>
    <div>
        <a
           :title="title('up')"
           @click.prevent="voteUp"
           class="vote-up" :class="classes"
        >
            <i class="fas fa-caret-up fa-3x"></i>
        </a>

        <span class="votes-count">{{ count }}</span>

        <a
           :title="title('down')"
           @click.prevent="voteDown"
           class="vote-down" :class="classes"
        >
            <i class="fas fa-caret-down fa-3x"></i>
        </a>
    </div>
</template>

<script>
    export default {
        name: "Vote",
        props: ['name', 'model'],

        data() {
            return {
                count: this.model.votes_count || 0,
                id: this.model.id
            };
        },

        computed: {
            classes() {
                return this.signedIn ? '' : 'off';
            }
        },

        methods: {
            title(voteType) {
                let titles = {
                    up: `This ${this.name} is useful?`,
                    down: `This ${this.name} is not useful?`
                };

                return titles[voteType];
            },

            voteUp() {
                this._vote(1);
            },

            voteDown() {
                this._vote(-1);
            },

            _vote(vote) {

                if (! this.signedIn) {
                    this.$toast.warning(`Please login to vote the ${this.name}`, "Warning", {
                        timeout: 3000,
                        position: 'topLeft'
                    });

                    return;
                }

                axios.post(`/${this.name}s/${this.id}/vote`, { vote })
                    .then(response => {
                        this.$toast.success(response.data.message, "Success", {
                            timeout: 3000,
                            position: 'topLeft'
                        });
                        this.count = response.data.votesCount;
                    });
            }
        }
    }
</script>

<style scoped>

</style>
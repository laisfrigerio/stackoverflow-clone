<template>
    <div class="media post">
        <div class="d-flex flex-column vote-controls">
            <vote :model="answer" name="answer"></vote>
            <accept :answer="answer"></accept>
        </div>
        <div class="media-body">
            <form v-if="editing" @submit.prevent="update">
                <div class="form-group">
                    <textarea rows="10" v-model="body" class="form-control" required></textarea>
                </div>
                <button @click="edit" :disabled="isInvalid" class="btn btn-primary">Update</button>
                <button @click="cancel" class="btn btn-danger" type="button">Cancel</button>
            </form>
            <div v-else>
                <div v-html="bodyHtml"></div>
                <div class="row">
                    <div class="col-4">
                        <div class="ml-auto">
                            <a
                                v-if="authorize('modify', answer)"
                                @click.prevent="edit"
                                class="btn btn-sm btn-primary"
                            >
                                Edit
                            </a>
                            <button
                                v-if="authorize('modify', answer)"
                                @click="destroy"
                                class="btn btn-sm btn-outline-danger"
                            >
                                Delete
                            </button>
                        </div>
                    </div>
                    <div class="col-4"></div>
                    <div class="col-4">
                        <avatar label='Answered' :model="answer"></avatar>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        name: "Answer",
        props: ['answer'],

        data() {
            return {
                editing: false,
                body: this.answer.body,
                bodyHtml: this.answer.body_html,
                id: this.answer.id,
                questionID: this.answer.question_id,
                beforeEditCache: null
            }
        },

        methods: {
            edit() {
                this.editing = true;
                this.beforeEditCache = this.body
            },

            cancel() {
                this.editing = false;
                this.body =  this.beforeEditCache;
            },

            update() {
                axios.patch(`/questions/${this.questionID}/answers/${this.id}`, {
                    body: this.body
                })
                .then(response => {
                    this.editing = false;
                    this.bodyHtml = response.data.body_html;
                    this.$toast.success(response.data.message, "Success", { timeout: 3000, position: 'topRight'});
                })
                .catch(error => {
                    this.$toast.error(error.response.data.message, "Error", { timeout: 3000, position: 'topRight'});
                });
            },

            destroy() {
                this.$toast.question('Are you sure about that?', "Confirm", {
                    timeout: 20000,
                    close: false,
                    overlay: true,
                    displayMode: 'once',
                    id: 'question',
                    zindex: 999,
                    title: 'Hey',
                    position: 'center',
                    buttons: [
                        ['<button><b>YES</b></button>', (instance, toast) => {

                            axios.delete(`/questions/${this.questionID}/answers/${this.id}`)
                                .then(response => {
                                    this.$emit('deleted')
                                });
                            instance.hide({ transitionOut: 'fadeOut' }, toast, 'button');
                        }, true],
                        ['<button>NO</button>', function (instance, toast) {
                            instance.hide({ transitionOut: 'fadeOut' }, toast, 'button');
                        }],
                    ]
                });
            }
        },

        computed: {
            isInvalid() {
                return this.body.length < 10;
            },
        }
    }
</script>

<style scoped>

</style>

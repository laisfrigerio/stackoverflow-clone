<template>
    
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
                                    $(this.$el).fadeOut(500, () => {
                                        this.$toast.success(response.data.message, "Sucess", { timeout: 3000 });
                                    })
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

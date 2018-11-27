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
                axios.patch(this.endPoint, {
                    body: this.body
                })
                .then(response => {
                    this.editing = false;
                    this.bodyHtml = response.data.body_html;
                    alert(response.data.message)
                })
                .catch(error => {
                    alert(error.response.data.message);
                });
            },

            destroy() {
                if (confirm('Are you sure?')) {
                    axios.delete(this.endPoint)
                    .then(response => {
                        $(this.$el).fadeOut(500, () => {
                            alert(response.data.message);
                        })
                    });
                }
            }
        },

        computed: {
            isInvalid() {
                return this.body.length < 10;
            },

            endPoint() {
                return `/questions/${this.questionID}/answers/${this.id}`
            }
        }
    }
</script>

<style scoped>

</style>

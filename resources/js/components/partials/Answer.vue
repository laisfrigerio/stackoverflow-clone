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
                questionID: this.answer.question_id
            }
        },

        methods: {
            update() {
                axios.patch(`/questions/${this.questionID}/answers/${this.id}`, {
                    body: this.body
                })
                .then(response => {
                    this.editing = false;
                    this.bodyHtml = response.data.body_html;
                    alert(response.data.message)
                })
                .catch(error => {
                    console.log('Something wnet wrong' + error);
                });
            }
        }
    }
</script>

<style scoped>

</style>

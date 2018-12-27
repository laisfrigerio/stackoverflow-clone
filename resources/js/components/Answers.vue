<template>
    <div class="row mt-4"  v-cloak v-if="count">
        <div class="col-md-12">
            <div class="card">
                <div class="card-body">
                    <div class="card-title">
                        <h2>{{ title }}</h2>
                    </div>
                    <hr>
                    <answer v-for="answer in answers" :answer="answer" :key="answer.id" :questionID="answer.questionID"></answer>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        name: "Answers",
        props: ['answers', 'count'],
        computed: {
            title() {
                return this.count + " " + (this.count > 0 ? 'Answers' : 'Answer')
            }
        }
    }
</script>

<style scoped>

</style>
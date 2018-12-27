<template>
    <div class="row mt-4"  v-cloak v-if="count">
        <div class="col-md-12">
            <div class="card">
                <div class="card-body">
                    <div class="card-title">
                        <h2>{{ title }}</h2>
                    </div>
                    <hr>
                    <answer @deleted="remove(index)" v-for="(answer, index) in answers" :answer="answer" :key="answer.id" :questionID="answer.questionID"></answer>
                    <div class="text-center mt-3" v-if="nextUrl">
                        <button @click.prevent="fetch(nextUrl)" class="btn btn-outline-secondary">Load more answers</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        name: "Answers",
        props: ['question'],

        data() {
            return {
                questionId: this.question.id,
                count: this.question.answers_count,
                answers: [],
                nextUrl: null,
            }
        },

        computed: {
            title() {
                return this.count + " " + (this.count > 0 ? 'Answers' : 'Answer')
            }
        },

        methods: {
          remove(index) {
              this.count =  this.count - 1;
              this.answers.splice(index, 1);
          },

          fetch(endPoint) {
              axios.get(endPoint)
                  .then(response => {
                      this.answers.push(...response.data.data);
                      this.nextUrl = response.data.next_page_url;
                  });
          },
        },

        created() {
          this.fetch(`/questions/${this.questionId}/answers`);
        },
    }
</script>

<style scoped>

</style>
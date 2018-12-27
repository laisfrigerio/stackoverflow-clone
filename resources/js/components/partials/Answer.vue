<template>
    <div class="media post">
        <div class="d-flex flex-column vote-controls">
            <vote :model="answer" name="answer"></vote>
            <accept :answer="answer"></accept>
        </div>
        <div class="media-body">
            <form v-if="editing" @submit.prevent="update">
                <div class="form-group">
                    <textarea
                        rows="10"
                        v-model="body"
                        class="form-control"
                        required
                    ></textarea>
                </div>
                <button
                    @click="edit"
                    :disabled="isInvalid"
                    class="btn btn-primary"
                >Update</button>
                <button
                    @click="cancel"
                    class="btn btn-danger"
                    type="button"
                >Cancel</button>
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
                            >Edit</a>
                            <button
                                v-if="authorize('modify', answer)"
                                @click="destroy"
                                class="btn btn-sm btn-outline-danger"
                            >Delete</button>
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
import mixins from '../../mixins/mixins';

export default {
    name: "Answer",

    props: ['answer'],

    mixins: [mixins],

    data() {
        return {
            body: this.answer.body,
            bodyHtml: this.answer.body_html,
            id: this.answer.id,
            questionID: this.answer.question_id,
            beforeEditCache: null
        }
    },

    computed: {
        isInvalid() {
            return this.body.length < 10;
        },
        endPoint() {
            return `/questions/${this.questionID}/answers/${this.id}`;
        },
    },

    methods: {
        setEditCache() {
            this.beforeEditCache = this.body
        },

        restoreFromCache() {
            this.body =  this.beforeEditCache;
        },

        payload() {
            return {
                body: this.body
            }
        },

        delete() {
            axios.delete(this.endPoint)
            .then(({data}) => {
                this.$toast.success(data.message, "Success", { timeout: 2000 });
                this.$emit('deleted');
            });
        }
    },
}
</script>
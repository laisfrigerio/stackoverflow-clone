<template>
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <form class="card-body" v-if="editing" @submit.prevent="update">
                    <div class="card-title">
                        <input required v-model="title" type="text" class="form-control form-control-lg">
                    </div>
                    <hr>
                    <div class="media">
                        <div class="media-body">
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
                        </div>
                    </div>
                </form>
                <div class="card-body" v-else>
                    <div class="card-title">
                        <div class="d-flex align-items-center">
                            <h1>{{ title }}</h1>
                            <div class="ml-auto">
                                <a href="/questions" class="btn btn-outline-secondary">Back to all questions</a>
                            </div>
                        </div>
                    </div>

                    <hr>

                    <div class="media">
                        <div class="d-flex flex-column vote-controls">
                            <vote :model="question" name="question"></vote>
                            <favorite :question="question"></favorite>
                        </div>

                        <div class="media-body">
                            <div v-html="bodyHtml"></div>
                            <div class="row">
                                <div class="col-md-4">
                                    <div class="ml-auto">
                                        <a
                                            v-if="authorize('modify', question)"
                                            @click.prevent="edit"
                                            class="btn btn-sm btn-primary"
                                        >Edit</a>
                                        <button v-if="authorize('deleteQuestion', question)" @click="destroy" class="btn btn-sm btn-outline-danger">Delete</button>
                                    </div>
                                </div>
                                <div class="col-md-4"></div>
                                <div class="col-md-4">
                                    <avatar label='Asked' :model="question"></avatar>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import mixins from '../mixins/mixins';
export default {
    name: "Question",
    props: ['question'],

    mixins: [
        mixins
    ],

    data() {
        return {
            id: this.question.id,
            title: this.question.title,
            body: this.question.body,
            bodyHtml: this.question.body_html,
            beforeEditCache: {},
        }
    },

    computed: {
        isInvalid() {
            return this.body.length < 10 || this.title.length < 10
        },
        endPoint() {
            return `/questions/${this.id}`;
        },
    },

    methods: {
        setEditCache() {
            this.beforeEditCache = {
                body: this.body,
                title: this.title
            };
        },

        restoreFromCache() {
            this.body = this.beforeEditCache.body;
            this.title = this.beforeEditCache.title;
        },

        payload() {
            return {
                body: this.body,
                title: this.title
            }
        },

        delete() {
            axios.delete(this.endPoint)
                .then(({data}) => {
                    this.$toast.success(data.message, "Success", { timeout: 2000 });
                });
            setTimeout(() => {
                window.location.href = "/questions";
            }, 3000);
        },
    }
}
</script>
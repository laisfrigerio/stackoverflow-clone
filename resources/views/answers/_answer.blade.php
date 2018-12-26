<answer :answer="{{ $answer }}" inline-template>
    <div class="media post">
        <div class="d-flex flex-column vote-controls">
            <vote :model="{{ $answer }}" name="answer"></vote>
            <accept :answer="{{ $answer }}"></accept>
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
                {{--{!! $answer->body_html !!}--}}
                <div v-html="bodyHtml"></div>
                <div class="row">
                    <div class="col-4">
                        <div class="ml-auto">
                            @can('update', $answer)
                                <a
                                    {{--                                href="{{ route('questions.answers.edit', [$question->id, $answer->id]) }}" --}}
                                    @click.prevent="edit"
                                    class="btn btn-sm btn-primary"
                                >
                                    Edit
                                </a>
                            @endcan
                            @can('delete', $answer)
                                    <button @click="destroy" class="btn btn-sm btn-outline-danger">Delete</button>
                                </form>
                            @endcan
                        </div>
                    </div>
                    <div class="col-4"></div>
                    <div class="col-4">
                        <avatar label='Answered' :model="{{ $answer  }}"></avatar>
                    </div>
                </div>
            </div>
        </div>
    </div>
</answer>


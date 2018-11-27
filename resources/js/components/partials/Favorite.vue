<template>
    <a
        title="Click to mark as favorite {{ $name }} (Click again to undo)"
        class="favorite mt-2 {{ Auth::guest() ? 'off' : ($model->isFavorited() ? 'favorited' : '') }}"
        onclick="event.preventDefault(); document.getElementById('favorite-{{ $name }}-{{ $model->id }}').submit()"
    >
        <i class="fas fa-star fa-2x"></i>
        <span class="favorites-count">{{ $model->favorites_count }}</span>
    </a>

</template>

<script>
    export default {
        name: "favorite",
        props: ['question'],

        data() {
            return {
                isFavorite: this.question.is_favorited,
                count: this.question.favorites_count,
                signedIn: true
            }
        },

        computed: {
            classes() {
                return [

                ];
            }
        }
    }
</script>

<style scoped>

</style>

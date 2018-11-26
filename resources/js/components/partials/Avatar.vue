<template>
    <div class="float-right">
        <span class="text-muted">{{ postDate }}</span>
        <div class="media mt-2">
            <a  :href="user.url" class="pr-2">
                <img :src="user.avatar">
            </a>
            <div class="media-body mt-1">
                <a :href="user.url">{{ user.name }}</a>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        name: "Avatar",
        props: ['model', 'label'],
        data() {
            return {
                user: this.model.user
            }
        },
        computed: {
            postDate() {
                return this.label + ' ' + this.model.created_date
            }
        }
    }
</script>

<style scoped>

</style>

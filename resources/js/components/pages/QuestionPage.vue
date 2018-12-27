<template>
    <div class="container">
        <question :question="question"></question>
        <answers :question="question"></answers>
    </div>
</template>

<script>
    export default {
        name: "QuestionPage",
        props: ['question']
    }
</script>

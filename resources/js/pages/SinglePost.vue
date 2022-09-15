<template>
    <div class="container">
        <div v-if="post">
            <h1>{{ post.title }}</h1>

            <div v-if="post.tags.legth > 0">
                <span v-for="tag in post.tags" :key="tag.id" class="badge bg-info text-light">{{ tag.name }}</span>
            </div>
            
            <p v-if="post.category">Categoria: {{ post.category.name}}</p>

            <p>{{ post.content }}</p>
        </div>
    </div>
</template>

<script>
export default {
    name: 'SinglePost',
    data() {
        return {
            post: null
        };
    },
    mounted() {
        axios.get('/api/posts/' + this.$route.params.slug)
        .then((response)=> {
            this.post = response.data.results;
        });
    }
}
</script>


<template>

<section>
    <div class="container">
        <h1> Lista dei post </h1>

        <div class="row row-cols-3">
            <!--Single post-->
            <div v-for="post in posts" :key="post.id" class="col">
                <div class="card mt-4">
                    <!--<img src="..." class="card-img-top" alt="...">-->
                    <div class="card-body">
                        <h5 class="card-title">{{ post.title }}</h5>
                        <p class="card-text">{{ truncateText(post.content) }}</p>
                        <a href="#" class="btn btn-primary">Go somewhere</a>
                    </div>
                </div>
            </div>
        </div>

        <div class="mt-5">
            <!--Nav bar scrolling pages-->
            <nav aria-label="Page navigation example">
                <ul class="pagination">
                    <!--Previous-->
                    <li class="page-item">
                        <a @click.prevent="getPosts(paginationCurrentPage - 1)" class="page-link" href="#">Previous</a>
                    </li>

                    <li class="page-item"><a class="page-link" href="#">1</a></li>
                    <li class="page-item"><a class="page-link" href="#">2</a></li>
                    <li class="page-item"><a class="page-link" href="#">3</a></li>

                    <!--Next-->
                    <li class="page-item">
                        <a @click.prevent="getPosts(paginationCurrentPage + 1)" class="page-link" href="#">Next</a>
                    </li>
                </ul>
            </nav>
        </div>
    </div>
</section>

</template>

<script>
export default {
    name : 'Posts',
    data() {
        return {
            posts: [],
            paginationCurrentPage: 1
        };
    },
    methods: {
        truncateText(text) {
  
            return text.length > 100 ? text.slice(0, 100) + '...' : text;
        },
        getPosts(pageNumber) {
            axios.get('/api/posts', {
                params: {
                    page: pageNumber
                }
            })
            .then((response) => {
                this.posts = response.data.results.data;
                this.paginationCurrentPage = response.data.results.current_page;
            });
        }
    },
    mounted() {
        this.getPosts(1);
    }
}
</script>

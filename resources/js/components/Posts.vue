<template>

<section>
    <div class="container">
        <h1> Lista dei post </h1>

        <div class="row row-cols-3">
            <!--Single post-->
            <div class="col">
                <div class="card mt-5">
                    <!--<img src="..." class="card-img-top" alt="...">-->
                    <div class="card-body">
                        <h5 class="card-title">Card title</h5>
                        <p class="card-text">Some quick example text to build on the card title and make up the bulk of the card's content.</p>
                        <a href="#" class="btn btn-primary">Go somewhere</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

</template>

<script>
export default {
    name : 'Posts'
}
</script>

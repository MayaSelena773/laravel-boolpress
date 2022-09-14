<template>
<div>
    <MainHeader />

    <main>
        <router-view></router-view>
    </main>
</div>
</template>

<script>
import MainHeader from '../components/MainHeader';

export default {
    name : 'app',
    components : {
        MainHeader
    }
}
</script>

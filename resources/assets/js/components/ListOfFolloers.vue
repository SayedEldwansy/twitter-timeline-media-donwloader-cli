<template>
    <ul class="list-group">
        <li class="list-group-item" v-for="item in items">{{item}}</li>
    </ul>
</template>
<script>
    export default {
        data() {
            return {
                items: [1, 2, 22, 2, 2, 2, 2, 234, 234, 234, 23, 423, 4, 23, 4],
                foo: 'ttt',
                following : []
            }
        },
        created() {
            axios.get('api/following').then(response => this.following = response.data);
            console.log(this.following);
        },
        computed: {
            authenticatedUser() {
                console.log( this.$auth.getAuthenticatedUser());
                return this.$auth.getAuthenticatedUser()
            }
        }
    }

</script>
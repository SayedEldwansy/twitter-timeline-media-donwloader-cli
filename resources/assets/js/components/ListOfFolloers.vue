<template>
    <!--<div>You are Following : {{following.length}}</div>-->
    <div class="row">
        <div class="col-md-3 padding" v-for="user in following_data">
            <div class="card">
                <img class="card-img-top" v-bind:src="user['profile_image_url_https']">
                <div class="card-body">
                    <h5 class="card-title">{{user['name']}}</h5>
                    <p class="card-text">{{user['screen_name']}}</p>
                </div>
                <ul class="list-group list-group-flush">
                    <li class="list-group-item">Bio: {{user['description']}}</li>
                    <li class="list-group-item">Dapibus ac facilisis in</li>
                    <li class="list-group-item">Vestibulum at eros</li>
                </ul>
                <div class="card-body">
                    <a href="#" class="card-link">Twitter</a>
                    <a href="#" class="card-link">Another link</a>
                </div>
            </div>
        </div>
    </div>
</template>
<script>
    export default {
        data() {
            return {
                following: [],
                following_data :[]
            }
        },
        methods: {
            getUserData(nex_cur = null) {
                axios.get('api/following', {params: {'next_cursor': nex_cur}}).then(response => {
                    var that = this;
                    response.data['ids'].map(function (item) {
                        that.following.push(item);
                    });
                    console.log(response.data);
                    if (response.data['next_cursor']) {
                        console.log(response.data['next_cursor']);
                        setTimeout(this.getUserData(response.data['next_cursor']),2000)
                    }
                });
                this.getUserInformation();
            },
            getUserInformation(){

            }
        },
        created() {
            this.getUserData()
        },
    }

</script>
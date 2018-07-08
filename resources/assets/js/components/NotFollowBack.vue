<template>
    <div class="row justify-content-center">
        <div class="col-md-10">
            <div class="card">
                <div class="card-header">Who is not follow you back is : <em
                        class="badge badge-primary">{{list_count}}</em> people
                </div>
                <div class="card-body">
                    <h3 v-if="list_count == 0 ">
                        This list will be ready soon <i class="fa fa-circle-o-notch fa-spin fa-2x"></i>
                    </h3>
                    <div class="row">
                        <div v-for="user in users_list" class="card mb-3 mr-1"
                             style="width: 18rem;height: 20rem" v-bind:id="user['screen_name']">
                            <div class="card-header">
                                <a target="_blank" v-bind:href="'https://twitter.com/'+user['screen_name']">@{{user['screen_name']}} </a>
                                <button @click="unfollow(user['screen_name'],user['id'])"
                                        class="btn btn-sm btn-danger float-right">Unfollow
                                </button>
                            </div>
                            <div class="card-body">
                                <h5 class="card-title">
                                    <img class="img-thumbnail img-circle" v-bind:src="user['profile_image_url_https']">
                                    {{user['name']}}
                                </h5>
                                <p class="card-text">
                                    Bio: {{user['description']}} <br>
                                    <span v-if="user['location']">Location : {{user['location']}} <br> </span>
                                    Followers : {{user['followers_count']}} <br>
                                    Following : {{user['friends_count']}} <br>
                                </p>
                            </div>
                        </div>
                    </div>
                    <div v-if="list_count > 0" class="row justify-content-center">
                        <button @click="loadmore()" class="btn btn-primary ">Load more</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        data() {
            return {
                page: 0,
                list_count: 0,
                users_list: []
            }
        },
        methods: {
            getUserData() {
                axios.get('api/not-follow-list', {params: {'page': this.page}}).then(response => {
                    this.list_count = response.data['list_count'];
                    var that = this;
                    response.data['list_data'].map(function (item) {
                        that.users_list.push(item);
                    });
                    if (this.page < 1){
                        this.users_list.sort(function (a, b) {
                            return a['followers_count'] - b['followers_count'];
                        });
                    }
                    console.log(response.data);
                });
            },
            unfollow(screen_name, id) {
                console.log(screen_name, id);
                axios.post('api/un-follow', {screen_name: screen_name, id: id}).then(response => {
                    if (response) {
                        $('#' + screen_name).hide();
                        this.list_count = this.list_count - 1
                    }
                });
            },
            loadmore() {
                this.page++;
                this.getUserData();
            }
        },
        created() {
            this.getUserData()
        },
    }

</script>
